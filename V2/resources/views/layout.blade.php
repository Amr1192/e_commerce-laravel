@props(['products'])
<!DOCTYPE html>
<html lang="en" class="@yield('html')">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<body class="@yield('body')">
   <x-navbar></x-navbar>
   @yield('content')
</body>
</html>