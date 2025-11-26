@props(['title'])

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
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Dashboard
                            </span>
                        </a>
                    </li>

                    @if (auth()->user()->role === 'buyer')
                        <li>
                            <a href="{{ route('products.index') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('products.*') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Browse Products
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('cart.*') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Cart
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('orders.*') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    My Orders
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('trade-in.index') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('trade-in.*') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                    Trade-In
                                </span>
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'seller')
                        <li>
                            <a href="{{ route('products.create') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('products.create') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    List Product
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.index') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('products.*') && !request()->routeIs('products.create') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    My Products
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('orders.*') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Sales Orders
                                </span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('profile.show') }}"
                            class="block px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('profile.*') ? 'bg-primary-50 text-primary-800' : 'text-gray-700' }}">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile
                            </span>
                        </a>
                    </li>

                    @role('admin')
                        <li class="pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                    Admin Panel
                                </span>
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
