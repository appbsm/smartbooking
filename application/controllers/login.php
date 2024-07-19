<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_stringlib');
		$this->load->model('m_guest');
		// require(APPPATH . 'third_party/PHPMailer/PHPMailerAutoload.php');
	}
	
	public function index()
	{		
		if (!empty($_POST)) {
			if(!empty($_POST['type'])){
				$email = $this->input->post('email');
				$user_login = $this->m_guest->get_profile_facebook($email);
				if($user_login){
					$this->session->set_userdata('id_guest',$user_login->id_guest);
					$this->session->set_userdata('guest_name',$user_login->name);
					if ($this->session->userdata('booking_items')) {
						redirect('booking/guest_info');
					}
					else {
						redirect('home');
					}
				}else{
					$data = array(
						'name' => $this->input->post('name'),
						'firstname' => '',
						'lastname' => '',
						'contact_number' => '',
						'address' => '',
						'email' => $this->input->post('email'),
						'username' => '',
						'password' => '',
						'photo_url' => '',
						'tax_id' => '',
						'is_active' => 1,
						'type' => 'facebook',
						'date_created' => date('Y-m-d H:i:s')
					);
					$insert_id = $this->m_guest->insert_profile($data);
					$this->session->set_userdata('id_guest',$insert_id);
					$this->session->set_userdata('guest_name',$this->input->post('name'));
					if ($this->session->userdata('booking_items')) {
						redirect('booking/guest_info');
					}
					else {
						redirect('home');
					}
				}

			}else{

				$username = $this->input->post('username'); //username
				$password = $this->m_stringlib->useMD5($this->input->post('password'), strtolower($this->input->post('password')));
				$user_login = $this->m_guest->get_profile_by_username_password($username,$password);
				//echo $password;
				//echo "test";
				
				//echo "1";
				//print_r($this->session->userdata('cart_data'));
				if($user_login){
					$this->session->set_userdata('id_guest',$user_login->id_guest);
					$this->session->set_userdata('guest_name',$user_login->firstname.' '.$user_login->lastname);												
					//echo "ID GUEST".$this->session->userdata('id_guest');
					//print_r($_SESSION);
					if ($this->session->userdata('booking_items')) {
						//echo "2";
						/*echo $this->session->userdata('num_of_adult');
						echo $this->session->userdata('num_of_children');
						echo $this->session->userdata('children_ages');*/
						redirect('booking/guest_info');
					}
					else {
						redirect('home');
					}
					
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
					//echo $_SERVER['HTTP_REFERER'];				
				}
				else {
					//echo "4";
					$this->session->set_flashdata('login_error', $this->lang->line('message_login_incorrect'));
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					// $this->session->set_flashdata('login_error', 'รหัสผ่านหรือชื่อผู้ใช้ไม่ถูกต้อง');
	            	// redirect('login');  
				}

			}
		}else {			
			//$this->load->view('v_header');
			//echo "5";
			//print_r($_SESSION);
			//echo "LOGIN CART";
			//print_r($this->session->userdata('cart_data'));

			$this->load->view('v_header');
			// $this->load->view('v_login');
			$this->load->view('signin');
			$this->load->view('v_footer');
		}
		
	}

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

	public function index3()
	{
		$this->load->view('test_f2');
	}

	public function forget_password(){
		// require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
		$temp_pass = $this->m_stringlib->uniqueAlphaNum8();
    	$password = $this->m_stringlib->useMD5($temp_pass, strtolower($temp_pass));

    	$data['temp_pass'] = $temp_pass;
    	$data['password'] = $password;

    	$data_update = array ('password' => $password);
    	$this->m_guest->update_temp_password($data_update,$_POST['reset_email'],$_POST['reset_username']);

		$this->load->view('forget_password',$data);
		// $this->load->view('v_footer');

		//////////////////////////
    	// $subject = 'Smart Booking System Password Reset';
	    // $message = '';
	    // if ($_POST['lang'] != 'english') {
	    //     $message = '<p>เราส่งอีเมลนี้ถึงคุณเนื่องจากมีการร้องขอเปลี่ยนรหัสผ่าน โปรดใช้รหัสผ่านชั่วคราวด้านล่างเพื่อเข้าสู่ระบบ หลังจากที่คุณเข้าสู่ระบบ โปรดไปที่โปรไฟล์ของคุณเพื่อเปลี่ยนรหัสผ่านอีกครั้ง</p><br>'
	    //            . '<b>รหัสผ่าน: </b>'.$temp_pass
	    //            . '<br><p>ขอขอบพระคุณ'
	    //            . '<br><p>Smart Booking Management</p>'
	    //            . '<br><p>นี่คืออีเมลที่สร้างขึ้นโดยระบบอัตโนมัติ โปรดอย่าตอบกลับอีเมลฉบับนี้</p>'
	    //            ;
	    // }
	    // else {
	    //     $message = '<p>We are sending you this email because you requested a password reset. '
	    //            . 'Please use the temporary password below to login. '
	    //            . 'After you login, please go to your profile to change the temporary password.</p><br>'
	    //            . '<b>Password: </b>'.$temp_pass
	    //            . '<br><p>Thank you.'
	    //            . '<br><p>Smart Booking Management</p>'
	    //            . '<br><p>This is auto-generated email. Please do not reply to this email.</p>'
	    //            ;
	    // }

		// $sender = $_POST['reset_email'];
	    // $smtp_user = 'info@installdirect.asia';
	    // $smtp_pass = 'Bsm@2024';
	    // $mail = new PHPMailer();
	    // $mail->IsSMTP();
	    // $mail->SMTPAutoTLS = false;
	    // $mail->SMTPAuth    = true;
	    // $mail->SMTPSecure  = "tls";
	    // $mail->Host        = "smtp-legacy.office365.com";
	    // $mail->Mailer      = "smtp";
	    // $mail->Port        = "587";
	    // $mail->Username    = $smtp_user;
	    // $mail->Password    = $smtp_pass;

	    // $mail->SetFrom('info@installdirect.asia', 'installdirect');
	    // $mail->isHTML(true);
	    // $mail->CharSet = "utf-8";
	    // // $mail->Subject = "Request change password for SmartBroker system.";
	    // $mail->Subject = $Subject;
	    // $mail->AddAddress($sender, "Receiver");

	    // $requester_details ="requester_details";
	    // $issue_data = "issue_data";
	    // $assign_to  = "assign_to";

	    // // $msg = "detail msg";
	    // // $mail->Body = $msg;
	    // $mail->Body = $message;
	    // if (!$mail->send()) {
	    //     // echo 'Mailer Error: '.$mail->ErrorInfo;
	    // } else {
	    //     // echo 'successfully';
	    // }
	    // echo "end >>";

	}

	public function index2()
	{		
		if (!empty($_POST)) {
			$username = $this->input->post('username'); //username
			$password = $this->m_stringlib->useMD5($this->input->post('password'), strtolower($this->input->post('password')));
			$user_login = $this->m_guest->get_profile_by_username_password($username,$password);
			//echo $password;
			//echo "test";
			
			//echo "1";
			//print_r($this->session->userdata('cart_data'));
			if($user_login){
				$this->session->set_userdata('id_guest',$user_login->id_guest);
				$this->session->set_userdata('guest_name',$user_login->firstname.' '.$user_login->lastname);												
				//echo "ID GUEST".$this->session->userdata('id_guest');
				//print_r($_SESSION);
				if ($this->session->userdata('booking_items')) {
					//echo "2";
					/*echo $this->session->userdata('num_of_adult');
					echo $this->session->userdata('num_of_children');
					echo $this->session->userdata('children_ages');*/
					redirect('booking/guest_info');
				}
				else {
					//echo "3";
					redirect('home');
				}
				
				//header('Location: ' . $_SERVER['HTTP_REFERER']);
				//echo $_SERVER['HTTP_REFERER'];				
			}
			else {
				//echo "4";
				$this->session->set_flashdata('login_error', $this->lang->line('message_login_incorrect'));
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		}	
		else {			
			//$this->load->view('v_header');			
			//echo "5";
			//print_r($_SESSION);
			//echo "LOGIN CART";
			//print_r($this->session->userdata('cart_data'));
			$this->load->view('v_header');
			$this->load->view('signin');
			$this->load->view('v_footer');
			//$this->load->view('v_footer');
		}
	}

	public function signup()
	{
		$this->load->view('v_header');
		$this->load->view('register');
		$this->load->view('v_footer');
	}

	public function index_old()
	{		
		if (!empty($_POST)) {
			$username = $this->input->post('username'); //username
			$password = $this->m_stringlib->useMD5($this->input->post('password'), strtolower($this->input->post('password')));
			$user_login = $this->m_guest->get_profile_by_username_password($username,$password);
			//echo $password;
			//echo "test";
			
			//echo "1";
			//print_r($this->session->userdata('cart_data'));
			if($user_login){
				$this->session->set_userdata('id_guest',$user_login->id_guest);
				$this->session->set_userdata('guest_name',$user_login->firstname.' '.$user_login->lastname);												
				//echo "ID GUEST".$this->session->userdata('id_guest');
				//print_r($_SESSION);
				if ($this->session->userdata('booking_items')) {
					//echo "2";
					/*echo $this->session->userdata('num_of_adult');
					echo $this->session->userdata('num_of_children');
					echo $this->session->userdata('children_ages');*/
					redirect('booking/guest_info');
				}
				else {
					//echo "3";
					redirect('home');
				}
				
				//header('Location: ' . $_SERVER['HTTP_REFERER']);
				//echo $_SERVER['HTTP_REFERER'];				
			}
			else {
				//echo "4";
				$this->session->set_flashdata('login_error', $this->lang->line('message_login_incorrect'));
				header('Location: ' . $_SERVER['HTTP_REFERER']);
				
			}
			
			
		}	
		else {			
			//$this->load->view('v_header');			
			//echo "5";
			//print_r($_SESSION);
			//echo "LOGIN CART";
			//print_r($this->session->userdata('cart_data'));
			$this->load->view('v_header');
			$this->load->view('v_login');
			// $this->load->view('register');
			//$this->load->view('v_footer');
		}
		
	}
	
	function logout(){		
		$this->session->sess_destroy();
		redirect('home');		
	}
		
}
