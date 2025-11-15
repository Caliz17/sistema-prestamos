<x-dashboard-layout>

    <div class="max-w-3xl mx-auto">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold">Editar Solicitud #{{ $solicitud['id'] }}</h1>
                <p class="text-sm opacity-70">Modifica los datos y guarda los cambios</p>
            </div>

            <a href="{{ route('solicitudes.index') }}" class="btn btn-neutral">
                ← Volver
            </a>
        </div>

        {{-- FORMULARIO --}}
        <div class="card shadow-lg bg-base-100">
            <div class="card-body">

                <form action="{{ route('solicitudes.update', $solicitud['id']) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- MONTO --}}
                        <div>
                            <label class="label font-semibold">Monto solicitado</label>
                            <input type="number" step="0.01"
                                   name="monto_solicitado"
                                   value="{{ old('monto_solicitado', $solicitud['monto_solicitado']) }}"
                                   class="input input-bordered w-full bg-base-200 text-base-content"
                                   required>
                        </div>

                        {{-- PLAZO --}}
                        <div>
                            <label class="label font-semibold">Plazo (meses)</label>
                            <input type="number"
                                   name="plazo_meses"
                                   value="{{ old('plazo_meses', $solicitud['plazo_meses']) }}"
                                   class="input input-bordered w-full bg-base-200 text-base-content"
                                   required>
                        </div>

                        {{-- TASA DE INTERÉS --}}
                        <div>
                            <label class="label font-semibold">Tasa de interés (%)</label>
                            <input type="number" step="0.01"
                                   name="tasa_interes"
                                   value="{{ old('tasa_interes', $solicitud['tasa_interes']) }}"
                                   class="input input-bordered w-full bg-base-200 text-base-content"
                                   required>
                        </div>

                        {{-- ESTADO --}}
                        <div>
                            <label class="label font-semibold">Estado</label>
                            <select name="estado"
                                    class="select select-bordered w-full bg-base-200 text-base-content"
                                    required>
                                <option value="EN PROCESO" {{ $solicitud['estado'] === 'EN PROCESO' ? 'selected' : '' }}>En proceso</option>
                                <option value="APROBADO" {{ $solicitud['estado'] === 'APROBADO' ? 'selected' : '' }}>Aprobado</option>
                                <option value="RECHAZADO" {{ $solicitud['estado'] === 'RECHAZADO' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>

                    </div>

                    {{-- OBSERVACIONES --}}
                    <div class="mt-6">
                        <label class="label font-semibold">Observaciones</label>
                        <textarea name="observaciones"
                                  rows="4"
                                  class="textarea textarea-bordered w-full bg-base-200 text-base-content"
                                  placeholder="Detalles adicionales">{{ old('observaciones', $solicitud['observaciones']) }}</textarea>
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex justify-end mt-8 gap-3">
                        <a href="{{ route('solicitudes.index') }}" class="btn">Cancelar</a>

                        <button class="btn btn-primary">
                            💾 Guardar cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</x-dashboard-layout>
