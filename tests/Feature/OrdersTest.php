<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_successfully()
    {
        $payload = [
            'product_name' => 'Laptop',
            'quantity' => 2,
            'price' => 50.00,
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(201)
                ->assertJsonStructure([
                            'product_name',
                            'quantity',
                            'price',
                            'created_at',
                    ]);

        $this->assertDatabaseHas('orders', [
            'product_name' => 'Laptop',
            'quantity' => 2,
            'price' => 50.00,
        ]);
    }

    public function test_create_order_fails_with_invalid_data()
    {
        $payload = [
            'product_name' => '',
            'quantity' => -1,
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(422)
                    ->assertJsonValidationErrors(['product_name', 'quantity']);
    }
}
