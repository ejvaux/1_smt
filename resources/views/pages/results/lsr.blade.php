@extends('layouts.app2')

@section('js')    
    {{-- <script src="{{ asset('js/lr/lr.js')}}" defer></script> --}}
@endsection

@section('title')    
    LINE SUMMARY - SMT SYSTEM
@endsection

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">                        
                        <h5>Line Summary Results</h5>
                    </div>
                    <div class="card-body">                        
                        {{-- @include('includes.lr.linepanel') --}}
                        <line-summary-component datenow="{{$date}}" :lines="{{$lines}}"></line-summary-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
