<?php

namespace App\Http\Requests\Accounting\Portfolio;

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
            "title"=>"required|image|mimes:png,jpeg,jpg",
            "content"=>"required",
            "descriptions"=>"required",
            "images" => "nullable|array",
            "images.*" => "nullable|image|mimes:png,jpg,jpeg"
        ];
    }
}
