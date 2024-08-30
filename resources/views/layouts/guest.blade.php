<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="text-body bg-light">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4 py-sm-5">
        <div>
            <a href="/">
                @include('components.application-logo')
            </a>
        </div>

        <div class="w-100 mt-4 px-3 py-4 bg-white shadow rounded"
          style="max-width: 28rem;"
        >
            @yield('content')
        </div>
    </div>
    </body>
</html>