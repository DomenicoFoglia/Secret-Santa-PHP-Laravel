<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GiftChaos')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>



</head>

<body class="bg-gray-100 font-sans text-gray-900">

    <x-navbar />

    <div class="min-h-screen flex flex-col justify-center items-center bg-green-300 font-sans text-gray-900">
        {{ $slot }}
    </div>

    <x-footer />


</body>

</html>
