<div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
    <input id='snhead' type="hidden" value="@isset($sn){{$sn}}@endisset" >    
    @isset ($reels)
        @if (count($reels)>0)
            <table class="table table-sm" id="datatable2">
                <thead >
                    <tr class="text-center">
                        <th>#</th>
                        <th>WORK ORDER</th>
                        <th>SN</th>
                        <th>RID</th>
                        <th>PN</th>
                        <th>DATETIME</th>
                        <th>PROGRAM</th>
                        <th>MACHINE</th>
                        <th>TABLE</th>
                        <th>FEEDER</th>
                        <th>POSITION</th>
                        <th>JOB ORDER</th>
                        <th>EMPLOYEE</th>
                    </tr>
                </thead>
                <tbody class='text-center'>
                    @php
                        $c = 1;                        
                    @endphp
                @foreach ($reels as $reel)
                    @php
                        /* $created = App\Models\Pcb::where('serial_number',$sn)->where('mat_comp_id',$reel->id)->where('type',0)->pluck('created_at')->first(); */
                        if(!$pcb = App\Models\Pcb::with(['employee'])->select('work_order','jo_number','employee_id','created_at','jo_id')->where('serial_number',$sn)->where('mat_comp_id',$reel->id)->first()){
                            $pcb = App\Models\PcbArchive::with(['employee'])->select('work_order','jo_number','employee_id','created_at','jo_id')->where('serial_number',$sn)->where('mat_comp_id',$reel->id)->first();
                        }
                        if(!$pcb->work_order){
                            $wot = \App\Models\WorkOrder::where('ID',$pcb->jo_id)->pluck('SALES_ORDER')->first();
                        }
                        else{
                            $wot = $pcb->work_order;
                        }
                    @endphp
                    @foreach ($reel->materials as $re => $r)              
                        <tr>
                            <td>{{$c++}}</td>
                            <td>{{$wot}}</td>
                            <td>{{$sn}}</td>
                            <td>{{$r['RID']}}</td>
                            <td>{{App\Http\Controllers\MES\model\Component::where('id',$re)->pluck('product_number')->first()}}</td>                            
                            {{-- <td>{{App\MatLoadModel::where('ReelInfo','LIKE','RID:'.$r['RID'].'%')->pluck('created_at')->first()}}</td> --}}
                            <td>{{$pcb->created_at}}</td>
                            <td>{{App\modelSMT::where('id',$reel->model_id)->pluck('program_name')->first()}}</td>
                            <td>{{CustomFunctions::getmachcode($r['machine'])}}</td>
                            <td>{{CustomFunctions::getmachtable($r['machine'])}}</td>
                            <td>{{$r['feeder']}}</td>
                            <td>{{App\Http\Controllers\MES\model\Position::where('id',$r['position'])->pluck('name')->first()}}</td>
                            <td>{{$pcb->jo_number}}</td>
                            <td>{{$pcb->employee->fname}} {{$pcb->employee->lname}}</td>
                        </tr>
                    @endforeach
                @endforeach
                {{-- @foreach ($reels as $item => $prop)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$sn}}</td>
                        <td>{{$prop['RID']}}</td>
                        <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
                        <td>{{App\Http\Controllers\MES\model\LineName::where('id',$prop['line'])->pluck('name')->first()}}</td>
                        <td>{{CustomFunctions::getmachcode($prop['machine'])}}</td>
                        <td>{{CustomFunctions::getmachtable($prop['machine'])}}</td>
                        <td>{{$prop['feeder']}}</td>
                        <td>{{App\Http\Controllers\MES\model\Position::where('id',$prop['position'])->pluck('name')->first()}}</td>
                    </tr>
                @endforeach --}}
                </tbody>
            </table>
        @else
            <h4 class='text-center'>No data to display</h4>
        @endif
    @else
        <h4 class='text-center'>No data to display</h4>
    @endisset    
</div>