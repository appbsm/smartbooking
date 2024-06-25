<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


    if (!function_exists('email')) {

	    // usage: $this->email($data_email);		
		function email($to = '', $subject = '', $message = '', $attachment = ''){
			
			$ci =& get_instance();
			//require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
			$smtp_user = EMAIL_USER;
			//$smtp_user = 'helpdesk@buildersmart.com';//'sms.booking@hotmail.com';
			$ci->load->library('email', array(
				'protocol'    => 'smtp',
				'smtp_host'   => 'smtp-legacy.office365.com',
				'smtp_port'   => 587,
				'smtp_user'   => $smtp_user,
				'smtp_pass'   => EMAIL_PASSWORD, //'Hor93452',//'Bsm@2023',
				'smtp_crypto' => 'tls',
				'mailtype'    => 'html',
				'charset'     => 'utf-8',
				'wordwrap'    => TRUE
			));
	
			$headers = "MIME-Version: 1.0" ."\r\n";
			$headers .= "Content-type: text/html; charset=UTF-8" ."\r\n";
	
			$ci->email->set_newline("\r\n");
			$ci->email->from($smtp_user, 'SMS Booking');
			$ci->email->to($to);
			$ci->email->subject($subject);
			$ci->email->message($message);
			if (!empty($attachment)) {
				$ci->email->attach($attachment);
			}
	
			if($ci->email->send()) {
				$ret['result'] = 'true';
			} else {
				$ret['message'] = $this->email->print_debugger();
			}
	
			if (!empty($attachment)) {
				unlink($attachment);
			}
			return $ret;
		}
	} 
	
	if (!function_exists('email_cal_mew')) {

	    // usage: $this->email($data_email);		
		function email_cal_new($data){
			
			$ci =& get_instance();
			$ci->load->model('vehicle_booking/m_v_booking');
			require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
			$mail = new PHPMailer();
			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
			$mail->Host       = "smtp.office365.com";//"smtp.gmail.com";      // setting GMail as our SMTP server smtp.gmail.com smtp.office365.com
			$mail->Port       = "587";                   // SMTP port to connect to GMail 465 587
			$mail->Username   = "info@buildersmart.com";   // user email address Thanada@buildersmart.com bp.bpsweett@gmail.com
			$mail->Password   = "Bsm@2020#";          // password in GMail
			$mail->SetFrom('info@buildersmart.com', 'Info Buildersmart');  //Who is sending
			$mail->isHTML(true);
			$mail->CharSet = "utf-8";
			$mail->Subject    = $data['email_subject'];
			$mail->AddAddress($data['receiver_email'], $data['receiver_name']);
			//$mail->addAttachment($data['attachment']);
			$details = $data['details'];
			$mail->ContentType = 'text/calendar';
			$details = $data['details'];
			//echo "Test";
			//print_r($details);
			//date('h:i a', strtotime($given_time))
			$b_date = date('Ymd', strtotime($details['booking_date']));
			$b_date_to = date('Ymd', strtotime($details['booking_date_to']));
			$st = date('His', strtotime($details['booking_time_from']));
			$et = date('His', strtotime($details['booking_time_to']));
			
			$uid = date("Ymd\TGis", strtotime($st)).rand()."-bsm_vehicle_booking_system\r\n";
			$ical = 'BEGIN:VCALENDAR' . "\r\n" .
				'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
				'VERSION:2.0' . "\r\n" .
				'METHOD:PUBLISH' . "\r\n" .
				'BEGIN:VTIMEZONE' . "\r\n" .
				'TZID:Asia/Bangkok' . "\r\n" .
				'BEGIN:STANDARD' . "\r\n"  .
				'DTSTART:'.$b_date.'T'.$st."\r\n" .								
				'TZOFFSETFROM:+0800' . "\r\n" .
				'TZOFFSETTO:+0800' . "\r\n" .
				'TZNAME:EST' . "\r\n" .
				'END:STANDARD' . "\r\n" .					
				'END:VTIMEZONE' . "\r\n" .
				'BEGIN:VEVENT' . "\r\n" .
				'ORGANIZER;CN=Systems:MAILTO:info@buildersmart.com'."\r\n" .
				'ATTENDEE;CN=Receiver";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$data['receiver_email']. "\r\n" .
				'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
				'UID:'.$uid.
				'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
				'DTSTART;TZID="Asia/Bangkok":'.$b_date.'T'.$st. "\r\n" .
				'DTEND;TZID="Asia/Bangkok":'.$b_date_to.'T'.$et. "\r\n" .
				'TRANSP:OPAQUE'. "\r\n" .
				'SEQUENCE:0'. "\r\n" .
				'SUMMARY:' . $details['title'] . "\r\n" .
				'DESCRIPTION:'.$details['title']."\r\n" .
				'LOCATION:Buildersmart' . "\r\n" .
				'CLASS:PUBLIC'. "\r\n" .
				'PRIORITY:5'. "\r\n" .
				'BEGIN:VALARM' . "\r\n" .
				'TRIGGER:-PT15M' . "\r\n" .
				'ACTION:DISPLAY' . "\r\n" .
				'DESCRIPTION:Reminder' . "\r\n" .
				'END:VALARM' . "\r\n" .
				'END:VEVENT'. "\r\n" .
				'END:VCALENDAR'. "\r\n";							
			$mail->Body      = $ical;
			
			//$mail->Body = $string;
			if(!$mail->Send()) {
				echo $mail->ErrorInfo;
			}	
			return $uid;
		}
	} 
	
	if (!function_exists('email_cal')) {

	    // usage: $this->email($data_email);		
		function email_cal($data){
			
			$ci =& get_instance();
			$ci->load->model('vehicle_booking/m_v_booking');
			require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
			$mail = new PHPMailer();
			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
			$mail->Host       = "smtp.office365.com";//"smtp.gmail.com";      // setting GMail as our SMTP server smtp.gmail.com smtp.office365.com
			$mail->Port       = "587";                   // SMTP port to connect to GMail 465 587
			$mail->Username   = "info@buildersmart.com";   // user email address Thanada@buildersmart.com bp.bpsweett@gmail.com
			$mail->Password   = "Bsm@2020#";          // password in GMail
			$mail->SetFrom('info@buildersmart.com', 'Info Buildersmart');  //Who is sending
			$mail->isHTML(true);
			$mail->CharSet = "utf-8";
			$mail->Subject    = $data['email_subject'];
			$mail->AddAddress($data['receiver_email'], $data['receiver_name']);
			//$mail->addAttachment($data['attachment']);
			$details = $data['details'];
			$mail->ContentType = 'text/calendar';
			$details = $data['details'];
			//echo "Test";
			//print_r($details);
			//date('h:i a', strtotime($given_time))
			$b_date = date('Ymd', strtotime($details->booking_date));
			$b_date_to = date('Ymd', strtotime($details->booking_date_to));
			$st = date('His', strtotime($details->booking_time_from));
			$et = date('His', strtotime($details->booking_time_to));
			
			$uid = date("Ymd\TGis", strtotime($st)).rand()."-bsm_vehicle_booking_system\r\n";
			$ical = 'BEGIN:VCALENDAR' . "\r\n" .
				'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
				'VERSION:2.0' . "\r\n" .
				'METHOD:PUBLISH' . "\r\n" .
				'BEGIN:VTIMEZONE' . "\r\n" .
				'TZID:Asia/Bangkok' . "\r\n" .
				'BEGIN:STANDARD' . "\r\n"  .
				'DTSTART:'.$b_date.'T'.$st."\r\n" .								
				'TZOFFSETFROM:+0800' . "\r\n" .
				'TZOFFSETTO:+0800' . "\r\n" .
				'TZNAME:EST' . "\r\n" .
				'END:STANDARD' . "\r\n" .					
				'END:VTIMEZONE' . "\r\n" .
				'BEGIN:VEVENT' . "\r\n" .
				'ORGANIZER;CN=Systems:MAILTO:info@buildersmart.com'."\r\n" .
				'ATTENDEE;CN=Receiver";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$data['receiver_email']. "\r\n" .
				'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
				'UID:'.$uid.
				'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
				'DTSTART;TZID="Asia/Bangkok":'.$b_date.'T'.$st. "\r\n" .
				'DTEND;TZID="Asia/Bangkok":'.$b_date_to.'T'.$et. "\r\n" .
				'TRANSP:OPAQUE'. "\r\n" .
				'SEQUENCE:0'. "\r\n" .
				'SUMMARY:' . $details->title . "\r\n" .
				'DESCRIPTION:'.$details->title."\r\n" .
				'LOCATION:Buildersmart' . "\r\n" .
				'CLASS:PUBLIC'. "\r\n" .
				'PRIORITY:5'. "\r\n" .
				'BEGIN:VALARM' . "\r\n" .
				'TRIGGER:-PT15M' . "\r\n" .
				'ACTION:DISPLAY' . "\r\n" .
				'DESCRIPTION:Reminder' . "\r\n" .
				'END:VALARM' . "\r\n" .
				'END:VEVENT'. "\r\n" .
				'END:VCALENDAR'. "\r\n";							
			$mail->Body      = $ical;
			
			//$mail->Body = $string;
			if(!$mail->Send()) {
				echo $mail->ErrorInfo;
			}	
			return $uid;
		}
	} 
	
	if (!function_exists('email_cal_recur')) {

	    // usage: $this->email($data_email);		
		function email_cal_recur($data){			
			$ci =& get_instance();
			$ci->load->model('vehicle_booking/m_v_booking');
			require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
			$mail = new PHPMailer();
			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
			$mail->Host       = "smtp.office365.com";//"smtp.gmail.com";      // setting GMail as our SMTP server smtp.gmail.com smtp.office365.com
			$mail->Port       = "587";                   // SMTP port to connect to GMail 465 587
			$mail->Username   = "info@buildersmart.com";   // user email address Thanada@buildersmart.com bp.bpsweett@gmail.com
			$mail->Password   = "Bsm@2020#";          // password in GMail
			$mail->SetFrom('info@buildersmart.com', 'Info Buildersmart');  //Who is sending
			$mail->isHTML(true);
			$mail->CharSet = "utf-8";
			$mail->Subject    = $data['email_subject'];
			$mail->ContentType = 'text/calendar';
			$mail->AddAddress($data['receiver_email'], $data['receiver_name']);
			//$mail->addAttachment($data['attachment']);
			
			$details = $data['details'];
			$mail->ContentType = 'text/calendar';
			$details = $data['details'];
			//echo "Test";
			//print_r($details);
			//date('h:i a', strtotime($given_time))
			
			$b_date = date('Ymd', strtotime($details['booking_date']));
			$b_date_to = date('Ymd', strtotime($details['booking_date_to']));
			$start_date = date('Ymd', strtotime($b_date . " - 1 day"));
			$end_date = date('Ymd', strtotime($b_date . " + 2 day"));
			$b_end_date = date('Ymd', strtotime($details['booking_date_to']));
			$st = date('His', strtotime($details['booking_time_from']));
			$et = date('His', strtotime($details['booking_time_to']));
			$uid = date("Ymd\TGis", strtotime($st)).rand()."-bsm_vehicle_booking_system\r\n";
			$recur_details = $data['recur_details'];
			$ical = 'BEGIN:VCALENDAR' . "\r\n" .
				'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
				'VERSION:2.0' . "\r\n" .
				'METHOD:PUBLISH' . "\r\n" .
				'BEGIN:VTIMEZONE' . "\r\n" .
				'TZID:Asia/Bangkok' . "\r\n" .
				'BEGIN:STANDARD' . "\r\n"  .
				'DTSTART:'.$b_date.'T'.$st."\r\n" .								
				'TZOFFSETFROM:+0800' . "\r\n" .
				'TZOFFSETTO:+0800' . "\r\n" .
				'TZNAME:EST' . "\r\n" .
				'END:STANDARD' . "\r\n" .					
				'END:VTIMEZONE' . "\r\n" .
				'BEGIN:VEVENT' . "\r\n" .
				'ORGANIZER;CN=Systems:MAILTO:info@buildersmart.com'."\rn" .
				'ATTENDEE;CN=Receiver";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$data['receiver_email']. "\r\n" .
				'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
				'UID:'.$uid.
				'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
				'DTSTART;TZID="Asia/Bangkok":'.$b_date.'T'.$st. "\r\n" .
				'DTEND;TZID="Asia/Bangkok":'.$b_date_to.'T'.$et. "\r\n" .
				'TRANSP:OPAQUE'. "\r\n" .
				'SEQUENCE:0'. "\r\n" .
				'SUMMARY:' . $data['title'] . "\r\n" .
				'DESCRIPTION:'.$data['title']."\r\n" .
				'LOCATION:Buildersmart' . "\r\n" .
				'CLASS:PUBLIC'. "\r\n" .
				'PRIORITY:5'. "\r\n" .	
				$recur_details['rrecur'] . "\r\n" .
				$recur_details['except_days']. "\r\n" .				
				'BEGIN:VALARM' . "\r\n" .
				'TRIGGER:-PT15M' . "\r\n" .
				'ACTION:DISPLAY' . "\r\n" .
				'DESCRIPTION:Reminder' . "\r\n" .
				'END:VALARM' . "\r\n" .
				'END:VEVENT'. "\r\n" .					
				'END:VCALENDAR'. "\r\n";		
									
			$mail->Body      = $ical;
			//echo "<br><br>";
			//print_r($ical);
			//$mail->Body      = $details['title'];
			//$mail->addStringAttachment($ical,'ical.ics','base64','text/calendar');
			
			//$mail->Body = $string;
			if(!$mail->Send()) {
				echo $mail->ErrorInfo;
			}	
			return $uid;
		}
	} 
	
	if (!function_exists('email_password')) {

	    // usage: $this->email($data_email);		
		function email_password($data){
			
			$ci =& get_instance();
			require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
			$mail = new PHPMailer();
			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
			$mail->Host       = "smtp.office365.com";//"smtp.gmail.com";      // setting GMail as our SMTP server smtp.gmail.com smtp.office365.com
			$mail->Port       = "587";                   // SMTP port to connect to GMail 465 587
			$mail->Username   = "Customercare@sansara.asia";   // user email address Thanada@buildersmart.com bp.bpsweett@gmail.com
			$mail->Password   = "Bsm@2017";          // password in GMail
			$mail->SetFrom('Customercare@sansara.asia', 'Vehicle Booking System');  //Who is sending
			$mail->isHTML(true);
			$mail->CharSet = "utf-8";
			$mail->Subject    = $data['email_subject'];
			$mail->AddAddress($data['receiver_email'], $data['receiver_name']);
			//$mail->addAttachment($data['attachment']);
			$email_data = array(
				'temp_password' => $data['temp_password'],
				'user_name' => $data['user_name'],
				'receiver_name' => $data['receiver_name']
			);
			$mail->Body = $ci->load->view('vehicle_booking/v_email_password',$email_data,TRUE);
			//$mail->Body = $string;
			if(!$mail->Send()) {
				echo $mail->ErrorInfo;
			}	
		}
	} 
	
	
	/*	
	if (!function_exists('email_password')) {

	    // usage: $this->email($data_email);		
		function email_password($data){
			
			$ci =& get_instance();
			require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
			$mail = new PHPMailer();
			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
			$mail->Host       = "smtp.office365.com";//"smtp.gmail.com";      // setting GMail as our SMTP server smtp.gmail.com smtp.office365.com
			$mail->Port       = "587";                   // SMTP port to connect to GMail 465 587
			$mail->Username   = "info@buildersmart.com";   // user email address Thanada@buildersmart.com bp.bpsweett@gmail.com
			$mail->Password   = "Bsm@2020#";          // password in GMail
			$mail->SetFrom('Customercare@sansara.asia', 'Vehicle Booking System');  //Who is sending
			$mail->isHTML(true);
			$mail->CharSet = "utf-8";
			$mail->Subject    = $data['email_subject'];
			$mail->AddAddress($data['receiver_email'], $data['receiver_name']);
			//$mail->addAttachment($data['attachment']);
			$email_data = array(
				'temp_password' => $data['temp_password'],
				'user_name' => $data['user_name'],
				'receiver_name' => $data['receiver_name']
			);
			$mail->Body = $ci->load->view('vehicle_booking/v_email_password',$email_data,TRUE);
			//$mail->Body = $string;
			if(!$mail->Send()) {
				echo $mail->ErrorInfo;
			}	
		}
	} 
	*/
	
	if (!function_exists('email_daily_completed_report')) {

	    // usage: $this->email($data_email);		
		function email_daily_completed_report($data){
			
			$ci =& get_instance();
			require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
			$mail = new PHPMailer();
			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
			$mail->Host       = "smtp.office365.com";//"smtp.gmail.com";      // setting GMail as our SMTP server smtp.gmail.com smtp.office365.com
			$mail->Port       = "587";                   // SMTP port to connect to GMail 465 587
			$mail->Username   = "info@buildersmart.com";   // user email address Thanada@buildersmart.com bp.bpsweett@gmail.com
			$mail->Password   = "Bsm@2020#";          // password in GMail
			$mail->SetFrom('Customercare@sansara.asia', 'Vehicle Booking System');  //Who is sending
			$mail->isHTML(true);
			$mail->CharSet = "utf-8";
			$mail->Subject    = $data['email_subject'];
			$mail->AddAddress($data['receiver_email'], $data['receiver_name']);
			
			$files = $data['files'];
			foreach ($files as $f) {
				$mail->addAttachment($f);
			}								
			$email_data = array(
				'email_body' => $data['email_body'],
				'receiver_name' => $data['receiver_name']
			);
			$mail->Body = $ci->load->view('vehicle_booking/v_email_daily_report',$email_data,TRUE);
			//$mail->Body = $string;
			if(!$mail->Send()) {
				echo $mail->ErrorInfo;
			}	
		}
	}

	if (!function_exists('email_cal_cancel')) {

	    // usage: $this->email($data_email);		
		function email_cal_cancel($data){
			
			$ci =& get_instance();
			$ci->load->model('vehicle_booking/m_v_booking');
			require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
			$mail = new PHPMailer();
			$mail->IsSMTP(); // we are going to use SMTP
			$mail->SMTPAuth   = true; // enabled SMTP authentication
			$mail->SMTPSecure = "tls";  // prefix for secure protocol to connect to the server
			$mail->Host       = "smtp.office365.com";//"smtp.gmail.com";      // setting GMail as our SMTP server smtp.gmail.com smtp.office365.com
			$mail->Port       = "587";                   // SMTP port to connect to GMail 465 587
			$mail->Username   = "info@buildersmart.com";   // user email address Thanada@buildersmart.com bp.bpsweett@gmail.com
			$mail->Password   = "Bsm@2020#";          // password in GMail
			$mail->SetFrom('info@buildersmart.com', 'Info Buildersmart');  //Who is sending
			$mail->isHTML(true);
			$mail->CharSet = "utf-8";
			$mail->Subject    = $data['email_subject'];
			$mail->AddAddress($data['receiver_email'], $data['receiver_name']);
			//$mail->addAttachment($data['attachment']);
			$details = $data['details'];
			$mail->ContentType = 'text/calendar';
			$details = $data['details'];
			//echo "Test";
			//print_r($details);
			//date('h:i a', strtotime($given_time))
			$b_date = date('Ymd', strtotime($details['booking_date']));
			$b_date_to = date('Ymd', strtotime($details['booking_date_to']));
			$st = date('His', strtotime($details['booking_time_from']));
			$et = date('His', strtotime($details['booking_time_to']));
			$uid = $details['uid'];
			print_r($details);
			$ical = 'BEGIN:VCALENDAR' . "\r\n" .
				'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
				'VERSION:2.0' . "\r\n" .
				'METHOD:CANCEL' . "\r\n" .
				'BEGIN:VTIMEZONE' . "\r\n" .
				'TZID:Asia/Bangkok' . "\r\n" .
				'BEGIN:STANDARD' . "\r\n"  .
				'DTSTART:'.$b_date.'T'.$st."\r\n" .								
				'TZOFFSETFROM:+0800' . "\r\n" .
				'TZOFFSETTO:+0800' . "\r\n" .
				'TZNAME:EST' . "\r\n" .
				'END:STANDARD' . "\r\n" .					
				'END:VTIMEZONE' . "\r\n" .
				'BEGIN:VEVENT' . "\r\n" .
				'ORGANIZER;CN=Systems:MAILTO:info@buildersmart.com'."\r\n" .				
				'UID:'.$uid.
				'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
				'DTSTART;TZID="Asia/Bangkok":'.$b_date.'T'.$st. "\r\n" .
				'DTEND;TZID="Asia/Bangkok":'.$b_date_to.'T'.$et. "\r\n" .
				'SEQUENCE:10'. "\r\n" .				
				'SUMMARY:' . $data['title'] . "\r\n" .
				'DESCRIPTION:'.$data['title']."\r\n" .
				'LOCATION:Buildersmart' . "\r\n" .
				'CLASS:PUBLIC'. "\r\n" .
				'PRIORITY:5'. "\r\n" .				
				'STATUS:CANCELLED'. "\r\n" .
				'END:VEVENT'. "\r\n" .
				'END:VCALENDAR'. "\r\n";							
			$mail->Body      = $ical;
			echo "<br>";
			print_r($ical);
			//$mail->Body = $string;
			if(!$mail->Send()) {
				echo $mail->ErrorInfo;
			}	
			return $uid;
		}
	}
	