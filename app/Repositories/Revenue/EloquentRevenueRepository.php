<?php

namespace App\Repositories\Revenue;

use App\Models\Revenue;
use App\Repositories\WithFilters;

class EloquentRevenueRepository implements RevenueRepository
{
    use WithFilters;

    /**
     * @inheritDoc
     */
    public function paginate (int $perPage = 15, array $columns = ['*'])
    {
        $query = Revenue::with('product', 'client')->newQuery();

        $this->applyFilter($query);

        return $query->paginate($perPage, $columns);
    }

    /**
     * @inheritDoc
     */
    public function all (array $columns = ['*'])
    {
        $query = Revenue::with('product', 'client')->newQuery();

        $this->applyFilter($query);

        return $query->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function summary (array $columns = ['*'])
    {
        $query = Revenue::with('product', 'client')->newQuery();

        $this->applyFilter($query);

        return $query->selectRaw('sum(total) as sum, date')
            ->groupBy('date')->orderBy('date')->get();
    }
}
