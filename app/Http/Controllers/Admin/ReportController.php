<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AttendanceDataTable;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Models\UserEvent;

class ReportController extends Controller
{

    public function attendance()
    {

        if (auth()->user()->user_id == "1") {
            $events = Event::orderBy('event_id', 'desc')->get();
            return view('report.attendance', compact('events'));
        } else {
            $userId = auth()->user()->user_id;
            $userEventFind = UserEvent::where('user_id', $userId)->pluck('event_id')->toArray();
            $userEvent = Event::find($userEventFind[0]);
            $events = Event::where('event_id', $userEvent->event_id)->get();
            return view('report.attendance', compact('events'));
        }
    }

    public function summaryAttendance(AttendanceDataTable $dataTable, $event_id)
    {
        // Pass the event_id to the DataTable
        $event = Event::where('slug', $event_id)->firstOrFail();
        return $dataTable->setEventId($event_id)->render('report.attendance_summary', compact('event'));
    }

    public function registration()
    {
        if (auth()->user()->user_id == "1") {
            $events = Event::orderBy('event_id', 'desc')->get();
            return view('report.registration', compact('events'));
        } else {
            $userId = auth()->user()->user_id;
            $userEventFind = UserEvent::where('user_id', $userId)->pluck('event_id')->toArray();
            $userEvent = Event::find($userEventFind[0]);
            $events = Event::where('event_id', $userEvent->event_id)->get();
            return view('report.registration', compact('events'));
        }
    }
}
