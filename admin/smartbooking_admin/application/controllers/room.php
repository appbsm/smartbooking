<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Room extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
		$this->load->library('../controllers/home');
    }

	public function room_management()
	{
		if (!has_permission('room_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->select('rt.*, p.project_name_en, p.project_name_th');
		$this->db->from('room_type rt');
		$this->db->join('project_info p', 'rt.id_project_info = p.id_project_info');
		$room_type = $this->db->get()->result_array();
		foreach ($room_type as $i => $r) {
			// Main Photo
			$this->db->where('id_room_type', $r['id_room_type']);
			$this->db->where('display_sequence', 1);
			$main_photo = $this->db->get('room_type_photo')->result_array();

			if (count($main_photo) > 0) {
				
				$room_type[$i]['image'] = getImageUrl($main_photo[0]['room_photo_url']);
			} else {
				$room_type[$i]['image'] = site_url() .'asset/image/upload.jpg';
			}

			// Rooms Count
			$this->db->where('id_room_type', $r['id_room_type']);
			$room_type[$i]['rooms_count'] = count($this->db->get('room_details')->result_array());
		}
		$this->_data['room_type'] = $room_type;

		$this->render();
	}

	public function edit_room_type($id = '')
	{
		if (!has_permission('room_management', 'view')) {
			header("Location: ". home_url());
		}

		///// Room Type Info
		$this->db->where('id_room_type', $id);
		$room_type = $this->db->get('room_type')->result_array();

		if (count($room_type) > 0) {
			$this->_data['room_type_info'] = $room_type[0];

			///// Project Photo
			$this->db->where('id_room_type', $id);
			$room_type_photo = $this->db->get('room_type_photo')->result_array();

			// blank row
			$fields = $this->db->list_fields('room_type_photo');
			$tmp = array();
			foreach ($fields as $field) {
				if ($field != 'date_created') {
					$tmp[$field] = '';
				}
			}
			$tmp['id_room_type'] = $id;
			$tmp['id_room_type_photo'] = '';
			$tmp['display_sequence'] = '';
			$tmp['room_photo_url'] = site_url() .'asset/image/upload.jpg';
			$this->_data['room_type_photo_blank_row'] = $tmp;

			foreach ($room_type_photo as $i => $p) {
				$room_type_photo[$i]['room_photo_url'] = getImageUrl($p['room_photo_url']);
			}

			// check if main photo exist
			$this->db->where('id_room_type', $id);
			$this->db->where('display_sequence', 1);
			$main_photo = $this->db->get('room_type_photo')->result_array();
			if (count($main_photo) == 0) {
				$tmp['display_sequence'] = 1;
				array_unshift($room_type_photo, $tmp);
			}

			$this->_data['room_type_photo'] = $room_type_photo;

			///// Amenities Select
			$this->db->where('id_room_type', $id);
			$select_facility = $this->db->get('room_type_amenities')->result_array();
			$tmp = array();
			foreach ($select_facility as $f) {
				$tmp[$f['id_amenities']] = $f;
			}
			$this->_data['select_amenity'] = $tmp;

			///// Room Detail
			$this->db->where('id_room_type', $id);
			$this->_data['room_details'] = $this->db->get('room_details')->result_array();

			// blank row
			$fields = $this->db->list_fields('room_details');
			$tmp = array();
			foreach ($fields as $field) {
				if (!in_array($field, array('date_created', 'id_room_details', 'room_type_name_en', 'room_type_name_th'))) {
					$tmp[$field] = '';
				}
			}

			$tmp['id_room_type'] = $id;
			$this->_data['room_detail_blank_row'] = $tmp;
		} else {
			$fields = $this->db->list_fields('room_type');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$this->_data['room_type_info'] = $tmp;
		}

		///// Seasonal Price
		$this->db->where('id_room_type', $id);
		$seasonal_price = $this->db->get('seasonal_price')->result_array();
		$fields = $this->db->list_fields('seasonal_price');
		$tmp = array();
		foreach ($fields as $field) {
			if ($field != 'date_created') {
				$tmp[$field] = '';
			}
		}
		$tmp['id_seasonal_price'] = '0';
		array_unshift($seasonal_price, $tmp);
		$this->_data['seasonal_price'] = $seasonal_price;

		///// Amenities
		$amenity = $this->db->get('amenities')->result_array();
		array_unshift($amenity, array(
			'id_amenities' => '0',
			'icon' => 'asset/image/upload.jpg',
			'desc_en' => '',
			'desc_th' => ''
		));

		foreach ($amenity as $i => $a) {
			$amenity[$i]['icon'] = getImageUrl($a['icon']);
		}
		$this->_data['amenity'] = $amenity;

		///// Project Info
		$project_info = $this->db->get('project_info')->result_array();
		$this->_data['project_info'] = $project_info;

		//
		$this->_data['step'] = empty($_GET['step']) ? 1 : $_GET['step'];
		$this->render();
	}

	public function save_room_type()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_room_type = $_POST['id_room_type'];
		unset($_POST['id_room_type']);

		if (empty($id_room_type)) {
			$_POST['date_created'] = date('Y-m-d H:i:s');
			$this->db->insert('room_type', $_POST);
			$ret['message'] = $this->db->insert_id();
		} else {
			$this->db->where('id_room_type', $id_room_type);
			$this->db->update('room_type', $_POST);

			$this->db->where('id_room_type', $id_room_type);
			$this->db->update('room_details', array(
				'room_type_name_en' => $_POST['room_type_name_en'],
				'room_type_name_th' => $_POST['room_type_name_th']
			));

			$ret['message'] = $id_room_type;
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_room_type()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		// check empty room type id
		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Room Type ID';
			echo json_encode($ret);
			return;
		}

		// check photo
		$this->db->where('id_room_type', $_POST['id']);
		$this->db->where('display_sequence >', 1);
		$res = $this->db->get('room_type_photo')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete room_type, please delete all sub_photos first.';
			echo json_encode($ret);
			return;
		}

		// check amenity select
		$this->db->where('id_room_type', $_POST['id']);
		$res = $this->db->get('room_type_amenities')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete room_type, please delete all amenities selection first.';
			echo json_encode($ret);
			return;
		}

		// check room detail
		$this->db->where('id_room_type', $_POST['id']);
		$res = $this->db->get('room_details')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete room_type, please delete all room_details first.';
			echo json_encode($ret);
			return;
		}

		// check seasonal price
		$this->db->where('id_room_type', $_POST['id']);
		$res = $this->db->get('seasonal_price')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete room_type, please delete all seasonal_price first.';
			echo json_encode($ret);
			return;
		}

		///// => Delete Room Type
		$this->db->where('id_room_type', $_POST['id']);
		$this->db->where('display_sequence', 1);
		$this->db->delete('room_type_photo');
		$this->db->where('id_room_type', $_POST['id']);
		$this->db->delete('room_type');

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'room_type_photo', $_POST['id']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function save_room_type_photo()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('id_room_type', $_POST['id_room_type']);
		$this->db->delete('room_type_photo');

		foreach ($_POST['room_type_photo'] as $i => $p) {
			unset($p['id_room_type_photo']);
			$p['date_created'] = date('Y-m-d H:i:s');
			$p['room_photo_url'] = _upload('room_type_photo', $p['room_photo_url'], $_POST['id_room_type']);
			$this->db->insert('room_type_photo', $p);
		}

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'room_type_photo', $_POST['id_room_type']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function save_seasonal_price()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_seasonal_price = $_POST['id_seasonal_price'];
		unset($_POST['id_seasonal_price']);

		if (empty($id_seasonal_price)) {
			$_POST['date_created'] = date('Y-m-d H:i:s');
			$this->db->insert('seasonal_price', $_POST);
		} else {
			$this->db->where('id_seasonal_price', $id_seasonal_price);
			$this->db->update('seasonal_price', $_POST);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_seasonal_price()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Seasonal Price ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_seasonal_price', $_POST['id']);
			$this->db->delete('seasonal_price');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function save_amenity()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_amenities = $_POST['id_amenities'];
		unset($_POST['id_amenities']);
		$icon = $_POST['icon'];
		unset($_POST['icon']);

		if (empty($id_amenities)) {
			$_POST['date_created'] = date('Y-m-d H:i:s');
			$this->db->insert('amenities', $_POST);
			$id_amenities = $this->db->insert_id();
		} else {
			$this->db->where('id_amenities', $id_amenities);
			$this->db->update('amenities', $_POST);
		}

		$_POST['icon'] = _upload('amenity_icon', $icon, $id_amenities);
		$this->db->where('id_amenities', $id_amenities);
		$this->db->update('amenities', array('icon' => $_POST['icon']));

		$this->db->where('id_amenities', $id_amenities);
		$this->db->update('room_type_amenities', array(
			'icon' => $_POST['icon'],
			'desc_en' => $_POST['desc_en'],
			'desc_th' => $_POST['desc_th']
		));

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'amenity_icon', $id_amenities);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function select_amenity()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('id_room_type', $_POST['id_room_type']);
		$this->db->where('id_amenities', $_POST['id_amenities']);
		$room_type_amenities = $this->db->get('room_type_amenities')->result_array();

		if (count($room_type_amenities) > 0) {
			$this->db->where('id_room_type', $_POST['id_room_type']);
			$this->db->where('id_amenities', $_POST['id_amenities']);
			$this->db->delete('room_type_amenities');
		} else {
			$this->db->where('id_amenities', $_POST['id_amenities']);
			$amenities = $this->db->get('amenities')->result_array();
			$amenity = $amenities[0];

			$_POST['icon'] = $amenity['icon'];
			$_POST['desc_en'] = $amenity['desc_en'];
			$_POST['desc_th'] = $amenity['desc_th'];
			$_POST['date_created'] = date('Y-m-d H:i:s');

			$this->db->insert('room_type_amenities', $_POST);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_amenity()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Amenity ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_amenities', $_POST['id']);
			$room_type_amenities = $this->db->get('room_type_amenities')->result_array();

			if (count($room_type_amenities) > 0) {
				$ret['message'] = 'Can not delete, there are room_types using this amenity.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_amenities', $_POST['id']);
			$this->db->delete('amenities');
		}

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'amenity_icon', $_POST['id']);

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