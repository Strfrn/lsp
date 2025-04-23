<?php

use App\Http\Controllers\adminreservation;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\AdminReservationsController;
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'rooms'])->name('rooms');
Route::get('/rooms', [FrontendController::class, 'ruangan'])->name('ruangan');
Route::get('/contact', function () { return view('user.contact'); })->name('contact');
Route::get('/about', function () { return view('user.about'); })->name('about');
Route::get('/blog-single', function () { return view('user.blog-single'); })->name('blog-single');
Route::get('/blog', function () { return view('user.blog'); })->name('blog');


Route::middleware('auth')->group(function () {
    Route::resource('reservasii', ReservationsController::class);
    Route::get('detail', [ReservationsController::class, 'detail'])->name('detail');
    Route::get('/history', [ReservationsController::class, 'history'])->name('history');
    Route::get('/jkamar/{id}', [RoomTypeController::class, 'jkamar'])->name('kamar');
    Route::post('/bayar/{id}', [ReservationsController::class, 'pay'])->name('bayar');
    Route::post('/cancel/{id}', [ReservationsController::class, 'cancel'])->name('cancel');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - Hanya bisa diakses oleh admin
Route::prefix('dashboard')->middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/', [RoomTypeController::class, 'index'])->name('dashboard');

    Route::resource('jeniskamar', RoomTypeController::class)->parameters([
        'jeniskamar' => 'room_type'
    ]);

    Route::resource('kamar', RoomsController::class)->parameters([
        'kamar' => 'rooms'
    ]);

    Route::resource('laporan', LaporanController::class);
    Route::resource('reservasi', AdminReservationsController::class);
});

require __DIR__.'/auth.php';
