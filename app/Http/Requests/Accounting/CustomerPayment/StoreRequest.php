<?php

namespace App\Http\Requests\Accounting\CustomerPayment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            "project_id"=>["required",Rule::exists("projects","id")],
            "amount"=>["required","decimal","min:1"],
            "payer_name"=>["required","string","max:255"],
        ];
    }
}
