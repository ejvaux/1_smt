{{-- Lot Number --}}
<div class="row mt-3 mb-2">
    <div class="col-md m-0 p-1">
        <button id='check_lot_num' class='btn btn-primary btn-sm bold-text w-100'>CHECK</button>
    </div>
    <div class="col-md m-0 p-1">
        <button id='create_lot_num' class='btn btn-primary btn-sm bold-text w-100' disabled>CREATE</button>
    </div>
    <div class="col-md m-0 p-1">
        <button id='close_lot_num' class='btn btn-warning btn-sm bold-text w-100' disabled>CLOSE</button>
    </div>
</div>
<div class="row mb-1"> 
    <div class="col-md">
        <div class="row">
            <div class="col-3">
                <label for="" class="col-form-label bold-text">LOT <i class="fas fa-hashtag"></i>:</label>                  
            </div>
            <div class="col-9">
                <input class='form-control' type="text" name="" id="lot_num" value="Check First." readonly>
            </div>
        </div>
    </div>                            
</div>
<div class="row mb-1"> 
    <div class="col-md">
        <div class="row">
            <div class="col-3">
                <label for="" class="col-form-label bold-text">TOTAL:</label>                  
            </div>
            <div class="col-9">
                <div class="input-group">
                    <input class='form-control' type="text" name="" id="lot_total" value='' readonly>
                    <button type="button" class='' id="get_lot_total"><i class="fas fa-sync-alt"></i></button>
                </div>                
            </div>
        </div>
    </div>                            
</div>
{{-- <div class="row">
    <div class="col-md">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text bold-text" id="">LOT <i class="fas fa-hashtag"></i></span>
            </div>
            <input class='form-control' type="text" name="" id="lot_num">
        </div>
    </div>                            
</div>
<div class="row">
    <div class="col-md">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text bold-text" id="">TOTAL:</span>
            </div>
            <input class='form-control' type="text" name="" id="lot_total">
        </div>
    </div>
</div> --}}