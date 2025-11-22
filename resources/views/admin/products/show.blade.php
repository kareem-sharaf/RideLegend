<x-admin-layout title="Product Details">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Product Details</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Back to List
            </a>
            @if($product->status === 'pending')
                <form method="POST" action="{{ route('admin.products.approve', $product->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Approve
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.products.reject', $product->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Reject
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Product Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Title</label>
                        <p class="text-gray-900">{{ $product->title }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="text-gray-900">{{ $product->description }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Brand</label>
                            <p class="text-gray-900">{{ $product->brand }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Model</label>
                            <p class="text-gray-900">{{ $product->model }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Year</label>
                            <p class="text-gray-900">{{ $product->year ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Price</label>
                            <p class="text-gray-900 font-semibold">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Bike Type</label>
                            <p class="text-gray-900">{{ ucfirst($product->bike_type) }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Frame Material</label>
                            <p class="text-gray-900">{{ ucfirst($product->frame_material) }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <div class="mt-1">
                            @if($product->status === 'active')
                                <x-badge variant="success">Active</x-badge>
                            @elseif($product->status === 'pending')
                                <x-badge variant="warning">Pending</x-badge>
                            @else
                                <x-badge variant="danger">Rejected</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            @if($product->images->count() > 0)
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Images</h3>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Product Image" class="w-full h-48 object-cover rounded-lg">
                    @endforeach
                </div>
            </x-card>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Seller Information</h3>
                <div class="space-y-2">
                    <p class="text-sm">
                        <span class="font-medium">Name:</span>
                        {{ $product->seller->first_name ?? 'N/A' }} {{ $product->seller->last_name ?? '' }}
                    </p>
                    <p class="text-sm">
                        <span class="font-medium">Email:</span>
                        {{ $product->seller->email ?? 'N/A' }}
                    </p>
                </div>
            </x-card>

            @if($product->certification)
            <x-card>
                <h3 class="text-lg font-semibold mb-4">Certification</h3>
                <p class="text-sm text-gray-600">Product is certified</p>
                <a href="{{ route('certifications.show', $product->certification->id) }}" class="text-primary-600 hover:underline mt-2 inline-block">
                    View Certification
                </a>
            </x-card>
            @endif

            <x-card>
                <h3 class="text-lg font-semibold mb-4">Actions</h3>
                <div class="space-y-2">
                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Delete Product
                        </button>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
</x-admin-layout>

