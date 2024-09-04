<?php

namespace App\Actions\Client\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterAction
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
        return User::create([
            'fullname' => $data['fullname'],
            'role' => Role::USER,
            'email' => $data['email'],
            'password' => ($data['password'] ?? null) ? Hash::make($data['password']) : null,
            'provider' => $data['provider'] ?? null,
            'social_id' => $data['social_id'] ?? null,
        ]);
    }
}