<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="form-control">
        <label class="label">
            <span class="label-text font-semibold">Primer Nombre</span>
        </label>
        <input type="text" name="primer_nombre" class="input input-bordered w-full bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary"
               value="{{ old('primer_nombre', $cliente['primer_nombre'] ?? '') }}"
               placeholder="Ingrese el primer nombre">
        @error('primer_nombre')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-control">
        <label class="label">
            <span class="label-text">Segundo Nombre</span>
        </label>
        <input type="text" name="segundo_nombre" class="input input-bordered w-full bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary"
               value="{{ old('segundo_nombre', $cliente['segundo_nombre'] ?? '') }}"
               placeholder="Opcional">
        @error('segundo_nombre')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-control">
        <label class="label">
            <span class="label-text font-semibold">Primer Apellido</span>
        </label>
        <input type="text" name="primer_apellido" class="input input-bordered w-full bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary"
               value="{{ old('primer_apellido', $cliente['primer_apellido'] ?? '') }}"
               placeholder="Ingrese el primer apellido">
        @error('primer_apellido')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-control">
        <label class="label">
            <span class="label-text">Segundo Apellido</span>
        </label>
        <input type="text" name="segundo_apellido" class="input input-bordered w-full bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary"
               value="{{ old('segundo_apellido', $cliente['segundo_apellido'] ?? '') }}"
               placeholder="Opcional">
        @error('segundo_apellido')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-control">
        <label class="label">
            <span class="label-text font-semibold">DPI</span>
        </label>
        <input type="text" name="dpi" class="input input-bordered w-full bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary"
               value="{{ old('dpi', $cliente['dpi'] ?? '') }}"
               placeholder="Número de DPI" required>
        @error('dpi')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-control">
        <label class="label">
            <span class="label-text">NIT</span>
        </label>
        <input type="text" name="nit" class="input input-bordered w-full bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary"
               value="{{ old('nit', $cliente['nit'] ?? '') }}"
               placeholder="Número de NIT">
        @error('nit')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-control">
        <label class="label">
            <span class="label-text">Fecha Nacimiento</span>
        </label>
        <input type="date" name="fecha_nacimiento" class="input input-bordered w-full bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary"
               value="{{ old('fecha_nacimiento', $cliente['fecha_nacimiento'] ?? '') }}">
        @error('fecha_nacimiento')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-control">
        <label class="label">
            <span class="label-text">Correo Electrónico</span>
        </label>
        <input type="email" name="correo" class="input input-bordered w-full bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary"
               value="{{ old('correo', $cliente['correo'] ?? '') }}"
               placeholder="correo@ejemplo.com">
        @error('correo')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-control">
        <label class="label">
            <span class="label-text">Teléfono</span>
        </label>
        <input type="text" name="telefono" class="input input-bordered w-full bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary"
               value="{{ old('telefono', $cliente['telefono'] ?? '') }}"
               placeholder="Número de teléfono">
        @error('telefono')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-control md:col-span-2">
        <label class="label">
            <span class="label-text">Dirección</span>
        </label>
        <textarea name="direccion" class="textarea textarea-bordered w-full h-24 bg-gray-800 text-white border-gray-600 focus:bg-gray-700 focus:border-primary" 
                  placeholder="Dirección completa del cliente">{{ old('direccion', $cliente['direccion'] ?? '') }}</textarea>
        @error('direccion')
            <div class="text-error text-sm mt-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </div>
        @enderror
    </div>

</div>