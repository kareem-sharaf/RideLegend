@props(['product'])

<div class="bg-white rounded-card shadow-card overflow-hidden hover:shadow-card-hover transition-shadow">
    <div class="relative">
        @if($product->getImages()->isNotEmpty())
            @php
                $primaryImage = $product->getImages()->firstWhere('isPrimary', true) 
                    ?? $product->getImages()->first();
            @endphp
            <img 
                src="{{ asset('storage/' . $primaryImage->getPath()) }}" 
                alt="{{ $product->getTitle() }}"
                class="w-full h-48 object-cover"
            >
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-400">No Image</span>
            </div>
        @endif

        @if($product->isCertified())
            <div class="absolute top-2 right-2">
                <x-badge variant="success">Certified</x-badge>
            </div>
        @endif
    </div>

    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
            {{ $product->getTitle() }}
        </h3>
        
        <div class="flex items-center justify-between mb-2">
            <span class="text-2xl font-bold text-primary-800">
                ${{ number_format($product->getPrice()->getAmount(), 2) }}
            </span>
            <x-badge variant="info">{{ $product->getBikeType()->getDisplayName() }}</x-badge>
        </div>

        <div class="text-sm text-gray-600 space-y-1">
            <p><strong>Brand:</strong> {{ $product->getBrand() ?: 'N/A' }}</p>
            <p><strong>Model:</strong> {{ $product->getModel() ?: 'N/A' }}</p>
            @if($product->getYear())
                <p><strong>Year:</strong> {{ $product->getYear() }}</p>
            @endif
        </div>

        <div class="mt-4">
            <x-button href="{{ route('products.show', $product->getId()) }}" variant="primary" class="w-full">
                View Details
            </x-button>
        </div>
    </div>
</div>

