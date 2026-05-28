@extends('layouts.app')
@section('title', 'Sign Up')



@section('content')
<section class="section-sm" style="min-height:calc(100vh - 72px);display:flex;align-items:center;">
  <div class="container" style="max-width:480px;">
    <div style="text-align:center;margin-bottom:40px;">
      <span class="label">Create account</span>
      <h1 class="display-md" style="margin-top:12px;">Join Sonara</h1>
    </div>

    <div style="background:white;border-radius:var(--radius-lg);padding:40px;box-shadow:var(--shadow-lg);">
      <form method="POST" action="{{ route('register.post') }}">
        @csrf

        @foreach([['name','Name','text','Your full name'],['email','Email','email','you@example.com'],['password','Password','password','••••••••'],['password_confirmation','Confirm Password','password','••••••••']] as $item)
          @php
            $field = $item[0];
            $label = $item[1];
            $type = $item[2];
            $placeholder = $item[3];
          @endphp
          <div style="margin-bottom:20px;">
            <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px;">{{ $label }}</label>
            <input type="{{ $type }}" name="{{ $field }}" value="{{ in_array($field,['name','email']) ? old($field) : '' }}"
              placeholder="{{ $placeholder }}" required
              class="auth-input @error($field) has-error @enderror" />
            @error($field)<p style="color:#ef4444;font-size:0.8rem;margin-top:6px;">{{ $message }}</p>@enderror
          </div>
        @endforeach

        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px;">Create Account ✨</button>
      </form>

      <div style="text-align:center;margin-top:24px;color:var(--text-muted);font-size:0.9rem;">
        Already have an account? <a href="{{ route('login') }}" style="color:var(--brand-blue);font-weight:600;">Sign in</a>
      </div>
    </div>
  </div>
</section>
@endsection
