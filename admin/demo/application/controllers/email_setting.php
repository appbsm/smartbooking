<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_setting extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
    }

	public function edit_email_setting()
	{
		if (!has_permission('edit_email_setting', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['step'] = empty($_GET['step']) ? 1 : $_GET['step'];
		$this->render();
	}

	public function save_email_setting()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('name', $_POST['action'] .'_email_template');
		$data = array(
			'value' => $_POST['data'],
			'updated' => date('Y-m-d H:i:s')
		);
		$this->db->update('setting', $data);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}