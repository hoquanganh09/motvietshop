<?php

namespace App\Jobs;

use App\Mail\OrderConfirmed;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailOrderConfirmedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $userId, protected Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);

        if ($user->has_send_email_order && $user->isEmailVerified()) {
            Mail::to($user->email)->send(new OrderConfirmed($user->fullname, $this->order->code));
        }
    }
}
