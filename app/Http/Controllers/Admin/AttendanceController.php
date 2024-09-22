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


    public function scan(Request $request)
    {
        $event_ticket_no = $request->input('event_ticket_no');

        $attendance = EventRegistration::where('reg_ticket_no', $event_ticket_no)->first();
        if ($attendance) {
            $event = Event::where('event_id', $attendance->event_id)->first();
            $today = now()->format('Y-m-d');
            $checkAbsen = Attendance::where('event_ticket_no', $attendance->reg_ticket_no)
                ->whereDate('attendance_date_time', $today)
                ->first();
            if ($checkAbsen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket sudah terdaftar!'
                ], 400);
            }
            $event_code_trans = $event->event_code_trans;
            $event_id = $event->event_id;
            // Ambil pendaftaran terakhir untuk event yang sama untuk nomor tiket
            $lastAttendance = Attendance::where('event_id', $event_id)->orderBy('attendance_date_time', 'desc')->first();

            if ($lastAttendance) {
                $nextSequence = (int)substr($lastAttendance->attendance_id, -4) + 1;
            } else {
                // If there is no previous attendance, start the sequence at 1
                $nextSequence = 1;
            }

            $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

            $attendance_id = "$event_code_trans.$event_id.$formattedSequence";

            // Simpan absensi
            Attendance::create([
                'attendance_id' => $attendance_id,
                'attendance_date_time' => Carbon::now(),
                'event_id' => $event_id, // Bisa disesuaikan sesuai event
                'event_reg_id' => '1', // Sesuaikan jika ada
                'event_ticket_no' => $event_ticket_no,
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ticket tidak terdaftar!'
            ], 400);
        }

        // Cari data registrasi event berdasarkan ticket no


        // return response()->json(['success' => true], 200);
    }

    public function countByDate(Request $request)
    {
        // Validate the input date
        $request->validate([
            'date' => 'required|date'
        ]);

        // Parse the input date
        $selectedDate = Carbon::parse($request->input('date'));

        // Count the number of attendees for the selected date
        $totalAttendance = Attendance::whereDate('attendance_date_time', $selectedDate)->count();
        $formattedDate = $selectedDate->locale('id')->isoFormat('dddd, D MMMM YYYY');

        // Return the view with the total count and the selected date
        return view('attendance.show-total-attendance', [
            'totalAttendance' => $totalAttendance,
            'selectedDate' => $formattedDate
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
