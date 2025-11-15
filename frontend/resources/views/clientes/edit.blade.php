<x-dashboard-layout section="Editar Cliente">
    
    <h1 class="text-3xl font-bold mb-6">Editar Cliente 👤</h1>

    <div class="max-w-3xl mx-auto bg-base-200 p-6 rounded-xl shadow-md">

        <h2 class="text-2xl font-bold mb-6">Información del Cliente</h2>

        <form action="{{ route('clientes.update', $cliente['id']) }}" method="POST">
            @csrf
            @method('PUT')

            @include('clientes.form', ['cliente' => $cliente])

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('clientes.index') }}" class="btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Actualizar Cliente
                </button>
            </div>
        </form>

    </div>

</x-dashboard-layout>