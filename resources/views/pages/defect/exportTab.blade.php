<form id="ds_export_form" class='' method="GET" action='{{url('exportdefectmats')}}'>
    <div class="form-group row">
        <div class="col-4">
            <label for="ds_status" class="col-form-label">STATUS:</label>                  
        </div>
        <div class="col-8">
            <select class='form-control' name="status" id="ds_status">
                <option value="">ALL</option>
                <option value="1">NG</option>
                <option value="2">GOOD</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4">
            <label for="ds_line" class="col-form-label">LINE:</label>                  
        </div>
        <div class="col-8">
            <select class='form-control' name="line" id="ds_line">
                <option value="">ALL</option>
                @foreach ($lines as $line)
                    <option value="{{$line->id}}">{{$line->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4">
            <label for="ds_shift" class="col-form-label">SHIFT:</label>                  
        </div>
        <div class="col-8">
            <select class='form-control' name="shift" id="ds_shift">
                <option value="">ALL</option>
                <option value="1">DAY</option>
                <option value="2">NIGHT</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4">
            <label for="ds_date_from" class="col-form-label">FROM:</label>                  
        </div>
        <div class="col-8">
            <input type="date" class="form-control" name="date_from" id="ds_date_from" value="{{Date('Y-m-d')}}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4">
            <label for="ds_date_to" class="col-form-label">TO:</label>                  
        </div>
        <div class="col-8">
            <input type="date" class="form-control" name="date_to" id="ds_date_to" value="{{Date('Y-m-d')}}">
        </div>
    </div>
    <div class="row text-right">
        <div class="col-md">
            <button type="submit" class="btn btn-primary" name="submit" id="ds_export_submit"><i class="fas fa-download"></i> DOWNLOAD</button>
        </div>
    </div>
</form>