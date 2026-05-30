@extends('layouts.app-admin')
@section('title', 'Add Product')

@push('head')
<style>
  .admin-wrapper {
    display: grid;
    grid-template-columns: 260px 1fr;
    min-height: calc(100vh - 72px);
    background: var(--gray-50);
  }

  /* Sidebar styling */
  .admin-sidebar {
    background: var(--brand-navy);
    color: var(--white);
    padding: 32px 24px;
    display: flex;
    flex-direction: column;
    gap: 32px;
    border-right: 1px solid rgba(255,255,255,0.05);
  }
  .sidebar-title {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--gray-400);
    font-weight: 700;
  }
  .sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  .sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 500;
    color: rgba(255,255,255,0.7);
    transition: all var(--transition);
  }
  .sidebar-link:hover, .sidebar-link.active {
    color: var(--white);
    background: rgba(67, 97, 238, 0.15);
    border-left: 4px solid var(--brand-blue);
    padding-left: 14px;
  }

  /* Content area */
  .admin-content {
    padding: 40px;
    overflow-y: auto;
  }
  .content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
  }
  .content-title {
    font-family: 'Fraunces', serif;
    font-size: 2rem;
    font-weight: 500;
    color: var(--brand-navy);
  }

  .form-card {
    background: #ffffff;
    border-radius: var(--radius);
    padding: 40px;
    box-shadow: var(--shadow);
    border: 1px solid var(--gray-100);
    max-width: 800px;
  }

  .form-group {
    margin-bottom: 24px;
  }
  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
  }
  .form-label {
    display: block;
    font-weight: 600;
    font-size: 0.88rem;
    color: var(--brand-navy);
    margin-bottom: 8px;
  }
  .form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    font-size: 0.95rem;
    transition: all var(--transition);
    color: var(--text);
  }
  .form-input:focus {
    border-color: var(--brand-blue);
    background: var(--brand-blue-light);
  }
  .form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid var(--gray-200);
    border-radius: var(--radius);
    font-size: 0.95rem;
    min-height: 120px;
    font-family: inherit;
    resize: vertical;
    transition: all var(--transition);
    color: var(--text);
  }
  .form-textarea:focus {
    border-color: var(--brand-blue);
    background: var(--brand-blue-light);
  }

  .spec-row {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: 12px;
    margin-bottom: 12px;
    align-items: center;
  }

  .color-picker-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
  }
  .color-input-container {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--gray-50);
    padding: 8px 12px;
    border-radius: 100px;
    border: 1px solid var(--gray-200);
  }

  .btn-remove {
    background: none;
    color: #ef4444;
    font-size: 1.2rem;
    padding: 4px 8px;
  }

  @media (max-width: 1024px) {
    .admin-wrapper {
      grid-template-columns: 1fr;
    }
    .admin-sidebar {
      display: none;
    }
    .form-row {
      grid-template-columns: 1fr;
      gap: 0;
    }
  }
</style>
@endpush

@section('content')
<div class="admin-wrapper">
  {{-- Sidebar --}}
  <div class="admin-sidebar">
    <div>
      <div class="sidebar-title" style="margin-bottom: 16px;">Sonara Admin</div>
      <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
          <span>📊</span> Dashboard
        </a>
        <a href="{{ route('admin.products') }}" class="sidebar-link">
          <span>📦</span> Products
        </a>
        <a href="{{ route('admin.products.create') }}" class="sidebar-link active">
          <span>➕</span> Add Product
        </a>
      </div>
    </div>
    
    <div style="margin-top: auto;">
      <a href="{{ route('home') }}" class="sidebar-link" style="background: rgba(255,255,255,0.05);">
        <span>🏠</span> Back to Store
      </a>
    </div>
  </div>

  {{-- Main Content --}}
  <div class="admin-content">
    <div class="content-header">
      <div>
        <h1 class="content-title">Add New Product</h1>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 4px;">Launch a new premium sound device to the store.</p>
      </div>
    </div>

    {{-- Form --}}
    <div class="form-card">
      @if ($errors->any())
        <div style="padding: 16px; background: #fee2e2; border: 1px solid #fecaca; border-radius: var(--radius); margin-bottom: 24px; color: #dc2626; font-size: 0.9rem;">
          <ul style="padding-left: 16px; list-style-type: disc;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf

        {{-- Basic Information --}}
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-input" value="{{ old('name') }}" required placeholder="e.g., AeroBuds Elite" />
          </div>
          <div class="form-group">
            <label class="form-label">Category</label>
            <select name="category" class="form-input" required>
              <option value="headphones" {{ old('category') === 'headphones' ? 'selected' : '' }}>Headphones</option>
              <option value="earbuds" {{ old('category') === 'earbuds' ? 'selected' : '' }}>Earbuds</option>
              <option value="speakers" {{ old('category') === 'speakers' ? 'selected' : '' }}>Speakers</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Price ($)</label>
            <input type="number" name="price" step="0.01" class="form-input" value="{{ old('price') }}" required placeholder="149.99" />
          </div>
          <div class="form-group">
            <label class="form-label">Old Price ($) <span style="font-weight: normal; color: var(--text-muted); font-size: 0.8rem;">(Optional)</span></label>
            <input type="number" name="old_price" step="0.01" class="form-input" value="{{ old('old_price') }}" placeholder="199.99" />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Stock Quantity</label>
            <input type="number" name="stock" class="form-input" value="{{ old('stock', 100) }}" required placeholder="100" />
          </div>
          <div class="form-group">
            <label class="form-label">Link Shopee Brand</label>
            <input type="url" name="shopee_link" class="form-input" value="{{ old('shopee_link') }}" placeholder="link Shopee" />
          </div>
        </div>
      

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Badge Label <span style="font-weight: normal; color: var(--text-muted); font-size: 0.8rem;">(Optional)</span></label>
            <input type="text" name="badge" class="form-input" value="{{ old('badge') }}" placeholder="e.g., New, Sale, Best Seller" />
          </div>
          <div class="form-group">
            <label class="form-label">Badge Style Type</label>
            <select name="badge_type" class="form-input">
              <option value="">None</option>
              <option value="new" {{ old('badge_type') === 'new' ? 'selected' : '' }}>New (Blue)</option>
              <option value="sale" {{ old('badge_type') === 'sale' ? 'selected' : '' }}>Sale (Red)</option>
              <option value="popular" {{ old('badge_type') === 'popular' ? 'selected' : '' }}>Popular (Gold)</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Product Image URL</label>
          <input type="url" name="image_url" class="form-input" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/... or /images/..." />
          <p style="font-size: 0.78rem; color: var(--text-muted); margin-top: 6px;">Provide a clean image URL (e.g. from Unsplash) to render the product card properly.</p>
        </div>

        <div class="form-group">
          <label class="form-label">Product Description</label>
          <textarea name="description" class="form-textarea" required placeholder="Describe the sonic attributes, battery life, design comfort..."></textarea>
        </div>

        {{-- Dynamic Specifications --}}
        <div class="form-group" style="border-top: 1px solid var(--gray-100); padding-top: 24px; margin-top: 24px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <label class="form-label" style="margin-bottom:0;">Technical Specifications</label>
            <button type="button" id="btn-add-spec" class="btn btn-outline btn-sm" style="padding: 6px 14px;">+ Add Spec</button>
          </div>
          <div id="specs-container">
            <div class="spec-row">
              <input type="text" name="specs_keys[]" class="form-input" placeholder="e.g., Battery Life" />
              <input type="text" name="specs_values[]" class="form-input" placeholder="e.g., 40 Hours" />
              <button type="button" class="btn-remove" onclick="this.parentElement.remove()">&times;</button>
            </div>
            <div class="spec-row">
              <input type="text" name="specs_keys[]" class="form-input" placeholder="e.g., Bluetooth" />
              <input type="text" name="specs_values[]" class="form-input" placeholder="e.g., 5.3" />
              <button type="button" class="btn-remove" onclick="this.parentElement.remove()">&times;</button>
            </div>
          </div>
        </div>

        {{-- Dynamic Colors --}}
        <div class="form-group" style="border-top: 1px solid var(--gray-100); padding-top: 24px; margin-top: 24px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <label class="form-label" style="margin-bottom:0;">Available Colors</label>
            <button type="button" id="btn-add-color" class="btn btn-outline btn-sm" style="padding: 6px 14px;">+ Add Color</button>
          </div>
          <div id="colors-container" class="color-picker-wrapper">
            <div class="color-input-container">
              <input type="color" name="colors[]" value="#2d3561" style="border:none; background:none; width:30px; height:30px; cursor:pointer;" />
              <button type="button" class="btn-remove" style="font-size:0.9rem;" onclick="this.parentElement.remove()">Remove</button>
            </div>
            <div class="color-input-container">
              <input type="color" name="colors[]" value="#4361EE" style="border:none; background:none; width:30px; height:30px; cursor:pointer;" />
              <button type="button" class="btn-remove" style="font-size:0.9rem;" onclick="this.parentElement.remove()">Remove</button>
            </div>
          </div>
        </div>

        <div class="form-group" style="margin-top: 28px;">
          <label class="form-label" style="display: inline-flex; align-items: center; gap: 10px; cursor: pointer;">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;" />
            Feature this product on homepage
          </label>
        </div>

        <div style="display: flex; gap: 16px; border-top: 1px solid var(--gray-100); padding-top: 24px; margin-top: 28px;">
          <button type="submit" class="btn btn-primary">Save Product</button>
          <a href="{{ route('admin.products') }}" class="btn btn-ghost">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Add Spec Row
  document.getElementById('btn-add-spec').addEventListener('click', () => {
    const container = document.getElementById('specs-container');
    const row = document.createElement('div');
    row.className = 'spec-row';
    row.innerHTML = `
      <input type="text" name="specs_keys[]" class="form-input" placeholder="Spec key" />
      <input type="text" name="specs_values[]" class="form-input" placeholder="Spec value" />
      <button type="button" class="btn-remove" onclick="this.parentElement.remove()">&times;</button>
    `;
    container.appendChild(row);
  });

  // Add Color Box
  document.getElementById('btn-add-color').addEventListener('click', () => {
    const container = document.getElementById('colors-container');
    const containerItem = document.createElement('div');
    containerItem.className = 'color-input-container';
    containerItem.innerHTML = `
      <input type="color" name="colors[]" value="#000000" style="border:none; background:none; width:30px; height:30px; cursor:pointer;" />
      <button type="button" class="btn-remove" style="font-size:0.9rem;" onclick="this.parentElement.remove()">Remove</button>
    `;
    container.appendChild(containerItem);
  });
</script>
@endpush
@endsection
