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
<link  rel="stylesheet" href="<?php echo $base_url; ?>assets/plugins/sweetalert/sweetalert.css">

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
        <?php if($codeExist==1){ ?>
                            <form class="card" method="post" id="passwordForm">
                            <div class="input-group icon before_span">
                    <span class="input-group-addon">  </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required autofocus>
                   
                    </div>
                </div>
                <div class="input-group icon before_span">
                    <span class="input-group-addon">  </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="confPassword" id="confPassword" placeholder="Confirm Password" required autofocus>
                        <span class="errResetPassword" style="color:red"></span>
                   
                    </div>
                </div>
						
                                    <input type="hidden" name="us_id" value="<?php echo $_GET['us'] ?>">
									
							<div class="col-sm-12 text-center">
                                    <?php if(!isset($ptype)){ ?>
										<button attrb="web" type="submit" class="btn btn-raised waves-effect g-bg-cyan ">Submit</button>
                                    <?php } else { ?>
										<button attrb=<?php echo $ptype; ?> type="submit" class="btn btn-raised waves-effect g-bg-cyan ">Submit</button>
                                    <?php } ?>
									</div>
								</div>								
							</form>
                            <?php } else{ ?>
                                <div class="card card-body p-6">
                                    <h2 style="text-align:center">Invalid Link</h2>
									<div class="text-center text-muted mt-3 ">
									Forget it, <a href="<?php echo $base_url; ?>auth">send me back</a> to the sign in screen.
								    </div>
                                </div>
                            <?php } ?>
        </div>
    </div>
</div>
<div class="theme-bg"></div>




<script src="<?php echo $base_url; ?>assets/js/jquery.min.js"></script>

<!-- Jquery Core Js -->
<script src="<?php echo $base_url ?>assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?php echo $base_url ?>assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="<?php echo $base_url; ?>assets/plugins/sweetalert/sweetalert.min.js"></script>

<script src="<?php echo $base_url ?>assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
<script src="<?php echo $base_url; ?>assets/js/main.js"></script>

</body>

<!-- Mirrored from thememakker.com/templates/swift/hospital/forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 20 Jun 2020 08:51:24 GMT -->
</html>