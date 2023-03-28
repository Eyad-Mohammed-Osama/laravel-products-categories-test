<?php

namespace App\Http\Requests\Admin\Categories;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCategoryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = RuleFactory::make([
            "%name%"    => ["required", "string", "max:20"],
            "parent_id" => ["nullable", "integer", "gt:0", Rule::exists("categories", "id")]
        ]);
        return $rules;
    }
}
