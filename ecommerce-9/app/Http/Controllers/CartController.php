<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session()->get('cart', []);
        $items = collect($cart)->values();
        $subtotal = $items->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('items', 'subtotal'));
    }

    public function add(Products $product): RedirectResponse
    {
        $cart = session()->get('cart', []);
        $key = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += 1;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => (int) $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', $product->name.' berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Products $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session()->get('cart', []);
        $key = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $validated['quantity'];
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function remove(Products $product): RedirectResponse
    {
        $cart = session()->get('cart', []);
        $key = (string) $product->id;

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkoutPage(): View
    {
        $cart = session()->get('cart', []);
        $items = collect($cart)->values();
        $subtotal = $items->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('checkout', compact('items', 'subtotal'));
    }

    public function checkout(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_address' => ['required', 'string'],
            'payment_method' => ['required', 'string'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang masih kosong.');
        }

        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk checkout.');
        }

        $totalAmount = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'order_number' => 'ORD-'.strtoupper(bin2hex(random_bytes(4))),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'user_id' => $user->id,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Checkout berhasil. Pesanan Anda sedang diproses.');
    }
}
