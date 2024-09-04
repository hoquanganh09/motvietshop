<?php

namespace App\Actions\Admin\Product;

use App\Actions\Admin\ProductImage\DeleteProductImageAction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteProductAction
{
    /**
     * Constructor
     */
    public function __construct(private DeleteProductImageAction $deleteProductImageAction)
    {
        //
    }

    /**
     * Execute the action.
     */
    public function handle(Product $product)
    {
        DB::beginTransaction();
        try {
            foreach ($product->images as $image) {
                $this->deleteProductImageAction->handle($image);
            }

            $product->sizes()->delete();
            $product->colors()->delete();

            DB::commit();

            return $product->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            DB::rollBack();
            return false;
        }
    }
}
