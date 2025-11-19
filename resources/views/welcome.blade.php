<x-main-layout title="Welcome">
    <div class="container mx-auto px-4 py-16">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Premium Bikes Marketplace</h1>
            <p class="text-xl text-gray-600 mb-8">Your trusted marketplace for premium bicycles</p>
            <div class="flex justify-center space-x-4">
                <x-button href="{{ route('register') }}" variant="primary" size="lg">Get Started</x-button>
                <x-button href="{{ route('login') }}" variant="secondary" size="lg">Sign In</x-button>
                </div>
        </div>
    </div>
</x-main-layout>
