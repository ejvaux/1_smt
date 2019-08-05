<div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'>
    <input id="reelhead" type="hidden" value="@isset($reel){{$reel}}@endisset">
    <table class="table table-sm" id="datatable2">
        <thead >
            <tr rowspan="6" class="text-center">
                <th>SERIAL NUMBERS</th>
            </tr>
        </thead>
        <tbody class='text-center'>
        @isset ($sns)
            @if (count($sns)>0)
                @foreach ($sns as $sn)                    
                    @foreach ($sn as $item => $prop)
                        @if ($loop->iteration % 6 == 1)
                            <tr>
                                <td>{{$item}}</td>
                        @elseif($loop->iteration % 6 == 0)
                                <td>{{$item}}</td>
                            </tr>
                        @else
                                <td>{{$item}}</td>
                        @endif
                    @endforeach
                    <tr>
                        @for ($i = 0; $i < 6; $i++)
                            <td></td>
                        @endfor
                    </tr>
                @endforeach
            @else
                <tr>
                    <th colspan="6">
                        <h4>No data to display</h4>
                    </th>
                </tr>
            @endif
        @else
            <tr>
                <th colspan="6">
                    <h4>No data to display.</h4>
                </th>
            </tr>
        @endisset
        </tbody>
    </table>
</div>