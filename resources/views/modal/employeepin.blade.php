<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="background-color:#5b83b2">
                <h4 class="modal-title"><i class="fas fa-unlock"></i>&nbspUser Authentication</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
            <div class="modal-body">
              <p>Please provide the PIN for this employee. The system will record the selected employee id along with its transaction.</p>
              
                <div class="input-group">
                    <span class="vertical-center"><i class="fas fa-key" style="font-size: 20px"></i>&nbsp</span>
                    <input id="admin_pass" type="password" class="form-control" name="admin_pwd" placeholder="Enter Administrator Password">
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-user-check"></i>&nbspContinue</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="WrongPIN()"><i class="fas fa-times"></i>&nbspClose</button>
            </div>
          </div>
      
        </div>
      </div>