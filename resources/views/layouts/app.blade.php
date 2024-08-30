<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
      rel="stylesheet"
    >

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
    <div class="min-vh-100 bg-light">
      @include('layouts.navigation')

      @hasSection('header')
        <header>
          <div class="container py-3">
            @yield('header')
          </div>
        </header>
      @endif

      <main>
        @yield('content')
      </main>
    </div>

  <!-- Bootstrap JS -->
  </body>
</html>