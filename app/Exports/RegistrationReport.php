<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\EventRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegistrationReport implements FromCollection, WithHeadings, WithMapping
{
    protected $status;
    protected $eventId;

    public function __construct($status, $eventId)
    {
        $this->status = $status;
        $this->eventId = $eventId;
    }
    public function collection()
    {
        // Ambil data sesuai dengan status yang dipilih dan urutkan berdasarkan reg_id descending
        if ($this->status == 'successful') {
            return EventRegistration::where('event_id', $this->eventId)
                ->where('reg_success', true)
                ->orderBy('reg_id', 'desc') // Mengurutkan berdasarkan reg_id secara descending
                ->get(); // Ganti dengan kondisi sesuai
        }

        return EventRegistration::where('event_id', $this->eventId)->orderBy('reg_id', 'desc')->get(); // Mengurutkan untuk semua pendaftaran
    }


    public function headings(): array
    {
        $event = Event::where('event_id',  $this->eventId)->firstOrFail();
        if ($event->event_type == "PK DEVELOPER") {
            return [
                'Registration ID',         // reg_id
                'Registration Date & Time', // reg_date_time
                'Name',                   // pax_name
                'Phone',                  // pax_phone
                'Email',                  // pax_email
                'Company',                  // pax_email
                'Status',    // reg_success
            ];
        } else {
            return [
                'Registration ID',         // reg_id
                'Registration Date & Time', // reg_date_time
                'Name',                   // pax_name
                'Phone',                  // pax_phone
                'Email',                  // pax_email
                'Status',    // reg_success
                'Age',                    // pax_age
                'Profession',                    // pax_age
                'Purpose of Visit'        // pax_purpose_of_visit
            ];
        }
    }

    public function map($registration): array
    {

        $formattedWibDate = \Carbon\Carbon::parse($registration->reg_date_time)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i');
        $formattedPhone = preg_replace('/^\+62/', '0', $registration->pax_phone);
        $paxProfession = !empty($registration->pax_profession) ? $registration->pax_profession : '-';
        $event = Event::where('event_id',  $this->eventId)->firstOrFail();
        if ($event->event_type == "PK DEVELOPER") {
            return [
                $registration->reg_id,              // reg_id
                $formattedWibDate,                  // reg_date_time (dalam format WIB)
                $registration->pax_name,            // pax_name
                $formattedPhone, // pax_phone
                $registration->pax_email,           // pax_email
                $registration->pax_company_name,           // pax_email
                $registration->reg_success ? 'Success' : 'Failure', // reg_success
            ];
        } else {
            return [
                $registration->reg_id,              // reg_id
                $formattedWibDate,                  // reg_date_time (dalam format WIB)
                $registration->pax_name,            // pax_name
                $formattedPhone, // pax_phone
                $registration->pax_email,           // pax_email
                $registration->reg_success ? 'Success' : 'Failure', // reg_success
                $registration->pax_age,           // pax_age
                $paxProfession,             // pax_age
                $registration->pax_purpose_of_visit  // pax_purpose_of_visit
            ];
        }
    }
}
