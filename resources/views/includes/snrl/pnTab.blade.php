<div class="row mb-3">
    <div class="col-md-3">
        <input type="text" class="form-control form-control-sm" id="pnTB" name="" placeholder="Enter P/N Here . . .">
    </div>
    {{-- <div class="col-md-3">
        <form method="get" action="{{url('exportpn')}}">
            <input id="pnExport" type="hidden" name="pn">
            <button id="pnexportBtn" type="submit" class="btn btn-primary form-control" style='display:none'>Export</button>
        </form>
    </div> --}}
    <div class="col-md-3">
        <label id='pnhead1' class="font-weight-bold" style="font-size:1.5rem"></label>
    </div>   
</div>
<div id="pnTableDiv">
    @include('includes.table.pnTable')
</div>