<!DOCTYPE html>
<html lang="id">
    <head>
        <title>@yield('title', 'Simple POS')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <x-nav />
        <main class="max-w-6xl mx-auto px-4 py-6">
            @yield('content')
        </main>
    </body>
</html>
