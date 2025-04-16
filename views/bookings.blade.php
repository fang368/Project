@extends('layouts.app')

@section('title', 'Мои заявки')

@section('content')
<h2 class="mb-4">Мои заявки</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Автомобиль</th>
            <th>Дата</th>
            <th>Статус</th>
        </tr>
    </thead>
    <tbody>
        @forelse($bookings as $booking)
        <tr>
            <td>{{ $booking->car->brand ?? 'Удалено' }}</td>
            <td>{{ $booking->booking_date }}</td>
            <td>
                @if($booking->status === 'pending')
                    <span class="badge bg-warning text-dark">Новое</span>
                @elseif($booking->status === 'approved')
                    <span class="badge bg-success">Подтверждено</span>
                @else
                    <span class="badge bg-danger">Отклонено</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="3">Заявок нет.</td></tr>
        @endforelse
    </tbody>
</table>

<hr>

<h3 class="mt-5">Новая заявка</h3>
<form method="POST" action="{{ route('bookings.store') }}">
    @csrf
    <div class="mb-3">
        <label for="car_id" class="form-label">Выберите автомобиль:</label>
        <select name="car_id" id="car_id" class="form-select" required>
            <option value="" disabled selected>-- выберите авто --</option>
            @foreach($cars as $car)
                <option value="{{ $car->id }}">{{ $car->brand }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="booking_date" class="form-label">Дата бронирования:</label>
        <input type="date" name="booking_date" id="booking_date" class="form-control" required min="{{ date('Y-m-d') }}">
    </div>
    <button type="submit" class="btn btn-primary">Забронировать</button>
</form>
@endsection
