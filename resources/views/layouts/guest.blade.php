<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="favicon" href=" {{ asset('images/favicon.png') }}" type="image/png">
    <title>MealMate - @yield('title')</title>

    {{-- Vite assets --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Fuente Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <main class="flex-grow-1 py-4">
        @yield('content')
    </main>
</body>

</html>
