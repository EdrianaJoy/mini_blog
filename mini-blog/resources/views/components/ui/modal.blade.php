@props(['name', 'maxWidth'])

@php
  $maxWidth = match($maxWidth) {
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    default => 'sm:max-w-2xl',
  };
@endphp

<div 
  x-data="{ show: false }" 
  x-show="show" 
  x-on:open-modal.window="if ($event.detail == {{ Illuminate\Support\Js::from($name) }}) show = true" 
  x-on:close-modal.window="if ($event.detail == {{ Illuminate\Support\Js::from($name) }}) show = false"
  class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
  style="display: none;"
>
  <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all {{ $maxWidth }} w-full">
      {{ $slot }}
    </div>
  </div>
</div>
