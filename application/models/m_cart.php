<?php
class M_cart extends CI_Model{
	
 	
	function insert_to_cart ($data, $id_room_type, $id_guest) {
		
		//echo $this->db->last_query();
		$result = array();
		$select = "SELECT * from cart_item "
			. "where id_room_type = ".$id_room_type
			. " and id_guest_info = ".$id_guest;
		$query = $this->db->query($select);
		//echo $this->db->last_query();
	 	if ($query->num_rows() > 0) {
	 		$result = $query->result();	 
	 		foreach ($result as $r) {
	 			$new_qty = $r->quantity + 1;
	 			$data_new = array('quantity' => $new_qty);
	 			$this->db->where('id_room_type', $id_room_type);
	 			$this->db->where('id_guest_info', $id_guest);
	 			$this->db->update('cart_item', $data_new);
	 		}
	 	}
	 	else {
	 		$this->db->insert('cart_item', $data);
	 	}
	 	
	}
	
	function insert_to_cart_package ($data, $id_package, $id_guest) {
		
		//echo $this->db->last_query();
		$result = array();
		$select = "SELECT * from cart_item "
			. "where id_package = ".$id_package
			. " and id_guest_info = ".$id_guest;
		$query = $this->db->query($select);
		//echo $this->db->last_query();
	 	if ($query->num_rows() > 0) {
	 		$result = $query->result();	 
	 		foreach ($result as $r) {
	 			$new_qty = $r->quantity + 1;
	 			$data_new = array('quantity' => $new_qty);
	 			$this->db->where('id_package', $id_package);
	 			$this->db->where('id_guest_info', $id_guest);
	 			$this->db->update('cart_item', $data_new);
	 		}
	 	}
	 	else {
	 		$this->db->insert('cart_item', $data);
	 	}	 	
	}
	
	function delete_to_cart ($id_cart_item) {
		$this->db->where('id_cart_item', $id_cart_item);
		$this->db->delete('cart_item');
		
	}
	
	function delete_to_cart_by_room_type ($id_room_type, $id_guest, $quantity) {
		$result = array();
		$select = "SELECT * from cart_item "
			. "where id_room_type = ".$id_room_type
			. " and id_guest_info = ".$id_guest;
		$query = $this->db->query($select);
		//echo $this->db->last_query();
	 	if ($query->num_rows() > 0) {
	 		$result = $query->result();
	 		foreach ($result as $r) {
		 		$new_qty = $r->quantity - $quantity;
		 		if ($new_qty <= 0) {
		 			// delete
		 			$this->db->where('id_room_type', $id_room_type);
		 			$this->db->where('id_guest_info', $id_guest);
		 			$this->db->delete('cart_item');
		 		}
		 		else if ($quantity < $r->quantity) {
		 			// update	 			
		 			$data = array ('quantity' => $new_qty);
		 			$this->db->where('id_room_type', $id_room_type);
		 			$this->db->where('id_guest_info', $id_guest);
		 			$this->db->update('cart_item', $data);
		 		}
		 	}	
		 	//echo $this->db->last_query();
	 	}
	 	 	
	}
	
	function delete_to_cart_by_package ($id_package, $id_guest, $quantity) {
		$result = array();
		$select = "SELECT * from cart_item "
			. "where id_package = ".$id_package
			. " and id_guest_info = ".$id_guest;
		$query = $this->db->query($select);
		//echo $this->db->last_query();
	 	
		if ($query->num_rows() > 0) {
	 		$result = $query->result();
	 		foreach ($result as $r) {
		 		$new_qty = $r->quantity - $quantity;
		 		if ($new_qty <= 0) {
		 			// delete
		 			$this->db->where('id_package', $id_package);
		 			$this->db->where('id_guest_info', $id_guest);
		 			$this->db->delete('cart_item');
		 		}
		 		else if ($quantity < $r->quantity) {
		 			// update	 			
		 			$data = array ('quantity' => $new_qty);
		 			$this->db->where('id_package', $id_package);
		 			$this->db->where('id_guest_info', $id_guest);
		 			$this->db->update('cart_item', $data);
		 		}
		 	}	
		 	//echo $this->db->last_query();
	 	}
	 	 	
	}
	
	function get_cart_items ($id_guest_info) {
		$result = array();
		$this->db->where('id_guest_info', $id_guest_info);
		$this->db->order_by('date_created', 'DESC');
		$query = $this->db->get('cart_item');
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_cart_item_by_type ($id_guest_info, $id_room_type) {
		$result = new stdClass();
		$this->db->where('id_guest_info', $id_guest_info);
		$this->db->where('id_room_type', $id_room_type);
		$query = $this->db->get('cart_item');
		if ($query->num_rows() > 0) {
			$res = $query->result();
			$result = $res[0];
		}
		
		return $result;
	}
	
	function get_cart_item_by_package ($id_guest_info, $id_package) {
		$result = new stdClass();
		$this->db->where('id_guest_info', $id_guest_info);
		$this->db->where('id_package', $id_package);
		$query = $this->db->get('cart_item');
		if ($query->num_rows() > 0) {
			$res = $query->result();
			$result = $res[0];
		}
		
		return $result;
	}
	
	function get_cart_item_count ($id_guest_info) {
		$result = 0;
		$this->db->select('COUNT(*) as count');
		$this->db->from('cart_item');
		$this->db->where('id_guest_info', $id_guest_info);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0]->count;
		}
		return $result;
	}
	
	function update_cart ($data, $id_guest, $id_room_type) {		
	 	$this->db->where('id_room_type', $id_room_type);
	 	$this->db->where('id_guest_info', $id_guest);
	 	$this->db->update('cart_item', $data);
	 	//echo $this->db->last_query();
	}
	
	function update_cart_package ($data, $id_guest, $id_package) {		
	 	$this->db->where('id_package', $id_package);
	 	$this->db->where('id_guest_info', $id_guest);
	 	$this->db->update('cart_item', $data);
	 	//echo $this->db->last_query();
	}
}