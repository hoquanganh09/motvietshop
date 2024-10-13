<?php

namespace App\Actions\Admin\Kind;

use App\Models\Kind;
use Illuminate\Http\Request;

class GetListKindAction
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
    public function handle(bool $hasPaginate = true, array $order = ['category_id', 'asc'] , array $relations = ['category', 'products'])
    {
        $query = Kind::query()
            ->orderBy($order[0], $order[1]);

        foreach ($relations as $relation) {
            $query = $query->with($relation);
        }

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}