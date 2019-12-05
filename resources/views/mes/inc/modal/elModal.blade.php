{{-- Edit Employee --}}
<div class="modal hide fade in" role="dialog" id="edit_emp_details" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_emp_form" method="POST">
            @method('PUT')           
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="fname" class="col-form-label">First Name:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control' type="text" name="fname" id="fname" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="lname" class="col-form-label">Last Name:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control' type="text" name="lname" id="lname" required>
                            </div>
                        </div>
                    </div>                                
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="repair" class="col-form-label">Repair:</label>                  
                            </div>
                            <div class="col-7">
                                <input id="repair" name='repair' type="checkbox" >
                            </div>
                        </div>
                    </div>                                
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary form_submit_button" name="submit" id="edit_emp_submit"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- Add Employee --}}
<div class="modal hide fade in" role="dialog" id="add-el-modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-el-form" method="POST" action='{{url('employees')}}'>
                @csrf
                @method('POST')           
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="fname-add" class="col-form-label">First Name:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control' type="text" name="fname" id="fname-add" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="lname-add" class="col-form-label">Last Name:</label>                  
                            </div>
                            <div class="col-7">
                                <input class='form-control' type="text" name="lname" id="lname-add" required>
                            </div>
                        </div>
                    </div>                                
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-5">
                                <label for="repair-add" class="col-form-label">Repair:</label>                  
                            </div>
                            <div class="col-7">
                                <input id="repair-add-check" name='repair' type="checkbox" >
                                {{-- <input id="repair-add-input" name='repair' type="hidden" > --}}
                            </div>
                        </div>
                    </div>                                
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary " name="submit" id="add-el-submit-button"><i class="far fa-save"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- Export Employee --}}
<div class="modal hide fade in" role="dialog" id="export-el-modal" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="export-el-form" method="GET" action='{{url('exportel')}}'>
                @method('GET')           
            <div class="modal-body" style="">
                <!-- ____________ FORM __________________ -->
        
                <div class="form-group row">
                    <div class="col-md">
                        <label for="employee-dd" class="col-form-label">Select Employees:</label>
                        <select class="form-control select2" name="employees[]" id="employee-dd" multiple>
                            @foreach ($empps as $emp)
                                <option value="{{$emp->id}}">{{$emp->lname}}, {{$emp->fname}}</option>
                            @endforeach
                        </select>
                    </div>                                                    
                </div>
                <!-- ____________ FORM END __________________ -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary " name="submit" id="add-el-submit-button"><i class="far fa-save"></i> Download</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>