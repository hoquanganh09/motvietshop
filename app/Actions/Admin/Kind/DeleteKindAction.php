<?php

namespace App\Actions\Admin\Kind;

use App\Models\Kind;
use Illuminate\Http\Request;

class DeleteKindAction
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
    public function handle(Kind $kind)
    {
        return $kind->delete();
    }
}