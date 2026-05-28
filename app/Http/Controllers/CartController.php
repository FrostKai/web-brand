<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Helper: get cart from session
    private function getCart(): array
    {
        return session('cart', []);
    }

    // Helper: save cart to session
    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart     = $this->getCart();
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $tax      = round($subtotal * 0.08, 2);
        $promo    = session('promo');
        $discount = $promo ? round($subtotal * ($promo['discount'] / 100), 2) : 0;
        $total    = $subtotal + $tax - $discount;

        return view('pages.cart', compact('cart', 'subtotal', 'tax', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $qty  = max(1, (int) $request->input('qty', 1));
        $cart = $this->getCart();

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'id'    => $product->id,
                'slug'  => $product->slug,
                'name'  => $product->name,
                'price' => $product->price,
                'emoji' => $product->emoji,
                'image' => $product->image_url,
                'qty'   => $qty,
            ];
        }

        $this->saveCart($cart);

        if ($request->wantsJson()) {
            return response()->json([
                'cart_count' => collect($cart)->sum('qty'),
                'message'    => $product->name . ' added to cart!',
            ]);
        }

        return back()->with('toast', $product->name . ' added to cart! 🛒');
    }

    public function update(Request $request, Product $product)
    {
        $cart = $this->getCart();
        $qty  = (int) $request->input('qty', 1);

        if ($qty <= 0) {
            unset($cart[$product->id]);
        } elseif (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] = $qty;
        }

        $this->saveCart($cart);
        return redirect()->route('cart.index');
    }

    public function remove(Product $product)
    {
        $cart = $this->getCart();
        unset($cart[$product->id]);
        $this->saveCart($cart);

        return redirect()->route('cart.index')->with('toast', 'Item removed from cart.');
    }

    public function applyPromo(Request $request)
    {
        $code = strtoupper(trim($request->input('code', '')));

        $validCodes = [
            'SONARA10' => 10,
            'WELCOME20' => 20,
        ];

        if (array_key_exists($code, $validCodes)) {
            session(['promo' => ['code' => $code, 'discount' => $validCodes[$code]]]);
            return back()->with('toast', "Promo code {$code} applied! {$validCodes[$code]}% off 🎉");
        }

        return back()->with('toast_error', 'Invalid promo code.');
    }
}
