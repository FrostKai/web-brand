@extends('layouts.app-admin')
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
        {{-- Menu Baru untuk Verifikasi --}}
        <a href="{{ route('admin.dashboard') }}#verifikasi-shopee" class="sidebar-link" style="border-left: 4px solid transparent;">
          <span>🧡</span> Verifikasi Shopee
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

    <div class="dashboard-card">
      <div style="overflow-x: auto;">
        @if(empty($products) || $products->isEmpty())
        <div style="text-align: center; padding: 40px 0; color: var(--text-muted);">
          <p>No products available.</p>
        </div>
        @else
        <table class="admin-table">
          <thead>
            <tr>
              <th>Image</th>
              <th>Product Details</th>
              <th>Price & Stock</th>
              <th>Shopee Link</th>
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
                <div style="font-weight: 600; color: var(--brand-navy);">{{ $product->name }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $product->category_label }}</div>
              </td>
              <td>
                <div style="font-weight: 600;">${{ number_format($product->price, 2) }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">Stock: {{ $product->stock }}</div>
              </td>
              <td>
                @if(!empty($product->shopee_link))
                  <a href="{{ $product->shopee_link }}" target="_blank" style="color: #ee4d2d; font-size: 0.85rem; font-weight: 600;">Terhubung 🧡</a>
                @else
                  <span style="color: var(--text-muted); font-size: 0.85rem;">Tidak Ada</span>
                @endif
              </td>
              <td>
                <div class="actions-flex" style="display: flex; gap: 8px; justify-content: flex-end;">
                  <a href="{{ route('products.show', $product->slug) }}" class="btn-action btn-outline" target="_blank" style="padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; border: 1px solid var(--gray-300); text-decoration: none; color: inherit;">
                    View
                  </a>
                  <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action btn-dark" style="padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; background: var(--brand-navy); color: white; text-decoration: none;">
                    Edit
                  </a>
                  <form method="POST" action="{{ route('admin.products.delete', $product->id) }}" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-primary" style="padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; background: #ef4444; color: white; border: none; cursor: pointer;">
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