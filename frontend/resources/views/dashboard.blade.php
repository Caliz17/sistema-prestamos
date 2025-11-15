<x-dashboard-layout>

    <h1 class="text-3xl font-bold mb-6">Bienvenido, {{ auth()->user()->name }} 👋</h1>

    <!-- CARDS DE ESTADÍSTICAS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="stat bg-base-200 rounded-xl shadow-md">
            <div class="stat-title">Clientes</div>
            <div class="stat-value text-primary">{{ $dashboardData['clientes'] ?? 0 }}</div>
            <div class="stat-desc">Registrados en el sistema</div>
        </div>

        <div class="stat bg-base-200 rounded-xl shadow-md">
            <div class="stat-title">Préstamos activos</div>
            <div class="stat-value text-secondary">{{ $dashboardData['prestamos_activos'] ?? 0 }}</div>
            <div class="stat-desc">Actualmente vigentes</div>
        </div>

        <div class="stat bg-base-200 rounded-xl shadow-md">
            <div class="stat-title">Ingresos</div>
            <div class="stat-value text-success">Q{{ number_format($dashboardData['ingresos_mensuales'] ?? 0, 2) }}</div>
            <div class="stat-desc">Últimos 30 días</div>
        </div>

    </div>

    <!-- TABLA DE PRÉSTAMOS RECIENTES -->
    <div class="bg-base-200 p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-bold mb-4">Préstamos recientes</h2>

        @if(isset($dashboardData['prestamos_recientes']) && count($dashboardData['prestamos_recientes']) > 0)
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dashboardData['prestamos_recientes'] as $prestamo)
                    <tr>
                        <td class="font-medium">{{ $prestamo['cliente_nombre'] ?? 'N/A' }}</td>
                        <td>Q{{ number_format($prestamo['monto_aprobado'] ?? 0, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($prestamo['fecha_aprobacion'] ?? now())->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $estado = $prestamo['estado'] ?? 'DESCONOCIDO';
                                $badgeClass = match($estado) {
                                    'ACTIVO' => 'badge-success',
                                    'PENDIENTE' => 'badge-warning',
                                    'ATRASADO' => 'badge-error',
                                    'PAGADO' => 'badge-info',
                                    default => 'badge-neutral'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $estado }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/30 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-base-content/60">No hay préstamos recientes</p>
        </div>
        @endif
    </div>

</x-dashboard-layout>