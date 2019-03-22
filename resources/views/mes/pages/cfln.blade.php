@extends('mes.layouts.app')
@section('tabs')
    <ul class="navbar-nav nav-tabs mr-auto mt-1" id="tb">
        <li><a id="tb1" class="nav-link tbl active" href="{{url('fl')}}">Feeder List</a></li>
        <li><a id="tb2" class="nav-link tbl" href="{{url('mp')}}">Model - Parts</a></li>
        <li><a id="tb3" class="nav-link tbl" href="{{url('lm')}}">Line - Machine Structure</a></li>
        <li><a id="tb4" class="nav-link tbl" href="{{url('el')}}">Employees</a></li>
    </ul>
@endsection
@section('content')
    <div class="container mt-5" id="table_display" style="width: 100%;">
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md-5">
                <div class="row mb-2">
                    <div class="col-md">
                        <div class="btn-group" role="group" aria-label="Basic example">                    
                            <a class="btn btn-outline-danger py-0 p-1" href='{{'cflh'}}'><i class="fas fa-ban"></i> Cancel</a>                
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Create New Feeder List
                            </div>
                            <div class="card-body">
                                <h1>New</h1>        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md"></div>
        </div>
    </div>
@endsection