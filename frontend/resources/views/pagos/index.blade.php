<x-dashboard-layout>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Pagos</h1>

        <button class="btn btn-primary" onclick="modalNuevoPago.showModal()">
            + Registrar Pago
        </button>
    </div>

    {{-- FILTRO --}}
    <form method="GET" class="flex gap-3 mb-4">
        <select name="prestamo_id"
                class="select select-bordered bg-base-200 text-base-content">
            <option value="">Todos los préstamos</option>

            @foreach($prestamos as $p)
                <option value="{{ $p['id'] }}"
                    {{ request('prestamo_id') == $p['id'] ? 'selected' : '' }}>
                    Préstamo #{{ $p['id'] }} — Solicitud #{{ $p['solicitud_id'] }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-neutral">Filtrar</button>
    </form>

    {{-- TABLA --}}
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Préstamo</th>
                    <th>Monto</th>
                    <th>Método</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pagos as $pago)
                    <tr>
                        <td>{{ $pago['id'] }}</td>

                        <td>
                            <a class="text-blue-400 underline"
                               href="{{ route('prestamos.show', $pago['prestamo_id']) }}">
                                Préstamo #{{ $pago['prestamo_id'] }}
                            </a>
                        </td>

                        <td>Q{{ number_format($pago['monto_pagado'], 2) }}</td>
                        <td>{{ $pago['metodo_pago'] }}</td>

                        <td>{{ \Carbon\Carbon::parse($pago['created_at'])->format('d/m/Y H:i') }}</td>

                        <td>
                            <a href="{{ route('pagos.show', $pago['id']) }}"
                               class="btn btn-sm btn-info">
                                Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    {{-- MODAL REGISTRO --}}
    <dialog id="modalNuevoPago" class="modal">
        <div class="modal-box bg-base-200 text-base-content max-w-lg rounded-xl">

            <h3 class="text-xl font-bold mb-3">Registrar nuevo pago</h3>

            <form method="POST" action="{{ route('pagos.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="label">Préstamo</label>
                    <select name="prestamo_id"
                        class="select select-bordered bg-base-300 text-base-content w-full" required>
                        <option value="">Seleccione</option>

                        @foreach($prestamos as $p)
                            <option value="{{ $p['id'] }}">
                                #{{ $p['id'] }} — Solicitud #{{ $p['solicitud_id'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label">Monto pagado</label>
                    <input type="number" step="0.01" name="monto_pagado"
                        class="input input-bordered bg-base-300 text-base-content w-full"
                        required>
                </div>

                <div>
                    <label class="label">Método de pago</label>
                    <select name="metodo_pago"
                        class="select select-bordered bg-base-300 text-base-content w-full" required>
                        <option value="EFECTIVO">Efectivo</option>
                        <option value="TRANSFERENCIA">Transferencia</option>
                        <option value="DEPOSITO">Depósito</option>
                        <option value="TARJETA">Tarjeta</option>
                    </select>
                </div>

                <div>
                    <label class="label">Observaciones</label>
                    <textarea name="observaciones" rows="3"
                        class="textarea textarea-bordered bg-base-300 text-base-content w-full"></textarea>
                </div>

                <button class="btn btn-primary w-full">Guardar Pago</button>
            </form>

            <div class="modal-action">
                <button class="btn" onclick="modalNuevoPago.close()">Cerrar</button>
            </div>

        </div>
    </dialog>

</x-dashboard-layout>
