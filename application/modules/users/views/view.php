<section class="content  patient-view">
    <div class="container-fluid">
        <div class="block-header">
            <!-- <h2>Payments</h2> -->
            <!-- <small class="text-muted">Welcome to Swift application</small> -->
        </div>

        <form method="post" id="users_update">
        <div class="card">
					<div class="header">
						<h2>Patient Information </h2>
					</div>
					<div class="body">

                        <div class="row clearfix">
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>First Name</label>
                                        <input type="hidden" name="id" id="id" value="<?php echo $profile->id; ?>">
                                        <input style="padding:8px;" type="text" name="name" id="name" required="" value="<?php echo $profile->name; ?>" class="form-control" maxlength="30">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Last Name</label>
                                        <input style="padding:8px;" type="text" name="lastname" id="lastname" required="" value="<?php echo $profile->lastname; ?>" class="form-control" maxlength="30">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Email Address</label>
                                        <input style="padding:8px;" type="email" name="email" id="email" required="" value="<?php echo $profile->email; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Mobile Number</label>
                                        <input style="padding:8px;" type="phone" name="phone" id="phone" required value="<?php echo $profile->phone; ?>" class="form-control preventAlpha phone" maxlength="10">
                                    </div>
                                    <span class="mobileErr" style="color: red;"></span>
                                </div>
                            </div>
                        </div>



                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Push notification</label>
                                        <label class="switch">
                                        <?php if ($profile->push_notification_state == 1) {?>
                                            <input type="checkbox" id="push_notification_state" name="push_notification_state" form-control checked    >
                                        <?php }?>
                                        <?php if ($profile->push_notification_state == 0) {?>
                                            <input type="checkbox" id="push_notification_state" name="push_notification_state" form-control     >
                                        <?php }?>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Special notification</label>
                                        <label class="switch">
                                        <?php if ($profile->special_notification == 1) {?>
                                            <input type="checkbox" id="special_notification" name="special_notification" form-control checked >
                                        <?php }?>
                                        <?php if ($profile->special_notification == 0) {?>
                                            <input type="checkbox" id="special_notification" name="special_notification" form-control >
                                        <?php }?>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Gps Enable</label>
                                        <label class="switch">
                                        <?php if ($profile->gps_status == 1) {?>
                                            <input type="checkbox" id="gps_status" name="gps_status" form-control checked >
                                        <?php }?>
                                        <?php if ($profile->gps_status == 0) {?>
                                            <input type="checkbox" id="gps_status" name="gps_status" form-control >
                                        <?php }?>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-row">
                                        <label>Comment</label>
                                        <textarea name="comment" id="comment"  cols="150" rows="4">
                                        <?php echo $profile->comment; ?>
                                        </textarea>
                                    </div >
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="card">
                    <div class="header">
                    <h2>Patient Insurance Information</h2>
					</div>
                    <div class="body">
                        <div class="row clearfix">
                        <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient Name</label>
                                        <?php if($insurance){ ?>
                                            <input type="text" id="p_name" name="patient_name"  value="<?=  $insurance->patient_name;?>"  class="form-control" autocomplete="off"  >
                                        <?php }else{ ?>
                                        <input type="text" id="p_name" name="patient_name"    class="form-control" autocomplete="off"  >
                                         <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Subscriber ID</label>
                                        <?php if($insurance){ ?>
                                            <input type="text" id="s_id" name="subscriber_id"  value="<?=  $insurance->subscriber_id;?>"  class="form-control" autocomplete="off"  >
                                        <?php }else{ ?>
                                        <input type="text" id="s_id" name="subscriber_id"    class="form-control" autocomplete="off"  >
                                         <?php } ?>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Subscriber Name</label>
                                        <?php if($insurance){ ?>
                                        <input type="text" id="s_name" name="subscriber_name" value="<?=  $insurance->subscriber_name;?>" class=" form-control" autocomplete="off"  >
                                        <?php }else{ ?>
                                            <input type="text" id="s_name" name="subscriber_name" class=" form-control" autocomplete="off" >
                                            <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient Date Of Birth</label>
                                        <?php if($insurance){ ?>
                                        <input type="text" id="p_birth" name="patient_date_of_birth" value="<?=  $insurance->patient_date_of_birth;?>"  class=" form-control" autocomplete="off" >
                                        <?php }else{ ?>
                                        <input type="text" id="p_birth" name="patient_date_of_birth"   class=" form-control" autocomplete="off" >
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Subscriber Date Of Birth</label>
                                        <?php if($insurance){ ?>
                                        <input type="text" id="s_birth" name="subcriber_date_of_birth" value="<?=  $insurance->subcriber_date_of_birth;?>"  class=" form-control" autocomplete="off"  >
                                        <?php }else{ ?>
                                            <input type="text" id="s_birth" name="subcriber_date_of_birth"   class=" form-control" autocomplete="off">
                                            <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
					</div>
                </div>
        <div class="modal-footer">
            <input type="submit" value="Save" class=" btn btn-raised g-bg-cyan">
        </div>
    </form>



        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                        <div style="padding-bottom: 0px !important;" class="header">
                        <h2 style="width:50%; float:left;">Family Member</h2>
                        <!-- <button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Add Member</button> -->
                        <i data-toggle="modal" data-target="#defaultModal" style="float:right;font-size:xx-large; color:#007bff;" class="fa fa-plus-circle makepoint" aria-hidden="true"></i>



                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable" data-id="<?=$id?>" id="members_table">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone Number</th>
                                    <th>Action</th>
                                    <!-- <th>Edit</th>
                                    <th>Delete</th> -->

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


<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add memeber</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <form method="post" id="add_member" >
                    <div class="form-group">
                    <div class="form-line">
                        <label>First Name</label>
                        <input type="hidden"  value="<?php echo $id ?>" id="id" name="id">
                    <input type="text" name="Firstname" id=" Firstname"required class="form-control" required maxlength="30" >
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label>Last Name</label>
                    <input type="text" name="Lastname" id="Lastname" required class="form-control" required  maxlength="30">
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label>Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number"required class="form-control preventAlpha phone" required maxlength="10" >
                    </div>
                    <span class="mobileError" style="color: red;"></span>
                    </div>
                    <div class="modal-footer">
                    <input type="submit" class="btn btn-raised g-bg-cyan" value="Add">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    </div>


            </form>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="edit_modals" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Update memeber</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <form method="post" id="edit_member" >
                <input type="hidden"   id="member_id" name="id">

                    <div class="form-group">
                    <div class="form-line">
                        <label>First Name</label>
                        <input type="text" name="Firstname" id="names" required class="form-control" required  maxlength="30">
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label>Last Name</label>
                    <input type="text" name="Lastname" id="member_Lastname" required class="form-control" required maxlength="30" >
                    </div>
                    </div>
                    <div class="form-group">
                    <div class="form-line">
                        <label>Phone Number</label>
                    <input type="text" name="phone_number" id="member_phone_number" required class="form-control preventAlpha phone" required maxlength="10" >
                    </div>
                    <span class="mobileErrors" style="color: red;"></span>

                    </div>
                    <div class="modal-footer">
                    <input type="submit" class="btn btn-raised g-bg-cyan" value="Update">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    </div>


            </form>
            </div>
        </div>
    </div>
</div>