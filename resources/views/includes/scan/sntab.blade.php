<div class="row mt-2 mb-1">        
    <div class="col-md-3">
        <button id='loadpcbtable' class='btn btn-primary'><i class="fas fa-sync-alt"></i> LOAD</button>
    </div>
    {{-- <div class="col-md-5">
        <input class='form-control' type="text" name="" id="searchpcbtable" placeholder="Scan Serial Number Here to Search">
    </div> --}}
    <div class="col-md">
        <span class='text-danger bold-text'>Serial numbers are based on the Configuration and selected Work Order.</span>
    </div>
</div>
<div class="row">
    <div class="col-md">
        <div id='pcbtable_div'>@include('includes.table.pcbTable')</div>        
    </div>
</div>