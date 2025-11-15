<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 px-4 py-12">

        <div class="w-full max-w-md bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/10">

            <!-- Título -->
            <h2 class="text-3xl font-extrabold text-white text-center">
                Recuperar contraseña
            </h2>

            <p class="text-gray-300 text-center mt-2">
                Ingresa tu correo y te enviaremos un enlace.
            </p>

            <!-- ÉXITO -->
            @if (session('status'))
                <div class="alert alert-success shadow-md mt-6 mb-4 rounded-lg border border-green-400/20">
                    {{ session('status') }}
                </div>
            @endif

            <!-- ERRORES -->
            @if ($errors->any())
                <div class="alert alert-error shadow-md mt-6 mb-4 rounded-lg border border-red-400/20">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
                @csrf

                <label class="block text-sm font-semibold text-gray-200 mb-1">Email</label>
                <input type="email" name="email" required
                       class="w-full rounded-md bg-white/20 text-white border border-white/20 focus:border-indigo-400 focus:ring-indigo-400 px-3 py-2 placeholder-gray-300"
                       placeholder="tu@correo.com">

                <button class="w-full py-2.5 rounded-lg bg-indigo-600 text-white font-bold text-sm shadow-md hover:bg-indigo-500 transition">
                    Enviar enlace
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-400">
                <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300">
                    Volver al login
                </a>
            </p>

        </div>
    </div>
</x-guest-layout>
