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
			echo $this->input->post('password');
			$password = $this->m_stringlib->useMD5($this->input->post('password'), strtolower($this->input->post('password')));
			$user_login = $this->m_guest->get_profile_by_username_password($username,$password);
			echo $password;
			echo "test";
			print_r($user_login);
			
			if($user_login){
				$this->session->set_userdata('id_guest',$user_login->id_guest);
				$this->session->set_userdata('guest_name',$user_login->firstname.' '.$user_login->lastname);				
				redirect('home');
			}
			else {
				redirect('login');
			}
			
			
		}
		else {
		//$this->load->view('v_header');
			$this->load->view('v_login');
		//$this->load->view('v_footer');
		}
	}
	
	function logout(){		
		$this->session->sess_destroy();
		redirect('login');
		
	}
		
}
