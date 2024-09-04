<?php

namespace App\Actions\Admin\Kind;

use App\Models\Kind;
use Illuminate\Http\Request;

class UpdateKindAction
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
    public function handle(array $data, Kind $kind)
    {
        $kind->update([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
        ]);
    }
}