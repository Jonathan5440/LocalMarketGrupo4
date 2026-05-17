@extends('layouts.admin')
@section('titulo', 'Comercios')
@section('subtitulo', 'Gestión de comercios afiliados')
@section('contenido')

<div class="flex items-center justify-between mb-6">
    <div>
        <h3 class="text-xl font-bold text-slate-800">Comercios</h3>
        <p class="text-slate-400 text-sm mt-0.5">{{ $comercios->total() }} comercios registrados</p>
    </div>
    <a href="{{ route('admin.comercios.create') }}"
       class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">
        <i data-lucide="plus" class="w-4 h-4"></i> Nuevo comercio
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-100">
                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">#</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">Comercio</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">Propietario</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">Contacto</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">Estado</th>
                <th class="text-right text-xs font-semibold text-slate-400 uppercase tracking-wider px-6 py-4">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($comercios as $comercio)
            <tr class="hover:bg-slate-50/70 transition">
                <td class="px-6 py-4">
                    <span class="text-xs font-mono text-slate-400 bg-slate-100 px-2 py-1 rounded-lg">{{ $comercio->id }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                            @if($comercio->logo)
                                <img src="{{ asset('storage/'.$comercio->logo) }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="store" class="w-5 h-5 text-brand-600"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $comercio->nombre }}</p>
                            <p class="text-xs text-slate-400">{{ Str::limit($comercio->descripcion, 40) }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-slate-700">{{ $comercio->user->name ?? '—' }}</p>
                    <p class="text-xs text-slate-400">{{ $comercio->user->email ?? '' }}</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm text-slate-600">{{ $comercio->telefono ?? '—' }}</p>
                    <p class="text-xs text-slate-400">{{ $comercio->direccion ?? '' }}</p>
                </td>
                <td class="px-6 py-4">
                    <form action="{{ route('admin.comercios.toggle', $comercio) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-full transition
                            {{ $comercio->activo
                                ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200'
                                : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                            {{ $comercio->activo ? '✓ Activo' : '✗ Inactivo' }}
                        </button>
                    </form>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.comercios.show', $comercio) }}"
                           class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Ver
                        </a>
                        <a href="{{ route('admin.comercios.edit', $comercio) }}"
                           class="flex items-center gap-1.5 text-xs font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition">
                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Editar
                        </a>
                        <form action="{{ route('admin.comercios.destroy', $comercio) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
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
                <td colspan="6" class="px-6 py-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center">
                            <i data-lucide="store" class="w-7 h-7 text-slate-300"></i>
                        </div>
                        <p class="text-slate-400 font-medium">No hay comercios registrados</p>
                        <a href="{{ route('admin.comercios.create') }}" class="text-sm text-brand-600 font-semibold hover:underline">
                            Registrar primer comercio
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($comercios->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $comercios->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', e => {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar comercio?',
            text: 'Se eliminarán también sus productos y datos asociados.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});
</script>
@endsection
