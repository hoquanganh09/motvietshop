<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Category\GetListCategoryAction;
use App\Actions\Admin\Kind\CreateKindAction;
use App\Actions\Admin\Kind\DeleteKindAction;
use App\Actions\Admin\Kind\GetListKindAction;
use App\Actions\Admin\Kind\UpdateKindAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Kind\CreateKindRequest;
use App\Http\Requests\Admin\Kind\UpdateKindRequest;
use App\Models\Kind;

class KindController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kinds = app()->make(GetListKindAction::class)->handle();

        if (request()->ajax()) {
            return response()->view('admin.kind.table_list', compact('kinds'));
        }

        $categories = app()->make(GetListCategoryAction::class)->handle(hasPaginate: false);

        return view('admin.kind.index', compact('kinds', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateKindRequest $request)
    {
        $validated = $request->validated();

        app()->make(CreateKindAction::class)->handle($validated);

        return response()->json([
            'message' => 'Thêm mới thể loại thành công.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kind $kind)
    {
        $categories = app()->make(GetListCategoryAction::class)->handle(hasPaginate: false);

        return response()->view('admin.kind.modals.edit', compact('kind', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKindRequest $request, Kind $kind)
    {
        $validated = $request->validated();

        app()->make(UpdateKindAction::class)->handle($validated, $kind);

        return response()->json([
            'message' => 'Cập nhật thể loại thành công.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kind $kind)
    {
        app()->make(DeleteKindAction::class)->handle($kind);

        return response()->json([
            'message' => 'Xóa thể loại thành công.',
        ]);
    }
}
