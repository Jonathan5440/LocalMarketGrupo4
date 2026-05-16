@extends('layouts.admin')

@section('titulo', 'Nueva Categoría')
@section('subtitulo', 'Agregar una nueva categoría al catálogo')

@section('contenido')

    <div class="max-w-2xl">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
            <a href="{{ route('admin.categorias.index') }}" class="hover:text-brand-600 transition">Categorías</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-slate-600 font-medium">Nueva categoría</span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">

            <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 bg-brand-100 rounded-2xl flex items-center justify-center">
                    <i data-lucide="tag" class="w-6 h-6 text-brand-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Nueva categoría</h3>
                    <p class="text-slate-400 text-sm">Completa los campos para crear la categoría</p>
                </div>
            </div>

            <form action="{{ route('admin.categorias.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nombre --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           placeholder="Ej: Frutas y Verduras"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300
                           focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition
                           @error('nombre') border-red-400 bg-red-50 @enderror">
                    @error('nombre')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Icono --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Icono (emoji)</label>
                    <div class="flex items-center gap-3">
                        <div id="preview-icono" class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center text-2xl border-2 border-dashed border-brand-200">
                            {{ old('icono') ?? '🏷️' }}
                        </div>
                        <input type="text" name="icono" id="input-icono" value="{{ old('icono') }}"
                               placeholder="Ej: 🥦 🍞 🥩"
                               class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300
                               focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                    </div>
                    <p class="mt-1.5 text-xs text-slate-400">Puedes copiar un emoji y pegarlo aquí</p>
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Descripción</label>
                    <textarea name="descripcion" rows="3"
                              placeholder="Describe brevemente esta categoría..."
                              class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-300
                           focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition resize-none">{{ old('descripcion') }}</textarea>
                </div>

                {{-- Botones --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-6 py-3 rounded-xl transition shadow-sm">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Guardar categoría
                    </button>
                    <a href="{{ route('admin.categorias.index') }}"
                       class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm px-6 py-3 rounded-xl transition">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const input = document.getElementById('input-icono');
        const preview = document.getElementById('preview-icono');
        input.addEventListener('input', () => {
            preview.textContent = input.value || '🏷️';
        });
    </script>
@endsection
