<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Service Type</h2>
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
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable" data-id="<?=$id?>" id="service_type">
                            <thead>
                                <tr>
                                   
                                    <th>Servic Type</th>
                                    <th>Service Description</th>
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
    <div class="modal-dialog" role="document">
            <form id="add_servicetype"  method="post">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Service Type</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>  

            </div>

            <div class="modal-body">
            <div class="form-group">
                    <div class="form-line">
                        <input type="hidden" name="id" id="id" value="<?php  echo $id?>">
                        <label>Service Type</label>
                        <input type="text" name="service_type" id="service_type" required class="form-control" maxlength="100"  autocomplete="off">
                    </div>
                </div>
           

                <div class="form-group">
                    <div class="form-line">
                        <label>Servic  Description</label>
                    <textarea id="service_description" name="service_description" rows="4" cols="50" required class="form-control"></textarea>

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
    <div class="modal-dialog" role="document">
            <form id="edit_serviceaptype"  method="post">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Update Service Type</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>  

            </div>

            <div class="modal-body">
            <div class="form-group">
                    <div class="form-line">
                        <input type="hidden" name="id" id="aid">
                        <label>Service Type</label>
                        <input type="text" name="service_type" id="aservice_type" required class="form-control" maxlength="100" autocomplete="off" >
                    </div>
                </div>
                <div class="form-group">
                <div class="form-line">
                    <label>Service Description</label>
                    <input type="text" name="service_description" id="aservice_description" required class="form-control" autocomplete="off">
                </div>
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


