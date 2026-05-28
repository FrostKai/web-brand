<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::featured()->limit(3)->get();
        return view('pages.home', compact('featuredProducts'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        DB::table('newsletter_subscribers')->insert([
            'email'      => $request->email,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('toast', 'Thank you for subscribing! 🎧');
    }

    public function about()
    {
        return view('pages.about');
    }
}
