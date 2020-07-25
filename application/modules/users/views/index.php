<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>All Patients</h2>
            <!-- <small class="text-muted">Welcome to Swift application</small> -->
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                  
                        <div style="padding-bottom: 0px !important;" class="header">
                        <!-- <h2 style="width:50%; float:left;">All Patients</h2> -->
                      
                        <i data-toggle="modal" data-target="#add_modal" style="float:right;font-size:xx-large; color:#007bff;" class="fa fa-plus-circle makepoint" aria-hidden="true"></i>

                        <button class="btn btn-primaary" id="export">Import</button>

                      
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable"  id="users_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Office</th>
                                    <!-- <th>Status</th> -->
                                    <th>Action</th>

                                   
                                </tr>
                            </thead>
                       
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="color-bg"></div>




<div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <form method="post" id="add_user" >

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Patient</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>  
            </div>
            <div class="modal-body">
                <!-- <form method="post" id="update_subadmin" > -->
                    <div class="form-group">
                    <div class="form-line">
                     
                        <label>First Name</label>
                    <input type="text" name="name" id="name" required class="form-control" maxlength="30"  >
                    </div>
                    </div>

                    <div class="form-group">
                    <div class="form-line">
                     
                        <label>Last Name</label>
                    <input type="text" name="lastname" id="lastname" required class="form-control" maxlength="30" >
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                    <label>Email</label>
                    <input type="email" name="email" id="email" required class="form-control"  >
                    <span class="errEmail" style="color: red;"></span>
                    </div>
                    </div>

                    <div class="form-group">
                    <div class="form-line">
                    <label>Mobile No</label>
                    <input type="text" name="phone" id="phone" required class="form-control preventAlpha phone" maxlength="10" >
                    <span class="errMobile" style="color: red;"></span>
                    </div>
                    </div>

                    <div class="form-group">
                    <div class="form-line">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required class="form-control" maxlength="20" >
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                    Push notification
                                   
                                <label class="switch">
                                <input type="checkbox" id="push_notification" name="push_notification_state" form-control    >
                                <span class="slider round"></span>
                                </label>
                    </div></div>
                    
                    <div class="form-group">
                    <div class="form-line">
                    Special notification
                                   
                                   <label class="switch">
                                   <input type="checkbox" id="special_notification" name="special_notification" form-control >
                                   <span class="slider round"></span>
                                   </label>

                    </div>
                    </div>
                    <?php   if($this->session->userdata('usertype')==1){?>
                    <div class="form-group">
                    <div class="form-line">
                    <!-- <label>Choose Office</label> -->
                    <select class="form-control show-tick" name="desired_clinic" id="desired_clinic" required>
                                     
                                     <option value="">Select Office</option>
                                   
                                     <?php  foreach ($clinic as $data):  ?>
                                         <option  value="<?php  echo $data->id  ?>" ><?php  echo $data->desired_clinic  ?></option>
                                         <?php endforeach  ?>
                                 </select>
                                 </div>
                                    </div>
                                     <?php  }?>
                                     <?php   if($this->session->userdata('usertype')==2){?>
                                        <input type="hidden" name="desired_clinic" id="desired_clinic" value="<?php echo $_SESSION['clinic']; ?>">
                                     <?php  } ?>

                            <div class="modal-footer">  
                        <input type="submit" class=" btn btn-raised g-bg-cyan" value="Add">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                        </div>
            </div>
        </div>
    </form>
    </div>
</div>

