<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="http://172.16.1.13:8000/">
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
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif --}}                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('sp')}}"><span class='font-weight-bold'>Scan</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('tracking')}}"><span class='font-weight-bold'>Tracking</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('ds')}}"><span class='font-weight-bold'>Defect</span></a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link bold-text" href="/1_smt/public/home"><i class="fas fa-home"></i> Home</a>
                    </li>
                    {{-- <li class="nav-item bold-text">
                        <a class="nav-link" href="{{url('sp')}}"><i class="fas fa-barcode"></i> Scan PCB</a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle bold-text" href="#" role="button" data-toggle="dropdown" >
                            <i class="fas fa-barcode"></i> Scan PCB <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">                                   
                            <a class="nav-link" href="{{url('sp')}}"><i class="fas fa-exchange-alt"></i> In/Out</a>
                            <a class="nav-link" href="{{url('tracking')}}"><i class="fas fa-search"></i> Tracking</a>                            
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle bold-text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-archive"></i> Materials <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">                                   
                            <a class="nav-link" href="{{url('mscan2')}}"><i class="fas fa-archive"></i> Scan Materials</a>
                            <a class="nav-link" href="{{url('ds')}}"><i class="fas fa-times-circle"></i> Defect Materials</a>
                            <a class="nav-link" href="{{url('errorlog')}}"><i class="fas fa-exclamation-circle"></i> Error Logs</a>
                        </div>
                    </li>
                    

                    <li class="nav-item bold-text">
                        <a class="nav-link" href="{{url('ep')}}"><i class="fas fa-download"></i>&nbspData Export</a>
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