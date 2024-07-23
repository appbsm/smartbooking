<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Packages extends MY_Controller {
	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
    }

	public function package_management()
	{
		if (!has_permission('package_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['package'] = $this->Package->getPackage();

		$this->render();
	}

	public function edit_package($id = '')
	{
		if (!has_permission('package_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['projects'] = $this->db->get('project_info')->result_array();

		///// Package Info
		$this->db->where('id_package', $id);
		$package = $this->db->get('package')->result_array();
		
		if (count($package) > 0) {
			$this->_data['package_info'] = $package[0];
			
		} else {
			$tmp = $this->Package->get_blank_row();
			$tmp['is_active'] = 1;
			$tmp['id_project_info'] = $this->_data['projects'][0]['id_project_info'];

			$this->_data['package_info'] = $tmp;
		}

		///// Rooms
		$rooms = array();
		$projects = $this->db->get('project_info')->result_array();

		foreach ($projects as $project) {
			$this->db->where('id_project_info', $project['id_project_info']);
			$this->db->order_by('display_sequence');
			$room_types = $this->db->get('room_type')->result_array();

			foreach ($room_types as $room_type) {
				$tmp = $room_type;
				$tmp['project_name_en'] = $project['project_name_en'];
				$tmp['project_name_th'] = $project['project_name_th'];
				$tmp['is_selected'] = 0;
				$rooms[$tmp['id_room_type']] = $tmp;
			}
		}

		// select room
		$this->db->where('id_package', $this->_data['package_info']['id_package']);
		$package_room = $this->db->get('package_item')->result_array();
		foreach ($package_room as $r) {
			$rooms[$r['id_room_type']]['is_selected'] = 1;
			$rooms[$r['id_room_type']]['qty'] = $r['qty'];
		}

		foreach ($rooms as $i => $r) {
			if (empty($r['active']) && empty($r['is_selected'])) {
				unset($rooms[$i]);
			}
		}
		$this->_data['rooms'] = $rooms;

		$this->render();
	}

	public function save_package()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$rooms = $_POST['rooms'];
		$package_info = $_POST['package_info'];
		$id_package = $package_info['id_package'];
		unset($package_info['id_package']);

		$now = date('Y-m-d H:i:s');
		if (empty($id_package)) {
			$user_data = $this->session->userdata('user_data');
			$package_info['staff_id'] = $user_data['id_user'];

			$this->db->insert('package', $package_info);
			$ret['message'] = $this->db->insert_id();
		} else {
			if (empty($package_info['staff_id'])) {
				$package_info['staff_id'] = null;
			}

			$this->db->where('id_package', $id_package);
			$this->db->update('package', $package_info);
			$ret['message'] = $id_package;
		}

		// Save Package Rooms
		$this->db->where('id_package', $ret['message']);
		$this->db->delete('package_item');

		foreach ($rooms as $room) {
			if (empty($room)) {
				continue;
			}

			$this->db->insert('package_item', array(
				'id_package' => $ret['message'],
				'id_room_type' => $room['id_room_type'],
				'qty' => $room['qty']
			));
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_package()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Package ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_package', $_POST['id']);
			$booking_room = $this->db->get('booking_room')->result_array();

			if (count($booking_room) > 0) {
				$ret['message'] = 'Can not delete, there are bookings using this package.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_package', $_POST['id']);
			$this->db->delete('package_item');

			$this->db->where('id_package', $_POST['id']);
			$this->db->delete('package');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	// Calculate Package Price
	public function _calculate_package_price($package = '', $rooms = array())
	{
		$ret = array('price' => 0);
		if (empty($package)) {
			return $ret;
		}

		// room price
		foreach ($rooms as $room) {
			if (isset($room['is_selected']) && $room['is_selected'] == 0) {
				continue;
			}

			$ret['price'] += $room['default_rate'];
		}

		return $ret;
	}

	public function calculate_package_price()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['package'])) {
			$ret['message'] = 'Empty Package Info';
			echo json_encode($ret);
			return;
		}

		$ret['message'] = $this->_calculate_package_price($_POST['package'], $_POST['rooms']);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}