<?php

namespace App\Http\Requests\Accounting\Project;

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
            "customer_id"=>"required",
            "customer_name"=>"required",
            "material_type"=>"required",
            "material_amount"=>"required",
            "payment_type"=>"required",
            "supplier_id"=>"required",
            "unit_price_of_material"=>"required|numeric|min:0.1",
            "square_meters"=>"required|min:0.1|numeric",
            "is_stock"=>"required",
            "earning" => "required|min:0|numeric",
            "pay_date" => "required",
            "note" => "nullable|string",
        ];
    }
}
