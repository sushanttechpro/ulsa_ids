
<section class="content home">
    <div class="">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6">
          
                <div class="info-box-4 hover-zoom-effect">
                <a href="<?php echo $base_url   ?>users">
                    <div class="icon">   <i class="zmdi zmdi-account col-blue"></i> </div>
                    <div class="content">
                        <div class="text">New Patients Registered</div>
                        <div class="number" id="totalusers"><?= $totalUsers ?></div>
                    </div>
                </a>
                </div>
           
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                <a href="<?php echo $base_url   ?>appointment">

                    <div class="icon"> <i class="zmdi zmdi-account col-green"></i> </div>
                    <div class="content">
                        <div class="text">Confirmed Appointments</div>
                        <div class="number" id="cnfApp"><?= $totalconfApp ?></div>
                    </div>
                </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                <!-- <a href="#"> -->
                <a href="<?php echo $base_url   ?>appointment">

                    <div class="icon"> <i class="zmdi zmdi-bug col-blush"></i> </div>
                    <div class="content">
                        <div class="text">New Requests</div>
                        <div class="number" id="newApp"><?= $totalnewApp ?></div>
                        
                    </div>
                </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                <a href="<?php echo $base_url   ?>doctors">
                    <div class="icon"> <i class="fa fa-user-md col-cyan"></i>  </div>
                    <div class="content">
                        <div class="text">Available Doctors</div>
                        <div class="number"><?= $totalDoctors ?></div>
                    </div>
                </a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="info-box-4 hover-zoom-effect">
                <a href="<?php echo $base_url   ?>emergency">
                    
                    <div class="icon"> <i class="zmdi zmdi-bug col-blush"></i> </div>
                    <div class="content">
                        <div class="text">Emergencies</div>
                        <div class="number"><?=  $totalEmergency ?></div>
                    </div>
                </a>
                </div>
            </div>


        </div>
        <!-- <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Hospital Survey</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu float-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul> 
                    </div>
                    <div class="body">
                        <canvas id="line_chart" height="70"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row clearfix">
            <div class=" col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="header"> -->
                        <!-- <h2>New Patient <small >18% High then last month</small></h2> -->
                        <!-- <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu float-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul> -->
                    <!-- </div> -->
                    <!-- <div class="body">
                        <div class="stats-report">
                            <div class="stat-item">
                                <h5>Overall</h5>
                                <b class="col-indigo">70.40%</b></div>
                            <div class="stat-item">
                                <h5>Montly</h5>
                                <b class="col-indigo">25.80%</b></div>
                            <div class="stat-item">
                                <h5>Day</h5>
                                <b class="col-indigo">12.50%</b></div>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="3" data-highlight-Spot-Color="rgb(63, 81, 181)" data-highlight-Line-Color="#222"
                                 data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(63, 81, 181)" data-spot-Color="rgb(63, 81, 181, 0.7)"
                                 data-offset="90" data-width="100%" data-height="100px" data-line-Width="1" data-line-Color="rgb(63, 81, 181, 0.7)"
                                 data-fill-Color="rgba(63, 81, 181, 0.3)"> 6,1,3,3,6,3,2,2,8,2 </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class=" col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="header"> -->
                        <!-- <h2>Heart Surgeries <small>18% High then last month</small></h2> -->
                        <!-- <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu float-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="stats-report">
                            <div class="stat-item">
                                <h5>Overall</h5>
                                <b class="col-blue-grey">80.40%</b></div>
                            <div class="stat-item">
                                <h5>Montly</h5>
                                <b class="col-blue-grey">13.00%</b></div>
                            <div class="stat-item">
                                <h5>Day</h5>
                                <b class="col-blue-grey">9.50%</b></div>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="3" data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                                 data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(96, 125, 139)" data-spot-Color="rgb(96, 125, 139, 0.7)"
                                 data-offset="90" data-width="100%" data-height="100px" data-line-Width="1" data-line-Color="rgb(96, 125, 139, 0.7)"
                                 data-fill-Color="rgba(96, 125, 139, 0.3)"> 6,4,7,8,4,3,2,2,5,6,7,4,1,5,7,9,9,8,7,6 </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class=" col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="header">
                        <!-- <h2>Medical Treatment <small>18% High then last month</small></h2> -->
                        <!-- <ul class="header-dropdown"> -->
                            <!-- <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu float-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li> -->
                                <!-- </ul>
                            </li>
                        </ul>
                    </div>  -->
                    <!-- <div class="body">
                        <div class="stats-report">
                            <div class="stat-item">
                                <h5>Overall</h5>
                                <b class="col-green">84.60%</b></div>
                            <div class="stat-item">
                                <h5>Montly</h5>
                                <b class="col-green">15.40%</b></div>
                            <div class="stat-item">
                                <h5>Day</h5>
                                <b class="col-green">5.10%</b></div>
                        </div> -->
                        <!-- <div class="sparkline" data-type="line" data-spot-Radius="3" data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                                 data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(120, 184, 62)" data-spot-Color="rgb(120, 184, 62, 0.7)"
                                 data-offset="90" data-width="100%" data-height="100px" data-line-Width="1" data-line-Color="rgb(120, 184, 62, 0.7)"
                                 data-fill-Color="rgba(120, 184, 62, 0.3)"> 6,4,7,6,9,3,3,5,7,4,2,3,7,6 </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
        <div class="header">
                        <h2 style="width:50%;float:left;">Today's Emergency List  </h2>
                        <a href="<?php echo base_url(); ?>emergency" style="float:right;">View All Emergencies</a>
                    </div>
        <div class="body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#approvedemergency">Confirmed Emergencies</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pendingemergency">New Emergencies</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cancelledemergency">Cancelled Emergencies</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane in active" id="approvedemergency">
                    <div class="body table-responsive">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div style="padding-bottom: 0px !important;" class="header">
                                        <h2 style="width:50%; float:left;"></h2>
                                    </div>
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="emergency_table" data-id="3">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <!-- <th>Doctor Name</th> -->
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
                <div role="tabpanel" class="tab-pane" id="pendingemergency">
                    <div class="body table-responsive">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div style="padding-bottom: 0px !important;" class="header">
                                        <h2 style="width:50%; float:left;"></h2>
                                    </div>
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="emergency_table_pend" data-id="4">
                                        <thead>
                                            <tr>
                                            <th>S.No</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>

                                                <!-- <th>Doctor Name</th> -->
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
                <div role="tabpanel" class="tab-pane" id="cancelledemergency">
                    <div class="body table-responsive">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div style="padding-bottom: 0px !important;" class="header">
                                        <h2 style="width:50%; float:left;"></h2>
                                    </div>
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="emergency_table_dec" data-id="5">
                                        <thead>
                                            <tr>
                                            <th>S.No</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>

                                                <!-- <th>Doctor Name</th> -->
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
                </div></div></div>


        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2 style="width:50%;float:left;">Today's Appointment List  </h2>
                        <a href="<?php echo base_url(); ?>appointment" style="float:right;">View All Appointments</a>
                    </div>
                    <div class="body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#approved">Confirmed Appointments</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pending">New Requests</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cancelled">Cancelled Appointments</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane  in active" id="approved">
                            <div class="body table-responsive">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div style="padding-bottom: 0px !important;" class="header">
                                                 <h2 style="width:50%; float:left;"></h2>
                                                </div>
                                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="appointment_dashboard" data-id="1">
                                                     <thead>
                                                    <tr>
                                                    <th>S.No</th>
                                                    <th>First Name</th>
                                                    <!-- <th>Last Name</th> -->
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Service</th>
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
                        <div role="tabpanel" class="tab-pane" id="pending">
                            <div class="body table-responsive">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div style="padding-bottom: 0px !important;" class="header">
                                                 <h2 style="width:50%; float:left;"></h2>
                                                </div>
                                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="appointment_dashboard_pend" data-id="0">
                                                     <thead>
                                                    <tr>
                                                    <th>S.No</th>
                                                    <th>First Name</th>
                                                    <!-- <th>Last Name</th> -->
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Service</th>
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
                                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="appointment_dashboard_cancel" data-id="2">
                                                     <thead>
                                                    <tr>
                                                    <th>S.No</th>
                                                    <!-- <th>First Name</th> -->
                                                    <th>First Name</th>
                                                    <!-- <th>Last Name</th> -->
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Service</th>
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
        </div>
    </div>
        <!-- <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card">
                    <div class="header">
                        <h2>PATIENT prograss</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu float-right">
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <ul class="basic-list">
                            <li>Mark Otto <span class="label-danger label">21%</span></li>
                            <li>Jacob Thornton <span class="label-purple label">50%</span></li>
                            <li>Jacob Thornton<span class="label-success label">90%</span></li>
                            <li>M. Arthur <span class="label-info label">75%</span></li>
                            <li>Jacob Thornton <span class="label-warning label">60%</span></li>
                            <li>M. Arthur <span class="label-success label">91%</span></li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card">
                    <div class="header">
                        <h2>PATIENT Reports</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu float-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Charts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dean Otto</td>
                                        <td>
                                            <span class="sparkbar">5,8,6,3,5,9,2</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>K. Thornton</td>
                                        <td>
                                        <span class="sparkbar">10,8,9,3,5,8,5</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kane D.</td>
                                        <td>
                                            <span class="sparkbar">7,5,9,3,5,2,5</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jack Bird</td>
                                        <td>
                                            <span class="sparkbar">1,8,2,3,9,8,5</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hughe L.</td>
                                        <td>
                                            <span class="sparkbar">10,8,1,3,2,8,5</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Visits from countries</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu float-right">
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <ul class="country-state">
                            <li class="m-b-20">                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">6350</h5>
                                    <small>From India 58%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:58%;"> <span class="sr-only">58% Complete</span></div>
                                </div>
                            </li>
                            <li class="m-b-20">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">3250</h5>
                                    <small>From UAE 90%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:90%;"> <span class="sr-only">90% Complete</span></div>
                                </div>
                            </li>
                            <li class="m-b-20">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">1250</h5>
                                    <small>From Australia 70%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:70%;"> <span class="sr-only">70% Complete</span></div>
                                </div>
                            </li>
                            <li  class="m-b-20">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">1350</h5>
                                    <small>From USA 70%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:70%;"> <span class="sr-only">70% Complete</span></div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">1250</h5>
                                    <small>From UK 65%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:65%;"> <span class="sr-only">65% Complete</span></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>            
        </div>
	</div> -->
</section>

<div class="color-bg"></div>