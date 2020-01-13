<div class="table table-responsive text-nowrap">
    <table class="table" id="">
        <thead class="text-center">
            {{-- <tr><th colspan="9"><h4>Mat Comp</h4></th></tr> --}}
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
                <th>Action</th>
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
                            <tr class="border-left border-danger">
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

                            @if (!$feeder)
                                <td>
                                    <form id="matdelForm" action="">
                                        <input type="hidden" name='RID' value="">
                                    </form>
                                    <button class="btn btn-danger delMat mt-0">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            @endif 
                            
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