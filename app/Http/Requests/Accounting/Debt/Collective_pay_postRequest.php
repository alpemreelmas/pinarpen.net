<?php

namespace App\Http\Requests\Accounting\Debt;

use Illuminate\Foundation\Http\FormRequest;

class Collective_pay_postRequest extends FormRequest
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
            "amount"=>"required|numeric"
        ];
    }
}
