@extends('layouts.admin')
@section('titulo', 'Nuevo Comercio')
@section('subtitulo', 'Registrar un nuevo comercio en la plataforma')
@section('contenido')

<div class="max-w-3xl">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.comercios.index') }}" class="hover:text-brand-600 transition">Comercios</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-slate-600 font-medium">Nuevo comercio</span>
    </div>

    <form action="{{ route('admin.comercios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Datos del comercio --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 bg-brand-100 rounded-2xl flex items-center justify-center">
                    <i data-lucide="store" class="w-6 h-6 text-brand-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Datos del comercio</h3>
                    <p class="text-slate-400 text-sm">Información pública del negocio</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre del comercio <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Tienda La Bendición"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition @error('nombre') border-red-400 @enderror">
                    @error('nombre')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Descripción</label>
                    <textarea name="descripcion" rows="3" placeholder="Descripción breve del negocio..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition resize-none">{{ old('descripcion') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="5555-0000"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Correo del comercio</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="comercio@ejemplo.com"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Zona 1, Ciudad de Guatemala"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>

                {{-- Logo --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Logo del comercio</label>
                    <div class="flex items-center gap-4">
                        <div id="logo-preview" class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center border-2 border-dashed border-slate-300 overflow-hidden">
                            <i data-lucide="image" class="w-6 h-6 text-slate-300" id="logo-icon"></i>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="logo" id="logo-input" accept="image/*" class="hidden">
                            <button type="button" onclick="document.getElementById('logo-input').click()"
                                class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                                <i data-lucide="upload" class="w-4 h-4"></i> Subir logo
                            </button>
                            <p class="text-xs text-slate-400 mt-1.5">JPG, PNG o WEBP · máx. 2MB</p>
                        </div>
                    </div>
                    @error('logo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Datos del usuario propietario --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <i data-lucide="user-plus" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Cuenta del propietario</h3>
                    <p class="text-slate-400 text-sm">Se creará un usuario con rol Comerciante</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre completo <span class="text-red-500">*</span></label>
                    <input type="text" name="user_name" value="{{ old('user_name') }}" placeholder="Nombre del propietario"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition @error('user_name') border-red-400 @enderror">
                    @error('user_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Correo electrónico <span class="text-red-500">*</span></label>
                    <input type="email" name="user_email" value="{{ old('user_email') }}" placeholder="propietario@ejemplo.com"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition @error('user_email') border-red-400 @enderror">
                    @error('user_email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Contraseña <span class="text-red-500">*</span></label>
                    <input type="password" name="user_password" placeholder="Mínimo 8 caracteres"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition @error('user_password') border-red-400 @enderror">
                    @error('user_password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition shadow-sm">
                <i data-lucide="save" class="w-4 h-4"></i> Registrar comercio
            </button>
            <a href="{{ route('admin.comercios.index') }}"
               class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm px-6 py-3 rounded-xl transition">
                <i data-lucide="x" class="w-4 h-4"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('logo-input').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('logo-preview');
        preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
