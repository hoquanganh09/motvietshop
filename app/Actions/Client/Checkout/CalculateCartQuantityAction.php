<?php

namespace App\Actions\Client\Checkout;

use App\Models\Product;

class CalculateCartQuantityAction
{
    public function handle(array $cart)
    {
        $errorQuantity = false;
        $products = collect($cart);
        
        if ($products->isEmpty()) {
            return [
                'cart' => [],
                'products' => $products,
                'errorQuantity' => false,
            ];
        }

        $productIds = array_values($products->map(fn($item) => $item['id'])->toArray());
        $productsGroup = $products->groupBy('id');
        $orderProductQuantity = [];
        $productAppendQuantity = [];

        foreach ($productsGroup as $key => $item) {
            $orderProductQuantity[$key] = [
                'id' => $key,
                'quantity' => $item->sum('quantity'),
            ];
        }

        $productAvaiables = Product::query()
            ->whereIn('id', $productIds)
            ->get();

        foreach ($productAvaiables as $item) {
            $productAppendQuantity[$item->id] = 0;

            if ($item->stock < $orderProductQuantity[$item->id]['quantity']) {
                $errorQuantity = true;
                $productAppendQuantity[$item->id] = $orderProductQuantity[$item->id]['quantity'] - $item->stock;
            }
        }

        $cart = array_reverse($cart);
        $cart = array_map(function ($item) use (&$productAppendQuantity) {
            $item['disabled'] = false;
            if ($productAppendQuantity[$item['id']] > 0) {
                $item['disabled'] = true;
                $productAppendQuantity[$item['id']] -= $item['quantity'];
            }
            return $item;
        }, $cart);

        $cart = array_reverse($cart);

        return [
            'cart' => $cart,
            'products' => $products,
            'errorQuantity' => $errorQuantity,
        ];
    }
}
