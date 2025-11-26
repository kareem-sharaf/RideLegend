@props([
    'variant' => 'default',
])

@php
    // Minimal Card Style - مسطحة مع حدود خفيفة
    $baseClasses = '';

    $variantClasses = match ($variant) {
        'default' => 'bg-white border border-neutral-200 p-8',
        'outlined' => 'bg-white border border-black p-8',
        'subtle' => 'bg-gray-light border border-neutral-300 p-8',
        'minimal' => 'bg-white border-b border-neutral-200 p-8',
        default => 'bg-white border border-neutral-200 p-8',
    };

    $classes = "{$baseClasses} {$variantClasses}";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
