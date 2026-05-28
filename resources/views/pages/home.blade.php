@extends('layouts.app')
@section('title', 'Home')

@section('content')

{{-- HERO --}}
<section class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-text fade-in">
        <span class="label">Introducing Nova Pro X</span>
        <h1 class="display-xl" style="margin:20px 0 28px;">
          Sound That<br><em style="color:var(--brand-blue);font-style:italic;">Moves</em><br>You.
        </h1>
        <p class="body-lg" style="margin-bottom:40px;max-width:440px;">
          Experience audio elevated to an art form. Premium headphones, earbuds, and speakers crafted for those who refuse to compromise on sound.
        </p>
        <div style="display:flex;gap:16px;flex-wrap:wrap;">
          <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Shop Now →</a>
          <a href="{{ route('about') }}" class="btn btn-outline btn-lg">Our Story</a>
        </div>
        <div style="display:flex;gap:32px;margin-top:48px;flex-wrap:wrap;">
          <div><div style="font-size:1.5rem;font-weight:700;font-family:'Fraunces',serif;">40h</div><div style="color:var(--text-muted);font-size:0.875rem;">Battery Life</div></div>
          <div><div style="font-size:1.5rem;font-weight:700;font-family:'Fraunces',serif;">98%</div><div style="color:var(--text-muted);font-size:0.875rem;">Noise Cancelled</div></div>
          <div><div style="font-size:1.5rem;font-weight:700;font-family:'Fraunces',serif;">10k+</div><div style="color:var(--text-muted);font-size:0.875rem;">Happy Listeners</div></div>
        </div>
      </div>
      <div class="hero-visual fade-in-delay-2">
        <div class="hero-bg-circle"></div>
        <div class="hero-product-img">
          <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80" alt="Premium Headphones" />
        </div>
        <div class="hero-badge b1">
          <div class="badge-icon">🎧</div>
          <div>
            <div class="badge-text">Studio Pro X</div>
            <div class="badge-sub">Best Seller 2025</div>
          </div>
        </div>
        <div class="hero-badge b2">
          <div class="badge-icon">⚡</div>
          <div>
            <div class="badge-text">Fast Charging</div>
            <div class="badge-sub">10 min → 3 hours</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- BRANDS STRIP --}}
<div class="brands-strip">
  <div class="container">
    <div style="overflow:hidden;">
      <div class="brands-scroll">
        <span>Trusted by audiophiles worldwide</span>
        <span>·</span><span>TechCrunch Pick 2025</span>
        <span>·</span><span>What Hi-Fi? Award</span>
        <span>·</span><span>CES Innovation Award</span>
        <span>·</span><span>10,000+ 5-Star Reviews</span>
        <span>·</span><span>Trusted by audiophiles worldwide</span>
        <span>·</span><span>TechCrunch Pick 2025</span>
        <span>·</span><span>What Hi-Fi? Award</span>
      </div>
    </div>
  </div>
</div>

{{-- FEATURES --}}
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="label">Why choose Sonara</span>
      <h2 class="display-lg">Built for the way <em style="color:var(--brand-blue);font-style:italic;">you</em> listen</h2>
      <p class="body-lg" style="max-width:480px;margin:0 auto;">Every product is crafted with precision engineering and obsessive attention to acoustic detail.</p>
    </div>
    <div class="features-grid">
      @foreach([
        ['🔊','Studio-Grade Sound','Experience music the way the artist intended. 40mm dynamic drivers deliver crystal-clear highs, rich mids, and deep bass.'],
        ['🔋','All-Day Battery','Up to 40 hours of continuous playback. 10 minutes charging gives you 3 hours of listening.'],
        ['🛡️','Active Noise Cancellation','Three levels of ANC powered by 6 microphones. From ambient filter to complete silence.'],
        ['🎨','Premium Design','Aircraft-grade aluminum and premium leather. Engineered to look as good as it sounds.'],
        ['📡','Seamless Connectivity','Bluetooth 5.3 with multipoint connection. Switch instantly between devices.'],
        ['🌊','Water Resistant','IPX4 rating for your active lifestyle without sacrificing audio quality.'],
      ] as [$icon, $title, $desc])
        <div class="feature-card">
          <div class="feature-icon">{{ $icon }}</div>
          <h3 class="feature-title">{{ $title }}</h3>
          <p class="feature-desc">{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- FEATURED PRODUCTS --}}
<section class="section" style="background: var(--gray-50);">
  <div class="container">
    <div class="section-header">
      <span class="label">Featured Collection</span>
      <h2 class="display-lg">Our bestsellers</h2>
      <p class="body-lg" style="max-width:440px;margin:0 auto;">Hand-picked favorites loved by thousands of listeners worldwide.</p>
    </div>
    <div class="products-grid">
      @foreach($featuredProducts as $product)
        @include('components.product-card', ['product' => $product])
      @endforeach
    </div>
    <div style="text-align:center;margin-top:48px;">
      <a href="{{ route('products.index') }}" class="btn btn-outline btn-lg">View All Products →</a>
    </div>
  </div>
</section>

{{-- DARK BANNER --}}
<section class="section">
  <div class="container">
    <div class="dark-banner">
      <div>
        <span class="label">Limited Time Offer</span>
        <h2 class="display-lg" style="margin-top:12px;margin-bottom:16px;">Comfortable buds with <em style="font-style:italic;">better</em> sound</h2>
        <p class="body-lg" style="margin-bottom:32px;">Experience the Sonara Buds Pro — 8mm drivers, 36-hour total playtime, and a fit so comfortable you'll forget you're wearing them.</p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
          <form method="POST" action="{{ route('cart.add', 'buds-pro') }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
          </form>
          <a href="{{ route('products.show', 'buds-pro') }}" class="btn" style="background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);">Learn More</a>
        </div>
      </div>
      <div class="dark-banner-visual">
        <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500&q=80" alt="Earbuds" />
      </div>
    </div>
  </div>
</section>

{{-- TESTIMONIALS --}}
<section class="section" style="background: var(--gray-50);">
  <div class="container">
    <div class="section-header">
      <span class="label">Customer Love</span>
      <h2 class="display-lg">What our listeners say</h2>
    </div>
    <div class="testimonials-grid">
      @foreach([
        ['A','Alex Whitmore','Music Producer · New York','These are hands-down the best headphones I\'ve ever owned. The ANC is incredible, the sound is warm and detailed, and they\'re incredibly comfortable for long sessions.'],
        ['M','Maya Chen','Software Engineer · San Francisco','I wear these on my commute every day. The battery lasts all week, the fit is secure, and the sound quality rivals headphones twice the price.'],
        ['S','Sarah Park','Designer · London','Bought as a gift for my husband and he absolutely loves them. The build quality is phenomenal. Worth every penny.'],
      ] as [$initial, $name, $role, $quote])
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"{{ $quote }}"</p>
          <div class="testimonial-author">
            <div class="author-avatar">{{ $initial }}</div>
            <div>
              <div class="author-name">{{ $name }}</div>
              <div class="author-role">{{ $role }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- NEWSLETTER --}}
<section class="section">
  <div class="container" style="max-width:600px;">
    <div class="section-header">
      <span class="label">Stay in the loop</span>
      <h2 class="display-lg">Join 50,000+ listeners</h2>
      <p class="body-lg">Get exclusive deals, new product launches, and listening tips delivered to your inbox.</p>
    </div>
    <form method="POST" action="{{ route('newsletter.subscribe') }}" style="display:flex;gap:12px;max-width:480px;margin:0 auto;">
      @csrf
      <input type="email" name="email" placeholder="your@email.com" required
        style="flex:1;padding:14px 20px;border:1.5px solid var(--gray-200);border-radius:100px;font-size:0.9375rem;" />
      <button type="submit" class="btn btn-primary">Subscribe</button>
    </form>
  </div>
</section>

@endsection
