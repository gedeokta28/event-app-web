<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('attendance.index');
    }


    public function scanTools()
    {
        return view('attendance.scan-tools');
    }

    public function checkIn(Request $request)
    {
        $regId = $request->input('reg_id');

        // Find the event registration based on reg_id
        $attendance = EventRegistration::where('reg_id', $regId)->first();

        if ($attendance) {
            $event_id = $attendance->event_id;
            $event_ticket_no = $attendance->reg_ticket_no;

            // Check if the user has already checked in for today
            $today = now()->format('Y-m-d');
            $checkAbsen = Attendance::where('event_ticket_no', $event_ticket_no)
                ->whereDate('attendance_date_time', $today)
                ->first();

            if ($checkAbsen) {
                return response()->json(['success' => false, 'message' => 'Ticket sudah terdaftar!'], 400);
            }

            // Proceed with check-in logic...
            $event_code_trans = Event::where('event_id', $event_id)->value('event_code_trans');

            // Determine the next attendance ID
            $lastAttendance = Attendance::where('event_id', $event_id)
                ->orderByRaw('CAST(SUBSTRING_INDEX(attendance_id, \'.\', -1) AS UNSIGNED) DESC')
                ->first();

            $nextSequence = $lastAttendance ?
                (int)substr($lastAttendance->attendance_id, strrpos($lastAttendance->attendance_id, '.') + 1) + 1 : 1;

            $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

            $attendance_id = "$event_code_trans.$event_id.$formattedSequence";

            // Save attendance
            Attendance::create([
                'attendance_id' => $attendance_id,
                'attendance_date_time' => now(),
                'event_id' => $event_id,
                'event_reg_id' => $attendance->reg_id,
                'event_ticket_no' => $event_ticket_no,
            ]);

            return response()->json(['success' => true, 'message' => 'Check-in berhasil!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Ticket tidak terdaftar!'], 400);
        }
    }
    public function scan(Request $request)
    {
        $event_ticket_no = $request->input('event_ticket_no');

        $attendance = EventRegistration::where('reg_ticket_no', $event_ticket_no)->first();
        if ($attendance) {
            $event_reg_id = $attendance->reg_id;
            $event = Event::where('event_id', $attendance->event_id)->first();
            $today = now()->format('Y-m-d');
            $checkAbsen = Attendance::where('event_ticket_no', $attendance->reg_ticket_no)
                ->whereDate('attendance_date_time', $today)
                ->first();
            if ($checkAbsen) {
                if ($event->event_type == "PK DEVELOPER") {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ticket sudah terdaftar!'
                    ], 400);
                } else {
                    return response()->json(['success' => true, 'message' => 'Tiket sudah terdaftar']);
                }
            }
            $event_code_trans = $event->event_code_trans;
            $event_id = $event->event_id;
            // Ambil pendaftaran terakhir untuk event yang sama untuk nomor tiket
            // $lastAttendance = Attendance::where('event_id', $event_id)->orderBy('attendance_id', 'desc')->first();
            //
            $lastAttendance = Attendance::where('event_id', $event_id)
                ->orderByRaw('CAST(SUBSTRING_INDEX(attendance_id, \'.\', -1) AS UNSIGNED) DESC')
                ->first();

            if ($lastAttendance) {
                //
                // $nextSequence = (int)substr($lastAttendance->attendance_id, -4) + 1;
                $lastSequence = (int)substr($lastAttendance->attendance_id, strrpos($lastAttendance->attendance_id, '.') + 1);
                $nextSequence = $lastSequence + 1;
            } else {
                // If there is no previous attendance, start the sequence at 1
                $nextSequence = 1;
            }
            //
            // $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
            if ($nextSequence < 10000) {
                $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT); // For 4 digits
            } else {
                $formattedSequence = str_pad($nextSequence, 5, '0', STR_PAD_LEFT); // For 5 digits
            }

            $attendance_id = "$event_code_trans.$event_id.$formattedSequence";

            // Simpan absensi
            Attendance::create([
                'attendance_id' => $attendance_id,
                'attendance_date_time' => Carbon::now(),
                'event_id' => $event_id, // Bisa disesuaikan sesuai event
                'event_reg_id' => $event_reg_id, // Sesuaikan jika ada
                'event_ticket_no' => $event_ticket_no,
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ticket tidak terdaftar!'
            ], 400);
        }
    }

    public function countByDate(Request $request)
    {
        // Validate the input date
        $request->validate([
            'date' => 'required|date',
        ]);

        // Parse the input date
        $selectedDate = Carbon::parse($request->input('date'));
        $eventId = $request->input('event_id');
        $event = Event::where('event_id', $eventId)->first();
        $eventImage = $event->logo_file;

        // Count the number of attendees for the selected date
        $totalAttendance = Attendance::whereDate('attendance_date_time', $selectedDate)->where('event_id', $eventId)->count();
        $formattedDate = $selectedDate->locale('id')->isoFormat('dddd, D MMMM YYYY');

        // Return the view with the total count and the selected date
        return view('attendance.show-total-attendance', [
            'totalAttendance' => $totalAttendance,
            'selectedDate' => $formattedDate,
            'eventImage' => $eventImage,
            'initialDate' => $request->input('date'),
            'initialEventId' => $request->input('event_id'),
        ]);
    }
    public function countByDateJson(Request $request)
    {
        // Validate the input date
        $request->validate([
            'date' => 'required|date'
        ]);

        // Parse the input date
        $selectedDate = Carbon::parse($request->input('date'));
        $eventId = $request->input('event_id');

        // Count the number of attendees for the selected date
        $totalAttendance = Attendance::whereDate('attendance_date_time', $selectedDate)->where('event_id', $eventId)->count();

        // Return the total attendance as JSON response
        return response()->json([
            'totalAttendance' => $totalAttendance,
            'formattedDate' => $selectedDate->locale('id')->isoFormat('dddd, D MMMM YYYY'),
        ]);
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
