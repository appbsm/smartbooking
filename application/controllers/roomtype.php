<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roomtype extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_project_info');
		$this->load->model('m_package');
	 	/*if(!$this->session->userdata('id_guest')){
		 	redirect('login');
		}*/
		$this->id_project_info = 1;
	}
	
	public function index($id_project='')
	{	
		$data['project_all'] = $this->m_project_info->get_all_project();

		if($id_project==''){
			$id_project=1;
		}
		$data['project_details'] = $this->m_project_info->get_project_info_detail($id_project);
		
		$data['project_highlights'] = $this->m_project_info->get_project_highlights($id_project);
		$data['project_facility'] = $this->m_project_info->get_project_facility($id_project);

		$data['project_policy_type'] = $this->m_project_info->get_property_policy_type($id_project);
		$data['project_policy'] = $this->m_project_info->get_property_policy($id_project,'');

		$data['point_of_interest'] = $this->m_project_info->get_locations_nearby($id_project);

		$data['project_all'] = $this->m_project_info->get_all_project();

		$this->load->view('v_header');
		$this->load->view('roomtype', $data);
		$this->load->view('v_footer');
	}

	public function project_detail($id_project = '')
	{
		if($id_project==''){
			$id_project=1;
		}
		$data['project_details'] = $this->m_project_info->get_project_info_detail($id_project);
		
		$data['project_highlights'] = $this->m_project_info->get_project_highlights($id_project);
		$data['project_facility'] = $this->m_project_info->get_project_facility($id_project);

		$data['project_policy_type'] = $this->m_project_info->get_property_policy_type($id_project);
		$data['project_policy'] = $this->m_project_info->get_property_policy($id_project,'');

		$data['point_of_interest'] = $this->m_project_info->get_locations_nearby($id_project);

		$data['project_all'] = $this->m_project_info->get_all_project();

		$this->load->view('v_header');
		$this->load->view('facilities_amenities', $data);
		$this->load->view('v_footer');
	}
	
	public function header_page () {
		$this->load->view('v_header_my');
		$this->load->view('v_footer');
		
	}
	
	public function search () {

		$this->id_project_info = $this->input->post('project_id');
		$data = array();

		if (!empty($_POST)) {
			$data['project_all'] = $this->m_project_info->get_all_project();
			$data['project_details'] = $this->m_project_info->get_project_info($this->id_project_info);
			$data['project_photos'] = $this->m_project_info->get_project_photos($this->id_project_info);
			$data['packages'] = $this->m_package->get_all_packages();
			$search_type = $this->input->post('search_type');
			if ($search_type == 'search_room') {
				$room_types = $this->m_room_type->get_room_types($this->id_project_info);
				$modular_type = array();
				
				$types_photos = array();
				foreach ($room_types as $key => $rt) {
					array_push($modular_type, $key); 
					// $this->m_room_type->get_room_type_photos_by_modular($room_types[$key]->id_room_type);
					array_push($types_photos, $this->m_room_type->get_room_type_photos_by_modular($room_types[$key]->id_room_type));
				}
				$data['num_of_adult'] = $this->input->post('s_num_of_adult');
				$data['num_of_room'] = $this->input->post('s_num_of_room');
				$data['num_of_children'] = $this->input->post('s_num_of_children');
				$data['children_ages'] = $this->input->post('s_children_ages');
				$data['types_photos'] = $types_photos;
				$data['modular_type'] = $modular_type;
				$data['children'] = $this->input->post('children');
				$data['adult'] = $this->input->post('adult');
				$data['room'] = $this->input->post('room');
				$data['project_id'] = $this->input->post('project_id');
				$data['select_age'] = $this->input->post('select_age');
				$check_in_date = date_reformat($this->input->post('check_in_date'), 'day_to_year_dash');
				$check_out_date = date_reformat($this->input->post('check_out_date'), 'day_to_year_dash');							
				$data['result'] = $this->m_room_type->search_room_to_book($check_in_date, $check_out_date);
				$data['check_in_date'] = $this->input->post('check_in_date');
				$data['check_out_date'] = $this->input->post('check_out_date');

				$this->load->view('v_header');
				$this->load->view('v_search', $data);
				$this->load->view('v_footer');
			}
			else if ($search_type == 'search_package'){
				$check_in_date = date_reformat($this->input->post('check_in_date'), 'day_to_year_dash');
				$check_out_date = date_reformat($this->input->post('check_out_date'), 'day_to_year_dash');							
				//$data['result'] = $this->m_room_type->search_room_to_book($check_in_date, $check_out_date);
				$data['check_in_date'] = $this->input->post('check_in_date');
				$data['check_out_date'] = $this->input->post('check_out_date');
				$packages = $this->input->post('packages');
				// $result = $this->m_package->get_available_package($check_in_date, $packages);	
				$result = $this->m_package->get_all_packages();		
				$package_result = array();
				foreach ($result as $r) {					
					// get package items by ID
					$package = $this->m_package->get_package_items_by_id ($r->id_package);					
					$package_rooms = array();
					foreach ($package as $p) {
						$room = $this->m_room_type->get_room_type_by_ID ($this->id_project_info, $p->id_room_type);
						$package_rooms[] = $room; 
						//print_r($room);
						//echo "<br><br>";
					}
					$p_result = array();
					$p_result['id_package'] = $r->id_package;
					$p_result['header'] = $package;
					$p_result['room_types'] = $package_rooms;
					$package_result[] = (array)$p_result;
					
				}
				$data['package_result'] = $package_result;
				$this->load->view('v_header');
				$this->load->view('v_package_search', $data);
				$this->load->view('v_footer');
			}
			$data['search_type'] = $search_type;
			$this->session->set_userdata('search_data', json_encode($data));
		}
		else {
			//redirect('home');
			$data = (array)json_decode($this->session->userdata('search_data'));
			//print_r($data['package_result']);
			if ($data['search_type'] == 'search_room') {
				$this->load->view('v_header');
				$this->load->view('v_search', $data);
				$this->load->view('v_footer');
			}
			else if ($data['search_type'] == 'search_package') {
				$this->load->view('v_header');
				$this->load->view('v_package_search', $data);
				$this->load->view('v_footer');
			}
		}
	}
	
	public function get_all_room_photos() {		
		$type_a = $this->m_room_type->get_room_type_photos_by_modular($this->id_project_info);
		print_r($type_a);
	}
	
	public function test_settings () {
		$max_children_age = app_settings('max_children_age');
		echo $max_children_age;
	}	
	
	public function test_available_package () {
		$check_in_date = '2023-03-09';
		$result = $this->m_package->get_available_package($check_in_date);
		
		foreach ($result as $r) {
			
			//1. get package by ID
			$package = $this->m_package->get_package_items_by_id ($r->id_package);
			
			foreach ($package as $p) {
				$room = $this->m_room_type->get_room_type_by_ID ($this->id_project_info, $p->id_room_type);
				print_r($room);
			echo "<br><br>";
			}
		}
		
	}
	
	/*
	public function bootstrap3()
	{
		$this->load->view('bootstrap3');
	}
	
	public function bootstrap4()
	{
		$this->load->view('bootstrap4');
	}
	*/
}
