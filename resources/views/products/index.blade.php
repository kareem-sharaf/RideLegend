<x-main-layout title="Products">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Premium Bikes</h1>
            <p class="text-gray-600">Browse our collection of certified premium bicycles</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <x-filter-panel />
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <p class="text-gray-600">
                        Showing {{ $products->count() }} products
                    </p>
                    @auth
                        @can('create products')
                            <x-button href="{{ route('products.create') }}" variant="primary">
                                List Your Bike
                            </x-button>
                        @endcan
                    @endauth
                </div>

                @if($products->isEmpty())
                    <x-card>
                        <div class="text-center py-12">
                            <p class="text-gray-600 mb-4">No products found</p>
                            <x-button href="{{ route('products.index') }}" variant="secondary">
                                Clear Filters
                            </x-button>
                        </div>
                    </x-card>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-main-layout>

