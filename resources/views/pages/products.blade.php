@extends('layouts.app')
@section('title', 'Products')

@section('content')
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="label">Our Collection</span>
      <h1 class="display-lg">All Products</h1>
      <p class="body-lg">Find your perfect sound companion.</p>
    </div>

    {{-- Filter & Sort bar --}}
    <form method="GET" action="{{ route('products.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;margin-bottom:48px;">
      <div class="filter-tabs">
        @foreach(['all' => 'All', 'headphones' => 'Headphones', 'earbuds' => 'Earbuds', 'speakers' => 'Speakers'] as $key => $label)
          <button type="submit" name="category" value="{{ $key }}"
            class="filter-tab {{ request('category', 'all') === $key ? 'active' : '' }}">
            {{ $label }}
          </button>
        @endforeach
      </div>
      <select name="sort" onchange="this.form.submit()" style="padding:10px 16px;border:1.5px solid var(--gray-200);border-radius:100px;font-size:0.875rem;background:white;">
        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
        <option value="price-asc" {{ request('sort') === 'price-asc' ? 'selected' : '' }}>Price: Low to High</option>
        <option value="price-desc" {{ request('sort') === 'price-desc' ? 'selected' : '' }}>Price: High to Low</option>
        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top Rated</option>
        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
      </select>
      @if(request('category') && request('category') !== 'all')
        <input type="hidden" name="category" value="{{ request('category') }}" />
      @endif
    </form>

    @if($products->isEmpty())
      <div style="text-align:center;padding:80px 0;color:var(--text-muted);">
        <div style="font-size:3rem;margin-bottom:16px;">🎧</div>
        <p>No products found in this category.</p>
        <a href="{{ route('products.index') }}" class="btn btn-outline" style="margin-top:16px;">View All</a>
      </div>
    @else
      <div class="products-grid">
        @foreach($products as $product)
          @include('components.product-card', ['product' => $product])
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
