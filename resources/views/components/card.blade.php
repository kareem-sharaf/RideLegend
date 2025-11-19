@props([
    'variant' => 'default',
])

@php
    $baseClasses = 'rounded-card';
    
    $variantClasses = match($variant) {
        'default' => 'bg-white shadow-card p-6',
        'elevated' => 'bg-white shadow-card-hover p-6',
        'outlined' => 'bg-white border-2 border-gray-200 p-6',
        default => 'bg-white shadow-card p-6',
    };
    
    $classes = "{$baseClasses} {$variantClasses}";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>

