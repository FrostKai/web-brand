@extends('layouts.app')
@section('title', 'Login')

@section('content')
<section class="section-sm" style="min-height:calc(100vh - 72px);display:flex;align-items:center;">
  <div class="container" style="max-width:480px;">
    <div style="text-align:center;margin-bottom:40px;">
      <span class="label">Welcome back</span>
      <h1 class="display-md" style="margin-top:12px;">Sign in to Sonara</h1>
    </div>

    <div style="background:white;border-radius:var(--radius-lg);padding:40px;box-shadow:var(--shadow-lg);">
      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div style="margin-bottom:20px;">
          <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px;">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required
            placeholder="you@example.com"
            style="width:100%;padding:14px 18px;border:1.5px solid {{ $errors->has('email') ? '#ef4444' : 'var(--gray-200)' }};border-radius:var(--radius);font-size:0.9375rem;" />
          @error('email')<p style="color:#ef4444;font-size:0.8rem;margin-top:6px;">{{ $message }}</p>@enderror
        </div>

        <div style="margin-bottom:12px;">
          <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px;">Password</label>
          <input type="password" name="password" required
            placeholder="••••••••"
            style="width:100%;padding:14px 18px;border:1.5px solid var(--gray-200);border-radius:var(--radius);font-size:0.9375rem;" />
          @error('password')<p style="color:#ef4444;font-size:0.8rem;margin-top:6px;">{{ $message }}</p>@enderror
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;">
          <label style="display:flex;align-items:center;gap:8px;font-size:0.875rem;cursor:pointer;">
            <input type="checkbox" name="remember" style="width:16px;height:16px;" /> Remember me
          </label>
          <a href="{{ route('password.request') }}" style="color:var(--brand-blue);font-size:0.875rem;font-weight:500;">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Sign In</button>
      </form>

      <div style="text-align:center;margin-top:24px;color:var(--text-muted);font-size:0.9rem;">
        Don't have an account? <a href="{{ route('register') }}" style="color:var(--brand-blue);font-weight:600;">Sign up</a>
      </div>
    </div>
  </div>
</section>
@endsection
