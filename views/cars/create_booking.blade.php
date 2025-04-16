@extends('layouts.app')

@section('title', 'Создать заявку на бронирование')

@section('content')
<div class="container">
    <h1>Забронировать {{ $car->brand }} {{ $car->model }}</h1>

    <form action="{{ route('cars.storeBooking') }}" method="POST">
        @csrf
        <input type="hidden" name="car_id" value="{{ $car->id }}">

        <div class="mb-3">
            <label for="booking_date" class="form-label">Дата бронирования</label>
            <input type="date" class="form-control" id="booking_date" name="booking_date" required>
            @error('booking_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Отправить заявку</button>
    </form>
</div>
@endsection
