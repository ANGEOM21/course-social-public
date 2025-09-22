<div class="relative inline-block" x-data="dropdown()" @click.outside="close()">
  <button x-ref="button" @click="toggle()" {{ $trigger->attributes->merge(['class' => 'btn']) }}>
    {{ $trigger }}
  </button>
  <div x-show="open" x-transition x-bind:style="`top: ${position.top}px; left: ${position.left}px; position: fixed;`"
    {{ $attributes->merge(['class' => 'z-50 bg-base-100 rounded-box shadow-lg w-32 py-2 text-sm']) }}
    style="will-change: opacity, transform;" x-cloak>
    <ul {{ $content->attributes->merge(['class' => 'menu p-2 w-max']) }}>
      {{ $content }}
    </ul>
  </div>

  <script>
    function dropdown() {
      return {
        open: false,
        position: {
          top: 0,
          left: 0
        },
        toggle() {
          this.open = !this.open;
          if (this.open) {
            this.$nextTick(() => {
              const btn = this.$refs.button;
              const rect = btn.getBoundingClientRect();
              this.position.top = rect.bottom + window.scrollY;
              this.position.left = rect.right - 128 + window.scrollX;
            });
          }
        },
        close() {
          this.open = false;
        }
      }
    }
  </script>
</div>
