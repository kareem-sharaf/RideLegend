<x-main-layout title="Products">
    <div class="bg-white">
        <!-- Header Section - Unified Spacing -->
        <div class="border-b border-neutral-200 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-display font-bold text-black mb-3">Premium Bikes</h1>
                <p class="text-base text-neutral-600">Browse our collection of certified premium bicycles</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <x-filter-panel />
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                    <!-- Sorting Bar - Improved -->
                    <div class="mb-6 flex items-center justify-between border-b border-neutral-200 pb-6">
                        <div class="flex items-center gap-4">
                            <p class="text-sm text-neutral-600">
                                <span class="font-medium text-black">{{ $products->total() }}</span> results
                            </p>
                            <div class="flex items-center gap-3">
                                <label class="text-sm text-neutral-600">Sort by:</label>
                                <select name="sort" onchange="this.form.submit()"
                                    class="text-sm border-none bg-transparent text-black font-medium focus:outline-none cursor-pointer hover:opacity-80 transition-opacity"
                                    form="filter-form">
                                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest
                                    </option>
                                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>
                                        Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>
                                        Price: High to Low</option>
                                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>
                                        Name: A-Z</option>
                                </select>
                            </div>
                        </div>
                    @auth
                        @can('create products')
                                <x-button href="{{ route('products.create') }}" variant="outline" size="sm">
                                List Your Bike
                            </x-button>
                        @endcan
                    @endauth
                </div>

                    @if ($products->isEmpty())
                        <!-- Empty State - Improved -->
                        <div class="text-center py-16">
                            <svg class="w-12 h-12 text-neutral-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <h3 class="text-xl font-display font-semibold text-black mb-3">No products found</h3>
                            <p class="text-base text-neutral-600 mb-6">Try adjusting your filters</p>
                            <x-button href="{{ route('products.index') }}" variant="outline">
                                Clear Filters
                            </x-button>
                        </div>
                @else
                        <!-- Products Grid - 3 Columns -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                        <!-- Pagination - Minimal Design -->
                        @if ($products->hasPages())
                            <div class="mt-10">
                                <x-pagination :paginator="$products" />
                            </div>
                        @endif
                @endif
            </div>
        </div>
    </div>
    </div>

    <!-- Hidden form for sorting -->
    <form id="filter-form" method="GET" action="{{ route('products.index') }}" class="hidden">
        @foreach (request()->except('sort') as $key => $value)
            @if (is_array($value))
                @foreach ($value as $item)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach
    </form>
</x-main-layout>
