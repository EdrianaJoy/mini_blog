<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Mini Blog') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Alpine.js via CDN -->
  <script src="https://unpkg.com/alpinejs" defer></script>

  <!-- Vite Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="font-sans antialiased bg-orange-100 text-pink-900">
  <div class="min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow">
      <div class="w-full py-4 px-9 bg-rose-300 flex justify-between items-center">
        <!-- Changed this route: -->
        <a href="{{ route('admin.dashboard') }}" class="font-bold text-white text-xl">
          Mini Blog
        </a>

        <nav class="flex items-center space-x-4">
          @auth
            <!-- Dropdown User Menu -->
            <x-dropdown align="right" width="48">
              <x-slot name="trigger">
                <button class="flex items-center text-pink-800 font-semibold hover:text-pink-600">
                  <span>{{ auth()->user()->name }}</span>
                  <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
              </x-slot>

              <x-slot name="content">
                <x-dropdown-link href="{{ route('profile.edit') }}">
                  {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <x-dropdown-link :href="route('logout')"
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                  </x-dropdown-link>
                </form>
              </x-slot>
            </x-dropdown>

            <a href="{{ route('posts.create') }}" class="px-3 py-1 bg-rose-600 font-semibold text-white rounded">
              New Post
            </a>
          @else
            <a href="{{ route('login') }}" class="px-3 py-1 font-medium text-white hover:underline">Login</a>
          @endauth
        </nav>
      </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
      @if(session('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="mb-6 p-4 bg-rose-100 text-pink-800 rounded">
          {{ session('success') }}
        </div>
      @endif

      {{ $slot }}
    </main>

  </div>
</body>
</html>
