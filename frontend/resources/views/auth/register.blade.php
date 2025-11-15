<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 px-4 py-12">

    <div class="w-full max-w-md bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/10">

        <!-- Logo -->
        <div class="flex flex-col items-center">
            <img src="https://images.icon-icons.com/1989/PNG/512/artboard_123064.png"
                class="h-24 w-24 drop-shadow-lg" alt="Logo" />

            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Crear cuenta
            </h2>

            <p class="text-gray-300 mt-1">Regístrate para continuar</p>
        </div>

        <!-- Alertas -->
        @if ($errors->any())
            <div class="alert alert-error shadow-md mt-6 mb-4 rounded-lg border border-red-400/20">
                <div class="flex items-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="stroke-current flex-shrink-0 h-6 w-6 mr-3" fill="none"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 14l2-2m0 0l2-2m-2 2l2 2m-2-2l-2-2m2 2h.01M12 14h.01M4.93 4.93l14.14 14.14"></path>
                    </svg>

                    <span class="flex-1 text-center font-medium">
                        {{ $errors->first() }}
                    </span>

                </div>
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
            @csrf

            <!-- Nombre -->
            <div>
                <label class="block text-sm font-semibold text-gray-200 mb-1">Nombre completo</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-md bg-white/20 text-white border border-white/20 focus:border-indigo-400 focus:ring-indigo-400 px-3 py-2 placeholder-gray-300"
                    placeholder="Carlos López" />
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-200 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-md bg-white/20 text-white border border-white/20 focus:border-indigo-400 focus:ring-indigo-400 px-3 py-2 placeholder-gray-300"
                    placeholder="ejemplo@correo.com" />
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-200 mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-md bg-white/20 text-white border border-white/20 focus:border-indigo-400 focus:ring-indigo-400 px-3 py-2 placeholder-gray-300"
                    placeholder="••••••••" />
            </div>

            <!-- Password Confirmation -->
            <div>
                <label class="block text-sm font-semibold text-gray-200 mb-1">Confirmar Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full rounded-md bg-white/20 text-white border border-white/20 focus:border-indigo-400 focus:ring-indigo-400 px-3 py-2 placeholder-gray-300"
                    placeholder="••••••••" />
            </div>

            <!-- Botón -->
            <button type="submit"
                class="w-full py-2.5 rounded-lg bg-indigo-600 text-white font-bold text-sm tracking-wide shadow-md
                       hover:bg-indigo-500 transition-all duration-200 hover:scale-[1.02]">
                Crear cuenta
            </button>

        </form>

        <!-- Link al Login -->
        <p class="mt-6 text-center text-sm text-gray-400">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}" class="font-semibold text-indigo-400 hover:text-indigo-300">
                Iniciar sesión
            </a>
        </p>

    </div>
</div>

</x-guest-layout>
