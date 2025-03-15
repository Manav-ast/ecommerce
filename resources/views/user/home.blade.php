<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
    <x-navbar />

    <div class="container">
        <h1>Welcome to Our Website</h1>
        <p>This is a simple homepage created using HTML and CSS. You can customize it as needed.</p>
        {{-- <a href="{{route('user.logout')}}" class="btn">Logout</a> --}}
    </div>
</body>
</html>
