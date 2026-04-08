<?php

namespace App\Actions\Client\Auth;

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
    public function handle(array $data)
    {
        $attempt = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
        $remember = $data['remember'] ?? false;

        if (Auth::attempt($attempt, $remember) && Auth::user()->isActive()) {
            request()->session()->regenerate();
            return true;
        }

        Auth::logout();
        return false;
    }
}