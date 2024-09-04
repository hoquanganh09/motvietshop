<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Size\CreateSizeAction;
use App\Actions\Admin\Size\DeleteSizeAction;
use App\Actions\Admin\Size\GetListSizeAction;
use App\Actions\Admin\Size\UpdateSizeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Size\CreateSizeRequest;
use App\Http\Requests\Admin\Size\UpdateSizeRequest;
use App\Models\Size;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = app()->make(GetListSizeAction::class)->handle();

        if (request()->ajax()) {
            return response()->view('admin.size.table_list', compact('sizes'));
        }

        return view('admin.size.index', compact('sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSizeRequest $request)
    {
        $validated = $request->validated();

        app()->make(CreateSizeAction::class)->handle($validated);

        return response()->json([
            'message' => 'Thêm mới size thành công.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return response()->view('admin.size.modals.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSizeRequest $request, Size $size)
    {
        $validated = $request->validated();

        app()->make(UpdateSizeAction::class)->handle($validated, $size);

        return response()->json([
            'message' => 'Cập nhật size thành công.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        app()->make(DeleteSizeAction::class)->handle($size);

        return response()->json([
            'message' => 'Xóa size thành công.',
        ]);
    }
}
