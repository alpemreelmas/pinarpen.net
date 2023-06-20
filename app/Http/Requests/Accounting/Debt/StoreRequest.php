<?php

namespace App\Http\Requests\Accounting\Debt;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "supplier_id"=>"required",
            "material_type"=>"required",
            "unit_price_of_material"=>"required|numeric|min:0.1",
            "square_meters"=>"required|min:0.1|numeric",
        ];
    }
}
