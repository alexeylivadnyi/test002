<?php

namespace App\Http\Requests\Revenue;

use Illuminate\Foundation\Http\FormRequest;

class RevenueUpdateRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'client_id'  => 'required|exists:clients,id',
            'total'      => 'required|numeric',
            'date'       => 'required|date_format:' . config('app.date_format'),
        ];
    }
}
