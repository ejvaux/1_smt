@extends('mes2.layouts.app')
@section('tabs')
    <script>
        $('#tab1').addClass('active');
    </script>
@endsection

@if (session('alert'))
    <div class="alert alert-success">
        {{ session('alert') }}
    </div>
@endif
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
                                                                {{--  Search From Date --}}
                                                                <div class="col-md-6 mr-auto">
                                                                    <form class="formGetqc" method="POST" action='{{url('qcs/')}}'>
                                                                        @csrf
                                                                        @method('GET')
                                                                                <input type="date" name ="Dateqc" class="date" data-date-format="yyyy/mm/dd" > <button type="submit"  class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal">Search</button>
                                                                    </form>
                                                                </div>
                                                                {{--  End Search From Date--}}


                                                                {{--  Search From Lot--}}
                                                                <div class="col-md-6">
                                                                    <form class="" method="POST" action='{{url('qcl/')}}'>
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
                                                              {{--   <th >JUDGEMENT</th> --}}
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
                                                                                            <h5><label for="" class="ml-5" style="color: green;  text-align: center;"><i class="far fa-check-circle"></i> GOOD.</label></h5>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                        @elseif($Qc->status == 1 && $Qc->qc_status == 2 )
                                                                        <div class="div">
                                                                                <div class="row">
                                                                                    
                                                                                    <div class="col-md-12">
                                                                                            <h5><label for="" class="ml-5" style="color: red;  text-align: center;"><i class="far fa-times-circle"></i> NO GOOD.</label></h5>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                        
        
                                                                        @else
                                                                        
                                            
                                                                        {{--      <div class="container-fluid" style="overflow-x:auto;" > --}}
                                                                            <div class="row mt-2">
                                                                                    
                                                                                <div class="col-md-4 mr-auto">
                                                                                        <form method="post" id="DeleteProcessForm_{{$Qc->id}}"  action='{{url('qc/'.$Qc->id)}}'>
                                                                                                @csrf
                                                                                                @method('DELETE')      
                                                                                    {{-- <button type="button" class="btn btn-outline-primary mb-1" data-toggle="modal" data-target="#addProcessModal"><i class="far fa-plus-square"></i> New Data</button> --}}
                                                                                    <button type='button'  data-id='{{$Qc->id}}' class="btn btn-outline-success editProcess ml-2"><i class="far fa-check-circle"></i> Good</button>
                                                                                </form>
                                                                                </div>
                                                                                 
                                                                                
                                                                                <div class="col-md-7">
                                                                                    <button type='button' class="btn btn-outline-danger del_process_btn ml-1 " data-id='{{$Qc->lot_id}}'><i class="far fa-times-circle"></i> No Good</button>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            
                                                                            {{--    </div> --}}
                                                                            
                                                                        @endif
                                                                       
                                                                    </td>
                                                                <td><strong>{{$Qc->number}}</strong></td>
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
                                                               {{--  <td><strong>
                                                                        @if ($Qc->qc_status == 0)
                                                                        PENDING
                                                                        @elseif($Qc->qc_status == 1)
                                                                        GOOD
                                                                        @else
                                                                        NO GOOD 
                                                                        @endif
                                                                </strong></td> --}}
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