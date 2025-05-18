@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-mindcare-blue mb-6">Comunidad</h1>
    <!-- Formulario nuevo post -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <form action="{{ route('community.store') }}" method="POST">
            @csrf
            <input type="text" name="title" placeholder="Título" class="w-full p-2 mb-4 border rounded">
            <textarea name="body" rows="3" class="w-full p-2 mb-4 border rounded" placeholder="¿Qué quieres compartir?"></textarea>
            <div class="flex justify-between">
                <select name="category" class="p-2 border rounded">
                    <option value="#Ansiedad">#Ansiedad</option>
                    <option value="#Depresión">#Depresión</option>
                </select>
                <label class="flex items-center">
                    <input type="checkbox" name="anonymous" class="mr-2"> Publicar como anónimo
                </label>
                <button type="submit" class="btn-primary">Publicar</button>
            </div>
        </form>
    </div>

    <!-- Lista de posts -->
    @foreach($posts as $post)
        <div class="bg-white p-6 rounded-lg shadow-md mb-4">
            <div class="flex items-center mb-2">
                <span class="font-bold">{{ $post->username }}</span>
                <span class="ml-4 text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
            <p class="mt-2">{{ $post->body }}</p>
            <span class="inline-block mt-4 px-3 py-1 bg-mindcare-blue text-white rounded-full text-sm">
                {{ $post->category }}
            </span>
        </div>
    @endforeach

    {{ $posts->links() }} <!-- Paginación -->
</div>
@endsection