@extends('layouts.app')
@section('title', 'Manage Products')



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
        <a href="{{ route('admin.products') }}" class="sidebar-link active">
          <span>📦</span> Products
        </a>
        <a href="{{ route('admin.products.create') }}" class="sidebar-link">
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
        <h1 class="content-title">Manage Products</h1>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 4px;">Add, edit, or remove products from the catalog.</p>
      </div>
      <div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
          <span>➕</span> Add New Product
        </a>
      </div>
    </div>

    {{-- Product List Card --}}
    <div class="dashboard-card">
      <div style="overflow-x: auto;">
        @if($products->isEmpty())
          <div style="text-align: center; padding: 40px 0; color: var(--text-muted);">
            <p style="font-size: 1.5rem; margin-bottom: 8px;">📦</p>
            <p>No products available. Click the button above to add one!</p>
          </div>
        @else
          <table class="admin-table">
            <thead>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Badge</th>
                <th>Featured</th>
                <th style="text-align: right;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $product)
                <tr>
                  <td>
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;" />
                  </td>
                  <td>
                    <div style="font-weight: 600; color: var(--brand-navy);">{{ $product->name }} {{ $product->emoji }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $product->slug }}</div>
                  </td>
                  <td>{{ $product->category_label }}</td>
                  <td>
                    <span style="font-weight: 600;">${{ number_format($product->price, 2) }}</span>
                    @if($product->old_price)
                      <span style="text-decoration: line-through; color: var(--text-muted); font-size: 0.8rem; margin-left: 4px;">
                        ${{ number_format($product->old_price, 2) }}
                      </span>
                    @endif
                  </td>
                  <td>{{ $product->stock }} units</td>
                  <td>
                    @if($product->badge)
                      <span class="badge-tag {{ $product->badge_type }}">
                        {{ $product->badge }}
                      </span>
                    @else
                      <span style="color: var(--text-muted); font-size: 0.85rem;">—</span>
                    @endif
                  </td>
                  <td>
                    @if($product->is_featured)
                      <span style="color: #2EC4B6; font-weight: 600;">★ Yes</span>
                    @else
                      <span style="color: var(--text-muted);">No</span>
                    @endif
                  </td>
                  <td>
                    <div class="actions-flex" style="justify-content: flex-end;">
                      <a href="{{ route('products.show', $product->slug) }}" class="btn-action btn-outline" target="_blank" style="padding: 6px 12px; border-radius: 8px; font-size: 0.8rem;">
                        View
                      </a>
                      <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action btn-dark" style="padding: 6px 12px; border-radius: 8px; font-size: 0.8rem;">
                        Edit
                      </a>
                      <form method="POST" action="{{ route('admin.products.delete', $product->id) }}" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-primary" style="padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; background: #ef4444; box-shadow: none;">
                          Delete
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
