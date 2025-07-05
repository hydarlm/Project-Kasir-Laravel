<div>
    <?php
    // File: resources/views/components/button-primary.blade.php
    ?>
    @props(['type' => 'button', 'disabled' => false])

    <button
        type="{{ $type }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150' . ($disabled ? ' cursor-not-allowed' : '')]) }}
    >
        {{ $slot }}
    </button>
</div>
