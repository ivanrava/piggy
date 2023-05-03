<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Piggy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Ubuntu+Mono&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])
    @vite('resources/css/app.css')
</head>
<body>
    <div id="app">
        <router-view></router-view>
    </div>
</body>
</html>
