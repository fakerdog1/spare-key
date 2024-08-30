<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
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

    @stack('styles')
  </head>
  <body class="d-flex flex-column h-100">
    <div class="flex-shrink-0">
      @include('layouts.navigation')

      @hasSection('header')
        <header>
          <div class="container py-3">
            @yield('header')
          </div>
        </header>
      @endif

      <main class="flex-grow-1">
        @yield('content')
      </main>
    </div>

    @hasSection('footer')
      <footer class="footer mt-auto bg-light">
        @yield('footer')
      </footer>
    @endif
  </body>
</html>