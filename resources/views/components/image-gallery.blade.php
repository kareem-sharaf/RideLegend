@props(['images', 'productId' => null])

<div class="space-y-6">
    <!-- Main Image - Large -->
    <div class="relative bg-gray-light">
        @if ($images->isNotEmpty())
            @php
                $primaryImage = $images->firstWhere('isPrimary', true) ?? $images->first();
            @endphp
            <img id="main-image" src="{{ asset('storage/' . $primaryImage->getPath()) }}" alt="Product Image"
                class="w-full aspect-[4/3] object-cover" loading="eager">
        @else
            <div class="w-full aspect-[4/3] bg-gray-light flex items-center justify-center">
                <span class="text-neutral-400">No Image Available</span>
            </div>
        @endif
    </div>

    <!-- Thumbnails - Small Strip -->
    @if ($images->count() > 1)
        <div class="flex gap-3 overflow-x-auto pb-2">
            @foreach ($images as $image)
                <button onclick="changeMainImage('{{ asset('storage/' . $image->getPath()) }}', this)"
                    class="flex-shrink-0 w-24 h-24 border-2 transition-all duration-200 {{ $image->isPrimary() || ($loop->first && !$images->firstWhere('isPrimary', true)) ? 'border-black' : 'border-neutral-200 hover:border-neutral-400' }}">
                    <img src="{{ asset('storage/' . $image->getPath()) }}" alt="Thumbnail"
                        class="w-full h-full object-cover" loading="lazy">
                </button>
            @endforeach
        </div>
    @endif
</div>

<script>
    function changeMainImage(src, button) {
        // Update main image
        document.getElementById('main-image').src = src;

        // Update active thumbnail
        document.querySelectorAll('.image-gallery button').forEach(btn => {
            btn.classList.remove('border-black');
            btn.classList.add('border-neutral-200');
        });
        button.classList.remove('border-neutral-200');
        button.classList.add('border-black');
    }
</script>
