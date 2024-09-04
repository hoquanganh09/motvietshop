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
    public function handle(string $search = null, array $relations = ['images', 'kind', 'kind.category'], bool $hasPaginate = true)
    {
        $query = Product::query();

        if ($search) {
            $query = Product::search($search);
        }

        foreach ($relations as $relation) {
            $query = $query->with($relation);
        }

        $query = $query->orderBy('name');

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}