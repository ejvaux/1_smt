@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/tracking/ml.js')}}" defer></script>
@endsection

@section('title')    
    Material List - SMT SYSTEM
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            {{-- <div class="col-md"></div> --}}
            <div class="col-md">
                <div class="card">
                    <div class="card-header">                        
                        <h5>Material List</h5>
                    </div>
                    <div class="card-body">   
                        @include('includes.tracking.mllPanel')
                    </div>
                </div>
            </div>
            {{-- <div class="col-md"></div> --}}
        </div>
    </div>
</div>
@endsection
