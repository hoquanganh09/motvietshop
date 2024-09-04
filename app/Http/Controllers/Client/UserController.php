<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\User\ChangePasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\User\ChangePassword;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function changePassword(ChangePassword $request)
    {
        app()->make(ChangePasswordAction::class)->handle(
            user: auth()->user(),
            password: $request->input('new_password')
        );

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
    }
}
