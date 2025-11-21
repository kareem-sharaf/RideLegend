@props(['title'])

<x-layouts.admin title="{{ $title }}">
    {{ $slot }}
</x-layouts.admin>

