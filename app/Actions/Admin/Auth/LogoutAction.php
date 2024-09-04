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

        return true;
    }
}