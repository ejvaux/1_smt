@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/scan/sp.js')}}" defer></script>
@endsection

@section('title')    
    SCAN - SMT SYSTEM
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
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row mb-3">
            {{-- LEFT PANEL --}}
            <div class="col-md-8">              
                @include('includes.scan.lpanel')            
            </div>
            {{-- Right Panel --}}
            <div class="col-md-4">
                @include('includes.scan.rpanel')
            </div>
        </div>
        {{--Bottom Panel --}}
        {{-- <div class="row">
            <div class="col-md">
                @include('includes.scan.bpanel')
            </div>
        </div> --}}
    </div>
</div>
@endsection
