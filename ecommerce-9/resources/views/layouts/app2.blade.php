<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z Shop - @yield('title', 'E-Commerce')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background:
                radial-gradient(circle at top left, rgba(248, 113, 113, 0.18), transparent 28%),
                radial-gradient(circle at bottom right, rgba(251, 146, 60, 0.14), transparent 24%),
                linear-gradient(180deg, #fff7f7 0%, #ffffff 38%, #fffaf5 100%);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.76);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .soft-shadow {
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
        }
    </style>
</head>
<body class="flex min-h-screen flex-col bg-white text-slate-900">

    {{-- Component Navbar --}}
    @include('components.navbar')

    {{-- Content Area --}}
    <main class="mx-auto flex w-full max-w-7xl flex-grow px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full">
            @yield('content')
        </div>
    </main>

    {{-- Component Footer --}}
    @include('components.footer')

</body>
</html>