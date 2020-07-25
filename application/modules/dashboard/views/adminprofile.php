<?php
if (!$this->session->userdata("email")) {
    $this->load->helper('url');
    redirect('auth');
}
?>

<section class="content home">
    <div class="container-fluid">
        <div class="block-header">
            <!-- <h2>Dashboard</h2>
            <small class="text-muted">Welcome to Swift application</small> -->
        </div>
    </div>
<form method="post" id="admin_update">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 ">
            <div class="card">
				<div class="header">
					<h2>Personal Information </h2>
				</div>
				<div class="body">
                     
                    <div class="row clearfix">
                        <div class="col-sm-6 ">
                            <div class="form-group">
                                <div class="form-line">
                                    <label>First Name</label>
                                    <input style="padding:8px;" type="text" name="name" id="name" required value="<?php echo $profile->name; ?>" class="form-control" maxlength="30">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Last Name</label>
                                    <input style="padding:8px;" type="text" name="lastname" id="lastname" required value="<?php echo $profile->lastname; ?>" class="form-control" maxlength="30">
                                </div>
                            </div>
                        </div>
                    </div>
                                             
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Email Address</label>
                                    <input style="padding:8px;" type="email" readonly name="email" id="email" required value="<?php echo $profile->email; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Mobile Number</label>
                                    <input style="padding:8px;" type="phone" name="phone" id="phone" required value="<?php echo $profile->phone; ?>" class="form-control preventAlpha phone" maxlength="10">
                                </div>
                        <span class="erradmin_mobile" style="color: red;"></span>

                            </div>
                        </div>
                    </div> 
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="modal-footer">
                                <input type="submit" value="Save" class=" btn btn-raised g-bg-cyan">
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </div>
</form >

<form id="password_change">
    <div class="card">
		<div class="header">
			<h2>Change Password</h2>
		</div>
		<div class="body">
            <div class="row clearfix">
                <div class="col-sm-12 ">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Old Password</label>
                            <input style="padding:8px;" type="Password" name="oldpassword" id="oldpassword"   class="form-control " required maxlength="20"> 
                        </div>
                        <span class="errPaasword" style="color: red;"></span>
                    </div>
                </div>
            </div>
                                             
            <div class="row clearfix">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form-line">
                            <label>New Password</label>
                            <input style="padding:8px;" type="Password" name="password" id="password"   class="form-control " required maxlength="20"> 
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Confirm Password</label>
                            <input style="padding:8px;" type="Password" name="cnfpassword" id="cnfpassword"   class="form-control " required maxlength="20"> 
                        </div>
                        <span class="errCnfPass" style="color: red;"></span>
                    </div>
                </div>
            </div> 
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="modal-footer">
                        <input type="submit" value="Change" class=" btn btn-raised g-bg-cyan">
                    </div>
                </div>
            </div>
        </div>
	</div>
</form>

            
<form id="status_filter">
    <div class="card">
		<div class="header">
			<h2>Set Statistics Date</h2>
		</div>
		<div class="body">

            <div class="row clearfix">

                <div class="col-sm-6 ">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Start Date</label>
                            <?php if($status_date){ ?>
                            <input type="text" name="date_one" id="date_one" class="form-control" value="<?=date("d-m-Y", strtotime( $status_date->starting_date)) ?>" required autocomplete="off" maxlength="10">
                            <?php }else{ ?>
                            <input type="text" name="date_one" id="date_one" class="form-control"  required autocomplete="off" maxlength="10">
                            <?php } ?>
                        </div>
                        <span class="date_one" style="color: red;"></span>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="form-group">
                        <div class="form-line">
                            <label>End Date</label>
                            <?php if($status_date){ ?>
                            <input type="text" name="date_two" id="date_two" class="form-control" value="<?=  date("d-m-Y", strtotime( $status_date->ending_date)) ?>" required autocomplete="off" maxlength="10">
                            <?php }else{ ?>
                            <input type="text" name="date_two" id="date_two" class="form-control"  required autocomplete="off" maxlength="10">
                            <?php } ?>

                        </div>
                        <span class="date_two" style="color: red;"></span>
                    </div>
                </div>

            </div>

                                             
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="modal-footer">
                        <input type="submit"  class=" btn btn-raised g-bg-cyan">
                    </div>
                </div>
            </div>
        </div>
	</div>
</form>


</section>

<div class="color-bg"></div>