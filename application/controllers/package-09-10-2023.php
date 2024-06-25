<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends MY_Controller {

	public function __construct(){
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
	}

	public function package_details () {
		// $id_package = 4;
		$id_package = $this->uri->segment(3);
		$package_rooms = $this->m_package->get_package_items_by_id($id_package);
		//print_r($package_rooms);
		
		$room_types = array();
		foreach ($package_rooms as $r) {
			$room_type = $this->m_room_type->get_room_type_by_ID(1, $r->id_room_type);
			$room_type_photos = $this->m_room_type->get_room_type_photos_by_modular($r->id_room_type);
			$rt['room_type'] = $room_type;
			$rt['room_type_photos'] = $room_type_photos;
			$room_types[] = $rt;
		}
		
		$data['package'] = $package_rooms;
		$data['room_types'] = $room_types;
		//$data['room_amenities'] = $this->m_room_type->get_room_facilities($id_room_type);
		//$data['room_details'] = $this->m_room_type->get_room_details_by_type($id_room_type);
		
		
		
		$data['project_details'] = $this->m_project_info->get_project_info($this->id_project_info);
		$data['project_photos'] = $this->m_project_info->get_project_photos($this->id_project_info);
		$this->load->view('v_header');
		//$this->load->view('v_package_details', $data);
		$this->load->view('v_package_show', $data);
		$this->load->view('v_footer');	
	}
	
	public function test_avail_package () {
		$check_in_date = '2023-09-21';
		$check_out_date = '2023-09-23';
		$id_package = 8;
		$this->get_package_room_types ($id_package, $check_in_date, $check_out_date);
	}
	
	
}
