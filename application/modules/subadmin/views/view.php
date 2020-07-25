<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <!-- <h2>Payments</h2> -->
            <!-- <small class="text-muted">Welcome to Swift application</small> -->
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Module List</h2>
                        <!-- <button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Add Member</button> -->

                       
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable"  id="module_table">
                            <thead>
                                <tr>
                                    <th>Module Name</th>
                                    <th>Permission</th>
                                   
                                   
                                </tr>
                            </thead>
                            <?php ?>
                            
                            <tbody>
                                <?php foreach($module as $data): ?>
                                <tr>
                                <td>
                                    <div>
                                        <i style="color:#007bff;margin-right:10px;" class="fa fa-plus collapsed makepoint" data-toggle="collapse" data-target='#collapseExample<?php echo $data->name; ?>' aria-expanded="false" aria-controls="collapseExample" aria-hidden="true"></i><?php echo $data->name ?>
                                    </div>
                                    <div class="collapse" id="collapseExample<?php echo $data->name; ?>">
                                        <div class="well" style="margin-left: 21px;line-height: 25px;">
                                        <?php foreach($subModule as $datas) {?>
                                            <?php if($data->id == $datas->module_id) { 
                                                echo $datas->action;
                                                echo "<br>";
                                            } ?>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="checkbox" style="left: 62%;opacity: 1;" id="vehicle1" name="vehicle1" value="<?php echo $data->name; ?>">
                                    </div>
                                    <div class="collapse" id="collapseExample<?php echo $data->name; ?>">
                                        <div class="well" style="margin-top: 27px;">
                                        <?php foreach($subModule as $datas) {?>
                                            <?php if($data->id == $datas->module_id) { ?>
                                                <input type="checkbox" style="left: 62%;opacity: 1;" id="vehicle1" name="vehicle1" value="<?php echo $data->name; ?>">
                                                <?php echo "<br>"; ?>
                                            <?php } ?>
                                        <?php } ?>
                                        </div>
                                    </div>
                                    
                                </td>

                                </tr>
                                <?php  endforeach  ?>
                            </tbody>
                        
                       
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    
</section>
<div class="color-bg"></div>