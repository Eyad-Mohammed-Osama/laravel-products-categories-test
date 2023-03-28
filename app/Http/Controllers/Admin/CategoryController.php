<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\SaveCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::paginate(5);
        return view("admin.subviews.categories.view-all", compact("categories"));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view("admin.subviews.categories.save", compact("categories"));
    }

    public function save(SaveCategoryRequest $request, CategoryService $service): JsonResponse
    {
        DB::beginTransaction();
        $response = $service->save($request->except("_token", "parent_id"), $request->parent_id);
        DB::commit();

        return response()->json($response);
    }
}
