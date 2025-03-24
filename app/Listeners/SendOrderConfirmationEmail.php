<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Mail\OrderConfirmationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        Mail::to($event->order->user->email)
            ->send(new OrderConfirmationEmail($event->order));
    }
}
