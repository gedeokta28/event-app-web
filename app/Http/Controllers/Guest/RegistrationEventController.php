<?php

namespace App\Http\Controllers\Guest;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use DateTime;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Storage;

class RegistrationEventController extends Controller
{
    /**
     * Store a newly created registration in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data pendaftaran
        $validatedData = $request->validate([
            'pax_name' => 'required|string|max:50',
            'pax_phone' => 'required|string|max:50',
            'pax_email' => 'required|email|max:100',
            'pax_company_name' => 'required|string|max:100',
            'event_id' => 'required|integer', // Asumsikan ada event_id dalam form
        ]);

        try {
            $eventid = $validatedData['event_id'];

            $event = Event::find($eventid);

            if (!$event) {
                return redirect()->back()->withErrors('Event not found.');
            }

            // Hitung jumlah pendaftar yang sudah ada
            $currentRegistrations = EventRegistration::where('event_id', $eventid)->count();
            // Ambil pendaftaran terakhir untuk event yang sama untuk nomor tiket
            $lastRegistration = EventRegistration::where('event_id', $eventid)
                ->orderBy('reg_date_time', 'desc')
                ->first();

            // Tentukan nomor urut berikutnya
            $nextSequence = $lastRegistration ? (int)substr($lastRegistration->reg_ticket_no, -4) + 1 : 1;
            $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT); // Format nomor urut dengan 4 digit

            // Format reg_id dan reg_ticket_no
            $reg_id = "1.$eventid.$formattedSequence";
            $reg_ticket_no = "$eventid.$formattedSequence";


            // Cek jika jumlah pendaftar melebihi batas maksimum
            if ($currentRegistrations >= $event->event_max_pax) {
                // Simpan data ke database
                $registration = new EventRegistration([
                    'reg_id' => $reg_id,
                    'reg_date_time' => now(), // Atur waktu pendaftaran
                    'event_id' => $eventid, // Ambil event_id dari form
                    'pax_name' => $validatedData['pax_name'],
                    'pax_phone' => $validatedData['pax_phone'],
                    'pax_email' => $validatedData['pax_email'],
                    'pax_company_name' => $validatedData['pax_company_name'],
                    'reg_success' => false,
                    'reg_ticket_no' => $reg_ticket_no, // Set nomor tiket
                ]);

                $registration->save();
                return redirect()->back()->withErrors('Registration failed. The maximum number of participants has been reached.');
            } else {
                // Simpan data ke database
                $registration = new EventRegistration([
                    'reg_id' => $reg_id,
                    'reg_date_time' => now(), // Atur waktu pendaftaran
                    'event_id' => $eventid, // Ambil event_id dari form
                    'pax_name' => $validatedData['pax_name'],
                    'pax_phone' => $validatedData['pax_phone'],
                    'pax_email' => $validatedData['pax_email'],
                    'pax_company_name' => $validatedData['pax_company_name'],
                    'reg_success' => true,
                    'reg_ticket_no' => $reg_ticket_no, // Set nomor tiket
                ]);

                $registration->save();

                $barcodeGenerator = new DNS1D();
                $barcode = $barcodeGenerator->getBarcodePNG($reg_ticket_no, 'C128', 3, 50); // scale: 3, height: 50

                // Define the file path for saving the barcode image
                $barcodePath = 'public/barcodes/barcode_' . $reg_ticket_no . '.png';

                // Save the barcode image to storage as a PNG file
                Storage::put($barcodePath, base64_decode($barcode));

                // Get the path of the saved barcode image
                $barcodeUrl = Storage::url($barcodePath);

                $registration->update(['barcode_file' => $barcodeUrl]);

                // Redirect kembali dengan pesan sukses
                return redirect()->back()->with('success', 'Registration successful. Your ticket will be sent via WhatsApp.');
            }
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan error
            return redirect()->back()->withErrors('There was an error processing your registration. Please try again later.');
        }
    }
}
