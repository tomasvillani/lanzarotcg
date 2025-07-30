<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    
    <title>@yield('title', 'LanzaroTCG')</title>

    @vite('resources/js/app.js')
</head>
<body>

    @include('layouts.navbar')

    <main class="flex-grow w-100 container py-4">
        @yield('content')
    </main>

</body>
</html>