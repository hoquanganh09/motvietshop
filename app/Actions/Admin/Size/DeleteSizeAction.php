<?php

namespace App\Actions\Admin\Size;

use App\Models\Size;

class DeleteSizeAction
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
    public function handle(Size $size)
    {
        return $size->delete();
    }
}