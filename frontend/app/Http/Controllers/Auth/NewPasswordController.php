<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $response = Http::withHeaders([
                    'Accept' => 'application/json',
                ])
                ->post(env('API_URL') . '/reset-password', [
                    'token' => $request->token,
                    'email' => $request->email,
                    'password' => $request->password,
                    'password_confirmation' => $request->password_confirmation,
                ]);

            if ($response->successful()) {
                return redirect()->route('login')
                    ->with('status', 'Contraseña restablecida correctamente.');
            }

            // Manejar diferentes tipos de errores
            $errorData = $response->json();
            
            if ($response->status() === 422) {
                // Error de validación
                $errorMessage = $errorData['message'] ?? 'Datos inválidos.';
                if (isset($errorData['errors']['email'])) {
                    $errorMessage = $errorData['errors']['email'][0];
                }
            } else if ($response->status() === 400) {
                // Token inválido o expirado
                $errorMessage = $errorData['message'] ?? 'Token inválido o expirado.';
            } else {
                // Error genérico
                $errorMessage = $errorData['message'] ?? 'Error del servidor.';
            }

            return back()->withInput($request->only('email'))
                        ->withErrors(['email' => $errorMessage]);

        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            return back()->withErrors([
                'server' => 'No se pudo conectar con el servidor, intenta más tarde.'
            ]);
        }
    }
}
