<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindCare - @yield('title')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Barra de navegación -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-mindcare-blue">
                        MindCare
                    </a>
                </div>
                <!-- Menú desktop -->
                <div class="hidden sm:flex space-x-8">
                    <x-nav-link href="{{ route('diary.index') }}" :active="request()->routeIs('diary.*')">
                        Diario
                    </x-nav-link>
                    <x-nav-link href="{{ route('resources.index') }}" :active="request()->routeIs('resources.*')">
                        Recursos
                    </x-nav-link>
                    <x-nav-link href="{{ route('community.index') }}" :active="request()->routeIs('community.*')">
                        Comunidad
                    </x-nav-link>
                    <x-nav-link href="{{ route('exercises.index') }}" :active="request()->routeIs('exercises.*')">
                        Ejercicios
                    </x-nav-link>
                </div>
                <!-- Menú usuario -->
                <div class="flex items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Avatar de {{Auth::user()->name}}" class="h-8 w-8 rounded-full">
                                @else
                                    <svg class="h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" title="Avatar de {{Auth::user()->name}}">
                                        <path d="M10 2a6 6 0 100 12 6 6 0 000-12zm0 14a8 8 0 00-8 8h16a8 8 0 00-8-8z" />
                                    </svg>
                                @endif
                                <span class="ml-2 text-gray-700">{{ Auth::user()->name }}</span>
                                
                                <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                Perfil
                            </x-dropdown-link>
                            <x-dropdown-link href="#">
                                Configuración
                            </x-dropdown-link>
                            <x-dropdown-link href="#">
                                Ayuda
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-8 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            © 2025 MindCare - Todos los derechos reservados
        </div>
    </footer>
</body>
</html>