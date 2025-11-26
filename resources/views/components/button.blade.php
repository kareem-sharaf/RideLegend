@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
])

@php
    // Minimal Button Style - بدون shadow
    $baseClasses = 'font-medium transition-all duration-200 focus:outline-none uppercase tracking-wide inline-block text-center';

    $variantClasses = match ($variant) {
        'primary' => 'bg-black text-white hover:bg-gray-dark border border-black',
        'secondary' => 'bg-white text-black border border-black hover:bg-gray-light',
        'outline' => 'bg-transparent text-black border border-black hover:bg-black hover:text-white',
        'ghost' => 'bg-transparent text-black border border-transparent hover:border-black',
        'gold' => 'bg-gold text-black border border-gold hover:bg-gold-light',
        'danger' => 'bg-accent-red text-white border border-accent-red hover:bg-red-600',
        default => 'bg-black text-white hover:bg-gray-dark border border-black',
    };

    $sizeClasses = match ($size) {
        'sm' => 'px-6 py-2 text-xs',
        'md' => 'px-8 py-3 text-sm',
        'lg' => 'px-10 py-4 text-base',
        default => 'px-8 py-3 text-sm',
    };

    $classes = "{$baseClasses} {$variantClasses} {$sizeClasses}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
