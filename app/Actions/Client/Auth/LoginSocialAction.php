<?php

namespace App\Actions\Client\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginSocialAction
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly RegisterAction $registerAction
    ) {
        //
    }

    /**
     * Execute the action.
     */
    public function handle()
    {
        $ggUser = Socialite::driver('google')->user();

        $user = User::query()
            ->where('email', $ggUser->getEmail())
            ->first();

        if ($user) {
            $user->provider = 'google';
            $user->social_id = $ggUser->getId();
            $user->is_active = 1;

            $user->save();
        } else {
            $user = $this->registerAction->handle([
                'fullname' => $ggUser->getName(),
                'email' => $ggUser->getEmail(),
                'provider' => 'google',
                'social_id' => $ggUser->getId(),
            ]);
        }

        return $user;
    }
}
