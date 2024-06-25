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

	public function index () {
		// $id_package = 4;
		
		$package_rooms = $this->m_package->get_package_items_by_id($id_package);
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
		$this->load->view('v_header');
		$this->load->view('v_package_details', $data);
		$this->load->view('v_footer');	
	}
	
	
}
