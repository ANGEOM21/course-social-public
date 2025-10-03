{{-- resources/views/components/forms/trix.blade.php (Versi Final & Paling Andal) --}}

@props(['value' => ''])

<div
    wire:ignore
    {{ $attributes }}
    x-data="{
        value: @entangle($attributes->wire('model')),

        initEditor() {
            const trixEditor = this.$refs.trix;
            trixEditor.editor.loadHTML(this.value || '');
            trixEditor.addEventListener('trix-change', () => {
                this.value = trixEditor.value;
            }, false);
            this.$watch('value', (newValue) => {
                if (newValue !== trixEditor.value) {
                    const originalSelection = trixEditor.editor.getSelectedRange();
                    trixEditor.editor.loadHTML(newValue || '');
                    if (originalSelection[0] > 0) {
                        trixEditor.editor.setSelectedRange(originalSelection);
                    }
                }
            });
        }
    }"
    x-init="initEditor()"
>
    <input id="{{ $attributes['id'] ?? 'trix' }}" type="hidden" value="{{ $value }}">
    <trix-editor x-ref="trix" input="{{ $attributes['id'] ?? 'trix' }}" class="trix-content bg-base-100"></trix-editor>
</div>