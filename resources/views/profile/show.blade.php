@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">

    @if (session('success'))
        <div class="bg-mindcare-green text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif
    <!-- Sección de Información del Usuario -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                @if($user->avatar)
                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" 
                         alt="Avatar de {{ $user->name }}"
                         class="h-32 w-32 rounded-full object-cover border-4 border-mindcare-blue">
                @else
                    <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg class="h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Datos del Usuario -->
            <div class="text-center md:text-left">
                <h1 class="text-3xl font-bold text-mindcare-blue">{{ $user->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $user->email }}</p>
                
                <div class="flex justify-center md:justify-start gap-4">
                    <a href="{{ route('profile.edit') }}" 
                       class="btn-primary px-6 py-2">
                        Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Posts/Registros -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-mindcare-blue mb-6">Mis Registros Recientes</h2>
        
        @if($posts->count() > 0)
            <div class="space-y-4">
                @foreach($posts as $post)
                    <div class="border-b border-gray-100 pb-4 last:border-0">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-lg font-semibold">{{ $post->created_at->format('d M Y') }}</span>
                            <span class="text-2xl">{{ $post->mood }}</span>
                        </div>
                        @if($post->notes)
                            <p class="text-gray-700 whitespace-pre-line">{{ $post->notes }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">Aún no has hecho ningún registro.</p>
                <a href="{{ route('diary.create') }}" class="btn-primary inline-block mt-4">
                    Crear mi primer registro
                </a>
            </div>
        @endif
    </div>
</div>
@endsection