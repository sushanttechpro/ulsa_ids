<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Add Patient</h2>
            
        </div>
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="header">
						
						
					</div>
					<div class="body">
                        <form method="post" id="add_user">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Name" name="name" id="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                         <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
                                         <span class="errEmail" style="color: red;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">                            
                            <!-- <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" class=" form-control" placeholder="Confirm Password" id="Confirm Password">
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group form-line ">
                                 Push notification
                                   
                                <label class="switch">
                                <input type="checkbox" id="push_notification" name="push_notification_state"    >
                                <span class="slider round"></span>
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group form-line ">
                                 Special notification
                                   
                                <label class="switch">
                                <input type="checkbox" id="special_notification" name="special_notification"  >
                                <span class="slider round"></span>
                                </label>
                                </div>
                            </div>                            
                            <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="form-group drop-custum">
                                    <select class="form-control show-tick" name="desired_clinic" id="desired_clinic" required>
                                     
                                        <option value="">Select Clinic</option>
                                      
                                        <?php  foreach ($clinic as $data):  ?>
                                            <option ><?php  echo $data->desired_clinic  ?></option>
                                            <?php endforeach  ?>
                                    </select>

                                   
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="https://thememakker.com/" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph"> <i class="material-icons">touch_app</i> </div>
                                        <h3>Drop files here or click to upload.</h3>
                                        <em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em> </div>
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                </form>
                            </div>
                        </div> -->
                        <div class="row clearfix">                            
                            <!-- <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea rows="4" class="form-control no-resize" placeholder="Description"></textarea>
                                    </div>
                                </div>
                            </div> -->
                            <div class="">
                                <button type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                            </div>
                        </div>
                        </form>
                    </div>
				</div>
			</div>
		</div>
        <!-- <div class="row clearfix">
			<div class="col-md-12">
				<div class="card">
					<div class="header">
						<h2>Registration Information <small>Description text here...</small> </h2>						
					</div>
					<div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Doctor Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Staff on Duty">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" placeholder="Ward No.">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">                               
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="datetimepicker form-control" placeholder="Please choose date & time...">
                                    </div>
                                </div>                               
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                <button type="submit" class="btn btn-raised">Cancel</button>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>         -->
    </div>
</section>
<div class="color-bg"></div>
