<?php

namespace App\Actions\Admin\Size;

use App\Models\Size;

class CreateSizeAction
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
    public function handle(array $data)
    {        
        Size::create([
            'name' => $data['name'],
            'number' => $data['number'],
        ]);
    }
}