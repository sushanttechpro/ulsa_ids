<style>
    .ui-timepicker-container{ 
     z-index:9999999 !important; 
}
</style>
<section class="content home emergency-detail">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Emergency Details</h2>
        </div>
    </div>

    

    <?php  foreach ($emergency as $data): ?>
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 ">
				<div class="card">
					<div class="header">
						<!-- <h2>Appointment Information </h2> -->
					</div>
					<div class="body">
                    <?php if(empty($data->Firstname) ){ ?> 
                        <div class="row clearfix">
                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient First Name</label>
                                        <input type="text" class="form-control" value="<?= $data->name ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient Last Name</label>
                                        <input type="text" class="form-control" value="<?= $data->lastname ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient's Email Address</label>
                                        <input type="text" class="form-control" value="<?= $data->email ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php  }?>
                        <?php if(!empty($data->Firstname) ){ ?>                             
                        <div class="row clearfix">
                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient  First Name</label>
                                        <input type="text" class="form-control" value="<?= $data->Firstname ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient  Last Name</label>
                                        <input type="text" class="form-control" value="<?= $data->Lastname ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient's Email Address</label>
                                        <input type="text" class="form-control" value="<?= $data->email ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Appointment Created By</label>
                                        <input type="text" class="form-control" value="<?= $data->name.' '.$data->lastname ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php  }?> 
                        <div class="row clearfix">
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Emergency Created</label>
                                        <input type="text" class="datepicker form-control" value="<?=  date(" j F Y g:i a", strtotime ($data->created_date )) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        
                          
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Appointment Status</label>
                                        <?php 
                                        if( $data->status==1){
                                            $status = "Confirmed";
                                        } else if( $data->status==2){
                                            $status = "Cancelled";
                                        } else if( $data->status==0){
                                            $status = "Pending";
                                            } ?>
                                        <input type="text" class="datepicker form-control" value="<?=  $status; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient Mobile Number</label>
                                        <input type="text" class="form-control" value="<?= $data->phone ?>" readonly>
                                    </div>
                                </div>
                            </div>


                            <?php if(!empty($data->admin_approved_date)){ ?>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Appointment Fixed Date</label>
                                        <input type="text" class="datepicker form-control" value="<?=  date(" j F Y ", strtotime ($data->admin_approved_date )) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if(!empty($data->StartTime)){ ?>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Appointment Start Time</label>
                                        <input type="text" class="datepicker form-control" value="<?=  date(" g:i a ", strtotime ($data->StartTime )) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if(!empty($data->StopTime)){ ?>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Appointment Stop Time</label>
                                        <input type="text" class="datepicker form-control" value="<?=  date(" g:i a ", strtotime ($data->StopTime )) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if(!empty($data->FName)){ ?>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Doctor Name</label>
                                        <input type="text" class="datepicker form-control" value="<?= $data->FName.' '.$data->LName  ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>



                            <div class="col-sm-12 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Teeth Name</label>
                                        <input type="text" class=" form-control" value="<?=  $teethNames ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Emergency Service</label>
                                        <input type="text" class=" form-control" value="<?=  $emergency_service ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div> 
                 
                    </div>
                </div>

                <div class="card">
                    <div class="header">
						<h2>Patient Notes</h2>
					</div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-4 col-sm-12">
                                <div class="card">
                                    <div class="card-body" style="padding:0;">
                                        <h4 class="card-title">Problem</h4>
                                        <p class="card-text" ><?= $data->comments ?></p>
                                    </div>
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
                    <!-- <form id="apfix"> -->
                        <div class="row clearfix">
                            <?php foreach($insurance as $insData): ?>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Subscriber ID</label>
                                <?php if(!empty($insData->subscriber_id)){ ?>
                                        <input type="text" id="" name=""  value="<?= $insData->subscriber_id;  ?>" readonly class="form-control" autocomplete="off" >
                                        <?php  }else{?>
                                    <input type="text" id="" name=""  value="N/A" readonly class="form-control" autocomplete="off" >
                                <?php  }?>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Subscriber Name</label>
                                <?php if(!empty($insData->subscriber_name)){ ?>
                                        <input type="text" id="" name="" value="<?= $insData->subscriber_name ?>" readonly class=" form-control" autocomplete="off" >
                                        <?php  }else{?>
                                    <input type="text" id="" name=""  value="N/A" readonly class="form-control" autocomplete="off" >
                                <?php  }?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Patient Date Of Birth</label>
                                <?php if(!empty($insData->patient_date_of_birth)){ ?>
                                        <input type="text" id="" name="" value="<?=$insData->patient_date_of_birth ?>" readonly class=" form-control" autocomplete="off" >
                                        <?php  }else{?>
                                    <input type="text" id="" name=""  value="N/A" readonly class="form-control" autocomplete="off" >
                                <?php  }?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Subscriber Date Of Birth</label>
                                <?php if(!empty($insData->subcriber_date_of_birth)){ ?>
                                        <input type="text" id="" name="" value="<?=$insData->subcriber_date_of_birth   ?>" readonly class=" form-control" autocomplete="off" >
                                        <?php  }else{?>
                                    <input type="text" id="" name=""  value="N/A" readonly class="form-control" autocomplete="off" >
                                <?php  }?>
                                    </div>
                                </div>
                            </div>
                              
                            <?php endforeach; ?>

                        </div>
                    <!-- </form> -->
                   
                    
					</div>
                </div>



                
                <div class="card">
                    <div class="header">
                    <?php if($data->status==0){  ?>
                        <p class="text-warning">Appointment Pending</p>
                        <h2>Fix Appointment </h2>
                    <?php } elseif($data->status==1) {?>
                        <p class="text-success">Appointment Fixed at <mark> <?php echo  date(" j F Y ", strtotime ($data->admin_approved_date ));?>
                     Between<?=  date(" g:i a ", strtotime  ($data->StartTime))?> TO <?=date(" g:i a ", strtotime  (  $data->StopTime)) ?>    By Dr <?=  $data->FName.' '.$data->LName ; ?></mark></p>
                    <h2>Reschedule Appointment</h2>
                    <?php  } elseif($data->status==2) { ?>
                        <p class="text-danger">Appointment Cancelled</p>
                        <h2>Fix Appointment</h2>
                    <?php  }?>
					</div>
                    <script type="text/javascript">
                        $(".demo-preloader").css("display","none");
                    </script>
                    <div class="body">
                        <div class="demo-preloader" style="position: absolute; margin-top: 44px; margin-left: 43%; z-index: 999999;">
                            <div class="preloader pl-size-xl">
                                <div class="spinner-layer">
                                    <div class="circle-clipper left">
                                        <div class="circle"></div>
                                    </div>
                                    <div class="circle-clipper right">
                                        <div class="circle"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <form id="emergencyfix">
                        <div class="row clearfix">
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="hidden" id="id" name="id" value="<?php echo $data->id?>">
                                        <input type="hidden" id="clinic_id" name="clinic_id" value="<?php echo $data->clinic_id?>">
                                        <input type="hidden" id="PatNum" name="PatNum" value="<?php echo $data->PatNum?>">

                                        <input type="text" id="date" name="date" class=" form-control" placeholder="Please choose date" required autocomplete="off" maxlength="10" >
                                    </div>
                                </div>
                            </div>
                                
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="time" name="time" class=" form-control" placeholder="Please choose startTime" required autocomplete="off" maxlength="7" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="times" name="times" class=" form-control" placeholder="Please choose stopTime" required autocomplete="off" maxlength="7" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <div class="form-line">
                                    <select  name="ProvNum" id="ProvNum" class="form-control " required >
                                            <option value="">Select Doctor</option>
                                            <?php  foreach ($doctors as $doc):  ?>
                                            <option value="<?php  echo $doc->ProvNum  ?>" ><?php  echo $doc->FName.' '.$doc->LName  ?></option>
                                            <?php endforeach  ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <?php if($data->status==0  || $data->status==2) {  ?>
                                <input type="submit" value="Fix Appointment" class=" btn btn-raised g-bg-cyan">
                         <?php } elseif($data->status==1){?>
                            <input type="submit" value="Reschedule" class=" btn btn-raised g-bg-cyan">
                         <?php  }?>

                                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button> -->
                            </div>
                        </div>
                    </form>
                   
                    
					</div>
                </div>

                <?php if($data->status==1 ){  ?>

                <form method="post" id="emergencycancel" >
                    <div class="form-group ">
                            <input type="hidden" id="start_event" name="start_event" value="<?php echo $data->admin_approved_date?>">
                            <input type="hidden" id="id" name="id" value="<?php echo $data->id?>" >
                            <input type="submit" value="Cancel Appointment" class=" btn btn-raised g-bg-cyan">
                    </div>
                </form>
                <?php  }?>
               
               

                
			</div>
		</div>
    <?php endforeach;?>
</section>

<div class="color-bg"></div>