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

    <!-- <li>
        <a href="javascript:void(0);">
            <div class="menu-info">
                <h4>John request an appointment</h4>
                <div style="width:50%;float:left;">
                    <p><i class="material-icons">access_time</i> 14 mins ago</p>
                </div>
                <div style="width:50%;float:right;">
                    <button style="float: right;margin-right: 25px;">View</button>
                </div>
                
            </div>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);">
            <div class="menu-info">
                <h4>David request an emergency</h4>
                <div style="width:50%;float:left;">
                    <p><i class="material-icons">access_time</i> 12 mins ago</p>
                </div>
                <div style="width:50%;float:right;">
                    <button style="float: right;margin-right: 25px;">View</button>
                </div>
            </div>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);">
            <div class="menu-info">
                <h4>Mike request an emergency</h4>
                <div style="width:50%;float:left;">
                    <p><i class="material-icons">access_time</i> 11mins ago</p>
                </div>
                <div style="width:50%;float:right;">
                    <button style="float: right;margin-right: 25px;">View</button>
                </div>
            </div>
        </a>
    </li>
    <li>
        <a href="javascript:void(0);">
            <div class="menu-info">
                <h4>1 message from Mike</h4>
                <div style="width:50%;float:left;">
                    <p><i class="material-icons">access_time</i> 9 mins ago</p>
                </div>
                <div style="width:50%;float:right;">
                    <button style="float: right;margin-right: 25px;">View</button>
                </div>
            </div>
        </a>
    </li> -->
    <div class="col-lg-12 col-md-6 col-sm-6">
                <div class="card">
                    <div class="header">
                        <h2>Notifications</h2>
                        <!-- <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu float-right">
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                    <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                </ul>
                            </li>
                        </ul> -->
                    </div>
                    <div class="body">
                        <ul class="basic-list">
                            <li>Mike request an emergency <button type="button" class="btn  btn-raised btn-info waves-effect">INFO</button></li>
                            <li>John request an appointment <button type="button" class="btn  btn-raised btn-info waves-effect">INFO</button></li>
                            <li>David request an appointment<button type="button" class="btn  btn-raised btn-info waves-effect">INFO</button></li>
                            <li>1 message from Mike <button type="button" class="btn  btn-raised btn-info waves-effect">INFO</button></li>
                            <li>1 message from George <button type="button" class="btn  btn-raised btn-info waves-effect">INFO</button></li>
                            <li>2 messages from Lily <button type="button" class="btn  btn-raised btn-info waves-effect">INFO</button></li>
                        </ul>
                    </div>
                </div>
            </div>

</section>

<div class="color-bg"></div>