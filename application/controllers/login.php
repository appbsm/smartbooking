<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_stringlib');
		$this->load->model('m_guest');
	}
	
	public function index()
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
				// $this->session->set_flashdata('login_error', 'รหัสผ่านหรือชื่อผู้ใช้ไม่ถูกต้อง');
            	// redirect('login');  
			}
		}	
		else {			
			//$this->load->view('v_header');
			//echo "5";
			//print_r($_SESSION);
			//echo "LOGIN CART";
			//print_r($this->session->userdata('cart_data'));

			$this->load->view('v_header');
			// $this->load->view('v_login');
			$this->load->view('signin');
			// $this->load->view('v_footer');
			$this->load->view('v_footer');
		}
		
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
