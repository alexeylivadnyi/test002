<?php


namespace App\Repositories;


use Illuminate\Support\Collection;

trait WithFilters
{

    protected ?Collection $filters = null;

    /**
     * @param FilterContract $filter
     */
    public function pushFilter (FilterContract $filter): void
    {
        if (!$this->filters) {
            $this->filters = new Collection();
        }

        $this->filters->push($filter);
    }


    /**
     * @param $query
     */
    public function applyFilter ($query): void
    {
        if (!$this->filters) {
            return;
        }

        $filtersCount = $this->filters->count();
        for ($i = 0; $i < $filtersCount; $i++) {
            $this->filters->get($i)->apply($query);
        }
    }

    /**
     * Check if needed filter exist in filters store
     *
     * @param string $filterClass
     * @return bool
     */
    public function hasFilter (string $filterClass): bool
    {
        $filtersCount = $this->filters->count();
        for ($i = 0; $i < $filtersCount; $i++) {
            if ($this->filters->get($i) instanceof $filterClass) {
                return true;
            }
        }
        return false;
    }

}
