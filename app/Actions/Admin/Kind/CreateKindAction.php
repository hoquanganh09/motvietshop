<?php

namespace App\Actions\Admin\Kind;

use App\Models\Kind;
use Illuminate\Http\Request;

class CreateKindAction
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
        Kind::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
        ]);
    }
}