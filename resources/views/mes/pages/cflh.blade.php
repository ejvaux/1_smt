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
                            <a class="btn btn-outline-secondary py-0 p-1" href='{{'fl'}}'><i class="fas fa-arrow-left"></i> Back</a>                
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md" >
                        <div class="card">
                            <div class="card-header">
                                Feeder List
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md text-center">
                                        <a class='btn btn-outline-info' href="{{url('cfln')}}">Create New List</a>    
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-md text-center">
                                        <a class='btn btn-outline-info' href="{{url('cflv')}}">Create Version</a>
                                    </div>    
                                </div>        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md"></div>
        </div>
    </div>
@endsection