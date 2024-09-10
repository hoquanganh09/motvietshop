<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\User\ChangeContactAction;
use App\Actions\Client\User\ChangeInfoAction;
use App\Actions\Client\User\ChangePasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\User\ChangeContactRequest;
use App\Http\Requests\Client\User\ChangeInfoRequest;
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

    public function changeContact(ChangeContactRequest $request)
    {
        app()->make(ChangeContactAction::class)->handle(
            user: auth()->user(),
            email: $request->input('email'),
            phone_number: $request->input('phone_number'),
        );

        return redirect()->back()->with('success', 'Đổi thông tin liên hệ thành công');
    }

    public function changeInfo(ChangeInfoRequest $request)
    {
        app()->make(ChangeInfoAction::class)->handle(
            user: auth()->user(),
            fullname: $request->input('fullname'),
            date_of_birth: $request->input('date_of_birth'),
        );

        return redirect()->back()->with('success', 'Đổi thông tin cá nhân thành công');
    }
}
