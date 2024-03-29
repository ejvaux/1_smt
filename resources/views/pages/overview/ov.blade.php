@extends('layouts.app2')

@section('js')    
    <script src="{{ asset('js/overview/ov.js')}}" defer></script>
@endsection

@section('title')    
    Overview - SMT SYSTEM
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            {{-- <div class="col-md"></div> --}}
            <div class="col-md">
                <div class="card">
                    <div class="card-header">                        
                        <h5>Overview</h5>
                    </div>
                    <div class="card-body">                                                
                        @include('pages.overview.panels.ovPanel')
                    </div>
                </div>
            </div>
            {{-- <div class="col-md"></div> --}}
        </div>
    </div>
</div>
@endsection
