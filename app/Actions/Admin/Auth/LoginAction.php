<?php

namespace App\Actions\Admin\Auth;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAction
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
    public function handle(Request $request)
    {
        $validated = $request->only(['email', 'password']);
        $remember = $request->boolean('remember');

        if (Auth::guard('admin')->attempt($validated, $remember) && Auth::guard('admin')->user()->role !== Role::USER && Auth::guard('admin')->user()->isActive()) {
            return true;
        }
        Auth::guard('admin')->logout();
        return false;
    }
}
