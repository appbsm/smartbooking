<?php
class M_package extends CI_Model{
	
 	
	function get_package_items_by_id ($id_package) {
		$result = array();
		$this->db->select('*');
		$this->db->from('package p');
		$this->db->join('package_item pi', 'pi.id_package = p.id_package', 'LEFT');
		$this->db->where('p.id_package', $id_package);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_package_by_id ($id_package) {
		$result = new stdClass();
		$this->db->select('*');
		$this->db->from('package p');
		$this->db->where('p.id_package', $id_package);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
	
	function get_all_packages() {
		$result = array();
		$this->db->select('*,pi.project_name_en,pi.project_name_th');
		$this->db->from('package p');
		$this->db->join('project_info pi', 'pi.id_project_info = p.id_project_info', 'LEFT');
		$this->db->where('is_active', 1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_available_package ($check_in_date, $packages = '') {
		//$result = array();
		$applic_package = $this->get_applicable_package($check_in_date, $packages);
		//print_r($applic_package);
		foreach ($applic_package as $key => $pk) {
			// 1. get rooms in package
			$rooms = $this->get_package_items_by_id($pk->id_package);
			// 2. check if room is not in booking, if in booking, remove package
			foreach ($rooms as $room) {
				$room_in_booking = $this->check_room_in_booking ($room->id_room_type, $check_in_date);
				if ($room_in_booking == 1) {
					unset($applic_package[$key]);
					break;
				}
			}
		}
		//print_r($applic_package);
		return $applic_package;
	}
	
	function check_room_in_booking ($id_room_type, $check_in_date) {
		$result = 0;
		$select = "select * from booking_room br "
				. "left join booking b on b.booking_number = br.booking_number "
				. "where b.check_in_date <= '".$check_in_date."' "
				. "and b.check_out_date > '".$check_in_date."' "
				. "and id_room_type = ".$id_room_type
				;
		//echo $select;
		$query = $this->db->query($select);
		if ($query->num_rows() > 0) {
			$result = 1;
		}
		return $result;
	}
	
	function get_applicable_package ($check_in_date, $packages) {
		$result = array();
		$select = "select distinct p.id_package from package p "
				. "left join package_item pi on pi.id_package = p.id_package "
				. "where p.start_date <= '".$check_in_date."' and p.end_date >= '".$check_in_date."' ";
		if ($packages != '') {
			$select .= "and p.id_package IN (".$packages.")";
		}
		$query = $this->db->query($select);
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function get_package_room_types ($id_package) {
		$result = array();
		$this->db->select('*');
		$this->db->from('package_item');
		$this->db->where('id_package' , $id_package);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
		}
		return $result;
	}
	
	function is_package_available ($id_package, $check_in_date, $check_out_date) {		
		$room_types = $this->get_package_room_types ($id_package);
		$is_available = 1;
		foreach ($room_types as $rt) {
			//print_r($rt);
			$available_room = $this->m_room_type->get_room_by_type ($rt->id_room_type, $check_in_date, $check_out_date);
			if (count($available_room) < $rt->qty) {
				$is_available = 0;
				break;
			}			
		}
		return $is_available;
	}
}