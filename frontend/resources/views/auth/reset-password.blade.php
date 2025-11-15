<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 to-gray-800 px-4">

    <div class="w-full max-w-md bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl p-8 border border-white/10">

        <h2 class="text-center text-white text-2xl font-bold mb-6">
            Restablecer contraseña
        </h2>

        @if ($errors->any())
            <div class="alert alert-error mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="text-gray-200 font-semibold mb-1 block">Correo electrónico</label>
                <input type="email" name="email" required value="{{ request('email') }}"
                       class="input input-bordered w-full bg-white/20 text-white" />
            </div>

            <div>
                <label class="text-gray-200 font-semibold mb-1 block">Nueva contraseña</label>
                <input type="password" name="password" required
                       class="input input-bordered w-full bg-white/20 text-white" />
            </div>

            <div>
                <label class="text-gray-200 font-semibold mb-1 block">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" required
                       class="input input-bordered w-full bg-white/20 text-white" />
            </div>

            <button class="btn btn-primary w-full">
                Restablecer contraseña
            </button>

        </form>
    </div>

</div>

</x-guest-layout>
