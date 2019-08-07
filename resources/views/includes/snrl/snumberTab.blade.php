<div class="row mb-3">
    <div class="col-md-3">
        <input type="text" class="form-control form-control-sm" id="snTB" name="" placeholder="Scan Serial Number Here . . .">
    </div>
    <div class="col-md-3">
        <form method="get" action="{{url('exportreel')}}">
            <input id="serialExport" type="hidden" name="sn">
            <button id="exportBtn" type="submit" class="btn btn-primary btn-sm form-control" style='display:none'>Export</button>
        </form>
    </div>
    <div class="col-md">
        <label id='snhead1' class="font-weight-bold" style="font-size:1.5rem"></label>
    </div>
</div>
<div id="sntTableDiv">
    @include('includes.table.sntTable')
</div>