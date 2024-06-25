<?php
class M_settings extends CI_Model{
	
 		
	function get_settings () {
		$result = array();
		$query = $this->db->get('setting');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
}