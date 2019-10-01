<table class="table table-sm">
    <thead >
        <tr class="text-center">
            <th>RID</th>
            <th>SN</th>
            <th>MACHINE</th>
            <th>TABLE</th>
            <th>FEEDER</th>
            <th>POSITION</th>
        </tr>
    </thead>                        
    <tbody class='text-center'>
        @foreach ($serials as $serial)
            @php
                $matcomp = App\Models\Matcomp::where('id',$serial->mat_comp_id)->pluck('materials')->first();
                foreach ($matcomp as $key => $value) {
                    if($key == $serial->component_id){
                        $mach = $value['machine'];
                        $fdr = $value['feeder'];
                        $pos = App\Http\Controllers\MES\model\Position::where('id',$value['position'])->pluck('name')->first();
                        break;
                    }
                }
            @endphp
            @foreach ($serial->sn as $sn)                
                <tr>
                    <td>{{$reel}}</td>
                    <td>{{$sn}}</td>
                    <td>{{CustomFunctions::getmachcode($mach)}}</td>
                    <td>{{CustomFunctions::getmachtable($mach)}}</td>
                    <td>{{$fdr}}</td>
                    <td>{{$pos}}</td>
                </tr>
            @endforeach            
        @endforeach
    </tbody>
</table>