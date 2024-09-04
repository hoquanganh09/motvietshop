<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\User\GetListEmployeeAction;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = app()->make(GetListEmployeeAction::class)->handle();

        if (request()->ajax()) {
            return response()->view('admin.users.table_list_user', compact('users'));
        }

        $roles = Role::query()->orderBy('level')->pluck('name', 'id');

        $filters = [
            [
                'name' => 'role',
                'label' => 'Vai trò',
                'data' => $roles->toArray(),
            ],
            [
                'name' => 'is_active',
                'label' => 'Trạng thái',
                'data' => [
                    User::INACTIVE => 'Không hoạt động',
                    User::ACTIVE => 'Đang hoạt động',
                ],
            ]
        ];

        return view('admin.users.index', compact('users', 'filters'));
    }

    public function create() {}
}
