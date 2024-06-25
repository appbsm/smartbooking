<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_guest');
		$this->load->model('m_cart');
		$this->load->model('m_project_info');
		$this->load->model('m_stringlib');
	}
	
	public function index()
	{
		$id_guest_info = $this->session->userdata('id_guest');	
		$data['cart_items'] = $this->m_cart->get_cart_items($id_guest_info);		
		
		$this->load->view('v_header');
		$this->load->view('v_cart_items', $data);
		$this->load->view('v_footer');
	}
	
	public function room_available () {
		if (!empty($_POST)) {
			//$check_in_date = '2023-01-12';
			//$check_out_date = '2023-01-13';
			//$rooms = array(3, 4);

			$in_date = explode('-', $this->input->post('check_in_date'));
			$check_in_date = $in_date[2].'-'.$in_date[1].'-'.$in_date[0];
			$out_date = explode('-', $this->input->post('check_out_date'));
			$check_out_date = $out_date[2].'-'.$out_date[1].'-'.$out_date[0];
			$rooms = explode(',', $this->input->post('rooms'));
			$available_rooms = $this->m_room_type->search_room_to_book ($check_in_date, $check_out_date);
			$arr_room_avail = array();
			foreach ($available_rooms as $a_room) {
				$arr_room_avail[] = $a_room->id_room_type;
			}
			$rooms_not_available = array();
			
			foreach ($rooms as $r) {
				if (!in_array($r, $arr_room_avail)) {
					
					$rooms_not_available[] = $r;
				}
			}
			//print_r($rooms_not_available);
			echo json_encode($rooms_not_available);
		}
	}
	
	function add_to_cart () {
		if(!empty($_POST)) {
			$id_guest_info = $this->session->userdata('id_guest');	
			$id_room_type = $this->input->post('id_room_type');
			$room_rate = $this->input->post('room_rate');
			$room_type = $this->m_room_type->get_room_type_by_ID(1, $id_room_type);
			$data = array(
				'id_guest_info' => $id_guest_info,
				'id_room_type' => $id_room_type,
				'room_type_name_en' => $room_type->room_type_name_en,
				'room_type_name_th' => $room_type->room_type_name_th,
				'unit_price' => $room_rate,
				'quantity' => 1,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->m_cart->insert_to_cart($data);
		}
	}
	
	function delete_to_cart () {
		if(!empty($_POST)) {
			$id_cart_item = $this->input->post('id_cart_item');			
			$this->m_cart->delete_to_cart($id_cart_item);
		}
	}
}
