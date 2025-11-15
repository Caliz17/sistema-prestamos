<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Client\ConnectionException;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use App\Models\User;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación interna
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed'],
        ]);

        try {
            // Enviar registro a la API
            $response = Http::timeout(5)
                ->acceptJson()
                ->post(env('API_URL') . '/register', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                ]);

        } catch (\Exception $e) {
            return back()
                ->withErrors(['server' => 'No se pudo conectar con el servidor.'])
                ->withInput();
        }

        // Manejo de errores de la API
        if ($response->failed()) {

            $error = $response->json('message') ?? 'Error desconocido';

            // Traducir mensajes comunes
            if (str_contains($error, 'The email has already been taken')) {
                $error = 'El correo electrónico ya está registrado.';
            }

            return back()
                ->withErrors(['email' => $error])
                ->withInput();
        }

        // Si llegó aquí, se registró correctamente
        return redirect()->route('login')
            ->with('success', 'Tu cuenta ha sido creada. Ahora puedes iniciar sesión.');
    }

}
