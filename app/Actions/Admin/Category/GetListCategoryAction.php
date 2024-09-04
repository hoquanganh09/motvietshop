<?php

namespace App\Actions\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;

class GetListCategoryAction
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
        $query = Category::query();

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}