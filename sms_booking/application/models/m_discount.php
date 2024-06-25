<?php
class M_discount extends CI_Model{
	
 		
	function get_discount ($id_discount, $date_used) {
		$result = new stdClass();
		$this->db->where('start_date <=', $date_used);
		$this->db->where('end_date >=', $date_used);
		$this->db->where('id_discount', $id_discount);
		$query = $this->db->get('discount');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
}