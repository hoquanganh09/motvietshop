<?php

namespace App\Actions\Client\User;

use App\Models\User;
use Illuminate\Http\Request;

class ChangeContactAction
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
    public function handle(User $user, string $email, ?string $phone_number)
    {
        $oldEmail = $user->email;

        $user->email = $email;
        $user->phone_number = $phone_number;

        if ($oldEmail !== $email) {
            $user->email_verified_at = null;
        }

        return $user->save();
    }
}