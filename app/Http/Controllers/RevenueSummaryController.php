<?php

namespace App\Http\Controllers;

use App\Http\Requests\Revenue\RevenueIndexRequest;
use App\Http\Resources\Revenue\RevenueResource;
use App\Http\Resources\RevenueSummaryResource;
use App\Models\Revenue;
use App\Repositories\Revenue\Filters\ByAllFields;
use App\Repositories\Revenue\Filters\ByClient;
use App\Repositories\Revenue\Filters\ByDate;
use App\Repositories\Revenue\Filters\ByProduct;
use App\Repositories\Revenue\Filters\ByTotal;
use App\Repositories\Revenue\Filters\SortBy;
use App\Repositories\Revenue\RevenueRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RevenueSummaryController extends Controller
{
    protected RevenueRepository $repository;

    /**
     * RevenueController constructor.
     * @param RevenueRepository $repository
     */
    public function __construct (RevenueRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RevenueIndexRequest $request): JsonResource
    {
        if ($request->has('field')) {
            $filter = null;
            $keywords = $request->get('keywords');

            switch ($request->get('field')) {
                case Revenue::FIELDS_ALL:
                    $filter = new ByAllFields($keywords);
                    break;
                case Revenue::FIELD_TOTAL:
                    $filter = new ByTotal($keywords);
                    break;
                case Revenue::FIELD_CLIENT:
                    $filter = new ByClient($keywords);
                    break;
                case Revenue::FIELD_PRODUCT:
                    $filter = new ByProduct($keywords);
                    break;
                case Revenue::FIELD_DATE:
                    $filter = new ByDate($keywords);
                    break;
            }

            if ($filter) {
                $this->repository->pushFilter($filter);
            }
        }

        if ($request->has('sortBy')) {
            $this->repository->pushFilter(
                new SortBy($request->get('sortBy'), $request->get('sortDesc'))
            );
        }

        return RevenueSummaryResource::collection($this->repository->summary());
    }
}
