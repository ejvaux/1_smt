@extends('layouts.app3')

@section('js')
<script src="{{ asset('js/mes2/spsearch.js')}}" defer></script>
@endsection
@section('content')
<div class="container-fluid border mt-3 border-dark" style="overflow-x:auto;">
    <div class="card mt-3 border mb-3 border-secondary"style="overflow-x:auto;">
        <div class="card-header">
        <h5>SMT Component Tracker</h5>
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
                                        <form class="formGetComponent" method="POST" action='{{url('tc/')}}'>
                                            @csrf
                                            @method('GET')
                                            
                                            <input type="Text" class="form-control mb-2" name="myInputComponent" placeholder="Search Component Here" autocomplete="off" value="">
                                            
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
                                                   
                                                    <th scope="col">DATE</th>
                                                    <th scope="col">COMPONENT</th>
                                                    <th scope="col">VENDOR</th>
                                                    <th scope="col">MACHINE</th>
                                                    <th scope="col">MODEL</th>
                                                    <th scope="col">TABLE</th>
                                                    <th scope="col">MOUNTER</th>
                                                    <th scope="col">POSITION</th>
                                                    <th scope="col">EMPLOYEE</th>
                                                </tr>
                                            </thead>
                                            <tbody class='text-center'>
                                              {{--   @isset ($Pcbs) --}}
                                                    @if (count($Feeders)>0)
                                                        @foreach ($Feeders as $Feeder)
                                                            
                                                                <td>{{$Feeder->created_at}}</td>
                                                                <td>{{$Feeder->component_rel->product_number}}</td>
                                                                <td>{{$Feeder->component_rel->authorized_vendor}}</td>
                                                                <td>{{$Feeder->machine_rel->code}}</td>
                                                                <td>{{$Feeder->smt_model_rel->code}}</td>
                                                                <td>{{$Feeder->table_id}}</td>
                                                                <td>{{$Feeder->mounter_rel->code}}</td>
                                                                <td>{{$Feeder->smt_pos_rel->name}}</td>
                                                                <td>{{$Feeder->employee_rel->lname}} {{$Feeder->employee_rel->fname}}</td>

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

