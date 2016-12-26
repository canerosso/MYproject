  <div class="modal fade" id="myModal1" role="dialog">
             <div class="modal-dialog">
               <div class="modal-content">
                
                 <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"> Add Superadmin</h4>
                 </div>
                
                 <div class="modal-body">
                  <div class="row"> 
                   <form role="form" action="api/superadmin/index.php/inviteSuperadmin" method="post" id="inviteSuperAdmin">
                    <div class="box-body">
                      <div class="form-group">
                       <label for="exampleInputEmail1">Please enter email</label>
                       <input type="email" class="form-control" id="exampleInputName" 
                         name="email" id="email" placeholder="josef@tfin.com" required>
                      </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary">Invite</button>
                    </div>
                   </form>
                  <div class="box-footer">
                    <label id="message"></label>
                  </div>
               </div>     
              </div>  <!--modal body-->
            </div> <!--modal-content-->
           </div> <!--modal-dialog-->
          </div>  <!--modal fade--> 