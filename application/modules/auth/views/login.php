<!DOCTYPE html>
<html>

<!-- Mirrored from thememakker.com/templates/swift/hospital/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 20 Jun 2020 08:51:10 GMT -->
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>Smile Centers</title>
<!-- <link rel="icon" href="favicon.ico" type="image/x-icon"> -->
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" type="text/css">

<!-- Custom Css -->
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/main.css"/>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/custome.css" />


</head>

<body class="theme-cyan authentication">
<img src="<?php echo $base_url; ?>assets/images/smilecenterspc.png" class="logo"/>

<div class="container">

    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>Smile Centers</span>Login <span class="msg"></span></h1>
        <div class="body">
            <form id="login" method="post" >
                <div class="input-group icon before_span">
                    <span class="input-group-addon"> <i class="zmdi zmdi-account"></i> </span>
                    <div class="form-line">
                        <input type="text" class="form-control" name="email_address" placeholder="Email" id="email_address" required   autofocus>
                        <span class="errLoginUser" style="color: red;padding:0"  ></span>
                        

                    </div>
                </div>
                 <div class="input-group icon before_span">
                    <span class="input-group-addon"> <i class="zmdi zmdi-lock"></i> </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Password" id="userPassword" maxlength="20" required>
                        <span class="errLoginPass" style="color: red;padding:0"></span>
                    </div>
                </div>
                <!-- <div> -->
                   
                   
                    <div class="text-center">
                        <input type="submit" class="btn btn-raised waves-effect g-bg-cyan login-button" value="SIGN IN" >
                    </div>
                    <div class="text-center" style="margin-top:15px;"> <a href="<?php echo $base_url; ?>auth/forgot">Forgot Password?</a></div>
                <!-- </div> -->
            </form>
        </div>
    </div>    
</div>
<div class="theme-bg"></div>



<script src="<?php echo $base_url; ?>assets/js/jquery.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/main.js"></script>



<!-- Jquery Core Js --> 
<!-- <script src="<?php echo $base_url; ?>assets/bundles/libscripts.bundle.js"></script> Lib Scripts Plugin Js -->
<script src="<?php echo $base_url; ?>assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

<script src="<?php echo $base_url; ?>assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
</body>

<!-- Mirrored from thememakker.com/templates/swift/hospital/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 20 Jun 2020 08:51:10 GMT -->
</html>