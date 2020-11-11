<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Builder;

interface FilterContract
{
    /**
     * Apply criteria
     *
     * @param $query
     */
    public function apply (Builder $query): void;
}
