<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Braces</h2>
            <!-- <small class="text-muted">Welcome to Swift application</small> -->
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                        <div style="padding-bottom: 0px !important;" class="header">
                        <h2 style="width:50%; float:left;"></h2>
                       
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Braces-Post OP</button> -->
                        <i data-toggle="modal" data-target="#addModal" style="float:right;font-size:xx-large; color:#007bff;" class="fa fa-plus-circle makepoint" aria-hidden="true"></i>
                     
                        <!-- <button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Add Member</button> -->

                       
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="braces_table">
                            <thead>
                                <tr>
                                    <th> Name</th>
                                    <th>Office</th>
                                    <th>Link</th>
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

<div class="modal fade" id="addModal" tabindex="-1" role="dialog"  >
    <div class="modal-dialog" role="document" style="max-width:50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Braces-Post OP</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>  

            </div>

           <div class="modal-body">
           <form id="add_braces" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <div class="form-line"> 
                        <label> Braces-Post OP Name</label>
                        <input type="text" name="braces_name_add" id="braces_name_add" class="form-control" required maxlength="30" >
                    </div>
                </div>
                <?php   if($this->session->userdata('usertype')==1){?>

                <div class="form-group">
                <div class="form-line">

                <select  name="clinic_id" id="clinic_ids" class="form-control " required>
                                            <option value="">Select Office</option>
                                            <?php  foreach ($clinic as $data):  ?>
                                            <option value="<?php  echo $data->id  ?>" ><?php  echo $data->desired_clinic  ?></option>
                                            <?php endforeach  ?>

                                          
                                        </select>
                </div>
                </div>
                                            <?php } ?>
                                            <?php   if($this->session->userdata('usertype')==2){?>
                                                <input type="hidden" name="clinic_id" id="clinic_id" value="<?php echo $_SESSION['clinic']; ?>">


                                            <?php  } ?>

                <div class="form-group">
                    <div class="form-line">
                        <label>  Enter Youtube Link</label>
                        <input type="text" name="braces_link" id="braces_link" required class="form-control">
                    </div>
                </div>

                <div class="modal-footer">  
                    <input type="submit" value="Add"  class="btn btn-raised g-bg-cyan">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
           </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width:50% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Update Braces-Post OP</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>  

            </div>
            <div class="modal-body">
            <form id="edit_braces" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <div class="form-line">
                        <input type="hidden" id="id" name="id">
                        <label> Braces-Post OP Name</label>
                        <input type="text" name="braces_name" id="braces_name"  class="form-control" required maxlength="30">
                    </div>
                </div>
                <?php   if($this->session->userdata('usertype')==1){?>


                <div class="form-group">
                <div class="form-line">

                <select  name="clinic_id" id="bclinic_id" class="form-control " required>
                                            <option value="">Select Office</option>
                                            <?php  foreach ($clinic as $data):  ?>
                                            <option value="<?php  echo $data->id  ?>" ><?php  echo $data->desired_clinic  ?></option>
                                            <?php endforeach  ?>

                                          
                                        </select>
                </div>
                </div>
                                            <?php  } ?>
                                            <?php   if($this->session->userdata('usertype')==2){?>
                                                <input type="hidden" name="clinic_id" id="bclinic_id" value="<?php echo $_SESSION['clinic']; ?>">


                                            <?php  }?>

                <div class="form-group">
                    <div class="form-line">
                    <label>  Enter Youtube Link</label>
                        <input type="text" name="youlink" id="youlink"  class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">  
                    <input type="submit" value="Update"  class="btn btn-raised g-bg-cyan">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
            </div>

        </div>
    </div>
</div>