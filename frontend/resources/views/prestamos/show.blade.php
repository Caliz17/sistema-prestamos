<x-dashboard-layout>

<h1 class="text-2xl font-bold mb-4">Detalle del préstamo #{{ $prestamo['id'] }}</h1>

<div class="card bg-base-200 shadow p-6">

    <p><strong>Monto aprobado:</strong> Q{{ number_format($prestamo['monto_aprobado'], 2) }}</p>
    <p><strong>Tasa de interés:</strong> {{ $prestamo['tasa_interes'] }}%</p>
    <p><strong>Plazo:</strong> {{ $prestamo['plazo_meses'] }} meses</p>
    <p><strong>Saldo actual:</strong> Q{{ number_format($prestamo['saldo_actual'], 2) }}</p>
    <p><strong>Estado:</strong> {{ $prestamo['estado'] }}</p>
    <p><strong>Fecha aprobación:</strong> {{ $prestamo['fecha_aprobacion'] }}</p>

</div>

<a href="{{ route('pagos.index', $prestamo['id']) }}" class="btn btn-accent mt-4">Ver pagos</a>

</x-dashboard-layout>
