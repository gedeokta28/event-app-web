<?php

namespace App\Listeners;

use App\Notifications\CustomerResetPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Hash;

class GenerateNewPasswordForCustomer
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->customer) {

            $newPassword = uniqid();

            // update password
            $event->customer->update(['password' => Hash::make($newPassword)]);

            // send notification via email
            $event->customer->notify(
                new CustomerResetPasswordNotification($newPassword, $event->customer->customername)
            );
        }
    }
}
