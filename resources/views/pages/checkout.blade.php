@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<section class="section">
  <div class="container">
    <h1 class="display-md" style="margin-bottom:40px;">Checkout</h1>

    <div style="display:grid;grid-template-columns:1fr 380px;gap:40px;align-items:start;">
      {{-- Form --}}
      <form method="POST" action="{{ route('checkout.place') }}">
        @csrf

        {{-- Shipping info --}}
        <div style="background:var(--gray-50);border-radius:var(--radius-lg);padding:32px;margin-bottom:24px;">
          <h3 style="font-family:'Fraunces',serif;font-size:1.1rem;margin-bottom:24px;">Shipping Information</h3>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            @foreach([['first_name','First Name','text'],['last_name','Last Name','text'],['email','Email','email'],['phone','Phone','tel'],['address','Street Address','text'],['city','City','text'],['postal_code','Postal Code','text'],['country','Country','text']] as [$field,$label,$type])
              <div @if(in_array($field,['address','email'])) style="grid-column:1/-1;" @endif>
                <label style="font-weight:600;font-size:0.8rem;display:block;margin-bottom:6px;">{{ $label }}</label>
                <input type="{{ $type }}" name="{{ $field }}" value="{{ old($field, auth()->user()->{$field} ?? '') }}"
                  required="{{ !in_array($field,['phone']) }}"
                  style="width:100%;padding:12px 16px;border:1.5px solid {{ $errors->has($field) ? '#ef4444' : 'var(--gray-200)' }};border-radius:var(--radius);font-size:0.9rem;background:white;" />
                @error($field)<p style="color:#ef4444;font-size:0.75rem;margin-top:4px;">{{ $message }}</p>@enderror
              </div>
            @endforeach
          </div>
        </div>

        {{-- Shipping method --}}
        <div style="background:var(--gray-50);border-radius:var(--radius-lg);padding:32px;margin-bottom:24px;">
          <h3 style="font-family:'Fraunces',serif;font-size:1.1rem;margin-bottom:20px;">Shipping Method</h3>
          @foreach([['standard','Standard (5-7 days)','Free'],['express','Express (2-3 days)','$9.99'],['overnight','Overnight','$24.99']] as [$val,$label,$cost])
            <label style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border:1.5px solid var(--gray-200);border-radius:var(--radius);margin-bottom:10px;cursor:pointer;background:white;">
              <div style="display:flex;align-items:center;gap:10px;">
                <input type="radio" name="shipping_method" value="{{ $val }}" {{ $val==='standard'?'checked':'' }} />
                <span style="font-weight:500;">{{ $label }}</span>
              </div>
              <span style="font-weight:600;color:{{ $cost==='Free'?'#22c55e':'var(--text)' }};">{{ $cost }}</span>
            </label>
          @endforeach
        </div>

        <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
          Place Order →
        </button>
      </form>

      {{-- Order summary --}}
      <div style="background:var(--gray-50);border-radius:var(--radius-lg);padding:32px;position:sticky;top:100px;">
        <h3 style="font-family:'Fraunces',serif;font-size:1.1rem;margin-bottom:20px;">Order Summary</h3>

        @foreach($cart as $item)
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
            <div style="background:white;border-radius:8px;width:48px;height:48px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
              {{ $item['emoji'] ?? '🎧' }}
            </div>
            <div style="flex:1;">
              <div style="font-weight:600;font-size:0.875rem;">{{ $item['name'] }}</div>
              <div style="color:var(--text-muted);font-size:0.8rem;">Qty: {{ $item['qty'] }}</div>
            </div>
            <div style="font-weight:600;">${{ number_format($item['price'] * $item['qty'], 2) }}</div>
          </div>
        @endforeach

        <div style="border-top:1px solid var(--gray-200);padding-top:16px;margin-top:8px;">
          <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
            <span>Subtotal</span>
            <span>${{ number_format($subtotal, 2) }}</span>
          </div>
          @if($discount > 0)
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;color:#22c55e;">
              <span>Promo ({{ $promo['code'] }})</span>
              <span>-${{ number_format($discount, 2) }}</span>
            </div>
          @endif
          <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
            <span>Shipping</span>
            <span id="summary-shipping" style="color:#22c55e;">Free</span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.9rem;">
            <span>Tax (8%)</span>
            <span>${{ number_format($tax, 2) }}</span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-top:16px;font-weight:700;font-size:1.1rem;border-top:1px solid var(--gray-200);padding-top:16px;">
            <span>Total</span>
            <span id="summary-total" style="color:var(--brand-blue);font-family:'Fraunces',serif;">${{ number_format($subtotal + $tax - $discount, 2) }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="shipping_method"]');
    if (radios.length > 0) {
      radios.forEach(radio => {
        radio.addEventListener('change', function() {
          const val = this.value;
          const subtotal = {{ $subtotal }};
          const tax = {{ $tax }};
          const discount = {{ $discount }};
          
          let shippingCost = 0;
          let shippingText = 'Free';
          
          if (val === 'express') {
            shippingCost = 9.99;
            shippingText = '$9.99';
          } else if (val === 'overnight') {
            shippingCost = 24.99;
            shippingText = '$24.99';
          }
          
          const summaryShipping = document.getElementById('summary-shipping');
          if (summaryShipping) {
            summaryShipping.textContent = shippingText;
            summaryShipping.style.color = shippingCost === 0 ? '#22c55e' : 'inherit';
          }
          
          const summaryTotal = document.getElementById('summary-total');
          if (summaryTotal) {
            const total = subtotal + tax + shippingCost - discount;
            summaryTotal.textContent = '$' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
          }
        });
      });
    }
  });
</script>
@endpush
@endsection
