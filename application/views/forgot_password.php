
<?php

require_once('PHPMailer/PHPMailerAutoload.php');
// echo "email:".$_POST['reset_email'];

// include('connect_sql.php');
// $password = '1234';
// $reset_email = 'thanawat@installdirect.asia';
// $sql ="update guest_info set password='".$password."' where email ='".$reset_email."' ";
// $stmt = sqlsrv_query($conn,$sql);
// if ($stmt === false) {
//     // กรณีเกิดข้อผิดพลาดในการ execute query
//     die(print_r(sqlsrv_errors(), true));
// } else {
//     // กรณี execute query สำเร็จ
//     echo "Update successful!";
// }
// sqlsrv_close($conn);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $temp_pass = uniqueAlphaNum8();
    $password  = md5($temp_pass);

    include('connect_sql.php');
    // $sql ="update modular_icon set password='".$password."' where email ='".$_POST['reset_email']."' ";
    // $stmt = sqlsrv_query($conn,$sql);

    // $reset_email = $_POST['reset_email'];
    // $sql = "UPDATE modular_icon SET password = ? WHERE email = ?";
    // $params = array($password, $reset_email);
    // $stmt = sqlsrv_query($conn, $sql, $params);
    // sqlsrv_close($conn);

    $sql ="update guest_info set password='".$password."' where email ='".$_POST['reset_email']."' ";
    $stmt = sqlsrv_query($conn,$sql);
    sqlsrv_close($conn);

    $stmt = sqlsrv_query($conn,$sql);

    $subject = 'Smart Booking System Password Reset)';
    $message = '';
    if ($_POST['lang'] != 'english') {
        $message = '<p>เราส่งอีเมลนี้ถึงคุณเนื่องจากมีการร้องขอเปลี่ยนรหัสผ่าน โปรดใช้รหัสผ่านชั่วคราวด้านล่างเพื่อเข้าสู่ระบบ หลังจากที่คุณเข้าสู่ระบบ โปรดไปที่โปรไฟล์ของคุณเพื่อเปลี่ยนรหัสผ่านอีกครั้ง</p><br>'
               . '<b>รหัสผ่าน: </b>'.$temp_pass
               . '<br><p>ขอขอบพระคุณ'
               . '<br><p>Smart Booking Management</p>'
               . '<br><p>นี่คืออีเมลที่สร้างขึ้นโดยระบบอัตโนมัติ โปรดอย่าตอบกลับอีเมลฉบับนี้</p>'
               ;
    }
    else {
        $message = '<p>We are sending you this email because you requested a password reset. '
               . 'Please use the temporary password below to login. '
               . 'After you login, please go to your profile to change the temporary password.</p><br>'
               . '<b>Password: </b>'.$temp_pass
               . '<br><p>Thank you.'
               . '<br><p>Smart Booking Management</p>'
               . '<br><p>This is auto-generated email. Please do not reply to this email.</p>'
               ;
    }

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
    // $mail->Subject = "Request change password for SmartBroker system.";
    $mail->Subject = $Subject;
    $mail->AddAddress($sender, "Receiver");

    $requester_details ="requester_details";
    $issue_data = "issue_data";
    $assign_to  = "assign_to";

    // $msg = "detail msg";
    // $mail->Body = $msg;
    $mail->Body = $message;
    if (!$mail->send()) {
        // echo 'Mailer Error: '.$mail->ErrorInfo;
    } else {
        // echo 'successfully';
    }
    // echo "end >>";
}

    /////////////////////////////////////////////////
    $data = array(
    'sent_mail' => 'success',
    );
    $query_string = http_build_query($data);
    header('Location: login?' . $query_string);

    /////////////////////////////////////////////////


?>

<?php
// ฟังก์ชันสำหรับสร้างรหัสผ่านที่เป็นตัวอักษรและตัวเลข 8 ตัวอักษร
function uniqueAlphaNum8() {
    // กำหนดตัวอักษรและตัวเลขที่สามารถใช้ได้
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 8; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>