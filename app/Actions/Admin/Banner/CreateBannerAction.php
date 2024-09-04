<?php

namespace App\Actions\Admin\Banner;

use App\Models\Banner;
use App\Models\Category;
use App\Traits\UploadFileTrait;
use Illuminate\Http\Request;

class CreateBannerAction
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
        if (isset($data['image'])) {
            $filename = Banner::uploadFile($data['image']);
        }
        
        Banner::create([
            'title' => $data['title'] ?? null,
            'content' => $data['content'],
            'image' => $filename ?? null,
        ]);
    }
}