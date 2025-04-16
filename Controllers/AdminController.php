<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['user', 'car'])
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->date, function ($query) use ($request) {
                return $query->whereDate('booking_date', $request->date);
            })
            ->paginate(2);  
    
        return view('admin.bookings.index', compact('bookings'));
    }
    

    public function updateStatus($id, Request $request)
    {
        $booking = Booking::findOrFail($id);

        // Проверяем, что статус можно изменить (только для "новых" заявок)
        if ($booking->status === 'pending') {
            $booking->status = $request->status;
            $booking->save();

            return redirect()->route('admin.bookings.index')->with('success', 'Статус заявки обновлен!');
        }

        return redirect()->route('admin.bookings.index')->with('error', 'Невозможно изменить статус!');
    }
}
