<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Premium Bikes Marketplace - Buy, sell, and trade premium bicycles with certified inspections and warranties">
    <meta name="keywords" content="premium bikes, bicycles, bike marketplace, bike trading, bike inspection">
    <meta name="author" content="Premium Bikes Marketplace">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Premium Bikes Marketplace">
    <meta property="og:description" content="Buy, sell, and trade premium bicycles with certified inspections and warranties">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="Premium Bikes Marketplace">
    <meta property="twitter:description" content="Buy, sell, and trade premium bicycles with certified inspections and warranties">

    <title>Premium Bikes Marketplace - Buy, Sell & Trade Premium Bicycles</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-primary-800">Premium Bikes</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-primary-600">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-primary-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-600 to-primary-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl font-bold mb-6">Premium Bikes Marketplace</h1>
            <p class="text-xl mb-8 text-primary-100">Buy, sell, and trade premium bicycles with certified inspections and warranties</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('products.index') }}" class="px-8 py-3 bg-white text-primary-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Browse Bikes
                </a>
                <a href="{{ route('register') }}" class="px-8 py-3 bg-primary-500 text-white rounded-lg font-semibold hover:bg-primary-400 transition">
                    Get Started
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">Why Choose Premium Bikes?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900">Certified Inspections</h3>
                    <p class="text-gray-600">All bikes undergo professional inspection by certified mechanics before listing</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900">Warranty Protection</h3>
                    <p class="text-gray-600">Comprehensive warranty options to protect your investment</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-900">Trade-In Program</h3>
                    <p class="text-gray-600">Trade your old bike and get credit towards your next purchase</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">List Your Bike</h3>
                    <p class="text-gray-600">Create a listing with photos and details</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Get Inspected</h3>
                    <p class="text-gray-600">Professional inspection by certified mechanics</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Get Certified</h3>
                    <p class="text-gray-600">Receive certification report and listing approval</p>
                </div>
        <div class="text-center">
                    <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">4</div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Sell & Ship</h3>
                    <p class="text-gray-600">Complete sale and ship securely</p>
                </div>
        </div>
    </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-primary-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-xl mb-8 text-primary-100">Join thousands of cyclists buying and selling premium bikes</p>
            <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-primary-600 rounded-lg font-semibold hover:bg-gray-100 transition inline-block">
                Create Your Account
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">Premium Bikes</h3>
                    <p class="text-sm">Your trusted marketplace for premium bicycles</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">For Buyers</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white">Browse Bikes</a></li>
                        <li><a href="#" class="hover:text-white">How to Buy</a></li>
                        <li><a href="#" class="hover:text-white">Warranty Info</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">For Sellers</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Sell Your Bike</a></li>
                        <li><a href="#" class="hover:text-white">Inspection Process</a></li>
                        <li><a href="#" class="hover:text-white">Seller Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                        <li><a href="#" class="hover:text-white">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Premium Bikes Marketplace. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
