<?php
class M_cart extends CI_Model{
	
 	
	function insert_to_cart ($data) {
		$this->db->insert('cart_item', $data);
		echo $this->db->last_query();
	}
	
	function delete_to_cart ($id_cart_item) {
		$this->db->where('id_cart_item', $id_cart_item);
		$this->db->delete('cart_item');
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
}