@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
  $alignmentClasses = match ($align) {
      'left' => 'dropdown-menu-start',
      'top' => '',
      default => 'dropdown-menu-end',
  };

  $width = match ($width) {
      '48' => '',
      default => $width,
  };
@endphp

<div class="dropdown" v-cloak>
  <div @click="open = !open">
    {{ $trigger }}
  </div>

  <div v-if="open"
    class="dropdown-menu {{ $alignmentClasses }} {{ $width }} {{ $contentClasses }}"
    @click="open = false">
    {{ $content }}
  </div>
</div>

@push('scripts')
  <script>
    new Vue({
      el: '.dropdown',
      data: {
        open: false
      },
      mounted() {
        document.addEventListener('click', this.closeDropdown)
      },
      beforeDestroy() {
        document.removeEventListener('click', this.closeDropdown)
      },
      methods: {
        closeDropdown(event) {
          if (!this.$el.contains(event.target)) {
            this.open = false
          }
        }
      }
    });
  </script>
@endpush