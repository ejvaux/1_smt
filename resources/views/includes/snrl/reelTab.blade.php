<div class="row mb-3">
    <div class="col-md-3">
        <input type="text" class="form-control form-control-sm" id="reelTB" name="" placeholder="Scan Reel Here . . .">
    </div>
    <div class="col-md-3">
        <form method="get" action="{{url('exportrlsn')}}">
            <input id="reelExport" type="hidden" name="reel">
            <button id="reelexportBtn" type="button" class="btn btn-primary btn-sm form-control" style='display:none'>Export</button>
        </form>
    </div>
    <div class="col-md-3">
        <label id='reelhead1' class="font-weight-bold" style="font-size:1.5rem"></label>
    </div>   
</div>
<div id="reelTableDiv">
    @include('includes.table.reelTable')
</div>