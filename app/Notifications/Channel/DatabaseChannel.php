<?php

namespace App\Notifications\Channel;

use Illuminate\Notifications\Channels\DatabaseChannel as BaseDatabaseChannel;
use Illuminate\Notifications\Notification;
use RuntimeException;

class DatabaseChannel extends BaseDatabaseChannel
{
    protected function buildPayload($notifiable, Notification $notification)
    {

        return [
            'id' => $notification->id,
            'type' => method_exists($notification, 'databaseType')
                ? $notification->databaseType($notifiable)
                : get_class($notification),
            'data' => $this->getData($notifiable, $notification),
            'read_at' => null,
            'category' => $this->getCategory($notifiable, $notification)
        ];
    }

    /**
     * Get the category for the notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function getCategory($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toCategory')) {
            return is_string($data = $notification->toCategory($notifiable))
                ? $data : null;
        }

        throw new RuntimeException('Notification is missing toCategory method.');
    }
}
