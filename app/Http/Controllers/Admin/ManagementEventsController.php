<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Support\Facades\Log;
use App\DataTables\EventDataTable;
use Illuminate\Support\Str;

class ManagementEventsController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) {}

    public function index(EventDataTable $eventDataTable)
    {
        return $eventDataTable->render('events.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EventStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventStoreRequest $request)
    {


        $data = $request->validated();
        $data['event_start_date'] = \Carbon\Carbon::parse($data['event_start_date'])->format('Y-m-d');
        $data['event_end_date'] = \Carbon\Carbon::parse($data['event_end_date'])->format('Y-m-d');

        // Generate slug from event_name
        $data['slug'] = Str::slug($data['event_name']);

        // Auto-generate event_code_reg and event_code_trans
        $event_code_reg = '1'; // Example static code or logic to determine the code
        $event_code_trans = '2'; // Example static code or logic to determine the code

        $data['event_code_reg'] = $event_code_reg;
        $data['event_code_trans'] = $event_code_trans;

        // Generate event_id based on the provided configuration
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Fetch the latest event_id to increment
        $lastEvent = Event::orderBy('event_id', 'desc')->first();
        $nextIdNumber = 1; // Default to 001 if no previous events

        if ($lastEvent) {
            $lastId = $lastEvent->event_id;
            $lastYear = '20' . substr($lastId, 0, 2);
            $lastMonth = substr($lastId, 2, 2);
            $lastNumber = intval(substr($lastId, 6));

            if ($currentYear == $lastYear && $currentMonth == $lastMonth) {
                $nextIdNumber = $lastNumber + 1;
            }
        }

        $shortYear = substr($currentYear, 2);
        $event_id = sprintf('%s%s%03d', $shortYear, $currentMonth, $nextIdNumber);

        $data['event_id'] = $event_id;
        $data['event_active'] = $request->has('event_active');
        $this->eventService->create($data);

        return redirect()->route('events.create')->with('success', 'Data berhasil disimpan');
    }


    public function edit(Event $event)
    {

        return view('events.edit', compact('event'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EventStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(EventStoreRequest $request, Event $event)
    {
        // Log::info('Store method is being called');

        // // Log the entire request to see the inputs
        // Log::info($request->all());

        // $data = $request->validated();
        // Log::info($data);
        $data = $request->validated();
        $data['event_active'] = $request->has('event_active');
        // Ensure files are included in the request


        $this->eventService->update($event->event_id, $data);
        return redirect()->route('events.index')->with('success', 'Data berhasil disimpan');
    }


    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['status' => 'OK']);
    }
}
