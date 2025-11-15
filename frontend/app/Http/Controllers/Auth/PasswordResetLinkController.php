<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    # REVISAR PORQUE NO ESTA ALMACENANDO BIEN LOS NUEVA SCONTRACENIAS
    public function store(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        try {
            $response = Http::withHeaders([
                    'Accept' => 'application/json',
                ])
                ->post(env('API_URL') . '/forgot-password', [
                    'email' => $request->email,
                ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'server' => 'No se pudo conectar con el servidor, intenta más tarde.'
            ]);
        }

        if ($response->failed()) {
            return back()->withErrors([
                'email' => $response->json('message') ?? 'No se pudo enviar el correo.'
            ]);
        }

        return back()->with('status', 'Se envió un enlace a tu correo.');
    }
}
