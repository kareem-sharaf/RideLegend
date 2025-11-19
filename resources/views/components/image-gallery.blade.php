@props(['images', 'productId' => null])

<div class="space-y-4">
    <!-- Main Image -->
    <div class="relative">
        @if($images->isNotEmpty())
            @php
                $primaryImage = $images->firstWhere('isPrimary', true) ?? $images->first();
            @endphp
            <img 
                id="main-image"
                src="{{ asset('storage/' . $primaryImage->getPath()) }}" 
                alt="Product Image"
                class="w-full h-96 object-cover rounded-lg"
            >
        @else
            <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                <span class="text-gray-400">No Image Available</span>
            </div>
        @endif
    </div>

    <!-- Thumbnails -->
    @if($images->count() > 1)
        <div class="grid grid-cols-4 gap-2">
            @foreach($images as $image)
                <button 
                    onclick="changeMainImage('{{ asset('storage/' . $image->getPath()) }}')"
                    class="relative overflow-hidden rounded-lg border-2 {{ ($image->isPrimary() || ($loop->first && !$images->firstWhere('isPrimary', true))) ? 'border-primary-500' : 'border-gray-200' }}"
                >
                    <img 
                        src="{{ asset('storage/' . $image->getPath()) }}" 
                        alt="Thumbnail"
                        class="w-full h-20 object-cover"
                    >
                </button>
            @endforeach
        </div>
    @endif
</div>

<script>
function changeMainImage(src) {
    document.getElementById('main-image').src = src;
}
</script>

