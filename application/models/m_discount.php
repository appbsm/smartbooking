<?php
class M_discount extends CI_Model{
	
 		
	function get_discount ($id_discount, $booking_date, $check_in_date, $checkout_date) {
		$result = new stdClass();
		$select = "select * from discount "
				. "where (start_date_booking <= '".$booking_date."' AND end_date_booking >= '".$booking_date."') "
				. "AND ( "
				. "start_date_check_in <=  '".$check_in_date."' AND end_date_check_in >= '".$check_in_date."' "
				. "OR "
				. "start_date_check_in < '".$checkout_date."' "
				. ") "
				. "AND id_discount = '".$id_discount."' "
				; 
		$query = $this->db->query($select);
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
	
	function get_discount_by_code ($code, $booking_date, $check_in_date, $checkout_date) {
		$result = new stdClass();
		$select = "select * from discount "
				. "where (start_date_booking <= '".$booking_date."' AND end_date_booking >= '".$booking_date."') "
				. "AND ( "
				. "start_date_check_in <=  '".$check_in_date."' AND end_date_check_in >= '".$check_in_date."' "
				. "OR "
				. "start_date_check_in < '".$checkout_date."' "
				. ") "
				. "AND code = '".$code."' "
				; 
		$query = $this->db->query($select);		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
	
	
	
}