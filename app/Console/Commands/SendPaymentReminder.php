<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Enums\PaymentMethod;
use App\Mail\PaymentReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendPaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-payment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for pending online orders that have not been paid in the last 2 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Finding unpaid online orders...');

        // Find orders older than 2 hours but less than 24 hours, not paid, online payment
        $orders = Order::query()
            ->where('payment_method', PaymentMethod::Online->value)
            ->where('is_paid', false)
            ->where('created_at', '<=', Carbon::now()->subHours(2))
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->get();
            
        $count = 0;

        foreach ($orders as $order) {
            $email = optional($order->shippingAddress)->email;
            
            if ($email) {
                // Ignore if we already sent a reminder (we could add a column to track this later)
                Mail::to($email)->send(new PaymentReminder($order));
                $this->line("Sent reminder to: $email for Order " . $order->code);
                $count++;
            }
        }

        $this->info("Completed. Sent $count reminders.");
    }
}
