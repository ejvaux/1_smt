<div class="table table-responsive text-nowrap">
    <table class="table" id="">
        <thead class="text-center">
            @isset($model_id)
            <h3>Program: {{App\Http\Controllers\MES\model\Modname::where('id',$model_id)->value('program_name')}}</h3>
            @endisset            
            <tr><th colspan="12"><h4>Feeder List</h4></th></tr>
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
                                    @if( $qty - $total * $feeder->usage < 0 )
                                        <td class="text-danger font-weight-bold">
                                    @else
                                        <td>
                                    @endif
                                    {{$qty - $total * $feeder->usage}}</td>
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

<div class="table table-responsive text-nowrap">
    <table class="table" id="">
        <thead class="text-center">
            <tr><th colspan="9"><h4>Mat Comp</h4></th></tr>
            <tr>
                <th>#</th>
                <th>Component</th>
                <th>Machine</th>
                <th>Table</th>
                <th>Feeder</th>
                <th>Position</th>
                <th>Feed Time</th>
                <th>Reel ID</th>
                <th>Reel Q'ty</th>
            </tr>
        </thead>
        <tbody class='text-center'>
            @isset($f)
                @if (count($f->materials) > 0)
                    @foreach ($f->materials as $ff)
                        @php
                            $machine = App\Http\Controllers\MES\model\Machine::where('code',CustomFunctions::getmachcode($ff['machine']))->first();
                            $line = App\Http\Controllers\MES\model\Line::where('id',$machine->line_id)->pluck('line_name_id')->first();
                            $table = CustomFunctions::getmachtable($ff['machine']);
                            $machid = $machine->machine_type_id;                            
                            $feeder = App\Http\Controllers\MES\model\Feeder::where('model_id',$f->model_id)
                                                                    ->where('line_id',$line)
                                                                    ->where('machine_type_id',$machid)
                                                                    ->where('table_id',$table)
                                                                    ->where('mounter_id',$ff['feeder'])
                                                                    ->where('pos_id',$ff['position'])
                                                                    ->first();
                            /* if (isset($ff['feedTime'])) {
                                $ft = $ff['feedTime'];
                            }
                            else{
                                $ft = App\MatLoadModel::where('id',$ff['matload_id'])->pluck('created_at')->first();
                            } */
                            if(isset($ff['matload_id'])){
                                $ft = App\MatLoadModel::where('id',$ff['matload_id'])->pluck('created_at')->first();
                            }
                            else{
                                $ft = 'wala';
                            }
                        @endphp
                        @if ($feeder)
                            <tr>
                        @else
                            <tr class="bg-danger">
                        @endif                       
                                               
                            <td>{{$loop->iteration}}</td>
                            <td>{{App\Http\Controllers\MES\model\Component::where('id',$ff['component_id'])->value('product_number')}}</td>
                            <td>{{CustomFunctions::getmachcode($ff['machine'])}}</td>
                            <td>{{CustomFunctions::getmachtable($ff['machine'])}}</td>
                            <td>{{$ff['feeder']}}</td>
                            <td>{{$ff['position']}}</td>
                            <td>{{$ft}}</td>
                            <td>{{$ff['RID']}}</td>
                            <td>{{$ff['QTY']}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="9">
                            <h3>NO DATA TO DISPLAY</h3>
                        </th>
                    </tr>
                @endif
            @else
                <tr>
                    <th colspan="9">
                        <h3>NO DATA TO DISPLAY</h3>
                    </th>
                </tr>
            @endisset
        </tbody>
    </table>
</div>

{{-- <div class="table table-responsive text-nowrap">
    <table class="table" id="">
        <thead class="text-center">
            <tr><th colspan="9"><h4>Mat Load</h4></th></tr>
            <tr>
                <th>#</th>
                <th>Component</th>
                <th>Machine</th>
                <th>Table</th>
                <th>Mounter</th>
                <th>Position</th>
                <th>Feed Time</th>
                <th>Reel ID</th>
                <th>Reel Q'ty</th>
            </tr>
        </thead>
        <tbody class='text-center'>
            @isset($mm)
                @if (count($mm) > 0)
                    @foreach ($mm as $m)                     
                        <tr>              
                            <td>{{$loop->iteration}}</td>                            
                            <td>{{$m->component_rel->product_number}}</td>
                            <td>{{$m->machine->code}}</td>
                            <td>{{$m->table_id}}</td>
                            <td>{{$m->mounter_id}}</td>
                            <td>{{$m->pos_id}}</td>
                            <td>{{$m->created_at}}</td>
                            <td>{{CustomFunctions::getQrData($m->ReelInfo,'RID')}}</td>
                            <td>{{CustomFunctions::getQrData($m->ReelInfo,'QTY')}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th colspan="9">
                            <h3>NO DATA TO DISPLAY</h3>
                        </th>
                    </tr>
                @endif
            @else
                <tr>
                    <th colspan="9">
                        <h3>NO DATA TO DISPLAY</h3>
                    </th>
                </tr>
            @endisset
        </tbody>
    </table>
</div> --}}