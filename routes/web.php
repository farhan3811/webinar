<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController; // Pastikan ini sudah dibuat
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

Route::get('registration', [RegistrationController::class, 'showForm']);
Route::post('registration', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
    Route::put('admin/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
});
Route::get('admin/scan-qr', [AdminController::class, 'scanQr'])->name('admin.scanQr');
Route::post('admin/check-in/{nim}', [AdminController::class, 'checkIn'])->name('admin.checkIn');
Route::get('admin/scan-qr', [AdminController::class, 'scanQr'])
    ->middleware('auth')
    ->name('admin.scanQr');
    Route::get('/datamahasiswa', [AdminController::class, 'dataMahasiswa'])
    ->middleware('auth')
    ->name('datamahasiswa');
    Route::put('/admin/update-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
    Route::get('/admin/details/{id}', [AdminController::class, 'showDetails'])->name('admin.details');
    Route::get('/admin/export-excel', [AdminController::class, 'exportExcel'])->name('admin.exportExcel');
    Route::get('/gambar/{filename}', function ($filename) {
        $path = storage_path('app/images/' . $filename);
    
        if (!file_exists($path)) {
            abort(404);
        }
    
        $file = file_get_contents($path);
        $type = mime_content_type($path);
    
        return response($file)->header("Content-Type", $type);
    });
require __DIR__.'/auth.php';
