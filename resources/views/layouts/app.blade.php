<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Content Scheduler') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            width: 280px;
            transition: all 0.3s;
        }
        .content {
            margin-left: 280px;
            transition: all 0.3s;
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -280px;
            }
            .content {
                margin-left: 0;
            }
            .sidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        @auth
        <!-- Sidebar -->
        <div class="sidebar fixed inset-y-0 left-0 bg-white shadow-lg">
            <div class="flex items-center justify-center h-16 border-b">
                <h1 class="text-xl font-bold text-gray-800">Content Scheduler</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-home w-5"></i>
                    <span class="mx-3">Dashboard</span>
                </a>
                <a href="{{ route('posts.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-file-alt w-5"></i>
                    <span class="mx-3">Posts</span>
                </a>
                <a href="{{ route('platforms.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-share-alt w-5"></i>
                    <span class="mx-3">Platforms</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="content flex-1">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between h-16 px-6">
                    <button class="text-gray-500 focus:outline-none lg:hidden" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="flex items-center">
                        <div class="relative">
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-gray-900">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
        @else
            @yield('content')
        @endauth
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>
    @stack('scripts')
</body>
</html> 