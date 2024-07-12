<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_guest');
		$this->load->model('m_project_info');
		$this->load->model('m_stringlib');
		
		$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai'; 
		if($lg=='thai'){
		    $this->lang->load('content','thai');
		}
		elseif($lg=='english'){
		    $this->lang->load('content','english');
		}
		$this->language  = $lg;
	}
	
	public function index()
	{
		if(!$this->session->userdata('id_guest')){
		 	redirect('profile/create_profile');
		}
		else {
			redirect('profile/edit_profile');
		}
	}
	
	public function create_profile()
	{
		$this->load->view('v_header');
		$this->load->view('v_profile_create');
		$this->load->view('v_footer');
	}
	
	public function edit_profile()
	{
		$id_guest = $this->session->userdata('id_guest');
		$data['guest_info'] = $this->m_guest->get_profile_by_guestID($id_guest);
		$data['discount'] = $this->m_guest->get_discount_by_user($id_guest);
		$this->load->view('v_header');
		$this->load->view('v_profile_update', $data);
		$this->load->view('v_footer');
	}

	public function edit_profile_security()
	{
		$id_guest = $this->session->userdata('id_guest');
		$data['guest_info'] = $this->m_guest->get_profile_by_guestID($id_guest);
		$data['discount'] = $this->m_guest->get_discount_by_user($id_guest);
		$this->load->view('v_header');
		$this->load->view('v_profile_update_security', $data);
		$this->load->view('v_footer');
	}

	public function edit_profile_code()
	{
		$id_guest = $this->session->userdata('id_guest');
		$data['guest_info'] = $this->m_guest->get_profile_by_guestID($id_guest);
		$data['discount'] = $this->m_guest->get_discount_by_user($id_guest);
		$this->load->view('v_header');
		$this->load->view('v_profile_code', $data);
		$this->load->view('v_footer');
	}
	
	public function save_profile () {
		if (!empty($_POST)) {
			$password = $this->m_stringlib->useMD5($this->input->post('password'), strtolower($this->input->post('password')));
			$data = array(
				'name' => $this->input->post('firstname').' '.$this->input->post('lastname'),
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'contact_number' => $this->input->post('contact_number'),
				'address' => $this->input->post('address'),
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'password' => $password,
				'photo_url' => '',
				'tax_id' => $this->input->post('tax_id'),
				'is_active' => 1,	
				'date_created' => date('Y-m-d H:i:s')
			);
			$insert_id = $this->m_guest->insert_profile($data);	
			
			if (isset($_FILES['guest_photo']) && $_FILES['guest_photo']['name'] != '') {	        		        		
					$doc_link = '';
					$target_dir = 'upload/guest_photo/'; 					
					$old_file_1 = basename($_FILES["guest_photo"]["name"]);
					$extension = substr($old_file_1,strpos($old_file_1, '.'),strlen($old_file_1));
					//$timestamp = date('YmdHis');
					//$target_file = $this->input->post('username').'_'.$timestamp.$extension;
					$target_file = $insert_id .'_'. uniqid() . $extension; //$this->rand().$extension;
		
					$config['file_name'] 			= $target_file;
					$config['upload_path']          = '../share_folder/sms_booking/'. $target_dir;
			        $config['allowed_types']        = 'gif|jpg|png|jpeg';
			        $config['overwrite']    		= true;
	
		        	$this->load->library('upload', $config);
					$this->upload->initialize($config);
		        	
					if ( ! $this->upload->do_upload('guest_photo')) 
					{
		        		$data_error = array('error' => $this->upload->display_errors());
		        		print_r($data_error);
		        	}
		        	else
		        	{
		        		$data_error = array('upload_data' => $this->upload->data());	        		
		        		$doc_link = $target_dir.$target_file;
		        	}
					$this->db->where('id_guest', $insert_id);
					$this->db->update('guest_info', array('photo_url' => $doc_link));
			}
			echo '<script>alert("Registration Successful! Please login to create you session.")</script>';
			redirect('login');
		}
	}
	public function update_password () {
		if (!empty($_POST)) {
			$id_guest = $this->input->post('id_guest_p');
			$password = $this->m_stringlib->useMD5($this->input->post('password'), strtolower($this->input->post('password')));
			$data = array ('username' => $this->input->post('username'), 'password' => $password);
			$this->m_guest->update_profile($data, $id_guest);
			redirect('profile/edit_profile_security');
		}
	}
	
	public function update_profile () {
		if (!empty($_POST)) {
			$id_guest = $this->input->post('id_guest');
			$data = array(
				'name' => $this->input->post('firstname').' '.$this->input->post('lastname'),
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'contact_number' => $this->input->post('contact_number'),
				'address' => $this->input->post('address'),
				'email' => $this->input->post('email'), 
				'tax_id' => $this->input->post('tax_id')
			);
			$this->m_guest->update_profile($data, $id_guest);	
			if ($_FILES['guest_photo']['name'] != '') {												
					$doc_link = '';
					$target_dir = 'upload/guest_photo/';
					$old_file_1 = basename($_FILES["guest_photo"]["name"]);
					$extension = substr($old_file_1,strpos($old_file_1, '.'),strlen($old_file_1));
					//$timestamp = date('YmdHis');
					//$target_file = $this->input->post('username').'_'.$timestamp.$extension;
					$target_file = $id_guest .'_'. uniqid() . $extension; //$this->rand().$extension;
		
					$config['file_name'] 			= $target_file;
					$config['upload_path']          = '../share_folder/sms_booking/'. $target_dir;
			        $config['allowed_types']        = 'gif|jpg|png|jpeg';
			        $config['overwrite']    		= true;

		        	$this->load->library('upload', $config);
					$this->upload->initialize($config);
		        	
					if ( ! $this->upload->do_upload('guest_photo')) 
					{
		        		$data_error = array('error' => $this->upload->display_errors());
		        		print_r($data_error);
		        	}
		        	else
		        	{
		        		$data_error = array('upload_data' => $this->upload->data());	        		
		        		$doc_link = $target_dir.$target_file;
		        	}		        	
	        		
					$data = array(
						'photo_url' => $doc_link,
					);
					$this->m_guest->update_profile($data, $id_guest);						
			}
			redirect('profile');						
		}
	}
	
	function check_email_exist () {
		if (!empty($_POST)) {
			$v_if_email_exist = $this->m_guest->if_email_exist($this->input->post('email'));
			echo $v_if_email_exist;
		}
	}
	
	function send_temp_password(){
		// require_once('PHPMailer/PHPMailerAutoload.php');
		// require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
		require_once(APPPATH.'third_party/PHPMailer/PHPMailerAutoload.php');
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		if (!empty($_POST)) {
			$user_email = $this->input->post('reset_email');
			//$user_name = $this->input->post('reset_username');
			//$user_email = 'mychelle@buildersmart.com';
			//$user_name = 'jaz';
			$temp_pass = $this->m_stringlib->uniqueAlphaNum8();
			$password = $this->m_stringlib->useMD5($temp_pass, strtolower($temp_pass));
			$data = array ('password' => $password);
			//$this->m_guest->update_temp_password($data, $user_email, $user_name);
			$this->m_guest->update_temp_password($data, $user_email);

			$subject = 'Smart Modular System Password Reset)';
			$message = '';
			if ($this->language == 'thai') {
				$message = '<p>เราส่งอีเมลนี้ถึงคุณเนื่องจากมีการร้องขอเปลี่ยนรหัสผ่าน โปรดใช้รหัสผ่านชั่วคราวด้านล่างเพื่อเข้าสู่ระบบ หลังจากที่คุณเข้าสู่ระบบ โปรดไปที่โปรไฟล์ของคุณเพื่อเปลี่ยนรหัสผ่านอีกครั้ง</p><br>'
					   . '<b>รหัสผ่าน: </b>'.$temp_pass
					   . '<br><p>ขอขอบพระคุณ'
					   . '<br><p>SMS Booking Management</p>'
					   . '<br><p>นี่คืออีเมลที่สร้างขึ้นโดยระบบอัตโนมัติ โปรดอย่าตอบกลับอีเมลฉบับนี้</p>'
					   ;
			}
			else {
				$message = '<p>We are sending you this email because you requested a password reset. '
					   . 'Please use the temporary password below to login. '
					   . 'After you login, please go to your profile to change the temporary password.</p><br>'
					   . '<b>Password: </b>'.$temp_pass
					   . '<br><p>Thank you.'
					   . '<br><p>SMS Booking Management</p>'
					   . '<br><p>This is auto-generated email. Please do not reply to this email.</p>'
					   ;
			}




			$user_email = $this->input->post('reset_email');
			$post_data = $this->session->userdata('post_data');

			echo $message;
			email($user_email, $subject, $message, '');
			//redirect ('login');

			require_once('PHPMailer/PHPMailerAutoload.php');
			// $this->load->view('PHPMailer/PHPMailerAutoload.php');
			// require_once APPPATH . 'libraries/PHPMailer/PHPMailerAutoload.php';

			// $sender = $_POST['email'];

			$sender = $user_email;
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
		    if (!$mail->send()) {
		        // echo 'Mailer Error: ' . $mail->ErrorInfo;
		    } else {
		        // echo 'successfully';
		    }
			// redirect('home');
		}
	}
	
	
	private function rand () {
		$timestamp = date('YmdHis');
		$result = md5($timestamp);
		return $result;
	}
	
	public function test_password () {
		$pass = '1111';
		$password = $this->m_stringlib->useMD5($pass, strtolower($pass));
		echo $password;
	}
}
