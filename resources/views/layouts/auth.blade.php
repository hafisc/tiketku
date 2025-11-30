<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Tiketku - Autentikasi')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-br from-[rgba(10,154,242,0.05)] via-blue-50 to-white min-h-screen flex items-center justify-center">
    

    {{-- Main Content --}}
    <main class="w-full px-4">
        @yield('content')
    </main>
</body>
</html>
