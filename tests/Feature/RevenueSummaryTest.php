<?php

namespace Tests\Feature;

use App\Models\Revenue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RevenueSummaryTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGetSummary ()
    {
        $this->seed();

        $this->getJson('/api/revenues/summary')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['total', 'date']
                ]
            ]);
    }
}
