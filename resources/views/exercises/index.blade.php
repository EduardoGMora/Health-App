@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-mindcare-blue mb-8">Ejercicios de Relajación</h1>
    
    <div class="grid md:grid-cols-3 gap-6">
        <!-- Ejercicio 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h3 class="font-bold text-xl mb-2">Meditación Guiada (5 min)</h3>
                <p class="text-gray-600 mb-4">Para reducir el estrés</p>
                <audio controls class="w-full mt-4">
                    <source src="{{ asset('audio/meditacion-1.mp3') }}" type="audio/mpeg">
                    Tu navegador no soporta audio.
                </audio>
            </div>
        </div>
        
        <!-- Ejercicio 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h3 class="font-bold text-xl mb-2">Respiración 4-7-8</h3>
                <p class="text-gray-600 mb-4">Técnica para la ansiedad</p>
                <div x-data="{ playing: false }" class="mt-4">
                    <button @click="playing = !playing" 
                            class="btn-primary flex items-center">
                        <span x-text="playing ? 'Detener' : 'Comenzar'"></span>
                        <svg x-show="!playing" class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <svg x-show="playing" class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </button>
                    <div x-show="playing" class="mt-4 text-center">
                        <p class="text-2xl font-mono" x-text="'Inhala... 4'"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection