<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Role\GetListRoleAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = app()->make(GetListRoleAction::class)->handle();

        return view('admin.roles.index', compact('roles'));
    }
}
