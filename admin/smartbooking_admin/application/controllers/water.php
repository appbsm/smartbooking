<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Water extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
		$this->load->library('../controllers/home');
    }

	public function water_management()
	{
		if (!has_permission('water_management', 'view')) {
			header("Location: ". home_url());
		}
		$this->db->select('wl.*, p.project_name_en, p.project_name_th,r.room_type_name_en,r.room_type_name_th,,rd.room_name_en,rd.room_name_th');
		$this->db->from('water_list wl');
		$this->db->join('project_info p', 'wl.id_project_info = p.id_project_info','left');
		$this->db->join('room_type r', 'wl.id_room_type = r.id_room_type','left');
		$this->db->join('room_details rd', 'wl.id_room_details = rd.id_room_details','left');
		$water_list = $this->db->get()->result_array();
		
		$run_id=1;
		foreach ($water_list as $i => $r) {
			$water_list[$i]['run_id'] = $run_id;
			$run_id++;
		}

		$this->_data['water_list'] = $water_list;
		$this->render();
	}

	public function edit_water($id = '')
	{
		if (!has_permission('water_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->where('id',$id);
		$water_info = $this->db->get('water_list')->result_array();
		
		if (count($water_info) > 0) {
			$this->_data['water_info'] = $water_info[0];
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$this->db->where('id_project_info',$water_info[0]['id_project_info']);
			$room_type = $this->db->get('room_type')->result_array();
			$this->_data['room_type'] = $room_type;

			$this->db->where('id_room_type',$water_info[0]['id_room_type']);
			$room_type = $this->db->get('room_details')->result_array();
			$this->_data['room_details'] = $room_type;

		}else{
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$fields = $this->db->list_fields('water_list');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$this->_data['water_info'] = $tmp;
		}

		$this->render();
	}

	public function save_water()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_water = $_POST['id'];
		unset($_POST['id']);

		if (empty($id_water)) {

			//// เช็คค่าล่าสุดและใส่ MTW+1
			$this->db->select('meter_id');
			$this->db->from('water_list');
			$this->db->order_by('meter_id', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get();
			$water_info = $query->row_array();

			if (!empty($water_info)) {
				$last_meter_id = $water_info['meter_id'];
			    $parts = explode('-', $last_meter_id);
			    $number = intval(end($parts));
			    
			    $new_number = str_pad($number + 1, 5, '0', STR_PAD_LEFT);
			    $meter_id_set = 'MTW-' . $new_number;
			}else{
				$meter_id_set = "MTW-00001";
			}
			$_POST['meter_id'] = $meter_id_set;

			///////////////////////////////

			$_POST['create_date'] = date('Y-m-d H:i:s');
			$this->db->insert('water_list',$_POST);
			$ret['id_water'] = $this->db->insert_id();
		}else{
			$ret['id_water'] = $id_water;
			$_POST['update_date'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id_water);
			$this->db->update('water_list',$_POST);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function get_water_by_project($project_id) {

	    $this->db->where('id_project_info',$project_id);
	    $result = $this->db->get('room_type')->result_array();
	    echo json_encode($result);
	}

	public function get_water_by_room_details($room_id) {
	    $this->db->where('id_room_type',$room_id);
	    $result = $this->db->get('room_details')->result_array();
	    echo json_encode($result);
	}

	public function delete_water()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		// check empty room type id
		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Water ID';
			echo json_encode($ret);
			return;
		}

		$this->db->where('id', $_POST['id']);
		$this->db->delete('water_list');

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_water_detail()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Room Detail ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_room_details', $_POST['id']);
			$booking_room = $this->db->get('booking_room')->result_array();

			if (count($booking_room) > 0) {
				$ret['message'] = 'Can not delete, there are bookings of this room.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_room_details', $_POST['id']);
			$this->db->delete('room_details');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}