<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('BACKEND_API_URL', 'http://localhost:8000/api');
    }

    // MÉTODO CREATE FALTANTE
    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'dpi' => 'required|string|max:20',
            'nit' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'correo' => 'required|email',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:500',
        ]);

        try {
            Log::info('Enviando datos a la API:', $validated);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('api_token'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(env('API_URL') . '/clientes', $validated);


            if ($response->successful()) {
                $clienteData = $response->json();

                Log::info('Cliente creado via API:', $clienteData);

                return redirect()->route('clientes.index')
                    ->with('success', 'Cliente creado exitosamente.');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error desconocido del servidor';
                $statusCode = $response->status();

                Log::error('Error API al crear cliente: ' . $errorMessage, [
                    'status' => $statusCode,
                    'response' => $response->json()
                ]);
                if ($response->status() === 422) {
                    $errors = $response->json()['errors'] ?? [];

                    return back()
                        ->withErrors($errors)
                        ->withInput();
                }
            }

        } catch (\Exception $e) {
            Log::error('Excepción al crear cliente: ' . $e->getMessage());

            if ($response->status() === 422) {
                $errors = $response->json()['errors'] ?? [];

                return back()
                    ->withErrors($errors)
                    ->withInput();
            }
        }
    }

    public function index()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('api_token'),
                'Accept' => 'application/json',
            ])->get($this->apiBaseUrl . '/clientes');

            if ($response->successful()) {
                $apiResponse = $response->json();

                // Extraer los datos correctamente
                $data = $apiResponse['data'] ?? $apiResponse;

                return view('clientes.index', [
                    'clientes' => $data['clientes'] ?? [],
                    'totalClientes' => $data['total_clientes'] ?? 0,
                    'clientesConPrestamos' => $data['clientes_con_prestamos'] ?? 0,
                    'clientesNuevosMes' => $data['clientes_nuevos_mes'] ?? 0
                ]);
            } else {
                Log::error('Error al obtener clientes de API: ' . $response->status());
                return view('clientes.index', [
                    'clientes' => [],
                    'totalClientes' => 0,
                    'clientesConPrestamos' => 0,
                    'clientesNuevosMes' => 0
                ])->with('error', 'Error al cargar los clientes');
            }

        } catch (\Exception $e) {
            Log::error('Excepción al obtener clientes: ' . $e->getMessage());
            return view('clientes.index', [
                'clientes' => [],
                'totalClientes' => 0,
                'clientesConPrestamos' => 0,
                'clientesNuevosMes' => 0
            ])->with('error', 'Error de conexión al cargar clientes');
        }
    }

    public function edit($id)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('api_token'),
                'Accept' => 'application/json',
            ])->get($this->apiBaseUrl . '/clientes/' . $id);

            if ($response->successful()) {
                $cliente = $response->json()['data'] ?? $response->json();
                return view('clientes.edit', compact('cliente'));
            } else {
                return redirect()->route('clientes.index')
                    ->with('error', 'Cliente no encontrado');
            }

        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Error de conexión');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'dpi' => 'required|string|max:20',
            'nit' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'correo' => 'required|email',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:500',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('api_token'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->put($this->apiBaseUrl . '/clientes/' . $id, $validated);

            if ($response->successful()) {
                return redirect()->route('clientes.index')
                    ->with('success', 'Cliente actualizado exitosamente.');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error desconocido del servidor';
                if ($response->status() === 422) {
                    $errors = $response->json()['errors'] ?? [];

                    return back()
                        ->withErrors($errors)
                        ->withInput();
                }
            }

        } catch (\Exception $e) {
            if ($response->status() === 422) {
                $errors = $response->json()['errors'] ?? [];

                return back()
                    ->withErrors($errors)
                    ->withInput();
            }
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('api_token'),
                'Accept' => 'application/json',
            ])->delete($this->apiBaseUrl . '/clientes/' . $id);

            if ($response->successful()) {
                return redirect()->route('clientes.index')
                    ->with('success', 'Cliente eliminado exitosamente.');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error desconocido del servidor';
                return redirect()->route('clientes.index')
                    ->with('error', "Error al eliminar: {$errorMessage}");
            }

        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }

    // También asegúrate de tener el método show si usas Route::resource()
    public function show($id)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('api_token'),
                'Accept' => 'application/json',
            ])->get($this->apiBaseUrl . '/clientes/' . $id);

            if ($response->successful()) {
                $cliente = $response->json()['data'] ?? $response->json();
                return view('clientes.show', compact('cliente'));
            } else {
                return redirect()->route('clientes.index')
                    ->with('error', 'Cliente no encontrado');
            }

        } catch (\Exception $e) {
            return redirect()->route('clientes.index')
                ->with('error', 'Error de conexión');
        }
    }
}
