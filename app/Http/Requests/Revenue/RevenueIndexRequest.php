<?php

namespace App\Http\Requests\Revenue;

use App\Models\Revenue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class RevenueIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize ()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ()
    {
        return [
            'keywords'   => 'required_with:field',
            'field'      => 'required_with:keywords|in:' . implode(',', Revenue::FIELDS),
            'sortBy'     => 'array',
            'sortBy.*'   => 'string|in:id,client,product,total,date',
            'sortDesc'   => "array|required_with:sortBy",
            'sortDesc.*' => 'boolean',
        ];
    }
}
