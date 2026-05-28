  @extends('layouts.app')
  @section('title', 'Forgot Password')
  @section('content')
  <section class="section-sm" style="min-height:calc(100vh - 72px);display:flex;align-items:center;">
    <div class="container" style="max-width:480px;">
      <div style="text-align:center;margin-bottom:40px;">
        <span class="label">Reset Password</span>
        <h1 class="display-md" style="margin-top:12px;">Forgot your password?</h1>
        <p style="color:var(--text-muted);font-size:0.95rem;margin-top:8px;">No problem. Just let us know your email address and we will email you a password reset link.</p>
      </div>

      <div style="background:white;border-radius:var(--radius-lg);padding:40px;box-shadow:var(--shadow-lg);">
        
        @if (session('status'))
          <div style="padding:12px 18px; border-radius:var(--radius); margin-bottom:20px; font-size:0.9rem; background:#dcfce7; border:1px solid #86efac; color:#15803d;">
            {{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div style="margin-bottom:28px;">
            <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px;">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
              placeholder="you@example.com"
              class="auth-input @error('email') has-error @enderror" />
            @error('email')
              <p style="color:#ef4444;font-size:0.8rem;margin-top:6px;">{{ $message }}</p>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Email Password Reset Link ✉️</button>
        </form>

        <div style="text-align:center;margin-top:24px;color:var(--text-muted);font-size:0.9rem;">
          Remembered your password? <a href="{{ route('login') }}" style="color:var(--brand-blue);font-weight:600;">Sign in</a>
        </div>
      </div>
    </div>
  </section>
  @endsection