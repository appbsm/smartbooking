	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room_details extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_project_info');
	}
	
	public function index()
	{
		$id_room_type = '';
		if (!empty($_POST)) {
			if(!$this->session->userdata('id_guest')){
				$this->session->set_userdata('num_of_adult',$this->input->post('h_num_of_adult'));
				$this->session->set_userdata('num_of_room',$this->input->post('h_num_of_room'));
				$this->session->set_userdata('num_of_children',$this->input->post('h_num_of_children'));
				$this->session->set_userdata('children_ages',$this->input->post('h_children_ages'));
				$this->session->set_userdata('check_in_date',$this->input->post('h_check_in_date'));
				$this->session->set_userdata('check_out_date',$this->input->post('h_check_out_date'));
				$this->session->set_userdata('id_room_type',$this->input->post('h_id_room_type'));
				
				
			}
			$id_room_type = $this->input->post('h_id_room_type');
			$data['num_of_adult'] = $this->input->post('h_num_of_adult');
			$data['num_of_room'] = $this->input->post('h_num_of_room');
			$data['num_of_children'] = $this->input->post('h_num_of_children');
			$data['children_ages'] = $this->input->post('h_children_ages');
			$data['check_in_date'] = $this->input->post('h_check_in_date');
			$data['check_out_date'] = $this->input->post('h_check_out_date');
			
		}	 
		else if ($this->session->userdata('id_room_type')) {
			$id_room_type = $this->session->userdata('id_room_type');
			$data['num_of_adult'] = $this->input->post('h_num_of_adult');
			$data['num_of_room'] = $this->input->post('h_num_of_room');
			$data['num_of_children'] = $this->input->post('h_num_of_children');
			$data['children_ages'] = $this->input->post('h_children_ages');
			$data['check_in_date'] = $this->input->post('h_check_in_date');
			$data['check_out_date'] = $this->input->post('h_check_out_date');
		}
		if ($id_room_type != '') {
			$room_type = $this->m_room_type->get_room_type_by_ID(1, $id_room_type);			
			$data['room_type_photos'] = $this->m_room_type->get_room_type_photos_by_modular($id_room_type);
			$data['room_type'] = $room_type;
			$data['room_amenities'] = $this->m_room_type->get_room_facilities($id_room_type);
			$data['room_details'] = $this->m_room_type->get_room_details_by_type($id_room_type);
			$data['locations_nearby'] = $this->m_project_info->get_locations_nearby(1);
			$this->load->view('v_header');
			$this->load->view('v_room_details', $data);
			$this->load->view('v_footer');
		}
	}
	
	function get_day_rate ($id_room_type, $current_date) {			
		$rate = 0;		
		$seasonal_price = $this->get_seasonal_price_by_room_date ($id_room_type, $current_date); 
		if (isset($seasonal_price->rate)) {
			$day_of_date = strtolower(date('D', strtotime($current_date)));
			$str_rate = $day_of_date.'_rate';
			$rate = $seasonal_price->$str_rate;
		}		
		return $rate;
	}
	
	function get_season_price () {
		//$check_in_date = '2023-04-12';
		//$check_out_date = '2023-04-16';
		//$id_room_type = 1;
		$price_date = array();		
		if (!empty($_POST)) {
			$in_date = explode('-', $this->input->post('check_in_date'));
			$check_in_date = $in_date[2].'-'.$in_date[1].'-'.$in_date[0];
			$out_date = explode('-', $this->input->post('check_out_date'));
			$check_out_date = $out_date[2].'-'.$out_date[1].'-'.$out_date[0];
			$id_room_type = $this->input->post('id_room_type');			
			$dates = $this->date_array($check_in_date, $check_out_date);
			
			$rate = 0;
			$prev_rate = 0;
			$night_ctr = 1;
			foreach  ($dates as $indx => $d) {
				$_price = new stdClass();
				
				$seasonal_price = $this->m_room_type->get_seasonal_price_by_room_date ($id_room_type, $d); 
				//print_r($seasonal_price);
				if (isset($seasonal_price->rate)) {
					$day_of_date = strtolower(date('D', strtotime($d)));
					$str_rate = $day_of_date.'_rate';
					$rate = $seasonal_price->$str_rate;
				}
				else {
					$room_type = $this->m_room_type->get_room_type_by_ID(1, $id_room_type);
					$rate = $room_type->default_rate;
				}
				
				if ($indx == 0) {
					$_price->night_ctr = $night_ctr;
					$_price->unit_price = $rate;
					$_price->item_total_price = $rate*$night_ctr;
					array_push($price_date, (array)$_price);	
					$prev_rate = $rate;							
				}
				else {
					$found_key = array_search($rate, array_column($price_date, 'unit_price'));
					if ($found_key !== false) {
	
						$array_found = $price_date[$found_key];	
						//print_r($array_found);					
						unset($price_date[$found_key]);		
						$price_date = array_values($price_date);				
						$night_ctr = $array_found['night_ctr'] + 1;
						$_price->night_ctr = $night_ctr;
						$_price->unit_price = $rate;
						$_price->item_total_price = $rate*$night_ctr;
						//$remove = array_pop($price_date);  
						array_push($price_date, (array)$_price);	
						$prev_rate = $rate;	
					}
					else {
						$night_ctr = 1;
						$_price->night_ctr = $night_ctr;
						$_price->unit_price = $rate;
						$_price->item_total_price = $rate*$night_ctr;
						array_push($price_date, (array)$_price);	
						$prev_rate = $rate;	
					}
				}
													
			}
		}
		//print_r($price_date);		
		echo json_encode($price_date);
	}
	
	function test_get_season_price () {
		$check_in_date = '2023-01-12';
		$check_out_date = '2023-01-16';
		$id_room_type = 1;
		$price_date = array();		
		//if (!empty($_POST)) {
						
			$dates = $this->date_array($check_in_date, $check_out_date);
			
			$rate = 0;
			$prev_rate = 0;
			$night_ctr = 1;
			
			foreach  ($dates as $indx => $d) {
				$_price = new stdClass();
				echo "INDEX".$indx."<br>";
				$seasonal_price = $this->m_room_type->get_seasonal_price_by_room_date ($id_room_type, $d); 
				//print_r($seasonal_price);
				if (isset($seasonal_price->rate)) {
					$day_of_date = strtolower(date('D', strtotime($d)));
					$str_rate = $day_of_date.'_rate';
					$rate = $seasonal_price->$str_rate;
				}
				else {
					$room_type = $this->m_room_type->get_room_type_by_ID(1, $id_room_type);
					$rate = $room_type->default_rate;
				}
				echo "--".$rate.'--'."<br>";
				
				if ($indx == 0) {
					echo "1"."<br>";
					$_price->night_ctr = $night_ctr;
					$_price->unit_price = $rate;
					$_price->item_total_price = $rate*$night_ctr;
					array_push($price_date, (array)$_price);	
					$prev_rate = $rate;			
					//print_r($price_date);				
				}
				else {

					print_r($price_date);
					$found_key = array_search($rate, array_column($price_date, 'unit_price'));

					if ($found_key !== false) {
	
						$array_found = $price_date[$found_key];	
						//print_r($array_found);					
						unset($price_date[$found_key]);		
						$price_date = array_values($price_date);				
						$night_ctr = $array_found['night_ctr'] + 1;
						$_price->night_ctr = $night_ctr;
						$_price->unit_price = $rate;
						$_price->item_total_price = $rate*$night_ctr;
						//$remove = array_pop($price_date);  
						array_push($price_date, (array)$_price);	
						$prev_rate = $rate;	
					}
					else {
						echo "4"."<br>";
						$night_ctr = 1;
						$_price->night_ctr = $night_ctr;
						$_price->unit_price = $rate;
						$_price->item_total_price = $rate*$night_ctr;
						array_push($price_date, (array)$_price);	
						$prev_rate = $rate;	
					}
					/*
					if ($prev_rate != $rate) {
						$night_ctr = 1;
						$_price->night_ctr = $night_ctr;
						$_price->unit_price = $rate;
						$_price->item_total_price = $rate*$night_ctr;
						array_push($price_date, (array)$_price);	
						$prev_rate = $rate;	
					}
					else {			
						
					}
					*/
				}
													
			}
		//}
		print_r($price_date);		
		//echo json_encode($price_date, JSON_UNESCAPED_UNICODE);
	}
	
	function date_array ($check_in_date, $check_out_date) {
		$result = array();
		$go = 1;
		$new_date = $check_in_date;
		$ctr = 0;
		do {
			if ($ctr > 0) {
				$new_date = date('Y-m-d', strtotime("+1 day", strtotime($new_date)));
				if (strtotime($new_date) < strtotime($check_out_date)) {
					array_push($result, $new_date);
				}
				else {
					$go = 0;
					break;
				}
			}
			else {
				array_push($result, $new_date);
			}
			$ctr++; 
		}while($go==1);
		return $result;
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
	
}
