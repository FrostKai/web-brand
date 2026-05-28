@extends('layouts.app')
@section('title', 'Your Cart')

@section('content')
<section class="section">
  <div class="container">
    <h1 class="display-md" style="margin-bottom:40px;">Your Cart</h1>

    @if(empty($cart))
      <div style="text-align:center;padding:80px 0;">
        <div style="font-size:4rem;margin-bottom:24px;">🛒</div>
        <h2 style="margin-bottom:16px;">Your cart is empty</h2>
        <p style="color:var(--text-muted);margin-bottom:32px;">Add some products to get started.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Shop Now →</a>
      </div>
    @else
      <div class="cart-layout" style="display:grid;grid-template-columns:1fr 380px;gap:40px;align-items:start;">

        {{-- Cart items --}}
        <div class="cart-items">
          @foreach($cart as $item)
            <div class="cart-item">
              <div class="cart-item-img" style="font-size:2.5rem;background:var(--gray-50);width:80px;height:80px;border-radius:var(--radius);display:flex;align-items:center;justify-content:center;">
                @if($item['image'])
                  <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width:100%;height:100%;object-fit:cover;border-radius:var(--radius);" />
                @else
                  {{ $item['emoji'] ?? '🎧' }}
                @endif
              </div>
              <div class="cart-item-info" style="flex:1;">
                <div style="font-weight:600;margin-bottom:4px;">{{ $item['name'] }}</div>
                <div style="color:var(--text-muted);font-size:0.875rem;margin-bottom:8px;">Midnight Blue</div>
                <div style="font-weight:600;color:var(--brand-blue);">${{ number_format($item['price'], 2) }}</div>
              </div>
              <div style="display:flex;flex-direction:column;align-items:flex-end;gap:12px;">
                {{-- Qty --}}
                <form method="POST" action="{{ route('cart.update', $item['slug']) }}" style="display:flex;align-items:center;">
                  @csrf @method('PATCH')
                  <div style="display:flex;align-items:center;border:1.5px solid var(--gray-200);border-radius:100px;">
                    <button type="submit" name="qty" value="{{ $item['qty'] - 1 }}" class="qty-btn">−</button>
                    <span style="padding:0 12px;font-weight:600;">{{ $item['qty'] }}</span>
                    <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}" class="qty-btn">+</button>
                  </div>
                </form>
                <div style="font-weight:700;">${{ number_format($item['price'] * $item['qty'], 2) }}</div>
                <form method="POST" action="{{ route('cart.remove', $item['slug']) }}">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-ghost btn-sm" style="color:#ef4444;padding:4px 10px;">✕ Remove</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>

        {{-- Order summary --}}
        <div class="cart-summary" style="background:var(--gray-50);border-radius:var(--radius-lg);padding:32px;position:sticky;top:100px;">
          <h3 style="font-family:'Fraunces',serif;font-size:1.25rem;margin-bottom:24px;">Order Summary</h3>

          <div class="summary-row"><span>Subtotal ({{ collect($cart)->sum('qty') }} items)</span><span>${{ number_format($subtotal, 2) }}</span></div>
          <div class="summary-row"><span>Shipping</span><span style="color:#22c55e;">Free</span></div>
          <div class="summary-row"><span>Tax (8%)</span><span>${{ number_format($tax, 2) }}</span></div>

          @if(session('promo'))
            <div class="summary-row" style="color:#22c55e;"><span>Promo ({{ session('promo.code') }})</span><span>-{{ session('promo.discount') }}%</span></div>
          @endif

          <div class="summary-row total" style="border-top:1px solid var(--gray-200);padding-top:16px;margin-top:16px;font-weight:700;">
            <span>Total</span>
            <span style="color:var(--brand-blue);font-family:'Fraunces',serif;font-size:1.3rem;">${{ number_format($total, 2) }}</span>
          </div>

          {{-- Promo code --}}
          <form method="POST" action="{{ route('cart.promo') }}" style="display:flex;gap:8px;margin-top:20px;">
            @csrf
            <input type="text" name="code" placeholder="Promo code..." style="flex:1;padding:10px 16px;border:1.5px solid var(--gray-200);border-radius:100px;font-size:0.875rem;" />
            <button type="submit" class="btn btn-outline btn-sm">Apply</button>
          </form>

          <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="width:100%;justify-content:center;display:flex;margin-top:16px;">
            Proceed to Checkout →
          </a>
          <a href="{{ route('products.index') }}" class="btn btn-ghost btn-sm" style="width:100%;justify-content:center;display:flex;margin-top:8px;">
            Continue Shopping
          </a>
        </div>
      </div>
    @endif
  </div>
</section>
@endsection
