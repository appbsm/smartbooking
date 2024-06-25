<?php
class M_gallery extends CI_Model{
	
 	
	function get_gallery_categories () {
		$this->db->order_by('id_gallery_category', 'ASC');
		$query = $this->db->get('gallery_category');		
		
		return $query->result_array();
	}
	
	function get_gallery_photos ($id_gal_cat) {
		$this->db->select('gp.*, gc.*');
		$this->db->from('gallery_category gc');
		$this->db->join('gallery_photo gp', 'gp.id_gallery_category = gc.id_gallery_category', 'LEFT');
		$this->db->where('gc.id_gallery_category', $id_gal_cat);
		$this->db->order_by('gp.sequence_order', 'ASC');
		$query = $this->db->get();		
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function get_photos_by_id_gallery ($id_gal_cat) {
		$this->db->select('*');
		$this->db->from('gallery_photo');
		$this->db->where('id_gallery_category', $id_gal_cat);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	function get_photo_by_id ($id_photo_gallery) {
		$result = array();
		$this->db->select("*");
		$this->db->from('gallery_photo');
		$this->db->where('id_gallery_photo', $id_photo_gallery);
		$query = $this->db->get();	
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0];
		}
		return $result;
	}
	
	function get_gallery_by_id ($id_gallery_category) {
		$result = array();
		$this->db->select("*");
		$this->db->from('gallery_category');
		$this->db->where('id_gallery_category', $id_gallery_category);
		$query = $this->db->get();	
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0];
		}
		return $result;
	}
	
	function get_count_photos ($id_gal_cat) {
		$count = 0;
		$this->db->select('COUNT(*) as count');
		$this->db->from('gallery_photo');
		$this->db->where('id_gallery_category', $id_gal_cat);
		$query = $this->db->get();	
		if ($query->num_rows() > 0) {
			$res = $query->result();
			$count = $res[0]->count;
		}
		return $count;
	}
}