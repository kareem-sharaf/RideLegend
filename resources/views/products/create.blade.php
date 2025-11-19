<x-dashboard-layout title="List Your Bike">
    <div class="max-w-4xl mx-auto">
        <x-card>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Create Product Listing</h2>

            <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
                @csrf

                <x-form-input
                    label="Title"
                    name="title"
                    type="text"
                    value="{{ old('title') }}"
                    required
                />

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="description" 
                        rows="5"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-form-input
                        label="Price ($)"
                        name="price"
                        type="number"
                        step="0.01"
                        value="{{ old('price') }}"
                        required
                    />

                    <x-form-input
                        label="Year"
                        name="year"
                        type="number"
                        value="{{ old('year') }}"
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-form-input
                        label="Brand"
                        name="brand"
                        type="text"
                        value="{{ old('brand') }}"
                    />

                    <x-form-input
                        label="Model"
                        name="model"
                        type="text"
                        value="{{ old('model') }}"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Bike Type <span class="text-red-500">*</span>
                    </label>
                    <select name="bike_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <option value="">Select Bike Type</option>
                        <option value="road" {{ old('bike_type') === 'road' ? 'selected' : '' }}>Road</option>
                        <option value="mountain" {{ old('bike_type') === 'mountain' ? 'selected' : '' }}>Mountain</option>
                        <option value="gravel" {{ old('bike_type') === 'gravel' ? 'selected' : '' }}>Gravel</option>
                        <option value="hybrid" {{ old('bike_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        <option value="electric" {{ old('bike_type') === 'electric' ? 'selected' : '' }}>Electric</option>
                    </select>
                    @error('bike_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Frame Material <span class="text-red-500">*</span>
                        </label>
                        <select name="frame_material" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                            <option value="">Select Material</option>
                            <option value="carbon" {{ old('frame_material') === 'carbon' ? 'selected' : '' }}>Carbon</option>
                            <option value="aluminum" {{ old('frame_material') === 'aluminum' ? 'selected' : '' }}>Aluminum</option>
                            <option value="steel" {{ old('frame_material') === 'steel' ? 'selected' : '' }}>Steel</option>
                            <option value="titanium" {{ old('frame_material') === 'titanium' ? 'selected' : '' }}>Titanium</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Brake Type <span class="text-red-500">*</span>
                        </label>
                        <select name="brake_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                            <option value="">Select Brake Type</option>
                            <option value="rim_brake" {{ old('brake_type') === 'rim_brake' ? 'selected' : '' }}>Rim Brake</option>
                            <option value="disc_brake_mechanical" {{ old('brake_type') === 'disc_brake_mechanical' ? 'selected' : '' }}>Disc (Mechanical)</option>
                            <option value="disc_brake_hydraulic" {{ old('brake_type') === 'disc_brake_hydraulic' ? 'selected' : '' }}>Disc (Hydraulic)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Wheel Size <span class="text-red-500">*</span>
                        </label>
                        <select name="wheel_size" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                            <option value="">Select Size</option>
                            <option value="26" {{ old('wheel_size') === '26' ? 'selected' : '' }}>26"</option>
                            <option value="27.5" {{ old('wheel_size') === '27.5' ? 'selected' : '' }}>27.5"</option>
                            <option value="29" {{ old('wheel_size') === '29' ? 'selected' : '' }}>29"</option>
                            <option value="700c" {{ old('wheel_size') === '700c' ? 'selected' : '' }}>700c</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <x-form-input
                            label="Weight"
                            name="weight"
                            type="number"
                            step="0.1"
                            value="{{ old('weight') }}"
                        />
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                            <select name="weight_unit" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="kg" {{ old('weight_unit', 'kg') === 'kg' ? 'selected' : '' }}>kg</option>
                                <option value="lbs" {{ old('weight_unit') === 'lbs' ? 'selected' : '' }}>lbs</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <x-button type="submit" variant="primary">Create Product</x-button>
                    <x-button href="{{ route('products.index') }}" variant="secondary">Cancel</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-dashboard-layout>

