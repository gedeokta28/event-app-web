<?php

namespace App\Http\Controllers\Guest;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use DateTime;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;
use Intervention\Image\Facades\Image;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendTicketEmailJob;

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
        $paxPurpose = '';
        $validatedData = $request->validate([
            'pax_name' => 'required|string|max:50',
            'pax_phone' => 'required|string|max:50',
            'pax_email' => 'required|email|max:100',
            'pax_age' => 'required|string|max:30',
            'pax_purpose_of_visit' => 'required|string|max:500',
            'other_purpose' => 'nullable|string|max:1000',
            'event_id' => 'required|integer',
        ]);
        if ($validatedData['other_purpose'] == null) {
            $paxPurpose = $validatedData['pax_purpose_of_visit'];
        } else {
            $paxPurpose = $validatedData['other_purpose'];
        }

        try {
            $eventid = $validatedData['event_id'];
            $event = Event::find($eventid);
            if (!$event) {
                return redirect()->back()->withErrors('Event not found.');
            }
            $phone = $validatedData['pax_phone'];
            $phone = '+62' . substr($phone, 1);
            $phoneExists = EventRegistration::where('event_id', $eventid)
                ->where('pax_phone', $phone)
                ->where('reg_success',  true)
                ->first();
            $emailExists = EventRegistration::where('event_id', $eventid)
                ->where('pax_email',  $validatedData['pax_email'])
                ->where('reg_success',  true)
                ->first();
            if ($phoneExists) {
                return redirect()->back()->withErrors('Registration failed. This Phone Number is already registered !!');
            }
            if ($emailExists) {
                return redirect()->back()->withErrors('Registration failed. This Email is already registered !!');
            }

            // $currentRegistrations = EventRegistration::where('event_id', $eventid)->count();
            $currentRegistrations = EventRegistration::where('event_id', $eventid)
                ->where('reg_success', 1) // Ensure reg_success is 1 (true)
                ->count();
            $lastRegistration = EventRegistration::where('event_id', $eventid)
                ->orderBy('reg_date_time', 'desc')
                ->first();

            $nextSequence = $lastRegistration ? (int)substr($lastRegistration->reg_ticket_no, -4) + 1 : 1;
            $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT); // Format nomor urut dengan 4 digit

            $reg_id = "1.$eventid.$formattedSequence";
            $reg_ticket_no = "$eventid.$formattedSequence";


            if ($currentRegistrations > $event->event_max_pax) {
                $registration = new EventRegistration([
                    'reg_id' => $reg_id,
                    'reg_date_time' => now(),
                    'event_id' => $eventid,
                    'pax_name' => strtoupper($validatedData['pax_name']),
                    'pax_phone' => $phone,
                    'pax_email' => $validatedData['pax_email'],
                    'pax_age' => $validatedData['pax_age'],
                    'pax_purpose_of_visit' => $paxPurpose,
                    'reg_success' => false,
                    'reg_ticket_no' => $reg_ticket_no,
                ]);

                $registration->save();
                return redirect()->back()->withErrors('Registration failed. The maximum number of participants has been reached.');
            } else {
                try {
                    $registration = new EventRegistration([
                        'reg_id' => $reg_id,
                        'reg_date_time' => now(),
                        'event_id' => $eventid,
                        'pax_name' => strtoupper($validatedData['pax_name']),
                        'pax_phone' => $phone,
                        'pax_email' => $validatedData['pax_email'],
                        'pax_age' => $validatedData['pax_age'],
                        'pax_purpose_of_visit' => $paxPurpose,
                        'reg_success' => true,
                        'reg_ticket_no' => $reg_ticket_no,
                    ]);

                    $registration->save();

                    $barcodeGenerator = new DNS1D();
                    $barcode = $barcodeGenerator->getBarcodePNG($reg_ticket_no, 'C128', 3, 50); // scale: 3, height: 50

                    $canvasWidth = 600;
                    $canvasHeight = 800;
                    $img = Image::canvas($canvasWidth, $canvasHeight, '#ffffff');

                    // Menambahkan logo
                    if ($event->logo_file) {
                        $logoPath = public_path('app/' . $event->logo_file);
                        if (file_exists($logoPath)) {
                            $logoImage = Image::make($logoPath);
                            $logoWidth = $logoImage->width();

                            // Mengatur ukuran maksimal logo (60% dari lebar canvas)
                            $maxLogoWidth = $canvasWidth * 0.6;
                            $maxLogoHeight = $canvasHeight * 0.5; // Atur agar lebih kecil dari sebelumnya

                            // Resize logo
                            $logoImage->resize($maxLogoWidth, $maxLogoHeight, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });

                            // Mengambil ukuran logo baru
                            $logoWidth = $logoImage->width();

                            // Hitung posisi logo agar berada di bagian atas
                            $x = ($canvasWidth - $logoWidth) / 2;
                            $y = 40; // Naikkan posisi logo agar lebih dekat ke bagian atas

                            $img->insert($logoImage, 'top-left', $x, $y);
                        }
                    }

                    // Menambahkan barcode
                    $barcodeGenerator = new DNS1D();
                    $barcode = $barcodeGenerator->getBarcodePNG($reg_ticket_no, 'C128', 3, 50);
                    $barcodeImage = Image::make(base64_decode($barcode));

                    $maxBarcodeWidth = $canvasWidth * 0.8;
                    $barcodeImage->resize($maxBarcodeWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $barcodeWidth = $barcodeImage->width();
                    $barcodeHeight = $barcodeImage->height();

                    $xBarcode = ($canvasWidth - $barcodeWidth) / 2;
                    $yBarcode = $canvasHeight - $barcodeHeight - 150;

                    $img->insert($barcodeImage, 'top-left', $xBarcode, $yBarcode);


                    $img->text('NAME', $canvasWidth / 2, $yBarcode - 100, function ($font) {
                        $font->file(public_path('fonts/arial-bold.TTF')); // Menggunakan font bold
                        $font->size(22); // Ukuran font
                        $font->color('#000000');
                        $font->align('center');
                        $font->valign('top');
                    });

                    $registrationName = strtoupper($validatedData['pax_name']); // Contoh nama registrasi
                    $img->text($registrationName, $canvasWidth / 2, $yBarcode - 70, function ($font) {
                        $font->file(public_path('fonts/arial.ttf')); // Menggunakan font biasa (non-bold)
                        $font->size(23); // Ukuran font
                        $font->color('#000000');
                        $font->align('center');
                        $font->valign('top');
                    });

                    $fontSize = 25;
                    $yText = $yBarcode + $barcodeHeight + 10;
                    $img->text($reg_ticket_no, $canvasWidth / 2, $yText, function ($font) use ($fontSize) {
                        $font->file(public_path('fonts/arial.ttf'));
                        $font->size($fontSize);
                        $font->color('#000000');
                        $font->align('center');
                        $font->valign('top');
                    });

                    // Nama dan folder file yang akan disimpan
                    $fileName = 'event_' . $reg_ticket_no . '.png';
                    $folderPath = storage_path('app/temp_images');

                    // Buat folder jika belum ada
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0755, true);
                    }

                    $tempFilePath = $folderPath . '/' . $fileName;

                    // Simpan gambar
                    $img->save($tempFilePath);

                    $uploadedFile = new UploadedFile(
                        $tempFilePath, // path ke file sementara
                        $fileName,     // nama file
                        'image/png',   // mime type
                        null,          // ukuran file (bisa null, Laravel akan menghitung otomatis)
                        true           // indikasi bahwa ini file yang valid
                    );

                    $fileExtension = $uploadedFile->clientExtension();
                    $barcodeFileName = sprintf("%s.%s", 'ticket_' . $reg_ticket_no, $fileExtension);

                    $filepath = $uploadedFile->storeAs('event/barcodes', $barcodeFileName);

                    $registration->update(['barcode_file' => $filepath]);

                    try {
                        $initStartDate = \Carbon\Carbon::parse($event->event_start_date);
                        $initEndDate = \Carbon\Carbon::parse($event->event_end_date);

                        $startDate = $initStartDate->format('j');
                        $endDate = $initEndDate->format('j');
                        $month = \Carbon\Carbon::parse($event->event_start_date)->format('F');
                        $year = \Carbon\Carbon::parse($event->event_start_date)->format('Y');

                        $formattedDateRange = "{$startDate}-{$endDate} {$month} {$year}";
                        $ticketPath = public_path('app/' . $filepath);
                        SendTicketEmailJob::dispatch($registration, $formattedDateRange, $event, $ticketPath);
                    } catch (\Exception $e) {
                        $registration->update(['reg_success' => false]);
                        Log::error('Error updating registration or dispatching email job: ' . $e->getMessage());
                        return redirect()->back()->withErrors("Registration failed. We couldn't send an email to the provided address. Please check if it's correct and active. If the issue persists, try another email or contact support for assistance.");
                    }

                    // WHATSAPP
                    $sid = env('TWILIO_SID');
                    $token = env('TWILIO_AUTH_TOKEN');
                    $twilio = new \Twilio\Rest\Client($sid, $token);

                    $message = $twilio->messages->create(
                        "whatsapp:$phone", // To
                        [
                            "contentSid" => "HXf1a61c0cf0a3cd7f5557caa7aef37f71",
                            "from" => "whatsapp:+12163500105",
                            "contentVariables" => json_encode([
                                "1" => $validatedData['pax_name'],
                                "2" => $validatedData['pax_phone'],
                                "3" => $validatedData['pax_email'],
                                "4" => $filepath,
                            ]),

                        ]
                    );
                    $downloadLink = route('download.ticket', ['filename' => $barcodeFileName]);
                    return redirect()->back()->with('success', "Registration successful! Your ticket has been sent to your email and via WhatsApp.<br>Thank you for joining us at BEYOND LIVING 2024!<br><a href='{$downloadLink}' style='text-decoration: underline;'>Click here to download your ticket</a>");
                } catch (\Exception $e) {
                    $registration->update(['reg_success' => false]);
                    return redirect()->back()->withErrors('Registration failed. ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {

            return redirect()->back()->withErrors('There was an error processing your registration. Please try again later.');
        }
    }
}
