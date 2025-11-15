<x-dashboard-layout section="Clientes">

    <h1 class="text-3xl font-bold mb-6">Gestión de Clientes 👥</h1>

    <!-- CARDS DE ESTADÍSTICAS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="stat bg-base-200 rounded-xl shadow-md">
            <div class="stat-title">Total Clientes</div>
            <div class="stat-value text-primary">{{ $totalClientes }}</div>
            <div class="stat-desc">Registrados en el sistema</div>
        </div>

        <div class="stat bg-base-200 rounded-xl shadow-md">
            <div class="stat-title">Clientes Activos</div>
            <div class="stat-value text-secondary">{{ $clientesConPrestamos }}</div>
            <div class="stat-desc">Con préstamos vigentes</div>
        </div>

        <div class="stat bg-base-200 rounded-xl shadow-md">
            <div class="stat-title">Nuevos este mes</div>
            <div class="stat-value text-success">{{ $clientesNuevosMes }}</div>
            <div class="stat-desc">Crecimiento mensual</div>
        </div>
    </div>

    <!-- HEADER Y BOTÓN -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Lista de Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Crear Cliente
        </a>
    </div>

    <!-- ALERTA DE SUCCESS -->
    @if(session('success'))
        <div class="alert alert-success mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- TABLA DE CLIENTES CON DATATABLES -->
    <div class="bg-base-200 p-6 rounded-xl shadow-md">
        <div class="overflow-x-auto">
            <table id="clientesTable" class="table w-full display">
                <thead>
                    <tr class="bg-base-300">
                        <th>Nombre</th>
                        <th>DPI</th>
                        <th>NIT</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $c)
                    <tr>
                        <td class="font-medium">
                            <div class="flex items-center space-x-3">
                                <div class="avatar placeholder">
                                    <div class="bg-neutral text-neutral-content rounded-full w-10">
                                        <span class="text-xs">
                                            {{ substr($c['primer_nombre'], 0, 1) }}{{ substr($c['primer_apellido'], 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ $c['primer_nombre'] }} {{ $c['primer_apellido'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $c['dpi'] }}</td>
                        <td>{{ $c['nit'] }}</td>
                        <td>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-base-content/70" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                {{ $c['correo'] }}
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-base-content/70" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                {{ $c['telefono'] }}
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('clientes.edit', $c['id']) }}" 
                                   class="btn btn-sm btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Editar
                                </a>
                                <form action="{{ route('clientes.destroy', $c['id']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-error"
                                            onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- SCRIPTS PARA DATATABLES -->
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.tailwindcss.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#clientesTable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": activar para ordenar la columna ascendente",
                        "sortDescending": ": activar para ordenar la columna descendente"
                    }
                },
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
                dom: '<"flex justify-between items-center mb-4"<"flex items-center"l><"flex items-center"f>>rt<"flex justify-between items-center mt-4"<"flex items-center"i><"flex items-center"p>>',
                initComplete: function() {
                    // Personalizar el input de búsqueda
                    $('div.dataTables_filter input').addClass('input input-bordered input-sm');
                    $('div.dataTables_length select').addClass('select select-bordered select-sm');
                },
                drawCallback: function() {
                    // Actualizar información de paginación
                    var info = this.api().page.info();
                    $('.dataTables_info').html(
                        'Mostrando ' + (info.start + 1) + ' a ' + 
                        (info.end) + ' de ' + info.recordsTotal + ' registros'
                    );
                }
            });
        });
    </script>
    
    <style>
        /* Personalización adicional para DataTables */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply btn btn-sm mx-1;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply btn-primary;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:not(.current) {
            @apply btn-ghost;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            @apply mb-4;
        }
    </style>
    @endpush

</x-dashboard-layout>