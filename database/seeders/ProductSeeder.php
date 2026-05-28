<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'           => 'Nova Pro X',
                'category'       => 'headphones',
                'category_label' => 'Headphones',
                'price'          => 349,
                'old_price'      => 399,
                'rating'         => 4.9,
                'reviews_count'  => 1247,
                'badge'          => 'Best Seller',
                'badge_type'     => 'popular',
                'emoji'          => '🎧',
                'is_featured'    => true,
                'description'    => 'The Nova Pro X is our flagship over-ear headphone, engineered for those who refuse to compromise. With 40mm custom drivers, active noise cancellation that eliminates up to 98% of ambient noise, and a battery that lasts through your longest days.',
                'specs'          => json_encode([
                    ['Driver Size', '40mm'], ['Frequency Response', '5Hz – 40kHz'],
                    ['Battery Life', '40 hours'], ['ANC', 'Hybrid 3-mic'],
                    ['Bluetooth', '5.3'], ['Weight', '265g'],
                    ['Foldable', 'Yes'], ['Colors', '3 options'],
                ]),
                'colors'         => json_encode(['#2d3561', '#e5e7eb', '#f72585']),
                'image_url'      => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&q=80',
            ],
            [
                'name'           => 'Buds Pro',
                'category'       => 'earbuds',
                'category_label' => 'Earbuds',
                'price'          => 149,
                'old_price'      => null,
                'rating'         => 4.8,
                'reviews_count'  => 892,
                'badge'          => 'New',
                'badge_type'     => 'new',
                'emoji'          => '🎵',
                'is_featured'    => true,
                'description'    => 'Tiny in size, massive in sound. The Buds Pro pack 8mm premium drivers into an ultra-compact form that disappears into your ears.',
                'specs'          => json_encode([
                    ['Driver', '8mm dynamic'], ['Battery', '9 + 27 hrs (case)'],
                    ['ANC', 'Adaptive 3-level'], ['Water Resistance', 'IPX4'],
                    ['Bluetooth', '5.3 Multipoint'], ['Weight', '5.6g per bud'],
                    ['Wireless Charging', 'Yes'], ['Colors', '5 options'],
                ]),
                'colors'         => json_encode(['#2d3561', '#4361EE', '#f72585', '#e5e7eb', '#0d1b2a']),
                'image_url'      => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&q=80',
            ],
            [
                'name'           => 'Air Series 2',
                'category'       => 'headphones',
                'category_label' => 'Headphones',
                'price'          => 199,
                'old_price'      => null,
                'rating'         => 4.7,
                'reviews_count'  => 643,
                'badge'          => null,
                'badge_type'     => null,
                'emoji'          => '🎼',
                'is_featured'    => true,
                'description'    => 'The Air Series 2 takes everything you love about wireless audio and strips it down to its essence. Lightweight, airy, and astonishingly clear.',
                'specs'          => json_encode([
                    ['Driver Size', '35mm'], ['Frequency Response', '20Hz – 22kHz'],
                    ['Battery Life', '30 hours'], ['ANC', '2-level'],
                    ['Bluetooth', '5.2'], ['Weight', '220g'],
                    ['Foldable', 'Yes'], ['Colors', '4 options'],
                ]),
                'colors'         => json_encode(['#2d3561', '#4361EE', '#e5e7eb', '#f72585']),
                'image_url'      => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=400&q=80',
            ],
            [
                'name'           => 'Nomad Speaker',
                'category'       => 'speakers',
                'category_label' => 'Speakers',
                'price'          => 129,
                'old_price'      => 159,
                'rating'         => 4.8,
                'reviews_count'  => 512,
                'badge'          => 'Sale',
                'badge_type'     => 'sale',
                'emoji'          => '🔊',
                'is_featured'    => false,
                'description'    => 'Take the party anywhere. The Nomad Speaker delivers 360° room-filling sound with 20W of output, IPX7 waterproofing, and 24-hour battery.',
                'specs'          => json_encode([
                    ['Output Power', '20W RMS'], ['Frequency Response', '60Hz – 20kHz'],
                    ['Battery Life', '24 hours'], ['Water Resistance', 'IPX7'],
                    ['Bluetooth', '5.0 + NFC'], ['Weight', '680g'],
                    ['Party Mode', 'Up to 2 speakers'], ['USB-C', 'Yes (charging only)'],
                ]),
                'colors'         => json_encode(['#2d3561', '#22c55e', '#f59e0b']),
                'image_url'      => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400&q=80',
            ],
            [
                'name'           => 'Classic Open',
                'category'       => 'headphones',
                'category_label' => 'Headphones',
                'price'          => 399,
                'old_price'      => null,
                'rating'         => 4.9,
                'reviews_count'  => 321,
                'badge'          => null,
                'badge_type'     => null,
                'emoji'          => '🎙',
                'is_featured'    => false,
                'description'    => 'For the discerning audiophile who accepts no compromise. The Classic Open is an open-back, planar magnetic headphone delivering an impossibly wide soundstage.',
                'specs'          => json_encode([
                    ['Driver', 'Planar magnetic'], ['Frequency Response', '5Hz – 50kHz'],
                    ['Impedance', '50 Ω'], ['Sensitivity', '100 dB/mW'],
                    ['Connectivity', '3.5mm + 6.35mm'], ['Weight', '340g'],
                    ['Cable Length', '1.5m detachable'], ['Use Case', 'Home listening'],
                ]),
                'colors'         => json_encode(['#2d3561', '#e5e7eb']),
                'image_url'      => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&q=80',
            ],
            [
                'name'           => 'Sport Clip',
                'category'       => 'earbuds',
                'category_label' => 'Earbuds',
                'price'          => 89,
                'old_price'      => 109,
                'rating'         => 4.6,
                'reviews_count'  => 789,
                'badge'          => null,
                'badge_type'     => null,
                'emoji'          => '🏃',
                'is_featured'    => false,
                'description'    => 'Built for movement. The Sport Clip earbuds feature an over-ear hook design that stays in no matter how hard you train. IPX6 rated.',
                'specs'          => json_encode([
                    ['Driver', '6.8mm dynamic'], ['Battery', '8 + 24 hrs (case)'],
                    ['Water Resistance', 'IPX6'], ['ANC', 'Ambient Aware mode'],
                    ['Bluetooth', '5.2'], ['Weight', '6.1g per bud'],
                    ['Ear Hook', 'Adjustable'], ['Colors', '5 options'],
                ]),
                'colors'         => json_encode(['#2d3561', '#22c55e', '#f72585', '#f59e0b', '#4361EE']),
                'image_url'      => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=400&q=80',
            ],
        ];

        foreach ($products as $product) {
            $product['slug'] = Str::slug($product['name']);
            $product['created_at'] = now();
            $product['updated_at'] = now();
            DB::table('products')->insert($product);
        }
    }
}
