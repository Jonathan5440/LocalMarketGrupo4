@extends('layouts.admin')

@section('titulo', 'Dashboard')
@section('subtitulo', 'Resumen general de LocalMarket')

@section('contenido')

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="tag" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">Catálogo</span>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ $categorias }}</p>
            <p class="text-sm text-slate-500 mt-1">Categorías activas</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="package" class="w-5 h-5 text-emerald-600"></i>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Inventario</span>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ $productos }}</p>
            <p class="text-sm text-slate-500 mt-1">Productos registrados</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="store" class="w-5 h-5 text-blue-600"></i>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Red</span>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ $comercios }}</p>
            <p class="text-sm text-slate-500 mt-1">Comercios afiliados</p>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-orange-500"></i>
                </div>
                <span class="text-xs font-semibold text-orange-500 bg-orange-50 px-2 py-1 rounded-full">Ventas</span>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ $pedidos }}</p>
            <p class="text-sm text-slate-500 mt-1">Pedidos totales</p>
        </div>

    </div>

    {{-- Segunda fila: Gráfica + Pedidos recientes --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-8">

        {{-- Gráfica --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Resumen de la plataforma</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Distribución actual de recursos</p>
                </div>
                <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-slate-500"></i>
                </div>
            </div>
            <canvas id="statsChart" height="100"></canvas>
        </div>

        {{-- Estado rápido --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-base font-semibold text-slate-800">Estado del sistema</h3>
                <span class="flex items-center gap-1.5 text-xs text-emerald-600 font-medium">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                En línea
            </span>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="database" class="w-4 h-4 text-indigo-600"></i>
                        </div>
                        <span class="text-sm text-slate-600 font-medium">Base de datos</span>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">OK</span>
                </div>

                <div class="flex items-center justify-between py-3 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        <span class="text-sm text-slate-600 font-medium">Autenticación</span>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">OK</span>
                </div>

                <div class="flex items-center justify-between py-3 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="mail" class="w-4 h-4 text-orange-500"></i>
                        </div>
                        <span class="text-sm text-slate-600 font-medium">Notificaciones</span>
                    </div>
                    <span class="text-xs font-semibold text-orange-500 bg-orange-50 px-2 py-1 rounded-full">Config</span>
                </div>

                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="zap" class="w-4 h-4 text-purple-600"></i>
                        </div>
                        <span class="text-sm text-slate-600 font-medium">Tiempo real</span>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-2 py-1 rounded-full">Pronto</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Acciones rápidas --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-base font-semibold text-slate-800 mb-5">Acciones rápidas</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('admin.categorias.create') }}"
               class="flex flex-col items-center gap-3 p-5 rounded-xl border-2 border-dashed border-indigo-200 hover:border-indigo-400 hover:bg-indigo-50 transition group">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-200 transition">
                    <i data-lucide="plus" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <span class="text-sm font-medium text-slate-600 text-center">Nueva Categoría</span>
            </a>

            <a href="#"
               class="flex flex-col items-center gap-3 p-5 rounded-xl border-2 border-dashed border-emerald-200 hover:border-emerald-400 hover:bg-emerald-50 transition group">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center group-hover:bg-emerald-200 transition">
                    <i data-lucide="package-plus" class="w-5 h-5 text-emerald-600"></i>
                </div>
                <span class="text-sm font-medium text-slate-600 text-center">Nuevo Producto</span>
            </a>

            <a href="#"
               class="flex flex-col items-center gap-3 p-5 rounded-xl border-2 border-dashed border-blue-200 hover:border-blue-400 hover:bg-blue-50 transition group">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition">
                    <i data-lucide="store" class="w-5 h-5 text-blue-600"></i>
                </div>
                <span class="text-sm font-medium text-slate-600 text-center">Ver Comercios</span>
            </a>

            <a href="#"
               class="flex flex-col items-center gap-3 p-5 rounded-xl border-2 border-dashed border-orange-200 hover:border-orange-400 hover:bg-orange-50 transition group">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center group-hover:bg-orange-200 transition">
                    <i data-lucide="clipboard-list" class="w-5 h-5 text-orange-500"></i>
                </div>
                <span class="text-sm font-medium text-slate-600 text-center">Ver Pedidos</span>
            </a>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const ctx = document.getElementById('statsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Categorías', 'Productos', 'Comercios', 'Pedidos'],
                datasets: [{
                    label: 'Total registros',
                    data: [{{ $categorias }}, {{ $productos }}, {{ $comercios }}, {{ $pedidos }}],
                    backgroundColor: ['#e0e7ff','#d1fae5','#dbeafe','#fed7aa'],
                    borderColor:     ['#6366f1','#10b981','#3b82f6','#f97316'],
                    borderWidth: 2,
                    borderRadius: 10,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#f1f5f9',
                        padding: 12,
                        cornerRadius: 10,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { color: '#94a3b8', font: { size: 12 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 13, weight: '500' } }
                    }
                }
            }
        });
    </script>
@endsection
