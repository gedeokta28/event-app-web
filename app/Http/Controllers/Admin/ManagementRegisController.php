<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\RegisDataTable;
use App\DataTables\RegisDataTableAdmin;
use App\Jobs\SendTicketEmailJob;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Log;

class ManagementRegisController extends Controller
{


    public function registration()
    {
        $events = Event::orderBy('event_id', 'desc')->get();
        return view('registrations.select-event', compact('events'));
    }

    public function index(RegisDataTable $regisDataTable)
    {
        return $regisDataTable->render('registrations.index');
    }

    public function indexAdmin(RegisDataTableAdmin $regisDataTable, $event_id)
    {
        $event = Event::where('slug', $event_id)->firstOrFail();
        return $regisDataTable->setEventId($event_id)->render('registrations.registration_summary', compact('event'));
    }

    public function resendTicket($regId)
    {
        try {

            // Find the existing registration
            $registration = EventRegistration::where('reg_id', $regId)
                ->first();

            if (!$registration) {
                return redirect()->back()->withErrors('No successful registration found for the given details.');
            }

            // Find the event
            $event = Event::find($registration->event_id);
            if (!$event) {
                return redirect()->back()->withErrors('Event not found.');
            }

            $filepath = $registration->barcode_file;

            // Check if the ticket barcode exists
            if (!file_exists(public_path('app/' . $filepath))) {
                return redirect()->back()->withErrors('Ticket file not found. Please contact support.');
            }

            $ticketPath = public_path('app/' . $filepath);

            try {
                // Prepare event date for the ticket email
                $initStartDate = \Carbon\Carbon::parse($event->event_start_date);
                $initEndDate = \Carbon\Carbon::parse($event->event_end_date);

                $startDate = $initStartDate->format('j');
                $endDate = $initEndDate->format('j');
                $month = \Carbon\Carbon::parse($event->event_start_date)->format('F');
                $year = \Carbon\Carbon::parse($event->event_start_date)->format('Y');

                $formattedDateRange = "{$startDate}-{$endDate} {$month} {$year}";

                // Resend the email with the ticket
                SendTicketEmailJob::dispatch($registration, $formattedDateRange, $event, $ticketPath);
            } catch (\Exception $e) {
                Log::error('Error resending email: ' . $e->getMessage());
                return redirect()->back()->withErrors("We couldn't resend the email to the provided address. Please check if it's correct and active.");
            }

            // WhatsApp resend
            try {
                $sid = env('TWILIO_SID');
                $token = env('TWILIO_AUTH_TOKEN');
                $twilio = new \Twilio\Rest\Client($sid, $token);
                $phone = $registration->pax_phone;
                $twilio->messages->create(
                    "whatsapp:$phone", // To
                    [
                        "contentSid" => "HXbe2bc113a281074a09c0873ae0fae70e",
                        "from" => "whatsapp:+12163500105",
                        "contentVariables" => json_encode([
                            "1" => "Selamat datang di {$event->event_name}",
                            "2" => strtoupper($registration->pax_name),
                            "3" => $registration->pax_phone,
                            "4" => $registration->pax_email,
                            "5" => $filepath,
                        ]),
                    ]
                );
            } catch (\Exception $e) {
                Log::error('Error WhatsApp resend: ' . $e->getMessage());
                return redirect()->back()->with('success', "Ticket resend successful via email.<br>We encountered an issue with WhatsApp. Please check your email for the ticket.<br><a href='" . route('download.ticket', ['filename' => $registration->barcode_file]) . "'>Click here to download your ticket</a>");
            }

            return redirect()->back()->with('success', "Ticket resend successful via both email and WhatsApp.<br><a href='" . route('download.ticket', ['filename' => $registration->barcode_file]) . "'>Click here to download your ticket</a>");
        } catch (\Exception $e) {
            Log::error('Error resending ticket: ' . $e->getMessage());
            return redirect()->back()->withErrors('There was an error resending the ticket. Please try again later.');
        }
    }
}
