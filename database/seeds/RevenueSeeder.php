<?php

use App\Models\Client;
use App\Models\Product;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run ()
    {
        $clientIds = Client::pluck('id')->all();
        $products = Product::all();
        $clientsCount = count($clientIds);
        $productsCount = count($products);

        $now = CarbonImmutable::now();
        $dateFrom = $now->subMonths(3);
        $dayCount = $now->diffInDays($dateFrom);

        $data = [];
        for ($i = 0; $i < $dayCount; $i++) {
            $orderCount = rand(100, 400);
            $date = $dateFrom->addDays($i);
            for ($j = 0; $j < $orderCount; $j++) {
                $product = $products[rand(0, $productsCount - 1)];
                $data[] = [
                    'client_id'  => $clientIds[rand(0, $clientsCount - 1)],
                    'product_id' => $product->id,
                    'total'      => $product->price * rand(1, 1000),
                    'date'       => $date,
                ];
            }
        }

        $partitions = array_chunk($data, 10000);
        foreach ($partitions as $partition) {
            DB::table('revenues')->insert($partition);
        }
    }
}
