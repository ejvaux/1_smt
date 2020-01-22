<table class="table">
    <thead>
        <tr>
            <th class="w-50">LOCATION</th>
            <th class="w-50">DATE CODE</th>
        </tr>
    </thead>
    <tbody class='text-center'>
        @isset($locs)
            @if (count($locs) > 0)
                @foreach ($locs as $loc)
                    <tr>
                        <td>
                            {{\App\Models\Location::where('id',$loc['location_id'])->first()->name}}
                        </td>
                        <td>
                            <input class="form-control locs" type="text" name="" data-location_id="{{$loc['location_id']}}" placeholder="Insert Date Code">
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th colspan="2"><h4>No data to display.</h4></th>
                </tr> 
            @endif
        @else
            <tr>
                <th colspan="2"><h4>No data to display.</h4></th>
            </tr>            
        @endisset
    </tbody>
</table>