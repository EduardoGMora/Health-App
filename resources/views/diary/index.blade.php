@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-mindcare-blue">Mi Diario Emocional</h1>
        <a href="{{ route('diary.create') }}" class="btn-primary flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Nuevo Registro
        </a>
    </div>

    @if (session('success'))
        <div class="bg-mindcare-green text-white p-4 rounded-md mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Lista de registros -->
    <div class="space-y-4">
        @forelse ($entries as $entry)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-4">
                        <span class="text-4xl">{{ $entry->mood }}</span>
                        <div>
                            <h3 class="font-bold text-lg">
                                {{ $entry->created_at->format('d M Y') }}
                            </h3>
                            <p class="text-gray-600">
                                Nivel de energía: {{ $entry->energy_level }}/10
                            </p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">
                        {{ $entry->created_at->diffForHumans() }}
                    </span>
                </div>
                @if ($entry->notes)
                    <div class="mt-4 p-4 bg-gray-50 rounded-md">
                        <p class="whitespace-pre-line">{{ $entry->notes }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <p class="text-gray-500">No hay registros aún. ¡Comienza a registrar tus emociones!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection