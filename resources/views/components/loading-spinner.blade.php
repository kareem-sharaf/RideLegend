@props(['size' => 'md'])

@php
    $sizeClasses = match ($size) {
        'sm' => 'w-4 h-4',
        'md' => 'w-8 h-8',
        'lg' => 'w-12 h-12',
        default => 'w-8 h-8',
    };
@endphp

<div class="flex items-center justify-center py-12">
    <div class="{{ $sizeClasses }} border-2 border-black border-t-transparent rounded-full animate-spin"></div>
</div>
