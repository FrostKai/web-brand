<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_forgot_password_page_loads(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
    }

    public function test_newsletter_subscription_saves_email(): void
    {
        $response = $this->post('/newsletter', [
            'email' => 'subscriber@example.com'
        ]);

        $response->assertStatus(302); // Redirect back
        $response->assertSessionHas('toast');
        
        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'subscriber@example.com'
        ]);
    }

    public function test_promo_code_applies_discount_correctly(): void
    {
        // Create product
        $product = \App\Models\Product::create([
            'name'           => 'Test Product',
            'slug'           => 'test-product',
            'category'       => 'headphones',
            'category_label' => 'Headphones',
            'price'          => 100.00,
            'description'    => 'A test description',
            'stock'          => 10,
        ]);

        // Add to cart
        $this->post('/cart/add/' . $product->slug, ['qty' => 1]);

        // Apply promo WELCOME20 (20% off)
        $this->post('/cart/promo', ['code' => 'WELCOME20']);

        // Check if cart view has correct calculations
        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertViewHas('total', 88.00); // $100 subtotal + $8 tax - $20 discount
    }
}
