<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegisteredEvent  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        Mail::to($event->user->email)
            ->send(new WelcomeEmail($event->user));
    }
}
