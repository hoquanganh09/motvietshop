<?php

namespace App\Actions\Admin\Color;

use App\Models\Color;
use Illuminate\Http\Request;

class GetListColorAction
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
        $query = Color::query();

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}