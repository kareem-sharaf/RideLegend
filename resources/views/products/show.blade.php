@php
    $product = $product ?? null;
    if (!$product) {
        abort(404);
    }
@endphp

<x-main-layout title="{{ $product->getTitle() }}">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image Gallery -->
            <div>
                <x-image-gallery :images="$product->getImages()" :productId="$product->getId()" />
            </div>

            <!-- Product Details -->
            <div>
                <div class="mb-4">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $product->getTitle() }}
                    </h1>
                    @if($product->isCertified())
                        <x-badge variant="success" size="lg">Certified</x-badge>
                    @endif
                </div>

                <div class="mb-6">
                    <p class="text-4xl font-bold text-primary-800 mb-4">
                        ${{ number_format($product->getPrice()->getAmount(), 2) }}
                    </p>
                </div>

                <!-- Specifications -->
                <x-card class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Specifications</h2>
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Bike Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->getBikeType()->getDisplayName() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Frame Material</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->getFrameMaterial()->getDisplayName() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Brake Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->getBrakeType()->getDisplayName() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Wheel Size</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->getWheelSize() }}</dd>
                        </div>
                        @if($product->getWeight())
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Weight</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->getWeight() }}</dd>
                            </div>
                        @endif
                        @if($product->getBrand())
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Brand</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->getBrand() }}</dd>
                            </div>
                        @endif
                        @if($product->getModel())
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Model</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->getModel() }}</dd>
                            </div>
                        @endif
                        @if($product->getYear())
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Year</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->getYear() }}</dd>
                            </div>
                        @endif
                    </dl>
                </x-card>

                <!-- Description -->
                <x-card class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $product->getDescription() }}</p>
                </x-card>

                <!-- Certification Report -->
                @if($product->isCertified())
                    <x-card class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Certification</h2>
                        <p class="text-gray-700 mb-4">This product has been certified by our inspection team.</p>
                        <x-button href="#" variant="primary">View Certification Report</x-button>
                    </x-card>
                @endif

                <!-- Actions -->
                <div class="flex space-x-4">
                    <x-button variant="primary" size="lg" class="flex-1">Add to Cart</x-button>
                    <x-button variant="secondary" size="lg">Contact Seller</x-button>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>

