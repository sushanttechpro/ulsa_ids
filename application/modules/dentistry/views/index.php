<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<style>
    .cke_chrome {
        margin-left: 45px !important;
    }
    .cke_bottom {
        display:none;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Dentistry</h2>
            <!-- <small class="text-muted">Welcome to Swift application</small> -->
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                        <div style="padding-bottom: 0px !important;" class="header">
                        <h2 style="width:50%; float:left;"></h2>

                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Dentistry</button> -->
                       
                        <i data-toggle="modal" data-target="#addModal" style="float:right;font-size:xx-large; color:#007bff;" class="fa fa-plus-circle makepoint" aria-hidden="true"></i>

                     
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="dentistry_table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Dentistry</th>
                                    <th>Description</th>
                                    <th>Office</th>
                                    <th>Action</th>
                                    <!-- <th>Delete</th> -->
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
    <div class="modal-dialog" role="document" style="max-width:75%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Dentistry</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>  

            </div>

            <div class="modal-body">
            <form id="add_Dentistry" enctype="multipart/form-data" method="post">
                <div class="form-group">
                <div class="form-line">

                    <label>Dentistry Name</label>
                    <input type="text" name="General_dentistry_name" id="General_dentistry_name" class="form-control" required maxlength="30">
                </div>
                </div>
                <div class="form-group">
                <div class="form-line">
                    <label>Images</label>
                    <input type="file" name="image" id="image" class="form-control"  required>
                </div>
                </div>
                <?php   if($this->session->userdata('usertype')==1){?>
                <div class="form-group">
                <div class="form-line">

                <select  name="clinic_id" id="clinic_id" class="form-control " required>
                                            <option value="">Select Office</option>
                                            <?php  foreach ($clinic as $data):  ?>
                                            <option value="<?php  echo $data->id  ?>" ><?php  echo $data->desired_clinic  ?></option>
                                            <?php endforeach  ?>

                                          
                                        </select>
                </div>
                </div>
                                            <?php } ?>

                                            <?php if($this->session->userdata('usertype')==2){?>
                                                <input type="hidden"  name="clinic_id" id="clinic_id" class="form-control " value="<?php echo $_SESSION['clinic']; ?>" required >

                                                
                                            <?php  } ?>
                                            


                <div class="form-group">
                <div class="form-line">
                    <label>Description</label>
                    <textarea id="description" name="description" rows="4" cols="50" required class="form-control"></textarea>

                    <script type="text/javascript">
                        CKEDITOR.replace('description', {
                            height: 200,
                            width : 900
                        });
                    </script>
                </div>
                <span class="dentistry_descrption_err" style="color: red;"></span>
                </div>
                <div class="modal-footer">  

                    <input type="submit" value="Add" class="btn btn-raised g-bg-cyan">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
            </div>

        </div>
    </div>
</div>




<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width:75% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Update Dentistry</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>  

            </div>

           <div class="modal-body">
           <form id="edit_Dentistry" enctype="multipart/form-data" method="post">
                <div class="form-group">
                <div class="form-line"> 
                    <label>Dentistry Name</label>
                    <input type="hidden" id="id" name="id">
                    <input type="text" name="General_dentistry_name" id="General_dentistry" class="form-control"  required maxlength="30">
                </div>
                </div>
                <div class="form-group">
                <div class="form-line"> 
                    <label>Images</label>
                    <input type="file" name="image" id="image_dentistry" class="form-control" >
                </div>
                </div>
                <?php   if($this->session->userdata('usertype')==1){?>
                <div class="form-group">
                <div class="form-line">

                <select  name="clinic_id" id="clinic_id_dentistry" class="form-control " required>
                                            <option value="">Select Office</option>
                                            <?php  foreach ($clinic as $data):  ?>
                                            <option value="<?php  echo $data->id  ?>" ><?php  echo $data->desired_clinic  ?></option>
                                            <?php endforeach  ?>

                                          
                                        </select>
                </div>
                </div>
                                            <?php  }?>
                                            <?php   if($this->session->userdata('usertype')==2){?>
                                                <input type="hidden"  name="clinic_id" id="clinic_id_dentistry" class="form-control " value="<?php echo $_SESSION['clinic']; ?>" required >


                                            <?php  }?>

                <div class="form-group">
                <div class="form-line"> 
                    <label>Description</label>
                    <textarea id="description_dentistry" name="description" rows="4" cols="50" required  class="form-control"></textarea>
                    <script type="text/javascript">
                        CKEDITOR.replace('description_dentistry', {
                            height: 200,
                            width : 900
                        });
                    </script>
                </div>
                <span class="dentistry_descrption_error" style="color: red;"></span>
                </div>
                <div class="modal-footer">  
                    <input type="submit" value="Update" class="btn btn-raised g-bg-cyan">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
           </div>

        </div>
    </div>
</div>