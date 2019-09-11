<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container-fluid">
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
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{url('sp')}}" target="_blank"><span class='font-weight-bold'>Scan</span></a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle bold-text" href="#" role="button" data-toggle="dropdown" >
                            Results <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="nav-link" href="{{url('lr')}}" target="_blank">Line</a>                             
                            <a class="nav-link" href="{{url('wor')}}" target="_blank">Work Order</a> 
                        </div>
                        {{-- <a class="nav-link" href="{{url('lr')}}" target="_blank"><span class='font-weight-bold'>Results</span></a> --}}
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle bold-text" href="#" role="button" data-toggle="dropdown" >
                            Tracking <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="nav-link" href="{{url('jo')}}" target="_blank">JO</a>                             
                            <a class="nav-link" href="{{url('tracking')}}" target="_blank">PCB</a>
                            <a class="nav-link" href="{{url('tc')}}" target="_blank">Component</a>
                            <a class="nav-link" href="{{url('pt')}}" target="_blank">Process</a>                              
                            {{-- <a class="nav-link" href="{{url('sr')}}" target="_blank">SN/Reel</a> --}}
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('ds')}}" target="_blank"><span class='font-weight-bold'>Defect</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('sr')}}" target="_blank"><span class='font-weight-bold'>SN/Reel</span></a>
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
                        <div class="dropdown-menu dropdown-menu-right font-weight-bold">                                   
                            <a class="nav-link" href="{{url('sp')}}">{{-- <i class="fas fa-exchange-alt"></i> --}} In/Out</a>
                            <a class="nav-link" href="{{url('tracking')}}">{{-- <i class="fas fa-search"></i> --}} Tracking</a>                                                      
                            <a class="nav-link" href="{{url('ds')}}">Defect</a>
                        </div>
                    </li>
                    {{-- <li class="nav-item bold-text">
                        <a class="nav-link" href="{{url('sp')}}"><i class="fas fa-barcode"></i> Scan PCB</a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle bold-text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-archive"></i> Materials <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right font-weight-bold" aria-labelledby="navbarDropdown">                                   
                            <a class="nav-link" href="{{url('mscan2')}}">{{-- <i class="fas fa-archive"></i> --}} Scan Materials</a>
                            <a class="nav-link" href="{{url('ds')}}">{{-- <i class="fas fa-times-circle"></i> --}} Defect Materials</a>
                            <a class="nav-link" href="{{url('errorlog')}}">{{-- <i class="fas fa-exclamation-circle"></i> --}} Error Logs</a>
                            {{-- <a class="nav-link" href="{{url('tc')}}"><i class="fas fa-search"></i> Component Tracking</a> --}}
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle bold-text" href="#" role="button" data-toggle="dropdown" >
                            <i class="fas fa-search"></i> Tracking <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right font-weight-bold">
                            <a class="nav-link" href="{{url('jo')}}">JO</a>                             
                            {{-- <a class="nav-link" href="{{url('tracking')}}">PCB</a>
                            <a class="nav-link" href="{{url('ds')}}">Defect PCB</a> --}}
                            <a class="nav-link" href="{{url('tc')}}">Component</a>                            
                            <a class="nav-link" href="{{url('sr')}}">SN/Reel</a>
                            <a class="nav-link" href="{{url('lr')}}">Line Results</a>
                        </div>
                    </li>

                    {{-- <li class="nav-item bold-text">
                        <a class="nav-link" href="{{url('ep')}}"><i class="fas fa-download"></i>&nbspData Export</a>
                    </li> --}}
                    {{-- <li class="nav-item bold-text">
                        <a class="nav-link" href="#"><i class="fas fa-bell"></i>&nbspNotifications</a>
                    </li> --}}
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