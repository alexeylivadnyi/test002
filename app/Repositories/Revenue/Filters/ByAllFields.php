<?php

namespace App\Repositories\Revenue\Filters;

use App\Models\Client;
use App\Models\Product;
use App\Repositories\FilterContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ByAllFields implements FilterContract
{
    protected array $clientIds;
    protected array $productIds;
    protected float $total;
    protected ?Carbon $date;

    /**
     * ByAllFields constructor.
     * @param string $search
     */
    public function __construct (string $search)
    {
        $lower = strtolower($search);

        $this->clientIds = Client::query()
            ->where(function ($q) use ($search, $lower) {
                $q->where('name', 'like', "%{$search}%")
                    ->where('name', 'like', "%{$lower}%");
            })->pluck('id')->all();

        $this->productIds = Product::query()
            ->where(function ($q) use ($search, $lower) {
                $q->where('name', 'like', "%{$search}%")
                    ->where('name', 'like', "%{$lower}%");
            })->pluck('id')->all();

        $this->total = floatval($search);

        try {
            $this->date = Carbon::createFromFormat(config('app.date_format'), $search);
        } catch (\Exception $exception) {
            $this->date = null;
        }
    }

    /**
     * @inheritDoc
     */
    public function apply (Builder $query): void
    {
        if ($this->date) {
            $query = $query->where('date', $this->date->format('Y-m-d'));
        }

        $query->orWhereIn('client_id', $this->clientIds)
            ->orWhereIn('product_id', $this->productIds)
            ->orWhere('total', $this->total);
    }
}
