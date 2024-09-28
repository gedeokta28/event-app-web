<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Exports\RegistrationReport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [\App\Http\Controllers\Guest\EventController::class, 'index'])->name('guests.index');
// Route::get('/events/{id}', [\App\Http\Controllers\Guest\EventController::class, 'show'])->name('guests.event.detail');
Route::get('/events/{slug}', [\App\Http\Controllers\Guest\EventController::class, 'show'])->name('guests.event.detail');

Route::get('/management-panel/login', function () {
    return view('auth.login');
})->name('login-admin');

Route::post('/events/register', [\App\Http\Controllers\Guest\RegistrationEventController::class,  'store'])->name('events.register');

Route::get('/download-ticket/{filename}', function ($filename) {
    $filePath = public_path('app/event/barcodes/' . $filename);

    if (file_exists($filePath)) {
        return response()->download($filePath);
    } else {
        abort(404, 'File not found.');
    }
})->name('download.ticket');

Route::middleware('auth')->prefix('/management-panel')->group(function () {
    Route::redirect("/", "/management-panel/dashboard");
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('attendance', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('attendance');
    Route::get('attendance-tools', [\App\Http\Controllers\Admin\AttendanceController::class, 'scanTools'])->name('attendance-tools');
    Route::get('attendance-count', function () {
        return view('attendance.count');
    })->name('attendance.form');
    Route::get('show-total-attendance', function () {
        return view('attendance.show-total-attendance');
    })->name('attendance.total');
    Route::post('attendance-count', [\App\Http\Controllers\Admin\AttendanceController::class, 'countByDate'])->name('attendance.count');
    Route::get('attendance-count-json', [\App\Http\Controllers\Admin\AttendanceController::class, 'countByDateJson']);
    Route::post('scan', [\App\Http\Controllers\Admin\AttendanceController::class, 'scan'])->name('attendance.scan');
    Route::get('profile', [\App\Http\Controllers\Admin\UserProfileController::class, 'index'])
        ->name('profile.index');
    Route::put('profile', [\App\Http\Controllers\Admin\UserProfileController::class, 'update'])
        ->name('profile.update');
    Route::resource('events', \App\Http\Controllers\Admin\ManagementEventsController::class)->except('show');
    Route::resource('registration', \App\Http\Controllers\Admin\ManagementRegisController::class);
    //report
    Route::get('report-attendance', [\App\Http\Controllers\Admin\ReportController::class, 'attendance'])->name('report-attendance');
    Route::get('report-registration', [\App\Http\Controllers\Admin\ReportController::class, 'registration'])->name('report-registration');
    Route::get('download-registration-report', function (Request $request) {
        $status = $request->input('status', 'all'); // Ambil status dari input
        $eventId = $request->input('event_id');
        $eventName = $request->input('event_name');
        $date = \Carbon\Carbon::now()->format('Y-m-d');
        $fileName = "{$eventName}_registration_report_{$date}.xlsx";
        return Excel::download(new RegistrationReport($status, $eventId), $fileName);
    })->name('download.registration.report');
});

Route::get('/_db-migrate', function () {
    Artisan::call('migrate:fresh --seed');

    return response('SUCCESS');
});

Route::get('/_symlink', function () {
    Artisan::call('storage:link');

    return response('SUCCESS');
});


Route::get('/test-date', function () {
    // Mengambil tanggal dan waktu dari database
    $startDate = "2024-09-28 06:49:06";

    $wibDate = \Carbon\Carbon::parse($startDate)->setTimezone('Asia/Jakarta');

    // Jika Anda ingin mengubah formatnya
    $formattedWibDate = $wibDate->format('Y-m-d H:i');
    return response($formattedWibDate);
});

Route::get('/_clear-cache', function () {
    Artisan::call('optimize:clear');
    // Clear the config cache
    Artisan::call('config:clear');
    return response('Success');
});

Route::get('/_migrate', function () {
    Artisan::call('migrate');

    return response('Success');
});

// Route::get('/_dump-autoload', function () {
//     Artisan::call('dump-autoload');

//     return response('Success');
// });

Route::get('/clear-config-cache', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    return 'Config and cache cleared!';
});

Route::get('/updateapp', function () {
    Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});
