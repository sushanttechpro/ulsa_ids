<style>
    .modal-backdrop.show {
        opacity : 0 !important;
        z-index: 0 !important;
    }
    .table {
        width: 100% !important;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>All Appointments</h2>
            <!-- <small class="text-muted">Welcome to Swift application</small> -->
        </div>
        <div class="body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#approved">Approved Appointments</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pending">Pending Appointments</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cancelled">Cancelled Appointments</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane in active" id="approved">
                    <div class="body table-responsive">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div style="padding-bottom: 0px !important;" class="header">
                                        <h2 style="width:50%; float:left;"></h2>
                                    </div>
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="appointment_table" data-id="1">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <!-- <th>Service</th> -->
                                                <th>Office Location</th>
                                                <!-- <th>Distance</th>/ -->
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th style="width:65px !important;">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="pending">
                    <div class="body table-responsive">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div style="padding-bottom: 0px !important;" class="header">
                                        <h2 style="width:50%; float:left;"></h2>
                                    </div>
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="appointment_table_pend" data-id="0">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <!-- <th>Service</th> -->
                                                <th>Office Location</th>
                                                <!-- <th>Distance</th> -->
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="cancelled">
                    <div class="body table-responsive">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div style="padding-bottom: 0px !important;" class="header">
                                        <h2 style="width:50%; float:left;"></h2>
                                    </div>
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="appointment_table_dec" data-id="2">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>First Name</th>

                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <!-- <th>Service</th> -->
                                                <th>Office Location</th>
                                                <!-- <th>Distance</th> -->
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="notification" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" id="notoification_form" >
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Send Notification</h4>
                    <div>
                        <h1 class="modal-title" id="notificationState"></h1>   
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Set Reminder Message</label>
                            <input type="hidden"  name="id" id="id"  required class="form-control"  >
                            <textarea cols="40" class="form-control no-resize" rows="4" name="text" id="text"></textarea>
                        </div>
                    </div>

                    <script type="text/javascript">
                        $(".demo-preloader").css("display","none");
                    </script>

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
              
                 
                    <div class="modal-footer">  
                        <input type="submit" class=" btn btn-raised g-bg-cyan" value="Send">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>





</section>
<div class="color-bg"></div>