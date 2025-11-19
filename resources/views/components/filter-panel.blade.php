@props(['filters' => []])

<div class="bg-white rounded-card shadow-card p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filters</h3>

    <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
        <!-- Price Range -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
            <div class="grid grid-cols-2 gap-2">
                <input 
                    type="number" 
                    name="min_price" 
                    placeholder="Min"
                    value="{{ request('min_price') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                >
                <input 
                    type="number" 
                    name="max_price" 
                    placeholder="Max"
                    value="{{ request('max_price') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                >
            </div>
        </div>

        <!-- Bike Type -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Bike Type</label>
            <select 
                name="bike_type"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            >
                <option value="">All Types</option>
                <option value="road" {{ request('bike_type') === 'road' ? 'selected' : '' }}>Road</option>
                <option value="mountain" {{ request('bike_type') === 'mountain' ? 'selected' : '' }}>Mountain</option>
                <option value="gravel" {{ request('bike_type') === 'gravel' ? 'selected' : '' }}>Gravel</option>
                <option value="hybrid" {{ request('bike_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                <option value="electric" {{ request('bike_type') === 'electric' ? 'selected' : '' }}>Electric</option>
            </select>
        </div>

        <!-- Frame Material -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Frame Material</label>
            <select 
                name="frame_material"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            >
                <option value="">All Materials</option>
                <option value="carbon" {{ request('frame_material') === 'carbon' ? 'selected' : '' }}>Carbon</option>
                <option value="aluminum" {{ request('frame_material') === 'aluminum' ? 'selected' : '' }}>Aluminum</option>
                <option value="steel" {{ request('frame_material') === 'steel' ? 'selected' : '' }}>Steel</option>
                <option value="titanium" {{ request('frame_material') === 'titanium' ? 'selected' : '' }}>Titanium</option>
            </select>
        </div>

        <!-- Brake Type -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Brake Type</label>
            <select 
                name="brake_type"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
            >
                <option value="">All Types</option>
                <option value="rim_brake" {{ request('brake_type') === 'rim_brake' ? 'selected' : '' }}>Rim Brake</option>
                <option value="disc_brake_mechanical" {{ request('brake_type') === 'disc_brake_mechanical' ? 'selected' : '' }}>Disc (Mechanical)</option>
                <option value="disc_brake_hydraulic" {{ request('brake_type') === 'disc_brake_hydraulic' ? 'selected' : '' }}>Disc (Hydraulic)</option>
            </select>
        </div>

        <!-- Certified Only -->
        <div>
            <label class="flex items-center">
                <input 
                    type="checkbox" 
                    name="certified_only" 
                    value="1"
                    {{ request('certified_only') ? 'checked' : '' }}
                    class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                >
                <span class="ml-2 text-sm text-gray-700">Certified Only</span>
            </label>
        </div>

        <div class="flex space-x-2">
            <x-button type="submit" variant="primary" class="flex-1">Apply Filters</x-button>
            <x-button href="{{ route('products.index') }}" variant="secondary">Reset</x-button>
        </div>
    </form>
</div>

