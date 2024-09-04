<?php

namespace App\Actions\Admin\Color;

use App\Models\Color;
use Illuminate\Http\Request;

class CreateColorAction
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
        Color::create([
            'name' => $data['name'],
            'label' => $data['label'],
        ]);
    }
}