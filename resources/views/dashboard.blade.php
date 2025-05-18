@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-mindcare-blue mb-8">Mi Dashboard</h1>
    
    <!-- Sección superior: Resumen rápido -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Estado de ánimo actual -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-4">Estado de ánimo</h3>
            @if($currentMood)
                <div class="flex items-center justify-between">
                    <span class="text-5xl">{{ $currentMood->mood }}</span>
                    <div>
                        <p class="text-gray-600">Hoy</p>
                        <p class="text-lg">{{ $currentMood->created_at->format('h:i A') }}</p>
                    </div>
                </div>
                @if($currentMood->notes)
                    <p class="mt-4 text-gray-700 italic">"{{ Str::limit($currentMood->notes, 50) }}"</p>
                @endif
            @else
                <p class="text-gray-500 py-4">No hay registro hoy</p>
                <a href="{{ route('diary.create') }}" class="btn-primary inline-block">
                    Registrar mi día
                </a>
            @endif
        </div>
        
        <!-- Ejercicios completados -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-4">Ejercicios</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-gray-600">Hoy</p>
                    <p class="text-2xl font-bold">{{ $exerciseStats['today'] }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Esta semana</p>
                    <p class="text-2xl font-bold">{{ $exerciseStats['week'] }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Favorito</p>
                    <p class="text-xl capitalize">{{ $exerciseStats['favorite'] }}</p>
                </div>
            </div>
        </div>
        
        <!-- Sugerencias -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-4">Sugerencias</h3>
            <div class="space-y-3">
                @foreach($suggestions as $suggestion)
                <div class="p-3 rounded-md 
                    @if($suggestion['type'] === 'alert') bg-red-50 text-red-700 @endif
                    @if($suggestion['type'] === 'warning') bg-yellow-50 text-yellow-700 @endif
                    @if($suggestion['type'] === 'info') bg-blue-50 text-blue-700 @endif
                    @if($suggestion['type'] === 'success') bg-green-50 text-green-700 @endif">
                    <p>{{ $suggestion['message'] }}</p>
                    @if($suggestion['action'])
                        <a href="{{ $suggestion['action'] }}" class="underline mt-1 inline-block">
                            Ver más
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Segunda sección: Gráficos y recursos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Tendencias de estado de ánimo -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-4">Tendencia semanal</h3>
            <canvas id="moodChart" height="200"></canvas>
        </div>
        
        <!-- Recursos recientes -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-4">Recursos vistos</h3>
            @if($recentResources->count() > 0)
                <div class="space-y-4">
                    @foreach($recentResources as $resource)
                    <div class="border-b border-gray-100 pb-4 last:border-0">
                        <h4 class="font-semibold">{{ $resource->title }}</h4>
                        <p class="text-sm text-gray-600">{{ $resource->type }} • {{ $resource->duration_minutes }} min</p>
                        <a href="{{ route('resources.show', $resource) }}" class="text-mindcare-blue text-sm mt-1 inline-block">
                            Volver a ver
                        </a>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 py-4">No has visto recursos recientemente</p>
                <a href="{{ route('resources.index') }}" class="btn-primary inline-block">
                    Explorar recursos
                </a>
            @endif
        </div>
    </div>
    
    <!-- Tercera sección: Acciones rápidas -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="font-bold text-lg mb-4">Acciones rápidas</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('diary.create') }}" class="bg-mindcare-blue bg-opacity-10 p-4 rounded-md text-center hover:bg-opacity-20 transition">
                <span class="block text-3xl mb-2">✏️</span>
                <span>Registrar día</span>
            </a>
            <a href="{{ route('exercises.index', ['type' => 'meditation']) }}" class="bg-mindcare-blue bg-opacity-10 p-4 rounded-md text-center hover:bg-opacity-20 transition">
                <span class="block text-3xl mb-2">🧘</span>
                <span>Meditar</span>
            </a>
            <a href="{{ route('resources.index') }}" class="bg-mindcare-blue bg-opacity-10 p-4 rounded-md text-center hover:bg-opacity-20 transition">
                <span class="block text-3xl mb-2">📚</span>
                <span>Recursos</span>
            </a>
            <a href="{{ route('community.index') }}" class="bg-mindcare-blue bg-opacity-10 p-4 rounded-md text-center hover:bg-opacity-20 transition">
                <span class="block text-3xl mb-2">👥</span>
                <span>Comunidad</span>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de tendencia de ánimo
    const ctx = document.getElementById('moodChart').getContext('2d');
    const moodChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($moodTrend->keys()) !!},
            datasets: [{
                label: 'Estado de ánimo (1-5)',
                data: {!! json_encode($moodTrend->values()) !!},
                backgroundColor: '#A5D8FF',
                borderColor: '#4A90E2',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    min: 1,
                    max: 5,
                    ticks: {
                        callback: function(value) {
                            const moods = ['', '😢', '😞', '😐', '🙂', '😊'];
                            return moods[value];
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection