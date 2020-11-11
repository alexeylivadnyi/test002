<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    public function testCanGetAllProducts ()
    {
        $expected = 100;
        factory(Client::class, $expected)->create();

        $this->getJson('api/clients')
            ->assertSuccessful()
            ->assertJsonCount($expected, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name']
                ]
            ]);
    }
}
