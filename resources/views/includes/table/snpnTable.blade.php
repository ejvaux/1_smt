<div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
    <input id='snpnhead' type="hidden" value="@isset($comp){{$comp}}@endisset" >    
    @isset ($snrids)    
        @if (count($snrids)>0)
        <table class="table table-sm" id="datatable2">
            <thead >
                <tr class="text-center">
                    <th>#</th>
                    <th>S/N</th>
                    <th>LINE</th>
                    <th>RID</th>
                </tr>
            </thead>
            <tbody class='text-center'>
                @foreach ($snrids as $rid => $r)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$rid}}</td>
                        <td>{{$r['line']}}</td>
                        <td>{{$r['RID']}}</td>
                    </tr>
                @endforeach            
            </tbody>
        </table>
        @else
            <h4 class='text-center'>No data to display</h4>
        @endif
    @else
        <h4 class='text-center'>No data to display</h4>
    @endisset    
</div>