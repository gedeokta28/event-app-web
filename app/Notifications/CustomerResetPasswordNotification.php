<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerResetPasswordNotification extends Notification
{
    use Queueable;


    protected $password;
    protected $customername;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($password, $customername)
    {
        $this->password = $password;
        $this->customername = $customername;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $email =  (new MailMessage)
            ->subject('Reset password successfully')
            ->greeting('Hello, ' . $this->customername)
            ->line('Your password has been reseted. please use the password below to login the app and don\'t forget to change it afterwards')
            ->salutation('PASS Admin');

        return $email->view('emails.reset_password', array_merge([
            'password'  => $this->password
        ], $email->toArray()));
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
            //
        ];
    }
}
