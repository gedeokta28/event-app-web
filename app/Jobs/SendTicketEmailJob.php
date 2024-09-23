<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\EventRegistration;
use App\Models\Event;

class SendTicketEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $registration;
    public $formattedDateRange;
    public $event;
    public $ticketPath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EventRegistration $registration, $formattedDateRange, Event $event, $ticketPath)
    {
        $this->registration = $registration;
        $this->event = $event;
        $this->formattedDateRange = $formattedDateRange;
        $this->ticketPath = $ticketPath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->registration->pax_email;

        Mail::send('email.ticket', ['registration' => $this->registration, 'formattedDateRange' => $this->formattedDateRange, 'event' => $this->event], function ($message) use ($email) {
            $message->to($email)
                ->subject('Your Event Ticket')
                ->attach($this->ticketPath);
        });
    }
}
