<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
    <title>Piggy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Josefin+Slab&family=Ubuntu+Mono&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])
    @vite('resources/css/app.css')
</head>
<body class="h-full flex flex-col justify-center align-middle">
    <div id="app" class="h-full flex justify-center align-middle">
        <router-view></router-view>
    </div>
</body>
</html>
