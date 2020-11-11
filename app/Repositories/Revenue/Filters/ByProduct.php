<?php

namespace App\Repositories\Revenue\Filters;


use App\Models\Product;
use App\Repositories\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class ByProduct implements FilterContract
{
    protected array $productIds;

    public function __construct (string $name)
    {
        $lower = strtolower($name);
        $this->productIds = Product::query()
            ->where(function ($q) use ($name, $lower) {
                $q->where('name', 'like', "%{$name}%")
                    ->where('name', 'like', "%{$lower}%");
            })->pluck('id')->all();
    }

    /**
     * @inheritDoc
     */
    public function apply (Builder $query): void
    {
        $query->whereIn('product_id', $this->productIds);
    }
}
