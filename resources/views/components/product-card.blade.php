{{-- resources/views/components/product-card.blade.php --}}
<div class="product-card">
  @if($product->badge)
    <div class="product-badge badge-{{ $product->badge_type }}">{{ $product->badge }}</div>
  @endif

  <div class="product-img">
    @if($product->image_url)
      <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" />
    @else
      <div style="font-size:4rem;display:flex;align-items:center;justify-content:center;height:100%;">{{ $product->emoji }}</div>
    @endif
  </div>

  <div class="product-info">
    <div class="product-category">{{ $product->category_label }}</div>
    <div class="product-name">{{ $product->name }}</div>

    <div class="product-rating">
      <span class="stars">{{ str_repeat('★', floor($product->rating)) }}{{ $product->rating - floor($product->rating) >= 0.5 ? '½' : '' }}</span>
      <span class="rating-num">{{ $product->rating }}</span>
      <span class="rating-count">({{ number_format($product->reviews_count) }})</span>
    </div>

    <div class="product-footer">
      <div class="product-price">
        ${{ number_format($product->price, 0) }}
        @if($product->old_price)
          <span class="product-price-old">${{ number_format($product->old_price, 0) }}</span>
        @endif
      </div>
      <div style="display:flex;gap:8px;">
        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline btn-sm">View</a>
        <form method="POST" action="{{ route('cart.add', $product->slug) }}">
          @csrf
          <button type="submit" class="btn btn-primary btn-sm">+ Cart</button>
        </form>
      </div>
    </div>
  </div>
</div>
