<table class="table table-sm">
    <thead >
        <tr class="text-center">
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
        @foreach ($pcbs as $pcb)
            <tr>
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
    </tbody>
</table>