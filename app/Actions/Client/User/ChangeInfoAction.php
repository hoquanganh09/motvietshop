<?php

namespace App\Actions\Client\User;

use App\Models\User;
use Illuminate\Http\Request;

class ChangeInfoAction
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
    public function handle(User $user, string $fullname, ?string $date_of_birth)
    {
        $user->fullname = $fullname;
        $user->date_of_birth = $date_of_birth;
        
        return $user->save();
    }
}