<?php

namespace App\Repositories\Revenue\Filters;


use App\Repositories\FilterContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ByDate implements FilterContract
{
    protected ?Carbon $date;

    /**
     * ByDate constructor.
     * @param string $date
     */
    public function __construct (string $date)
    {
        try {
            $this->date = Carbon::createFromFormat(config('app.date_format'), $date);
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
            $query->where('date', $this->date->format('Y-m-d'));
        }
    }
}
