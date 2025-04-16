@extends('layouts.admin')

@section('title', 'Заявки')

@section('content')
    <h1>Все заявки</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Форма для фильтрации -->
    <form method="GET" action="{{ route('admin.bookings.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label for="status">Статус</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Все</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Ожидает</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Подтверждено</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Отклонено</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="date">Дата бронирования</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary mt-4">Фильтровать</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ФИО</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Автомобиль</th>
                <th>Дата бронирования</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->user->phone }}</td>
                    <td>{{ $booking->user->email }}</td>
                    <td>{{ $booking->car->brand }} {{ $booking->car->model }}</td>
                    <td>{{ $booking->booking_date }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                    <td>
                        @if($booking->status === 'pending')
                            <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking->id) }}">
                                @csrf
                                <button type="submit" name="status" value="approved" class="btn btn-success">Подтвердить</button>
                                <button type="submit" name="status" value="rejected" class="btn btn-danger">Отклонить</button>
                            </form>
                        @else
                            <span class="text-muted">Статус не изменен</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

 
        <!-- Пагинация -->
    <div class="d-flex justify-content-center">
        {{ $bookings->links('pagination::bootstrap-4') }}
    </div>


@endsection
