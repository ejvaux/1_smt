@extends('layouts.app3')

@section('js')
<script src="{{ asset('js/mes2/spsearch.js')}}" defer></script>
@endsection
@section('content')
<div class="container border mt-3 border-dark" style="overflow-x:auto;">
    <div class="card mt-3 border mb-3 border-secondary"style="overflow-x:auto;">
        <div class="card-header">
        SMT Process Tracker
        </div>
        <div class="card-body">
            
        <div class="container-fluid border-secondary" id="table_display" style="width: 100%;"style="overflow-x:auto;">
            <div class="row mb-2">
                <div class="col-md">
                            @include('inc.messages')
                          {{--   <h1>Hello World! -- Laravel TEST</h1> --}}
                    {{--Start TABLE --}}
                    <div class="container border-fluid p-0 mb-2 border-secondary"  style="overflow-x:auto;">
        
                    </div>
                
                    <div class="container-fluid p-0" style="overflow-x:auto;">
                     <div class="col p-0 border-fluid">
                            <div class="row ">
                                    <div class="col-md-6 mr-auto mt">
                                        {{-- <button type="button" class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal"><i class="far fa-plus-square"></i> New Data</button> --}}
                                        {{-- <button type='button' class="btn btn-outline-success mb-1 editProcess1"><i class="fa fa-edit"></i>Update Data</button> --}}
                                        {{-- <input type="text" class="form-control mb-2" id="myInputPCB" onkeyup="myFunctionTableDtr()" placeholder="Search Data Here..." title="Type in a name"> --}}
                                        <form class="formGetPcb" method="POST" action='{{url('tracking/')}}'>
                                            @csrf
                                            @method('GET')
                                            
                                            <input type="Text" class="form-control mb-2" name="myInputPCB" placeholder="Search PCB Here" autocomplete="off">
                                            
                                            {{-- <button type="submit">Get User</button><br> --}}
                                        </form>
                                      
                                    </div>
                                    <div class="col-md-4">
                                        {{-- <input type="text" class="form-control" id="myInput" onkeyup="myFunctionTableDtr()" placeholder="Search Data Here..." title="Type in a name"> --}}
                                        
                                    </div>
                            </div>

                            <div class="row mb-1">
                                    <div class="table-responsive-lg w-100 text-nowrap" style='max-height: 350px;overflow:auto'>
                                        <table class="table table-sm" id="">
                                            <thead class="thead-light">
                                                <tr class="text-center">
                                                   
                                                    <th>S/N</th>
                                                    <th>WORK ORDER</th>
                                                    <th>DIVISION</th>
                                                    <th>LINE</th>
                                                    <th>PROCESS</th>
                                                    <th>TYPE</th>
                                                    <th>EMPLOYEE</th>
                                                    <th>SHIFT</th>
                                                    <th>CREATED AT</th>
                                                </tr>
                                            </thead>
                                            <tbody class='text-center'>
                                              {{--   @isset ($Pcbs) --}}
                                                    @if (count($Pcbs)>0)
                                                        @foreach ($Pcbs as $pcb)
                                                            <tr {{-- class='wo-clickable-row' --}} data-wodata='{{$pcb}}'>
                                                                {{-- <td>{{ $loop->iteration + (($pcbs->currentPage() - 1) * 100) }}</td> --}}
                                                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                                                <td>{{$pcb->serial_number}}</td>
                                                                <td>{{$pcb->jo_number}}</td>
                                                                <td>{{$pcb->division->DIVISION_NAME}}</td>
                                                                <td>{{$pcb->line->name}}</td>
                                                                <td>{{$pcb->divprocess->name}}</td>
                                                                <td>
                                                                    @if ($pcb->type == 0)
                                                                        IN
                                                                    @else
                                                                        OUT
                                                                    @endif
                                                                </td>
                                                                <td>{{$pcb->employee->fname}} {{$pcb->employee->lname}}</td>
                                                                <td>{{$pcb->shift}}</td>
                                                                <td>{{$pcb->created_at}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <th colspan="10">
                                                                <h4>No data to display. </h4>
                                                            </th>
                                                        </tr>
                                                    @endif
                                                
                                                {{-- @endisset--}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    </div>
                </div>

             
            </div>
           
            
        </div>
    </div>
</div>
   


@endsection

