<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('css/template.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <header class="header">
            @include('layouts.navigation')
        </header>
        @include('layouts.left')
        
        <!-- Page Content -->
        <main class="content">
            {{ $slot }}
        </main>
        <footer class="footer">
            <span>Desenvolvido com</span>
            <span><i class="fa-solid fa-heart text-red-600 mr-1 ml-"></i></span>
            <span>por COD<span class="text-red-600">3</span>R</span>
        </footer>
        <script src="{{ asset('js/innout.js') }}"></script>
    </body>
</html>
