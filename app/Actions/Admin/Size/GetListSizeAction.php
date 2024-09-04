<?php

namespace App\Actions\Admin\Size;

use App\Models\Size;
use Illuminate\Http\Request;

class GetListSizeAction
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
    public function handle(bool $hasPaginate = true)
    {
        $query = Size::query();

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}