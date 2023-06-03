<?php

namespace App\Http\Requests\Accounting\Portfolio;

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
            "title_image"=>"required|image|mimes:png,jpeg,jpg",
            "title"=>"required",
            "content"=>"required",
            "descriptions" =>"required",
            "images" => "nullable|array",
            "images.*" => "nullable|image|mimes:png,jpg,jpeg"
        ];
    }
}
