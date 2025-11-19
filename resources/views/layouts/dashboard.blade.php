<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - Premium Bikes Marketplace</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-sm">
            <div class="p-6">
                <h2 class="text-xl font-bold text-primary-800">Premium Bikes</h2>
            </div>
            <nav class="px-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                            Dashboard
                        </a>
                    </li>
                    @can('view products')
                        <li>
                            <a href="{{ route('products.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                Products
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('profile.*') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                            Profile
                        </a>
                    </li>
                    @role('admin')
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                Admin Panel
                            </a>
                        </li>
                    @endrole
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ auth()->user()->email }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-button type="submit" variant="ghost" size="sm">Logout</x-button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>

