<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hr extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'hr';
    }

	///// Role
	public function role_management()
	{
		if (!has_permission('role_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['roles'] = $this->db->get('role_mgt')->result_array();
		$this->render();
	}

	public function edit_role($id = '')
	{
		if (!has_permission('role_management', 'view')) {
			header("Location: ". home_url());
		}

		///// Role Info
		$this->db->where('id_role', $id);
		$roles = $this->db->get('role_mgt')->result_array();

		if (count($roles) > 0) {
			$this->_data['role'] = $roles[0];
		} else {
			$fields = $this->db->list_fields('role_mgt');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}

			$this->_data['role'] = $tmp;
		}

		// Module Permission
		$modules = $this->db->get('module_mgt')->result_array();
		$tmp = array();
		foreach ($modules as $module) {
			$tmp[$module['id_module']] = $module;
			$tmp[$module['id_module']]['can_view'] = 0;
			$tmp[$module['id_module']]['can_edit'] = 0;
			$tmp[$module['id_module']]['can_delete'] = 0;
		}

		$this->db->where('id_role', $this->_data['role']['id_role']);
		$role_module = $this->db->get('role_module')->result_array();
		foreach ($role_module as $rm) {
			$tmp[$rm['id_module']]['can_view'] = $rm['can_view'];
			$tmp[$rm['id_module']]['can_edit'] = $rm['can_edit'];
			$tmp[$rm['id_module']]['can_delete'] = $rm['can_delete'];
		}
		$this->_data['modules'] = $tmp;

		$this->render();
	}

	public function save_role()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$role = $_POST['role'];
		if (empty($role['id_role'])) {
			$role['date_created'] = date('Y-m-d H:i:s');
			unset($role['id_role']);

			$this->db->insert('role_mgt', $role);
			$ret['message'] = $this->db->insert_id();
		} else {
			$id_role = $role['id_role'];
			unset($role['id_role']);

			$this->db->where('id_role', $id_role);
			$this->db->update('role_mgt', $role);
			$ret['message'] = $id_role;
		}

		// Save Role Module
		$modules = $_POST['modules'];
		foreach ($modules as $module) {
			$this->db->where('id_role', $ret['message']);
			$this->db->where('id_module', $module['id_module']);
			$role_modules = $this->db->get('role_module')->result_array();

			if (count($role_modules) > 0) {
				$this->db->where('id_role', $ret['message']);
				$this->db->where('id_module', $module['id_module']);
				$this->db->update('role_module', array(
					'can_view' => ($module['can_view'] == '1' || $module['can_view'] == 'true') ? 1 : 0,
					'can_edit' => ($module['can_edit'] == '1' || $module['can_edit'] == 'true') ? 1 : 0,
					'can_delete' => ($module['can_delete'] == '1' || $module['can_delete'] == 'true') ? 1 : 0
				));
			} else {
				$this->db->insert('role_module', array(
					'id_role' => $ret['message'],
					'id_module' => $module['id_module'],
					'can_view' => ($module['can_view'] == '1' || $module['can_view'] == 'true') ? 1 : 0,
					'can_edit' => ($module['can_edit'] == '1' || $module['can_edit'] == 'true') ? 1 : 0,
					'can_delete' => ($module['can_delete'] == '1' || $module['can_delete'] == 'true') ? 1 : 0
				));
			}
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_role()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Role ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_role', $_POST['id']);
			$users = $this->db->get('user_mgt')->result_array();

			if (count($users) > 0) {
				$ret['message'] = 'Can not delete, there are users in this role.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_role', $_POST['id']);
			$this->db->delete('role_module');

			$this->db->where('id_role', $_POST['id']);
			$this->db->delete('role_mgt');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	///// User
	public function user_management()
	{
		if (!has_permission('user_management', 'view')) {
			header("Location: ". home_url());
		}

		$users = $this->db->get('user_mgt')->result_array();
		foreach ($users as $i => $u) {
			$users[$i]['date_created'] = date('d/m/Y H:i', strtotime($u['date_created']));
		}

		$this->_data['users'] = $users;
		$this->render();
	}

	public function edit_user($id = '')
	{
		$s = $this->session->userdata('user_data');
		if (!has_permission('user_management', 'view') && $s['id_user'] != $id) {
			header("Location: ". home_url());
		}
		$this->_data['action'] = empty($_GET['action']) ? '' : $_GET['action'];

		///// User Info
		$this->db->where('id_user', $id);
		$users = $this->db->get('user_mgt')->result_array();

		if (count($users) > 0) {
			$this->_data['user'] = $users[0];
		} else {
			$fields = $this->db->list_fields('user_mgt');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}

			$this->_data['user'] = $tmp;
		}

		// roles
		$this->db->where('active', 1);
		$this->_data['roles'] = $this->db->get('role_mgt')->result_array();

		$this->render();
	}

	public function save_user()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('email', $_POST['email']);
		if (!empty($_POST['id_user'])) {
			$this->db->where('id_user !=', $_POST['id_user']);
		}
		$check_users = $this->db->get('user_mgt')->result_array();
		if (count($check_users) > 0) {
			$ret['message'] = 'This email was used.';
			echo json_encode($ret);
			return;
		}

		$this->db->where('username', $_POST['username']);
		if (!empty($_POST['id_user'])) {
			$this->db->where('id_user !=', $_POST['id_user']);
		}
		$check_users = $this->db->get('user_mgt')->result_array();
		if (count($check_users) > 0) {
			$ret['message'] = 'This username was used.';
			echo json_encode($ret);
			return;
		}

		//
		$this->db->where('id_role', $_POST['id_role']);
		$role = $this->db->get('role_mgt')->row_array();
		$_POST['role_name'] = $role['role_name'];

		if (empty($_POST['id_user'])) {
			$_POST['last_login'] = null;
			$_POST['date_created'] = date('Y-m-d H:i:s');
			$_POST['password'] = useMD5($_POST['password']);
			unset($_POST['id_user']);

			$this->db->insert('user_mgt', $_POST);
			$ret['message'] = $this->db->insert_id();
		} else {
			$id_user = $_POST['id_user'];
			unset($_POST['id_user']);

			$this->db->where('id_user', $id_user);
			$this->db->update('user_mgt', $_POST);
			$ret['message'] = $id_user;
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_user()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Role ID';
			echo json_encode($ret);
			return;
		} else {
			$user_data = $this->session->userdata('user_data');
			if ($user_data['id_user'] == $_POST['id']) {
				$ret['message'] = 'You can not delete your account by yourself.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('staff_id', $_POST['id']);
			$booking = $this->db->get('booking')->result_array();
			if (count($booking) > 0) {
				$ret['message'] = 'Can not delete, there are booking by this user.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_user', $_POST['id']);
			$this->db->delete('user_mgt');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}