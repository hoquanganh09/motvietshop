<?php

namespace App\Actions\Client\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
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
    public function handle(User $user, string $password)
    {
        $user->password = Hash::make($password);
        return $user->save();
    }
}