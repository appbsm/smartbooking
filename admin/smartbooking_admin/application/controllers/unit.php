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
			echo unit_management_url();
		}else{
			$setting_unit_rate = $this->db->get('setting_unit_rate')->result_array();
			$this->_data['setting_unit_rate'] = $setting_unit_rate;

			$fields = $this->db->list_fields('internet_list');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$this->_data['internet_info'] = $tmp;
		}

		$this->_data['setting_unit_rate'] = $setting_unit_rate;
		$this->render();
	}
}