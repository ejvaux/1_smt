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
        <div class="row">
            <div class="col-md"></div>
            <div class="col-md-10">
                <div class="row mb-2">
                    <div class="col-md">
                        <div class="btn-group" role="group" aria-label="Basic example">                    
                            <a class="btn btn-outline-secondary py-0 p-1" href='{{url('fl')}}'><i class="fas fa-arrow-left"></i> Back</a>                
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">                        
                        @include('mes.inc.messages')
                    </div>
                </div>
                <div class="row">
                    <div class="col-md" >
                        <div class="card">
                            <div class="card-header">
                                <div class="col-md text-center">
                                    <h6 class='text-muted'>
                                        FEEDER UNIT LOCATION LIST
                                    </h6>
                                    <input id='mdl_id' type="hidden" name="" value="{{$model->id}}">
                                </div>                                                          
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-4">
                                                Model Name:
                                            </div>
                                            <div class="col-md-6">
                                                {{$model->code}}
                                            </div>
                                            <div class="col-md"></div>
                                        </div>                                         
                                    </div>
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md"></div>
                                            <div class="col-md-4">
                                                Version:
                                            </div>
                                            <div class="col-md-5">
                                                {{$model->version}}
                                            </div>
                                        </div>                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-4">
                                                Program Name:
                                            </div>
                                            <div class="col-md-6">
                                                {{$model->program_name}}
                                            </div>
                                            <div class="col-md"></div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md"></div>
                                            <div class="col-md-4">
                                                Last Updated:
                                            </div>
                                            <div class="col-md-5">
                                                {{$model->updated_at}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-4">
                                                Machine Name:
                                            </div>
                                            <div class="col-md-6">
                                                <div id="add_machine_input1">
                                                    @if (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->groupBy('machine_type_id')->count()>0)
                                                        <select name="" id="flviewmachine" value='{{$machid}}'>
                                                            {{-- <option value="">- Select Machine -</option> --}}
                                                            @foreach (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->groupBy('machine_type_id')->get() as $mach1)
                                                                @if ($mach1->machine_type_id == $machid)
                                                                    <option value="{{$mach1->machine_type_id}}" selected>{{$mach1->machinetype->name}}</option>
                                                                @else
                                                                    <option value="{{$mach1->machine_type_id}}">{{$mach1->machinetype->name}}</option>
                                                                @endif                                                            
                                                            @endforeach                                                    
                                                        </select>  
                                                    @endif                                                
                                                    <button id='add_mach' style='font-size:.8rem' title="Add Machine"><i class="fas fa-plus"></i> Machine</button>
                                                </div>                                                
                                                <div id="add_machine_input2" style='display:none'>
                                                    {{-- Adding machine Form --}}
                                                    <form id='add_machine_form' method='POST' action="{{url('feeders')}}">
                                                        <input id='model_id' type="hidden" name="model_id" value="{{$model->id}}">
                                                        <input id='table_id' type="hidden" name="table_id" value="0">
                                                        <input id='mounter_id' type="hidden" name="mounter_id" value="0">
                                                        <input id='pos_id' type="hidden" name="pos_id" value="0">
                                                        <input id='order_id' type="hidden" name="order_id" value="0">
                                                        <input id='component_id' type="hidden" name="component_id" value="0">
                                                        <input id='amupdated_by' type="hidden" name="user_id" value="">
                                                        <select id="addmachlist" name="machine_type_id">
                                                            <option value="">- Select Machine -</option>                                                    
                                                            @foreach ($machinetypes as $machinetype)
                                                                @foreach (\App\Http\Controllers\MES\model\Feeder::where('model_id',$model->id)->groupBy('machine_type_id')->get() as $mach2)
                                                                    @if ($machinetype->id == $mach2->machine_type_id)
                                                                        @php
                                                                            $chk = 1;
                                                                        @endphp
                                                                    @endif                                                            
                                                                @endforeach
                                                                @if ($chk == 0)
                                                                    <option value="{{$machinetype->id}}">{{$machinetype->name}}</option>
                                                                @else
                                                                    @php
                                                                        $chk = 0;
                                                                    @endphp
                                                                @endif
                                                            @endforeach                                                                                                       
                                                        </select><br>
                                                        <button type='button' id='insert_mach' style='color:green;font-size:.8rem;'><i class="fas fa-plus"></i> ADD</button>
                                                        <button type='button' id='cancel_mach' style='color:red;font-size:.8rem;'><i class="fas fa-ban"></i> CANCEL</button>
                                                    </form>
                                                </div>                                                
                                            </div>
                                            <div class="col-md"></div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md"></div>
                                            <div class="col-md-4">
                                                Updated by:
                                            </div>
                                            <div class="col-md-5">
                                                @if ($model->updated_by)
                                                    {{$model->updatedBy->USER_NAME}}
                                                @else
                                                    Error: No update user.
                                                @endif
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md">
                                        {{-- delete mounter form --}}
                                            <form class='form_to_submit' id='delmountform' method='POST' action='/1_smt/public/del_mount'>
                                                <input id='del_model_id' name='model_id' type="hidden" value="">
                                                <input id='del_machine_type_id' name='machine_type_id' type="hidden" value="">
                                                <input id='del_table_id' name='table_id' type="hidden" value="">
                                                <input id='del_mounter_id' name='mounter_id' type="hidden" value="">
                                                <input id='del_user_id' name='user_id' type="hidden" value="">
                                            </form>
                                        {{-- change mounter form --}}
                                            <form class='form_to_submit' id='chngemountform' method='POST' action='/1_smt/public/change_mount'>
                                                <input id='exc_model_id' name='model_id' type="hidden" value="">
                                                <input id='exc_machine_type_id' name='machine_type_id' type="hidden" value="">
                                                <input id='exc_table_id' name='table_id' type="hidden" value="">
                                                <input id='exc_mounter_id_from' name='mounter_id_from' type="hidden" value="">
                                                <input id='exc_mounter_id_to' name='mounter_id_to' type="hidden" value="">
                                                <input id='exc_user_id' name='user_id' type="hidden" value="">
                                            </form>
                                        {{-- transfer mounter form --}}
                                            <form class='form_to_submit' id='transfermountform' method='POST' action='/1_smt/public/transfer_mount'>
                                                <input id='trns_model_id' name='model_id' type="hidden" value="">
                                                <input id='trns_machine_type_id' name='machine_type_id' type="hidden" value="">
                                                <input id='trns_table_id' name='table_id' type="hidden" value="">
                                                <input id='trns_table_id_to' name='table_id_to' type="hidden" value="">
                                                <input id='trns_mounter_id' name='mounter_id' type="hidden" value="">
                                                <input id='trns_user_id' name='user_id' type="hidden" value="">
                                            </form>
                                        {{-- Delete components form --}}
                                            <form class='form_to_submit' id='del_cmpt' action="" method="post">
                                                @method('DELETE')  
                                                <input id='del_com_user_id' type="hidden" name='user_id' value="">                                                         
                                            </form>
                                        <div id="fltable">
                                            {{-- <h5>No selected machine.</h5> --}}
                                            <ul class="nav nav-pills mb-2">
                                                @for ($i = 1; $i <= \App\Http\Controllers\MES\model\MachineType::where('id',$machid)->pluck('table_count')->first(); $i++)
                                                    @if ($i == 1)
                                                        <li class="nav-item">
                                                            <a class="nav-link active" href="#tab{{$i}}" data-toggle="tab">Table {{$i}}</a>
                                                        </li> 
                                                    @else
                                                        <li class="nav-item">
                                                            <a class="nav-link " href="#tab{{$i}}" data-toggle="tab">Table {{$i}}</a>
                                                        </li>
                                                    @endif                                                                                                   
                                                @endfor
                                            </ul>
                                            @include('mes.inc.table.mach')
                                        </div>
                                    </div>    
                                </div>      
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div id="fdrmodl">
                    @include('mes.inc.modal.flModal')
                </div>                
            </div>
        </div>
    </div>
@endsection