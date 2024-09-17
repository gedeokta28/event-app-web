<?php

namespace App\Observers;

use App\Jobs\SendBroadcastNotificationFCM;
use App\Models\Broadcast;
use Illuminate\Support\Facades\Notification;
use Kreait\Firebase\Messaging\CloudMessage;

class BroadcastObserver
{

    /**
     * Handle the Broadcast "created" event.
     *
     * @param  \App\Models\Broadcast  $broadcast
     * @return void
     */
    public function created(Broadcast $broadcast)
    {
        SendBroadcastNotificationFCM::dispatch('activity.notification', $broadcast);
    }

    /**
     * Handle the Broadcast "updated" event.
     *
     * @param  \App\Models\Broadcast  $broadcast
     * @return void
     */
    public function updated(Broadcast $broadcast)
    {
        SendBroadcastNotificationFCM::dispatch('activity.notification', $broadcast);
    }

    /**
     * Handle the Broadcast "deleted" event.
     *
     * @param  \App\Models\Broadcast  $broadcast
     * @return void
     */
    public function deleted(Broadcast $broadcast)
    {
        //
    }

    /**
     * Handle the Broadcast "restored" event.
     *
     * @param  \App\Models\Broadcast  $broadcast
     * @return void
     */
    public function restored(Broadcast $broadcast)
    {
        //
    }

    /**
     * Handle the Broadcast "force deleted" event.
     *
     * @param  \App\Models\Broadcast  $broadcast
     * @return void
     */
    public function forceDeleted(Broadcast $broadcast)
    {
        //
    }
}
