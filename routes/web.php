<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('test');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('bookings', [AdminController::class, 'index'])->name('bookings.index');
    Route::post('bookings/{id}/update-status', [AdminController::class, 'updateStatus'])->name('bookings.updateStatus');
});


// Гостевые маршруты
Route::middleware('guest')->group(function () {
    Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
    
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index'); // Список всех автомобилей
    Route::get('/cars/{carId}/booking', [CarController::class, 'createBooking'])->name('cars.createBooking'); // Страница создания заявки
    Route::post('/cars/booking', [CarController::class, 'storeBooking'])->name('cars.storeBooking'); // Сохранение заявки
});




// Выход (для авторизованных)
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');