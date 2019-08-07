<div class="row mb-3">
    <div class="col-md-3">
        <input type="text" class="form-control form-control-sm" id="snpnTB" name="" placeholder="Enter S/N Here . . .">
    </div>
    <div class="col-md-3">
        <select class='select2 form-control' name="" id="snpnDD">
            <option value="">Select P/N</option>
            @foreach ($mats as $mat)
                @if ($mat->id != 0)
                    <option value="{{$mat->id}}">{{$mat->product_number}}</option>
                @endif                
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <form method="get" action="{{url('exportpn')}}">
            <input id="snpnExport" type="hidden" name="pn">
            <button id="pnexportBtn" type="button" class="btn btn-primary form-control" style='display:none'>Export</button>
        </form>
    </div>
    <div class="col-md-3">
        <label id='snpnhead1' class="font-weight-bold" style="font-size:1.5rem"></label>
    </div>   
</div>
<div id="snpnTableDiv">
    @include('includes.table.snpnTable')
</div>