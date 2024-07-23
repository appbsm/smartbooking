<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'home';
    }

	public function index()
	{
		$this->render();
	}

	public function change_language()
	{
		$lang = empty($_POST['lang']) ? 'EN' : $_POST['lang'];
		$this->session->set_userdata('lang', $lang);
	}

	public function check_deleted_image($debug = true, $folder = false, $id = false)
	{
		if ($debug) {
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		}

		$modules = array(
			array('folder_name' => 'amenity_icon',        'db_name' => 'amenities',          'col_name' => 'icon',              'id_name' => 'id_amenities'),
			array('folder_name' => 'business_logo',       'db_name' => 'business_info',      'col_name' => 'logo',              'id_name' => 'id_business_info'),
			array('folder_name' => 'facility_icon',       'db_name' => 'property_facility',  'col_name' => 'icon',              'id_name' => 'id_property_facility'),
			array('folder_name' => 'guest_photo',         'db_name' => 'guest_info',         'col_name' => 'photo_url',         'id_name' => 'id_guest'),
			array('folder_name' => 'project_highlight',   'db_name' => 'project_highlights', 'col_name' => 'icon',              'id_name' => 'id_project_info'),
			array('folder_name' => 'project_photo',       'db_name' => 'project_photos',     'col_name' => 'project_photo_url', 'id_name' => 'id_project_info'),
			array('folder_name' => 'room_type_photo',     'db_name' => 'room_type_photo',    'col_name' => 'room_photo_url',    'id_name' => 'id_room_type'),
			array('folder_name' => 'transfer_slip',       'db_name' => 'booking_payment',    'col_name' => 'transfer_slip',     'id_name' => 'id_booking'),
			array('folder_name' => 'order_transfer_slip', 'db_name' => 'order_payment',      'col_name' => 'transfer_slip',     'id_name' => 'id_order')
		);

		if (!empty($folder)) {
			$tmp = array();
			foreach ($modules as $module) {
				if ($module['folder_name'] == $folder) {
					$tmp[] = $module;
				}
			}
			$modules = $tmp;
		}

		$success = 0;
		foreach ($modules as $i => $module) {
			$path = 'upload/'. $module['folder_name'] .'/';
			$files = array_values(array_diff(scandir(server_path() . share_folder() . $path), array('.', '..')));

			if (!empty($id)) {
				$tmp = array();
				foreach ($files as $file) {
					if (startWith($file, $id .'_')) {
						$tmp[] = $file;
					}
				}
				$files = $tmp;
			}

			array_unshift($files, '');
			unset($files[0]);

			if ($debug) {
				echo '<hr>'. ($i + 1) .') '. $module['folder_name'] .'<br>';
				pr($files, $i > 0);
			}

			$found = 0;
			$not_found = 0;
			foreach ($files as $file) {
				$full_path = $path . $file;

				$this->db->where($module['col_name'], $full_path);
				$result = $this->db->get($module['db_name'])->result_array();

				if (count($result) > 0) {
					$found++;
					if ($debug) {
						echo 'Found ('. $found .')<br>';
					}
				} else {
					$not_found++;
					if ($debug) {
						echo 'Not Found ('. $not_found .') - '. $full_path .'<br>';
					}
					unlink(server_path() . share_folder() . $full_path);
				}
			}

			if ($debug) {
				if (!empty($id)) {
					$this->db->where($module['id_name'], $id);
				}

				$this->db->where($module['col_name'] .' !=', '');
				$this->db->where($module['col_name'] .' IS NOT NULL');
				$rows = $this->db->get($module['db_name'])->result_array();
				if ($found == count($rows) && $not_found == 0) {
					$success++;
					echo '<div style="margin-top:20px; margin-bottom:40px; width:25%; height:20px; text-align:center; color:white; background-color:green;">OK</div>';
				} else {
					echo '<div style="margin-top:20px; margin-bottom:40px; width:25%; height:20px; text-align:center; color:white; background-color:red;">Not Sync</div>';
				}
			}
		}

		if ($debug && $success == count($modules)) {
			echo '<hr><div style="line-height:30px; margin-top:20px; margin-bottom:40px; width:100%; height:30px; text-align:center; color:white; background-color:green;">All Folders OK</div>';
		}
	}
}