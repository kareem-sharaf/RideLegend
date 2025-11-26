<x-main-layout title="Page Not Found">
    <div class="min-h-screen flex items-center justify-center bg-white">
        <div class="text-center max-w-2xl mx-auto px-4">
            <h1 class="text-9xl font-display font-bold text-black mb-4">404</h1>
            <h2 class="text-3xl font-display font-semibold text-black mb-4">Page Not Found</h2>
            <p class="text-neutral-600 mb-8 text-lg">The page you're looking for doesn't exist or has been moved.</p>
            <div class="flex justify-center gap-4">
                <x-button href="{{ route('home') }}" variant="primary" size="lg">
                    Go Home
                </x-button>
                <x-button href="{{ route('products.index') }}" variant="outline" size="lg">
                    Browse Bikes
                </x-button>
            </div>
        </div>
    </div>
</x-main-layout>
