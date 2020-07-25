<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>All Users</h2>
        </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div style="padding-bottom: 0px !important;" class="header">
                    <h2 style="width:50%; float:left;"></h2>
                        <i data-toggle="modal" data-target="#add_modal" style="float:right;font-size:xx-large; color:#007bff;" 
                        class="fa fa-plus-circle makepoint" aria-hidden="true"></i>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable"  id="subadmin_table">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Office</th>
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


<div class="modal fade" id="edit_subadmin" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" id="update_subadmin" >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Update User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="hidden"   id="id" name="id">
                            <label>Name</label>
                            <input type="text" name="name" id="sname" required class="form-control" maxlength="30" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label>Last Name</label>
                            <input type="text" name="lastname" id="slastname" required class="form-control" maxlength="30" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label>Email</label>
                            <input type="email" name="email" id="semail" required class="form-control" maxlength="30" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label>Mobile</label>
                            <input type="text" name="phone" id="sphone" required class="form-control preventAlpha phone" maxlength="10" >
                            <span class="errMobilesadmin" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <select  name="desired_clinic" id="sdesired_clinic" class="form-control " required>
                                <option value="">Select Office</option>
                                    <?php  foreach ($clinic as $data):  ?>
                                <option value="<?php  echo $data->id  ?>" ><?php  echo $data->desired_clinic  ?></option>
                                <?php endforeach  ?>
                           </select>
                        </div>
                    </div>
                    <div class="modal-footer">  
                        <input type="submit" class=" btn btn-raised g-bg-cyan" value="Update">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" id="add_subadmin" >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Name</label>
                            <input type="text" name="name" id="name" required class="form-control" maxlength="30" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label>Last Name</label>
                            <input type="text" name="lastname" id="lastname" required  class="form-control" maxlength="30" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label>Email</label>
                            <input type="email" name="email" id="email" required class="form-control" maxlength="30" >
                            <span class="errEmailsubadmin" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label>Mobile</label>
                            <input type="text" name="phone" id="phone" required class="form-control preventAlpha  phone" maxlength="10" >
                            <span class="errMobilesubadmin" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <select  name="desired_clinic" id="desired_clinic" class="form-control " required>
                                <option value="">Select Office</option>
                                <?php  foreach ($clinic as $data):  ?>
                                    <option value="<?php  echo $data->id  ?>" ><?php  echo $data->desired_clinic  ?></option>
                                <?php endforeach  ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label>Password</label>
                            <input type="password" name="password" id="password" required class="form-control" maxlength="20" >
                        </div>
                    </div>
                    <div class="modal-footer">  
                        <input type="submit" class=" btn btn-raised g-bg-cyan" value="Add">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>