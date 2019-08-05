{{-- <div class="row mb-3">
    <div class="col-md">
        <div class="input-group">                        
            <input type="text" class="form-control" id="snTB" name="" placeholder="Scan Serial Number Here . . .">
        </div>
    </div>
</div> --}}
<div class="row mb-3">
    {{-- <div class="col-md-4">
        <label for="serial_number" class="col-form-label">Serial Number:</label>
        <input id="serial_number" class="form-control" type="text" value="" readonly>
    </div> --}}
    <div class="col-md-5">
        {{-- <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="">Serial Number: </span>
            </div>
            <input type="text" class="form-control" id="snTB" name="" placeholder="Scan Serial Number Here . . .">
        </div> --}}
        <input type="text" class="form-control" id="snTB" name="" placeholder="Scan Serial Number Here . . .">
    </div>
    <div class="col-md-3">
        <form method="get" action="{{url('exportreel')}}">
            <input id="serialExport" type="hidden" name="sn">
            <button id="exportBtn" type="submit" class="btn btn-primary form-control" style='display:none'>Export</button>
        </form>
    </div>
    <div class="col-md">
        <label id='snhead1' class="font-weight-bold" style="font-size:1.5rem"></label>
    </div>
</div>
{{-- <div class="row">
    <div class="col-md text-center">
        <h2 id='snhead'></h2>
    </div>
</div> --}}
<div id="sntTableDiv">
    @include('includes.table.sntTable')
</div>