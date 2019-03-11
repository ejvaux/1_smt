@extends('layouts.app2')

@section('content')
<div class="container-fluid">
    <div class="white_bkg">
        <div class="row">
            {{-- LEFT PANEL --}}
            <div class="col-lg-5">
                    <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bold-text"><i class="fas fa-barcode"></i> &nbspSCAN AREA</div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 vertical-center text-center bold-text">EMPLOYEE:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_employee">
                                                        <option value="">SELECT EMPLOYEE</option>
                                                        @foreach ($emp as $emp_item)
                                                         <option value="{{$emp_item->id}}">{{$emp_item->lname}}, {{$emp_item->fname}}</option>
                                                        @endforeach 
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">MODEL NAME:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_model">
                                                        <option value="" selected>SELECT MODEL</option>
                                                        @foreach ($models as $models_item)
                                                        <option value="{{$models_item->id}}">{{$models_item->code}}</option>
                                                        @endforeach 
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        {{-- <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">TABLE:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_table">
                                                        <option value="">SELECT TABLE</option>
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div> --}}
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">MACHINE CODE:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_machine" placeholder="INPUT MACHINE CODE" class="form-control" onkeypress="return event_mach(event)"></div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">POSITION:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_pos">
                                                        <option value="" selected>SELECT POSITION</option>
                                                        @foreach ($position as $position_item)
                                                        <option value="{{$position_item->id}}">{{$position_item->name}}</option>
                                                        @endforeach 
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">FEEDER SLOT#:</div>
                                        <div class="col-lg-7">
                                                <select class="select2" id="scan_feed_slot">
                                                        <option value="" selected>SELECT FEEDER #</option>
                                                        @foreach ($mounter as $mounter_item)
                                                        <option value="{{$mounter_item->id}}">{{$mounter_item->code}}</option>
                                                        @endforeach 
                                                </select>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-6  vertical-center text-center bold-text">
                                            <div class="form-check form-check-inline">
                                                <label for="inlineCheckbox1" class="form-check-label">FOR REPLENISHMENT? &nbsp</label>
                                                <input id="replenish" class="form-check-input" type="checkbox" data-toggle="toggle" data-on="YES" data-off="NO" data-offstyle="danger" onchange="IsReplenish()" checked>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <span style="font-size:0.8em"><b>NOTE:</b>Check this toggle button if you will load the same reel component/partname. 
                                                                This will require you to scan both reel barcodes.</span>
                                        </div>
                                        {{-- <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-6  vertical-center text-center bold-text">
                                            <div class="form-check form-check-inline">
                                                <label for="inlineCheckbox1" class="form-check-label">&nbsp&nbsp&nbsp&nbspUSE ALTERNATIVES? &nbsp</label>
                                                <input id="alt_items" class="form-check-input" type="checkbox" data-toggle="toggle" data-style="mr-1" data-on="YES" data-offstyle="danger" data-off="NO">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <span style="font-size:0.8em"><b>NOTE:</b>Check this toggle button if you will use alternative item components.</span>
                                        </div> --}}
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">LAST PRIMA PN:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_oldPN" placeholder="INPUT LAST PRIMA PN" class="form-control"  onkeypress="return event_lastPN(event)"></div>
                                        <div class="col-lg-2"></div>
                                        <div class="w-100 d-none d-md-block" style="margin-top:2%"></div>
                                        <div class="col-lg-3 vertical-center text-center bold-text">PRIMA PN TO LOAD:</div>
                                        <div class="col-lg-7"><input type="text" id="scan_newPN" placeholder="INPUT PRIMA PN TO LOAD" class="form-control" onkeypress="return event_loadPN(event)" ></div>
                                        <div class="col-lg-2"></div>
                                    </div>
                            </div>
                    </div>
            </div>
            {{-- RIGHT PANEL --}}
            <div class="col-lg-7">
                    <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bold-text"><i class="fas fa-info-circle"></i> &nbspSCAN DETAILS</div>
                            <div class="card-body">
                               
                                
                <div class="table-responsive-xl" style="width: 100%;height: 400px;overflow:auto">
                        <table class="table table-bordered table-hover table-sm table-striped" id="datatable2">
                                <thead class="thead-dark">
                                        <tr class="text-center">
                                                <th scope="col">DATE</th>
                                                <th scope="col">MACHINE</th>
                                                <th scope="col">MODEL</th>
                                                <th scope="col">TABLE</th>
                                                <th scope="col">MOUNTER</th>
                                                <th scope="col">POSITION</th>
                                                <th scope="col">COMPONENT</th>
                                                <th scope="col">AUTHOROZED VENDOR</th>
                                                <th scope="col">EMPLOYEE</th>
                                                
                                        </tr>
                                      </thead>
                                      <tbody>
                                            <tr style='height:100px'>
                                                <td colspan='9' class='text-center' style='font-size:1.5em'>
                                                    No data to display. Try to configure the scanning options then load data again.
                                                </td>
                                            </tr>
                                      </tbody>
                        </table>
                </div>



                            </div>
                    </div>
            </div>
        </div>
            



    </div>
</div>
@include('modal.employeepin')
@endsection
