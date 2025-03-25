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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</head>

<body>
    <x-users.header />
    <x-users.navbar />
    <main>
        @if (request()->routeIs('homepage'))
            <x-users.homepage-banner :banner="getHomeBanner()" />
        @endif
        @yield('content')
        @if (request()->routeIs('homepage'))
            <x-users.homepage-features />
        @endif
    </main>
    {{-- @dd($footerBlock) --}}
    <x-users.footer :footerBlock="getFooterBlock()" :footerLinks="getFooterLinks()" />
    <x-users.copy-right />

    @stack('scripts')
</body>

</html>
