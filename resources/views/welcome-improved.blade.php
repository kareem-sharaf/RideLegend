<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Premium Bikes Marketplace - Buy, sell, and trade premium bicycles with certified inspections and warranties">
    <meta name="keywords" content="premium bikes, bicycles, bike marketplace, bike trading, bike inspection">
    <meta name="author" content="Premium Bikes Marketplace">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Premium Bikes Marketplace">
    <meta property="og:description"
        content="Buy, sell, and trade premium bicycles with certified inspections and warranties">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="Premium Bikes Marketplace">
    <meta property="twitter:description"
        content="Buy, sell, and trade premium bicycles with certified inspections and warranties">

    <title>RideLegend - Premium Bikes Marketplace</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white">
    <!-- Navigation - Minimal & Consistent -->
    <nav class="bg-white border-b border-neutral-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}"
                        class="text-2xl font-display font-bold text-black transition-opacity hover:opacity-80">
                        RideLegend
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('products.index') }}"
                        class="text-sm uppercase tracking-wide text-black hover:underline transition-colors">Bikes</a>
                    <a href="{{ route('about') }}"
                        class="text-sm uppercase tracking-wide text-black hover:underline transition-colors">About</a>
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-sm uppercase tracking-wide text-black hover:underline transition-colors">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-sm uppercase tracking-wide text-black hover:underline transition-colors">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm uppercase tracking-wide text-black hover:underline transition-colors">Login</a>
                        <x-button href="{{ route('register') }}" variant="primary" size="sm">Sign Up</x-button>
                    @endauth
                </div>
                <div class="md:hidden">
                    <button class="text-black" aria-label="Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Unified Spacing -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-6xl md:text-7xl font-display font-bold text-black mb-6 leading-tight">
                    Premium Bikes
                </h1>
                <p class="text-lg text-neutral-600 mb-8 font-sans">
                    Buy, sell, and trade premium bicycles
                </p>
                <div class="flex justify-center">
                    <x-button href="{{ route('products.index') }}" variant="primary" size="lg">
                        Browse Bikes
                    </x-button>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section - Unified Spacing -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-display font-bold text-black text-center mb-16">Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $categories = [
                        [
                            'name' => 'Road Bikes',
                            'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800',
                        ],
                        [
                            'name' => 'Mountain Bikes',
                            'image' => 'https://images.unsplash.com/photo-1571068316344-75bc76f77890?w=800',
                        ],
                        [
                            'name' => 'Electric Bikes',
                            'image' => 'https://images.unsplash.com/photo-1571066811602-716837d681de?w=800',
                        ],
                    ];
                @endphp
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['bike_type' => strtolower(str_replace(' ', '_', $category['name']))]) }}"
                        class="block transition-opacity hover:opacity-90">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}"
                                class="w-full h-full object-cover brightness-75">
                            <div class="absolute bottom-0 left-0 right-0 bg-white px-6 py-5">
                                <h3 class="text-xl font-display font-bold text-black">
                                    {{ $category['name'] }}
                                </h3>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Bikes Section - Unified Spacing -->
    <section class="py-20 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-display font-bold text-black text-center mb-16">Featured Bikes</h2>
            @php
                $productRepository = app(\App\Domain\Product\Repositories\ProductRepositoryInterface::class);
                $featuredProducts = \App\Models\Product::with('images')
                    ->where('status', 'active')
                    ->orderBy('created_at', 'desc')
                    ->limit(6)
                    ->get()
                    ->map(function ($product) use ($productRepository) {
                        return $productRepository->findById($product->id);
                    })
                    ->filter();
            @endphp

            @if ($featuredProducts->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($featuredProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                <div class="text-center mt-12">
                    <x-button href="{{ route('products.index') }}" variant="outline" size="lg">
                        View All Bikes
                    </x-button>
                </div>
            @else
                <div class="text-center py-16">
                    <p class="text-neutral-600">No featured bikes available at the moment.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Trust Section - Improved Icons & Spacing -->
    <section class="py-20 bg-white border-t border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="mb-6 flex justify-center">
                        <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-base text-neutral-600">Certified Inspections</p>
                </div>
                <div class="text-center">
                    <div class="mb-6 flex justify-center">
                        <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-base text-neutral-600">Warranty Protection</p>
                </div>
                <div class="text-center">
                    <div class="mb-6 flex justify-center">
                        <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <p class="text-base text-neutral-600">Trade-In Program</p>
                </div>
                <div class="text-center">
                    <div class="mb-6 flex justify-center">
                        <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-base text-neutral-600">Secure Payments</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section - Unified Spacing -->
    <section class="py-20 bg-neutral-50 border-t border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-display font-bold text-black text-center mb-16">What Our Customers Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $testimonials = [
                        [
                            'text' =>
                                'The inspection process was thorough and professional. I felt confident buying my bike.',
                            'author' => 'Sarah Johnson',
                            'location' => 'New York, NY',
                        ],
                        [
                            'text' => 'Sold my bike quickly and got a fair price. The platform is easy to use.',
                            'author' => 'Michael Chen',
                            'location' => 'Los Angeles, CA',
                        ],
                        [
                            'text' => 'Excellent service from start to finish. Highly recommend!',
                            'author' => 'Emily Rodriguez',
                            'location' => 'Chicago, IL',
                        ],
                    ];
                @endphp
                @foreach ($testimonials as $testimonial)
                    <div class="text-center">
                        <p class="text-base text-neutral-700 mb-6 font-sans leading-relaxed">
                            "{{ $testimonial['text'] }}"
                        </p>
                        <div>
                            <p class="text-sm font-medium text-black">{{ $testimonial['author'] }}</p>
                            <p class="text-sm text-neutral-500 mt-1">{{ $testimonial['location'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer - Improved Spacing -->
    <footer class="bg-white border-t border-neutral-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-lg font-display font-bold text-black mb-6">RideLegend</h3>
                    <p class="text-sm text-neutral-600">Your trusted marketplace for premium bicycles</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-black mb-6 uppercase tracking-wide">For Buyers</h4>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li><a href="{{ route('products.index') }}" class="hover:text-black transition-colors">Browse
                                Bikes</a></li>
                        <li><a href="#" class="hover:text-black transition-colors">How to Buy</a></li>
                        <li><a href="#" class="hover:text-black transition-colors">Warranty Info</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-black mb-6 uppercase tracking-wide">For Sellers</h4>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li><a href="#" class="hover:text-black transition-colors">Sell Your Bike</a></li>
                        <li><a href="#" class="hover:text-black transition-colors">Inspection Process</a></li>
                        <li><a href="#" class="hover:text-black transition-colors">Seller Guide</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-black mb-6 uppercase tracking-wide">Support</h4>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li><a href="#" class="hover:text-black transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-black transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-black transition-colors">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-neutral-200 pt-8 text-center">
                <p class="text-sm text-neutral-500">&copy; {{ date('Y') }} RideLegend. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
