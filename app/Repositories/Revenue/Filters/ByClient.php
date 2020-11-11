<?php

namespace App\Repositories\Revenue\Filters;

use App\Models\Client;
use App\Repositories\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class ByClient implements FilterContract
{
    protected array $clientIds;

    public function __construct (string $name)
    {
        $lower = strtolower($name);
        $this->clientIds = Client::query()
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
        $query->whereIn('client_id', $this->clientIds);
    }
}
