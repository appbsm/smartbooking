<?php
class M_guest extends CI_Model{
	
 	
	function insert_profile ($data) {
		$this->db->insert('guest_info', $data);
		return $this->db->insert_id();
	}
	
	function update_profile ($data, $id_guest) {
		$this->db->where('id_guest', $id_guest);
		$this->db->update('guest_info', $data);
		//echo $this->db->last_query();
	}
	
	// function update_temp_password($data, $email) {
	function update_temp_password($data, $email, $user_name) {
		$this->db->where('email', $email);
		$this->db->where('username', $user_name);
		$this->db->update('guest_info', $data);

		//echo $this->db->last_query();
	}

	function get_profile_facebook($email) {
		$result = new stdClass;				
		$this->db->select('*');
		$this->db->from('guest_info');
		$this->db->where('is_active',1);
		$this->db->where('type','facebook');
		$this->db->group_start()
         ->where('email', $email)
         ->group_end();
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

	function get_profile_by_username_password($email,$pass_md5) {		
		$result = new stdClass;				
		$this->db->select('*');
		$this->db->from('guest_info');
		$this->db->where('is_active',1);
		// $this->db->where('username',$email);
		$this->db->group_start()
         ->where('username', $email)
         ->or_where('email', $email)
         ->group_end();
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
	
	function get_guest_by_name_tax_id($firstname,$lastname, $tax_id) {
	    $result = new stdClass;
	    $this->db->select('*');
	    $this->db->from('guest_info');
	    $this->db->where('is_active',1);
	    $this->db->where('firstname',$firstname);
	    $this->db->where('lastname',$lastname);
	    $this->db->where('tax_id',$tax_id);
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
		$this->db->select('guest_info.*,c.credit_term');
		$this->db->from('guest_info');
		$this->db->join('credit as c' , 'c.id_credit = guest_info.id_credit' , 'LEFT' );
		$this->db->where('guest_info.is_active',1);
		$this->db->where('guest_info.id_guest',$id_guest);
		
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$r = $query->result();
			$result = $r[0];
		}else{			
			$result = false;
		}
		return $result;
	}
	
	function if_email_exist ($email) {
		$result = 0;
		$this->db->where('email', $email);
		$query = $this->db->get('guest_info');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = 1;
		}
		return $result;
	} 
	
	function get_discount_by_user ($id_guest_info) {
		$result = new stdClass();
		$this->db->select('*');
		$this->db->from('guest_info g');
		$this->db->join('discount d', 'g.id_discount = d.id_discount', 'LEFT');
		$this->db->where('g.id_guest', $id_guest_info);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
	
}