<div class="row mb-1">
    <div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
        <table class="table" id="datatable2">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>DATE</th>
                    <th>PART NAME</th>
                    <th>WORK ORDER</th>
                    <th>JOB ORDER</th>
                    <th>LINE</th>
                    <th>QTY</th>
                    <th>REMAINING QTY</th>
                    <th>PART CODE</th>
                </tr>
            </thead>
            <tbody class='text-center'>
                @if (isset($jos))
                    @if (count($jos)>0)
                        @foreach ($jos as $jo)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <th>{{ $jo->DATE_ }}</th>
                                <td>
                                    @php
                                        if (strpos($jo->ITEM_NAME, ',') !== false) {
                                            $m = explode(",", $jo->ITEM_NAME);
                                            if($m[1] == 'Secure'){
                                                $mod = 'Main Board';
                                            }
                                            else{
                                                $mod = $m[1];
                                            }
                                        }
                                        else{
                                            $mod = $jo->ITEM_NAME;
                                        }
                                        echo $mod;
                                    @endphp
                                </td>
                                <td>{{ $jo->SALES_ORDER }}</td>
                                <td>{{ $jo->JOB_ORDER_NO }}</td>
                                <td>{{ $jo->MACHINE_CODE }}</td>
                                <td>{{ $jo->PLAN_QTY }}</td>
                                {{-- <td id='remcheckcol_{{$jo->ID}}'>
                                    <button id="{{$jo->ID}}" class="btn btn-outline-secondary py-0 remcheck">CALCULATE</button>
                                </td> --}}
                                <td>
                                    @php
                                        $aqty = \App\Models\Pcb::where('jo_id',$jo->ID)->where('type',1)->count();
                                        $rqty = $jo->PLAN_QTY - $aqty;
                                        echo $rqty;
                                    @endphp
                                </td>
                                <td>{{ $jo->ITEM_CODE }}</td>                                
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="9">
                                <h4>No data.</h4>
                            </th>
                        </tr>
                    @endif
                @else
                    <tr>
                        <th colspan="9">
                            <h4>No data.</h4>
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
{{-- @isset($jos)
    <div class='row'>
        <div class='col-md'>
            {!! $jos->appends(\Request::except('page'))->render() !!}
        </div>
    </div>
@endisset --}}
