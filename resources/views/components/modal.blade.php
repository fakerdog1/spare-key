@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
    $maxWidth = match ($maxWidth) {
        'sm' => 'modal-sm',
        'md' => '',
        'lg' => 'modal-lg',
        'xl' => 'modal-xl',
        '2xl' => 'modal-xl',
    };
@endphp

<div class="modal fade"
  tabindex="-1"
  aria-labelledby="{{ $name }}Label"
  aria-hidden="true"
  v-cloak
>
    <div class="modal-dialog {{ $maxWidth }} modal-dialog-centered">
        <div class="modal-content" ref="dialog">
            {{ $slot }}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        new Vue({
            el: ".modal",
            data: {
                show: @json($show)
            },
            watch: {
                show(value) {
                    if (value) {
                        document.body.classList.add("modal-open");
                        this.$nextTick(() => {
                            this.$refs.dialog.focus();
                        });
                    } else {
                        document.body.classList.remove("modal-open");
                    }
                }
            },
            mounted() {
                document.addEventListener("keydown", this.handleEscape);
                @if($attributes->has('focusable'))
                  this.$nextTick(() => {
                    this.$refs.dialog.focus();
                });
                @endif
            },
            beforeDestroy() {
                document.removeEventListener("keydown", this.handleEscape);
            },
            methods: {
                handleEscape(e) {
                    if (e.key === "Escape" && this.show) {
                        this.show = false;
                    }
                },
                close() {
                    this.show = false;
                }
            }
        });
    </script>
@endpush