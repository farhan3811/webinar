<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk pendaftaran
Route::get('registration', [RegistrationController::class, 'showForm']);
Route::post('registration', [RegistrationController::class, 'store'])->name('registration.store');

// Route untuk welcome page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [RegistrationController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::put('/approve/{id}', [AdminController::class, 'approve'])->name('approve');
        Route::get('/scan-qr', [AdminController::class, 'scanQr'])->name('scanQr');
        Route::post('/check-in/{nim}', [AdminController::class, 'checkIn'])->name('checkIn');
        Route::get('/details/{id}', [AdminController::class, 'showDetails'])->name('details');
        Route::put('/update-status/{id}', [AdminController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('exportExcel');
    });

    // Data mahasiswa
    Route::get('/datamahasiswa', [AdminController::class, 'dataMahasiswa'])->name('datamahasiswa');
});
Route::get('/admin/data-checkin', [AdminController::class, 'dataCheckIn'])->name('data-checkin');
// Route untuk gambar
Route::get('/gambar/{filename}', function ($filename) {
    $path = storage_path('app/images/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    $file = file_get_contents($path);
    $type = mime_content_type($path);

    return response($file)->header("Content-Type", $type);
});
Route::get('/admin/email-logs', [AdminController::class, 'emailLogs'])->name('admin.emailLogs');

// Include auth routes
require __DIR__ . '/auth.php';
