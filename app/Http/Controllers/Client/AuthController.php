<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\Auth\LoginAction;
use App\Actions\Client\Auth\LoginSocialAction;
use App\Actions\Client\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ForgotPasswordRequest;
use App\Http\Requests\Client\Auth\LoginRequest;
use App\Http\Requests\Client\Auth\RegisterRequest;
use App\Jobs\Client\SendMailVerifyEmailJob;
use App\Jobs\SendMailForgotPasswordJon;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('client.auth.login');
    }

    public function register()
    {
        return view('client.auth.register');
    }

    public function handleLogin(LoginRequest $request)
    {
        if (app(LoginAction::class)->handle($request->validated())) {
            return to_route('client.home.index');
        }

        return back()->with('error', 'Tài khoản hoặc mật khẩu không đúng');
    }

    public function handleRegister(RegisterRequest $request)
    {
        $user = app()->make(RegisterAction::class)->handle($request->validated());

        if (!$user) {
            return back()->with('error', 'Có lỗi xảy ra. Vui có thử lại sau');
        }

        Auth::login($user);

        return to_route('client.home.index');
    }

    public function redirectGoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogleLogin()
    {
        $user = app()->make(LoginSocialAction::class)->handle();

        Auth::login($user, true);

        return to_route('client.home.index');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->back();
    }

    public function verifyEmail()
    {
        dispatch(new SendMailVerifyEmailJob(auth()->user()));

        return redirect()->back()->with('success_verify_email', 'Vui lòng kiểm tra email để xác thực tài khoản');
    }

    public function handleVerifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return to_route('client.home.profile');
    }

    public function forgotPassword()
    {
        return view('client.auth.forgot_password');
    }

    public function handleForgotPassword(ForgotPasswordRequest $request)
    {
        SendMailForgotPasswordJon::dispatch($request->email);

        return redirect()->back()->with('success', 'Vui lòng kiểm tra email để đặt lại mật khẩu');
    }
}
