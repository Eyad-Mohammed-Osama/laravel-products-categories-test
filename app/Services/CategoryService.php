<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function save(array $data, int $parent_id): Category
    {
        $category = Category::create($data);
        if (isset($data["parent_id"])) {
            $parent_id = $data["parent_id"];
            $parent = Category::find($parent_id);
            $parent->children()->syncWithDetaching($category->id);
        }
        return $category;
    }
}
