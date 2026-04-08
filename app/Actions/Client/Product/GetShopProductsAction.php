<?php

namespace App\Actions\Client\Product;

use App\Models\Product;

class GetShopProductsAction
{
    public function handle(array $filters, string $keyword = null, string $sort = 'name:asc', bool $isSale = false)
    {
        return Product::search($keyword)
            ->active()
            ->with([
                'images',
                'sizes',
                'sizes.size',
                'colors',
                'colors.color',
            ])
            ->whereIn('kind_id', $filters['kind'] ?? [])
            ->where(function ($query) use ($filters) {
                if (isset($filters['min_price']) && isset($filters['max_price'])) {
                    $query->where('price', '>=', $filters['min_price'])
                        ->where('price', '<=', $filters['max_price']);
                }
            })
            ->join('product_sizes as ps', 'products.id', '=', 'ps.product_id')
            ->whereIn('ps.size_id', $filters['size'] ?? [])
            ->join('product_colors as pc', 'products.id', '=', 'pc.product_id')
            ->whereIn('pc.color_id', $filters['color'] ?? [])
            ->when($isSale, fn($query) => $query->whereNotNull('old_price'))
            ->groupBy('products.id')
            ->select('products.*')
            ->orderBy('products.' . explode(':', $sort)[0], explode(':', $sort)[1])
            ->paginate(config('view.pagination_limit', 15));
    }
}
