<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Prestamos') }}</title>
    <link rel="icon" href="https://images.icon-icons.com/474/PNG/512/wallet_46876.png" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-gray-900">
    {{ $slot }}
</body>
</html>
