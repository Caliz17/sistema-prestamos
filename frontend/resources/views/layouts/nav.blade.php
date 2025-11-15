<nav class="bg-white shadow p-4 mb-4">
    <div class="flex gap-4">
        <a href="/" class="font-bold">Dashboard</a>
        <a href="/clientes">Clientes</a>
        <a href="/solicitudes">Solicitudes</a>
        <a href="/prestamos">Préstamos</a>
        <a href="/pagos">Pagos</a>
        <form action="/logout" method="POST" class="ml-auto">
            @csrf
            <button class="text-red-600">Cerrar Sesión</button>
        </form>
    </div>
</nav>
