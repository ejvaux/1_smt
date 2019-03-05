@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
            <div class="card shadow-sm bg-white rounded">
                    <div class="card-header bold-text"><i class="fas fa-info-circle"></i> &nbspRECORD DETAILS</div>
                    <div class="card-body">
                        <div class="row text-center bold-text">
                            <div class="col-lg-2 vertical-center">RECORD ID:</div>
                            <div class="col-lg-4"><input type="text" class="form-control" readonly value="{{$data->id}}"></div>
                            <div class="col-lg-2 vertical-center">WORK ORDER #:</div>
                            <div class="col-lg-4"><input type="text" class="form-control" readonly value="{{$data->SapJONum}}"></div>
                            <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                            <div class="col-lg-2 vertical-center">PART CODE:</div>
                            <div class="col-lg-4"><input type="text" class="form-control" readonly value="{{$sapdetails->ItemCode}}"></div>
                            <div class="col-lg-2 vertical-center">PART NAME:</div>
                            <div class="col-lg-4"><input type="text" class="form-control" readonly value="{{$sapdetails->ProdName}}"></div>
                            <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                            <div class="col-lg-2">PROD LINE:</div>
                            <div class="col-lg-4">
                                <select class="select2" id="prodline_sel">
                                    <option value="">SELECT LINE</option>
                                @foreach ($pline as $pline_item)
                                    <option value="{{$pline_item->id}}"
                                        @if ($pline_item->id==$data->prodline_id)
                                            selected
                                        @endif
                                        >{{$pline_item->prodline_ini}}-{{$pline_item->prodline_name}}</option>
                                @endforeach 
                            </select>
                            </div>
                            <div class="col-lg-2">PROCESS NAME:</div>
                            <div class="col-lg-4">
                                <select class="select2" id="process_sel">
                                    <option value="">SELECT PROCESS</option>
                                @foreach ($processlist as $processlist_item)
                                    <option value="{{$processlist_item->id}}"
                                        @if ($processlist_item->id==$data->process_id)
                                        selected
                                    @endif
                                    >{{$processlist_item->process_ini}}&nbsp=&nbsp[{{$processlist_item->process_name}}]</option>
                                @endforeach
                        </select>
                            </div>
                            <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                            <div class="col-lg-2">MACHINE:</div>
                            <div class="col-lg-4">
                                <select class="select2 form-control" id="machine_sel" style="height:30px">
                                    <option>SELECT MACHINE</option>
                                   @foreach ($mcode as $mcode_item)
                                    <option value="{{$mcode_item->id}}"
                                        @if ($mcode_item->id==$data->machine_id)
                                        selected
                                    @endif
                                    >{{$mcode_item->machine_ini}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 vertical-center">SERIAL NUMBER:</div> 
                            <div class="col-lg-4"><input type="text" class="form-control" value="{{$data->serial_number}}"></div>
                            <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                            <div class="col-lg-12">
                                <button class="btn btn-success"><i class="fas fa-save"></i>&nbspSAVE</button>&nbsp
                                <button class="btn btn-danger" data-toggle="modal" data-target="#myModal"><i class="fas fa-trash-alt"></i>&nbspDELETE</button>&nbsp
                                <a href="/1_smt/public/scan" class="btn btn-primary"><i class="fas fa-ban"></i>&nbspCANCEL</a>&nbsp
                            </div>
                        </div>
                    </div>
            </div>



    </div>
</div>
@include('modal.adminpassword')
@endsection
