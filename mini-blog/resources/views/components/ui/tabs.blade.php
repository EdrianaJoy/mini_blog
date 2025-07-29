@props(['defaultTab' => 0])

<div x-data="{ activeTab: {{ $defaultTab }} }" class="w-full">
    {{ $slot }}
</div>