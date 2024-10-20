<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\UserEvent;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->user_id == "1") {
            $registrationTotal = \App\Models\EventRegistration::count();
            $eventTotal = \App\Models\Event::count();
            return view('dashboard.index', compact('registrationTotal', 'eventTotal'));
        } else {
            $userId = auth()->user()->user_id;
            $userEventFind = UserEvent::where('user_id', $userId)->pluck('event_id')->toArray();
            $userEvent = Event::find($userEventFind[0]);
            $registrationTotal = \App\Models\EventRegistration::where('event_id', $userEvent->event_id)->count();
            $eventTotal = \App\Models\Event::where('event_id', $userEvent->event_id)->count();
            return view('dashboard.index_admin', compact('registrationTotal', 'eventTotal', 'userEvent'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
