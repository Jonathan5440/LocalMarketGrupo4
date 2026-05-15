@extends('layouts.admin')
@section('titulo', 'Tienda LocalMarket')
@section('contenido')
<div class="bg-white p-6 rounded-xl shadow-md">
    <h3 class="text-xl font-bold text-gray-700">Bienvenido, {{ auth()->user()->name }}</h3>
    <p class="text-gray-500 mt-2">Catálogo de productos — próximamente aquí verás todos los productos disponibles.</p>
</div>
@endsection
