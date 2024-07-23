<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Discounts extends MY_Controller {
	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
    }

    public function discount_management()
    {
        if (!has_permission('discount_management', 'view')) {
			header("Location: ". home_url());
		}

        ///// Discount
		$discount = $this->db->get('discount')->result_array();
		$fields = $this->db->list_fields('discount');
		$tmp = array();
		foreach ($fields as $field) {
			if ($field != 'date_created') {
				$tmp[$field] = '';
			}
		}
		$tmp['id_discount'] = '0';
		array_unshift($discount, $tmp);
		$this->_data['discount'] = $discount;

        $this->render();
    }

    public function save_discount()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_discount = $_POST['id_discount'];
		unset($_POST['id_discount']);

		// check repeat code
		$this->db->where('code', $_POST['code']);
		$this->db->where('id_discount !=', $id_discount);
		$check_repeat = $this->db->get('discount')->num_rows();
		if ($check_repeat > 0) {
			$ret['message'] = 'This Code is already used.';
			echo json_encode($ret);
			return;
		}

		if (empty($id_discount)) {
			$_POST['date_created'] = date('Y-m-d H:i:s');
			$this->db->insert('discount', $_POST);
		} else {
			$this->db->where('id_discount', $id_discount);
			$this->db->update('discount', $_POST);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_discount()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Discount ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_discount', $_POST['id']);
			$guest = $this->db->get('guest_info')->result_array();

			if (count($guest) > 0) {
				$ret['message'] = 'Can not delete, there are guests using this discount.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_discount', $_POST['id']);
			$this->db->delete('discount');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}