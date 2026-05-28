@extends('layouts.app')
@section('title', 'Contact')

@section('content')
<section class="section">
  <div class="container" style="max-width:640px;">
    <div class="section-header">
      <span class="label">Get in touch</span>
      <h1 class="display-lg">We'd love to hear from you</h1>
      <p class="body-lg">Have a question or feedback? Send us a message and we'll get back within 24 hours.</p>
    </div>

    <form method="POST" action="{{ route('contact.send') }}" style="background:var(--gray-50);border-radius:var(--radius-lg);padding:40px;">
      @csrf
      @foreach([['name','Name','text','Your name'],['email','Email','email','your@email.com'],['subject','Subject','text','How can we help?']] as [$field,$label,$type,$placeholder])
        <div style="margin-bottom:20px;">
          <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px;">{{ $label }}</label>
          <input type="{{ $type }}" name="{{ $field }}" value="{{ old($field) }}" placeholder="{{ $placeholder }}" required
            style="width:100%;padding:14px 18px;border:1.5px solid var(--gray-200);border-radius:var(--radius);font-size:0.9375rem;background:white;" />
          @error($field)<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
        </div>
      @endforeach

      <div style="margin-bottom:28px;">
        <label style="font-weight:600;font-size:0.875rem;display:block;margin-bottom:8px;">Message</label>
        <textarea name="message" rows="5" placeholder="Tell us more..." required
          style="width:100%;padding:14px 18px;border:1.5px solid var(--gray-200);border-radius:var(--radius);font-size:0.9375rem;background:white;resize:vertical;">{{ old('message') }}</textarea>
        @error('message')<p style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
      </div>

      <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">Send Message →</button>
    </form>
  </div>
</section>
@endsection
