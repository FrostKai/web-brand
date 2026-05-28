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
        <div class="stat-icon">💵</div>
        <div>
          <div class="stat-label">Total Revenue</div>
          <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">🛍️</div>
        <div>
          <div class="stat-label">Total Orders</div>
          <div class="stat-value">{{ $totalOrders }}</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div>
          <div class="stat-label">Total Products</div>
          <div class="stat-value">{{ $totalProducts }}</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">👤</div>
        <div>
          <div class="stat-label">Total Users</div>
          <div class="stat-value">{{ $totalUsers }}</div>
        </div>
      </div>
    </div>

    {{-- Dashboard Grid --}}
    <div class="dashboard-grid">
      {{-- Recent Orders --}}
      <div class="dashboard-card">
        <div class="card-title-area">
          <h2 class="card-title">Recent Orders</h2>
          <span style="font-size: 0.85rem; color: var(--brand-blue); font-weight: 600;">Live Feed</span>
        </div>

        <div style="overflow-x: auto;">
          @if($recentOrders->isEmpty())
          <div style="text-align: center; padding: 40px 0; color: var(--text-muted);">
            <p style="font-size: 1.5rem; margin-bottom: 8px;">🛒</p>
            <p>No orders placed yet.</p>
          </div>
          @else
          <table class="admin-table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentOrders as $order)
              <tr>
                <td style="font-weight: 600; color: var(--brand-navy);">#{{ $order->id }}</td>
                <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                <td style="font-weight: 600;">${{ number_format($order->total, 2) }}</td>
                <td>
                  <span class="badge-status {{ $order->status }}">
                    {{ $order->status }}
                  </span>
                </td>
                <td style="color: var(--text-muted);">{{ $order->created_at->format('M d, Y') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @endif
        </div>
      </div>

      {{-- Sales Monitoring & Categories --}}
      <div class="dashboard-card" style="display: flex; flex-direction: column; justify-content: space-between;">
        <div>
          <div class="card-title-area">
            <h2 class="card-title">Stock & Inventory</h2>
            <span style="font-size: 0.85rem; color: var(--text-muted);">By Category</span>
          </div>

          @php
          $headphonesCount = $categoriesData['headphones'] ?? 0;
          $earbudsCount = $categoriesData['earbuds'] ?? 0;
          $speakersCount = $categoriesData['speakers'] ?? 0;
          $maxCategory = max($headphonesCount, $earbudsCount, $speakersCount, 1);
          @endphp

          <div class="progress-container">
            <div class="progress-header">
              <span>🎧 Headphones</span>
              <strong>{{ $headphonesCount }} products</strong>
            </div>
            <div class="progress-bar-bg">
              <div class="progress-bar-fill" style="width: {{ ($headphonesCount / $maxCategory) * 100 }}%;"></div>
            </div>
          </div>

          <div class="progress-container">
            <div class="progress-header">
              <span>🎵 Earbuds</span>
              <strong>{{ $earbudsCount }} products</strong>
            </div>
            <div class="progress-bar-bg">
              <div class="progress-bar-fill" style="width: {{ ($earbudsCount / $maxCategory) * 100 }}%; background: #00A3FF;"></div>
            </div>
          </div>

          <div class="progress-container">
            <div class="progress-header">
              <span>🔊 Speakers</span>
              <strong>{{ $speakersCount }} products</strong>
            </div>
            <div class="progress-bar-bg">
              <div class="progress-bar-fill" style="width: {{ ($speakersCount / $maxCategory) * 100 }}%; background: var(--accent);"></div>
            </div>
          </div>
        </div>

        <div style="border-top: 1px solid var(--gray-100); padding-top: 20px; margin-top: 20px;">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
              <div style="font-size: 0.85rem; color: var(--text-muted);">Pending Orders</div>
              <div style="font-size: 1.5rem; font-weight: 700; color: #d97706;">{{ $ordersPending }}</div>
            </div>
            <div>
              <div style="font-size: 0.85rem; color: var(--text-muted);">Processing</div>
              <div style="font-size: 1.5rem; font-weight: 700; color: #2563eb;">{{ $ordersProcessing }}</div>
            </div>
            <div>
              <div style="font-size: 0.85rem; color: var(--text-muted);">Completed</div>
              <div style="font-size: 1.5rem; font-weight: 700; color: #059669;">{{ $ordersCompleted }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Recent Products Grid / List --}}
    <div class="dashboard-card">
      <div class="card-title-area">
        <h2 class="card-title">Newly Added Products</h2>
        <a href="{{ route('admin.products') }}" style="font-size: 0.85rem; color: var(--brand-blue); font-weight: 600;">Manage All Products →</a>
      </div>

      <div style="overflow-x: auto;">
        @if($recentProducts->isEmpty())
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
@endsection