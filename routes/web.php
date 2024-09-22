<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
// Route::get('/eventssss', [\App\Http\Controllers\Guest\RegistrationEventController::class,  'stores'])->name('events.register');

Route::middleware('auth')->prefix('/management-panel')->group(function () {
    Route::redirect("/", "/management-panel/dashboard");
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('attendance', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('attendance');
    Route::post('scan', [\App\Http\Controllers\Admin\AttendanceController::class, 'scan'])->name('attendance.scan');
    Route::get('profile', [\App\Http\Controllers\Admin\UserProfileController::class, 'index'])
        ->name('profile.index');
    Route::put('profile', [\App\Http\Controllers\Admin\UserProfileController::class, 'update'])
        ->name('profile.update');
    Route::resource('events', \App\Http\Controllers\Admin\ManagementEventsController::class)->except('show');
    Route::resource('registration', \App\Http\Controllers\Admin\ManagementRegisController::class);
});

Route::get('/_db-migrate', function () {
    Artisan::call('migrate:fresh --seed');

    return response('SUCCESS');
});

Route::get('/_symlink', function () {
    Artisan::call('storage:link');

    return response('SUCCESS');
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
