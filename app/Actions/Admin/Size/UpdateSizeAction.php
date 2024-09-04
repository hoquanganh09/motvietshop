<?php

namespace App\Actions\Admin\Size;

use App\Models\Size;

class UpdateSizeAction
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
    public function handle(array $data, Size $size)
    {
        $size->update([
            'name' => $data['name'],
            'number' => $data['number'],
        ]);
    }
}