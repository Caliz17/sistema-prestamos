<!DOCTYPE html>
<html lang="es" class="h-full" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Prestamos</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">

<div class="drawer lg:drawer-open">
    <input id="sidebar" type="checkbox" class="drawer-toggle" />

    <!-- CONTENIDO PRINCIPAL -->
    <div class="drawer-content flex flex-col">

        <!-- NAVBAR SUPERIOR -->
        <div class="navbar bg-base-300 border-b border-base-100 px-4">
            <div class="flex-none lg:hidden">
                <label for="sidebar" class="btn btn-square btn-ghost">
                    <!-- hamburger -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                         stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </label>
            </div>

            <div class="flex-1 px-2 font-bold text-lg">
                Prestamos – Dashboard
            </div>

            <!-- DROPDOWN USER -->
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img src="https://i.pravatar.cc/100?img=15">
                    </div>
                </label>

                <ul tabindex="0" 
                    class="menu dropdown-content mt-3 z-[100] p-2 shadow bg-base-200 rounded-box w-52">

                    <li class="menu-title">Hola, {{ auth()->user()->name }}</li>

                    <li><a href="#">Perfil</a></li>
                    <li><a href="#">Ajustes</a></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-error">Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>

        <!-- CONTENIDO -->
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>

    <!-- SIDEBAR -->
    <div class="drawer-side">
        <label for="sidebar" class="drawer-overlay"></label>

        <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">

            <h2 class="menu-title text-lg mb-2">Menú</h2>

            <li><a href="{{ route('dashboard') }}">
                📊 Dashboard
            </a></li>

            <li><a href="#">
                👥 Clientes
            </a></li>

            <li><a href="#">
                💸 Préstamos
            </a></li>

            <li><a href="#">
                🧾 Pagos
            </a></li>

            <li><a href="#">
                ⚙ Configuración
            </a></li>
        </ul>
    </div>

</div>

</body>
</html>
