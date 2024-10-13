<?php

namespace App\Actions\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;

class GetListCategoryAction
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
    public function handle(bool $hasPaginate = true, array $relations = ['kinds'])
    {
        $query = Category::query();

        foreach ($relations as $relation) {
            $query = $query->with($relation);
        }

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}