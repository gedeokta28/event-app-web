<?php

namespace App\Jobs;

use App\Models\Broadcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class SendBroadcastNotificationFCM implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $topic, protected Broadcast $broadcast)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $messaging = app('firebase.messaging');

        $message = CloudMessage::withTarget('topic', $this->topic)
            ->withData([
                'action' => 'NEW_BROADCAST'
            ])
            ->withNotification(
                Notification::create('New Activity', $this->broadcast->description, asset('/app/' . $this->broadcast->image_path))
            )
            ->withDefaultSounds();

        $messaging->send($message);
    }
}
