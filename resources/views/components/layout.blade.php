<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Secret Santa')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="bg-gray-100 font-sans text-gray-900">

    <div class="min-h-screen flex flex-col justify-center items-center bg-green-300 font-sans text-gray-900">
        {{ $slot }}
    </div>


</body>

</html>
