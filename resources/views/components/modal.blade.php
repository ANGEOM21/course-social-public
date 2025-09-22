@props([
    'id' => null,
    'title' => null,
    'subtitle' => null,
    'boxClass' => null,
    'separator' => false,
    'persistent' => false,
    'actions' => null,
])

<dialog
    id="{{ $id }}"
    x-data="{ open: @entangle($attributes->wire('model')) }"
    :class="{ 'modal modal-open z-[9999]': open }"
    :open="open"
    {{ $attributes->except('wire:model')->class(['modal']) }}
    @keydown.escape.window="open = {{ $persistent ? 'true' : 'false' }}"
>
    <div class="modal-box {{ $boxClass }}">
        @if ($title)
            <x-header :title="$title" :subtitle="$subtitle" size="text-2xl" :separator="$separator" class="mb-5" />
        @endif

        <div>
            {{ $slot }}
        </div>

        @if ($separator)
            <hr class="mt-5" />
        @endif

        @if ($actions)
            <div class="modal-action">
                {{ $actions }}
            </div>
        @endif
    </div>

    @unless($persistent)
        <form method="dialog" class="modal-backdrop">
            <button type="button" @click="open = false">close</button>
        </form>
    @endunless
</dialog>
