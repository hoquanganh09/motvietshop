<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Color\GetListColorAction;
use App\Actions\Admin\Kind\GetListKindAction;
use App\Actions\Admin\Product\CreateProductAction;
use App\Actions\Admin\Product\DeleteProductAction;
use App\Actions\Admin\Product\GetListProductAction;
use App\Actions\Admin\Product\UpdateProductAction;
use App\Actions\Admin\Size\GetListSizeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Kind;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = [
            'search' => request()->input('search', ''),
            'is_active' => request()->input('is_active', ''),
            'kind_id' => request()->input('kind_id', ''),
        ];

        $products = app()->make(GetListProductAction::class)->handle(
            filters: $filters,
            hasPaginate: true,
        );

        if (request()->ajax()) {
            return response()->view('admin.product.table_list', compact('products'));
        }

        $filters = [
            [
                'name' => 'is_active',
                'label' => 'Trạng thái',
                'data' => [
                    '1' => 'Đang hoạt động',
                    '0' => 'Không hoạt động',
                ],
            ],
            [
                'name' => 'kind_id',
                'label' => 'Thể loại',
                'data' => Kind::query()->pluck('name', 'id')->toArray(),
            ],
        ];

        return view('admin.product.index', compact('products', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kinds = app()->make(GetListKindAction::class)->handle(hasPaginate: false);
        $colors = app()->make(GetListColorAction::class)->handle(hasPaginate: false);
        $sizes = app()->make(GetListSizeAction::class)->handle(hasPaginate: false);

        return view('admin.product.create', compact('kinds', 'colors', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        // dd($request->validated());
        $success = app()->make(CreateProductAction::class)->handle($request->validated());

        if (!$success) {
            return redirect()->back()->with('error', 'Thêm mới sản phẩm thất bại.');
        }

        return to_route('admin.product.index')->with('success', 'Thêm mới sản phẩm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $kinds = app()->make(GetListKindAction::class)->handle(hasPaginate: false);
        $colors = app()->make(GetListColorAction::class)->handle(hasPaginate: false);
        $sizes = app()->make(GetListSizeAction::class)->handle(hasPaginate: false);

        return view('admin.product.edit', compact('product', 'kinds', 'colors', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $success = app()->make(UpdateProductAction::class)->handle($request->validated(), $product);

        if (!$success) {
            return back()->with('error', 'Thêm mới sản phẩm thất bại.');
        }

        return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        app()->make(DeleteProductAction::class)->handle($product);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Xóa sản phẩm thành công.'
            ]);
        }

        return to_route('admin.product.index')->with('success', 'Xóa sản phẩm thành công.');
    }
}
