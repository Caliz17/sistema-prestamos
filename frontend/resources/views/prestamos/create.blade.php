<div class="modal-box bg-base-200 text-base-content shadow-xl border border-base-300 max-w-3xl">

    <h3 class="text-2xl font-bold mb-6">Crear nuevo préstamo</h3>

    <form method="POST" action="{{ route('prestamos.store') }}" class="space-y-6">
        @csrf

        {{-- SELECT SOLICITUD --}}
        <div>
            <label class="label font-semibold">Solicitud aprobada</label>
            <select name="solicitud_id"
                    class="select select-bordered bg-base-300 text-base-content w-full"
                    required>
                <option value="">Seleccione una solicitud</option>

                @foreach($solicitudes as $s)
                    @php 
                        $c = $s['cliente_detalle'];
                    @endphp

                    <option value="{{ $s['id'] }}">
                        Solicitud #{{ $s['id'] }} – 
                        {{ $c['primer_nombre'] ?? 'Cliente desconocido' }}
                        {{ $c['primer_apellido'] ?? '' }}
                        — Q{{ number_format($s['monto_solicitado'], 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="label font-semibold">Monto aprobado</label>
                <input type="number" step="0.01"
                       class="input input-bordered bg-base-300 text-base-content w-full"
                       name="monto_aprobado" required>
            </div>

            <div>
                <label class="label font-semibold">Tasa interés (%)</label>
                <input type="number" step="0.01"
                       class="input input-bordered bg-base-300 text-base-content w-full"
                       name="tasa_interes" required>
            </div>

            <div>
                <label class="label font-semibold">Plazo (meses)</label>
                <input type="number"
                       class="input input-bordered bg-base-300 text-base-content w-full"
                       name="plazo_meses" required>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" class="btn btn-neutral" onclick="document.getElementById('modal-prestamo').close()">
                Cancelar
            </button>
            <button class="btn btn-primary">
                Crear Préstamo
            </button>
        </div>

    </form>
</div>
