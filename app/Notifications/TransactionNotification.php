<?php

namespace App\Notifications;

use App\Helpers\OrderStatus;
use App\Models\SalesOrder;
use App\Notifications\Channel\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class TransactionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            DatabaseChannel::class,
            FcmChannel::class,
            'mail'
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting("Halo, " . $this->salesOrder?->customer->customerName ?? 'Kak')
            ->subject(sprintf("Status Pesanan #" . $this->salesOrder->salesorderno))
            ->line(OrderStatus::getOrderNotifMessage($this->salesOrder->status))
            ->salutation(" ");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->salesOrder->salesorderno,
            'order_status' => $this->salesOrder->status,
            'message' => OrderStatus::getOrderNotifMessage($this->salesOrder->status)
        ];
    }

    /**
     * Get the category representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toCategory($notifiable)
    {
        return 'notification.transaction';
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData([
                'order_id'        => (string) $this->salesOrder->salesorderno,
                'order_status'    => (string) $this->salesOrder->status,
                'message'         => OrderStatus::getOrderNotifMessage($this->salesOrder->status),
                'action'          => OrderStatus::getOrderActionStatus($this->salesOrder->status),
            ])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle(sprintf("Order #" . $this->salesOrder->salesorderno))
                ->setBody(OrderStatus::getOrderNotifMessage($this->salesOrder->status)))
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A')
                        ->setSound('default'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios'))
                    ->setPayload([
                        'aps'   => [
                            'sound' => 'default',
                            'content-available' => 1
                        ]
                    ])

            );
    }
}
