<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
		$this->load->library('../controllers/home');
    }

	public function project_management()
	{
		if (!has_permission('project_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->select('*')
				 ->select('project_info.email AS project_info_email')
				 ->select('project_info.phone_number AS project_info_phone_number')
				 ->from('project_info')
				 ->join('business_info', 'project_info.id_business_info = business_info.id_business_info');

		$project_info = $this->db->get()->result_array();
		$this->_data['project_info'] = $project_info;

		$this->render();
	}

	public function edit_project($id = '')
	{
		if (!has_permission('project_management', 'view')) {
			header("Location: ". home_url());
		}

		///// Project Info
		$this->db->where('id_project_info', $id);
		$project_info = $this->db->get('project_info')->result_array();

		if (count($project_info) > 0) {
			$this->_data['project_info'] = $project_info[0];

			///// Project Photo
			$this->db->where('id_project_info', $id);
			$project_photos = $this->db->get('project_photos')->result_array();

			// blank row
			$fields = $this->db->list_fields('project_photos');
			$tmp = array();
			foreach ($fields as $field) {
				if ($field != 'date_created') {
					$tmp[$field] = '';
				}
			}
			$tmp['id_project_info'] = $id;
			$tmp['id_project_photo'] = '';
			$tmp['display_sequence'] = '';
			$tmp['project_photo_url'] = site_url() .'asset/image/upload.jpg';
			$this->_data['project_photo_blank_row'] = $tmp;

			foreach ($project_photos as $i => $p) {
				$project_photos[$i]['project_photo_url'] = getImageUrl($p['project_photo_url']);
			}

			// check if main photo exist
			$this->db->where('id_project_info', $id);
			$this->db->where('display_sequence', 1);
			$main_photo = $this->db->get('project_photos')->result_array();
			if (count($main_photo) == 0) {
				$tmp['display_sequence'] = 1;
				array_unshift($project_photos, $tmp);
			}

			$this->_data['project_photos'] = $project_photos;

			///// Project Highlights
			$this->db->where('id_project_info', $id);
			$project_highlights = $this->db->get('project_highlights')->result_array();

			foreach ($project_highlights as $i => $h) {
				$project_highlights[$i]['icon'] = getImageUrl($h['icon']);
			}
			$this->_data['project_highlights'] = $project_highlights;

			// blank row
			$fields = $this->db->list_fields('project_highlights');
			$tmp = array();
			foreach ($fields as $field) {
				if ($field != 'date_created') {
					$tmp[$field] = '';
				}
			}
			$tmp['id_project_info'] = $id;
			$tmp['id_highlights'] = '';
			$tmp['icon'] = site_url() .'asset/image/upload.jpg';
			$this->_data['project_highlights_blank_row'] = $tmp;

			///// Point of Interest
			$this->db->where('id_project_info', $id);
			$this->_data['point_of_interest'] = $this->db->get('point_of_interest')->result_array();

			// blank row
			$fields = $this->db->list_fields('point_of_interest');
			$tmp = array();
			foreach ($fields as $field) {
				if (!in_array($field, array('date_created', 'id_project_location'))) {
					$tmp[$field] = '';
				}
			}
			$tmp['id_project_info'] = $id;
			$this->_data['point_of_interest_blank_row'] = $tmp;

			///// Facilities Select
			$this->db->where('id_project_info', $id);
			$select_facility = $this->db->get('project_facility')->result_array();
			$tmp = array();
			foreach ($select_facility as $f) {
				$tmp[$f['id_property_facility']] = $f;
			}
			$this->_data['select_facility'] = $tmp;

			///// Policy
			$this->db->where('id_project_info', $id);
			$this->_data['policy'] = $this->db->get('project_policy')->result_array();

			// blank row
			$fields = $this->db->list_fields('project_policy');
			$tmp = array();
			foreach ($fields as $field) {
				if (!in_array($field, array('date_created', 'id_project_policy'))) {
					$tmp[$field] = '';
				}
			}

			$tmp['id_project_info'] = $id;
			$this->_data['policy_blank_row'] = $tmp;

		} else {
			$fields = $this->db->list_fields('project_info');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$this->_data['project_info'] = $tmp;
		}

		///// Business Info
		$business_info = $this->db->get('business_info')->result_array();
		array_unshift($business_info, array(
			'id_business_info' => '0',
			'business_name_en' => '',
			'business_name_th' => '',
			'business_address_en' => '',
			'business_address_th' => '',
			'business_tax_id' => '',
			'phone_number' => '',
			'email' => '',
			'logo' => 'asset/image/upload.jpg'
		));

		foreach ($business_info as $i => $b) {
			$business_info[$i]['logo'] = getImageUrl($b['logo']);
		}
		$this->_data['business_info'] = $business_info;

		///// Project Facility
		$project_facility = $this->db->get('property_facility')->result_array();
		array_unshift($project_facility, array(
			'id_property_facility' => '0',
			'icon' => 'asset/image/upload.jpg',
			'short_desc_en' => '',
			'short_desc_th' => '',
			'long_desc_en' => '',
			'long_desc_th' => ''
		));

		foreach ($project_facility as $i => $f) {
			$project_facility[$i]['icon'] = getImageUrl($f['icon']);
		}
		$this->_data['project_facility'] = $project_facility;

		//
		$this->_data['step'] = empty($_GET['step']) ? 1 : $_GET['step'];
		$this->render();
	}

	public function save_project()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_project_info = $_POST['id_project_info'];
		unset($_POST['id_project_info']);

		$_POST['whole_address_en'] = $_POST['address_1_en'] .' '. $_POST['subdistrict_en'] .' '. $_POST['district_en'] .' '. $_POST['province_en'] .' '. $_POST['postcode'] .' '. $_POST['country_en'];
		$_POST['whole_address_th'] = $_POST['address_1_th'] .' '. $_POST['subdistrict_th'] .' '. $_POST['district_th'] .' '. $_POST['province_th'] .' '. $_POST['postcode'] .' '. $_POST['country_th'];

		if (empty($id_project_info)) {
			$_POST['date_created'] = date('Y-m-d H:i:s');
			$this->db->insert('project_info', $_POST);
			$ret['message'] = $this->db->insert_id();
		} else {
			$this->db->where('id_project_info', $id_project_info);
			$this->db->update('project_info', $_POST);
			$ret['message'] = $id_project_info;
		}

		$ret['result'] = 'true';
		echo json_encode($ret);	
	}

	public function save_project_photo()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('id_project_info', $_POST['id_project_info']);
		$this->db->delete('project_photos');

		foreach ($_POST['project_photos'] as $i => $p) {
			unset($p['id_project_photo']);
			$p['date_created'] = date('Y-m-d H:i:s');
			$p['project_photo_url'] = _upload('project_photo', $p['project_photo_url'], $_POST['id_project_info']);
			$this->db->insert('project_photos', $p);
		}

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'project_photo', $_POST['id_project_info']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_project()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		// check empty project id
		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Project ID';
			echo json_encode($ret);
			return;
		}
		
		// check photo
		$this->db->where('id_project_info', $_POST['id']);
		$this->db->where('display_sequence >', 1);
		$res = $this->db->get('project_photos')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete project, please delete all sub_photos first.';
			echo json_encode($ret);
			return;
		}

		// check point of interest
		$this->db->where('id_project_info', $_POST['id']);
		$res = $this->db->get('point_of_interest')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete project, please delete all points_of_interest first.';
			echo json_encode($ret);
			return;
		}

		// check facility select
		$this->db->where('id_project_info', $_POST['id']);
		$res = $this->db->get('project_facility')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete project, please delete all facilities selection first.';
			echo json_encode($ret);
			return;
		}

		// check highlight
		$this->db->where('id_project_info', $_POST['id']);
		$res = $this->db->get('project_highlights')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete project, please delete all highlights first.';
			echo json_encode($ret);
			return;
		}

		// check policy
		$this->db->where('id_project_info', $_POST['id']);
		$res = $this->db->get('project_policy')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete project, please delete all policies first.';
			echo json_encode($ret);
			return;
		}

		// check room type
		$this->db->where('id_project_info', $_POST['id']);
		$res = $this->db->get('room_type')->result_array();
		if (count($res) > 0) {
			$ret['message'] = 'Can not delete project, please delete all room_types first.';
			echo json_encode($ret);
			return;
		}

		///// => Delete Project
		$this->db->where('id_project_info', $_POST['id']);
		$this->db->where('display_sequence', 1);
		$this->db->delete('project_photos');
		$this->db->where('id_project_info', $_POST['id']);
		$this->db->delete('project_info');

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'project_photo', $_POST['id']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function save_project_highlights()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('id_project_info', $_POST['id_project_info']);
		$this->db->delete('project_highlights');

		if (!empty($_POST['project_highlights'])) {
			foreach ($_POST['project_highlights'] as $i => $h) {
				unset($h['id_highlights']);
				$h['date_created'] = date('Y-m-d H:i:s');
				$h['icon'] = _upload('project_highlight', $h['icon'], $_POST['id_project_info']);
				$this->db->insert('project_highlights', $h);
			}
		}

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'project_highlight', $_POST['id_project_info']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function save_business()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_business_info = $_POST['id_business_info'];
		unset($_POST['id_business_info']);
		$logo = $_POST['logo'];
		unset($_POST['logo']);

		if (empty($id_business_info)) {
			$this->db->insert('business_info', $_POST);
			$id_business_info = $this->db->insert_id();
		} else {
			$this->db->where('id_business_info', $id_business_info);
			$this->db->update('business_info', $_POST);
		}

		$_POST['logo'] = _upload('business_logo', $logo, $id_business_info);
		$this->db->where('id_business_info', $id_business_info);
		$this->db->update('business_info', array('logo' => $_POST['logo']));

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'business_logo', $id_business_info);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_business()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Business Info ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_business_info', $_POST['id']);
			$project = $this->db->get('project_info')->result_array();

			if (count($project) > 0) {
				$ret['message'] = 'Can not delete, there are projects using this business.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_business_info', $_POST['id']);
			$this->db->delete('business_info');
		}

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'business_logo', $_POST['id']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function save_facility()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_property_facility = $_POST['id_property_facility'];
		unset($_POST['id_property_facility']);
		$icon = $_POST['icon'];
		unset($_POST['icon']);

		if (empty($id_property_facility)) {
			$_POST['date_created'] = date('Y-m-d H:i:s');
			$this->db->insert('property_facility', $_POST);
			$id_property_facility = $this->db->insert_id();
		} else {
			$this->db->where('id_property_facility', $id_property_facility);
			$this->db->update('property_facility', $_POST);
		}

		$_POST['icon'] = _upload('facility_icon', $icon, $id_property_facility);
		$this->db->where('id_property_facility', $id_property_facility);
		$this->db->update('property_facility', array('icon' => $_POST['icon']));

		$this->db->where('id_property_facility', $id_property_facility);
		$this->db->update('project_facility', array(
			'icon' => $_POST['icon'],
			'long_desc_en' => $_POST['long_desc_en'],
			'long_desc_th' => $_POST['long_desc_th']
		));

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'facility_icon', $id_property_facility);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function select_facility()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('id_project_info', $_POST['id_project_info']);
		$this->db->where('id_property_facility', $_POST['id_property_facility']);
		$project_facility = $this->db->get('project_facility')->result_array();

		if (count($project_facility) > 0) {
			$this->db->where('id_project_info', $_POST['id_project_info']);
			$this->db->where('id_property_facility', $_POST['id_property_facility']);
			$this->db->delete('project_facility');
		} else {
			$this->db->where('id_property_facility', $_POST['id_property_facility']);
			$facilities = $this->db->get('property_facility')->result_array();
			$facility = $facilities[0];

			$_POST['icon'] = $facility['icon'];
			$_POST['long_desc_en'] = $facility['long_desc_en'];
			$_POST['long_desc_th'] = $facility['long_desc_th'];
			$_POST['date_created'] = date('Y-m-d H:i:s');

			$this->db->insert('project_facility', $_POST);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_facility()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Facility ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_property_facility', $_POST['id']);
			$project = $this->db->get('project_facility')->result_array();

			if (count($project) > 0) {
				$ret['message'] = 'Can not delete, there are projects using this facility.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_property_facility', $_POST['id']);
			$this->db->delete('property_facility');
		}

		// Check Unlink Deleted Image
		$this->home->check_deleted_image(false, 'facility_icon', $_POST['id']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	public function save_point_of_interest()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');
		
		if (empty($_POST['point_of_interest']['id_project_location'])) {
			$_POST['point_of_interest']['date_created'] = date('Y-m-d H:i:s');
			$this->db->insert('point_of_interest', $_POST['point_of_interest']);
		} else {
			$this->db->where('id_project_location', $_POST['point_of_interest']['id_project_location']);
			unset($_POST['point_of_interest']['id_project_location']);
			$this->db->update('point_of_interest', $_POST['point_of_interest']);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_point_of_interest()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Point of Interest ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_project_location', $_POST['id']);
			$this->db->delete('point_of_interest');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function save_policy()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['policy']['id_project_policy'])) {
			$_POST['policy']['date_created'] = date('Y-m-d H:i:s');
			$this->db->insert('project_policy', $_POST['policy']);
		} else {
			$this->db->where('id_project_policy', $_POST['policy']['id_project_policy']);
			unset($_POST['policy']['id_project_policy']);
			$this->db->update('project_policy', $_POST['policy']);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_policy()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Policy ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_project_policy', $_POST['id']);
			$this->db->delete('project_policy');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}