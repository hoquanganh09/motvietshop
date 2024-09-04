<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Color\CreateColorAction;
use App\Actions\Admin\Color\DeleteColorAction;
use App\Actions\Admin\Color\GetListColorAction;
use App\Actions\Admin\Color\UpdateColorAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Color\CreateColorRequest;
use App\Http\Requests\Admin\Color\UpdateColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = app()->make(GetListColorAction::class)->handle();

        if (request()->ajax()) {
            return response()->view('admin.color.table_list', compact('colors'));
        }

        return view('admin.color.index', compact('colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateColorRequest $request)
    {
        $validated = $request->validated();

        app()->make(CreateColorAction::class)->handle($validated);

        return response()->json([
            'message' => 'Thêm mới màu sắc thành công.',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return response()->view('admin.color.modals.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color)
    {
        $validated = $request->validated();

        app()->make(UpdateColorAction::class)->handle($validated, $color);

        return response()->json([
            'message' => 'Cập nhật màu sắc thành công.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        app()->make(DeleteColorAction::class)->handle($color);

        return response()->json([
            'message' => 'Xóa màu sắc thành công.',
        ]);
    }
}
