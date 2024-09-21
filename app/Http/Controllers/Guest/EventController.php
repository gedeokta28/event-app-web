<?php

namespace App\Http\Controllers\Guest;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;

class EventController extends Controller
{
    public function index()
    {
        $event = Event::where('event_active', 1)->first();
        $eventList = Event::where('event_active', 1)->get();
        // Format dates
        if ($event) {
            $initStartDate = \Carbon\Carbon::parse($event->event_start_date);
            $initEndDate = \Carbon\Carbon::parse($event->event_end_date);

            $startDate = $initStartDate->format('j');
            $endDate = $initEndDate->format('j');
            $month = \Carbon\Carbon::parse($event->event_start_date)->format('F');
            $year = \Carbon\Carbon::parse($event->event_start_date)->format('Y');

            $startDay = $initStartDate->format('l'); // Full day name (e.g., Monday)
            $endDay = $initEndDate->format('l');     // Full day name (e.g., Wednesday)
            // Combine into desired format
            $formattedDateRange = "{$startDate}-{$endDate} {$month} {$year}";
            $formattedDayRange = "{$startDay} to {$endDay}";
            //
            $eventTime = DateTime::createFromFormat('H:i', $event->event_time);
        } else {
            $formattedDateRange = '';
        }
        foreach ($eventList as $event) {
            $initStartDate = \Carbon\Carbon::parse($event->event_start_date);
            $initEndDate = \Carbon\Carbon::parse($event->event_end_date);

            $startDate = $initStartDate->format('j');
            $endDate = $initEndDate->format('j');
            $month = \Carbon\Carbon::parse($event->event_start_date)->format('F');
            $year = \Carbon\Carbon::parse($event->event_start_date)->format('Y');

            $startDay = $initStartDate->format('l');
            $endDay = $initEndDate->format('l');

            // Format tanggal untuk setiap event
            $event->formattedDateRange = "{$startDate}-{$endDate} {$month} {$year}";
            $event->formattedDayRange = "{$startDay} to {$endDay}";

            // Format waktu event
            if ($event->event_time) {
                $event->eventTime = DateTime::createFromFormat('H:i', $event->event_time);
            }
        }

        return view('guests.index', compact('eventList', 'event', 'formattedDateRange', 'formattedDayRange', 'eventTime'));
    }

    public function show($slug)
    {
        // Temukan event berdasarkan ID
        // $event = Event::findOrFail($id);
        $event = Event::where('slug', $slug)->firstOrFail();

        // Format tanggal dan waktu
        $initStartDate = \Carbon\Carbon::parse($event->event_start_date);
        $initEndDate = \Carbon\Carbon::parse($event->event_end_date);

        $startDate = $initStartDate->format('j');
        $endDate = $initEndDate->format('j');
        $month = \Carbon\Carbon::parse($event->event_start_date)->format('F');
        $year = \Carbon\Carbon::parse($event->event_start_date)->format('Y');

        $startDay = $initStartDate->format('l');
        $endDay = $initEndDate->format('l');

        // Format tanggal
        $formattedDateRange = "{$startDate}-{$endDate} {$month} {$year}";
        $formattedDayRange = "{$startDay} to {$endDay}";

        // Format waktu
        if ($event->event_time) {
            $eventTime = DateTime::createFromFormat('H:i', $event->event_time);
        } else {
            $eventTime = null;
        }

        // Kirim data ke view
        return view('guests.event-detail', compact('event', 'formattedDateRange', 'formattedDayRange', 'eventTime'));
    }
}
