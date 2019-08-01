{{-- <div class="row">
    <div class="col-md text-center">
        <h2 id='snhead'>@isset($sn){{$sn}}@endisset</h2>
    </div>
</div> --}}
<div class="table-responsive-lg w-100 text-nowrap" style='min-height: 400px;overflow:auto'{{-- style="width: 100%;height: 410px;overflow:auto" --}}>
    <table class="table table-sm" id="datatable2">
        <thead >
            <tr>
                <th colspan="6">
                    <h2 id='snhead' class='text-center'>@isset($sn){{$sn}}@endisset</h2>
                </th>
            </tr>
            <tr class="text-center">
                <th>PN</th>
                <th class='border-right'>REEL ID</th>
                <th>PN</th>
                <th class='border-right'>REEL ID</th>
                <th>PN</th>
                <th>REEL ID</th>
            </tr>
        </thead>
        <tbody class='text-center'>
        @isset ($reels)
            @if (count($reels)>0)
                @foreach ($reels as $reel)                    
                    @foreach ($reel as $item => $prop)
                        @if ($loop->iteration % 3 == 1)
                            <tr>
                                <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
                                <td class='border-right'>{{$prop['RID']}}</td>
                        @elseif($loop->iteration % 3 == 0)
                                <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
                                <td>{{$prop['RID']}}</td>
                            </tr>
                        @else
                                <td>{{App\Http\Controllers\MES\model\Component::where('id',$item)->pluck('product_number')->first()}}</td>
                                <td class='border-right'>{{$prop['RID']}}</td>
                        @endif
                    @endforeach
                    <tr>
                        @for ($i = 0; $i <= 6; $i++)
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