<!DOCTYPE html>
<html lang="en" class="@yield('html')">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('app.name', 'Shop'))</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="min-h-screen antialiased text-gray-900 @yield('body', 'bg-gray-50')">
    <x-navbar />
    <main>
        @yield('content')
    </main>
</body>
</html>
