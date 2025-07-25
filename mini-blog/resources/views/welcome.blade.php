<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
           <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
           <script src="{{ mix('resources/js/app.js') }}" defer></script>
        @endif
    </head>
    <body class="bg-orange-100 text-rose-400 flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    
    <div class="absolute right-[-22%] top-[-5%] w-[1000px] h-[1000px] bg-pink-400 opacity-60 rounded-full z-0"></div>
    <div class="absolute right-[-18%] top-[10%] w-[800px] h-[800px] bg-pink-200 opacity-50 rounded-full z-0"></div>
    <div class="absolute right-[-22%] top-[25%] w-[600px] h-[600px] bg-pink-100 opacity-40 rounded-full z-0"></div>
    
    <div class="relative z-10 flex flex-col items-start w-full px-8">
        <!-- Logo block -->
         <div class="mb-5 w-full max-w-xs">
    <img src="{{ asset('Sweet .png') }}" alt="Sweet Thoughts Logo" class="w-60 h-auto">
</div>

        <!-- Main content -->
        <main class="flex flex-col items-start w-full max-w-4xl text-left">
            <h1 class="text-4xl font-bold mb-2 font-serif">
            Welcome to Sweet Thoughts
            </h1>
            <p class="text-lg mb-5 font-serif">
            Your personal blogging platform.
            </p>

            <!-- Content goes here -->
            <div class="w-full max-w-2xl">
                @yield('content')
            </div>
        </main>

        <!-- Header with navigation -->

    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex flex-col justify-end gap-4">
                    @auth 
                        <
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block w-48 py-1.5 text-orange-100 bg-rose-400  border-rose-400 hover:border-rose-700 border rounded-full text-lg font-semibold leading-normal text-center"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block w-48 py-1.5 text-rose-400 border-rose-400 hover:border-rose-700 border text-[#1b1b18] rounded-full text-lg font-semibold leading-normal text-center">
                                Create Account
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        
                    
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
