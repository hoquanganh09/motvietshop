<?php

namespace App\Actions\Admin\Color;

use App\Models\Color;
use Illuminate\Http\Request;

class UpdateColorAction
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
    public function handle(array $data, Color $color): bool
    {
        return $color->update([
            'name' => $data['name'],
            'label' => $data['label'],
        ]);
    }
}