<div class="modal hide fade in" role="dialog" id="export-lr-modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Line Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="export-lr-form" class=''  method="GET" action='{{url('exportlr')}}'>
                @csrf
                <input id='division_id' type="hidden" name="division_id">
                <input id='line_id' type="hidden" name="line_id">
            <div class="modal-body" style="">

                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-3">
                        <label for="line-lr-input" class="col-form-label">LINE:</label>                  
                    </div>
                    <div class="col-9"> 
                        <select class='form-control' name="line" id="line-lr-input" required>
                            <option value="">- PLEASE SELECT -</option>
                            @foreach ($dlines as $dline)
                                <option value="{{$dline->id}}">{{$dline->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-3">
                        <label for="type-lr-input" class="col-form-label">TYPE:</label>                  
                    </div>
                    <div class="col-9"> 
                        <select class='form-control' name="type" id="type-lr-input">
                            <option value="">ALL</option>
                            <option value="0">IN</option>
                            <option value="1">OUT</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-3">
                        <label for="from-lr-input" class="col-form-label">FROM:</label>                  
                    </div>
                    <div class="col-9">
                        <div class="input-group">
                            <input class="form-control" type="date" name="fromdate" id="fromdate-lr-input" value="{{$today}}">
                            <input class="form-control" type="time" name="fromtime" id="fromtime-lr-input">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <label for="to-lr-input" class="col-form-label">TO:</label>                  
                    </div>
                    <div class="col-9">
                        <div class="input-group">
                            <input class="form-control" type="date" name="todate" id="todate-lr-input" value="{{$today}}">
                            <input class="form-control" type="time" name="totime" id="totime-lr-input">
                        </div>                        
                    </div>
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="submit" id="add_defect_submit"><i class="far fa-save"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>