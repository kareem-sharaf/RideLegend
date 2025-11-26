@props([
    'title' => 'No items found',
    'message' => 'Try adjusting your filters or search terms.',
    'action' => null,
])

<div class="text-center py-20">
    <svg class="w-16 h-16 text-neutral-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <h3 class="text-xl font-display font-semibold text-black mb-2">{{ $title }}</h3>
    <p class="text-neutral-600 mb-6">{{ $message }}</p>
    @if ($action)
        {{ $action }}
    @endif
</div>
