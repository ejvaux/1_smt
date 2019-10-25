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
                        <th width='25%' colspan="2">PROCESS</th>
                        <th width='25%' colspan="2">BOTTOM</th>
                        <th width='25%' colspan="2">TOP</th>
                        <th width='25%'>ALL</th>
                    </tr>
                </thead>
                <tbody class='text-center'>
                    <tr>
                        <th width='25%' colspan="2">TYPE</th>
                        <th width='12.5%'>IN</th>
                        <th width='12.5%'>OUT</th>
                        <th width='12.5%'>IN</th>
                        <th width='12.5%'>OUT</th>
                        <th width='25%'>TOTAL</th>
                    </tr>
                    <tr>
                        <th width='12.5%' rowspan="2" style='vertical-align:middle;text-align:center;'>SHIFT</th>
                        <th width='12.5%'>DAY</th>
                        <td width='12.5%'>{{$dbi}}</td>
                        <td width='12.5%'>{{$dbo}}</td>
                        <td width='12.5%'>{{$dti}}</td>
                        <td width='12.5%'>{{$dto}}</td>
                        <td width='25%'>{{$dbi + $dbo + $dti + $dto}}</td>
                    </tr>
                    <tr>
                        <th width='12.5%'>NIGHT</th>
                        <td width='12.5%'>{{$nbi}}</td>
                        <td width='12.5%'>{{$nbo}}</td>
                        <td width='12.5%'>{{$nti}}</td>
                        <td width='12.5%'>{{$nto}}</td>
                        <td width='25%'>{{$nbi + $nbo + $nti + $nto}}</td>
                    </tr>
                    <tr>
                        <th width='25%' colspan="2">TOTAL</th>
                        <td width='12.5%'>{{$dbi + $nbi}}</td>
                        <td width='12.5%'>{{$dbo + $nbo}}</td>
                        <td width='12.5%'>{{$dti + $nti}}</td>
                        <td width='12.5%'>{{$dto + $nto}}</td>
                        <td width='25%'>{{$dbi + $dbo + $dti + $dto + $nbi + $nbo + $nti + $nto}}</td>
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
