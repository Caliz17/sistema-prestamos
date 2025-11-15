<x-dashboard-layout>

    <div class="max-w-5xl mx-auto">

        {{-- HEADER PRINCIPAL --}}
        <div class="flex justify-between items-center mb-8">

            <div>
                <h1 class="text-3xl font-bold mb-1">
                    Solicitud #{{ $solicitud['id'] }}
                </h1>

                <p class="text-sm opacity-70">
                    Fecha:
                    @if(isset($solicitud['created_at']))
                        {{ \Carbon\Carbon::parse($solicitud['created_at'])->format('d/m/Y H:i') }}
                    @else
                        <span class="opacity-50">No disponible</span>
                    @endif
                </p>
            </div>

            {{-- BOTONES --}}
            <div class="flex gap-2">

                {{-- Volver --}}
                <a href="{{ route('solicitudes.index') }}" class="btn btn-neutral">
                    ← Volver
                </a>

                {{-- EDITAR --}}
                @if($solicitud['estado'] === 'EN PROCESO')
                    <a href="{{ route('solicitudes.edit', $solicitud['id']) }}"
                       class="btn btn-warning">
                        ✏️ Editar
                    </a>
                @endif

                {{-- APROBAR --}}
                @if($solicitud['estado'] === 'EN PROCESO')
                    <form action="{{ route('solicitudes.aprobar', $solicitud['id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-success">
                            ✔ Aprobar
                        </button>
                    </form>
                @endif

                {{-- RECHAZAR --}}
                @if($solicitud['estado'] === 'EN PROCESO')
                    <form action="{{ route('solicitudes.rechazar', $solicitud['id']) }}" method="POST"
                          onsubmit="return confirm('¿Rechazar esta solicitud?')">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-error">
                            ✖ Rechazar
                        </button>
                    </form>
                @endif

                {{-- CREAR PRÉSTAMO --}}
                @if($solicitud['estado'] === 'APROBADO')
                    <a href="{{ route('prestamos.createDesdeSolicitud', $solicitud['id']) }}"
                       class="btn btn-primary">
                        💰 Crear Préstamo
                    </a>
                @endif

            </div>

        </div>



        {{-- CARD CLIENTE --}}
        <div class="card shadow-md bg-base-100 mb-6">
            <div class="card-body">

                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Datos del Cliente</h2>
                </div>

                <div class="divider my-2"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <p><strong>Nombre:</strong> {{ $solicitud['cliente']['primer_nombre'] }} {{ $solicitud['cliente']['primer_apellido'] }}</p>

                    <p><strong>DPI:</strong> {{ $solicitud['cliente']['dpi'] }}</p>

                    <p><strong>Correo:</strong> {{ $solicitud['cliente']['correo'] }}</p>

                    <p><strong>Teléfono:</strong> {{ $solicitud['cliente']['telefono'] }}</p>

                </div>

            </div>
        </div>



        {{-- CARD DETALLE SOLICITUD --}}
        <div class="card shadow-md bg-base-100">
            <div class="card-body">

                <h2 class="text-xl font-semibold mb-2">Detalle de la Solicitud</h2>

                <div class="divider my-2"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <p>
                        <strong>Monto solicitado:</strong><br>
                        Q{{ number_format($solicitud['monto_solicitado'], 2) }}
                    </p>

                    <p>
                        <strong>Plazo:</strong><br>
                        {{ $solicitud['plazo_meses'] }} meses
                    </p>

                    <p>
                        <strong>Tasa interés:</strong><br>
                        {{ $solicitud['tasa_interes'] }}%
                    </p>

                    <p>
                        <strong>Estado:</strong><br>
                        @php
                            $color = match($solicitud['estado']) {
                                'APROBADO' => 'badge-success',
                                'RECHAZADO' => 'badge-error',
                                default => 'badge-warning'
                            };
                        @endphp

                        <span class="badge {{ $color }} text-base px-3 py-2">
                            {{ $solicitud['estado'] }}
                        </span>
                    </p>

                </div>

                <div class="mt-4">
                    <strong>Observaciones:</strong><br>
                    <p class="mt-1">
                        {{ $solicitud['observaciones'] ?: 'Sin observaciones' }}
                    </p>
                </div>

            </div>
        </div>

    </div>

</x-dashboard-layout>
