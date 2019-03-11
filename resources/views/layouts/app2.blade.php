<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @include('includes.header')
    
</head>
<body>
    <div id="app">
        <div id="wait">
            <div class="wait_cont">
            <img src="{{ asset('images/loading3.gif')}}" class="loading_badge"><br>LOADING...<br>Please wait for a moment.
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="{{ asset('images/primatech-logo.png')}}" class="nav-badge">
                    {{-- <b>{{ config('app.name', 'Laravel') }}</b> --}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link bold-text" href="/1_smt/public/home"><i class="fas fa-home"></i>&nbspHome</a>
                            </li>
                            <li class="nav-item bold-text">
                                <a class="nav-link" href="/1_smt/public/scan"><i class="fas fa-barcode"></i>&nbspScan Item</a>
                            </li>
                            <li class="nav-item bold-text">
                                <a class="nav-link" href="{{url('/fl')}}"><i class="fas fa-list"></i> Feeder List</a>
                            </li>
                            <li class="nav-item bold-text">
                                <a class="nav-link" href="/1_smt/public/mscan"><i class="fas fa-archive"></i>&nbspMaterials</a>
                            </li>
                            
                            <li class="nav-item bold-text">
                                <a class="nav-link" href="#"><i class="fas fa-download"></i>&nbspData Export</a>
                        </li>
                            <li class="nav-item bold-text">
                                <a class="nav-link" href="#"><i class="fas fa-bell"></i>&nbspNotifications</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle bold-text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle"></i>&nbsp Account Settings <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <h1 class="dropdown-header">
                                        <b><i class="fas fa-id-badge"></i>&nbsp&nbspACCOUNT ID:</b>&nbsp{{Auth::user()->id}}<br>
                                        <b><i class="fas fa-user"></i>&nbsp&nbspUSER: </b>&nbsp{{ Auth::user()->name }}
                                    </h1>
                                    <a class="dropdown-item" href="#"><i class="fas fa-key"></i>&nbspChange Password</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>&nbsp{{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <input type="text" id="userid" value="{{Auth::user()->id}}" hidden>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
       
        <main class="py-4">
            @yield('content')
        </main>
        
        @include('includes.footer')
    </div>
</body>
</html>
