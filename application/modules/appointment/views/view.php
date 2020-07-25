<style>
    .ui-timepicker-container{ 
     z-index:9999999 !important; 
}
</style>
<script type="text/javascript">
    $(".demo-preloader").css("display","none");
</script>
<section class="content home appointment-details">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Appointment Details</h2>
        </div>
    </div>

    

    <?php  foreach ($appointment as $data): ?>
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
                                        <label>Appointment Created</label>
                                        <input type="text" class="datepicker form-control" value="<?=  date(" j F Y g:i a", strtotime ($data->appointment_date )) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($data->reminder_date)){ ?>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Reminder Date</label>
                                        <input type="text" class="datepicker form-control" value="<?=  date(" j F Y g:i a", strtotime ($data->reminder_date )) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-sm-3 ">
                            <div class="form-group">
                                    <div class="form-line">
                                        <label>Appointment Type</label>
                                        <input type="text" class="datepicker form-control" value="<?=  $data->type ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label>Appointment Status</label>
                                        <?php 
                                        if( $data->approved_status==1){
                                            $status = "Confirmed";
                                        } else if( $data->approved_status==2){
                                            $status = "Cancelled";
                                        } else if( $data->approved_status==0){
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
                        </div> 
                 
                    </div>
				</div>
                <div class="card">
                    <div class="header">
						<h2>Patient Notes</h2>
					</div>
                    <div class="body">
                        <div class="row clearfix">
                            <?php foreach ($note as $notedata): ?>
                                <?php  if(!empty($notedata->note_name)){ ?>
                                    <div class="col-lg-6 col-md-4 col-sm-12" style="border: 1px solid #cacaca;">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title" style="text-align:center;"><?= $notedata->note_name ?></h4>
                                                <p class="card-text" style="text-align:justify;"  ><?= $notedata->note_description ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else {?>
                                    <p style="margin-left: 45%;color: #495057;">No Notes Available</p>
                                <?php } ?>
                            <?php endforeach; ?>
                        </div>
					</div>
                </div>
                <div class="card">
                    <div class="header">
						<h2>Patient Availability</h2>
					</div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Days</th>
                                        <th>Slots</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($appointment_time as $result): ?>
                                <?php 
                                if( $result->days==1){
                                    $choosenDay = "Monday";
                                } else if( $result->days==2){
                                    $choosenDay = "Tuesday";
                                } else if( $result->days==3){
                                    $choosenDay = "Wednesday";
                                    
                                } else if( $result->days==4){
                                    $choosenDay = "Thursday";
                                    
                                } else if( $result->days==5){
                                    $choosenDay = "FridaY";
                                    
                                } else if( $result->days==6){
                                    $choosenDay = "Saturday";
                                    
                                } else if( $result->days==7){
                                    $choosenDay = "Sunday";
                                }
                                if($result->slots == 1){
                                    $choosenSlot = "Anytime";
                                } else if($result->slots == 2){
                                    $choosenSlot = "Morning";
                                } else if($result->slots == 3){
                                    $choosenSlot = "Afternoon";
                                } else if($result->slots == 4){
                                    $choosenSlot = "Evening";
                                } else if($result->slots == 0){
                                    $choosenSlot = "Client didn't choose any option";
                                }
                                if($result->days==0){
                                    $choosenDay = "Next Avail Appt.";
                                    $choosenSlot = "";
                                }
                                ?>
                                <tr>
                                    <td><?= $choosenDay ?></td>
                                    <td><?= $choosenSlot ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
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
                    <?php if($data->approved_status==0){  ?>
                        <p class="text-warning">Appointment Pending</p>
                        <h2>Fix Appointment </h2>
                    <?php } elseif($data->approved_status==1) {?>
                        <p class="text-success">Appointment Fixed at <mark> <?php echo  date(" j F Y ", strtotime ($data->admin_approved_date ));?>
                     Between<?=  date(" g:i a ", strtotime  ($data->StartTime))?> TO <?=date(" g:i a ", strtotime  (  $data->StopTime)) ?>    By Dr <?=  $data->FName.' '.$data->LName ; ?></mark></p>
                    <h2>Reschedule Appointment</h2>
                    <?php  } elseif($data->approved_status==2) { ?>
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
                    <form id="apfix">
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
                            <?php if($data->approved_status==0  || $data->approved_status==2) {  ?>
                                <input type="submit" value="Fix Appointment" class=" btn btn-raised g-bg-cyan">
                         <?php } elseif($data->approved_status==1){?>
                            <input type="submit" value="Reschedule" class=" btn btn-raised g-bg-cyan">
                         <?php  }?>

                                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button> -->
                            </div>
                        </div>
                    </form>
                   
                    
					</div>
                </div>

                <?php if($data->approved_status==1 ){  ?>

                <form method="post" id="apcancel" >
                    <div class="form-group ">
                            <input type="hidden" id="start_event" name="start_event" value="<?php echo $data->admin_approved_date?>">
                            <input type="hidden" id="id" name="id" value="<?php echo $data->id?>">
                            <input type="submit" value="Cancel Appointment" class=" btn btn-raised g-bg-cyan">
                    </div>
                </form>
                <?php  }?>
			</div>
		</div>
    <?php endforeach;?>
</section>

<div class="color-bg"></div>