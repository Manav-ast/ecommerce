<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Mail\OrderConfirmationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class SendOrderConfirmationEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCreatedEvent  $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event)
    {
        try {
            // Send email to customer
            Mail::to($event->order->user->email)
                ->send(new OrderConfirmationEmail($event->order));

            // Send email to admin
            $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
            Mail::to($adminEmail)
                ->send(new OrderConfirmationEmail($event->order));

            Log::info('Order confirmation emails sent successfully', [
                'order_id' => $event->order->id,
                'customer_email' => $event->order->user->email,
                'admin_email' => $adminEmail
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation emails', [
                'order_id' => $event->order->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
