@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl',
    'closable' => true,
])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md', 
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
][$maxWidth];
@endphp

<div
    x-data="{ 
        show: @js($show),
        close() { 
            this.show = false;
            $dispatch('modal-closed', '{{ $name }}');
        }
    }"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-show="show"
    x-on:keydown.escape.window="@if($closable) close() @endif"
    style="display: none;"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
>
    <!-- Backdrop -->
    <div 
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75"
        @if($closable) @click="close()" @endif
    ></div>

    <!-- Modal -->
    <div 
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative transform transition-all sm:mx-auto {{ $maxWidth }} sm:w-full"
    >
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            @if($closable)
            <div class="absolute top-4 right-4">
                <button @click="close()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif
            {{ $slot }}
        </div>
    </div>
</div>