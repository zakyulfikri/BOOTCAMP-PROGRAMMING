<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(248,113,113,0.18),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(251,146,60,0.14),_transparent_24%),linear-gradient(135deg,_#fff7f7_0%,_#ffffff_38%,_#fffaf5_100%)] text-slate-900">
            <div class="mx-auto grid min-h-screen max-w-7xl items-center gap-10 px-4 py-10 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
                <div class="hidden rounded-[32px] bg-slate-950 p-8 text-white shadow-[0_30px_80px_rgba(15,23,42,0.35)] lg:block">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-red-500 to-orange-400 text-lg font-black text-white shadow-lg shadow-red-200">Z</span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.25em] text-red-200">Premium Store</p>
                            <h1 class="text-2xl font-black">Z Shop</h1>
                        </div>
                    </div>

                    <div class="mt-10 space-y-6">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-red-200">Selamat datang</p>
                            <h2 class="mt-3 text-4xl font-black leading-tight">Temukan produk yang cocok dengan gaya hidup Anda.</h2>
                        </div>

                        <p class="max-w-md text-base text-slate-300">
                            Nikmati pengalaman berbelanja yang lebih cepat, lebih aman, dan lebih nyaman dengan koleksi produk terbaik kami.
                        </p>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                                <div class="text-2xl font-black text-white">5K+</div>
                                <div class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-300">Pelanggan</div>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                                <div class="text-2xl font-black text-white">120+</div>
                                <div class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-300">Produk</div>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                                <div class="text-2xl font-black text-white">4.9</div>
                                <div class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-300">Rating</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <div class="mx-auto w-full max-w-md overflow-hidden rounded-[28px] border border-white/70 bg-white/80 p-6 shadow-[0_25px_60px_rgba(15,23,42,0.12)] backdrop-blur-xl sm:p-8">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-red-500">Akses akun</p>
                                <h3 class="mt-2 text-3xl font-black text-slate-900">Z Shop</h3>
                            </div>
                            <a href="/" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 text-slate-700 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                            </a>
                        </div>

                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
