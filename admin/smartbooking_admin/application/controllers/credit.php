<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Credit extends MY_Controller {
	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
    }

    public function credit_management()
    {
        if (!has_permission('credit_management', 'view')) {
			header("Location: ". home_url());
		}

        ///// Discount
		$this->db->order_by('credit_term', 'ASC');
		$credit = $this->db->get('credit')->result_array();
		$fields = $this->db->list_fields('credit');
		$tmp = array();
		foreach ($fields as $field) {
			if ($field != 'date_created') {
				$tmp[$field] = '';
			}
		}
		$tmp['id_credit'] = '0';
		array_unshift($credit, $tmp);
		$this->_data['credit'] = $credit;

        $this->render();
    }

    public function save_credit()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');
		$id_credit = $_POST['id_credit'];  
		unset($_POST['id_credit']);
		// check repeat code
		if (!empty($id_credit)) {
			$this->db->where('credit_term_days', $_POST['credit_term']);
			$this->db->where('id_credit !=', $id_credit);
			$check_repeat = $this->db->get('credit')->num_rows();
			if ($check_repeat > 0) {
				$ret['message'] = 'This Credit Term already exist.';
				echo json_encode($ret);
				return;
			}		
		}
		
		if (empty($id_credit)) {
			$_POST['date_created'] = date('Y-m-d');
			$this->db->insert('credit', $_POST);
		} else {
			$this->db->where('id_credit', $id_credit);
			$this->db->update('credit', $_POST);
		}
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_credit()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Credit';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_credit', $_POST['id']);
			$guest = $this->db->get('guest_info')->result_array();
			
			if (count($guest) > 0) {
				$ret['message'] = 'Can not delete, there are guests using this discount.';
				echo json_encode($ret);
				return;
			}
			
			$this->db->where('id_credit', $_POST['id']);
			$this->db->delete('credit');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}