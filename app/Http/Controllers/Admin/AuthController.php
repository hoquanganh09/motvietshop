<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Auth\LoginAction;
use App\Actions\Admin\Auth\LogoutAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function handleLogin(LoginRequest $request)
    {
        if (app()->make(LoginAction::class)->handle($request)) {
            return to_route('admin.home.dashboard');
        }

        return back()->with('error', 'Tài khoản hoặc mật khẩu không đúng');
    }

    public function handleLogout()
    {
        if (app()->make(LogoutAction::class)->handle()) {
            return to_route('admin.auth.login');
        }

        return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau');
    }
}
