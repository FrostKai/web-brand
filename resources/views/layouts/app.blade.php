<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Sonara') — Sound That Moves You</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;0,9..144,700;1,9..144,300;1,9..144,500&display=swap" rel="stylesheet" />

  {{-- Vite compiled CSS/JS --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('head')
</head>

<body>

  {{-- ===========================
     NAVBAR
=========================== --}}
  <nav id="navbar">
    <div class="nav-inner">
      <a href="{{ route('home') }}" class="nav-logo">Sonara<span>.</span></a>

      <div class="nav-links">
        <a href="{{ route('home') }}" @class(['active'=> request()->routeIs('home')])>Home</a>
        <a href="{{ route('products.index') }}" @class(['active'=> request()->routeIs('products.*')])>Products</a>
        <a href="{{ route('about') }}" @class(['active'=> request()->routeIs('about')])>Our Story</a>
        <a href="{{ route('pricing') }}" @class(['active'=> request()->routeIs('pricing')])>Pricing</a>
        <a href="{{ route('contact') }}" @class(['active'=> request()->routeIs('contact')])>Contact</a>
      </div>

      <div class="nav-actions">
        @auth
        @if(auth()->user()->is_admin)
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-sm" style="margin-right: 8px; border-color: var(--accent); color: var(--accent);">Admin Panel 🛠️</a>
        @endif
        <span style="font-size:0.9rem;color:var(--text-muted); margin-right: 8px;">Hi, {{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
          @csrf
          <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
        @endauth

        {{-- Cart button --}}
        <a href="{{ route('cart.index') }}" class="cart-btn" title="Cart">
          🛒
          @php $cartCount = collect(session('cart', []))->sum('qty'); @endphp
          @if($cartCount > 0)
          <span class="cart-badge">{{ $cartCount }}</span>
          @endif
        </a>

        <button class="hamburger" id="hamburger-btn" aria-label="Menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </nav>

  {{-- Mobile menu --}}
  <div class="mobile-menu" id="mobile-menu">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('products.index') }}">Products</a>
    <a href="{{ route('about') }}">Our Story</a>
    <a href="{{ route('pricing') }}">Pricing</a>
    <a href="{{ route('contact') }}">Contact</a>
    <a href="{{ route('cart.index') }}">Cart ({{ $cartCount ?? 0 }})</a>
    @auth
    @if(auth()->user()->is_admin)
    <a href="{{ route('admin.dashboard') }}" style="color: var(--accent);">Admin Panel 🛠️</a>
    @endif
    @endauth
    @guest
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Sign Up</a>
    @endguest
  </div>

  {{-- ===========================
     TOAST NOTIFICATION
=========================== --}}
  @if(session('toast') || session('toast_error'))
  <div id="toast" class="toast show">
    <span id="toast-msg">{{ session('toast') ?? session('toast_error') }}</span>
  </div>
  @endif

  {{-- ===========================
     MAIN CONTENT
=========================== --}}
  <main style="padding-top: 72px;">
    @yield('content')
  </main>

  {{-- ===========================
     FOOTER
=========================== --}}
  <footer style="background:var(--brand-navy);color:var(--white);padding:64px 0 32px;">
    <div class="container">
      <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:48px;">
        <div>
          <div class="nav-logo" style="color:white;margin-bottom:16px;">Sonara<span style="color:var(--brand-blue)">.</span></div>
          <p style="color:rgba(255,255,255,0.6);line-height:1.7;max-width:280px;">Premium audio gear crafted for those who believe sound should move you.</p>
        </div>
        <div>
          <div style="font-weight:600;margin-bottom:16px;">Products</div>
          <div style="display:flex;flex-direction:column;gap:10px;">
            <a href="{{ route('products.index') }}?category=headphones" style="color:rgba(255,255,255,0.6);">Headphones</a>
            <a href="{{ route('products.index') }}?category=earbuds" style="color:rgba(255,255,255,0.6);">Earbuds</a>
            <a href="{{ route('products.index') }}?category=speakers" style="color:rgba(255,255,255,0.6);">Speakers</a>
          </div>
        </div>
        <div>
          <div style="font-weight:600;margin-bottom:16px;">Company</div>
          <div style="display:flex;flex-direction:column;gap:10px;">
            <a href="{{ route('about') }}" style="color:rgba(255,255,255,0.6);">Our Story</a>
            <a href="{{ route('pricing') }}" style="color:rgba(255,255,255,0.6);">Pricing</a>
            <a href="{{ route('contact') }}" style="color:rgba(255,255,255,0.6);">Contact</a>
          </div>
        </div>
        <div>
          <div style="font-weight:600;margin-bottom:16px;">Account</div>
          <div style="display:flex;flex-direction:column;gap:10px;">
            @guest
            <a href="{{ route('login') }}" style="color:rgba(255,255,255,0.6);">Login</a>
            <a href="{{ route('register') }}" style="color:rgba(255,255,255,0.6);">Sign Up</a>
            @endguest
            <a href="{{ route('cart.index') }}" style="color:rgba(255,255,255,0.6);">Cart</a>
          </div>
        </div>
      </div>
      <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:32px;text-align:center;color:rgba(255,255,255,0.4);font-size:0.875rem;">
        © {{ date('Y') }} Sonara. Made with ♥ for music lovers.
      </div>
    </div>
  </footer>

  {{-- Toast auto-dismiss --}}
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
    });

    // Mobile menu toggle
    document.getElementById('hamburger-btn').addEventListener('click', () => {
      document.getElementById('mobile-menu').classList.toggle('open');
    });

    // Auto-dismiss toast
    const toast = document.getElementById('toast');
    if (toast) {
      setTimeout(() => toast.classList.remove('show'), 3500);
    }
  </script>

  @stack('scripts')
</body>

</html>