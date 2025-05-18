@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-mindcare-blue mb-6">Editar Perfil</h2>

    @if (session('success'))
        <div class="bg-mindcare-green text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Nombre -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nombre</label>
            <input 
                type="text" 
                name="name" 
                value="{{ old('name', $user->name) }}" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-mindcare-blue"
                required
            >
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Avatar -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Foto de perfil</label>
            <input 
                type="file" 
                name="avatar" 
                class="w-full px-3 py-2 border rounded-md"
            >
            @if($user->avatar)
                <img src="{{ asset('storage/avatars/'.$user->avatar) }}" 
                    alt="Avatar" 
                    class="h-20 w-20 rounded-full">
            @endif
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email', $user->email) }}" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-mindcare-blue"
                required
            >
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Contraseña (Opcional) -->
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Nueva contraseña (dejar en blanco para no cambiar)</label>
            <input 
                type="password" 
                name="password" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-mindcare-blue"
            >
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Confirmar contraseña</label>
            <input 
                type="password" 
                name="password_confirmation" 
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-mindcare-blue"
            >
        </div>

        <button type="submit" class="w-full btn-primary py-2">Guardar cambios</button>
    </form>
</div>
@endsection