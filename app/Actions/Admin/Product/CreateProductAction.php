<?php

namespace App\Actions\Admin\Product;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateProductAction
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
    public function handle(array $data)
    {
        $thumbnail = null;
        $images = [];

        DB::beginTransaction();
        try {
            $product = Product::create([
                'name' => $data['name'],
                'price' => $data['price'],
                'old_price' => $data['old_price'] ?? null,
                'description' => $data['description'],
                'washing_instructions' => $data['washing_instructions'],
                'kind_id' => $data['kind_id'],
                'is_active' => $data['is_active'] ?? false,
                'stock' => $data['stock'] ?? null,
            ]);

            // thumbnail
            if (isset($data['thumbnail'])) {
                $thumbnail = $this->uploadProductImage($data['thumbnail'], $product->id, true);
            }

            // images
            if (isset($data['images']) && count($data['images']) > 0) {
                foreach ($data['images'] as $image) {
                    $imagse[] = $this->uploadProductImage($image, $product->id, false);
                }
            }

            // color
            if (isset($data['colors']) && count($data['colors']) > 0) {
                $productColors = [];
                foreach ($data['colors'] as $color) {
                    $productColors[] = [
                        'product_id' => $product->id,
                        'color_id' => $color,
                    ];
                }
                ProductColor::insert($productColors);
            }

            // sizes
            if (isset($data['sizes']) && count($data['sizes']) > 0) {
                $productSizes = [];
                foreach ($data['sizes'] as $size) {
                    $productSizes[] = [
                        'product_id' => $product->id,
                        'size_id' => $size,
                    ];
                }
                ProductSize::insert($productSizes);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            $thumbnail && ProductImage::deleteFile($thumbnail);

            foreach ($images as $image) {
                $image && ProductImage::deleteFile($image);
            }

            return false;
        }
    }

    private function uploadProductImage(UploadedFile $file, string|int $productId, bool $isOnTop = false): string
    {
        $thumbnail = ProductImage::uploadFile($file);
        ProductImage::insert([
            [
                'product_id' => $productId,
                'image' => $thumbnail,
                'is_on_top' => $isOnTop,
            ],
        ]);

        return $thumbnail;
    }
}
