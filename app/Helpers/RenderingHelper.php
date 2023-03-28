<?php

namespace App\Helpers;

use App\Models\Category;
use Illuminate\Support\Collection;

class RenderingHelper
{
    public static function renderCategoriesList(Collection $categories, array &$visited = []): string
    {
        $str = "<ul style='list-style-type: none;'>";
        foreach ($categories as $category) {

            if (in_array($category->id, $visited)) {
                continue;
            }

            $children_ids = self::getCategoryChildrenRecursive($category);
            $parents_ids = self::getCategoryParentsRecursive($category);

            $checkbox = "<input 
                    type='checkbox' 
                    name='categories[]' 
                    class='form-check-input'
                    id='category_" . $category->id . "' 
                    data-children-ids='" . json_encode($children_ids) . "' 
                    data-parents-ids='" . json_encode($parents_ids) . "'
                    value='" . $category->id . "'> ";

            $label = "<label class='form-check-label' for='category_" . $category->id . "'>" . $category->name . "</label>";

            $element = "<li>" . $checkbox . $label . "</li>";
            $str .= $element;

            $visited[] = $category->id;
            if ($category->children()->count() > 0) {
                $str .= self::renderCategoriesList($category->children, $visited);
            }
        }
        $str .= "</ul>";
        return $str;
    }

    private static function getCategoryChildrenRecursive(Category $category, array &$acc = []): array
    {
        $children = $category->children;
        foreach ($children as $child) {
            if (!in_array($child->id, $acc)) {
                $acc[] = $child->id;
            }

            $result = self::getCategoryChildrenRecursive($child, $acc);
            $acc = array_merge($acc, $result);
        }
        $acc = array_unique($acc);
        return $acc;
    }

    private static function getCategoryParentsRecursive(Category $category, array &$acc = []): array
    {
        $parents = $category->parents;
        foreach ($parents as $parent) {
            if (!in_array($parent->id, $acc)) {
                $acc[] = $parent->id;
            }

            $result = self::getCategoryParentsRecursive($parent, $acc);
            $acc = array_merge($acc, $result);
        }
        $acc = array_unique($acc);
        return $acc;
    }
}
