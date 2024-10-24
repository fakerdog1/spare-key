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
    @vite(['resources/js/app.js'])
</head>
<body class="bg-light">
<div id="app" class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4">
    <div>
        <a href="/">
            <x-application-logo class="w-20 h-20 text-muted" />
        </a>
    </div>

    <div class="card mt-4 shadow-sm" style="width: 24rem;">
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
</div>
</body>
</html>