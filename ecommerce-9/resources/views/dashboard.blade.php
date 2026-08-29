@extends('layouts.app2')

@section('title', 'Dashboard')

@section('content')
    @php
        $totalProducts = \App\Models\Products::count();
        $totalCategories = \App\Models\ProductCategory::count();
        $totalProductClicks = \App\Models\Products::sum('click_count') ?? 0;
        $totalOrders = \App\Models\Order::count();
        $categoryChart = \App\Models\ProductCategory::withCount('products')->get();
        $maxCategoryProducts = $categoryChart->max('products_count') ?: 1;

        $weeklyOrders = collect();
        for ($i = 5; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $end = now()->subWeeks($i)->endOfWeek();
            $count = \App\Models\Order::whereBetween('created_at', [$start, $end])->count();
            $weeklyOrders->push([
                'label' => $start->format('d M'),
                'value' => $count,
            ]);
        }

        $maxWeeklyOrder = $weeklyOrders->max('value') ?: 1;

        $stats = [
            ['label' => 'Jumlah Produk', 'value' => $totalProducts, 'icon' => '🛍️', 'color' => 'bg-red-50 text-red-600'],
            ['label' => 'Jumlah Kategori Produk', 'value' => $totalCategories, 'icon' => '📂', 'color' => 'bg-orange-50 text-orange-600'],
            ['label' => 'Jumlah Klik Produk', 'value' => $totalProductClicks, 'icon' => '👁️', 'color' => 'bg-yellow-50 text-yellow-600'],
            ['label' => 'Jumlah Order', 'value' => $totalOrders, 'icon' => '🧾', 'color' => 'bg-emerald-50 text-emerald-600'],
        ];
    @endphp

    <div class="mb-8 rounded-3xl bg-gradient-to-r from-red-600 via-red-500 to-orange-400 p-6 text-white shadow-lg shadow-red-200">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-red-100">Overview</p>
                <h1 class="mt-2 text-3xl font-black md:text-4xl">Selamat Datang</h1>
            </div>
            <div class="rounded-full bg-white/15 px-4 py-2 text-sm font-semibold backdrop-blur-sm">
                {{ __('You\'re logged in!') }}
            </div>
        </div>
    </div>

    <div class="mb-8 text-center text-black">
        <h2 class="mb-2 text-2xl font-extrabold">Ringkasan Informasi</h2>
        <p class="text-lg text-gray-600">Informasi singkat mengenai performa toko Anda.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="rounded-xl {{ $stat['color'] }} p-3 text-2xl">{{ $stat['icon'] }}</span>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Live</span>
                </div>
                <div class="mt-5 text-sm font-medium text-gray-500">{{ $stat['label'] }}</div>
                <div class="mt-3 text-3xl font-bold text-black">{{ $stat['value'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-[1.4fr_0.9fr]">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-black">Distribusi Kategori</h3>
                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Diagram</span>
            </div>

            <div class="mt-6 space-y-5">
                @forelse ($categoryChart as $category)
                    @php
                        $percentage = ($category->products_count / $maxCategoryProducts) * 100;
                    @endphp
                    <div>
                        <div class="mb-1 flex items-center justify-between text-sm">
                            <span class="font-medium text-gray-700">{{ $category->name }}</span>
                            <span class="font-bold text-black">{{ $category->products_count }}</span>
                        </div>
                        <div class="h-2.5 overflow-hidden rounded-full bg-gray-100">
                            <div class="h-full rounded-full bg-gradient-to-r from-red-500 to-orange-400" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada data kategori produk.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="text-xl font-bold text-black">Catatan</h3>
            <div class="mt-6 space-y-3">
                <div class="rounded-xl border-l-4 border-red-500 bg-red-50 p-3 text-sm text-gray-700">
                    Produk dengan klik paling tinggi bisa dijadikan fokus promosi.
                </div>
                <div class="rounded-xl border-l-4 border-amber-500 bg-amber-50 p-3 text-sm text-gray-700">
                    Kategori produk masih perlu didorong untuk meningkatkan penjualan.
                </div>
                <div class="rounded-xl border-l-4 border-emerald-500 bg-emerald-50 p-3 text-sm text-gray-700">
                    Order aktif menunjukkan toko sedang berjalan dengan cukup baik.
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-bold text-black">Order per Minggu</h3>
            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Weekly</span>
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
@endsection
