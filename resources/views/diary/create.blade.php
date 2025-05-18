@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-mindcare-blue mb-6">Registra tu día</h2>
    
    <form action="{{ route('diary.store') }}" method="POST">
        @csrf
        
        <!-- Estado de ánimo -->
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">¿Cómo te sientes hoy?</label>
            <div class="flex space-x-4" x-data="{ selectedMood: '' }">
                @foreach(['😊' => 'Feliz', '😐' => 'Neutral', '😢' => 'Triste'] as $emoji => $label)
                    <button 
                        type="button" 
                        @click="selectedMood = '{{ $emoji }}'" 
                        class="text-4xl p-2 rounded-full transition"
                        :class="{ 'bg-mindcare-blue bg-opacity-20': selectedMood === '{{ $emoji }}' }"
                    >
                        {{ $emoji }}
                    </button>
                @endforeach
                <input type="hidden" name="mood" x-model="selectedMood" required>
            </div>
            @error('mood')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nivel de energía -->
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Nivel de energía (1-10)</label>
            <input 
                type="range" 
                name="energy_level" 
                min="1" 
                max="10" 
                value="5" 
                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                required
            >
            <div class="flex justify-between text-xs text-gray-500 mt-1">
                <span>1 (Bajo)</span>
                <span>10 (Alto)</span>
            </div>
        </div>

        <!-- Notas adicionales -->
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Notas (opcional)</label>
            <textarea 
                name="notes" 
                rows="3" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-mindcare-blue"
                placeholder="¿Qué te gustaría destacar de hoy?"
            ></textarea>
        </div>

        <button type="submit" class="w-full btn-primary py-3">Guardar registro</button>
    </form>
</div>
@endsection