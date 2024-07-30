<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Electric extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
		$this->load->library('../controllers/home');
    }

	public function electric_management()
	{
		if (!has_permission('electric_management', 'view')) {
			header("Location: ". home_url());
		}

		///////////// electric
		$this->db->select('el.*, p.project_name_en, p.project_name_th,r.room_type_name_en,r.room_type_name_th,rd.room_name_en,rd.room_name_th');
		$this->db->from('electric_list el');
		$this->db->join('project_info p', 'el.id_project_info = p.id_project_info', 'left');
		$this->db->join('room_type r', 'el.id_room_type = r.id_room_type', 'left');
		$this->db->join('room_details rd', 'el.id_room_details = rd.id_room_details', 'left');
		$electric_list = $this->db->get()->result_array();
		
		$run_id=1;
		foreach ($electric_list as $i => $r) {
			$electric_list[$i]['run_id'] = $run_id;
			$run_id++;
		}

		$this->_data['electric_list'] = $electric_list;

		///////////// water
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

		///////////// internet
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


		///////////// service 
		$this->db->select('*');
		$this->db->from('service_charge');
		$this->db->where('type','service');
		$service_charge = $this->db->get()->result_array();
		$this->_data['service_charge_info'] = $service_charge;

		$this->db->select('*');
		$this->db->from('service_charge');
		$this->db->where('type','discount');
		$service_charge = $this->db->get()->result_array();
		$this->_data['service_charge_info2'] = $service_charge;

		$fields = $this->db->list_fields('service_charge');
		$tmp = array();
		foreach ($fields as $field) {
			$tmp[$field] = '';
		}
		// $this->_data['service_charge'] = $tmp;
		$this->_data['service_charge'] = $tmp;

		$this->render();
	}

	public function save_service(){
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$data = $this->input->post();

		if (empty($_POST['service_name_th'])) {
			echo json_encode(array('result' => 'false', 'message' => 'ข้อมูลไม่ครบถ้วน'));
        	return;
		}

		// if (empty($data['service_name_th'])) {
        // 	echo json_encode(array('result' => 'false', 'message' => 'ข้อมูลไม่ครบถ้วน'));
        // 	return;
    	// }

    	unset($_POST['id']);
    	unset($_POST['update_by']);
		unset($_POST['create_by']);
		unset($_POST['update_date']);
		$_POST['create_date'] = date('Y-m-d H:i:s');
		$_POST['id_project_info'] = 1;
		$this->db->insert('service_charge',$_POST);
		$ret['result'] = 'true';

		echo json_encode($ret);
	}

	public function edit_service($id = ''){
		if (!has_permission('electric_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->where('id',$id);
		$service_info = $this->db->get('service_charge')->result_array();
		$this->_data['service_info'] = $service_info;

		$room_type = $this->db->get('room_type')->result_array();
		$this->_data['room_type'] = $room_type;

		$fields = $this->db->list_fields('service_detail');
		$tmp = array();
		foreach ($fields as $field) {
			$tmp[$field] = '';
		}
		$this->_data['service_detail'] = $tmp;

		// $this->db->select('rt.*, sc.*, res.*');
		// $this->db->from('room_type rt');
		// $this->db->join('rela_service_to_room res', 'res.id_room = rt.id_room_type', 'left');
		// $this->db->join('service_charge sc', 'sc.id = res.id_service', 'left');
		// $this->db->where('sc.id',$id);
		// $this->db->or_where('sc.id IS NULL');  // เพื่อให้รวมข้อมูลที่ไม่มี `sc.id` ในเงื่อนไขนี้
		// $service_charge_info = $this->db->get();
		// $this->_data['service_charge_info'] = $service_charge_info;
		
		if (count($service_info) > 0) {
			// $this->db->select('*');
			// $this->db->from('service_charge');
			// $service_charge = $this->db->get()->result_array();
			// $this->_data['service_charge_info'] = $service_charge;

			
		}else{

		}

		$this->render();
	}

	public function save_electric()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_electric = $_POST['id'];
		unset($_POST['id']);

		if (empty($id_electric)) {

			// $electric_info = $this->db->get('electric_list')->result_array();
			$this->db->select('meter_id');
			$this->db->from('electric_list');
			$this->db->order_by('meter_id', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get();
			$electric_info = $query->row_array();

			if (!empty($electric_info)) {
				$last_meter_id = $electric_info['meter_id'];
			    $parts = explode('-', $last_meter_id);
			    $number = intval(end($parts));
			    
			    // บวกค่าเข้าไป 1
			    $new_number = str_pad($number + 1, 5, '0', STR_PAD_LEFT);
			    $meter_id_set = 'MTE-' . $new_number;
			}else{
				$meter_id_set = "MTE-00001";
			}
			$_POST['meter_id'] = $meter_id_set;

			$_POST['create_date'] = date('Y-m-d H:i:s');
			$this->db->insert('electric_list',$_POST);
			$ret['id_electric'] = $this->db->insert_id();
			$ret['result'] = 'true';
		}else{
			$ret['id_electric'] = $id_electric;
			$_POST['create_date'] = date('Y-m-d H:i:s');
			$_POST['update_date'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id_electric);
			$this->db->update('electric_list',$_POST);
			$ret['result'] = 'true';
		}
		echo json_encode($ret);
	}

	public function edit_electric($id = '')
	{
		if (!has_permission('electric_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->where('id',$id);
		$electric_info = $this->db->get('electric_list')->result_array();
		

		if (count($electric_info) > 0) {
			$this->_data['electric_info'] = $electric_info[0];
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$this->db->where('id_project_info',$electric_info[0]['id_project_info']);
			$room_type = $this->db->get('room_type')->result_array();
			$this->_data['room_type'] = $room_type;

			$this->db->where('id_room_type',$electric_info[0]['id_room_type']);
			$room_type = $this->db->get('room_details')->result_array();
			$this->_data['room_details'] = $room_type;

		}else{

			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			// $this->db->where('id_project_info',$project_info[0]['id_project_info']);
			// $room_type = $this->db->get('room_type')->result_array();
			// $this->_data['room_type'] = $room_type;

			$fields = $this->db->list_fields('electric_list');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$this->_data['electric_info'] = $tmp;
		}

		

		// $fields = $this->db->list_fields('room_type');
		// $tmp = array();
		// foreach ($fields as $field) {
		// 	$tmp[$field] = '';
		// }

		

		$this->render();
	}

	public function get_electric_by_project($project_id) {
	    $this->db->where('id_project_info',$project_id);
	    $result = $this->db->get('room_type')->result_array();
	    echo json_encode($result);
	}

	public function get_electric_by_room_details($room_id) {
	    $this->db->where('id_room_type',$room_id);
	    $result = $this->db->get('room_details')->result_array();
	    echo json_encode($result);
	}

	public function delete_electric()
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
		$this->db->delete('electric_list');

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function save_room_detail()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['room_detail']['id_room_details'])) {
			$this->db->where('id_room_type', $_POST['room_detail']['id_room_type']);
			$room_types = $this->db->get('room_type')->result_array();
			$room_type = $room_types[0];

			$_POST['room_detail']['room_type_name_en'] = $room_type['room_type_name_en'];
			$_POST['room_detail']['room_type_name_th'] = $room_type['room_type_name_th'];
			$_POST['room_detail']['date_created'] = date('Y-m-d H:i:s');

			$this->db->insert('room_details', $_POST['room_detail']);
		} else {
			$this->db->where('id_room_details', $_POST['room_detail']['id_room_details']);
			unset($_POST['room_detail']['id_room_details']);
			$this->db->update('room_details', $_POST['room_detail']);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_room_detail()
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