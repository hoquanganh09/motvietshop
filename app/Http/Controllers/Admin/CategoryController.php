<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Category\CreateCategoryAction;
use App\Actions\Admin\Category\DeleteCategoryAction;
use App\Actions\Admin\Category\GetListCategoryAction;
use App\Actions\Admin\Category\UpdateCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = app()->make(GetListCategoryAction::class)->handle();

        if (request()->ajax()) {
            return response()->view('admin.category.table_list', compact('categories'));
        }

        return view('admin.category.index', compact('categories'));
    }

    public function store(CreateCategoryRequest $request)
    {
        $validated = $request->validated();

        app()->make(CreateCategoryAction::class)->handle($validated);

        return response()->json([
            'message' => 'Thêm mới phân loại thành công.',
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        app()->make(UpdateCategoryAction::class)->handle($validated, $category);

        return response()->json([
            'message' => 'Cập nhật phân loại thành công.',
        ]);
    }

    public function edit(Category $category)
    {
        return response()->view('admin.category.modals.edit', compact('category'));
    }

    public function destroy(Category $category)
    {
        app()->make(DeleteCategoryAction::class)->handle($category);

        return response()->json([
            'message' => 'Xóa phân loại thành công.',
        ]);
    }
}
