<div>
<?php
?>
@props(['type' => 'text', 'name', 'id' => null, 'value' => '', 'placeholder' => '', 'required' => false, 'readonly' => false, 'disabled' => false])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    value="{{ old($name, $value) }}"
    placeholder="{{ $placeholder }}"
    {{ $required ? 'required' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm' . ($readonly ? ' bg-gray-100 cursor-not-allowed' : '') . ($disabled ? ' bg-gray-200 cursor-not-allowed' : '')]) }}
>
</div>
