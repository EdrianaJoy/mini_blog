<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'Mini Blog' }}</title>

  <!-- Vite includes your compiled CSS & JS -->
  @vite(['resources/js/app.js'])
</head>
<body class="antialiased bg-orange-100 text-pink-900">
  <header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <a href="{{ route('posts.index') }}" class="font-bold text-xl">Mini Blog</a>
      <nav class="space-x-4">
        @auth
          <span>{{ auth()->user()->name }}</span>
          <a href="{{ route('posts.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">New Post</a>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="px-3 py-1">Login</a>
          <a href="{{ route('register') }}" class="px-3 py-1">Register</a>
        @endauth
      </nav>
    </div>
  </header>

  <main class="container mx-auto px-4 py-6">
    @if(session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif

    {{ $slot }}
  </main>
</body>
</html>
