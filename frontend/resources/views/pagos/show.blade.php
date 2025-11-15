<x-dashboard-layout>

    <h1 class="text-3xl font-bold mb-4">Pago #{{ $pago['id'] }}</h1>

    <div class="card bg-base-200 p-6 rounded-xl shadow">

        <p><strong>Préstamo:</strong> #{{ $pago['prestamo_id'] }}</p>
        <p><strong>Monto pagado:</strong> Q{{ number_format($pago['monto_pagado'],2) }}</p>
        <p><strong>Método:</strong> {{ $pago['metodo_pago'] }}</p>
        <p><strong>Observaciones:</strong> {{ $pago['observaciones'] ?? 'N/A' }}</p>
        <p><strong>Fecha:</strong> {{ $pago['created_at'] }}</p>

    </div>

    <a href="{{ route('pagos.index') }}" class="btn btn-neutral mt-5">
        ← Regresar
    </a>

</x-dashboard-layout>
