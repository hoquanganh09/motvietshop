<?php

namespace App\Jobs;

use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailForgotPasswordJon implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $email)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::query()->where('email', $this->email)->first();
        
        if ($user && $user->isEmailVerified()) {
            $password = \Illuminate\Support\Str::random(8);
            // Fix #1: Phải dùng Hash::make() trước khi lưu, trước đây ghi plaintext vào DB
            $user->password = \Illuminate\Support\Facades\Hash::make($password);
            $user->save();

            Mail::to($this->email)->send(new ForgotPassword($user->fullname, $password));
        }
    }
}
