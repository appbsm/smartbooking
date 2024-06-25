<?php
class M_room_type extends CI_Model{
	
	function search_room ($b_date) {
		$result = array();
		$this->db->select('*');
		$this->db->from('room_type rt');
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();			
		}
		return $result;
	}
	
	function get_room_types ($id_project_info) {
		$result = array();
		$this->db->where('id_project_info', $id_project_info);
		$this->db->order_by('display_sequence', 'ASC');
		$query = $this->db->get('room_type');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_room_type_by_ID ($id_project_info, $id_room_type) {
		$result = new stdClass();
		$this->db->where('id_project_info', $id_project_info);
		$this->db->where('id_room_type', $id_room_type);
		$query = $this->db->get('room_type');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
	
	function get_first_photo_room_type ($id_room_type) {
		$result = new stdClass();
		$this->db->where('id_room_type', $id_room_type);
		$query = $this->db->get('room_type_photo');
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
	
	function get_room_type_photos ($id_room_type) {
		$result = array();
		$this->db->where('id_room_type', $id_room_type);
		$this->db->order_by('display_sequence', 'ASC');
		$query = $this->db->get('room_type_photo');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_room_facilities ($id_room_type) {
		$result = array();
		$this->db->where('id_room_type', $id_room_type);
		$query = $this->db->get('room_type_amenities');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_room_type_photos_by_modular ($id_room_type) {
		$result = array();
		$this->db->where('id_room_type', $id_room_type);
		$this->db->order_by('display_sequence', 'ASC');
		$query = $this->db->get('room_type_photo');
		if ($query->num_rows() > 0) {
			$res = $query->result();
			foreach ($res as $r) {
				$result[] = $r->room_photo_url;
			}
		}
		return $result;
	}
	
	// Room available
	function search_room_to_book ($r_check_in_date, $r_check_out_date) {
		$result = array();
		$select = "select * from room_details rd "
				. "left join room_type rt on rt.id_room_type = rd.id_room_type "
				. "where "
				. "rd.active = 1 AND rt.active = 1 AND "
				. "rd.id_room_details NOT IN ( "
				. "select br.id_room_details from booking b "
				. "left join booking_room br on br.booking_number = b.booking_number "
				. "where "
				. "b.check_out_date > '". $r_check_in_date ."' AND "
				. "b.check_in_date < '". $r_check_out_date ."' AND "
				. "b.status != 'Expired' AND b.status != 'Checked-out' AND b.status != 'Cancel'"
				. ") "
				. "order by rt.display_sequence";
		$query = $this->db->query($select);
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}	
	
	function get_count_available_rooms ($id_room_type, $r_check_in_date, $r_check_out_date) {
		$result = 0;
		$select = "select count(rd.id_room_type) as room_count from room_details rd "
				. "left join room_type rt on rt.id_room_type = rd.id_room_type "
				. "where rd.active = 1 "
				. "AND rt.active = 1 "
				. "AND rd.id_room_type = ".$id_room_type
				. " AND rd.id_room_details NOT IN ( " 
				. "select br.id_room_details from booking b "
				. "left join booking_room br on br.booking_number = b.booking_number "
				. "where "
				. "b.check_out_date > '". $r_check_in_date ."' AND "
				. "b.check_in_date < '". $r_check_out_date ."' AND "
				. "b.status != 'Expired' AND b.status != 'Checked-out' AND b.status != 'Cancel'"
				. ") "
				. "group by rd.id_room_type";
		$query = $this->db->query($select);
		if ($query->num_rows() > 0) {
			$res = $query->result();
			$result = $res[0]->room_count;
		}
		return $result;
	}
	
	function get_seasonal_price_by_room ($id_room_type) {
		//select * from seasonal_price where id_room_type = 1 order by is_priority DESC
		$result = array();
		$this->db->where('id_room_type', $id_room_type);
		$this->db->order_by('is_priority', 'DESC');
		$query = $this->db->get('seasonal_price');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_seasonal_price_by_room_date ($id_room_type, $current_date) {
		//
		$result = new stdClass();
		$select = "select TOP 1 * "
				. "from seasonal_price "
				. "WHERE id_room_type = '".$id_room_type."' "
				. "AND start_date <= '".$current_date."' "
				. "AND end_date >= '".$current_date."' "
				. "order by is_priority DESC";
		$query = $this->db->query($select);
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
	
	function get_season_price ($id_room_type, $_check_in_date, $_check_out_date) {
		$price_date = array();
			$in_date = explode('-', $_check_in_date);
			$check_in_date = $in_date[2].'-'.$in_date[1].'-'.$in_date[0];
			$out_date = explode('-', $_check_out_date);
			$check_out_date = $out_date[2].'-'.$out_date[1].'-'.$out_date[0];
			//$id_room_type = $this->input->post('id_room_type');			
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
		return $price_date;
	}
	
	function get_day_rate ($id_room_type, $current_date) {			
		$rate = 0;		
		$seasonal_price = $this->get_seasonal_price_by_room_date ($id_room_type, $current_date); 
		if (isset($seasonal_price->rate)) {
			$day_of_date = strtolower(date('D', strtotime($current_date)));
			$str_rate = $day_of_date.'_rate';
			$rate = $seasonal_price->$str_rate;
		}		
		else  {
			$room_type = $this->get_room_type_by_ID (1, $id_room_type);
			if (isset($room_type->default_rate)) {
				$rate = $room_type->default_rate;
			} 
		}
		return $rate;
	}
	
	function get_room_by_type ($id_room_type, $check_in_date, $check_out_date) {
		// old
		/*$result = new stdClass();
		$this->db->select('*');
		$this->db->from('room_details rd');
		$this->db->join('room_type rt', 'rt.id_room_type= rd.id_room_type', 'LEFT');
		$this->db->where('rd.id_room_type', $id_room_type);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;*/

		// new
		$result = array();
		$select = "select * from room_details rd "
				. "left join room_type rt on rt.id_room_type = rd.id_room_type "
				. "where "
				. "rd.active = 1 AND rt.active = 1 AND "
				. "rt.id_room_type = ". $id_room_type ." AND "
				. "rd.id_room_details NOT IN ( "
				. "select br.id_room_details from booking_room br "
				. "left join booking b on br.booking_number = b.booking_number "
				. "where "
				. "b.check_out_date > '". $check_in_date ."' AND "
				. "b.check_in_date < '". $check_out_date ."' AND "
				. "b.status != 'Expired' AND b.status != 'Checked-out' AND b.status != 'Cancel'"
				. ")";
		$query = $this->db->query($select);
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	private function date_array ($check_in_date, $check_out_date) {
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
	
	function get_room_details_by_type ($id_room_type) {
		$result = array();
		$this->db->where('id_room_type', $id_room_type);
		$query = $this->db->get('room_details');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_rooms_by_type ($id_room_type) {
		$result = array();
		$this->db->where('id_room_type', $id_room_type);
		$query = $this->db->get('room_details');
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
	
	function get_room_details_by_id ($id_room_details) {
		$result = new stdClass();
		$this->db->select('*');
		$this->db->from('room_details rd');
		$this->db->join('room_type rt', 'rt.id_room_type = rd.id_room_type', 'LEFT');
		$this->db->where('id_room_details', $id_room_details);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
}