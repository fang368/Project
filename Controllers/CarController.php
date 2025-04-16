<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    // Отображение списка всех автомобилей
    public function index()
    {
        $cars = Car::all(); // Получаем все автомобили
        return view('cars.index', compact('cars')); // Отправляем в Blade шаблон
    }

    // Страница для создания заявки
    public function createBooking($carId)
    {
        $car = Car::findOrFail($carId); // Получаем автомобиль по ID
        return view('cars.create_booking', compact('car')); // Передаем в шаблон
    }

    // Сохранение новой заявки
    public function storeBooking(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        // Проверка, занято ли авто в эту дату
        $exists = Booking::where('car_id', $request->car_id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['booking_date' => 'Этот автомобиль уже забронирован на эту дату.']);
        }

        // Создаем новую заявку
        Booking::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'booking_date' => $request->booking_date,
            'status' => 'pending',
        ]);

        return redirect()->route('cars.index')->with('success', 'Заявка на бронирование отправлена!');
    }
}
