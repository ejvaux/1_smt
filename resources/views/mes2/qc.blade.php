@extends('mes2.layouts.app')
@section('tabs')
    <script>
        $('#tab1').addClass('active');
    </script>
@endsection
@section('content')

<!-- Start add Modal -->
<div class="modal fade  bd-example-modal-lg" id="modalqc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Quality Management - SMT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>

<div class="modal-body">


    <!-- Body of Modal Modal -->
    <h6>Lot Number:</h6> <strong><h6 ><input type="text" id="idlot" class="text" disabled style=" text-align: center;" ></h6></strong>

      {{--Start TABLE --}}
      <div class="container border-fluid p-0 mb-2 border-secondary"  style="overflow-x:auto;">
        
    </div>
    <div class="container-fluid p-0" style="overflow-x:auto;">
     <div class="col p-0 border-fluid">
            <div class="row ">
                    <div class="col-md-6 mr-auto mt">
                       
                        <form class="formGetPcb" method="POST" action='{{url('tracking/')}}'>
                            @csrf
                            @method('GET')
                            
                            {{-- <input type="Text" class="form-control mb-2" name="myInputPCB" placeholder="Search PCB Here" autocomplete="off"> --}}
                            
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
                                    <th>LOT_ID</th>
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
                                                <td>{{$pcb->lot_id}}</td>
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
{{-- End Table --}}


    <!-- End Body of Modal Modal -->

</div>
</div>
</div>
</div>
<!-- End add Modal -->

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
                                                                {{--  Search From Date --}}
                                                                <div class="col-md-6 mr-auto">
                                                                    <form class="formGetqc"  id="formGetqc" method="POST" action='{{url('qcs/')}}'>
                                                                        @csrf
                                                                        @method('GET')
                                                                                <input type="date" name ="Dateqc" class="date" data-date-format="yyyy/mm/dd" > <button type="submit"  class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal">Search</button>
                                                                    </form>
                                                                </div>
                                                                {{--  End Search From Date--}}


                                                                {{--  Search From Lot--}}
                                                                <div class="col-md-6">
                                                                    <form class="formGetqcl" method="POST" id="formGetqcl" action='{{url('qcl/')}}'>
                                                                        @csrf
                                                                        @method('GET')
                                                                            <input type="text" class="form-control" name="myInputLot" onkeyup="" placeholder="Search Lot Number Here" title="Type in a name" autocomplete="off">
                                                                    </form>
                                                                </div>
                                                                {{--  End Search From Lot--}}
                                                            
                                                        </div>
                                                     
                                                    <table  id = "myTable" class="table table-responsive table-hover table-reflow  {{-- table-bordered --}} mt-2" style="overflow-x:auto;">
                                                            <thead class="thead-dark" >
                                                            <tr>
                                                                <th >JUDGEMENT</th>
                                                                <th >LOT</th>
                                                                <th >JO NUMBER</th>
                                                                <th >STATUS</th>
                                                                <th >CREATED_BY</th>
                                                                <th >CREATED_AT</th>
                                                                <th >CLOSED_BY</th>
                                                                <th >CLOSED_AT</th>
                                                                <th >CHECKED_BY</th>
                                                              {{--  <th >JUDGEMENT</th> --}}
                                                                <th >CHECKED_AT</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if(count($Qcs) > 0)
                                                            @foreach($Qcs as $Qc)
                                                            <tr>   
                                                                <!-- Button FOR ACTIONS -->
                                                                <td>

                                                                        @if ($Qc->status == 0)
                                                                            <div class="div">
                                                                                <div class="row">
                                                                                    
                                                                                    <div class="col-md-12">
                                                                                            <h6><label for="" style="color: red;">This Lot is not available for QC.</label></h6>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        @elseif($Qc->status == 1 && $Qc->qc_status == 1 )
                                                                        <div class="div">
                                                                                <div class="row">
                                                                                    
                                                                                    <div class="col-md-12">
                                                                                        <h6><label for="" class="ml-5" style="color: green;  text-align: center;"><i class="far fa-check-circle"></i> GOOD.</label></h6>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                        @elseif($Qc->status == 1 && $Qc->qc_status == 2 )
                                                                        <div class="div">
                                                                                <div class="row">
                                                                                    
                                                                                    <div class="col-md-12">
                                                                                        <h6><label for="" class="ml-5" style="color: red;  text-align: center;"><i class="far fa-times-circle"></i> NO GOOD.</label></h6>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                        
        
                                                                        @else
                                                                        
                                            
                                                                        {{--      <div class="container-fluid" style="overflow-x:auto;" > --}}
                                                                            <div class="row mt-2">
                                                                                    
                                                                                <div class="col-md-6 mr-auto">
                                                                                    <form method="POST" id="qcGood" action='{{url('qcgood')}}'>
                                                                                    @csrf
                                                                                    @method('GET')
                                                                                    
                                                                                    {{-- <button type="button" class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal"><i class="far fa-plus-square"></i> New Data</button> --}}
                                                                                    <button type='button'  data-idqc='{{$Qc->id}}' class="btn btn-outline-success gbtn ml-5 btn-sm"><i class="far fa-check-circle"></i> Good</button>
                                                                                    <input type="hidden" class="text" value='{{$Qc->id}}'{{-- value="1" --}} name='id1'>
                                                                                    </form>
                                                                                </div>
                                                                                 
                                                                                
                                                                                <div class="col-md-6">
                                                                                    <form method="POST" id="qcnoGood"  action='{{url('qcnogood')}}'>
                                                                                    @csrf
                                                                                    @method('GET')
                                                                                  
                                                                                    <button type='button' data-idqc='{{$Qc->id}}' class="btn btn-outline-danger ngbtn ml-0 mr-10 btn-sm" ><i class="far fa-times-circle"></i> No Good</button>
                                                                                    <input type="hidden" class="text" value='{{$Qc->id}}' {{-- value="1" --}} name='id2'>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            
                                                                            {{--    </div> --}}
                                                                            
                                                                        @endif
                                                                       
                                                                    </td>
                                                                <td><strong>{{$Qc->number}}<button  type='button' data-idqc='{{$Qc->number}}' class="btn btn-outline-secondary ml-2 btn-sm showlot"  data-toggle="modal" data-target="#modalqc">View Data</button></strong></td>
                                                                <td><strong>{{$Qc->jo_id}}</strong></td>
                                                                <td><strong>
                                                                    @if ($Qc->status == 0)
                                                                    OPEN
                                                                    @else
                                                                    CLOSED
                                                                    @endif
                                                                </strong></td>
                                                                <td><strong>{{$Qc->employee_rel_create->fname}} {{$Qc->employee_rel_create->lname}}</strong></td>
                                                                <td><strong>{{$Qc->created_at}}</strong></td>
                                                                <td><strong>{{$Qc->employee_rel_close->fname}} {{$Qc->employee_rel_close->lname}}</strong></td>
                                                                <td><strong>{{$Qc->closed_at}}</strong></td>
                                                                <td><strong>{{$Qc->employee_rel_create->fname}} {{$Qc->employee_rel_close->lname}}</strong></td>                                          
                                                                <td><strong>{{$Qc->date}}</strong></td>                           
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