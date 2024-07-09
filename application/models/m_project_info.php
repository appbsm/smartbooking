<?php
class M_project_info extends CI_Model{
	function get_all_project(){
		$result = array();
		$this->db->select('*');
		$this->db->from('project_info');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();	
		}
		return $result;
	}
	
	function get_project_info($id_project_info = 1) {
		$result = new stdClass();
		$this->db->select('bi.*, pi.*');
		$this->db->from('project_info pi');
		$this->db->join('business_info bi', 'bi.id_business_info = pi.id_business_info', 'LEFT');
		$this->db->where('pi.id_project_info', $id_project_info);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];			
		}
		return $result;
	}

	function get_project_info_detail($id_project_info = 1) {
		$result = new stdClass();
		$this->db->select('pi.*');
		$this->db->from('project_info pi');

		if (!empty($id_project_info)) {
        	$this->db->where('pi.id_project_info', $id_project_info);
    	}
    	$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];			
		}
		return $result;
	}

	function get_project_photos ($id_project_info = 1) {
		$result = array();
		$this->db->select('*');
		$this->db->from('project_photos');
		$this->db->where('id_project_info', $id_project_info);
		$this->db->order_by('display_sequence', 'ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();	
		}
		return $result;
	}
	
	function get_project_highlights ($id_project_info = 1) {
		$result = array();
		$this->db->select('*');
		$this->db->from('project_highlights');
		$this->db->where('id_project_info', $id_project_info);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();	
		}
		return $result;
	}
	
	function get_project_facility($id_project_info = 1) {
		$result = array();
		$this->db->select('*');
		$this->db->from('project_facility');
		$this->db->where('id_project_info', $id_project_info);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();	
		}
		return $result;
	}
	
	function get_property_facility () {
		$result = array();
		$this->db->select('*');
		$this->db->from('property_facility a');
		$this->db->join('project_facility b','a.id_property_facility = b.id_property_facility','inner');
		//$this->db->where('is_featured', $id_project_info);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();	
		}
		return $result;
	}
	
	function get_property_policy_type ($id_project_info = 1) {
		$result = array();
		$this->db->select('policy_type_en, policy_type_th');
		$this->db->from('project_policy');		
		$this->db->where('id_project_info', $id_project_info);
		$this->db->order_by('policy_type_en');
		$this->db->group_by('policy_type_en, policy_type_th');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();	
		}
		return $result;
	}
	
	function get_property_policy($id_project_info = 1, $type = '') {
		$result = array();
		$this->db->select('*');
		$this->db->from('project_policy');
		if ($type != '') {
			$this->db->where('policy_type_en', $type);
		}
		$this->db->where('id_project_info', $id_project_info);
		$this->db->order_by('policy_type_en');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();	
		}
		return $result;
	}
	
	function get_locations_nearby ($id_project_info = 1) {
		$result = array();
		$this->db->select('*');
		$this->db->from('point_of_interest');
		$this->db->where('id_project_info', $id_project_info);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();	
		}
		return $result;
	}

	
}