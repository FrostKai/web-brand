@extends('layouts.app')
@section('title', 'Order Placed!')

@section('content')
<section class="section" style="min-height:calc(100vh - 72px);display:flex;align-items:center;">
  <div class="container" style="max-width:560px;text-align:center;">
    <div style="font-size:5rem;margin-bottom:24px;">🎉</div>
    <h1 class="display-lg" style="margin-bottom:16px;">Order Placed!</h1>
    <p class="body-lg" style="margin-bottom:40px;">
      Thank you for your purchase! Your order is confirmed and will be shipped soon. Check your email for tracking details.
    </p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Back to Home</a>
      <a href="{{ route('products.index') }}" class="btn btn-outline btn-lg">Keep Shopping</a>
    </div>
  </div>
</section>
@endsection
