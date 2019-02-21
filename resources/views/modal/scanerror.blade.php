<div class="modal errormodal" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i>&nbspINPUT ERROR CODE</h5>
       {{--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> --}}
      </div>
      <div class="modal-body">
        <select class="select22" id="ecode_sel" required>
            <option value="">SELECT ERROR CODE</option>
        @foreach ($ecode as $ecode_item)
            <option value="{{$ecode_item->id}}">{{$ecode_item->error_code}}-{{$ecode_item->error_desc}}</option>
        @endforeach
        
    </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="haserrorcode()"><i class="fas fa-save"></i>&nbspSAVE RECORD</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="errormsg()"><i class="fas fa-times-circle"></i>&nbspCLOSE</button>
      </div>
    </div>
  </div>
</div>