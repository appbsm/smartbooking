<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Room_details extends MY_Model {
    public $table = 'room_details';

    public function getRooms() {
        $this->db->select('*');
		$this->db->from('room_details');
		$this->db->join('room_type', 'room_details.id_room_type = room_type.id_room_type');
        $this->db->where('room_details.active = 1');
        $this->db->where('room_type.active = 1');
		$this->db->order_by('room_type.id_project_info, room_type.id_room_type, room_details.room_number');
		$rooms = $this->db->get()->result_array();

        return $rooms;
    }
}