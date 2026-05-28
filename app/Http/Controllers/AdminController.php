<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistics
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');

        // Recent Orders
        $recentOrders = Order::latest()->limit(5)->get();

        // Recent Products
        $recentProducts = Product::latest()->limit(5)->get();

        // Orders by Status
        $ordersPending = Order::where('status', 'pending')->count();
        $ordersProcessing = Order::where('status', 'processing')->count();
        $ordersCompleted = Order::where('status', 'delivered')->count();

        // Sales by Category
        $categoriesData = Product::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        return view('pages.admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalUsers', 'totalRevenue',
            'recentOrders', 'recentProducts', 'ordersPending', 'ordersProcessing',
            'ordersCompleted', 'categoriesData'
        ));
    }

    public function products()
    {
        $products = Product::latest()->get();
        return view('pages.admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('pages.admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:headphones,earbuds,speakers',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:50',
            'badge_type' => 'nullable|string|in:new,sale,popular',
            'emoji' => 'nullable|string|max:10',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'specs_keys' => 'nullable|array',
            'specs_values' => 'nullable|array',
            'colors' => 'nullable|array',
        ]);

        // Generate unique slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Process Specs JSON
        $specs = [];
        if ($request->filled('specs_keys') && $request->filled('specs_values')) {
            foreach ($request->specs_keys as $index => $key) {
                if (!empty($key)) {
                    $specs[] = [$key, $request->specs_values[$index] ?? ''];
                }
            }
        }

        // Process Colors JSON
        $colors = [];
        if ($request->filled('colors')) {
            $colors = array_filter($request->colors);
        }

        Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
            'category_label' => ucfirst($request->category),
            'price' => $request->price,
            'old_price' => $request->old_price,
            'badge' => $request->badge,
            'badge_type' => $request->badge_type,
            'emoji' => $request->emoji ?? '🎵',
            'description' => $request->description,
            'image_url' => $request->image_url ?? 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&q=80',
            'stock' => $request->stock,
            'is_featured' => $request->has('is_featured'),
            'specs' => $specs,
            'colors' => $colors,
        ]);

        return redirect()->route('admin.products')->with('toast', 'Product created successfully! 🎉');
    }

    public function editProduct(Product $product)
    {
        return view('pages.admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:headphones,earbuds,speakers',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:50',
            'badge_type' => 'nullable|string|in:new,sale,popular',
            'emoji' => 'nullable|string|max:10',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'stock' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'specs_keys' => 'nullable|array',
            'specs_values' => 'nullable|array',
            'colors' => 'nullable|array',
        ]);

        // Update slug if name changes
        if ($product->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $product->slug = $slug;
        }

        // Process Specs
        $specs = [];
        if ($request->filled('specs_keys') && $request->filled('specs_values')) {
            foreach ($request->specs_keys as $index => $key) {
                if (!empty($key)) {
                    $specs[] = [$key, $request->specs_values[$index] ?? ''];
                }
            }
        }

        // Process Colors
        $colors = [];
        if ($request->filled('colors')) {
            $colors = array_filter($request->colors);
        }

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'category_label' => ucfirst($request->category),
            'price' => $request->price,
            'old_price' => $request->old_price,
            'badge' => $request->badge,
            'badge_type' => $request->badge_type,
            'emoji' => $request->emoji ?? '🎵',
            'description' => $request->description,
            'image_url' => $request->image_url ?? $product->image_url,
            'stock' => $request->stock,
            'is_featured' => $request->has('is_featured'),
            'specs' => $specs,
            'colors' => $colors,
        ]);

        return redirect()->route('admin.products')->with('toast', 'Product updated successfully! ✏️');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('toast', 'Product deleted successfully! 🗑️');
    }
}
