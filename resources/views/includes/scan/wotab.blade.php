<div class="row mt-2 mb-1">
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-3">
                <label for="" class="col-form-label bold-text">DATE:</label>
            </div>
            <div class="col-md-9">
                <input type="date" id="woDate" class="form-control" value='{{$date1}}'>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md">
                <div class="btn-group" role="group">
                    <button id="loadwotable" class="btn btn-primary"><i class="fas fa-sync-alt"></i> LOAD</button>
                    <button id='setWO' data-wodata='' class="btn btn-success d-none"><i class="fas fa-wrench"></i> SET</button>
                </div>
            </div>                                                
        </div>
    </div>
</div>
<div class="row mb-1">
    <div class="col-md">
            <span class='text-danger bold-text'>Work Orders are based on the selected division.</span>
    </div>
</div>
<div id='spTablediv'>
    @include('includes.table.spTable')
</div>