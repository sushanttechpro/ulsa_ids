<?php 
date_default_timezone_set('Asia/Kolkata');

if($this->session->userdata('ulsa_id')){
    $this->load->model('Dashboard/Dashboard_model');
    $notificationAppt = $this->Dashboard_model->getNotificationAppt();
    $newMessages= $this->Dashboard_model->getNewMessages();
    // print_r($notificationAppt); die;
// print_r($newMessages);


}else{
    redirect('auth');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<link href='https://fonts.googleapis.com/css?family=Titillium Web' rel='stylesheet'>


    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <!-- <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" /> -->

<!-- <link rel="stylesheet" href="assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"/> -->

<link href="<?php echo $base_url; ?>assets/css/timepicker.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" /> -->

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" /> -->


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/bootstrap-select/css/bootstrap-select.css" />

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/dropzone/dropzone.css" />

    <!-- <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fullcalendar/fullcalendar.min.css" /> -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/fullcalendar/fullcalendar.min.css"/>
    


    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/ion-rangeslider/css/ion.rangeSlider.css" />

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/ion-rangeslider/css/ion.rangeSlider.skinFlat.css" />

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css" />

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css" />

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/morrisjs/morris.css" />

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/nestable/jquery-nestable.css" />

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/sweetalert/sweetalert.css" />

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/waitme/waitMe.css" />

    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/main.css" />
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/custome.css" />


<title>Smile Centers</title>
</head>
<body class="theme-cyan">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-cyan">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- #Float icon -->
<!-- <ul id="f-menu" class="mfbc-br mfb-zoomin" data-mfb-toggle="hover">
    <li class="mfbc_wrap">
        <a href="javascript:void(0);" class="mfbcb-main g-bg-cyan">
            <i class="mfbcm-icon-resting zmdi zmdi-plus"></i>
            <i class="mfbcm-icon-active zmdi zmdi-close"></i>
        </a>
        <ul class="mfbc_list">
            <li><a href="doctor-schedule.html" data-mfb-label="Doctor Schedule" class="mfb-child bg-blue"><i class="zmdi zmdi-calendar mfbc_icon"></i></a></li>
            <li><a href="patients.html" data-mfb-label="Patients List" class="mfb-child bg-orange"><i class="zmdi zmdi-account-o mfbc_icon"></i></a></li>
            <li><a href="payments.html" data-mfb-label="Payments" class="mfb-child bg-purple"><i class="zmdi zmdi-balance-wallet mfbc_icon"></i></a></li>
        </ul>
    </li>
</ul> -->

<!-- Morphing Search  -->
<div id="morphsearch" class="morphsearch">
    <!-- <form class="morphsearch-form">
        <div class="form-group m-0">
            <input value="" type="search" placeholder="Explore Swift..." class="form-control morphsearch-input" />
            <button class="morphsearch-submit" type="submit">Search</button>
        </div>
    </form> -->
    <div class="morphsearch-content">
        <div class="dummy-column">
            <h2>People</h2>
            <a class="dummy-media-object" href="javascript:void(0);"><img class="rounded" src="assets/images/xs/avatar1.jpg" alt=""/><h3>Sara Soueidan</h3></a>
 
        </div>
        <div class="dummy-column">
            <h2>Popular</h2>
            <a class="dummy-media-object" href="javascript:void(0);"><img class="rounded" src="assets/images/xs/avatar5.jpg" alt=""/><h3>Sara Soueidan</h3></a>

        </div>
        <div class="dummy-column">
            <h2>Recent</h2>
            <a class="dummy-media-object" href="javascript:void(0);"><img class="rounded" src="assets/images/xs/avatar1.jpg" alt=""/><h3>Sara Soueidan</h3></a>

        </div>
    </div>    
    <span class="morphsearch-close"></span>
</div>

<!-- Top Bar -->
<nav class="navbar clearHeader">
    <div class="col-12">

        <?php   if($this->session->userdata('usertype')==2){?>
            <!-- <img src="<?= $base_url.$this->session->userdata('clinic_logo');?>"  style="width:50px;height:50px;vertical-align:middle;border-radius:50%;  margin-bottom: 30px;" alt="logo"> -->

        <div class="navbar-header"> <a href="javascript:void(0);" class="bars">
        </a> <a class="navbar-brand" href="<?php echo $base_url   ?>dashboard">Smile Centers<span style="font-size:12px;margin-left:5px;">(<?=$this->session->userdata('clinic_name'); ?>)</span></a> </div>
    <?php }else{ ?>
        <div class="navbar-header"> <a href="javascript:void(0);" class="bars"></a> <a class="navbar-brand" href="<?php echo $base_url   ?>dashboard">Smile Centers</a> </div>
    <?php  }?>

        <ul class="nav navbar-nav navbar-right">
            <!-- Notifications -->
            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-notifications"></i> <span class="label-count"><?php if(isset($notificationAppt)){ echo count($notificationAppt);} else { echo 0;} ?></span> </a>



                <ul class="dropdown-menu">
                    <li class="header">NOTIFICATIONS</li>
                    <li class="body">
                        <ul class="menu">
                        <?php if(isset($notificationAppt)){ foreach ($notificationAppt as $key) { 
                            $start_date = new DateTime();
                            $since_start = $start_date->diff(new DateTime($key->appointment_date));
                        ?>
                            <li>
                                <a href="javascript:void(0);">
                                    <!-- <div class="icon-circle bg-light-green"><i class="zmdi zmdi-open-in-new"></i></div> -->
                                    <div class="menu-info">
                                        <h4><?= $key->name.' '.$key->lastname.' request for an appointment' ?></h4>
                                        <p><i class="material-icons">access_time</i><?= $since_start->i ?>  mins ago</p>
                                    </div>
                                </a>
                            </li>
                        <?php } } else { ?>
                            <div style="margin-top: 100px; color: #616161; text-align: center;">
                                No New Notifications
                            </div>
                        <?php } ?>
                        </ul>
                    </li>
                    <li class="footer"> <a href="<?php  echo $base_url; ?>notification">View All Notifications</a> </li>
                </ul>
            </li>

            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i style="color: white;" class="material-icons">chat</i> <span class="label-count"><?php if(isset($newMessages)){ echo count($newMessages);} else { echo 0;} ?></span> </a>

                <ul class="dropdown-menu">
                    <li class="header">Messages</li>
                    <li class="body">
                        <ul class="menu">
                        <?php if(isset($newMessages)){ foreach ($newMessages as $key) { 
                            $start_date = new DateTime();
                            $since_start = $start_date->diff(new DateTime($key->created_date));
                        ?>
                            <li>
                                <a href="<?php  echo $base_url.'chat/chats?id='.$key->user_id; ?>">
                                    <div class="menu-info">
                                        <h4><?= $key->name.' '.$key->lastname.' sends a message' ?></h4>
                                        <p style="color: blue; font-size: 12px; margin-top: 4px;"><?= $key->usermsg ?></p>
                                        <p><i class="material-icons">access_time</i><?= $since_start->i ?>  mins ago</p>
                                    </div>
                                </a>
                            </li>
                        <?php } } else { ?>
                        <div style="margin-top: 100px; color: #616161; text-align: center;">
                            No New Messages</div>
                        <?php } ?>
                        </ul>
                    </li>
                    <li class="footer"> <a href="<?php  echo $base_url; ?>chat">View All Messages</a> </li>
                </ul>
            </li>

           
            <!-- <div class="demo-google-material-icon"> <a href="<?php  echo $base_url; ?>chat" role="button"> <i style="color: white; margin-left: 6px; margin-top: 5px;" class="material-icons">chat</i></a> <span class="icon-name"></span></div> -->

            <!-- #END# Notifications --> 
            <!-- Tasks -->
            <!-- <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-flag"></i><span class="label-count">9</span> </a> -->
                <ul class="dropdown-menu">
                    <li class="header">TASKS</li>
                    <li class="body">
                        <ul class="menu tasks">
                            <li>
                                <a href="javascript:void(0);">
                                    <h4> Task 1 <small>32%</small> </h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%"> </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <h4>Task 2 <small>45%</small> </h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%"> </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <h4>Task 3 <small>54%</small> </h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%"> </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <h4> Task 4 <small>65%</small> </h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%"> </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer"><a href="javascript:void(0);">View All Tasks</a></li>
                </ul>
            </li>
            <!-- #END# Tasks -->
            <!-- <li><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="zmdi zmdi-settings"></i></a></li> -->
        </ul>
    </div>
</nav>
<!-- #Top Bar -->
<section> 
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar"> 
        <!-- User Info -->
        <div class="user-info">
            
         <?php if($this->session->userdata('usertype')==1){?>
            <div class="admin-image"> <img src="<?php echo $base_url ?>assets/images/random-avatar7.jpg" alt=""> </div>
            
         <?php  }?>
         <?php if($this->session->userdata('usertype')==2){?>

            <div class="admin-image">  <img src="<?= $base_url.$this->session->userdata('clinic_logo');?>"  style="width:60px;height:70px;" alt="logo"> </div>
         <?php  }?>
            <div class="admin-action-info"> <span>Welcome</span>
         <?php if($this->session->userdata('usertype')==1){?>
                <h3><?php echo $this->session->userdata('name').' '.$this->session->userdata('lastname')  ?></h3><br>
                <span>(Admin)</span>
         <?php  }else if($this->session->userdata('usertype')==2){?>
         <h3><?php echo $this->session->userdata('name').' '.$this->session->userdata('lastname')  ?>
                </h3>
         <?php  }?>
                <ul>
                    <!-- <li><a href="mail-inbox.html" title="Go to Inbox"><i class="zmdi zmdi-email"></i></a></li> -->
                    <li><a href="<?php echo $base_url; ?>dashboard/profile" title="Go to Profile"><i class="zmdi zmdi-account"></i></a></li>
                    <!-- <li><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="zmdi zmdi-settings"></i></a></li> -->
                    <li><a href="<?php echo $base_url; ?>auth/logout" title="sign out" ><i class="zmdi zmdi-sign-in"></i></a></li>
                </ul>
            </div>
            <div class="quick-stats">
                <!-- <h5>Today Report</h5>
                <ul>
                    <li><span>16<i>Appointment</i></span></li>
                    <li><span>20<i>Emergency</i></span></li>
                    <li><span>04<i>Offers</i></span></li>
                </ul> -->
            </div>
        </div>
        <!-- #User Info --> 
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <!-- <li class="header">MAIN NAVIGATION</li> -->
                <li class="active open dashmenu"><a href="<?php  echo $base_url ?>dashboard"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li> 

                <li class="apptmenu"><a href="<?php  echo $base_url ?>appointment" ><i class="zmdi zmdi-calendar-check"></i><span>Appointment</span> </a>
                </li>

                <!-- <li class="emermenu"><a href="<?php  echo $base_url ?>emergency" ><i class="zmdi zmdi-calendar-check"></i><span>Emergency</span> </a>
                </li> -->

                <?php   if($this->session->userdata('usertype')==1){?>
                <li class="usermenu"><a href="<?php echo $base_url ?>subadmin" class="menu-toggle"><i class="zmdi zmdi-account-add"></i><span>Users</span> </a>
                    <!-- <ul class="ml-menu">
                        <li><a href="<?php echo $base_url ?>subadmin">All Users</a></li>
                    </ul> -->
                </li> 
                <?php  } ?>

                <li class="docmenu"><a href="<?php echo $base_url ?>doctors" class="menu-toggle"><i class="fa fa-user-md"></i><span>Doctors</span> </a>
                    <!-- <ul class="ml-menu">
                        <li><a href="<?php echo $base_url ?>doctors">All Doctors</a></li>
                    </ul> -->
                </li>

                <?php   if($this->session->userdata('usertype')==1){?>
                <li class="clinicmenu"><a href="javascript:void(0);" class="menu-toggle"><i class="fa fa-hospital-o"></i><span>Office</span> </a>
                    <ul class="ml-menu">
                        <li><a href="<?php echo $base_url ?>clinic">All Office</a></li>
                    </ul>
                </li>
                <?php  }?>
                
                <?php   if($this->session->userdata('usertype')==2){?>
                    <li class="clinicmenu"><a href="<?php echo $base_url ?>clinic" class=""><i class="fa fa-hospital-o"></i><span>My Office</span> </a>
                    </li>
               <?php } ?>

                    



                <li class="patmenu"><a href="<?php echo $base_url  ?>users" class="menu-toggle"><i class="zmdi zmdi-account-o"></i><span>Patients</span> </a>
                    <!-- <ul class="ml-menu">
                        <li><a href="<?php echo $base_url  ?>users">All Patients</a></li>
                    </ul> -->
                </li>

                <li class="dentmenu"><a href="<?php echo $base_url ?>dentistry" class="menu-toggle"><i class="zmdi zmdi-balance-wallet"></i><span>Dentistry</span> </a>
                  <!-- <ul class="ml-menu">
                        <li> <a href="<?php echo $base_url ?>dentistry">All Dentistry</a></li>
                    </ul> -->
                </li>



                <li class="bracesmenu"><a href="<?php echo $base_url ?>braces" class="menu-toggle"><i class="zmdi zmdi-balance-wallet"></i><span>Braces</span> </a>
                    <!-- <ul class="ml-menu">
                        <li> <a href="<?php echo $base_url ?>braces">All Braces</a></li>
                    </ul> -->
                </li>

                <li class="spoffermenu"><a href="javascript:void(0);" class="menu-toggle"><i class="fa fa-gift"></i><span>Special Offers</span> </a>
                    <ul class="ml-menu">
                        <li><a href="<?php echo $base_url  ?>offers">All Offers</a></li>
                    </ul>
                </li>

                    <ul class="ml-menu">
                        <li> <a href="sign-in.html">Sign In</a> </li>
                        <li> <a href="sign-up.html">Sign Up</a> </li>
                        <li> <a href="forgot-password.html">Forgot Password</a> </li>
                        <li> <a href="404.html">Page 404</a> </li>
                        <li> <a href="500.html">Page 500</a> </li>
                        <li> <a href="page-offline.html">Page Offline</a> </li>
                        <li> <a href="locked.html">Locked Screen</a> </li>
                        <li> <a href="blank.html">Blank Page</a> </li>
                    </ul>
                </li>
                <!-- <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-swap-alt"></i><span>User Interface (UI)</span> </a> -->
                    <ul class="ml-menu">
                        <li> <a href="typography.html">Typography</a> </li>
                        <li> <a href="helper-classes.html">Helper Classes</a></li>
                        <li> <a href="alerts.html">Alerts</a> </li>
                        <li> <a href="animations.html">Animations</a> </li>
                        <li> <a href="badges.html">Badges</a> </li>
                        <li> <a href="breadcrumbs.html">Breadcrumbs</a> </li>
                        <li> <a href="buttons.html">Buttons</a> </li>
                        <li> <a href="collapse.html">Collapse</a> </li>
                        <li> <a href="colors.html">Colors</a> </li>
                        <li> <a href="dialogs.html">Dialogs</a> </li>
                        <li> <a href="icons.html">Icons</a> </li>
                        <li> <a href="labels.html">Labels</a> </li>
                        <li> <a href="list-group.html">List Group</a> </li>
                        <li> <a href="media-object.html">Media Object</a> </li>
                        <li> <a href="modals.html">Modals</a> </li>
                        <li> <a href="notifications.html">Notifications</a> </li>
                        <li> <a href="pagination.html">Pagination</a> </li>
                        <li> <a href="preloaders.html">Preloaders</a> </li>
                        <li> <a href="progressbars.html">Progress Bars</a> </li>
                        <li> <a href="range-sliders.html">Range Sliders</a> </li>
                        <li> <a href="sortable-nestable.html">Sortable & Nestable</a> </li>
                        <li> <a href="tabs.html">Tabs</a> </li>
                        <li> <a href="waves.html">Waves</a> </li>
                    </ul>
                </li>
                <!-- <li class="header">LABELS</li>
                <li> <a href="javascript:void(0);"><i class="zmdi zmdi-chart-donut col-red"></i><span>Important</span> </a> </li>
                <li> <a href="javascript:void(0);"><i class="zmdi zmdi-chart-donut col-amber"></i><span>Warning</span> </a> </li>
                <li> <a href="javascript:void(0);"><i class="zmdi zmdi-chart-donut col-blue"></i><span>Information</span> </a> </li> -->
            </ul>
        </div>
        <!-- #Menu -->
    </aside>
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#skins">Skins</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chat">Chat</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#settings">Setting</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane in active in active" id="skins">
                <ul class="demo-choose-skin">
                    <li data-theme="red"><div class="red"></div><span>Red</span> </li>
                    <li data-theme="purple"><div class="purple"></div><span>Purple</span> </li>
                    <li data-theme="blue"><div class="blue"></div><span>Blue</span> </li>
                    <li data-theme="cyan" class="active"><div class="cyan"></div><span>Cyan</span> </li>
                    <li data-theme="green"><div class="green"></div><span>Green</span> </li>
                    <li data-theme="deep-orange"><div class="deep-orange"></div><span>Deep Orange</span> </li>
                    <li data-theme="blue-grey"><div class="blue-grey"></div><span>Blue Grey</span> </li>
                    <li data-theme="black"><div class="black"></div><span>Black</span> </li>
                    <li data-theme="blush"><div class="blush"></div><span>Blush</span> </li>
                </ul>
            </div>
            <div role="tabpanel" class="tab-pane" id="chat">
                <div class="demo-settings">
                    <div class="search">
                        <div class="input-group">
                            <div class="form-line">
                                <input type="text" class="form-control" placeholder="Search..." required autofocus>
                            </div>
                        </div>
                    </div>
                    <h6>Recent</h6>
                    <ul>
                        <li class="online">
                            <div class="media">
                                <a href="javascript:void(0);"><img class="media-object " src="assets/images/xs/avatar1.jpg" alt=""></a>
                                <div class="media-body">
                                    <span class="name">Claire Sassu</span>
                                    <span class="message">Can you share the</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </li>
                        <li class="online">
                            <div class="media">
                                <a href="javascript:void(0);"><img class="media-object " src="assets/images/xs/avatar2.jpg" alt=""></a>
                                <div class="media-body">
                                    <span class="name">Maggie jackson</span>
                                    <span class="message">Can you share the</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </li>
                        <li class="online">
                            <div class="media">
                                <a href="javascript:void(0);"><img class="media-object " src="assets/images/xs/avatar3.jpg" alt=""></a>
                                <div class="media-body">
                                    <span class="name">Joel King</span>
                                    <span class="message">Ready for the meeti</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <h6>Contacts</h6>
                    <ul class="contacts_list">
                        <li class="offline">
                            <div class="media">
                                <a href="javascript:void(0);"><img class="media-object " src="assets/images/xs/avatar4.jpg" alt=""></a>
                                <div class="media-body">
                                    <span class="name">Hossein Shams</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </li>
                        <li class="online">
                            <div class="media">
                                <a href="javascript:void(0);"><img class="media-object " src="assets/images/xs/avatar1.jpg" alt=""></a>
                                <div class="media-body">
                                    <span class="name">Maryam Amiri</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </li>
                        <li class="offline">
                            <div class="media">
                                <a href="javascript:void(0);"><img class="media-object " src="assets/images/xs/avatar2.jpg" alt=""></a>
                                <div class="media-body">
                                    <span class="name">Gary Camara</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="settings">
                <div class="demo-settings">
                    <p>General settings</p>
                    <ul class="setting-list">
                        <li>
                        	<span>Report Panel Usage</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" checked>
                                    <span class="lever"></span>
                            	</label>
                            </div>
                        </li>
                        <li>
                        	<span>Email Redirect</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox">
                                    <span class="lever"></span>
                            	</label>
                            </div>
                        </li>
                    </ul>
                    <p>System settings</p>
                    <ul class="setting-list">
                        <li>
                        	<span>Notifications</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" checked>
                                    <span class="lever"></span>
                            	</label>
                            </div>
                        </li>
                        <li>
                        	<span>Auto Updates</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" checked>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </li>
                    </ul>
                    <p>Account settings</p>
                    <ul class="setting-list">
                        <li>
                        	<span>Offline</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox">
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </li>
                        <li>
                        	<span>Location Permission</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" checked>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</section>
    
