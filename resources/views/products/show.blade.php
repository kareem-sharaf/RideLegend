@php
    $product = $product ?? null;
    if (!$product) {
        abort(404);
    }

    // Get seller info
    $seller = $product->getSellerId() ? \App\Models\User::find($product->getSellerId()) : null;

    // Get related products
    $productRepository = app(\App\Domain\Product\Repositories\ProductRepositoryInterface::class);
    $relatedProducts = \App\Models\Product::with('images')
        ->where('status', 'active')
        ->where('id', '!=', $product->getId())
        ->where(function ($query) use ($product) {
            if ($product->getCategoryId()) {
                $query->where('category_id', $product->getCategoryId());
            } else {
                $query->where('bike_type', $product->getBikeType()->toString());
            }
        })
        ->limit(4)
        ->get()
        ->map(function ($p) use ($productRepository) {
            return $productRepository->findById($p->id);
        })
        ->filter();
@endphp

<x-main-layout title="{{ $product->getTitle() }}">
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-20">
                <!-- Image Gallery -->
                <div>
                    <x-image-gallery :images="$product->getImages()" :productId="$product->getId()" />
                </div>

                <!-- Product Info -->
                <div class="space-y-8">
                    <!-- Title - Large Playfair -->
                    <div>
                        <h1 class="text-5xl md:text-6xl font-display font-bold text-black mb-4 leading-tight">
                            {{ $product->getTitle() }}
                        </h1>
                        <div class="flex items-center gap-3">
                            @if ($product->isCertified())
                                <span
                                    class="bg-black text-white px-3 py-1 text-xs uppercase tracking-wide">Certified</span>
                            @endif
                            <span
                                class="text-sm text-neutral-500 uppercase tracking-wide">{{ $product->getBikeType()->getDisplayName() }}</span>
                        </div>
                    </div>

                    <!-- Price - Huge -->
                    <div>
                        <p class="text-6xl font-bold text-black">
                            ${{ number_format($product->getPrice()->getAmount(), 2) }}
                        </p>
                    </div>

                    <!-- CTA Button -->
                    <div>
                        <form action="{{ route('cart.store') }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->getId() }}">
                            <input type="hidden" name="quantity" value="1">
                            <x-button type="submit" variant="primary" size="lg" class="w-full">
                                Add to Basket
                            </x-button>
                        </form>
                    </div>

                    <!-- Specifications Table - Simple -->
                    <div class="border-t border-neutral-200 pt-8">
                        <h2 class="text-lg font-semibold text-black mb-6 uppercase tracking-wide">Specifications</h2>
                        <table class="w-full">
                            <tbody class="divide-y divide-neutral-200">
                                <tr>
                                    <td class="py-3 text-sm text-neutral-600">Bike Type</td>
                                    <td class="py-3 text-sm text-black font-medium text-right">
                                        {{ $product->getBikeType()->getDisplayName() }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-sm text-neutral-600">Frame Material</td>
                                    <td class="py-3 text-sm text-black font-medium text-right">
                                        {{ $product->getFrameMaterial()->getDisplayName() }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-sm text-neutral-600">Brake Type</td>
                                    <td class="py-3 text-sm text-black font-medium text-right">
                                        {{ $product->getBrakeType()->getDisplayName() }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-sm text-neutral-600">Wheel Size</td>
                                    <td class="py-3 text-sm text-black font-medium text-right">
                                        {{ $product->getWheelSize() }}</td>
                                </tr>
                                @if ($product->getWeight())
                                    <tr>
                                        <td class="py-3 text-sm text-neutral-600">Weight</td>
                                        <td class="py-3 text-sm text-black font-medium text-right">
                                            {{ $product->getWeight()->getValue() }}
                                            {{ $product->getWeight()->getUnit() }}</td>
                                    </tr>
                                @endif
                                @if ($product->getBrand())
                                    <tr>
                                        <td class="py-3 text-sm text-neutral-600">Brand</td>
                                        <td class="py-3 text-sm text-black font-medium text-right">
                                            {{ $product->getBrand() }}</td>
                                    </tr>
                                @endif
                                @if ($product->getModel())
                                    <tr>
                                        <td class="py-3 text-sm text-neutral-600">Model</td>
                                        <td class="py-3 text-sm text-black font-medium text-right">
                                            {{ $product->getModel() }}</td>
                                    </tr>
                                @endif
                                @if ($product->getYear())
                                    <tr>
                                        <td class="py-3 text-sm text-neutral-600">Year</td>
                                        <td class="py-3 text-sm text-black font-medium text-right">
                                            {{ $product->getYear() }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Seller Info - Simple Card -->
                    @if ($seller)
                        <div class="border border-neutral-200 p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-light rounded-full flex items-center justify-center">
                                    <span
                                        class="text-black font-semibold">{{ substr($seller->first_name ?? 'U', 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-black mb-1">{{ $seller->first_name }}
                                        {{ $seller->last_name }}</h3>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <span class="text-sm text-neutral-600">4.8 (12 reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if ($product->getDescription())
                <div class="border-t border-neutral-200 pt-12 mb-20">
                    <h2 class="text-2xl font-display font-bold text-black mb-6">Description</h2>
                    <div class="prose max-w-none">
                        <p class="text-neutral-700 leading-relaxed whitespace-pre-line">
                            {{ $product->getDescription() }}</p>
                    </div>
                </div>
            @endif

            <!-- Why Buy From Us Section -->
            <div class="border-t border-neutral-200 pt-12 mb-20">
                <h2 class="text-2xl font-display font-bold text-black mb-8">Why Buy From Us?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-2">Certified Inspections</h3>
                        <p class="text-sm text-neutral-600">All bikes undergo professional inspection by certified
                            mechanics</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-2">Warranty Protection</h3>
                        <p class="text-sm text-neutral-600">Comprehensive warranty options to protect your investment
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-2">Secure Payments</h3>
                        <p class="text-sm text-neutral-600">Safe and secure transactions with buyer protection</p>
                    </div>
                </div>
            </div>

            <!-- Related Items -->
            @if ($relatedProducts->isNotEmpty())
                <div class="border-t border-neutral-200 pt-12">
                    <h2 class="text-2xl font-display font-bold text-black mb-8">Related Items</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach ($relatedProducts as $relatedProduct)
                            <x-product-card :product="$relatedProduct" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-main-layout>
