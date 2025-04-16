<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-car-front-fill"></i> Эх, прокачу!
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="bi bi-house-door"></i> Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cars"><i class="bi bi-car-front"></i> Автомобили</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/bookings"><i class="bi bi-calendar-check"></i> Мои бронирования</a>
                    </li>
                    @endauth
                    @auth
                    @if(auth()->user()->role_id === 1) <!-- Проверяем, что пользователь admin -->
                        <li class="nav-item">
                        <a class="nav-link text-danger" href="{{ route('admin.bookings.index') }}">
                                <i class="bi bi-shield-lock"></i> Админ-панель
                            </a>
                        </li>
                    @endif
                @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile"><i class="bi bi-person"></i> Профиль</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Выйти
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Регистрация</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>