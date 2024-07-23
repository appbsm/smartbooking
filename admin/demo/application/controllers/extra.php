<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Extra extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
    }

	public function extra_management()
	{
		if (!has_permission('extra_management', 'view')) {
			header("Location: ". home_url());
		}

		$extras = $this->db->get('extras')->result_array();
		$this->_data['extras'] = $extras;

		// blank row
		$fields = $this->db->list_fields('extras');
		$tmp = array();
		foreach ($fields as $field) {
			if (!in_array($field, array('date_created', 'id_extras'))) {
				$tmp[$field] = '';
			}
		}
		$this->_data['extra_blank_row'] = $tmp;

		$this->render();
	}

	public function save_extra()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['extra']['id_extras'])) {
			$_POST['extra']['date_created'] = date('Y-m-d H:i:s');
			$this->db->insert('extras', $_POST['extra']);
		} else {
			$this->db->where('id_extras', $_POST['extra']['id_extras']);
			unset($_POST['extra']['id_extras']);
			$this->db->update('extras', $_POST['extra']);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_extra()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Can not delete, empty Extra ID.';
			echo json_encode($ret);
			return;
		}

		$this->db->where('id_extras', $_POST['id']);
		$booking_extra = $this->db->get('booking_item')->result_array();
		if (count($booking_extra) > 0) {
			$ret['message'] = 'Can not delete, there are bookings using this extra.';
			echo json_encode($ret);
			return;
		}

		$this->db->where('id_extras', $_POST['id']);
		$this->db->delete('extras');

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}