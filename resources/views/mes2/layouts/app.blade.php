<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        @php
            include $_SERVER['DOCUMENT_ROOT']."/1_mes/_includes/header.php";
            if(isset($_SESSION['username'])){
                $username = $_SESSION['username'];
            }
            if(!($auth == 'A' || $auth == 'SA')) {          
                echo "<script type='text/javascript'>alert('Access Denied!');window.location.href='/1_mes/_php/portal.php';</script>";        
            }
            $user_num = $_SESSION['user_num'];
        @endphp
        <meta name="username" content="{{$username}}">
        <meta name="user_num" content="{{$user_num}}">{{-- @php echo $user_num; @endphp --}}
        <meta name="google" content="notranslate">
        <!-- Header start -->
        <title>SMT Master Database</title>
        @include('mes.inc.header')
        
    </head>

    <body>
    
        <!-- Navbar - START -->
            @php
                include $_SERVER['DOCUMENT_ROOT']."/1_mes/_includes/navbar.php";            
            @endphp
        <!-- Navbar - END -->

        <!-- Contents - START  -->

        <div style="position: absolute;margin-top: -14px;" id="innernavbar">
            <nav class="navbar navbar-brdr navbar-expand-xl navbar-light bg-light m-0 px-2 pb-1 pt-0" style="position:fixed;width: 100%; z-index:2; overflow:hidden;">
                <button class="navbar-toggler mt-1" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <span class="navbar-toggler-icon"></span> -->MENU <i class="fas fa-caret-down"></i>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    
                    @include('mes.inc.tabs2')
                    @yield('tabs')
                            
                <!-- ICONS ON LEFT -->
                @php
                    include $_SERVER['DOCUMENT_ROOT']."/1_mes/_includes/tab_navbar.php";            
                @endphp
                <!-- ICONS ON LEFT END -->

                </div>  
            </nav>
        </div>
        <div id="app2">
            @yield('content')
        </div>
        <div class="mdl" style='z-index: 1'><!-- Place at bottom of page --></div>

        <!-- Contents - END-->        
    </body>
</html>