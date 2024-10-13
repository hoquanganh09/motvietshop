<?php

namespace App\Actions\Admin\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class GetListCustomerAction
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
        $active = request()->input('is_active', '');

        $query = User::search($search)
            ->when($active != '', function ($query) use ($active) {
                $query->where('is_active', $active);
            })
            ->where('role', Role::USER)
            ->where('is_admin', false);

        return $hasPaginate ? $query->paginate() : $query->get();
    }
}