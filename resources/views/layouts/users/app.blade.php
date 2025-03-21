<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Tailwind</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    {{-- @vite('resources/css/app.css', 'resources/js/app.js') --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')

</head>

<body>
    <x-users.header />
    <x-users.navbar />
    <main>
        @if (request()->routeIs('homepage'))
            <x-users.homepage-banner />
        @endif
        @yield('content')
        @if (request()->routeIs('homepage'))
            <x-users.homepage-features />
        @endif
    </main>
    <x-users.footer />
    <x-users.copy-right />

    @stack('scripts')
</body>

</html>
