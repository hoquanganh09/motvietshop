<?php

namespace App\Actions\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutAction
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
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return true;
    }
}