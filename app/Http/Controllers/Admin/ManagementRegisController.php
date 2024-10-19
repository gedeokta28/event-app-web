<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\RegisDataTable;
use App\DataTables\RegisDataTableAdmin;
use App\Models\Event;

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
}
