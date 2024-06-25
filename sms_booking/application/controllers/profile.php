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
		
		$this->load->view('v_header');
		$this->load->view('v_profile_update', $data);
		$this->load->view('v_footer');
	}
	
	public function save_profile () {
		if (!empty($_POST)) {
			if ($_FILES['guest_photo']['name'] != '') {							
					$doc_link = '';
					$target_dir = 'upload/guest_photo/'; 					
					$old_file_1 = basename($_FILES["guest_photo"]["name"]);
					$extension = substr($old_file_1,strpos($old_file_1, '.'),strlen($old_file_1));
					//$timestamp = date('YmdHis');
					//$target_file = $this->input->post('username').'_'.$timestamp.$extension;
					$target_file = $this->rand().$extension;
		
					$config['file_name'] 			= $target_file;
					$config['upload_path']          = $target_dir;
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
	        		$password = $this->m_stringlib->useMD5($this->input->post('password'), strtolower($this->input->post('password')));
					$data = array(
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'contact_number' => $this->input->post('contact_number'),
						'address' => $this->input->post('address'),
						'email' => $this->input->post('email'),
						'username' => $this->input->post('username'),
						'password' => $password,
						'photo_url' => $doc_link,
						'is_active' => 1,	
						'date_created' => 'Y-m-d H:i:s'	
					);
					$this->m_guest->insert_profile($data);		
				redirect('profile');
			}
			
			
			
		}
	}
	public function update_password () {
		if (!empty($_POST)) {
			$id_guest = $this->input->post('id_guest_p');
			$password = $this->m_stringlib->useMD5($this->input->post('password'), strtolower($this->input->post('password')));
			$data = array ('username' => $this->input->post('username'), 'password' => $password);
			$this->m_guest->update_profile($data, $id_guest);
			redirect('profile');
		}
	}
	
	public function update_profile () {
		if (!empty($_POST)) {
			if ($_FILES['guest_photo']['name'] != '') {							
					$id_guest = $this->input->post('id_guest');
					$doc_link = '';
					$target_dir = 'upload/guest_photo/'; 					
					$old_file_1 = basename($_FILES["guest_photo"]["name"]);
					$extension = substr($old_file_1,strpos($old_file_1, '.'),strlen($old_file_1));
					//$timestamp = date('YmdHis');
					//$target_file = $this->input->post('username').'_'.$timestamp.$extension;
					$target_file = $this->rand().$extension;
		
					$config['file_name'] 			= $target_file;
					$config['upload_path']          = $target_dir;
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
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'contact_number' => $this->input->post('contact_number'),
						'address' => $this->input->post('address'),
						'email' => $this->input->post('email'),
						/*
						'username' => $this->input->post('username'),
						'password' => $password,*/
						'photo_url' => $doc_link,
						'is_active' => 1
					);
					$this->m_guest->update_profile($data, $id_guest);		
				redirect('profile');
			}
			
			
			
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
