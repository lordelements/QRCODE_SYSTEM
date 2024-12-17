<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\QrScanController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'verified', 'admin']);
// Route::get('admin/profile', [HomeController::class, 'edit'])->name('admin.profile.edit')->middleware(['auth', 'verified', 'admin']);


// Route::get('admin/profile/edit', [AdminController::class, 'edit'])->name('admin.profile.edit')->middleware(['auth', 'verified', 'admin']);
// Route::patch('admin/profile/update', [AdminController::class, 'update'])->name('admin.profile.update');
// Route::delete('admin/profile', [AdminController::class, 'destroy'])->name('admin.profile.delete');

Route::middleware('auth')->group(function () {
    Route::get('admin/profile/edit', [AdminController::class, 'edit'])->name('admin.profile.edit')->middleware(['auth', 'verified', 'admin']);
    Route::patch('admin/profile/update', [AdminController::class, 'update'])->name('admin.profile.update');
    Route::delete('admin/profile', [AdminController::class, 'destroy'])->name('admin.profile.delete');
});

Route::get('admin/index', [QRCodeController::class, 'index'])->name('admin.index');
Route::get('admin/show/{id}', [QRCodeController::class, 'show'])->name('admin.show');
Route::post('store/qr_code', [QRCodeController::class, 'store'])->name('store.qr_code');

Route::get('admin/{id}/download-qr-code', [QRCodeController::class, 'downloadQrCode'])->name('admin.download_qr_code');

Route::put('admin/update/{id}', [QRCodeController::class, 'update'])->name('admin.update');
Route::delete('admin/delete/{id}', [QRCodeController::class, 'destroy'])->name('admin.destroy');

Route::delete('/qr-code/force-delete/{id}', [QRCodeController::class, 'forceDeleteQrCode'])->name('qr-code.forceDelete');
Route::patch('/qr-code/restore/{id}', [QRCodeController::class, 'restoreQrCode'])->name('qr-code.restore');
Route::get('/qr-code/archive', [QRCodeController::class, 'archive'])->name('qr-code.archive');
Route::get('/qr-codes/archived', [QRCodeController::class, 'showArchived'])->name('qr-codes.archived');
Route::get('/qr-code/edit/{id}', [QRCodeController::class, 'editForm']);
Route::put('/qr-codes/update/{id}', [QRCodeController::class, 'update'])->name('qr-codes.update');

//  Routes for scanning
Route::get('/scan/{id}', [QrScanController::class, 'handleScan'])->name('qr-code.details'); // Routes for handling qrcodes scanned logs
Route::get('scanlog/index', [QrScanController::class, 'index'])->name('scanlog.index'); // Routes for showing qrcodes scanned logs
// Route::get('/scan/{id}', [QrScanController::class, 'showDetails'])->name('qr-code.details'); // Routes when qrcodes scanned it shows details
Route::delete('scan/delete/{id}', [QrScanController::class, 'destroy'])->name('scanlog.destroy');

// Route::post('/scan/process', [QrScanController::class, 'processScan'])->name('qr.process');
// Route::post('/scan', [QrCodeController::class, 'logScan'])->name('qr.logScan');
