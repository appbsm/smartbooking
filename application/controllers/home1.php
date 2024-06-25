<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_project_info');
	 	if(!$this->session->userdata('id_guest')){
		 	redirect('login');
		}
	}
	
	public function index()
	{
		$data['project_details'] = $this->m_project_info->get_project_info(1);
		$data['project_photos'] = $this->m_project_info->get_project_photos(1);
		$room_types = $this->m_room_type->get_room_types(1);
		$modular_type = array('a', 'b, c', 'e');

		
		$data['type_a'] = $this->m_room_type->get_room_type_photos_by_modular(1);
		$data['type_b'] = $this->m_room_type->get_room_type_photos_by_modular(2);
		$data['type_c'] = $this->m_room_type->get_room_type_photos_by_modular(3);
		$data['type_e'] = $this->m_room_type->get_room_type_photos_by_modular(4);
		$data['room_types'] = $room_types;
		$this->load->view('v_header');
		$this->load->view('v_home', $data);
		$this->load->view('v_footer');
	}
	
	public function search () {
		if (!empty($_POST)) {
			$data['project_details'] = $this->m_project_info->get_project_info(1);
			$data['project_photos'] = $this->m_project_info->get_project_photos(1);
			$data['type_a'] = $this->m_room_type->get_room_type_photos_by_modular(1);
			$data['type_b'] = $this->m_room_type->get_room_type_photos_by_modular(2);
			$data['type_c'] = $this->m_room_type->get_room_type_photos_by_modular(3);
			$data['type_e'] = $this->m_room_type->get_room_type_photos_by_modular(4);
			//$data['room_types'] = $room_types;
			
			$in_date = explode('-', $this->input->post('check_in_date'));
			$check_in_date = $in_date[2].'-'.$in_date[1].'-'.$in_date[0];
			$out_date = explode('-', $this->input->post('check_out_date'));
			$check_out_date = $out_date[2].'-'.$out_date[1].'-'.$out_date[0];
			$data['result'] = $this->m_room_type->search_room_to_book($check_in_date, $check_out_date);
			//print_r($result);
			$data['check_in_date'] = $this->input->post('check_in_date');
			$data['check_out_date'] = $this->input->post('check_out_date');
			$this->load->view('v_header');
			$this->load->view('v_search', $data);
			$this->load->view('v_footer');
		}
	}
	
	public function get_all_room_photos() {
		
		$type_a = $this->m_room_type->get_room_type_photos_by_modular(1);
		print_r($type_a);
	}
	
	public function test_shared_folder () {
		
		$this->load->view('v_test_shared');
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
