@props([
    'variant' => 'default',
    'size' => 'md',
])

@php
    $baseClasses = 'inline-flex items-center rounded-full font-medium';
    
    $variantClasses = match($variant) {
        'success' => 'bg-emerald-100 text-emerald-800',
        'warning' => 'bg-amber-100 text-amber-800',
        'error' => 'bg-red-100 text-red-800',
        'info' => 'bg-blue-100 text-blue-800',
        'default' => 'bg-gray-100 text-gray-800',
        default => 'bg-gray-100 text-gray-800',
    };
    
    $sizeClasses = match($size) {
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-3 py-1 text-sm',
        'lg' => 'px-4 py-2 text-base',
        default => 'px-3 py-1 text-sm',
    };
    
    $classes = "{$baseClasses} {$variantClasses} {$sizeClasses}";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>

