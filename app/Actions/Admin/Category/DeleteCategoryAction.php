<?php

namespace App\Actions\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;

class DeleteCategoryAction
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
    public function handle(Category $category): bool
    {
        Category::deleteFile($category->image);

        return $category->delete();
    }
}