@extends('layouts.app')
@section('title', 'Pricing')

@section('content')

{{-- PRICING HERO --}}
<section style="background: linear-gradient(135deg, #f8f9ff 0%, #eef1ff 100%); padding: 120px 0 80px; text-align: center;">
  <div class="container" style="max-width: 700px;">
    <span class="label">Pricing & Plans</span>
    <h1 class="display-xl" style="margin-top: 16px; margin-bottom: 16px;">Choose what fits you</h1>
    <p class="body-lg">Whether you're a casual listener or a dedicated audiophile, we have a plan that delivers exactly what you need.</p>
  </div>
</section>

{{-- PRICING CARDS --}}
<section class="section">
  <div class="container" style="max-width: 960px;">

    {{-- Monthly / Annual Toggle --}}
    <div style="text-align: center; margin-bottom: 48px;">
      <div style="display: inline-flex; background: var(--gray-100); border-radius: 100px; padding: 4px; gap: 4px;">
        <button class="toggle-btn active" id="btn-monthly"
          onclick="setPricingMode('monthly', this)"
          style="padding: 10px 24px; border-radius: 100px; font-weight: 600; font-size: 0.9rem; border: none; cursor: pointer; background: white; transition: all 0.2s;">
          Monthly
        </button>
        <button class="toggle-btn" id="btn-annual"
          onclick="setPricingMode('annual', this)"
          style="padding: 10px 24px; border-radius: 100px; font-weight: 600; font-size: 0.9rem; border: none; cursor: pointer; background: transparent; color: var(--text-muted); transition: all 0.2s;">
          Annual
          <span style="background: var(--accent); color: white; font-size: 0.7rem; padding: 2px 8px; border-radius: 100px; margin-left: 6px;">Save 20%</span>
        </button>
      </div>
    </div>

    {{-- Cards --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; align-items: start;">

      {{-- Starter --}}
      <div style="border: 1.5px solid var(--gray-200); border-radius: var(--radius-lg); padding: 36px; background: white;">
        <div style="font-family: 'Fraunces', serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 8px;">Starter</div>
        <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 24px;">Perfect for casual listeners just getting started.</p>
        <div style="font-family: 'Fraunces', serif; font-size: 3rem; font-weight: 700; line-height: 1; margin-bottom: 4px;">
          $<span class="price-val" data-monthly="{{ $plans['monthly']['starter'] }}" data-annual="{{ $plans['annual']['starter'] }}">{{ $plans['monthly']['starter'] }}</span>
        </div>
        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 28px;">per month</div>
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px;">
          @foreach([
            [true, '1 device connected'],
            [true, 'Basic EQ settings'],
            [true, 'Standard audio codec'],
            [true, 'Email support'],
            [false, 'Custom EQ profiles'],
          ] as $item)
            @php
              $included = $item[0];
              $feature = $item[1];
              $textColor = !$included ? 'color: var(--text-muted);' : '';
              $bg = $included ? 'var(--brand-blue-light)' : 'var(--gray-100)';
              $color = $included ? 'var(--brand-blue)' : 'var(--gray-400)';
              $symbol = $included ? '✓' : '—';
            @endphp
            <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem; {{ $textColor }}">
              <div style="width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0; background: {{ $bg }}; color: {{ $color }};">
                {{ $symbol }}
              </div>
              {{ $feature }}
            </div>
          @endforeach
        </div>
        <a href="{{ route('register') }}" class="btn btn-outline" style="width: 100%; justify-content: center; display: flex;">Get Started</a>
      </div>

      {{-- Pro (Popular) --}}
      <div style="border: 2px solid var(--brand-blue); border-radius: var(--radius-lg); padding: 36px; background: var(--brand-blue); color: white; position: relative; transform: scale(1.03); box-shadow: var(--shadow-lg);">
        <div style="position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: var(--accent); color: white; font-size: 0.75rem; font-weight: 700; padding: 4px 16px; border-radius: 100px; white-space: nowrap;">Most Popular</div>
        <div style="font-family: 'Fraunces', serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 8px;">Pro</div>
        <p style="color: rgba(255,255,255,0.75); font-size: 0.875rem; margin-bottom: 24px;">For serious listeners who want the full experience.</p>
        <div style="font-family: 'Fraunces', serif; font-size: 3rem; font-weight: 700; line-height: 1; margin-bottom: 4px;">
          $<span class="price-val" data-monthly="{{ $plans['monthly']['pro'] }}" data-annual="{{ $plans['annual']['pro'] }}">{{ $plans['monthly']['pro'] }}</span>
        </div>
        <div style="color: rgba(255,255,255,0.65); font-size: 0.8rem; margin-bottom: 28px;">per month</div>
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px;">
          @foreach([
            'Up to 3 devices',
            'Advanced EQ + presets',
            'Hi-Res audio codec',
            'Priority support',
            'Custom EQ profiles',
          ] as $feature)
            <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
              <div style="width: 22px; height: 22px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0;">✓</div>
              {{ $feature }}
            </div>
          @endforeach
        </div>
        <a href="{{ route('register') }}" class="btn" style="width: 100%; justify-content: center; display: flex; background: white; color: var(--brand-blue); font-weight: 700;">Get Pro</a>
      </div>

      {{-- Studio --}}
      <div style="border: 1.5px solid var(--gray-200); border-radius: var(--radius-lg); padding: 36px; background: white;">
        <div style="font-family: 'Fraunces', serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 8px;">Studio</div>
        <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 24px;">For professionals and power users who demand the best.</p>
        <div style="font-family: 'Fraunces', serif; font-size: 3rem; font-weight: 700; line-height: 1; margin-bottom: 4px;">
          $<span class="price-val" data-monthly="{{ $plans['monthly']['studio'] }}" data-annual="{{ $plans['annual']['studio'] }}">{{ $plans['monthly']['studio'] }}</span>
        </div>
        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 28px;">per month</div>
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px;">
          @foreach([
            'Unlimited devices',
            'Studio EQ + mastering',
            'Lossless audio',
            '24/7 dedicated support',
            'API access',
          ] as $feature)
            <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
              <div style="width: 22px; height: 22px; border-radius: 50%; background: var(--brand-blue-light); color: var(--brand-blue); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; flex-shrink: 0;">✓</div>
              {{ $feature }}
            </div>
          @endforeach
        </div>
        <a href="{{ route('register') }}" class="btn btn-dark" style="width: 100%; justify-content: center; display: flex;">Get Studio</a>
      </div>

    </div>

    <p style="text-align: center; margin-top: 32px; font-size: 0.875rem; color: var(--text-muted);">
      All plans include a 30-day free trial. No credit card required to start.
    </p>

    {{-- FAQ --}}
    <div style="margin-top: 80px;">
      <h2 class="display-md" style="text-align: center; margin-bottom: 40px;">Frequently asked questions</h2>
      <div style="display: flex; flex-direction: column; gap: 16px; max-width: 640px; margin: 0 auto;">
        @foreach([
          ['Can I switch plans anytime?', 'Yes! You can upgrade or downgrade your plan at any time. Changes take effect at the start of your next billing cycle.'],
          ['Is there a free trial?', 'All plans come with a 30-day free trial. No credit card required to get started.'],
          ['What payment methods do you accept?', 'We accept all major credit cards, PayPal, and bank transfers for annual plans.'],
          ['Can I cancel anytime?', 'Absolutely. There are no long-term contracts. Cancel with one click from your account settings.'],
        ] as [$question, $answer])
          <div style="padding: 24px; background: var(--gray-50); border-radius: var(--radius); border: 1px solid var(--gray-100);">
            <div style="font-weight: 700; margin-bottom: 8px;">{{ $question }}</div>
            <div style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.7;">{{ $answer }}</div>
          </div>
        @endforeach
      </div>
    </div>

  </div>
</section>

@push('scripts')
<script>
  function setPricingMode(mode, btn) {
    // Update toggle button styles
    document.querySelectorAll('.toggle-btn').forEach(b => {
      b.style.background = 'transparent';
      b.style.color = 'var(--text-muted)';
    });
    btn.style.background = 'white';
    btn.style.color = 'var(--text)';

    // Update all prices
    document.querySelectorAll('.price-val').forEach(el => {
      el.textContent = el.dataset[mode];
    });
  }
</script>
@endpush

@endsection
