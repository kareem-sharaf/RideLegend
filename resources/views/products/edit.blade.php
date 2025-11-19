@php
    $product = $product ?? null;
    if (!$product) {
        abort(404);
    }
@endphp

<x-dashboard-layout title="Edit Product">
    <div class="max-w-4xl mx-auto">
        <x-card>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Product</h2>

            <form method="POST" action="{{ route('products.update', $product->getId()) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <x-form-input
                    label="Title"
                    name="title"
                    type="text"
                    value="{{ old('title', $product->getTitle()->toString()) }}"
                />

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea 
                        name="description" 
                        rows="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                    >{{ old('description', $product->getDescription()) }}</textarea>
                </div>

                <x-form-input
                    label="Price ($)"
                    name="price"
                    type="number"
                    step="0.01"
                    value="{{ old('price', $product->getPrice()->getAmount()) }}"
                />

                <div class="flex space-x-4">
                    <x-button type="submit" variant="primary">Update Product</x-button>
                    <x-button href="{{ route('products.show', $product->getId()) }}" variant="secondary">Cancel</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>

