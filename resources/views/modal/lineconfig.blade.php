{{-- Line Config --}}
<div class="modal hide fade in" role="dialog" id="lineconfig_mscan_modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Line Configuration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="lineconfig_mscan_form"  method="post" action=''>
                <input type="hidden" name="updated_by" id="ub_lc">
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
                <div id='lctable-div'>
                    {{-- @include('mes.inc.table.lcTable') --}}
                </div>                
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" name="submit" id="lineconfig_mscan_submit"><i class="far fa-save"></i> SAVE</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>