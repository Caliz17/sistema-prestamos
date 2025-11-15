<x-dashboard-layout>

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Crear Solicitud</h1>

        <a href="{{ route('solicitudes.index') }}" class="btn btn-neutral btn-outline">
            ← Regresar
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-base-200/40 p-8 rounded-xl shadow-xl border border-base-300">
        <form method="POST" action="{{ route('solicitudes.store') }}" class="space-y-8">
            @csrf

            {{-- GRID CAMPOS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- CLIENTE --}}
                <div class="form-control">
                    <label class="label font-semibold text-base-content/80">Cliente</label>
                    <select
                        name="cliente_id"
                        class="select select-bordered bg-base-300 text-base-content w-full"
                        required
                    >
                        <option value="">Seleccione un cliente</option>

                        @foreach($clientes as $c)
                            <option value="{{ $c['id'] }}">
                                {{ $c['primer_nombre'] }} {{ $c['primer_apellido'] }}
                                — DPI: {{ $c['dpi'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- MONTO --}}
                <div class="form-control">
                    <label class="label font-semibold text-base-content/80">Monto solicitado</label>
                    <input
                        type="number"
                        step="0.01"
                        name="monto_solicitado"
                        class="input input-bordered bg-base-300 text-base-content w-full"
                        required
                    >
                </div>

                {{-- PLAZO --}}
                <div class="form-control">
                    <label class="label font-semibold text-base-content/80">Plazo (meses)</label>
                    <input
                        type="number"
                        name="plazo_meses"
                        class="input input-bordered bg-base-300 text-base-content w-full"
                        required
                    >
                </div>

                {{-- INTERES --}}
                <div class="form-control">
                    <label class="label font-semibold text-base-content/80">Tasa de interés (%)</label>
                    <input
                        type="number"
                        step="0.01"
                        name="tasa_interes"
                        class="input input-bordered bg-base-300 text-base-content w-full"
                        required
                    >
                </div>

            </div>

            {{-- OBSERVACIONES --}}
            <div class="form-control">
                <label class="label font-semibold text-base-content/80">Observaciones</label>
                <textarea
                    name="observaciones"
                    class="textarea textarea-bordered bg-base-300 text-base-content w-full"
                    rows="4"
                ></textarea>
            </div>

            {{-- SUBMIT --}}
            <button class="btn btn-primary w-full md:w-auto shadow-lg">
                Guardar Solicitud
            </button>
        </form>
    </div>

</x-dashboard-layout>
