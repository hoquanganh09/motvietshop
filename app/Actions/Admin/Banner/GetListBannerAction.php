<?php

namespace App\Actions\Admin\Banner;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;

class GetListBannerAction
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
    public function handle(bool $hasPaginate = true)
    {
        $query = Banner::query();

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}