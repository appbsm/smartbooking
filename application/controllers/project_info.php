<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_info extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_project_info');
		$this->load->model('m_package');
	}
	
	public function index()
	{
		$data['project_details'] = $this->m_project_info->get_project_info(1);
		$data['project_photos'] = $this->m_project_info->get_project_photos(1);
		$room_types = $this->m_room_type->get_room_types(1);
		$modular_type = array();
		$types_photos = array();
		foreach ($room_types as $key => $rt) {
			array_push($modular_type, $key); 
			//$this->m_room_type->get_room_type_photos_by_modular($room_types[$key]->id_room_type);
			array_push($types_photos, $this->m_room_type->get_room_type_photos_by_modular($room_types[$key]->id_room_type));
		}
		$data['types_photos'] = $types_photos;		
		$data['room_types'] = $room_types;		
		$data['modular_type'] = $modular_type;
		
		$data['project_highlights'] = $this->m_project_info->get_project_highlights(1);
		$data['property_facility'] = $this->m_project_info->get_property_facility();
		$project_facility = $this->m_project_info->get_project_facility(1);
		$data['project_policy'] = $this->m_project_info->get_property_policy_type(1);
		$proj_facility = array();
		
		foreach ($project_facility as $f) {
			array_push($proj_facility, $f->long_desc_en);
		}
		$data['project_facility'] = $proj_facility;
		$data['locations_nearby'] = $this->m_project_info->get_locations_nearby(1);
		$data['room_types'] = $room_types;
		$this->load->view('v_header');
		$this->load->view('v_project_info', $data);
		$this->load->view('v_footer');
	}
	
	
}
