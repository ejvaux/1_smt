@isset ($pcbs)
    <div class="row text-center">
        <div class="col-md">
            <h4>TOTAL : {{count($pcbs)}}</h4>
        </div>
    </div>
@endisset
<div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'>
    <input id="reelhead" type="hidden" value="@isset($reel){{$reel}}@endisset">
    <table class="table table-sm">
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
        @isset ($pcbs)
            @if (count($pcbs)>0)
                @foreach ($pcbs as $pcb)
                    <tr>
                        <td>{{$c++}}</td>
                        <td>{{$pcb['wo']}}</td>
                        <td>{{$pcb['sn']}}</td>
                        <td>{{$pcb['rid']}}</td>
                        <td>{{$pcb['pn']}}</td>
                        <td>{{$pcb['dt']}}</td>
                        <td>{{$pcb['prog']}}</td>
                        <td>{{$pcb['mach']}}</td>
                        <td>{{$pcb['tb']}}</td>
                        <td>{{$pcb['fdr']}}</td>
                        <td>{{$pcb['pos']}}</td>
                        <td>{{$pcb['jo']}}</td>
                        <td>{{$pcb['emp']}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th colspan="13">
                        <h4 class="text-center">No data to display</h4>
                    </th>
                </tr>                
            @endif
        @else
            <tr>
                <th colspan="13">
                    <h4 class="text-center">No data to display</h4>
                </th>
            </tr> 
        @endisset
        </tbody>
    </table>
</div>