<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class AttendanceReport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $eventId;

    public function __construct($eventId, $startDate = null, $endDate = null)
    {
        $this->eventId = $eventId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Start querying both Attendance and Registration tables
        $query = DB::table('t_event_attendance as a')
            ->join('t_event_registration as r', 'a.event_reg_id', '=', 'r.reg_id') // Assuming reg_id is the common field
            ->select(
                'a.event_ticket_no',
                'r.pax_name',
                'r.pax_phone',
                'r.pax_email',
                'r.pax_age',
                'r.pax_purpose_of_visit',
                'a.attendance_date_time',
                'r.reg_date_time'
            )
            ->where('a.event_id', $this->eventId);

        // Apply date filtering based on the presence of startDate and endDate
        if ($this->startDate && $this->endDate) {
            $endDate = \Carbon\Carbon::parse($this->endDate)->endOfDay();

            $query->where('a.attendance_date_time', '>=', $this->startDate)
                ->where('a.attendance_date_time', '<=', $endDate);
        } elseif ($this->startDate) {
            // If only startDate is provided
            $query->where('a.attendance_date_time', '>=', $this->startDate);
        } elseif ($this->endDate) {
            // If only endDate is provided
            $query->where('a.attendance_date_time', '<=', $this->endDate);
        }

        // Return records ordered by attendance_id in descending order
        return $query->orderBy('a.attendance_id', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Ticket Number',          // event_ticket_no
            'Pax Name',               // pax_name
            'Pax Phone',              // pax_phone
            'Pax Email',              // pax_email
            'Pax Age',                // pax_age
            'Pax Purpose of Visit',   // pax_purpose_of_visit
            'Attendance Date & Time',  // attendance_date_time
            'Reg Date Time',          // reg_date_time
        ];
    }

    public function map($attendance): array
    {
        // Format attendance date and time to WIB timezone
        $formattedWibDate = \Carbon\Carbon::parse($attendance->attendance_date_time)
            ->setTimezone('Asia/Jakarta')
            ->format('Y-m-d H:i');

        $formattedRegDate = \Carbon\Carbon::parse($attendance->reg_date_time)
            ->setTimezone('Asia/Jakarta')
            ->format('Y-m-d H:i');

        $formattedPhone = preg_replace('/^\+62/', '0', $attendance->pax_phone);

        return [
            "\t" . (string)$attendance->event_ticket_no, // event_ticket_no
            $attendance->pax_name,                         // pax_name
            $formattedPhone,                        // pax_phone
            $attendance->pax_email,                        // pax_email
            $attendance->pax_age,                          // pax_age
            $attendance->pax_purpose_of_visit,            // pax_purpose_of_visit
            $formattedWibDate,                            // attendance_date_time (in WIB format)
            $formattedRegDate,                            // reg_date_time
        ];
    }
}
