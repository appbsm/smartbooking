<?php
require_once('PHPMailer/PHPMailerAutoload.php');
echo "email:".$_POST['reset_email'];
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$sender = $_POST['reset_email'];
    $smtp_user = 'info@installdirect.asia';
    $smtp_pass = 'Bsm@2024';
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
    $mail->isHTML(true);
    $mail->CharSet = "utf-8";
    $mail->Subject = "Request change password for SmartBroker system.";
    $mail->AddAddress($sender, "Receiver");

    $requester_details ="requester_details";
    $issue_data = "issue_data";
    $assign_to  = "assign_to";

    $msg = "detail msg";
    $mail->Body = $msg; 
    if (!$mail->send()) {
        echo 'Mailer Error: '.$mail->ErrorInfo;
    } else {
        echo 'successfully';
    }
    // echo "end >>";
}

?>
<?php //echo site_url('login');?>