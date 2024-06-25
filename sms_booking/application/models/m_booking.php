<?php
class M_booking extends CI_Model{
	
 	
	
	function insert_booking ($data) {
		$this->db->insert('booking', $data);
		//echo $this->db->last_query();
	}
	
	function insert_booking_item ($data) {
		$this->db->insert('booking_item', $data);
	}
	
	function insert_booking_room ($data) {
		$this->db->insert('booking_room', $data);
	}
	
	function update_booking ($data, $booking_number) {
		$this->db->where('booking_number', $booking_number);
		$this->db->update('booking', $data);
		echo $this->db->last_query();		
	}
	
	function generate_booking_number () {
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
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_booking_history($id_guest_info) {
		$result = array();
		$this->db->where('id_guest_info', $id_guest_info);
		$this->db->order_by('booking_date', 'DESC');
		$query = $this->db->get('booking');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	
	
}