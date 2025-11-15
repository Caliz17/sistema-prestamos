<x-dashboard-layout>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Solicitudes</h1>

        <a href="{{ route('solicitudes.create') }}" class="btn btn-primary">
            ➕ Nueva Solicitud
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error mb-4">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Plazo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($solicitudes as $s)
                    <tr>
                        <td>{{ $s['id'] }}</td>

                        <td>
                            {{ $s['cliente']['primer_nombre'] ?? '—' }}
                            {{ $s['cliente']['primer_apellido'] ?? '' }}
                        </td>

                        <td>Q{{ number_format($s['monto_solicitado'], 2) }}</td>

                        <td>{{ $s['plazo_meses'] }} meses</td>

                        <td>
                            <span class="badge 
                                @if($s['estado'] === 'APROBADO') badge-success 
                                @elseif($s['estado'] === 'RECHAZADO') badge-error
                                @else badge-info
                                @endif">
                                {{ $s['estado'] }}
                            </span>
                        </td>

                        <td class="flex gap-2">

                            <a href="{{ route('solicitudes.show', $s['id']) }}"
                               class="btn btn-sm btn-info">
                                Ver
                            </a>

                            <a href="{{ route('solicitudes.edit', $s['id']) }}"
                               class="btn btn-sm btn-warning">
                                Editar
                            </a>

                            <form method="POST" 
                                  action="{{ route('solicitudes.destroy', $s['id']) }}"
                                  onsubmit="return confirm('¿Eliminar esta solicitud?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-error">
                                    Eliminar
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</x-dashboard-layout>
