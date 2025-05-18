@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-mindcare-blue mb-8">Hola, {{ Auth::user()->name }} 👋</h1>
    
    <!-- Resumen rápido -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold mb-2">Tu estado hoy</h3>
            <p class="text-4xl">😊</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold mb-2">Ejercicios completados</h3>
            <p class="text-4xl">5</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold mb-2">Recursos vistos</h3>
            <p class="text-4xl">3</p>
        </div>
    </div>

    <!-- Acciones rápidas -->
    <div class="grid md:grid-cols-2 gap-6">
        <a href="{{ route('diary.create') }}" class="bg-mindcare-green text-white p-6 rounded-lg shadow-md hover:bg-opacity-90 transition flex items-center justify-between">
            <span class="text-xl font-bold">Registrar mi día</span>
            <span class="text-3xl">✏️</span>
        </a>
        <a href="{{ route('resources.index') }}" class="bg-mindcare-blue text-white p-6 rounded-lg shadow-md hover:bg-opacity-90 transition flex items-center justify-between">
            <span class="text-xl font-bold">Ver recursos</span>
            <span class="text-3xl">📚</span>
        </a>
    </div>
</div>
@endsection