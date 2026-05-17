@extends('layouts.admin')
@section('titulo', $comercio->nombre)
@section('subtitulo', 'Detalle del comercio')
@section('contenido')

<div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
    <a href="{{ route('admin.comercios.index') }}" class="hover:text-brand-600 transition">Comercios</a>
    <i data-lucide="chevron-right" class="w-4 h-4"></i>
    <span class="text-slate-600 font-medium">{{ $comercio->nombre }}</span>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Info principal --}}
    <div class="xl:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-brand-100 overflow-hidden flex items-center justify-center">
                    @if($comercio->logo)
                        <img src="{{ asset('storage/'.$comercio->logo) }}" class="w-full h-full object-cover">
                    @else
                        <i data-lucide="store" class="w-8 h-8 text-brand-600"></i>
                    @endif
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $comercio->nombre }}</h3>
                    <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $comercio->activo ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ $comercio->activo ? '✓ Activo' : '✗ Inactivo' }}
                    </span>
                </div>
                <div class="ml-auto">
                    <a href="{{ route('admin.comercios.edit', $comercio) }}"
                       class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                        <i data-lucide="pencil" class="w-4 h-4"></i> Editar
                    </a>
                </div>
            </div>

            <p class="text-slate-500 text-sm mb-6">{{ $comercio->descripcion ?? 'Sin descripción.' }}</p>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Teléfono</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $comercio->telefono ?? '—' }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Correo</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $comercio->email ?? '—' }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 col-span-2">
                    <p class="text-xs text-slate-400 mb-1">Dirección</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $comercio->direccion ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- Productos --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h4 class="text-base font-bold text-slate-800 mb-4">Productos ({{ $comercio->productos->count() }})</h4>
            @forelse($comercio->productos->take(5) as $producto)
            <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
                <div>
                    <p class="text-sm font-semibold text-slate-700">{{ $producto->nombre }}</p>
                    <p class="text-xs text-slate-400">Stock: {{ $producto->stock }}</p>
                </div>
                <span class="text-sm font-bold text-brand-600">Q{{ number_format($producto->precio, 2) }}</span>
            </div>
            @empty
            <p class="text-sm text-slate-400 py-4 text-center">Sin productos registrados</p>
            @endforelse
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Stats --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h4 class="text-base font-bold text-slate-800 mb-4">Estadísticas</h4>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">Productos</span>
                    <span class="text-sm font-bold text-slate-800">{{ $comercio->productos->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">Pedidos</span>
                    <span class="text-sm font-bold text-slate-800">{{ $comercio->pedidos->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">Registrado</span>
                    <span class="text-sm font-bold text-slate-800">{{ $comercio->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Propietario --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h4 class="text-base font-bold text-slate-800 mb-4">Propietario</h4>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center text-brand-700 font-bold">
                    {{ strtoupper(substr($comercio->user->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">{{ $comercio->user->name ?? '—' }}</p>
                    <p class="text-xs text-slate-400">{{ $comercio->user->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
