@extends('mes.layouts.app')
@section('tabs')
    <ul class="navbar-nav nav-tabs mr-auto mt-1" id="tb">
        <li><a id="tb1" class="nav-link tbl" href="{{url('fl')}}">Feeder List</a></li>
        <li><a id="tb2" class="nav-link tbl active" href="{{url('cl')}}">Components</a></li>
        {{-- <li><a id="tb3" class="nav-link tbl" href="{{url('lm')}}">Line - Machine Structure</a></li>
        <li><a id="tb4" class="nav-link tbl" href="{{url('el')}}">Employees</a></li> --}}
    </ul>
@endsection
@section('content')
    <div class="container-fluid mt-5" id="table_display" style="width: 100%;">
        <div class="row mb-2">
            <div class="col-md">
                <div class="btn-group" role="group" aria-label="Basic example">
                    {{-- <a class="btn btn-secondary" href='/1_atms/public/it/aq'>Handled</a> --}}
                    <button id='addComponent' class="btn btn-outline-secondary" href='#'><i class="fas fa-plus"></i> New Component</button>      
                </div>
            </div>
            {{-- <div class="col-md-3 ml-0 pl-1 ">
                <form>
                    <div class="input-group">                    
                        <input type="text" class="form-control" id="searchtextbox" placeholder="Search model . . .">
                        <button type="button" value="" id="search"><i class="fa fa-search"></i></button>
                    </div>               
                </form>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-md text-center w-100">
                @include('mes.inc.messages')
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 py-0 mr-0 text-center" >
                {{-- <h1>MODEL - PARTS TEST PAGE</h1> --}}                
                @include('mes.inc.table.clTable')
            </div>
        </div>
    </div>
    @include('mes.inc.modal.clModal')
@endsection