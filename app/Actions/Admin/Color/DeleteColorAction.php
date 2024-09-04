<?php

namespace App\Actions\Admin\Color;

use App\Models\Color;
use Illuminate\Http\Request;

class DeleteColorAction
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
    public function handle(Color $color)
    {
        return $color->delete();
    }
}