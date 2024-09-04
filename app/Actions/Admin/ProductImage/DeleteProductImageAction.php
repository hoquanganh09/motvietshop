<?php

namespace App\Actions\Admin\ProductImage;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class DeleteProductImageAction
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
    public function handle(ProductImage $productImage)
    {
        $productImage->deleteFile($productImage->image);
        
        return $productImage->delete();
    }
}