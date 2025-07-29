<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Admin Dashboard</h2>
  </x-slot>

  <div 
    id="admin-dashboard"
    data-roles="{{ json_encode(auth()->user()->getRoleNames()) }}"
    data-permissions="{{ json_encode(auth()->user()->getPermissionNames()) }}"
    data-user="{{ json_encode(auth()->user()->only(['id','name','email'])) }}"
  ></div>

  @vite('resources/js/app.jsx')
</x-app-layout>
