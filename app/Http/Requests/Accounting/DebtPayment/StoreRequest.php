<?php

namespace App\Http\Requests\Accounting\DebtPayment;

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
            "payer_name"=>"required",
            "payer_surname"=>"required",
            "amount"=>"required",
            "debt_id"=>"required",
        ];
    }
}
