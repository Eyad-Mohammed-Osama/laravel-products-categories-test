<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\SaveProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount("products")->withSum("products", "price")->get();
        return view("admin.subviews.products.view-all", compact("categories"));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view("admin.subviews.products.save", compact("categories"));
    }

    public function save(SaveProductRequest $request, ProductService $service): JsonResponse
    {
        DB::beginTransaction();
        $response = $service->save($request->except("_token", "categories"), $request->categories);
        DB::commit();

        return response()->json($response);
    }
}
