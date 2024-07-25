<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'record';
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
    
}