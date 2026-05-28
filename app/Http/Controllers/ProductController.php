<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Sort
        match ($request->sort) {
            'price-asc'    => $query->orderBy('price'),
            'price-desc'   => $query->orderByDesc('price'),
            'rating'       => $query->orderByDesc('rating'),
            'newest'       => $query->latest(),
            default        => $query->orderByDesc('reviews_count'),
        };

        $products = $query->get();

        return view('pages.products', compact('products'));
    }

    public function show(Product $product)
    {
        // Related products: same category, exclude current
        $related = Product::byCategory($product->category)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();

        return view('pages.product-detail', compact('product', 'related'));
    }
}
