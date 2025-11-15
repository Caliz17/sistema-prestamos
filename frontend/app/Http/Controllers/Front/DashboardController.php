<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('BACKEND_API_URL', 'http://localhost:8000/api');
    }

    public function index()
    {
        try {
            Log::info('Intentando conectar a API Dashboard', [
                'url' => $this->apiBaseUrl . '/dashboard',
                'token' => session('api_token') ? 'Presente' : 'Ausente'
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('api_token'),
                'Accept' => 'application/json',
            ])->timeout(30)->get($this->apiBaseUrl . '/dashboard');

            Log::info('Respuesta de API Dashboard', [
                'status' => $response->status(),
                'successful' => $response->successful()
            ]);

            if ($response->successful()) {
                $apiResponse = $response->json();
                $dashboardData = $apiResponse['data'] ?? $apiResponse;
                
                Log::info('Datos recibidos del dashboard', ['data' => $dashboardData]);
                
                return view('dashboard', compact('dashboardData'));
            } else {
                $errorBody = $response->body();
                Log::error('Error al cargar dashboard', [
                    'status' => $response->status(),
                    'response' => $errorBody,
                    'url' => $this->apiBaseUrl . '/dashboard'
                ]);
                
                // Si es error 401 (no autorizado), redirigir a login
                if ($response->status() === 401) {
                    return redirect()->route('login')->with('error', 'Sesión expirada. Por favor, inicie sesión nuevamente.');
                }
                
                return view('dashboard', ['dashboardData' => null])
                    ->with('error', 'No se pudieron cargar los datos del dashboard. Código: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Excepción en dashboard: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return view('dashboard', ['dashboardData' => null])
                ->with('error', 'Error de conexión con el servidor: ' . $e->getMessage());
        }
    }
}