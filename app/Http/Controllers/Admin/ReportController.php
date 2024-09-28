<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    public function attendance()
    {
        $events = Event::orderBy('event_id', 'desc')->get();
        return view('report.attendance', compact('events'));
    }
    
    public function registration()
    {
        $events = Event::orderBy('event_id', 'desc')->get();
        return view('report.registration', compact('events'));
    }
}
