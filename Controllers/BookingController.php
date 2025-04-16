<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BookingController extends Controller
{
    public function index()
{
    $bookings = Booking::with('car')
        ->where('user_id', Auth::id())
        ->orderByDesc('created_at')
        ->get();

    $cars = Car::all();

    return view('bookings', compact('bookings', 'cars'));
}

public function store(Request $request)
{
    $request->validate([
        'car_id' => 'required|exists:cars,id',
        'booking_date' => 'required|date|after_or_equal:today',
    ]);

    $exists = Booking::where('car_id', $request->car_id)
        ->where('booking_date', $request->booking_date)
        ->whereIn('status', ['pending', 'approved'])
        ->exists();

    if ($exists) {
        return back()->withErrors(['booking_date' => 'Автомобиль уже забронирован на эту дату.']);
    }

    Booking::create([
        'user_id' => Auth::id(),
        'car_id' => $request->car_id,
        'booking_date' => $request->booking_date,
        'status' => 'pending',
    ]);

    return back()->with('success', 'Заявка создана и ожидает подтверждения.');
}
}
