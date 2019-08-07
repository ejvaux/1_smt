@isset ($sns)
    <div class="row text-center">
        <div class="col-md">
            <h4>SERIAL NUMBERS</h4>
        </div>
        <div class="col-md">
            <h4>TOTAL : @isset($sntotal){{$sntotal}}@endisset</h4>
        </div>
        {{-- <div class="col-md">
            <h4>@isset($sntotal){{$sntotal}}@endisset</h4>
        </div> --}}
    </div>
@endisset
<div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'>
    <input id="reelhead" type="hidden" value="@isset($reel){{$reel}}@endisset">
    <table class="table table-sm">
        {{-- <thead >
            <tr class="text-center">
                <th>TOTAL :</th>
                <th>@isset($sntotal){{$sntotal}}@endisset</th>
            </tr>
        </thead> --}}
        <tbody class='text-center'>
        @isset ($sns)
            @if (count($sns)>0)
                @foreach ($sns as $sn)
                    @if ($loop->iteration % 6 == 1)
                            <tr>
                                <td>{{$sn}}</td>
                        @elseif($loop->iteration % 6 == 0)
                                <td>{{$sn}}</td>
                            </tr>
                        @else
                                <td>{{$sn}}</td>
                    @endif
                @endforeach
            @else
                <h4 class="text-center">No data to display</h4>
            @endif
        @else
            <h4 class="text-center">No data to display.</h4>
        @endisset
        </tbody>
    </table>
</div>