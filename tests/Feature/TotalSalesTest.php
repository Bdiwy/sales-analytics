<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TotalSalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_total_sales()
    {
        DB::table('orders')->insert([
            'product_name' => 'Laptop',
            'quantity' => 2,
            'price' => 100.00,
            'created_at' => now(),
        ]);

        $response = $this->postJson('/api/orders/total-sales');

        $response->assertStatus(200)
                    ->assertJson([
                        'total_sales' => 200.00,
                    ]);
    }
}