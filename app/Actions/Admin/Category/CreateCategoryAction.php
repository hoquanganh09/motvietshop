<?php

namespace App\Actions\Admin\Category;

use App\Models\Category;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;

class CreateCategoryAction
{
    use UploadFileTrait;
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
    public function handle(array $data)
    {
        if (isset($data['avatar'])) {
            $filename = Category::uploadFile($data['avatar']);
        }
        
        Category::create([
            'name' => $data['name'],
            'image' => $filename ?? null,
        ]);
    }
}