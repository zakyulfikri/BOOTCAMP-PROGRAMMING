<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\Products;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProducts = Products::count();
        $totalCategories = ProductCategory::count();
        $totalProductClicks = Products::sum('click_count') ?? 0;
        $totalOrders = Order::count();

        $productChart = Products::orderByDesc('click_count')->take(5)->get();
        $maxProductClicks = $productChart->max('click_count') ?: 1;

        $weeklyOrders = collect();
        for ($i = 5; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $end = now()->subWeeks($i)->endOfWeek();
            $count = Order::whereBetween('created_at', [$start, $end])->count();

            $weeklyOrders->push([
                'label' => $start->format('d M'),
                'value' => $count,
            ]);
        }

        $maxWeeklyOrder = $weeklyOrders->max('value') ?: 1;
        $recentOrders = Order::latest()->take(5)->get();

        $stats = [
            ['label' => 'Jumlah Produk', 'value' => $totalProducts, 'icon' => '🛍️', 'color' => 'bg-red-50 text-red-600'],
            ['label' => 'Jumlah Kategori Produk', 'value' => $totalCategories, 'icon' => '📂', 'color' => 'bg-orange-50 text-orange-600'],
            ['label' => 'Jumlah Klik Produk', 'value' => $totalProductClicks, 'icon' => '👁️', 'color' => 'bg-yellow-50 text-yellow-600'],
            ['label' => 'Jumlah Order', 'value' => $totalOrders, 'icon' => '🧾', 'color' => 'bg-emerald-50 text-emerald-600'],
        ];

        return view('dashboard', compact(
            'stats',
            'productChart',
            'weeklyOrders',
            'maxProductClicks',
            'maxWeeklyOrder',
            'recentOrders'
        ));
    }
}
