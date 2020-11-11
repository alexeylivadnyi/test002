<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testCanGetAllProducts ()
    {
        $expected = 100;
        factory(Product::class, $expected)->create();

        $this->getJson('api/products')
            ->assertSuccessful()
            ->assertJsonCount($expected, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name']
                ]
            ]);
    }
}
