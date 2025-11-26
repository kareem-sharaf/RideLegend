@props(['product'])

<a href="{{ route('products.show', $product->getId()) }}" class="block transition-opacity hover:opacity-90">
    <div class="bg-white border border-neutral-200 overflow-hidden">
        <!-- Image Section - Larger -->
        <div class="relative aspect-[3/2] overflow-hidden bg-neutral-50">
            @if ($product->getImages()->isNotEmpty())
                @php
                    $primaryImage =
                        $product->getImages()->firstWhere('isPrimary', true) ?? $product->getImages()->first();
                    $imagePath = $primaryImage->getPath();
                    $imageUrl = file_exists(storage_path('app/public/' . $imagePath))
                        ? asset('storage/' . $imagePath)
                        : 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop';
                @endphp
                <img src="{{ $imageUrl }}" alt="{{ $product->getTitle() }}" class="w-full h-full object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop"
                    alt="{{ $product->getTitle() }}" class="w-full h-full object-cover">
            @endif

            @if ($product->isCertified())
                <div class="absolute top-4 right-4">
                    <span class="bg-black text-white px-3 py-1 text-xs uppercase tracking-wide">Certified</span>
                </div>
            @endif
        </div>

        <!-- Content Section -->
        <div class="p-8">
            <!-- Price - 25% Larger -->
            <div class="mb-4">
                <span class="text-4xl font-bold text-black">
                    ${{ number_format($product->getPrice()->getAmount(), 2) }}
                </span>
            </div>

            <!-- Title -->
            <h3 class="text-lg font-medium text-black mb-4">
                {{ $product->getTitle() }}
            </h3>

            <!-- Specifications - Minimal (One Line Only) -->
            <div class="text-sm text-neutral-600">
                @if ($product->getYear() && $product->getBikeType())
                    <p>{{ $product->getYear() }} • {{ $product->getBikeType()->getDisplayName() }}</p>
                @elseif ($product->getBikeType())
                    <p>{{ $product->getBikeType()->getDisplayName() }}</p>
                @endif
            </div>
        </div>
    </div>
</a>
