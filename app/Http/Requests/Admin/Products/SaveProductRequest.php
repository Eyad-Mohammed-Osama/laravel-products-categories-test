<?php

namespace App\Http\Requests\Admin\Products;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class SaveProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = RuleFactory::make([
            "%name%"        =>  ["required", "string", "max:20"],
            "price"         =>  ["required", "numeric", "gt:0"],
            "stock_count"   =>  ["required", "integer", "gt:0"],
            "categories"    =>  ["required", "array", "min:1"]
        ]);

        return $rules;
    }
}
