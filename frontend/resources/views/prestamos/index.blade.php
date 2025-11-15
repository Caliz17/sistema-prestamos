<x-dashboard-layout>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Préstamos</h1>

        <div class="flex gap-3">
            <!-- BOTÓN PARA CREAR PRESTAMO -->
            <button class="btn btn-primary" onclick="document.getElementById('modalCrearPrestamo').showModal()">
                <i class="fa fa-plus"></i> Nuevo Préstamo
            </button>

            <!-- BOTÓN PARA VER SOLICITUDES -->
            <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">
                Solicitudes
            </a>
        </div>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Solicitud</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Saldo</th>
                    <th>Pagos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($prestamos as $p)
                    <tr>
                        <td>{{ $p['id'] }}</td>

                        <td>
                            <a href="{{ route('solicitudes.show', $p['solicitud_id']) }}"
                               class="text-blue-600 underline">
                                Solicitud #{{ $p['solicitud_id'] }}
                            </a>
                        </td>

                        <td>Q{{ number_format($p['monto_aprobado'], 2) }}</td>

                        <td>
                            <span class="badge badge-info">{{ $p['estado'] }}</span>
                        </td>

                        <td>Q{{ number_format($p['saldo_actual'], 2) }}</td>

                        <td>
                            <button class="btn btn-sm btn-outline"
                                    onclick="cargarPagos({{ $p['id'] }})">
                                Ver Pagos
                            </button>
                        </td>

                        <td class="flex gap-2">
                            <a href="{{ route('prestamos.show', $p['id']) }}" class="btn btn-sm btn-info">Ver</a>

                            <form method="POST" action="{{ route('prestamos.destroy', $p['id']) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-error"
                                        onclick="return confirm('¿Eliminar préstamo?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>


    <!-- ======================== -->
    <!--     MODAL VER PAGOS      -->
    <!-- ======================== -->
    <dialog id="modalPagos" class="modal">
        <div class="modal-box w-11/12 max-w-3xl">
            <h3 class="font-bold text-lg mb-2">Pagos del préstamo #<span id="prestamoIdPagos"></span></h3>

            <div id="contenedorPagos" class="my-4">
                <p class="text-gray-500">Cargando pagos...</p>
            </div>

            <!-- FORMULARIO DE NUEVO PAGO -->
            <form id="formPago" class="mt-4 border-t pt-4 hidden">
                <h4 class="font-semibold mb-2">Registrar nuevo pago</h4>

                <input type="hidden" id="prestamo_id_pago">

                <div class="form-control mb-2">
                    <label class="label">Monto del pago</label>
                    <input type="number" step="0.01" id="monto_pago" class="input input-bordered" required>
                </div>

                <button type="submit" class="btn btn-success w-full">Registrar Pago</button>
            </form>

            <div class="modal-action">
                <button class="btn" onclick="document.getElementById('modalPagos').close()">Cerrar</button>
            </div>
        </div>
    </dialog>


    <!-- ============================= -->
    <!--     MODAL CREAR PRESTAMO      -->
    <!-- ============================= -->
    <dialog id="modalCrearPrestamo" class="modal">
        <div class="modal-box bg-base-200 text-base-content w-11/12 max-w-xl rounded-xl shadow-lg">

            <h3 class="text-2xl font-bold mb-1">📄 Crear Nuevo Préstamo</h3>
            <p class="text-sm opacity-70 mb-4">Complete los datos para generar el préstamo.</p>

            <form method="POST" action="{{ route('prestamos.store') }}" class="space-y-4">
                @csrf

                {{-- SOLICITUD --}}
                <div class="form-control">
                    <label class="label font-semibold">Solicitud aprobada</label>
                    <select name="solicitud_id"
                            class="select select-bordered bg-base-300 text-base-content w-full rounded-lg"
                            required>
                        <option value="">Seleccione una solicitud</option>

                        @foreach($solicitudesAprobadas as $s)
                            <option value="{{ $s['id'] }}">
                                Solicitud #{{ $s['id'] }} — Cliente: {{ $s['cliente']['primer_nombre'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- MONTO --}}
                <div class="form-control">
                    <label class="label font-semibold">Monto aprobado</label>
                    <input type="number" step="0.01"
                        name="monto_aprobado"
                        placeholder="Ejemplo: 25000.00"
                        class="input input-bordered bg-base-300 text-base-content rounded-lg"
                        required>
                </div>

                {{-- TASA --}}
                <div class="form-control">
                    <label class="label font-semibold">Tasa de interés (%)</label>
                    <input type="number" step="0.01"
                        name="tasa_interes"
                        placeholder="Ejemplo: 12.5"
                        class="input input-bordered bg-base-300 text-base-content rounded-lg"
                        required>
                </div>

                {{-- PLAZO --}}
                <div class="form-control">
                    <label class="label font-semibold">Plazo (meses)</label>
                    <input type="number"
                        name="plazo_meses"
                        placeholder="Ejemplo: 12"
                        class="input input-bordered bg-base-300 text-base-content rounded-lg"
                        required>
                </div>

                <button class="btn btn-primary w-full rounded-lg text-lg mt-2">
                    Guardar préstamo
                </button>
            </form>

            <div class="modal-action">
                <button class="btn btn-outline rounded-lg"
                        onclick="document.getElementById('modalCrearPrestamo').close()">
                    Cerrar
                </button>
            </div>

        </div>
    </dialog>



    <!-- ======================== -->
    <!--   JS PARA PAGOS (AJAX)   -->
    <!-- ======================== -->
    <script>
    function cargarPagos(prestamoId) {
        document.getElementById('modalPagos').showModal();
        document.getElementById('prestamoIdPagos').innerText = prestamoId;

        fetch(`{{ env('BACKEND_API_URL') }}/pagos/prestamo/${prestamoId}`, {
            headers: {
                "Authorization": "Bearer {{ session('api_token') }}"
            }
        })
            .then(res => res.json())
            .then(data => {
                let html = "";

                if (!data.data || data.data.length === 0) {
                    html = `<p class='text-gray-500'>No hay pagos registrados.</p>`;
                } else {
                    html = `
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Monto</th>
                                <th>Método</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;

                    data.data.forEach(pago => {
                        html += `
                            <tr>
                                <td>${pago.id}</td>
                                <td>Q${Number(pago.monto_pagado).toFixed(2)}</td>
                                <td>${pago.metodo_pago}</td>
                                <td>${pago.created_at}</td>
                            </tr>
                        `;
                    });

                    html += "</tbody></table>";
                }

                document.getElementById('contenedorPagos').innerHTML = html;

                // habilitar formulario para nuevo pago
                document.getElementById('formPago').classList.remove('hidden');
                document.getElementById('prestamo_id_pago').value = prestamoId;
            })
            .catch(error => {
                document.getElementById('contenedorPagos').innerHTML =
                    "<p class='text-red-500'>Error al cargar los pagos.</p>";
            });
    }
    </script>

</x-dashboard-layout>
