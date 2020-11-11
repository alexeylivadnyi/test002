<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Product;
use App\Models\Revenue;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RevenueTest extends TestCase
{
    protected int $perPage;

    protected function setUp (): void
    {
        parent::setUp();
        $this->perPage = config('app.per_page');
    }

    public function testCanGetListOfRevenues ()
    {
        factory(Revenue::class, 100)->create();

        $this->getJson('api/revenues')
            ->assertSuccessful()
            ->assertJsonCount($this->perPage, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'total', 'date',
                        'client'  => ['id', 'name',],
                        'product' => ['id', 'name', 'price']
                    ]
                ]
            ]);
    }

    public function testCanGetFilteredByClientList ()
    {
        $expected = 10;
        $field = Revenue::FIELD_CLIENT;
        $keyword = 'test';

        factory(Revenue::class, 100)->create();
        $client = factory(Client::class)->create([
            'name' => $keyword,
        ]);
        factory(Revenue::class, $expected)->create([
            'client_id' => $client->id,
        ]);

        $this->getJson("api/revenues?field={$field}&keywords={$keyword}")
            ->assertSuccessful()
            ->assertJsonCount($expected, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'total', 'date',
                        'client'  => ['id', 'name',],
                        'product' => ['id', 'name', 'price']
                    ]
                ]
            ]);
    }

    public function testCanGetFilteredByProductList ()
    {
        $expected = 10;
        $field = Revenue::FIELD_PRODUCT;
        $keyword = 'test';

        factory(Revenue::class, 100)->create();
        $product = factory(Product::class)->create([
            'name' => $keyword,
        ]);
        factory(Revenue::class, $expected)->create([
            'product_id' => $product->id,
        ]);

        $this->getJson("api/revenues?field={$field}&keywords={$keyword}")
            ->assertSuccessful()
            ->assertJsonCount($expected, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'total', 'date',
                        'client'  => ['id', 'name',],
                        'product' => ['id', 'name', 'price']
                    ]
                ]
            ]);
    }

    public function testCanGetFilteredByTotalList ()
    {
        $expected = 10;
        $field = Revenue::FIELD_TOTAL;
        $keyword = 100.15;

        factory(Revenue::class, 100)->create();
        factory(Revenue::class, $expected)->create([
            'total' => $keyword,
        ]);

        $this->getJson("api/revenues?field={$field}&keywords={$keyword}")
            ->assertSuccessful()
            ->assertJsonCount($expected, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'total', 'date',
                        'client'  => ['id', 'name',],
                        'product' => ['id', 'name', 'price']
                    ]
                ]
            ]);
    }

    public function testCanGetFilteredByDateList ()
    {
        $date = Carbon::now()->addDays(5);
        $keyword = $date->format(config('app.date_format'));

        $expected = 10;
        $field = Revenue::FIELD_DATE;

        factory(Revenue::class, 100)->create();
        factory(Revenue::class, $expected)->create([
            'date' => $date,
        ]);

        $this->getJson("api/revenues?field={$field}&keywords={$keyword}")
            ->assertSuccessful()
            ->assertJsonCount($expected, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'total', 'date',
                        'client'  => ['id', 'name',],
                        'product' => ['id', 'name', 'price']
                    ]
                ]
            ]);
    }

    public function testCanGetFilteredByCustomField ()
    {
        $expected = 10;
        $field = Revenue::FIELDS_ALL;
        $keyword = 'test';

        factory(Revenue::class, 100)->create();
        $product = factory(Product::class)->create([
            'name' => $keyword,
        ]);
        factory(Revenue::class, 5)->create([
            'product_id' => $product->id,
        ]);
        $client = factory(Client::class)->create([
            'name' => $keyword,
        ]);
        factory(Revenue::class, 5)->create([
            'client_id' => $client->id,
        ]);

        $this->getJson("api/revenues?field={$field}&keywords={$keyword}")
            ->assertSuccessful()
            ->assertJsonCount($expected, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'total', 'date',
                        'client'  => ['id', 'name',],
                        'product' => ['id', 'name', 'price']
                    ]
                ]
            ]);
    }

    public function testCanUpdateRevenue ()
    {
        $revenue = factory(Revenue::class)->create();

        $data = [
            'total'      => 100500,
            'date'       => Carbon::now()->format(config('app.date_format')),
            'client_id'  => factory(Client::class)->create()->id,
            'product_id' => factory(Product::class)->create()->id,
        ];

        $this->patchJson("api/revenues/{$revenue->id}", $data)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id', 'total', 'date',
                    'client'  => ['id', 'name',],
                    'product' => ['id', 'name', 'price']
                ]
            ]);

        $this->assertEquals(1, Revenue::count());

        $this->assertDatabaseHas('revenues', [
            'id'         => $revenue->id,
            'date'       => Carbon::now()->format('Y-m-d'),
            'total'      => $data['total'],
            'product_id' => $data['product_id'],
            'client_id'  => $data['client_id'],
        ]);
    }

    public function testCanGetListOrderedByFieldAsc ()
    {
        factory(Revenue::class, 100)->create();

        $response = $this->getJson('api/revenues?sortBy[]=date&sortDesc[]=0')
            ->assertSuccessful();
        $data = $response->json()['data'];

        for ($i = 1; $i < count($data); $i++) {
            $curDate = Carbon::createFromFormat(config('app.date_format'), $data[$i]['date']);
            $prevDate = Carbon::createFromFormat(config('app.date_format'), $data[$i - 1]['date']);
            $this->assertTrue($curDate >= $prevDate);
        }
    }

    public function testCanGetListOrderedByFieldDesc ()
    {
        factory(Revenue::class, 100)->create();

        $response = $this->getJson('api/revenues?sortBy[]=date&sortDesc[]=1')
            ->assertSuccessful();
        $data = $response->json()['data'];

        for ($i = 1; $i < count($data); $i++) {
            $curDate = Carbon::createFromFormat(config('app.date_format'), $data[$i]['date']);
            $prevDate = Carbon::createFromFormat(config('app.date_format'), $data[$i - 1]['date']);
            $this->assertTrue($curDate <= $prevDate);
        }

    }
}
