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
    <body class="font-sans text-gray-900 antialiased bg-white"> {{-- S'assurer que le fond est blanc --}}

        {{-- INCLUSION DU HEADER ET GESTION DE LA MISE EN PAGE --}}
        <header class="w-full">
            @include('layouts.header')
        </header>
        
        {{-- CENTRAGE DU CONTENU (FORMULAIRE) --}}
        <div class="min-h-screen pt-20 flex flex-col items-center justify-start"> 
            {{-- Le pt-20 (padding-top 5rem) est essentiel pour éviter que le formulaire ne se superpose au header --}}

            {{-- Le slot $slot contient le formulaire de login --}}
            {{ $slot }}

        </div>

        {{-- L'élément Application-Logo peut être retiré car il est dans le header --}}

    </body>
</html>
