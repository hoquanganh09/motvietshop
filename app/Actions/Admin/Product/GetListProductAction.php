<?php

namespace App\Actions\Admin\Product;

use App\Models\Product;
use Illuminate\Http\Request;

class GetListProductAction
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
    public function handle(array $filters = [], array $relations = ['images', 'kind', 'kind.category', 'reviews'], bool $hasPaginate = true)
    {
        $query = Product::query();

        if (isset($filters['search']) && $filters['search']) {
            $query = Product::search($filters['search']);
        }

        if (isset($filters['is_active']) && $filters['is_active'] != '') {
            $query = $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['kind_id']) && $filters['kind_id'] != '') {
            $query = $query->where('kind_id', $filters['kind_id']);
        }

        foreach ($relations as $relation) {
            $query = $query->with($relation);
        }

        $query = $query->orderBy('name');

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}