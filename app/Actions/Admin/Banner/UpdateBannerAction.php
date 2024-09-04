<?php

namespace App\Actions\Admin\Banner;

use App\Models\Banner;
use Illuminate\Http\Request;

class UpdateBannerAction
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
    public function handle(array $data, Banner $banner)
    {
        $updateData = [
            'title' => $data['title'] ?? null,
            'content' => $data['content'],
        ];
        
        if (isset($data['image'])) {
            Banner::deleteFile($banner->image);
            $filename = Banner::uploadFile($data['image']);

            $updateData['image'] = $filename;
        }
        
        $banner->update($updateData);
    }
}