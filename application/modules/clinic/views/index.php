<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Offices</h2>
            <!-- <small class="text-muted">Welcome to Swift application</small> -->
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                        <div style="padding-bottom: 0px !important;" class="header">
                        <h2 style="width:50%; float:left;"></h2>
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add Braces-Post OP</button> -->
                        <?php if ($this->session->userdata('usertype') == 1) {?>
                        <i data-toggle="modal" data-target="#addModal" style="float:right;font-size:xx-large; color:#007bff;" class="fa fa-plus-circle makepoint" aria-hidden="true"></i>
                        <?php }?>

                        <!-- <button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Add Member</button> -->


                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="clinic_table">
                            <thead>
                                <tr>
                                    <th>image</th>
                                    <th>Logo</th>
                                    <th>office</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Working Hours</th>
                                    <th>Address</th>
                                    <th>Add Services</th>
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



<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width:100%">
            <form id="add_clinic" enctype="multipart/form-data" method="post">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Office</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
            <form id="add_Doctor" enctype="multipart/form-data" method="post">
            <div class="form-group">
                    <div class="form-line">
                        <label>  Enter Office Name</label>
                        <input type="text" name="desired_clinic" id="desired_clinic" required class="form-control" maxlength="30" >
                    </div>
                </div>
                <div class="form-group">
                <div class="form-line">
                    <label>Office Image</label>
                    <input type="file" name="image" id="image" required class="form-control" required>
                </div>
                </div>

                <div class="form-group">
                <div class="form-line">
                    <label>Office Logo</label>
                    <input type="file" name="logo" id="logo" required class="form-control" required>
                </div>
                </div>

                <div class="form-group">
                    <div class="form-line">
                        <label>Office Email</label>
                        <input type="email" name="clinic_email" id="clinic_email" required class="form-control">
                    </div>
                    <span class="errClinic_email" style="color: red;"></span>
                </div>

                <div class="form-group">
                    <div class="form-line">
                        <label>Office Phone</label>
                        <input type="text" name="clinic_phoneno" id="clinic_phoneno" maxlength="10" required class="form-control preventAlpha phone">
                    </div>
                    <span class="errClinic_phone" style="color: red;"></span>
                </div>

                <div class="form-group">
                    <div class="form-line">
                        <label>Office Address</label>
                        <input type="text" name="clinic_address" id="clinic_address" required class="form-control">
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <div class="form-line">
                                <label>Office Latitude</label>
                                <input type="text" name="clinic_lat" id="lat" required class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <div class="form-line">
                                <label>Office Longitude</label>
                                <input type="text" name="clinic_long" id="long" required class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                                <div class="form-line">
                                    <select id="dotor" name="doctor_id[]" multiple class="form-control" required>
                                        <?php foreach ($doctors as $data) :  ?>
                                            <option value="<?php echo $data->id  ?>"><?php echo  $data->FName.' '.$data->LName  ?></option>
                                        <?php endforeach  ?>
                                    </select>
                                </div>
                            </div>
                </div>


                <div class="form-group">
                <div class="form-line">
                    <label>Working Hours</label>
                    <textarea id="working_hours" name="working_hours" rows="4" cols="50" required class="form-control"></textarea>

                    <script type="text/javascript">
                        CKEDITOR.replace('working_hours', {
                            height: 200,
                            width : 900
                        });
                    </script>
                    <span class="workinghours_error" style="color: red;"></span>
                </div>
                </div>
                <!-- <div class="form-group"> -->
                <div class="modal-footer">
                    <input type="submit" value="Add" class=" btn btn-raised g-bg-cyan">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
            </div>

        </div>
    </div>
</div>





<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width:100%">
            <form id="edit_clinic" enctype="multipart/form-data" method="post">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Update Office</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
            <form id="add_Doctor" enctype="multipart/form-data" method="post">
            <div class="form-group">
                    <div class="form-line">
                        <label>  Enter Office Name</label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" name="desired_clinic" id="cdesired_clinic" required class="form-control" maxlength="30">
                    </div>
                </div>
                <div class="form-group">
                <div class="form-line">
                    <label>Office Image</label>
                    <input type="file" name="image" id="images"  class="form-control">
                </div>
                </div>

                <div class="form-group">
                <div class="form-line">
                    <label>Office Logo</label>
                    <input type="file" name="logo" id="logos"  class="form-control">
                </div>
                </div>

                <div class="form-group">
                    <div class="form-line">
                        <label>Office Email</label>
                        <input type="email" name="clinic_email" id="cclinic_email" required class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-line">
                        <label>Office Phone</label>
                        <input type="text" name="clinic_phoneno" id="cclinic_phoneno" maxlength="10" required class="form-control preventAlpha phone">
                    </div>
                    <span class="errClinic_phones" style="color: red;"></span>

                </div>

                <div class="form-group">
                    <div class="form-line">
                        <label>Office Address</label>
                        <input type="text" name="clinic_address" id="cclinic_address" required class="form-control">
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <div class="form-line">
                                <label>Office Latitude</label>
                                <input type="text" name="clinic_lat" id="clinic_latitude" required class="form-control ">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <div class="form-line">
                                <label>Office Longitude</label>
                                <input type="text" name="clinic_long" id="clinic_longitude" required class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                                <div class="form-line">
                                    <select id="dotors" name="doctor_id[]" multiple class="form-control" >
                                        <?php foreach ($doctors as $data) :  ?>
                                            <option value="<?php echo $data->id  ?>"><?php echo $data->FName.' '.$data->LName  ?></option>
                                        <?php endforeach  ?>
                                    </select>
                                </div>
                            </div>
                </div>


                <div class="form-group">
                <div class="form-line">
                    <label>Working Hours</label>
                    <textarea id="cworking_hours" name="working_hours" rows="4" cols="50" required class="form-control "></textarea>

                    <script type="text/javascript">
                        CKEDITOR.replace('cworking_hours', {
                            height: 200,
                            width : 900
                        });
                    </script>
                </div>
                <span class="workinghours_err" style="color: red;"></span>
                </div>
                <!-- <div class="form-group"> -->
                <div class="modal-footer">
                    <input type="submit" value="Update" class=" btn btn-raised g-bg-cyan">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
            </div>

        </div>
    </div>
</div>