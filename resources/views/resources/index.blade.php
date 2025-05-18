@extends('layouts.app', ['title' => 'Recursos Educativos'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-mindcare-blue mb-6">Recursos Educativos</h1>
    
    <!-- Filtros -->
    <div class="flex space-x-2 mb-6">
        @foreach($categories as $cat)
            <a href="?category={{ $cat }}" 
               class="px-4 py-2 rounded-full {{ $category == $cat ? 'bg-mindcare-green text-white' : 'bg-gray-200' }}">
                {{ ucfirst($cat) }}
            </a>
        @endforeach
    </div>

    <!-- Lista -->
    <div class="grid md:grid-cols-2 gap-6">
        @foreach($resources as $resource)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-xl mb-2">{{ $resource->title }}</h3>
                <p class="text-gray-600 mb-4">{{ $resource->type }} • {{ $resource->duration_minutes }} min</p>
                <a href="{{ $resource->content_url }}" target="_blank" class="btn-primary">
                    Ver {{ $resource->type }}
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection