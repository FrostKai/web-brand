@extends('layouts.app')
@section('title', 'Our Story')

@section('content')

{{-- ABOUT HERO --}}
<section style="background: linear-gradient(135deg, #f8f9ff 0%, #eef1ff 100%); padding: 120px 0 80px;">
  <div class="container" style="max-width: 720px; text-align: center;">
    <span class="label">Our Story</span>
    <h1 class="display-xl" style="margin-top: 16px; margin-bottom: 20px;">
      We are here to help our customers get their success
    </h1>
    <p class="body-lg">
      Founded in 2019, Sonara was born from a simple belief: everyone deserves extraordinary audio.
      We're a team of engineers, musicians, and designers obsessed with sound.
    </p>
  </div>
</section>

{{-- STORY SECTION --}}
<section class="section">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;">
      {{-- Image --}}
      <div>
        <div style="border-radius: var(--radius-lg); overflow: hidden; height: 420px;">
          <img
            src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80"
            alt="Team at work"
            style="width: 100%; height: 100%; object-fit: cover;"
          />
        </div>
      </div>

      {{-- Text --}}
      <div>
        <span class="label">Since 2019</span>
        <h2 class="display-md" style="margin-top: 12px; margin-bottom: 20px;">
          Built by audio lovers, for audio lovers
        </h2>
        <p class="body-md" style="margin-bottom: 16px;">
          We started in a small studio in Brooklyn, convinced we could build headphones that didn't
          compromise on anything — not sound, not design, not sustainability.
        </p>
        <p class="body-md" style="margin-bottom: 32px;">
          Today, Sonara ships to 50+ countries and has earned the trust of over 50,000 customers —
          from bedroom producers to touring musicians, from morning commuters to professional athletes.
        </p>

        {{-- Values --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
          @foreach([
            ['🎵', 'Sound First', 'Every decision starts with audio quality. We don\'t compromise.'],
            ['🌱', 'Sustainable', 'Recycled packaging, ethical sourcing, and a repair-first philosophy.'],
            ['🤝', 'Community', 'Our community of listeners shapes every product we build.'],
            ['🔬', 'Innovative', 'Constant R&D ensures we\'re always ahead of what\'s next in audio.'],
          ] as [$icon, $title, $desc])
            <div style="padding: 20px; background: var(--gray-50); border-radius: var(--radius);">
              <h4 style="font-weight: 700; margin-bottom: 8px;">{{ $icon }} {{ $title }}</h4>
              <p style="font-size: 0.875rem; color: var(--text-muted); line-height: 1.6;">{{ $desc }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

{{-- STATS BANNER --}}
<section class="section-sm" style="background: var(--brand-navy);">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; text-align: center;">
      @foreach([
        ['50K+', 'Customers worldwide'],
        ['50+', 'Countries shipped to'],
        ['12+', 'Product lines'],
        ['4.9★', 'Average rating'],
      ] as [$stat, $label])
        <div>
          <div style="font-family: 'Fraunces', serif; font-size: 3rem; font-weight: 700; color: var(--brand-blue); line-height: 1;">
            {{ $stat }}
          </div>
          <div style="color: rgba(255,255,255,0.65); margin-top: 8px; font-size: 0.9rem;">{{ $label }}</div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- TEAM --}}
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="label">The people</span>
      <h2 class="display-lg">Meet our team</h2>
      <p class="body-lg">A diverse group of creators, engineers, and dreamers united by a love of sound.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
      @foreach([
        ['https://i.pravatar.cc/150?img=1',  'James Fletcher',  'Founder & CEO'],
        ['https://i.pravatar.cc/150?img=5',  'Priya Mehta',     'Head of Design'],
        ['https://i.pravatar.cc/150?img=12', 'Carlos Rivera',   'Lead Engineer'],
        ['https://i.pravatar.cc/150?img=9',  'Emma Svensson',   'Head of Marketing'],
        ['https://i.pravatar.cc/150?img=15', 'Yuki Tanaka',     'Acoustic Engineer'],
        ['https://i.pravatar.cc/150?img=20', 'Marcus Webb',     'Customer Success'],
        ['https://i.pravatar.cc/150?img=25', 'Aisha Kone',      'Product Manager'],
        ['https://i.pravatar.cc/150?img=30', 'Tom Nakagawa',    'Software Lead'],
      ] as [$avatar, $name, $role])
        <div style="text-align: center; padding: 28px 20px; background: var(--gray-50); border-radius: var(--radius-lg); transition: all var(--transition);"
          onmouseover="this.style.boxShadow='var(--shadow-lg)';this.style.transform='translateY(-4px)'"
          onmouseout="this.style.boxShadow='';this.style.transform=''">
          <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin: 0 auto 16px;">
            <img src="{{ $avatar }}" alt="{{ $name }}" style="width: 100%; height: 100%; object-fit: cover;" />
          </div>
          <div style="font-weight: 700; font-size: 0.9375rem; margin-bottom: 4px;">{{ $name }}</div>
          <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $role }}</div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="section-sm" style="background: var(--gray-50); text-align: center;">
  <div class="container">
    <h2 class="display-md" style="margin-bottom: 16px;">Ready to experience Sonara?</h2>
    <p class="body-lg" style="margin-bottom: 32px;">Join 50,000+ listeners who've made Sonara their audio of choice.</p>
    <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
      <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Shop Now →</a>
      <a href="{{ route('contact') }}" class="btn btn-outline btn-lg">Get in Touch</a>
    </div>
  </div>
</section>

@endsection
