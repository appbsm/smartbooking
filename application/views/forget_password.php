<?php
// require_once($_SERVER['DOCUMENT_ROOT'] . '/smartbooking_front_test/PHPMailer/PHPMailerAutoload.php');
// require_once('PHPMailer/PHPMailerAutoload.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // require_once('PHPMailer/PHPMailerAutoload.php');
    // require(APPPATH . 'third_party/PHPMailer/PHPMailerAutoload.php');

    $max_attempts = 3;
    $attempt = 0;
    $loaded = false;
    $file_path = APPPATH . 'third_party/PHPMailer/PHPMailerAutoload.php';

    while ($attempt < $max_attempts && !$loaded) {
        if (file_exists($file_path)) {
            require_once($file_path);
            if (class_exists('PHPMailer')) {
                try {
                    $mail = new PHPMailer();
                    $loaded = true;
                    echo '<script>alert("file_path: '.$file_path.'")</script>';
                    // echo '<script>alert("try attempt: '.$attempt.' :loaded: '.$loaded.'")</script>';
                } catch (Exception $e) {
                    echo '<script>alert("PHPMailer initiation failed on attempt: '.$attempt.' :loaded: '.$loaded.'")</script>';
                    $attempt++;
                    if ($attempt >= $max_attempts) {
                        // Handle the error, log it, or display a message
                        echo '<script>alert("Failed to load PHPMailerAutoload.php or initiate PHPMailer after ' . $max_attempts . ' attempts.")</script>';
                    }
                }
            } else {
                echo '<script>alert("PHPMailer class does not exist after require_once on attempt: '.$attempt.' :loaded: '.$loaded.'")</script>';
                $attempt++;
                if ($attempt >= $max_attempts) {
                    // Handle the error, log it, or display a message
                    echo '<script>alert("Failed to load PHPMailerAutoload.php after ' . $max_attempts . ' attempts.")</script>';
                }
            }
        } else {
            echo '<script>alert("File does not exist on attempt: '.$attempt.' :loaded: '.$loaded.'")</script>';
            $attempt++;
            if ($attempt >= $max_attempts) {
                // Handle the error, log it, or display a message
                echo '<script>alert("Failed to load PHPMailerAutoload.php after ' . $max_attempts . ' attempts.")</script>';
            }
        }
    }

    // require('connect_sql.php');
    // $sql ="update guest_info set password='".$password."' where email ='".$_POST['reset_email']."' ";
    // $stmt = sqlsrv_query($conn,$sql);
    // sqlsrv_close($conn);


    $subject = 'Smart Booking System Password Reset';
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
    
    if (isset($Subject)) {
        $mail->Subject = $Subject;
    }
    $mail->AddAddress($sender, "Receiver");

    $requester_details ="requester_details";
    $issue_data = "issue_data";
    $assign_to  = "assign_to";

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
    // header('Location: login?' . $query_string);

    $this->session->set_flashdata('message', 'Login successful!');
    redirect ('login');
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