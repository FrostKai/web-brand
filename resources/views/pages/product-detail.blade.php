@extends('layouts.app')
@section('title', $product->name)

@section('content')
<section class="section">
  <div class="container">
    <a href="{{ route('products.index') }}" style="color:var(--text-muted);font-size:0.9rem;display:inline-flex;align-items:center;gap:6px;margin-bottom:32px;">
      ← Back to Products
    </a>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:start;">
      {{-- Image --}}
      <div>
        <div style="background:var(--gray-50);border-radius:var(--radius-lg);padding:48px;text-align:center;">
          @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="max-height:380px;object-fit:contain;margin:0 auto;" />
          @else
            <div style="font-size:8rem;">{{ $product->emoji }}</div>
          @endif
        </div>

        {{-- Color swatches --}}
        @if($product->colors)
          <div style="margin-top:24px;">
            <div style="font-size:0.875rem;font-weight:600;margin-bottom:12px;">Colors</div>
            <div style="display:flex;gap:10px;">
              @foreach($product->colors as $color)
                <div style="width:28px;height:28px;border-radius:50%;background:{{ $color }};border:2px solid white;box-shadow:0 0 0 2px var(--gray-200);cursor:pointer;"></div>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      {{-- Info --}}
      <div>
        @if($product->badge)
          <span class="product-badge badge-{{ $product->badge_type }}" style="position:static;display:inline-block;margin-bottom:12px;">{{ $product->badge }}</span>
        @endif

        <span style="color:var(--text-muted);font-size:0.875rem;">{{ $product->category_label }}</span>
        <h1 class="display-md" style="margin:8px 0 16px;">{{ $product->name }}</h1>

        <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
          <span style="color:#f59e0b;font-size:1.1rem;">{{ str_repeat('★', floor($product->rating)) }}</span>
          <span style="font-weight:600;">{{ $product->rating }}</span>
          <span style="color:var(--text-muted);">({{ number_format($product->reviews_count) }} reviews)</span>
        </div>

        <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
          <span style="font-size:2rem;font-weight:700;font-family:'Fraunces',serif;color:var(--brand-blue);">${{ number_format($product->price, 2) }}</span>
          @if($product->old_price)
            <span style="font-size:1.2rem;text-decoration:line-through;color:var(--text-muted);">${{ number_format($product->old_price, 2) }}</span>
            <span style="background:#fef2f2;color:#ef4444;padding:4px 10px;border-radius:100px;font-size:0.8rem;font-weight:600;">-{{ $product->discount_percent }}%</span>
          @endif
        </div>

        <p style="color:var(--text-muted);line-height:1.7;margin-bottom:32px;">{{ $product->description }}</p>

        {{-- Qty + Add to cart --}}
        <form method="POST" action="{{ route('cart.add', $product->slug) }}" style="display:flex;gap:12px;align-items:center;margin-bottom:24px;">
          @csrf
          <div style="display:flex;align-items:center;border:1.5px solid var(--gray-200);border-radius:100px;overflow:hidden;">
            <button type="button" onclick="adjustQty(-1)" class="qty-btn">−</button>
            <input type="number" name="qty" id="qty-input" value="1" min="1" max="{{ $product->stock }}"
              style="width:48px;text-align:center;border:none;font-weight:600;font-size:1rem;" readonly />
            <button type="button" onclick="adjustQty(1)" class="qty-btn">+</button>
          </div>
          <button type="submit" class="btn btn-primary btn-lg" style="flex:1;justify-content:center;">
            Add to Cart 🛒
          </button>
        </form>

        <a href="{{ route('checkout.index') }}" class="btn btn-dark btn-lg" style="width:100%;justify-content:center;display:flex;">Buy Now →</a>

        {{-- Specs --}}
        @if($product->specs)
          <div style="margin-top:40px;border-top:1px solid var(--gray-200);padding-top:32px;">
            <h3 style="font-weight:600;margin-bottom:16px;">Specifications</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
              @foreach($product->specs as [$key, $val])
                <div style="background:var(--gray-50);padding:12px 16px;border-radius:var(--radius);">
                  <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;">{{ $key }}</div>
                  <div style="font-weight:600;font-size:0.9rem;">{{ $val }}</div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </div>
    </div>

    {{-- Related --}}
    @if($related->isNotEmpty())
      <div style="margin-top:80px;">
        <h2 class="display-md" style="margin-bottom:32px;">You might also like</h2>
        <div class="products-grid">
          @foreach($related as $rel)
            @include('components.product-card', ['product' => $rel])
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>

@push('scripts')
<script>
  function adjustQty(delta) {
    const input = document.getElementById('qty-input');
    const newVal = Math.max(1, Math.min({{ $product->stock }}, parseInt(input.value) + delta));
    input.value = newVal;
  }
</script>
@endpush
@endsection
