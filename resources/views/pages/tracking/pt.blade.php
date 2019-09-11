@extends('layouts.app3')

@section('js')
<script src="{{ asset('js/tracking/pt.js')}}" defer></script>
@endsection

@section('title')    
    PCB PROCESS TRACKING - SMT SYSTEM
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
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">                        
                        <h5>PROCESS TRACKER</h5>
                    </div>
                    <div class="card-body">                        
                        @include('includes.tracking.ptPanel')
                    </div>
                </div>
            </div>
            <div class="col-md"></div>
        </div>
    </div>
</div>
@endsection

