@extends('layouts.admin')

@section('titulo', 'Categorías')
@section('subtitulo', 'Gestión de categorías del catálogo')

@section('contenido')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Categorías</h3>
            <p class="text-slate-400 text-sm mt-0.5">{{ $categorias->total() }} categorías registradas</p>
        </div>
        <a href="{{ route('admin.categorias.create') }}"
           class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-sm shadow-brand-200">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva categoría
        </a>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full">
            <thead>
            <tr class="bg-slate-50 border-b border-slate-100">
                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4 w-16">#</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4 w-20">Icono</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">Nombre</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">Descripción</th>
                <th class="text-right text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($categorias as $categoria)
                <tr class="hover:bg-slate-50/70 transition group">
                    <td class="px-6 py-4">
                        <span class="text-xs font-mono text-slate-400 bg-slate-100 px-2 py-1 rounded-lg">{{ $categoria->id }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center text-xl">
                            {{ $categoria->icono ?? '🏷️' }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm font-semibold text-slate-800">{{ $categoria->nombre }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-500 truncate max-w-xs">{{ $categoria->descripcion ?? '—' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.categorias.edit', $categoria) }}"
                               class="flex items-center gap-1.5 text-xs font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition">
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Editar
                            </a>

                            <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                                <i data-lucide="tag" class="w-7 h-7 text-slate-300"></i>
                            </div>
                            <p class="text-slate-400 font-medium">No hay categorías registradas</p>
                            <a href="{{ route('admin.categorias.create') }}" class="text-sm text-brand-600 font-semibold hover:underline">
                                Crear primera categoría
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Paginación --}}
        @if($categorias->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                <p class="text-sm text-slate-400">
                    Mostrando {{ $categorias->firstItem() }}–{{ $categorias->lastItem() }} de {{ $categorias->total() }}
                </p>
                {{ $categorias->links() }}
            </div>
        @endif
    </div>

@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar categoría?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    borderRadius: '16px',
                }).then(result => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
@endsection
