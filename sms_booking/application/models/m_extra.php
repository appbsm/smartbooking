<?php
class M_extra extends CI_Model{
	
 		
	function get_extra_from_extras () {
		$result = array();
		$this->db->where('active', 1);
		$this->db->order_by('id_extras', 'ASC');
		$query = $this->db->get('extras');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_extra_from_settings () {
		$result = array();
		$this->db->where('active', 1);
		$this->db->where('is_extra', 1);
		$this->db->order_by('id_setting', 'ASC');
		$query = $this->db->get('setting');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
}