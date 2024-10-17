<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Support\Facades\Log;
use App\DataTables\EventDataTable;
use App\Models\Company;
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
        // Ambil distinct company_type dari tabel Company
        $companyTypes = Company::select('company_type')->groupBy('company_type')->get();

        return view('events.create', compact('companyTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EventStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventStoreRequest $request)
    {
        // Validasi request
        $data = $request->validated();

        // Format tanggal mulai dan akhir event
        $data['event_start_date'] = \Carbon\Carbon::parse($data['event_start_date'])->format('Y-m-d');
        $data['event_end_date'] = \Carbon\Carbon::parse($data['event_end_date'])->format('Y-m-d');

        // Generate slug dari nama event
        $data['slug'] = Str::slug($data['event_name']);

        // Auto-generate event_code_reg dan event_code_trans
        $event_code_reg = '1'; // Contoh static code atau logika untuk menentukannya
        $event_code_trans = '2'; // Contoh static code atau logika untuk menentukannya
        $data['event_code_reg'] = $event_code_reg;
        $data['event_code_trans'] = $event_code_trans;

        // Generate event_id berdasarkan konfigurasi yang disediakan
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Fetch the latest event_id to increment
        $lastEvent = Event::orderBy('event_id', 'desc')->first();
        $nextIdNumber = 1; // Default jika belum ada event sebelumnya

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

        // Set event_active berdasarkan apakah request memiliki nilai 'event_active'
        $data['event_active'] = $request->has('event_active');

        // Tambahan logika untuk event_company_type
        if ($request->input('event_type') === 'PK DEVELOPER') {
            // Pastikan company_type dipilih jika event_type adalah 'PK DEVELOPER'
            $data['event_company_type'] = $request->input('event_company_type');
        } else {
            // Set null jika event_type bukan 'PK DEVELOPER'
            $data['event_company_type'] = null;
        }

        // Gunakan eventService untuk menyimpan data event
        $this->eventService->create($data);

        // Redirect ke halaman create event dengan pesan sukses
        return redirect()->route('events.create')->with('success', 'Data berhasil disimpan');
    }



    public function edit(Event $event)
    {
        $companyTypes = Company::select('company_type')->groupBy('company_type')->get();

        return view('events.edit', compact('companyTypes', 'event'));
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
        if ($request->input('event_type') === 'PK DEVELOPER') {
            // Pastikan company_type dipilih jika event_type adalah 'PK DEVELOPER'
            $data['event_company_type'] = $request->input('event_company_type');
        } else {
            // Set null jika event_type bukan 'PK DEVELOPER'
            $data['event_company_type'] = null;
        }

        $this->eventService->update($event->event_id, $data);
        return redirect()->route('events.index')->with('success', 'Data berhasil disimpan');
    }


    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['status' => 'OK']);
    }
}
