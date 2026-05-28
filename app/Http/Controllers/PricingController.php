<?php

namespace App\Http\Controllers;

class PricingController extends Controller
{
    public function index()
    {
        $plans = [
            'monthly' => ['starter' => 29, 'pro' => 49, 'studio' => 99],
            'annual'  => ['starter' => 23, 'pro' => 39, 'studio' => 79],
        ];

        return view('pages.pricing', compact('plans'));
    }
}
