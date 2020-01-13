<div class="table table-responsive text-nowrap">
    <table class="table" id="">
        <thead class="text-center">                        
            {{-- <tr><th colspan="12"><h4>Feeder List</h4></th></tr> --}}
            <tr>
                <th>#</th>
                <th>Machine</th>
                <th>Table</th>
                <th>Feeder</th>
                <th>Position</th>
                <th class="border-right">Usage</th>
                <th>Feed Time</th>
                <th>Employee</th>
                <th>Component PN</th>
                <th>Reel ID</th>
                <th>Reel Q'ty</th>
                <th>Remaining Q'ty</th>
                {{-- <th>Feed Time</th>
                <th>Employee</th> --}}
            </tr>
        </thead>
        <tbody class='text-center'>
            @isset($feeders)
                @if (count($feeders) > 0)
                    @foreach ($feeders as $feeder)
                        @php
                            $lin = App\Http\Controllers\MES\model\Machine::where('machine_type_id',$feeder->machine_type_id)->pluck('line_id');
                            $mach = App\Http\Controllers\MES\model\Line::whereIN('id',$lin)->where('line_name_id',$feeder->line_id)->pluck('machine_id')->first();
                            $matload = App\MatLoadModel::where('model_id',$feeder->model_id)
                                                    ->where('machine_id',$mach)
                                                    ->where('table_id',$feeder->table_id)
                                                    ->where('mounter_id',$feeder->mounter_id)
                                                    ->where('pos_id',$feeder->pos_id)
                                                    ->latest('id')
                                                    ->first();
                            if($matload){
                                $rid = CustomFunctions::getQrData($matload->ReelInfo,'RID');
                                $qty = CustomFunctions::getQrData($matload->ReelInfo,'QTY');
                                $total = 0;
                                $serials = App\Models\MatSnComp::where('RID',$rid)->get();
                                $sns = [];
                                if($serials){
                                    foreach ($serials as $serial) {            
                                        foreach ($serial->sn as $s) {
                                            $sns[] = $s;
                                        }
                                    }
                                }
                                $total = count(array_unique($sns));
                            }                               
                        @endphp
                        
                        {{-- @if (!$matload)
                            <tr class="bg-warning">
                        @elseif( $qty - $total * $feeder->usage < 0 )
                            <tr class="bg-danger">
                        @else
                            <tr>
                        @endif --}}
                        <tr>                       
                            <td>{{$loop->iteration}}</td>
                            <td>{{App\Http\Controllers\MES\model\MachineType::where('id',$feeder->machine_type_id)->pluck('name')->first()}}</td>
                            <td>{{$feeder->table_id}}</td>
                            <td>{{App\Http\Controllers\MES\model\Mounter::where('id',$feeder->mounter_id)->pluck('code')->first()}}</td>
                            <td>{{App\Http\Controllers\MES\model\Position::where('id',$feeder->pos_id)->pluck('name')->first()}}</td>
                            <td class="border-right">{{$feeder->usage}}</td>                            
                            @if ($matload)
                                <td>{{$matload->created_at}}</td>
                                <td>{{$matload->employee_rel->fname}} {{$matload->employee_rel->lname}}</td>
                                <td>{{$matload->component_rel->product_number}}{{--  - {{$matload->id}} --}}</td>
                                <td>{{$rid}}</td>
                                <td>{{$qty}}</td>                                
                                @if ( $feeder->usage)
                                    @php
                                        $rem_qty = $qty - $total * $feeder->usage;
                                    @endphp
                                    @if( $rem_qty < 0 )
                                        <td class="text-danger font-weight-bold">
                                    @elseif( $rem_qty < $qty * .1 && $rem_qty > 0 )
                                        <td class="text-warning font-weight-bold">
                                    @else
                                        <td>
                                    @endif
                                    {{$rem_qty}}</td>
                                @else
                                    <td class="text-info font-weight-bold">No Usage</td>
                                @endif
                                
                            @else
                                <td colspan="6" class="b-0 pb-0"> <h3>* * * NO SCAN * * *</h3></td>
                            @endif                            
                            {{-- <td>{{$matload}}</td> --}}
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="12">
                            <h3>NO DATA TO DISPLAY</h3>
                        </th>
                    </tr>
                @endif
            @else
                <tr>
                    <th colspan="12">
                        <h3>NO DATA TO DISPLAY</h3>
                    </th>
                </tr>
            @endisset
        </tbody>
    </table>
</div>