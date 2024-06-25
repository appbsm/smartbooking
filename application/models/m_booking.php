<?php
class M_booking extends CI_Model{
	
 	
	
	function insert_booking ($data) {
		$this->db->insert('booking', $data);
		//echo $this->db->last_query();
	}
	
	function insert_booking_item ($data) {
		$this->db->insert('booking_item', $data);
		return $this->db->insert_id();
		//echo $this->db->last_query();
	}
	
	function insert_booking_room ($data) {
		$this->db->insert('booking_room', $data);
	}
	
	function update_booking ($data, $booking_number) {
		$this->db->where('booking_number', $booking_number);
		$this->db->update('booking', $data);
		//echo $this->db->last_query();		
	}
		
	function save_booking_payment ($data) {
		$this->db->insert('booking_payment', $data);
		//echo $this->db->last_query();		
	}
	
	/*function generate_booking_number_old () {
		$current_year = date('Y');
		$booking_num = date('Y').'-';
		$running_number = 1;
		$query = $this->db->get('booking_num');
		echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();			
			print_r($r);
			$last_year = date('Y', strtotime($r[0]->last_date_created));
			if ($current_year > $last_year) {
				$running_number = 1;
				$data = array('running_num' => $running_number, 'last_date_created' => date('Y-m-d'));				
				$this->db->update('booking_num', $data);
			} else {
				if ($r[0]->running_num > 0) {
					$running_number = $r[0]->running_num + 1;
					$data = array('running_num' => $running_number, 'last_date_created' => date('Y-m-d'));				
					$this->db->update('booking_num', $data);
				}
				else {
					$data = array('running_num' => $running_number, 'last_date_created' => date('Y-m-d'));				
					$this->db->insert('booking_num', $data);
				}
			}					
		}
		else {
			$data = array('running_num' => $running_number, 'last_date_created' => date('Y-m-d'));				
			$this->db->insert('booking_num', $data);
		}	
		$booking_num = $booking_num.str_pad($running_number, 5, '0', STR_PAD_LEFT); 
		return $booking_num;
	}*/

	function generate_booking_number () {
		$current_year = date('Y');

		$this->db->order_by('id_booking', 'DESC');
		$bookings = $this->db->get('booking')->result_array();
		if (count($bookings) == 0) {
			$lastest_year = $current_year;
		} else {
			$lastest_year = date('Y', strtotime($bookings[0]['booking_date']));
		}

		if ($lastest_year == $current_year) {
			$this->db->where('name', 'booking_number_running');
			$setting_row = $this->db->get('setting')->result_array();
			$booking_number_running = $setting_row[0]['value'];

			$this->db->where('name', 'booking_number_running');
			$this->db->update('setting', array('value' => $booking_number_running + 1, 'updated' => date('Y-m-d H:i:s')));

			if ($booking_number_running >= 100000) {
				return $lastest_year .'-'. str_pad($booking_number_running + 1, 5, '0', STR_PAD_LEFT);
			} else {
				return $lastest_year .'-'. str_pad($booking_number_running + 1, 5, '0', STR_PAD_LEFT);
			}
		} else {
			$this->db->where('name', 'booking_number_running');
			$this->db->update('setting', array('value' => 1, 'updated' => date('Y-m-d H:i:s')));
			return $lastest_year .'-00001';
		}
	}
	
	function get_booking_by_booking_number ($booking_number) {
		$result = new stdClass();
		$this->db->where('booking_number', $booking_number);
		$query = $this->db->get('booking');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
	
	function get_items_by_booking_number ($booking_number) {
		$result = array();
		$this->db->where('booking_number', $booking_number);
		$query = $this->db->get('booking_item');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_items_by_id_booking($id_booking) {
		$result = array();
		$this->db->where('id_booking', $id_booking);
		
		$query = $this->db->get('booking_item');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_booking_history($id_guest_info) {
		$result = array();
		$this->db->where('id_guest_info', $id_guest_info);
		$this->db->order_by('id_booking', 'DESC');
		//$this->db->order_by('booking_date', 'DESC');
		$query = $this->db->get('booking');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}

	function get_booking_payment($booking_number) {
		$result = array();
		$this->db->where('booking_number', $booking_number);
		$this->db->order_by('transfer_time', 'DESC');
		$query = $this->db->get('booking_payment');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_booking_total_payment($booking_number) {
		$result = new stdClass();
		$this->db->select('SUM(transferred_amount) as total_payment');
		$this->db->where('booking_number', $booking_number);
		//$this->db->group_by('transferred_amount');
		$query = $this->db->get('booking_payment');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$res = $query->result();
			$result = $res[0];
		}
		return $result;
	}
	
	function package_booking_item_discount ($booking_number, $id_package) {
		$result = new stdClass();
		$select = "select SUM(discount) as discount from booking_item "
				. "where booking_number = '".$booking_number."' "
				. "and id_package = ".$id_package
				;
		$query = $this->db->query($select);
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];		
		}
		return $result;
	}
		
	function insert_booking_item_date ($data) {
		$this->db->insert('booking_item_date', $data);
	}
}