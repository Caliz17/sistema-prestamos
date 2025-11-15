<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrestamoController extends Controller
{
    private string $api;

    public function __construct()
    {
        $this->api = env('BACKEND_API_URL', 'http://localhost:8000/api');
    }

    private function token()
    {
        return session('api_token');
    }

    public function index()
    {
        try {
            // 🔹 Obtener todos los préstamos
            $prestamos = Http::withToken($this->token())
                ->get($this->api . '/prestamos')
                ->json('data') ?? [];

            // 🔹 Obtener solicitudes aprobadas para mostrar en modal
            $solicitudesAprobadas = Http::withToken($this->token())
                ->get($this->api . '/solicitudes', [
                    'estado' => 'APROBADO'
                ])
                ->json('data') ?? [];

            return view('prestamos.index', [
                'prestamos' => $prestamos,
                'solicitudesAprobadas' => $solicitudesAprobadas
            ]);

        } catch (\Exception $e) {
            Log::error("Error cargando préstamos: " . $e->getMessage());

            return view('prestamos.index', [
                'prestamos' => [],
                'solicitudesAprobadas' => []
            ])->with('error', 'No se pudieron cargar los préstamos');
        }
    }

    public function store(Request $request)
    {
        $response = Http::withToken($this->token())->post($this->api . '/prestamos', $request->all());

        if ($response->failed()) {
            return back()->with('error', 'No se pudo crear el préstamo. Verifica la solicitud.');
        }

        return redirect()->route('prestamos.index')->with('success', 'Préstamo creado correctamente.');
    }

    public function show($id)
    {
        $response = Http::withToken($this->token())->get($this->api . "/prestamos/$id");

        if ($response->status() === 404) {
            abort(404);
        }

        return view('prestamos.show', [
            'prestamo' => $response->json()['data']
        ]);
    }

    public function destroy($id)
    {
        $url = $this->api . "/prestamos/$id";

        $response = Http::withToken($this->token())->delete($url);

        if ($response->status() === 400) {
            return back()->with('error', 'No se puede eliminar, tiene pagos.');
        }

        if ($response->failed()) {
            return back()->with('error', 'Error al eliminar el préstamo.');
        }

        return redirect()->route('prestamos.index')->with('success', 'Préstamo eliminado correctamente.');
    }


    public function prestamosPorCliente($cliente_id)
    {
        $response = Http::withToken($this->token())
            ->get($this->api . "/prestamos/cliente/$cliente_id");

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron obtener los préstamos del cliente.');
        }

        return view('prestamos.index', [
            'prestamos' => $response->json()['data'],
            'solicitudesAprobadas' => []   // evita errores
        ]);
    }
    public function createFromSolicitud($id)
    {
        // Obtener los datos de la solicitud aprobada
        $response = Http::withToken($this->token())
            ->get($this->api . "/api/solicitudes/$id");

        if ($response->failed() || !isset($response->json()['data'])) {
            return redirect()->route('prestamos.index')
                ->with('error', 'No se pudo obtener la solicitud.');
        }

        $solicitud = $response->json()['data'];

        // Validar que esté aprobada
        if ($solicitud['estado'] !== 'APROBADO') {
            return redirect()->route('prestamos.index')
                ->with('error', 'La solicitud no está aprobada y no puede generar un préstamo.');
        }

        return view('prestamos.create-desde-solicitud', compact('solicitud'));
    }



}
