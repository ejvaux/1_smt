@extends('layouts.app4')

@section('js')    
    <script src="{{ asset('js/scan/auto.js')}}" defer></script>
@endsection

@section('title')    
    AUTO SCAN - SMT SYSTEM
@endsection

@section('content')
<audio id="e_sound">
    <source src="{{asset('sounds/ce.mp3')}}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<audio id="s_sound">
    <source src="{{asset('sounds/sn.mp3')}}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
<div class="container">
    <div class="white_bkg">
        <div class="row mb-3">
            <div class="col-md-8">
                @include('pages.autoscan.configCard')
            </div>
            <div class="col-md">
                @include('pages.autoscan.logCard')
            </div>
        </div>
    </div>
</div>
@endsection
