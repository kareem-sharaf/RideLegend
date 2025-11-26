@props(['filters' => []])

<div class="bg-white border border-neutral-200">
    <div class="px-6 py-4 border-b border-neutral-200">
        <h3 class="text-sm font-semibold text-black uppercase tracking-wide">Filters</h3>
    </div>

    <form method="GET" action="{{ route('products.index') }}" class="divide-y divide-neutral-200">
        <!-- Price Range - Toggle Section -->
        <div class="filter-section">
            <button type="button"
                class="filter-toggle w-full px-6 py-4 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors duration-200"
                onclick="toggleFilterSection(this)" aria-expanded="false">
                <span class="text-sm font-medium text-black uppercase tracking-wide">Price</span>
                <svg class="w-5 h-5 text-neutral-400 transform transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="filter-content hidden px-6 pb-6">
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                        class="w-full px-3 py-2 text-sm border border-neutral-200 focus:border-black focus:outline-none transition-colors duration-200">
                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                        class="w-full px-3 py-2 text-sm border border-neutral-200 focus:border-black focus:outline-none transition-colors duration-200">
                </div>
            </div>
        </div>

        <!-- Bike Type - Toggle Section -->
        <div class="filter-section">
            <button type="button"
                class="filter-toggle w-full px-6 py-4 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors duration-200"
                onclick="toggleFilterSection(this)" aria-expanded="false">
                <span class="text-sm font-medium text-black uppercase tracking-wide">Bike Type</span>
                <svg class="w-5 h-5 text-neutral-400 transform transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="filter-content hidden px-6 pb-6">
                <div class="space-y-2">
                    @php
                        $bikeTypes = [
                            'road' => 'Road',
                            'mountain' => 'Mountain',
                            'gravel' => 'Gravel',
                            'hybrid' => 'Hybrid',
                            'electric' => 'Electric',
                        ];
                    @endphp
                    @foreach ($bikeTypes as $value => $label)
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="bike_type[]" value="{{ $value }}"
                                {{ in_array($value, (array) request('bike_type', [])) ? 'checked' : '' }}
                                class="w-4 h-4 border-neutral-200 text-black focus:ring-black focus:ring-1 transition-colors duration-200">
                            <span
                                class="ml-3 text-sm text-neutral-600 group-hover:text-black transition-colors duration-200">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Frame Material - Toggle Section -->
        <div class="filter-section">
            <button type="button"
                class="filter-toggle w-full px-6 py-4 flex items-center justify-between text-left hover:bg-neutral-50 transition-colors duration-200"
                onclick="toggleFilterSection(this)" aria-expanded="false">
                <span class="text-sm font-medium text-black uppercase tracking-wide">Frame Material</span>
                <svg class="w-5 h-5 text-neutral-400 transform transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="filter-content hidden px-6 pb-6">
                <div class="space-y-2">
                    @php
                        $materials = [
                            'carbon' => 'Carbon',
                            'aluminum' => 'Aluminum',
                            'steel' => 'Steel',
                            'titanium' => 'Titanium',
                        ];
                    @endphp
                    @foreach ($materials as $value => $label)
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="frame_material[]" value="{{ $value }}"
                                {{ in_array($value, (array) request('frame_material', [])) ? 'checked' : '' }}
                                class="w-4 h-4 border-neutral-200 text-black focus:ring-black focus:ring-1 transition-colors duration-200">
                            <span
                                class="ml-3 text-sm text-neutral-600 group-hover:text-black transition-colors duration-200">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Certified Only -->
        <div class="px-6 py-4">
            <label class="flex items-center cursor-pointer group">
                <input type="checkbox" name="certified_only" value="1"
                    {{ request('certified_only') ? 'checked' : '' }}
                    class="w-4 h-4 border-neutral-200 text-black focus:ring-black focus:ring-1 transition-colors duration-200">
                <span
                    class="ml-3 text-sm text-neutral-600 group-hover:text-black transition-colors duration-200">Certified
                    Only</span>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="px-6 py-4 space-y-2">
            <x-button type="submit" variant="primary" class="w-full">Apply Filters</x-button>
            <x-button href="{{ route('products.index') }}" variant="outline" class="w-full">Reset</x-button>
        </div>

        {{-- Preserve all query parameters except page when applying filters --}}
        @foreach (request()->except(['page']) as $key => $value)
            @if (!in_array($key, ['min_price', 'max_price', 'bike_type', 'frame_material', 'certified_only', 'sort']))
                @if (is_array($value))
                    @foreach ($value as $item)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endif
        @endforeach
    </form>
</div>

<script>
    function toggleFilterSection(button) {
        const section = button.closest('.filter-section');
        const content = section.querySelector('.filter-content');
        const icon = button.querySelector('svg');
        const isExpanded = button.getAttribute('aria-expanded') === 'true';

        // Toggle content
        content.classList.toggle('hidden');

        // Toggle icon rotation
        icon.classList.toggle('rotate-180');

        // Update aria-expanded
        button.setAttribute('aria-expanded', !isExpanded);
    }
</script>

<style>
    .filter-section:first-child .filter-toggle {
        border-top: none;
    }

    .filter-content {
        transition: all 0.2s ease-in-out;
    }
</style>
