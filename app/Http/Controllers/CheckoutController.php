<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('toast', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $tax      = round($subtotal * 0.08, 2);
        $promo    = session('promo');
        $discount = $promo ? round($subtotal * ($promo['discount'] / 100), 2) : 0;

        return view('pages.checkout', compact('cart', 'subtotal', 'tax', 'discount', 'promo'));
    }

    public function place(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'email'           => 'required|email',
            'address'         => 'required|string',
            'city'            => 'required|string',
            'postal_code'     => 'required|string',
            'country'         => 'required|string',
            'shipping_method' => 'required|in:standard,express,overnight',
        ]);

        $shippingCosts = ['standard' => 0, 'express' => 9.99, 'overnight' => 24.99];
        $subtotal      = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $shippingCost  = $shippingCosts[$request->shipping_method];
        $tax           = round($subtotal * 0.08, 2);
        $promo         = session('promo');
        $discount      = $promo ? round($subtotal * ($promo['discount'] / 100), 2) : 0;
        $total         = $subtotal + $shippingCost + $tax - $discount;

        DB::transaction(function () use ($request, $cart, $subtotal, $shippingCost, $tax, $total, $discount, $promo) {
            $order = Order::create([
                'user_id'         => auth()->id(),
                'first_name'      => $request->first_name,
                'last_name'       => $request->last_name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'address'         => $request->address,
                'city'            => $request->city,
                'postal_code'     => $request->postal_code,
                'country'         => $request->country,
                'shipping_method' => $request->shipping_method,
                'subtotal'        => $subtotal,
                'shipping_cost'   => $shippingCost,
                'tax'             => $tax,
                'discount'        => $discount,
                'total'           => $total,
                'promo_code'      => $promo['code'] ?? null,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['id'],
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'quantity'     => $item['qty'],
                ]);
            }

            session()->forget(['cart', 'promo']);
        });

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        return view('pages.checkout-success');
    }
}
