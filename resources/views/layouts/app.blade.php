<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('img/logo-ies-playamar.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Custom pastel style -->
    <style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #e8eaf6, #b3e5fc); /* Degradado morado y azul pastel */
        font-family: 'Inter', 'Segoe UI', sans-serif;
        color: #ffffff; /* Blanco para texto que contrasta bien con el azul */
    }



    #app {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    main {
    background: linear-gradient(135deg, #e8eaf6, #b3e5fc); /* Degradado morado y azul pastel */
    padding: 2rem;
    /* border-radius: 16px; */
    /* box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); */
}



    .navbar {
        background: linear-gradient(90deg, #6a1b9a, #1976d2, #2e7d32);
        padding: 0.8rem 1.5rem;
        color: #ffffff;
    }

    .navbar-brand, .nav-link {
        color: #ffffff !important;
        font-weight: 600;
    }
    .dropdown-item{
        color:rgb(0, 182, 55);
    }

    .nav-link:hover, .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        border-radius: 8px;
    }

    .btn-success {
        background: linear-gradient(to right, #2e7d32, #66bb6a);
        border: none;
        font-weight: 600;
        color: white;
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-success:hover {
        filter: brightness(1.1);
    }

    .btn-primary {
        background: linear-gradient(to right, #6a1b9a, #8e24aa);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
    }

    .btn-primary:hover {
        filter: brightness(1.1);
    }
    .btn-warning {
        background: linear-gradient(to right, #f9a825, #fdd835); /* amarillo dorado a claro */
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
        transition: filter 0.2s ease-in-out;
    }

    .btn-warning:hover {
        filter: brightness(1.1);
    }

    .btn-danger {
        background: linear-gradient(to right, #c62828, #ef5350); /* rojo oscuro a coral */
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
        transition: filter 0.2s ease-in-out;
    }

    .btn-danger:hover {
        filter: brightness(1.1);
    }

    .btn-secondary {
        background: linear-gradient(to right, #455a64, #90a4ae); /* gris azulado oscuro a claro */
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
        transition: filter 0.2s ease-in-out;
    }

    .btn-secondary:hover {
        filter: brightness(1.1);
    }


    .alert-success {
        background-color: #e8f5e9;
        color: #2e7d32;
        border-left: 5px solid #66bb6a;
        border-radius: 8px;
        padding: 1rem;
    }

    .alert-danger {
        background-color: #fce4ec;
        color: #ad1457;
        border-left: 5px solid #f06292;
        border-radius: 8px;
        padding: 1rem;
    }

    .dropdown-menu {
        background-color:rgb(51, 0, 59);
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    img.rounded-circle {
        border: 3px solid #8e24aa;
    }



    .card {
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .form-control {
        background-color: #fdfdfd;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #7e57c2;
        box-shadow: 0 0 0 3px rgba(126, 87, 194, 0.2);
        outline: none;
    }

    footer {
        background-color: #eeeeee;
        padding: 1rem;
        text-align: center;
        color: #6c757d;
        border-top: 1px solid #dcdcdc;
        margin-top: auto;
    }
</style>





    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Livewire.on('cart-error', message => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('product-removed', () => {
            Livewire.emit('refreshCart');
        });
    });
</script>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo-ies-playamar.png') }}" alt="Logo" style="height: 40px; width: auto;">
                    <span>{{ __('Main Page') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if (optional(auth()->user())->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('panel') }}">{{ __('Panel') }}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('carts.index') }}">
                                <!-- @inject('cartService', 'App\Services\CartService')
                                Cart ({{ $cartService->countProducts() }}) -->
                                @livewire('cart-counter')
                            </a>
                        </li>
                        @if (auth()->check())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                            
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ asset(Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="rounded-circle" width="50px" height="50px" >
                                    <span class="caret">{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <div class="container-fluid">
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{  $error  }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    
</body>
</html>
