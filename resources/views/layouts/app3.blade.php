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
    @yield('js')
</head>
<body>
    <div id="app">
        <div id="wait">
            <div class="wait_cont">
            <img src="{{ asset('images/loading3.gif')}}" class="loading_badge"><br>LOADING...<br>Please wait.
            </div>
        </div>        
        @include('includes.navbar')
        <main class="py-4">
            @yield('content')
        </main>        
        {{-- @include('includes.footer') --}}
        <div class="footer-copyright text-center py-3 text-muted"><span style='font-size:1.1rem'><!-- © --><i class="far fa-copyright"></i> 2019 Prima Tech Phils., Inc.</span>
            <br>Designed and built by:<br>
            <span class="font-italic font-weight-bold" style='font-size: 1.1rem'>Christian Paul V. Ferrer</span> and <span class="font-italic font-weight-bold" style='font-size: 1.1rem'>Edmund O. Mati Jr.</span>
    </div>
    </div>
</body>
</html>
