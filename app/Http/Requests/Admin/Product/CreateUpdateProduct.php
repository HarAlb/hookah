<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'numeric',
            'thumbnail' => 'required_without:id|image|mimes:jpg,png',
            'category_id' => 'required|numeric|exists:categories,id',
            'price' => 'required|numeric|max:65000',
            'currency_id' => 'required|exists:currencies,id',
            'title' => 'required|max:100',
            'position' => 'required|numeric',
            'desc' => 'required_with:desc_it|max:255',
        ];
    }
}
