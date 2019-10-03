<table class="table table-sm">
    <thead >
        <tr class="text-center">
            <th>SN</th>
            <th>RID</th>
            <th>PN</th>
            <th>DATETIME</th>
            <th>PROGRAM</th>
            <th>MACHINE</th>
            <th>TABLE</th>
            <th>FEEDER</th>
            <th>POSITION</th>
        </tr>
    </thead>                        
    <tbody class='text-center'>
    @foreach ($reels as $reel)
        @foreach ($reel->materials as $re => $r)                      
            <tr>
                <td>{{$sn}}</td>
                <td>{{$r['RID']}}</td>
                <td>{{App\Http\Controllers\MES\model\Component::where('id',$re)->pluck('product_number')->first()}}</td>                          
                <td>{{App\MatLoadModel::where('ReelInfo','LIKE','RID:'.$r['RID'].'%')->pluck('created_at')->first()}}</td>                
                <td>{{App\modelSMT::where('id',$reel->model_id)->pluck('program_name')->first()}}</td>
                <td>{{CustomFunctions::getmachcode($r['machine'])}}</td>
                <td>{{CustomFunctions::getmachtable($r['machine'])}}</td>
                <td>{{$r['feeder']}}</td>
                <td>{{App\Http\Controllers\MES\model\Position::where('id',$r['position'])->pluck('name')->first()}}</td>
            </tr>
        @endforeach
    @endforeach
    {{-- @foreach ($reel as $item => $prop)
        <tr>
            <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
            <td class='border-right'>{{$prop['RID']}}</td>
            <td>{{CustomFunctions::getmachcode($prop['machine'])}}</td>
            <td>{{CustomFunctions::getmachtable($prop['machine'])}}</td>
            <td>{{App\Http\Controllers\MES\model\Position::where('id',$prop['position'])->pluck('name')->first()}}</td>
            <td>{{$prop['feeder']}}</td>
        </tr>
    @endforeach --}}
    </tbody>
</table>

