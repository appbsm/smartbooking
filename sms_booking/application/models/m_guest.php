<?php
class M_guest extends CI_Model{
	
 	
	function insert_profile ($data) {
		$this->db->insert('guest_info', $data);
	}
	
	function update_profile ($data, $id_guest) {
		$this->db->where('id_guest', $id_guest);
		$this->db->update('guest_info', $data);
		//echo $this->db->last_query();
	}
	
	function get_profile_by_username_password($email,$pass_md5) {		
		$result = new stdClass;				
		$this->db->select('*');
		$this->db->from('guest_info');
		$this->db->where('is_active',1);
		$this->db->where('username',$email);
		$this->db->where('password',$pass_md5);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$r = $query->result();
			$result = $r[0];
		}else{			
			$result = false;
		}
		return $result;
	}
	
	function get_profile_by_guestID($id_guest) {		
		$result = new stdClass;				
		$this->db->select('*');
		$this->db->from('guest_info');
		$this->db->where('is_active',1);
		$this->db->where('id_guest',$id_guest);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$r = $query->result();
			$result = $r[0];
		}else{			
			$result = false;
		}
		return $result;
	}
	
	
}