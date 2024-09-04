<?php

namespace App\Actions\Admin\Role;

use App\Models\Role;
use Illuminate\Http\Request;

class GetListRoleAction
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
    public function handle()
    {
        return Role::query()->with('users')->orderBy('level')->get();
    }
}