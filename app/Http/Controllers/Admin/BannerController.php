<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Banner\CreateBannerAction;
use App\Actions\Admin\Banner\DeleteBannerAction;
use App\Actions\Admin\Banner\GetListBannerAction;
use App\Actions\Admin\Banner\UpdateBannerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\CreateBannerRequest;
use App\Http\Requests\Admin\Banner\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = app()->make(GetListBannerAction::class)->handle();

        if (request()->ajax()) {
            return response()->view('admin.banner.table_list', compact('banners'));
        }

        return view('admin.banner.index', compact('banners'));
    }

    public function store(CreateBannerRequest $request)
    {
        $validated = $request->validated();

        app()->make(CreateBannerAction::class)->handle($validated);

        return response()->json([
            'message' => 'Thêm mới banner thành công.',
        ]);
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $validated = $request->validated();

        app()->make(UpdateBannerAction::class)->handle($validated, $banner);

        return response()->json([
            'message' => 'Cập nhật banner thành công.',
        ]);
    }

    public function edit(Banner $banner)
    {
        return response()->view('admin.banner.modals.edit', compact('banner'));
    }

    public function destroy(Banner $banner)
    {
        app()->make(DeleteBannerAction::class)->handle($banner);

        return response()->json([
            'message' => 'Xóa banner thành công.',
        ]);
    }
}
