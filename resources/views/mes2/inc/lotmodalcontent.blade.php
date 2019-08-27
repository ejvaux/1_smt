@if (isset($sns))  
    <div class="row form-group">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    <span>Lot Number:</span>
                </div>
                <div class="col-md-7">
                    <input id="lot_number-modal" class='form-control' type="text" value="@isset($lot){{$lot}}@endisset" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    <span>S/N Total:</span>
                </div>
                <div class="col-md-7">
                    <input class='form-control' type="text" value="@isset($sns){{$sns->count()}}@endisset" readonly>
                </div>
            </div>                    
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            @include('mes2.table.lotsnTable')
        </div>
    </div>
@else
<div class="row form-group">
    <div class="col-md">
        <img src="http://172.16.1.13:8000/1_smt/public/images/loading2.gif" style="width:1rem;height:1rem;">
    </div>
</div>
<div class="row">
    <div class="col-md">
        <h3 class="text-center">PLEASE WAIT</h3>
    </div>
</div>    
@endif