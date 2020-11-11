<?php

namespace App\Http\Controllers;

use App\Http\Requests\Revenue\RevenueIndexRequest;
use App\Http\Requests\Revenue\RevenueUpdateRequest;
use App\Http\Resources\Revenue\RevenueResource;
use App\Models\Revenue;
use App\Repositories\Revenue\Filters\ByAllFields;
use App\Repositories\Revenue\Filters\ByClient;
use App\Repositories\Revenue\Filters\ByDate;
use App\Repositories\Revenue\Filters\ByProduct;
use App\Repositories\Revenue\Filters\ByTotal;
use App\Repositories\Revenue\Filters\SortBy;
use App\Repositories\Revenue\RevenueRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class RevenueController extends Controller
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
     * @param RevenueIndexRequest $request
     * @return JsonResource
     */
    public function index (RevenueIndexRequest $request): JsonResource
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

        return RevenueResource::collection($this->repository->paginate());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RevenueUpdateRequest $request
     * @param Revenue              $revenue
     * @return JsonResource
     */
    public function update (RevenueUpdateRequest $request, Revenue $revenue): JsonResource
    {
        $fields = $request->only('total');

        $revenue->fill(array_merge($fields, [
            'date' => Carbon::createFromFormat(config('app.date_format'), $request->get('date')),
        ]));

        $revenue->client()->associate($request->get('client_id'));
        $revenue->product()->associate($request->get('product_id'));

        $revenue->save();
        return RevenueResource::make($revenue->load('product', 'client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Revenue $revenue
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy (Revenue $revenue): JsonResponse
    {
        return $revenue->delete()
            ? response()->json()
            : response()->json('', 400);
    }
}
