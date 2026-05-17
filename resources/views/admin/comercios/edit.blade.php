@extends('layouts.admin')
@section('titulo', 'Editar Comercio')
@section('subtitulo', 'Modificar datos del comercio')
@section('contenido')

<div class="max-w-3xl">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.comercios.index') }}" class="hover:text-brand-600 transition">Comercios</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="text-slate-600 font-medium">Editar: {{ $comercio->nombre }}</span>
    </div>

    <form action="{{ route('admin.comercios.update', $comercio) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center overflow-hidden">
                    @if($comercio->logo)
                        <img src="{{ asset('storage/'.$comercio->logo) }}" class="w-full h-full object-cover">
                    @else
                        <i data-lucide="store" class="w-6 h-6 text-amber-600"></i>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">{{ $comercio->nombre }}</h3>
                    <p class="text-slate-400 text-sm">ID #{{ $comercio->id }} · Propietario: {{ $comercio->user->name ?? '—' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $comercio->nombre) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                    @error('nombre')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition resize-none">{{ old('descripcion', $comercio->descripcion) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $comercio->telefono) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Correo</label>
                    <input type="email" name="email" value="{{ old('email', $comercio->email) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $comercio->direccion) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Logo</label>
                    <div class="flex items-center gap-4">
                        <div id="logo-preview" class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center border-2 border-dashed border-slate-300 overflow-hidden">
                            @if($comercio->logo)
                                <img src="{{ asset('storage/'.$comercio->logo) }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="image" class="w-6 h-6 text-slate-300"></i>
                            @endif
                        </div>
                        <div>
                            <input type="file" name="logo" id="logo-input" accept="image/*" class="hidden">
                            <button type="button" onclick="document.getElementById('logo-input').click()"
                                class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                                <i data-lucide="upload" class="w-4 h-4"></i> Cambiar logo
                            </button>
                            <p class="text-xs text-slate-400 mt-1.5">JPG, PNG o WEBP · máx. 2MB</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="activo" value="1" class="sr-only peer"
                                {{ old('activo', $comercio->activo) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer-checked:bg-brand-600 transition"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-sm font-semibold text-slate-700">Comercio activo</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition">
                <i data-lucide="save" class="w-4 h-4"></i> Guardar cambios
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
        document.getElementById('logo-preview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
