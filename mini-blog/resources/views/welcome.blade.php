<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sweet Thoughts</title>
  @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css','resources/js/app.js'])
  @else
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <script src="{{ mix('resources/js/app.js') }}" defer></script>
  @endif
</head>
<body class="bg-orange-100 text-rose-400 flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

  {{-- decorative circles --}}
  <div class="absolute right-[-22%] top-[-5%] w-[1000px] h-[1000px] bg-pink-400 opacity-60 rounded-full"></div>
  <div class="absolute right-[-18%] top-[10%] w-[800px] h-[800px] bg-pink-200 opacity-50 rounded-full"></div>
  <div class="absolute right-[-22%] top-[25%] w-[600px] h-[600px] bg-pink-100 opacity-40 rounded-full"></div>

  <div class="relative z-10 flex flex-col items-start w-full px-8">

    {{-- Logo --}}
    <div class="mb-5 w-full max-w-xs">
      <img src="{{ asset('Sweet .png') }}" alt="Sweet Thoughts Logo" class="w-60 h-auto">
    </div>

    {{-- Hero copy --}}
    <main class="flex flex-col items-start w-full max-w-4xl text-left">
      <h1 class="text-4xl font-bold mb-2 font-serif">Welcome to Sweet Thoughts</h1>
      <p class="text-lg mb-5 font-serif">Your personal blogging platform.</p>

      {{-- Auth buttons BELOW the paragraph --}}
      @if(Route::has('login'))
        <div class="flex space-x-4 mt-2">
          @auth
            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-pink-600 text-white rounded">
              Dashboard
            </a>
          @else
            <a href="{{ route('login') }}"
               class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
              Log in
            </a>
            @if(Route::has('register'))
              <a href="{{ route('register') }}"
                 class="px-4 py-2 bg-pink-300 text-pink-700 rounded hover:bg-pink-200">
                Create Account
              </a>
            @endif
          @endauth
        </div>
      @endif
    </main>

  </div>
</body>
</html>
