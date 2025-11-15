<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Client\ConnectionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {

            // Llamada con timeout y manejo automático de errores
            $response = Http::timeout(5)
                ->acceptJson()
                ->post(env('API_URL') . '/login', [
                    'email' => $request->email,
                    'password' => $request->password,
                ]);

        } catch (ConnectionException $e) {

            return back()
                ->withErrors([
                    'server' => 'Error del servidor, por favor intenta más tarde.'
                ])
                ->withInput();
        }

        // Si la API responde 401 o no manda token
        if ($response->status() === 401 || !$response->json('access_token')) {
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas'])
                ->withInput();
        }

        // Token ok
        $token = $response->json('access_token');
        session(['api_token' => $token]);

        // Obtener info del usuario
        $userResponse = Http::withToken($token)->get(env('API_URL') . '/me');

        if ($userResponse->failed()) {
            return back()->withErrors([
                'server' => 'Error del servidor: No se pudo obtener información del usuario.'
            ]);
        }

        $apiUser = $userResponse->json();
        session(['user' => $apiUser]);

        // Buscar usuario local
        $localUser = \App\Models\User::where('email', $apiUser['email'])->first();

        if (!$localUser) {
            return back()->withErrors([
                'email' => 'El usuario existe en la API pero no en el sistema local.'
            ]);
        }

        Auth::login($localUser);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Eliminar token API
        session()->forget(['api_token', 'user']);

        return redirect('/');
    }
}
