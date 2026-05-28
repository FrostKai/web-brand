@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<section class="section-sm" style="min-height:calc(100vh - 72px);display:flex;align-items:center;">
  <div class="container" style="max-width:480px;">
    <div style="text-align:center;margin-bottom:40px;">
      <span class="label">Reset Password</span>
      <h1 class="display-md" style="margin-top:12px;">Create New Password</h1>
      <p style="color:var(--text-muted);font-size:0.95rem;margin-top:8px;">Enter your email and create a new secure password for your account.</p>
    </div>

    <div style="background:white;border-radius:var(--radius-lg);padding:40px;box-shadow:var(--shadow-lg);">
      <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email Address -->
        <div style="margin-bottom:20px;">
          <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px;">Email Address</label>
          <input type="email" name="email" value="{{ old('email', $email) }}" required readonly
            style="width:100%;padding:14px 18px;border:1.5px solid var(--gray-200);border-radius:var(--radius);font-size:0.9375rem;background-color:#f9fafb;cursor:not-allowed;" />
          @error('email')
            <p style="color:#ef4444;font-size:0.8rem;margin-top:6px;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div style="margin-bottom:20px;">
          <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px;">New Password</label>
          <input type="password" name="password" required autofocus placeholder="••••••••"
            style="width:100%;padding:14px 18px;border:1.5px solid {{ $errors->has('password') ? '#ef4444' : 'var(--gray-200)' }};border-radius:var(--radius);font-size:0.9375rem;" />
          @error('password')
            <p style="color:#ef4444;font-size:0.8rem;margin-top:6px;">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom:28px;">
          <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px;">Confirm New Password</label>
          <input type="password" name="password_confirmation" required placeholder="••••••••"
            style="width:100%;padding:14px 18px;border:1.5px solid {{ $errors->has('password_confirmation') ? '#ef4444' : 'var(--gray-200)' }};border-radius:var(--radius);font-size:0.9375rem;" />
          @error('password_confirmation')
            <p style="color:#ef4444;font-size:0.8rem;margin-top:6px;">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Reset Password 🔑</button>
      </form>
    </div>
  </div>
</section>
@endsection
