<?php
?>
@props(['type' => 'info', 'dismissible' => false])

@php
$classes = [
    'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    'success' => 'bg-green-50 border-green-200 text-green-800',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
    'error' => 'bg-red-50 border-red-200 text-red-800',
];
@endphp

<div {{ $attributes->merge(['class' => 'border rounded-md p-4 ' . $classes[$type]]) }}>
    @if($dismissible)
        <div class="flex justify-between items-start">
            <div class="flex-1">
                {{ $slot }}
            </div>
            <button type="button" class="ml-2 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @else
        {{ $slot }}
    @endif
</div>
