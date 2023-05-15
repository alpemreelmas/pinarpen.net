<?php

namespace App\Http\Requests\Accounting\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "name"=>["required","string","max:255"],
            "surname"=>["required","string","max:255"],
            "phone_number"=>["required","string","max:255"],
            "address"=>["nullable","string","max:255"],
        ];
    }
}
