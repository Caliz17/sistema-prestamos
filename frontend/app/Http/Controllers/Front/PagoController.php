<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PagoController extends Controller
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

    public function index(Request $request)
    {
        $prestamoId = $request->prestamo_id;

        if ($prestamoId) {
            $responsePagos = Http::withToken($this->token())
                ->get($this->api . "/pagos/prestamo/$prestamoId");  // ✔ CORRECTO
        } else {
            $responsePagos = Http::withToken($this->token())
                ->get($this->api . "/pagos");  // ✔ CORRECTO
        }

        if ($responsePagos->failed()) {
            return back()->with('error', 'No se pudieron obtener los pagos.');
        }

        $pagos = $responsePagos->json()['data'] ?? [];

        // obtener préstamos
        $responsePrestamos = Http::withToken($this->token())
            ->get($this->api . "/prestamos");  // ✔ CORRECTO

        $prestamos = $responsePrestamos->json()['data'] ?? [];

        return view('pagos.index', compact('pagos', 'prestamos'));
    }



    public function store(Request $request)
    {
        $data = [
            "prestamo_id" => $request->prestamo_id,
            "monto_pagado" => $request->monto_pagado,
            "metodo_pago" => $request->metodo_pago,
            "observaciones" => $request->observaciones,
        ];

        $response = Http::withToken($this->token())
            ->post($this->api . "/pagos", $data);  // ✔ CORRECTO

        if ($response->failed()) {
            return back()->with('error', 'No se pudo registrar el pago.');
        }

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }



    public function show($id)
    {
        $response = Http::withToken($this->token())
            ->get($this->api . "/api/pagos/$id");

        if ($response->failed()) {
            abort(404);
        }

        return view('pagos.show', [
            "pago" => $response->json()['data']
        ]);
    }
}
