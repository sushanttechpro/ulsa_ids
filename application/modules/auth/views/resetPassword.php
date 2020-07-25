<!DOCTYPE html>
<html>

<!-- Mirrored from thememakker.com/templates/swift/hospital/forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 20 Jun 2020 08:51:24 GMT -->
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>Smile Centers</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo $base_url ?>assets/plugins/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" type="text/css">

<!-- Custom Css -->
<link rel="stylesheet" href="<?php echo $base_url ?>assets/css/main.css"/>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/custome.css" />

</head>

<body class="theme-cyan authentication">
<img src="<?php echo $base_url; ?>assets/images/smilecenterspc.png" class="logo"/>

<div class="container">
    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>Smile Centers</span>Forgot Password? <div class="msg">Enter your e-mail address below to reset your password.</div></h1>
        <div class="body">
            <form method="post" id="resetPasswordForm">
                <div class="input-group icon before_span">
                    <span class="input-group-addon"> <i class="zmdi zmdi-email"></i> </span>
                    <div class="form-line">
                        <input type="email" class="form-control" name="email" id="email_address" placeholder="Email" required autofocus>
                        <span class="err errResetEmail"></span>
                   
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
										<button type="submit" class="btn btn-raised waves-effect g-bg-cyan ">RESET MY PASSWORD</button>

                        <!-- <a href="index.html" class="btn btn-raised waves-effect g-bg-cyan">RESET MY PASSWORD</a> -->
                    </div>
                    <div class="col-sm-12 text-center"> <a href="<?php echo $base_url ?>auth">Sign In!</a> </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="theme-bg"></div>




<script src="<?php echo $base_url; ?>assets/js/jquery.min.js"></script>
<script src="<?php echo $base_url; ?>assets/js/main.js"></script>

<!-- Jquery Core Js -->
<script src="<?php echo $base_url ?>assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?php echo $base_url ?>assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

<script src="<?php echo $base_url ?>assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
</body>

<!-- Mirrored from thememakker.com/templates/swift/hospital/forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 20 Jun 2020 08:51:24 GMT -->
</html>