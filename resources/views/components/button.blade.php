@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $baseClasses = 'font-medium rounded-button transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variantClasses = match($variant) {
        'primary' => 'bg-primary-800 text-white hover:bg-primary-900 focus:ring-primary-500',
        'secondary' => 'bg-white text-primary-800 border-2 border-primary-800 hover:bg-primary-50 focus:ring-primary-500',
        'danger' => 'bg-accent-red text-white hover:bg-red-600 focus:ring-red-500',
        'ghost' => 'bg-transparent text-primary-800 hover:bg-gray-100 focus:ring-primary-500',
        default => 'bg-primary-800 text-white hover:bg-primary-900',
    };
    
    $sizeClasses = match($size) {
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg',
        default => 'px-6 py-3 text-base',
    };
    
    $classes = "{$baseClasses} {$variantClasses} {$sizeClasses}";
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>

