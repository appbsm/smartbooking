<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Config_setting extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
    }

	public function edit_config_setting()
	{
		if (!has_permission('edit_config_setting', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->where('can_edit', 1);
		$this->_data['setting_rows'] = $this->db->get('setting')->result_array();
		$this->render();
	}

	public function save_config_setting()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('id_setting', $_POST['id_setting']);
		$this->db->update('setting', array(
			'value' => $_POST['value'],
			'remark' => $_POST['remark'],
			'updated' => date('Y-m-d H:i:s')
		));

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}