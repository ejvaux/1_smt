<div class="card">
    <div class="card-body">
@isset($pcbs)    
    <div class="row">
        <div class="col-md">
            <h5 class='text-center font-weight-bold'>{{$linename}}</h5>
        </div>
    </div>
    <div class="row mb-1">
        <div class="table-responsive-lg w-100 text-nowrap">
            <table class="table" id="">
                <thead>
                    <tr class="text-center">
                        <th width='20%' colspan="2">PROCESS</th>
                        <th width='20%' colspan="2">BOTTOM</th>
                        <th width='20%' colspan="2">TOP</th>
                        <th width='20%' colspan="2">DIP</th>
                        <th width='20%'>ALL</th>
                    </tr>
                </thead>
                <tbody class='text-center'>
                    <tr>
                        <th width='20%' colspan="2">TYPE</th>
                        <th width='10%'>IN</th>
                        <th width='10%'>OUT</th>
                        <th width='10%'>IN</th>
                        <th width='10%'>OUT</th>
                        <th width='10%'>IN</th>
                        <th width='10%'>OUT</th>
                        <th width='20%'>TOTAL</th>
                    </tr>
                    <tr>
                        <th width='10%' rowspan="2" style='vertical-align:middle;text-align:center;'>SHIFT</th>
                        <th width='10%'>DAY</th>
                        <td width='10%'>{{$dbi}}</td>
                        <td width='10%'>{{$dbo}}</td>
                        <td width='10%'>{{$dti}}</td>
                        <td width='10%'>{{$dto}}</td>
                        <td width='10%'>{{$ddi}}</td>
                        <td width='10%'>{{$ddo}}</td>
                        <td width='20%'>{{$dbi + $dbo + $dti + $dto + $ddi + $ddo}}</td>
                    </tr>
                    <tr>
                        <th width='10%'>NIGHT</th>
                        <td width='10%'>{{$nbi}}</td>
                        <td width='10%'>{{$nbo}}</td>
                        <td width='10%'>{{$nti}}</td>
                        <td width='10%'>{{$nto}}</td>
                        <td width='10%'>{{$ndi}}</td>
                        <td width='10%'>{{$ndo}}</td>
                        <td width='20%'>{{$nbi + $nbo + $nti + $nto + $ndi + $ndo}}</td>
                    </tr>
                    <tr>
                        <th width='20%' colspan="2">TOTAL</th>
                        <td width='10%'>{{$dbi + $nbi}}</td>
                        <td width='10%'>{{$dbo + $nbo}}</td>
                        <td width='10%'>{{$dti + $nti}}</td>
                        <td width='10%'>{{$dto + $nto}}</td>
                        <td width='10%'>{{$ddi + $ndi}}</td>
                        <td width='10%'>{{$ddo + $ndo}}</td>
                        <td width='20%'>{{$dbi + $dbo + $dti + $dto + $nbi + $nbo + $nti + $nto + $ddi + $ndi + $ddo + $ndo}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>        
@else
    <h3>NO DATA TO DISPLAY</h3>
@endif
    </div>
</div>
