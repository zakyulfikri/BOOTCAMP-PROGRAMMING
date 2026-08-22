<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z Shop - @yield('title', 'E-Commerce')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900 flex flex-col min-h-screen">

    {{-- Component Navbar --}}
    @include('components.navbar')

    {{-- Content Area --}}
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- Component Footer --}}
    @include('components.footer')

</body>
</html>