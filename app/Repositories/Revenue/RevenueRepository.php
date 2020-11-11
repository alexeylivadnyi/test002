<?php

namespace App\Repositories\Revenue;

interface RevenueRepository
{
    /**
     * @param int   $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate (int $perPage = 15, array $columns = ['*']);

    /**
     * @param array $columns
     * @return mixed
     */
    public function all (array $columns = ['*']);

    /**
     * @param array $columns
     */
    public function summary (array $columns = ['*']);
}
