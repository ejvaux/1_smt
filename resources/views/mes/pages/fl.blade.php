@extends('mes.layouts.app')
@section('tabs')
    <ul class="navbar-nav nav-tabs mr-auto mt-1" id="tb">
        <li><a id="tb1" class="nav-link tbl active" href="{{url('fl')}}">Feeder List</a></li>
        <li><a id="tb2" class="nav-link tbl" href="{{url('cl')}}">Components</a></li>
        {{-- <li><a id="tb3" class="nav-link tbl" href="{{url('lm')}}">Line - Machine Structure</a></li>
        <li><a id="tb4" class="nav-link tbl" href="{{url('el')}}">Employees</a></li> --}}
    </ul>
@endsection
@section('content')
    <div class="container mt-5" id="table_display" style="width: 100%;">
        <div class="row mb-2">
            <div class="col-md">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button id='add_model_button' class="btn btn-outline-info py-0 p-1">Add Model</button>
                </div>
            </div>
            <div class="col-md-3 ml-0 pl-1 ">
                <form method="get" action="{{url('fl')}}">
                    <div class="input-group">                        
                        <input type="text" class="form-control" id="" name="text" placeholder="Search model . . .">
                        <button type="submit" class='btn btn-outline-secondary' id=""><i class="fa fa-search"></i></button>                                            
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                @include('mes.inc.messages')
            </div>
        </div>
        <div class="row">
            <div class="col-md" >
                @include('mes.inc.table.flTable')
            </div>
        </div>
    </div>
    @include('mes.inc.modal.modModal')
@endsection