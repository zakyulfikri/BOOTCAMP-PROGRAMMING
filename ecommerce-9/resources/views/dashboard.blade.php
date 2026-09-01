@extends('layouts.app2')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl bg-gradient-to-r from-red-600 via-red-500 to-orange-400 p-6 text-white shadow-lg shadow-red-200 ring-1 ring-white/20">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-red-100">Overview</p>
                    <h1 class="mt-2 text-3xl font-black md:text-4xl">Selamat Datang</h1>
                    <p class="mt-2 text-sm text-red-50">Ringkasan performa toko Anda hari ini.</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-2 text-sm font-medium backdrop-blur-sm">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-300"></span>
                        Online
                    </span>
                    <span class="rounded-full bg-white/10 px-3 py-2 text-sm font-medium backdrop-blur-sm">
                        {{ now()->translatedFormat('d M Y') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl {{ $stat['color'] }} text-2xl shadow-inner">
                            {{ $stat['icon'] }}
                        </span>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">
                            Live
                        </span>
                    </div>

                    <div class="mt-5">
                        <p class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $stat['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.45fr_0.95fr]">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Performance</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Distribusi Kategori</h3>
                    </div>
                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Diagram</span>
                </div>

                <div class="mt-6 space-y-5">
                    @forelse ($categoryChart as $category)
                        @php
                            $percentage = ($category->products_count / $maxCategoryProducts) * 100;
                        @endphp
                        <div>
                            <div class="mb-1.5 flex items-center justify-between text-sm">
                                <span class="font-semibold text-slate-700">{{ $category->name }}</span>
                                <span class="font-bold text-slate-900">{{ $category->products_count }}</span>
                            </div>
                            <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-gradient-to-r from-red-500 to-orange-400" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada data kategori produk.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Insights</p>
                        <h3 class="mt-1 text-xl font-bold text-slate-900">Catatan</h3>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    <div class="rounded-xl border-l-4 border-red-500 bg-red-50 p-3 text-sm text-slate-700">
                        Produk dengan klik paling tinggi bisa dijadikan fokus promosi utama.
                    </div>
                    <div class="rounded-xl border-l-4 border-amber-500 bg-amber-50 p-3 text-sm text-slate-700">
                        Kategori produk masih perlu didorong agar penjualan lebih merata.
                    </div>
                    <div class="rounded-xl border-l-4 border-emerald-500 bg-emerald-50 p-3 text-sm text-slate-700">
                        Order aktif menunjukkan toko Anda sedang berjalan dengan cukup baik.
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Trend</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Order per Minggu</h3>
                </div>
                <span class="w-fit rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Weekly</span>
            </div>

            @php
                $linePoints = [];
                $chartWidth = 620;
                $chartHeight = 180;
                $padding = 24;
                $stepX = count($weeklyOrders) > 1 ? ($chartWidth - ($padding * 2)) / (count($weeklyOrders) - 1) : 0;

                foreach ($weeklyOrders as $index => $order) {
                    $x = $padding + ($index * $stepX);
                    $y = $chartHeight - $padding - (($order['value'] / max($maxWeeklyOrder, 1)) * ($chartHeight - ($padding * 2)));
                    $linePoints[] = $x . ',' . $y;
                }

                $linePath = implode(' ', $linePoints);
            @endphp

            <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" class="h-52 w-full overflow-visible">
                <defs>
                    <linearGradient id="orderLineGradient" x1="0%" x2="100%" y1="0%" y2="0%">
                        <stop offset="0%" stop-color="#10b981" />
                        <stop offset="100%" stop-color="#22c55e" />
                    </linearGradient>
                </defs>

                @for ($i = 0; $i <= 4; $i++)
                    @php
                        $y = $padding + (($chartHeight - ($padding * 2)) / 4) * $i;
                    @endphp
                    <line x1="{{ $padding }}" y1="{{ $y }}" x2="{{ $chartWidth - $padding }}" y2="{{ $y }}" stroke="#e5e7eb" stroke-dasharray="4 6" />
                @endfor

                <polyline
                    fill="none"
                    stroke="url(#orderLineGradient)"
                    stroke-width="4"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    points="{{ $linePath }}"
                ></polyline>

                @foreach ($weeklyOrders as $index => $order)
                    @php
                        $x = $padding + ($index * $stepX);
                        $y = $chartHeight - $padding - (($order['value'] / max($maxWeeklyOrder, 1)) * ($chartHeight - ($padding * 2)));
                    @endphp
                    <circle cx="{{ $x }}" cy="{{ $y }}" r="5" fill="#10b981" stroke="#ffffff" stroke-width="3"></circle>
                    <text x="{{ $x }}" y="{{ $chartHeight - 4 }}" text-anchor="middle" font-size="10" fill="#6b7280">{{ $order['label'] }}</text>
                    <text x="{{ $x }}" y="{{ $y - 12 }}" text-anchor="middle" font-size="10" fill="#111827" font-weight="700">{{ $order['value'] }}</text>
                @endforeach
            </svg>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Orders</p>
                    <h3 class="mt-1 text-xl font-bold text-slate-900">Order Terbaru</h3>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">5 items</span>
            </div>

            <div class="overflow-hidden rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Order</th>
                            <th class="px-4 py-3 font-semibold">Pelanggan</th>
                            <th class="px-4 py-3 font-semibold">Total</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($recentOrders as $order)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $order->order_number }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $order->customer_name }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                        @if ($order->status === 'completed') bg-emerald-100 text-emerald-700
                                        @elseif ($order->status === 'pending') bg-amber-100 text-amber-700
                                        @else bg-slate-200 text-slate-700
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
