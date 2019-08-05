<div class="row mb-3">
    <div class="col-md-5">
        <input type="text" class="form-control" id="reelTB" name="" placeholder="Scan Reel Here . . .">
    </div>
    <div class="col-md-3">
        <form method="get" action="{{url('exportreel')}}">
            <input id="reelExport" type="hidden" name="reel">
            <button id="reelexportBtn" type="submit" class="btn btn-primary form-control" style='display:none'>Export</button>
        </form>
    </div>
    <div class="col-md">
        <label id='reelhead' class="font-weight-bold" style="font-size:1.5rem"></label>
    </div>
</div>
<div id="reelTableDiv">
    @include('includes.table.reelTable')
</div>