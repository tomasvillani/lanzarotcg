<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    
    <title>@yield('title', 'LanzaroTCG')</title>

    @vite('resources/js/app.js')
</head>
<body class="d-flex flex-column min-vh-100">

    @include('layouts.navbar')

    <main class="flex-grow-1 w-100 container py-4">
        @yield('content')
    </main>

    <footer class="bg-dark text-light text-center py-3 mt-auto">
        <div class="container">
            <small>&copy; {{ date('Y') }} LanzaroTCG. Todos los derechos reservados.</small><br>
            <small>Hecho para amantes de los TCG.</small>
        </div>
    </footer>

</body>
</html>
