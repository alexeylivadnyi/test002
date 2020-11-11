<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductFilterResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        return ProductFilterResource::collection(Product::all());
    }
}
