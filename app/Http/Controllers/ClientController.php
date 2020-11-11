<?php

namespace App\Http\Controllers;

use App\Http\Resources\Client\ClientFilterResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        return ClientFilterResource::collection(Client::all());
    }
}
