@extends('mes2.layouts.app')
@section('tabs')
    <script>
        $('#tab1').addClass('active');
    </script>
@endsection
@section('content')
@include('inc.messages')
<div class="container-fluid border mt-5 border-dark">
    <div class='row '>
        <div class="col-md">
                {{-- Start of code --}}

                <div class="card border-dark mt-3 mb-3 "  >
                    <div class="card-header">
                        <h5>Quality Management - SMT</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                      {{-- Code HERE --}}
                                    {{-- Tables --}}
                                    <div class="container-fluid mt-2" id="table_display" style="width: 100%;">
                                        <div class="row mb-2">
                                            <div class="col-md">
                                                        @include('inc.messages')
                                                    {{--   <h1>Hello World! -- Laravel TEST</h1> --}}
                                                {{--Start TABLE --}}
                                                <div class="container border-fluid p-0 mb-2">

                                                </div>
                                                <div class="container-fluid border " style="overflow-x:auto;">
                                                <div class="col p-0 border-fluid ">
                                                        <div class="row mt-2">
                                                                <div class="col-md-0 mr-auto">
                                                                    {{-- <button type="button" class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal"><i class="far fa-plus-square"></i> New Data</button> --}}
                                                                
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control" id="myInput" onkeyup="myFunctionTableDtr()" placeholder="Search Serial Number Here . . . " title="Type in a name">
                                                                </div>
                                                        </div>
                                                    <table  id = "myTable" class="table table-hover table-reflow  table-bordered mt-2" style="overflow-x:auto;">
                                                            <thead class="" >
                                                            <tr>
                                                                <th >ACTION</th>
                                                                <th >LOT</th>
                                                                <th >DIVISION ID</th>
                                                                <th >LINE_ID</th>
                                                                <th >SERIAL NUMBER</th>
                                                                <th >JO NUMBER</th>
                                                                
                                                                <th >CREATED_AT</th>
                                                                <th >UPDATED_AT</th>
                                        
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if(count($Pcbs) > 0)
                                                            @foreach($Pcbs as $Pcb)
                                                            <tr>   
                                                                <!-- Button FOR ACTIONS -->
                                                                <td>
                                                                        <form method="post" id="DeleteProcessForm_{{$Pcb->lot_id}}"  action='{{url('qc/'.$Pcb->lot_id)}}'>
                                                                            @csrf
                                                                            @method('DELETE')
                                        
                                                                    {{--      <div class="container-fluid" style="overflow-x:auto;" > --}}
                                                                        <div class="row mt-2">
                                                                            <div class="col-md-3 mr-auto">
                                                                                {{-- <button type="button" class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal"><i class="far fa-plus-square"></i> New Data</button> --}}
                                                                            </div>
                                                                            <div class="col-md-3 mr-auto">
                                                                                {{-- <button type="button" class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal"><i class="far fa-plus-square"></i> New Data</button> --}}
                                                                                <button type='button'  data-lot='{{$Pcb->lot_id}}'
                                                                                    data-serial='{{$Pcb->serial_number}}'
                                                                                    data-jonum='{{$Pcb->jo_number}}'
                                                                                
                                                                                    class="btn btn-outline-success editProcess"><i class="far fa-check-circle"></i> Good</button>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <button type='button' class="btn btn-outline-danger del_process_btn" data-id='{{$Pcb->lot_id}}'><i class="far fa-times-circle"></i> No Good</button>
                                                                            </div>
                                        
                                                                            <div class="col-md-3">
                                                                            
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        
                                                                        {{--    </div> --}}
                                                                        </form>
                                                                    </td>
                                                                <td><strong>{{$Pcb->lot_id}}</strong></td>
                                                                <td><strong>{{$Pcb->division_id}}</strong></td>
                                                                <td><strong>{{$Pcb->line_id}}</strong></td>
                                                                <td><strong>{{$Pcb->serial_number}}</strong></td>
                                                                <td><strong>{{$Pcb->jo_number}}</strong></td>
                                                                
                                                                <td><strong>{{$Pcb->created_at}}</strong></td>
                                                                <td><strong>{{$Pcb->updated_at}}</strong></td>                           
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            @else
                                            <p>No Posts Found</p>
                                            @endif
                                            {{--End TABLE  --}}
                                            </div>
                                        </div>
                                    </div>
                                    {{--End TABLE Sample  --}}
                    </ul>
                </div>
        </div>
    </div>    
</div>
@endsection