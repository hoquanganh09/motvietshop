<?php

namespace App\Actions\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;

class UpdateCategoryAction
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
    public function handle(array $data, Category $category)
    {
        if (isset($data['avatar'])) {
            Category::deleteFile($category->image);
            $filename = Category::uploadFile($data['avatar']);
        }
        
        $category->update([
            'name' => $data['name'],
            'image' => $filename ?? $category->image,
        ]);
    }
}