<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Internet extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
		$this->load->library('../controllers/home');
    }

	public function internet_management()
	{
		if (!has_permission('internet_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->select('il.*, p.project_name_en, p.project_name_th,r.room_type_name_en,r.room_type_name_th,rd.room_name_en,rd.room_name_th');
		$this->db->from('internet_list il');
		$this->db->join('project_info p', 'il.id_project_info = p.id_project_info','left');
		$this->db->join('room_type r', 'il.id_room_type = r.id_room_type','left');
		$this->db->join('room_details rd', 'il.id_room_details = rd.id_room_details','left');
		$internet_list = $this->db->get()->result_array();
		
		$run_id=1;
		foreach ($internet_list as $i => $r) {
			$internet_list[$i]['run_id'] = $run_id;
			$run_id++;
		}

		$this->_data['internet_list'] = $internet_list;
		$this->render();
	}

	public function edit_internet($id = '')
	{
		if (!has_permission('internet_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->where('id',$id);
		$internet_info = $this->db->get('internet_list')->result_array();
		
		if (count($internet_info) > 0) {
			$this->_data['internet_info'] = $internet_info[0];
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$this->db->where('id_project_info',$internet_info[0]['id_project_info']);
			$room_type = $this->db->get('room_type')->result_array();
			$this->_data['room_type'] = $room_type;

			$this->db->where('id_room_type',$internet_info[0]['id_room_type']);
			$room_type = $this->db->get('room_details')->result_array();
			$this->_data['room_details'] = $room_type;

		}else{
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$fields = $this->db->list_fields('internet_list');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$this->_data['internet_info'] = $tmp;
		}

		$this->render();
	}

	public function save_internet()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_internet = $_POST['id'];
		unset($_POST['id']);

		if (empty($id_internet)) {

			//// เช็คค่าล่าสุดและใส่ MTI+1
			$this->db->select('meter_id');
			$this->db->from('internet_list');
			$this->db->order_by('meter_id', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get();
			$electric_info = $query->row_array();

			if (!empty($electric_info)) {
				$last_meter_id = $electric_info['meter_id'];
			    $parts = explode('-', $last_meter_id);
			    $number = intval(end($parts));
			    
			    $new_number = str_pad($number + 1, 5, '0', STR_PAD_LEFT);
			    $meter_id_set = 'MTI-' . $new_number;
			}else{
				$meter_id_set = "MTI-00001";
			}
			$_POST['meter_id'] = $meter_id_set;
			///////////////////////////////

			$_POST['create_date'] = date('Y-m-d H:i:s');
			$this->db->insert('internet_list',$_POST);
			$ret['id_internet'] = $this->db->insert_id();
		}else{
			$ret['id_internet'] = $id_internet;
			$_POST['update_date'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id_internet);
			$this->db->update('internet_list',$_POST);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function get_internet_by_project($project_id) {

	    $this->db->where('id_project_info',$project_id);
	    $result = $this->db->get('room_type')->result_array();
	    echo json_encode($result);
	}

	public function get_internet_by_room_details($room_id) {
	    $this->db->where('id_room_type',$room_id);
	    $result = $this->db->get('room_details')->result_array();
	    echo json_encode($result);
	}

	public function delete_internet()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		// check empty room type id
		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Electric ID';
			echo json_encode($ret);
			return;
		}

		$this->db->where('id', $_POST['id']);
		$this->db->delete('internet_list');

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

}