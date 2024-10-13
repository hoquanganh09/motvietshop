<?php

namespace App\Actions\Admin\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class GetListEmployeeAction
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
    public function handle(bool $hasPaginate = true)
    {
        $search = request()->input('search', '');
        $role = request()->input('role', '');
        $active = request()->input('is_active', '');

        $query = User::search($search)
            ->with('getRole')
            ->when($role, function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->when($active != '', function ($query) use ($active) {
                $query->where('is_active', $active);
            })
            ->where('role', '!=', Role::USER)
            ->where('is_admin', false);

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}