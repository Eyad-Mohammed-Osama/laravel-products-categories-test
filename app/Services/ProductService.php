<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function save(array $data, array $categories): Product
    {
        $product = Product::create($data);
        $product->categories()->sync($categories);
        return $product;
    }
}
