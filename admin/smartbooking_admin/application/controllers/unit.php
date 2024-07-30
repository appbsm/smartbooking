<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
		$this->load->library('../controllers/home');
    }

    public function unit_management()
	{
		if (!has_permission('unit_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->select("*");
		$this->db->from('setting_unit_rate');
		$setting_unit_rate = $this->db->get()->result_array();

		$run_id=1;
		foreach ($setting_unit_rate as $i => $r) {
			$setting_unit_rate[$i]['run_id'] = $run_id;
			$run_id++;
		}
		
		$this->_data['setting_unit_rate'] = $setting_unit_rate;

		$this->render();
	}
    
    public function edit_unit($id = '')
	{
		if (!has_permission('internet_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->where('id',$id);
		$unit_info = $this->db->get('setting_unit_rate')->result_array();
		
		if (count($unit_info) > 0) {
			// echo unit_management_url();

			// $this->_data['internet_info'] = $internet_info[0];
			// $project_info = $this->db->get('project_info')->result_array();
			// $this->_data['project_info'] = $project_info;
			$this->_data['setting_unit_rate'] = $unit_info[0];
		}else{
			$setting_unit_rate = $this->db->get('setting_unit_rate')->result_array();
			$this->_data['setting_unit_rate'] = $setting_unit_rate;

			$fields = $this->db->list_fields('setting_unit_rate');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}

			$tmp['status'] = '1';
			$this->_data['setting_unit_rate'] = $tmp;
		}

		// $this->_data['setting_unit_rate'] = $setting_unit_rate;

		$this->render();
	}

	public function save_unit()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_unit = $_POST['id'];
		unset($_POST['id']);

		if (empty($id_unit)) {

			// $this->db->select('meter_id');
			// $this->db->from('internet_list');
			// $this->db->order_by('meter_id', 'DESC');
			// $this->db->limit(1);
			// $query = $this->db->get();
			// $electric_info = $query->row_array();

			// if (!empty($electric_info)) {
			// 	$last_meter_id = $electric_info['meter_id'];
			//     $parts = explode('-', $last_meter_id);
			//     $number = intval(end($parts));
			    
			//     $new_number = str_pad($number + 1, 5, '0', STR_PAD_LEFT);
			//     $meter_id_set = 'MTI-' . $new_number;
			// }else{
			// 	$meter_id_set = "MTI-00001";
			// }
			// $_POST['meter_id'] = $meter_id_set;

			unset($_POST['update_by']);
			unset($_POST['create_by']);
			unset($_POST['update_date']);
			$_POST['create_date'] = date('Y-m-d H:i:s');
			$this->db->insert('setting_unit_rate',$_POST);
			$ret['id_setting'] = $this->db->insert_id();
		}else{
			// $ret['id_unit'] = $id_unit;

			unset($_POST['id']);
			$_POST['update_date'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id_unit);
			$this->db->update('setting_unit_rate',$_POST);
			$ret['id_setting'] = $id_unit;
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_unit()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		// check empty room type id
		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Setting Unit ID';
			echo json_encode($ret);
			return;
		}

		$this->db->where('id', $_POST['id']);
		$this->db->delete('setting_unit_rate');

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

}