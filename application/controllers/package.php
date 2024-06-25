<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Package extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_project_info');
		$this->load->model('m_guest');
		$this->load->model('m_package');
		//if(!$this->session->userdata('id_guest')){
		//redirect('login');
		//header("Location: ". login_url());
		//}
		$this->id_project_info = 1;
		$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai'; 
		if($lg=='thai'){
		    $this->lang->load('content','thai');
		}
		elseif($lg=='english'){
		    $this->lang->load('content','english');
		}
		$this->language  = $lg;
	}

	public function package_details()
	{
		try {
			if ($this->input->post()) {
				$params = array();
				$params['package_id'] = $_POST['package_id'];
				$params['check_in_date'] = date('Y-m-d' , strtotime($_POST['check_in_date']));
				$params['check_out_date'] = date('Y-m-d' , strtotime($_POST['check_out_date']));
				$package_rooms = $this->m_package->get_package_items_by_id($params['package_id']);
				
				$result = $this->m_room_type->search_room_to_book($params['check_in_date'],$params['check_out_date']);

				$data['params'] = $params;
				if(!$result){
					$data['package_id'] = $params['package_id'];
					$data['package'] = array();
					$data['room_types'] = array();
					$data['project_details'] = $this->m_project_info->get_project_info($this->id_project_info);
					$data['project_photos'] = $this->m_project_info->get_project_photos($this->id_project_info);
					$this->session->set_flashdata('message_error', $this->lang->line('package_is_not_available'));
				}else{
					$this->session->unset_userdata('message_error');
					$room_types = array();
					foreach ($package_rooms as $r) {
						$room_type = $this->m_room_type->get_room_type_by_ID(1, $r->id_room_type);
						$room_type_photos = $this->m_room_type->get_room_type_photos_by_modular($r->id_room_type);
						$rt['room_type'] = $room_type;
						$rt['room_type_photos'] = $room_type_photos;
						$room_types[] = $rt;
					}
					$data['package_id'] = $params['package_id'];
					$data['package'] = $package_rooms;
					$data['room_types'] = $room_types;
					$data['project_details'] = $this->m_project_info->get_project_info($this->id_project_info);
					$data['project_photos'] = $this->m_project_info->get_project_photos($this->id_project_info);
				}
				

			} else {
				// $id_package = 4;
				$id_package = $this->uri->segment(3);
				$package_rooms = $this->m_package->get_package_items_by_id($id_package);
				$room_types = array();
				foreach ($package_rooms as $r) {
					$room_type = $this->m_room_type->get_room_type_by_ID(1, $r->id_room_type);
					$room_type_photos = $this->m_room_type->get_room_type_photos_by_modular($r->id_room_type);
					$rt['room_type'] = $room_type;
					$rt['room_type_photos'] = $room_type_photos;
					$room_types[] = $rt;
				}
				$data['package_id'] = $id_package;
				$data['package'] = $package_rooms;
				$data['room_types'] = $room_types;
				$data['project_details'] = $this->m_project_info->get_project_info($this->id_project_info);
				$data['project_photos'] = $this->m_project_info->get_project_photos($this->id_project_info);
			}
		} catch (Exception $e) {
			$this->session->set_flashdata('message_error', $e->getMessage());
		}

		$this->load->view('v_header');
		$this->load->view('v_package_show', $data);
		$this->load->view('v_footer');
	}

	public function test_avail_package()
	{
		$check_in_date = '2023-09-21';
		$check_out_date = '2023-09-23';
		$id_package = 8;
		$this->get_package_room_types($id_package, $check_in_date, $check_out_date);
	}
}
