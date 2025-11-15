<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SolicitudController extends Controller
{
    private string $api;

    public function __construct()
    {
        $this->api = config('services.api.url', 'http://localhost:8000');
    }

    private function token()
    {
        return session('api_token');
    }

    public function index()
    {
        $response = Http::withToken($this->token())->get($this->api . '/api/solicitudes');

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron obtener las solicitudes.');
        }

        return view('solicitudes.index', [
            'solicitudes' => $response->json()['data']
        ]);
    }

    public function create()
    {
        $response = Http::withToken($this->token())
            ->get($this->api . '/api/clientes');

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron cargar los clientes.');
        }

        $clientes = $response->json()['data']['clientes'] ?? [];


        // 🔥 Asegurar que sea SIEMPRE un array de arrays
        if (!is_array($clientes)) {
            $clientes = [];
        }

        // ⚠ Si algún elemento es int o null, filtrarlo:
        $clientes = array_filter($clientes, function ($item) {
            return is_array($item) && isset($item['id']);
        });

        return view('solicitudes.create', compact('clientes'));
    }


    public function store(Request $request)
    {
        $response = Http::withToken($this->token())->post($this->api . '/api/solicitudes', $request->all());

        if ($response->failed()) {
            return back()->with('error', 'Error al crear la solicitud.')->withInput();
        }

        return redirect()->route('solicitudes.index')->with('success', 'Solicitud creada correctamente.');
    }

    public function show($id)
    {
        $response = Http::withToken($this->token())->get($this->api . "/api/solicitudes/$id");

        if ($response->status() === 404) {
            abort(404);
        }

        return view('solicitudes.show', [
            'solicitud' => $response->json()['data']
        ]);
    }

    public function update(Request $request, $id)
    {
        $response = Http::withToken($this->token())
            ->put($this->api . "/api/solicitudes/{$id}", $request->all());

        if ($response->failed()) {
            return back()->with('error', 'Error al actualizar la solicitud.')->withInput();
        }

        return redirect()
            ->route('solicitudes.show', $id)
            ->with('success', 'Solicitud actualizada correctamente.');
    }


    public function destroy($id)
    {
        $response = Http::withToken($this->token())
            ->delete($this->api . "/api/solicitudes/$id");

        if ($response->failed()) {
            return back()->with('error', 'No se pudo eliminar la solicitud.');
        }

        return redirect()->route('solicitudes.index')->with('success', 'Solicitud eliminada.');
    }

    public function aprobar($id)
    {
        $response = Http::withToken($this->token())
            ->put($this->api . "/api/solicitudes/$id/aprobar");

        if ($response->failed()) {
            return back()->with('error', $response->json()['message'] ?? 'No se pudo aprobar');
        }

        return back()->with('success', 'Solicitud aprobada.');
    }

    public function rechazar($id)
    {
        $response = Http::withToken($this->token())
            ->put($this->api . "/api/solicitudes/$id/rechazar");

        if ($response->failed()) {
            return back()->with('error', $response->json()['message'] ?? 'No se pudo rechazar');
        }

        return back()->with('success', 'Solicitud rechazada.');
    }

    public function solicitudesPorCliente($cliente_id)
    {
        $response = Http::withToken($this->token())
            ->get($this->api . "/api/solicitudes/cliente/$cliente_id");

        return view('solicitudes.index', [
            'solicitudes' => $response->json()['data']
        ]);
    }

    public function edit($id)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('api_token'),
                'Accept' => 'application/json',
            ])->get($this->api . '/api/solicitudes/' . $id);

            if ($response->successful()) {
                $solicitud = $response->json()['data'] ?? $response->json();
                return view('solicitudes.edit', compact('solicitud'));
            } else {
                return redirect()->route('solicitudes.index')
                    ->with('error', 'Solicitud no encontrada');
            }

        } catch (\Exception $e) {
            return redirect()->route('solicitudes.index')
                ->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }

}
