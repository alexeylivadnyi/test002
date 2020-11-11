<?php

namespace App\Repositories\Revenue\Filters;


use App\Repositories\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class ByTotal implements FilterContract
{
    protected string $value;

    /**
     * ByTotal constructor.
     * @param string $value
     */
    public function __construct (string $value)
    {
        $this->value = floatval($value);
    }

    /**
     * @inheritDoc
     */
    public function apply (Builder $query): void
    {
        $query->where('total', $this->value);
    }
}
