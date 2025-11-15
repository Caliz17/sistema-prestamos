<x-dashboard-layout>

<h1 class="text-2xl font-bold mb-4">Registrar Pago</h1>

<form method="POST" action="{{ route('pagos.store', $prestamo_id) }}" class="space-y-4">
    @csrf

    <div class="form-control">
        <label class="label">Monto del pago</label>
        <input name="monto" type="number" step="0.01" required class="input input-bordered"/>
    </div>

    <button class="btn btn-primary w-full">Guardar pago</button>
</form>

</x-dashboard-layout>
