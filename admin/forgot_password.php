
<?php
session_start();
error_reporting(0);

// include('includes/config.php');
include('includes/config_company.php');
require_once('PHPMailer/PHPMailerAutoload.php');

if($_SESSION['alogin']!=''){
    $_SESSION['alogin']='';
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "SELECT * from user_info WHERE email = '".$_POST['email']."'";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);

    // echo '<script>alert("results: '.count($results).'")</script>'; 
    if(count($results)){

    // $sender = "thanawat@buildersmart.com";
    // $smtp_user = 'smbooking@smresorts.asia';
    // $smtp_pass = 'Bsm@2023';
    // $smtp_user = 'helpdesk@buildersmart.com';
    // $smtp_pass = 'Hor93452';
    $sender = $_POST['email'];

     $smtp_user = 'info@installdirect.asia';
    // $smtp_pass = 'Install@2024';
     $smtp_pass = 'Bsm@2024';
    //$smtp_user   = "helpdesk@buildersmart.com";
    //$smtp_pass   = "Hor93452";
     
     

        $key=md5(time()+123456789% rand(4000, 55000000));
        // $msg = "Please click link as below for create new password in SmartBroker system.". "\r\n"."http://brokerapp.installdirect.asia:8742/forgot_password_reset.php?key=".$key."&email=".$_POST['email'];
        $msg = "Please click link as below for create new password in SmartBroker system.". "\r\n"."http://www.brokerapp.asia/forgot_password_reset.php?key=".$key."&email=".$_POST['email'];

        $sql = "INSERT INTO forget_password (email,temp_key,created) values (:email_p,:temp_key_p,GETDATE()) ";
        $query = $dbh->prepare($sql); 
        $query->bindParam(':email_p',$_POST['email'],PDO::PARAM_STR);
        $query->bindParam(':temp_key_p',$key,PDO::PARAM_STR);
        $query->execute();
        // print_r($query->errorInfo());
        // $dbh->lastInsertId();

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAutoTLS = false;
        $mail->SMTPAuth    = true;
        $mail->SMTPSecure  = "tls";
        $mail->Host        = "smtp-legacy.office365.com";
        $mail->Mailer      = "smtp";
        $mail->Port        = "587";
        $mail->Username    = $smtp_user;
        $mail->Password    = $smtp_pass;

         $mail->SetFrom('info@installdirect.asia', 'installdirect');
        //$mail->SetFrom('helpdesk@buildersmart.com', 'Helpdesk');

        $mail->isHTML(true);
        $mail->CharSet = "utf-8";
        $mail->Subject = "Request change password for SmartBroker system.";
        $mail->AddAddress($sender, "Receiver");
        
        $requester_details ="requester_details";
        $issue_data = "issue_data";
        $assign_to  = "assign_to";
        
        $mail->Body = $msg; 
        if (!$mail->send()) {
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            // echo 'successfully';
        }

        $message_success="Please check your email inbox.";
    }else{
        $message="Sorry! no account associated with this email.";
    }
}

$dbh = null;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Broker Install Direct</title>
        <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script> -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
	<style>
		h1, h2, h3, h4, h5, h6, b, span, p, table, a, div, label, ul, li,
		button {
			font-family: Manrope, 'IBM Plex Sans Thai';
		}
		
		body {
		font-family: sans-serif;
		margin: 0;
		padding: 0;
		/*background-color: #f4f4f4;
		background-color: #0008ff6b;
		background-color: #10295880;*/
		/*background-color: #102958;*/
	}

	h4 {
		text-align: center;
		margin-bottom: 20px;
	}

	label {
		display: block;
		margin-bottom: 5px;
	}

	input[type="text"],
	input[type="password"] {
		width: 100%;
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 5px;
		margin-bottom: 20px;
	}

	
	.btn {
		padding: 10px 16px !important;
	}
	.btn:hover {
		background-color: #102958 !important;
	}
	
	.form-control {
		height: 40px !important;
	}
	</style>

<body class="">
    <div class="main-wrapper mt-5">
    <div class="">
        <div class="row">
            <div class="col-lg-3"></div>

            <div class="col-lg-6">
                <div class="row mt-1">
                    <div class="col-md-10 col-md-offset-1 pt-1">
                        <div class="row mt-30">
                            <div class="col-md-12">
                                <div class="panel" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

                                    <div class="panel-heading">
                                        <div class="panel-title d-flex justify-content-center align-items-center" style="margin: 20px;">
                                            <img src="logo_s.png" alt="Logo" height="120px" style="width: 170px;">
                                        </div>
                                        <div class="panel-title text-center">
                                            <h1 align="center" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">Smart Booking Admin Panel</h1>
                                        </div>
                                    </div>

                                    <div class="panel-heading">
                                        <div class="panel-title text-center" style="margin-top: 20px;">
                                            <h4>Please enter your email to recover your password</h4>
                                        </div>
                                    </div>

                                    <div class="panel-body p-20" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">

                                        <form class="form-horizontal" method="post">
                                            <div class="form-group">
                                                <!-- <label for="inputEmail3" class="col-sm-2 control-label">Email</label> -->
                                                <div class="col-sm-12">
                                                    <input id="email" name="email" type="text" class="form-control" placeholder="Email" required>
                                                </div>
                                            </div>

                                            <?php if (isset($error)) : ?>
                                                <div class='alert alert-danger' role='alert'>
                                                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                                                    <span class='sr-only'>Error:</span><?php echo $error; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($message <> "") : ?>
                                                <div class='alert alert-danger' role='alert'>
                                                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                                                    <span class='sr-only'>Error:</span><?php echo $message; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (isset($message_success)) : ?>
                                                <div class='alert alert-success' role='alert'>
                                                    <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                                    <span class='sr-only'>Success:</span><?php echo $message_success; ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="form-group mt-20">
                                                <div class="col-sm-6 text-left">
                                                    <a href="index.php" style="color: #4590B8;">Back to Login</a>
                                                </div>

                                                <div class="col-sm-6 text-right">
                                                    <button type="submit" style="background-color: #0275d8;color: #F9FAFA;" name="login" class="btn button">Send Email<span class="btn-label btn-label-right"><i class="fa "></i></span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-md-11 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /. -->
</div>

        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function(){

            });
        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>


