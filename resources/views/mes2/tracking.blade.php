@extends('layouts.app3')

@section('js')
<script src="{{ asset('js/mes2/spsearch.js')}}" defer></script>
@endsection

@section('title')    
    PCB TRACKING - SMT SYSTEM
@endsection

@section('content')
<div class="container-fluid border mt-3 border-dark" style="overflow-x:auto;">
    <div class="card mt-3 border mb-3 border-secondary"style="overflow-x:auto;">
        <div class="card-header">
            <h5>SMT Process Tracker</h5>
        </div>
        <div class="card-body">
            <div class="container-fluid border-secondary" id="table_display" style="width: 100%;"style="overflow-x:auto;">
                <div class="row mb-2">
                    <div class="col-md">
                        @include('inc.messages')
                        {{--Start TABLE --}}
                        <div class="container-fluid p-0" style="overflow-x:auto;">
                            <div class="col p-0 border-fluid">
                                <div class="row ">
                                    <div class="col-md-6 mr-auto mt">                                        
                                        <form class="formGetPcb" method="POST" action='{{url('tracking/')}}'>
                                            @csrf
                                            @method('GET')                                            
                                            <input type="Text" class="form-control mb-2" name="myInputPCB" placeholder="Search PCB Here" autocomplete="off">
                                        </form>                                        
                                    </div>
                                </div>
                                @include('mes2.table.pcbtrackingTable')
                                <div class="row mb-1 text-center">
                                    <div class="col-md">
                                        <h3>- - - DEFECT ENTRY - - -</h3>
                                    </div>
                                </div>
                                @include('mes2.table.pcbdtrackingTable')
                            </div>
                        </div>
                        {{-- End Table --}}                    
                    </div>
                </div>
            </div>
        </div>
@endsection

