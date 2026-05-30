@extends('layouts.app-admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-wrapper">
  {{-- Sidebar --}}
  <div class="admin-sidebar">
    <div>
      <div class="sidebar-title" style="margin-bottom: 16px;">Sonara Admin</div>
      <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
          <span>📊</span> Dashboard
        </a>
        <a href="{{ route('admin.products') }}" class="sidebar-link">
          <span>📦</span> Products
        </a>
        <a href="{{ route('admin.products.create') }}" class="sidebar-link">
          <span>➕</span> Add Product
        </a>
        {{-- Menu Baru untuk Verifikasi --}}
        <a href="#verifikasi-shopee" class="sidebar-link" style="border-left: 4px solid #ee4d2d; background: rgba(238, 77, 45, 0.05);">
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
        <h1 class="content-title">Dashboard Overview</h1>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 4px;">Welcome to Sonara live monitoring panel.</p>
      </div>
      <div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
          <span>➕</span> Add New Product
        </a>
      </div>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">
      <div class="stat-card">
      </div>
      {{-- Tambah Card Stat khusus Shopee --}}
      <div class="stat-card" style="border-bottom: 3px solid #ee4d2d;">
        <div class="stat-icon">🧡</div>
        <div>
          <div class="stat-label">Klaim Shopee Pending</div>
          <div class="stat-value" style="color: #ee4d2d; font-weight: bold;">{{ $pendingShopeeCount ?? 0 }}</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">👤</div>
        <div>
          <div class="stat-label">Total Users</div>
          <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
        </div>
      </div>
    </div>

    {{-- Dashboard Grid --}}
    <div class="dashboard-grid" style="display: flex; flex-direction: column; gap: 32px;">
      
      {{-- TABEL BARU: ANTIREAN VERIFIKASI MARKETPLACE --}}
      <div class="dashboard-card" id="verifikasi-shopee" style="border: 1px solid #fca5a5;">
        <div class="card-title-area" style="border-bottom: 2px solid #fee2e2; padding-bottom: 12px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
          <h2 class="card-title" style="color: #c2410c; margin: 0;">🟠 Perlu Verifikasi Pembelian Shopee</h2>
          <span style="font-size: 0.85rem; color: #ee4d2d; font-weight: 600;">Aksi Diperlukan</span>
        </div>

        <div style="overflow-x: auto;">
          @if(empty($shopeeKlaims) || $shopeeKlaims->isEmpty())
          <div style="text-align: center; padding: 40px 0; color: var(--text-muted);">
            <p style="font-size: 2rem; margin-bottom: 8px;">🎉</p>
            <p>Semua pesanan Shopee sudah rapi terverifikasi!</p>
          </div>
          @else
          <table class="admin-table">
            <thead>
              <tr>
                <th>User</th>
                <th>Produk</th>
                <th>No. Pesanan Shopee</th>
                <th>Bukti Screenshot</th>
                <th style="text-align: right;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($shopeeKlaims as $klaim)
              <tr>
                <td style="font-weight: 600;">{{ $klaim->user->name ?? 'Unknown' }}</td>
                <td>{{ $klaim->product->name ?? 'Unknown Product' }}</td>
                <td>
                  <span style="font-family: monospace; background: var(--gray-100); padding: 4px 8px; border-radius: 4px; font-size: 0.9rem;">
                    {{ $klaim->marketplace_order_id }}
                  </span>
                  <button type="button" onclick="navigator.clipboard.writeText('{{ $klaim->marketplace_order_id }}'); alert('No Pesanan disalin!')" style="padding: 2px 6px; font-size: 0.75rem; cursor: pointer; margin-left: 4px; border: 1px solid #cbd5e1; border-radius: 4px; background: white;">
                    📋 Salin
                  </button>
                </td>
                <td>
                  @if($klaim->proof_image)
                    <a href="{{ asset('storage/' . $klaim->proof_image) }}" target="_blank" style="color: var(--brand-blue); font-weight: 500; font-size: 0.85rem; text-decoration: underline;">👁️ Lihat Bukti</a>
                  @else
                    <span style="color: var(--text-muted); font-size: 0.85rem;">Tanpa Gambar</span>
                  @endif
                </td>
                <td>
                  <div style="display: flex; gap: 8px; justify-content: flex-end;">
                    <form action="{{ route('admin.marketplace.verify', [$klaim->id, 'verified']) }}" method="POST">
                      @csrf
                      <button type="submit" style="background: #22c55e; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">
                        ✓ Valid
                      </button>
                    </form>
                    <form action="{{ route('admin.marketplace.verify', [$klaim->id, 'rejected']) }}" method="POST">
                      @csrf
                      <button type="submit" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">
                        ✕ Tolak
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

      {{-- Tabel Transaksi Normal --}}
      <div class="dashboard-card">
        <div class="card-title-area" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--gray-200); padding-bottom: 12px; margin-bottom: 16px;">
          <h2 class="card-title" style="margin: 0;">Recent Products (Website Direct)</h2>
          <a href="{{ route('admin.products') }}" style="font-size: 0.85rem; color: var(--brand-blue); font-weight: 600; text-decoration: none;">Manage All Products →</a>
        </div>

        <div style="overflow-x: auto;">
          @if(empty($recentProducts) || $recentProducts->isEmpty())
          <div style="text-align: center; padding: 40px 0; color: var(--text-muted);">
            <p>No products available.</p>
          </div>
          @else
          <table class="admin-table">
            <thead>
              <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Rating</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentProducts as $product)
              <tr>
                <td>
                  <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;" />
                </td>
                <td style="font-weight: 600; color: var(--brand-navy);">{{ $product->name }} {{ $product->emoji }}</td>
                <td>{{ $product->category_label }}</td>
                <td style="font-weight: 600;">${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }} units</td>
                <td style="color: #f59e0b; font-weight: 600;">⭐ {{ $product->rating }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection