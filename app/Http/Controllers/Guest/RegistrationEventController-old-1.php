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
            // 'pax_company_name' => 'required|string|max:100',
            'other_purpose' => 'nullable|string|max:1000',
            'event_id' => 'required|integer', // Asumsikan ada event_id dalam form
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
                ->first();

            if ($phoneExists) {
                return redirect()->back()->withErrors('Registration failed. This phone number is already registered !!');
            }

            $currentRegistrations = EventRegistration::where('event_id', $eventid)->count();
            $lastRegistration = EventRegistration::where('event_id', $eventid)
                ->orderBy('reg_date_time', 'desc')
                ->first();

            $nextSequence = $lastRegistration ? (int)substr($lastRegistration->reg_ticket_no, -4) + 1 : 1;
            $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT); // Format nomor urut dengan 4 digit

            $reg_id = "1.$eventid.$formattedSequence";
            $reg_ticket_no = "$eventid.$formattedSequence";


            if ($currentRegistrations >= $event->event_max_pax) {
                $registration = new EventRegistration([
                    'reg_id' => $reg_id,
                    'reg_date_time' => now(), // Atur waktu pendaftaran
                    'event_id' => $eventid, // Ambil event_id dari form
                    'pax_name' => $validatedData['pax_name'],
                    'pax_phone' => $phone,
                    'pax_email' => $validatedData['pax_email'],
                    'pax_age' => $validatedData['pax_age'],
                    'pax_purpose_of_visit' => $paxPurpose,
                    // 'pax_company_name' => $validatedData['pax_company_name'],
                    'reg_success' => false,
                    'reg_ticket_no' => $reg_ticket_no, // Set nomor tiket
                ]);

                $registration->save();
                return redirect()->back()->withErrors('Registration failed. The maximum number of participants has been reached.');
            } else {
                try {

                    $registration = new EventRegistration([
                        'reg_id' => $reg_id,
                        'reg_date_time' => now(), // Atur waktu pendaftaran
                        'event_id' => $eventid, // Ambil event_id dari form
                        'pax_name' => $validatedData['pax_name'],
                        'pax_phone' => $phone,
                        'pax_email' => $validatedData['pax_email'],
                        'pax_age' => $validatedData['pax_age'],
                        'pax_purpose_of_visit' => $paxPurpose,
                        // 'pax_company_name' => $validatedData['pax_company_name'],
                        'reg_success' => true,
                        'reg_ticket_no' => $reg_ticket_no, // Set nomor tiket
                    ]);

                    $registration->save();

                    $barcodeGenerator = new DNS1D();
                    $barcode = $barcodeGenerator->getBarcodePNG($reg_ticket_no, 'C128', 3, 50); // scale: 3, height: 50

                    // $canvasWidth = 600;
                    // $canvasHeight = 800;
                    // $img = Image::canvas($canvasWidth, $canvasHeight, '#ffffff');
                    // if ($event->logo_file) {
                    //     $logoPath = public_path('app/' . $event->logo_file);
                    //     if (file_exists($logoPath)) {
                    //         // Buat image dari logo
                    //         $logoImage = Image::make($logoPath);
                    //         $logoWidth = $logoImage->width();
                    //         $logoHeight = $logoImage->height();

                    //         // Tentukan batas maksimum ukuran logo
                    //         $maxLogoWidth = $canvasWidth * 0.8; // 80% dari lebar canvas
                    //         $maxLogoHeight = $canvasHeight * 0.8; // 80% dari tinggi canvas

                    //         // Sesuaikan ukuran logo agar sesuai dengan batas maksimum
                    //         $logoImage->resize($maxLogoWidth, $maxLogoHeight, function ($constraint) {
                    //             $constraint->aspectRatio();
                    //             $constraint->upsize(); // Mencegah pembesaran gambar lebih besar dari ukuran aslinya
                    //         });

                    //         // Ambil ukuran baru dari logo
                    //         $logoWidth = $logoImage->width();
                    //         $logoHeight = $logoImage->height();

                    //         // Hitung posisi tengah
                    //         $x = ($canvasWidth - $logoWidth) / 2;
                    //         $y = ($canvasHeight - $logoHeight) / 2;

                    //         // Sisipkan logo di tengah canvas
                    //         $img->insert($logoImage, 'top-left', $x, $y);
                    //     }
                    // }
                    // $barcodeImage = Image::make(base64_decode($barcode));
                    // $barcodeImage->resize(300, null, function ($constraint) {
                    //     $constraint->aspectRatio();
                    // });
                    // $img->insert($barcodeImage, 'bottom', 20, 20); // Barcode at the bottom of the image


                    // // Nama dan folder file yang akan disimpan
                    // $fileName = 'event_' . $reg_ticket_no . '.png';
                    // $folderPath = storage_path('app/temp_images'); // Simpan sementara di folder 'temp_images'

                    // // Buat folder jika belum ada
                    // if (!file_exists($folderPath)) {
                    //     mkdir($folderPath, 0755, true);
                    // }

                    // $tempFilePath = $folderPath . '/' . $fileName;

                    // $img->save($tempFilePath);

                    $canvasWidth = 600;
                    $canvasHeight = 800;
                    $img = Image::canvas($canvasWidth, $canvasHeight, '#ffffff');

                    // Menambahkan logo
                    if ($event->logo_file) {
                        $logoPath = public_path('app/' . $event->logo_file);
                        if (file_exists($logoPath)) {
                            $logoImage = Image::make($logoPath);
                            $logoWidth = $logoImage->width();
                            $logoHeight = $logoImage->height();

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
                            $logoHeight = $logoImage->height();

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

                    // Posisi barcode lebih ke bawah dari teks nama dan tanggal
                    $xBarcode = ($canvasWidth - $barcodeWidth) / 2;
                    $yBarcode = $canvasHeight - $barcodeHeight - 150; // Naikkan sedikit untuk memberi ruang bagi teks nama dan tanggal

                    $img->insert($barcodeImage, 'top-left', $xBarcode, $yBarcode);

                    // Menambahkan teks nama dan tanggal registrasi

                    // Menambahkan teks "NAME" dengan bold
                    $img->text('NAME', $canvasWidth / 2, $yBarcode - 100, function ($font) {
                        $font->file(public_path('fonts/arial-bold.TTF')); // Menggunakan font bold
                        $font->size(22); // Ukuran font
                        $font->color('#000000');
                        $font->align('center');
                        $font->valign('top');
                    });

                    $registrationName = $validatedData['pax_name']; // Contoh nama registrasi
                    $img->text($registrationName, $canvasWidth / 2, $yBarcode - 70, function ($font) {
                        $font->file(public_path('fonts/arial.ttf')); // Menggunakan font biasa (non-bold)
                        $font->size(23); // Ukuran font
                        $font->color('#000000');
                        $font->align('center');
                        $font->valign('top');
                    });


                    // Menambahkan nomor barcode di bawah barcode
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
                    $barcodeFileName = sprintf("%s.%s", 'barcode_' . $reg_ticket_no, $fileExtension);

                    $filepath = $uploadedFile->storeAs('event/barcodes', $barcodeFileName);

                    $registration->update(['barcode_file' => $filepath]);

                    $sid = env('TWILIO_SID');
                    $token = env('TWILIO_AUTH_TOKEN');
                    $twilio = new \Twilio\Rest\Client($sid, $token);

                    $messageBody = "🎉 Selamat datang di event kami! 🎉\n\n";
                    $messageBody .= "Kami senang memberitahukan Anda bahwa registrasi Anda berhasil. Berikut adalah detail tiket Anda:\n\n";
                    $messageBody .= "Nama Peserta: " . $validatedData['pax_name'] . "\n";
                    $messageBody .= "Nomor Telepon: " . $validatedData['pax_phone'] . "\n";
                    $messageBody .= "Email: " . $validatedData['pax_email'] . "\n\n";
                    $messageBody .= "Harap simpan tiket ini sebagai bukti registrasi Anda. Terima kasih.";

                    // Kirim pesan ke nomor peserta
                    $message = $twilio->messages
                        ->create(
                            "whatsapp:+6287806508302", // Nomor WhatsApp peserta
                            [
                                "from" => "whatsapp:+14155238886", // Nomor WhatsApp Twilio
                                "body" => $messageBody,
                                "mediaUrl" => ["https://keneas.com/app/$filepath"]
                            ]
                        );

                    return redirect()->back()->with('success', 'Registration successful. Your ticket has been sent via WhatsApp.');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors('Registration successful but failed to send WhatsApp message. Please contact support.');
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('There was an error processing your registration. Please try again later.');
        }
    }

    public function stores()
    {


        try {
            $eventid = "2409001";
            $event = Event::find($eventid);
            if (!$event) {
                return redirect()->back()->withErrors('Event not found.');
            }

            $currentRegistrations = EventRegistration::where('event_id', $eventid)->count();
            $lastRegistration = EventRegistration::where('event_id', $eventid)
                ->orderBy('reg_date_time', 'desc')
                ->first();

            $nextSequence = $lastRegistration ? (int)substr($lastRegistration->reg_ticket_no, -4) + 1 : 1;
            $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT); // Format nomor urut dengan 4 digit

            $reg_id = "1.$eventid.$formattedSequence";
            $reg_ticket_no = "$eventid.$formattedSequence";


            if ($currentRegistrations >= $event->event_max_pax) {
                $registration = new EventRegistration([
                    'reg_id' => $reg_id,
                    'reg_date_time' => now(), // Atur waktu pendaftaran
                    'event_id' => $eventid, // Ambil event_id dari form
                    'pax_name' => "Oktaa",
                    'pax_phone' => "1231231212",
                    'pax_email' => "gedaeda@asd.co",
                    'pax_age' => "asdasda",
                    'pax_purpose_of_visit' => "asdsadasd",
                    // 'pax_company_name' => $validatedData['pax_company_name'],
                    'reg_success' => false,
                    'reg_ticket_no' => $reg_ticket_no, // Set nomor tiket
                ]);

                $registration->save();
                return redirect()->back()->withErrors('Registration failed. The maximum number of participants has been reached.');
            } else {
                try {
                    $registration = new EventRegistration([
                        'reg_id' => $reg_id,
                        'reg_date_time' => now(), // Atur waktu pendaftaran
                        'event_id' => $eventid, // Ambil event_id dari form
                        'pax_name' => "Oktaa",
                        'pax_phone' => "1231231212",
                        'pax_email' => "gedaeda@asd.co",
                        'pax_age' => "asdasda",
                        'pax_purpose_of_visit' => "asdsadasd",
                        // 'pax_company_name' => $validatedData['pax_company_name'],
                        'reg_success' => false,
                        'reg_ticket_no' => $reg_ticket_no, // Set nomor tiket
                    ]);

                    $registration->save();

                    $barcodeGenerator = new DNS1D();
                    $barcode = $barcodeGenerator->getBarcodePNG($reg_ticket_no, 'C128', 3, 50); // scale: 3, height: 50

                    // $canvasWidth = 600;
                    // $canvasHeight = 800;
                    // $img = Image::canvas($canvasWidth, $canvasHeight, '#ffffff');
                    // if ($event->logo_file) {
                    //     $logoPath = public_path('app/' . $event->logo_file);
                    //     if (file_exists($logoPath)) {
                    //         $logoImage = Image::make($logoPath);
                    //         $logoWidth = $logoImage->width();
                    //         $logoHeight = $logoImage->height();

                    //         $maxLogoWidth = $canvasWidth * 0.6; // 80% dari lebar canvas
                    //         $maxLogoHeight = $canvasHeight * 0.6; // 80% dari tinggi canvas

                    //         $logoImage->resize($maxLogoWidth, $maxLogoHeight, function ($constraint) {
                    //             $constraint->aspectRatio();
                    //             $constraint->upsize(); // Mencegah pembesaran gambar lebih besar dari ukuran aslinya
                    //         });

                    //         $logoWidth = $logoImage->width();
                    //         $logoHeight = $logoImage->height();

                    //         $x = ($canvasWidth - $logoWidth) / 2;
                    //         $y = ($canvasHeight - $logoHeight) / 2;

                    //         $img->insert($logoImage, 'top-left', $x, $y);
                    //     }
                    // }
                    // $barcodeImage = Image::make(base64_decode($barcode));

                    // $maxBarcodeWidth = $canvasWidth * 0.8; 
                    // $barcodeImage->resize($maxBarcodeWidth, null, function ($constraint) {
                    //     $constraint->aspectRatio();
                    // });

                    // $barcodeWidth = $barcodeImage->width();
                    // $barcodeHeight = $barcodeImage->height();

                    // $xBarcode = ($canvasWidth - $barcodeWidth) / 2;
                    // $yBarcode = $canvasHeight - $barcodeHeight - 100; 

                    // $img->insert($barcodeImage, 'top-left', $xBarcode, $yBarcode);

                    // $fontSize = 30; 
                    // $yText = $yBarcode + $barcodeHeight + 10; 
                    // $img->text($reg_ticket_no, $canvasWidth / 2, $yText, function ($font) use ($fontSize) {
                    //     $font->file(public_path('fonts/Arial.ttf')); 
                    //     $font->size($fontSize);
                    //     $font->color('#000000');
                    //     $font->align('center');
                    //     $font->valign('top');
                    // });

                    // $fileName = 'event_' . $reg_ticket_no . '.png';
                    // $folderPath = storage_path('app/temp_images'); 

                    // if (!file_exists($folderPath)) {
                    //     mkdir($folderPath, 0755, true);
                    // }

                    // $tempFilePath = $folderPath . '/' . $fileName;

                    // // Save the image
                    // $img->save($tempFilePath);
                    // $uploadedFile = new UploadedFile(
                    //     $tempFilePath, // path ke file sementara
                    //     $fileName,     // nama file
                    //     'image/png',   // mime type
                    //     null,          // ukuran file (bisa null, Laravel akan menghitung otomatis)
                    //     true           // indikasi bahwa ini file yang valid
                    // );

                    // $fileExtension = $uploadedFile->clientExtension();
                    // $barcodeFileName = sprintf("%s.%s", 'barcode_' . $reg_ticket_no, $fileExtension);

                    // $filepath = $uploadedFile->storeAs('event/barcodes', $barcodeFileName);

                    // $registration->update(['barcode_file' => $filepath]);


                    $canvasWidth = 600;
                    $canvasHeight = 800;
                    $img = Image::canvas($canvasWidth, $canvasHeight, '#ffffff');

                    // Menambahkan logo
                    if ($event->logo_file) {
                        $logoPath = public_path('app/' . $event->logo_file);
                        if (file_exists($logoPath)) {
                            $logoImage = Image::make($logoPath);
                            $logoWidth = $logoImage->width();
                            $logoHeight = $logoImage->height();

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
                            $logoHeight = $logoImage->height();

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

                    // Posisi barcode lebih ke bawah dari teks nama dan tanggal
                    $xBarcode = ($canvasWidth - $barcodeWidth) / 2;
                    $yBarcode = $canvasHeight - $barcodeHeight - 150; // Naikkan sedikit untuk memberi ruang bagi teks nama dan tanggal

                    $img->insert($barcodeImage, 'top-left', $xBarcode, $yBarcode);

                    // Menambahkan teks nama dan tanggal registrasi

                    // Menambahkan teks "NAME" dengan bold
                    $img->text('NAME', $canvasWidth / 2, $yBarcode - 100, function ($font) {
                        $font->file(public_path('fonts/arial-bold.TTF')); // Menggunakan font bold
                        $font->size(22); // Ukuran font
                        $font->color('#000000');
                        $font->align('center');
                        $font->valign('top');
                    });

                    $registrationName = "I Gede Okta Budai assadas"; // Contoh nama registrasi
                    $img->text($registrationName, $canvasWidth / 2, $yBarcode - 70, function ($font) {
                        $font->file(public_path('fonts/arial.ttf')); // Menggunakan font biasa (non-bold)
                        $font->size(23); // Ukuran font
                        $font->color('#000000');
                        $font->align('center');
                        $font->valign('top');
                    });


                    // Menambahkan nomor barcode di bawah barcode
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
                        $tempFilePath, // Path ke file sementara
                        $fileName,     // Nama file
                        'image/png',   // MIME type
                        null,          // Ukuran file (dihitung otomatis oleh Laravel)
                        true           // Indikasi bahwa file valid
                    );

                    $fileExtension = $uploadedFile->clientExtension();
                    $barcodeFileName = sprintf("%s.%s", 'barcode_' . $reg_ticket_no, $fileExtension);

                    $filepath = $uploadedFile->storeAs('event/barcodes', $barcodeFileName);

                    // Update registrasi dengan path barcode
                    $registration->update(['barcode_file' => $filepath]);


                    return redirect()->back()->with('success', 'Registration successful. Your ticket has been sent via WhatsApp.');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors('Registration successful but failed to send WhatsApp message. Please contact support.');
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('There was an error processing your registration. Please try again later.');
        }
    }
}
