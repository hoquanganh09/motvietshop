<?php

namespace App\Actions\Admin\Banner;

use App\Models\Banner;

class DeleteBannerAction
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the action.
     */
    public function handle(Banner $banner): bool
    {
        Banner::deleteFile($banner->image);

        return $banner->delete();
    }
}