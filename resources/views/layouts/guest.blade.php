<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sembark URL Shortner') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/#main" class="space-x-3 inline-flex items-center text-lg" itemprop="url" title="Sembark"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="h-8 w-8" fill="currentColor"> 
                    <path d="M8 16a8 8 0 10-4.465-1.361c.41.276 0-.846.715-2.639.534-1.34 1.81-4.466 1.825-5.205.01-.534-.193-.994-.4-1.466-.046-.101-.09-.204-.134-.307-.391.768-1.764 1.929-2.69 1.743-1.285-.256-.419-1.777.116-2.359l.18-.201c.498-.563 1.191-1.347 1.836-1.076.312.13 1.09.701 1.707 1.19 0 0-.018-.047-.028-.079-.282-.87-.67-1.896 1.14-2.047.46-.04 2.776-.023 2.275.854-.202.352-1.139.45-1.863.526-.305.032-.573.06-.732.101.076.42.121.93.128 1.396 1.074.123 1.755.032 2.557-.075.399-.053.827-.11 1.348-.147C12.035 4.81 12.75 4.75 13 5c.165.165.204.575.145.934-.247 1.491-1.68 2.794-2.812 3.823-.191.174-.374.34-.54.498-1.642 1.55-2.523 3.144-2.434 5.127.01.189-.011.607.225.607.138.007.276.011.416.011z">
                    </path> </svg> 
                    <span class="font-semibold uppercase tracking-widest">Sembark URL Shortner</span> 
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
