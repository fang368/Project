@extends('layouts.app')

@section('title', 'Автомобили')

@section('content')
<div class="container">
    <h1>Все автомобили</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($cars as $car)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                        <p class="card-text">
                            {{ $car->year }} | {{ $car->color }} | {{ $car->license_plate }}
                        </p>
                        <a href="{{ route('cars.createBooking', $car->id) }}" class="btn btn-primary">Забронировать</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
