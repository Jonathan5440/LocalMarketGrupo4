@extends('layouts.admin')
@section('titulo', 'Dashboard Comerciante')
@section('contenido')
<div class="bg-white p-6 rounded-xl shadow-md">
    <h3 class="text-xl font-bold text-gray-700">Bienvenido, {{ auth()->user()->name }}</h3>
    <p class="text-gray-500 mt-2">Panel del comerciante — próximamente aquí verás tus ventas, productos y pedidos.</p>
</div>

@endsection
