<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<style>
    .cke_chrome {
        margin-left: 45px !important;
    }

    .cke_bottom {
        display: none;
    }
    .btn-group {
        box-shadow: 0 0px;
        width: 150px !important;
        left: 0% !important;
    }
    .dropdown-menu.show {
        width: 350px !important;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Doctors</h2>
            <!-- <small class="text-muted">Welcome to Swift application</small> -->
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div style="padding-bottom: 0px !important;" class="header">
                        <h2 style="width:50%; float:left;"></h2>

                        <button type="button" class="btn btn-primary" id="adddoctor" style="float:right;"  >Import</button>

                        <!-- <i  style="float:right;font-size:xx-large; color:#007bff;" class="fa fa-plus-circle makepoint" aria-hidden="true" id="adddoctor" value="1" name="id"></i> -->
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="doctors_table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Phone No</th>
                                    <th>Description</th>
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




<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width:75%">
        <form id="add_Doctor" enctype="multipart/form-data" method="post">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Doctors</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">
                    <form id="add_Doctor" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <div class="form-line">
                                <label>Doctor Name</label>
                                <input type="text" name="name" id="name" required class="form-control" maxlength="30">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-line">
                                <label>Phone</label>
                                <input type="text" name="phone" id="phone" required class="form-control preventAlpha phone" maxlength="10">
                            </div>
                            <span class="errDoctor_phone" style="color: red;"></span>
                        </div>



                        <div class="form-group">
                            <div class="form-line">
                                <label>Images</label>
                                <input type="file" name="image" id="image" required class="form-control">
                            </div>
                        </div>
                        <!-- <?php if ($this->session->userdata('usertype') == 1) { ?>
                            <div class="form-group">
                                <div class="form-line">
                                    <select id="dotor_clinic_id" name="clinic_id[]" multiple class="form-control" required>
                                        <?php foreach ($clinic as $data) :  ?>
                                            <option value="<?php echo $data->id  ?>"><?php echo $data->desired_clinic  ?></option>
                                        <?php endforeach  ?>
                                    </select>
                                </div>
                            </div>
                        <?php  } ?>

                        <?php if ($this->session->userdata('usertype') == 2) { ?>
                            <input type="hidden" name="clinic_id" id="clinic_id" class="form-control " value="<?php echo $_SESSION['clinic']; ?>" required>

                        <?php  } ?> -->

                        <div class="form-group">
                            <div class="form-line">
                                <label>Description</label>
                                <textarea id="description" name="doctor_description" rows="4" cols="50" required class="form-control" required></textarea>
                                <script type="text/javascript">
                                    CKEDITOR.replace('description', {
                                        height: 200,
                                        width: 900
                                    });
                                </script>
                            </div>
                            <span class="description_error" style="color: red;"></span>
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




<div class="modal fade" id="editDoctor" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width:75% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Update Doctors</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">
                <form id="edit_Doctor" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Last Name</label>
                            <input type="hidden" id="id" name="id">
                            <input type="text" name="Lname" id="Lname" required class="form-control" maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <label>First Name</label>
                            <input type="text" name="Fname" id="Fname" required class="form-control" maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <label>Phone</label>
                            <input type="text" name="phone" id="doctor_phone" required class="form-control preventAlpha phone" maxlength="10">
                        </div>
                        <span class="errDoctor_phones" style="color: red;"></span>

                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label>Images</label>
                            <input type="file" name="image" id="doctor_image" class="form-control">
                        </div>
                    </div>
                    <!-- <?php if ($this->session->userdata('usertype') == 1) { ?>
                        <div class="form-group">
                            <div class="form-line">
                                <select id="doct_clinic_id" name="clinic_id[]" multiple class="form-control">
                                    <?php foreach ($clinic as $data) :  ?>
                                        <option value="<?php echo $data->id  ?>"><?php echo $data->desired_clinic  ?></option>
                                    <?php endforeach  ?>
                                </select>

                            </div>
                        </div>
                    <?php  } ?> -->
                  
                    <div class="form-group">
                        <div class="form-line">
                            <label>Description</label>
                            <textarea id="doctor_description" name="doctor_description" rows="4" cols="50" required class="form-control"></textarea>
                            <script type="text/javascript">
                                CKEDITOR.replace('doctor_description', {
                                    height: 200,
                                    width: 900
                                });
                            </script>
                        </div>
                        <span class="description_err" style="color: red;"></span>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Update" class=" btn btn-raised g-bg-cyan">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>