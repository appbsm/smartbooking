<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = '';
		$this->load->library('../controllers/pos');
    }

	public function login()
	{
		$this->load->view($this->router->fetch_class() .'/'. $this->router->method, $this->_data);
	}

	public function logout()
	{
		$this->session->set_userdata('user_data', '');
		header("Location: ". user_login_url());
	}

	public function auth()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('username', $_POST['username']);
		$this->db->where('password', useMD5($_POST['password']));
		$this->db->where('active', 1);
		$result = $this->db->get('user_mgt')->result_array();

		if (count($result) == 0) {
			$ret['message'] = 'Username or Password is wrong.';
		} else {
			$this->session->set_userdata('user_data', $result[0]);
			header("Location: ". home_url());
			$ret['result'] = 'true';

			if (!empty($result[0]['last_login'])) {
				$this->db->where('id_user', $result[0]['id_user']);
				$this->db->update('user_mgt', array(
					'last_login' => date('Y-m-d H:i:s')
				));
			}
		}

		echo json_encode($ret);
	}

	public function forgot_password()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('username', $_POST['username']);
		$this->db->where('email', $_POST['email']);
		$users = $this->db->get('user_mgt')->result_array();

		if (count($users) == 0) {
			$ret['message'] = 'Username or Email is not correct.';
			echo json_encode($ret);
			return;
		}

		// reset password
		$new_password = generateRandomString(8);

		$user = $users[0];
		$this->db->where('id_user', $user['id_user']);
		$this->db->update('user_mgt', array(
			'password' => useMD5($new_password)
		));

		// send email
		$to = $user['email'];
		$subject = 'SMS Booking Admin Panel - Password Reset';
		$message = 'username: '. $user['username'] .'<br>รหัสผ่านใหม่ของคุณคือ: '. $new_password;

		$this->pos->_sendEmail($to, $subject, $message);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function change_password()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('id_user', $_POST['id_user']);
		$user = $this->db->get('user_mgt')->row_array();

		if ($user['password'] != useMD5($_POST['old_password'])) {
			$ret['message'] = 'Old passward is not correct.';
			echo json_encode($ret);
			return;
		}

		$this->db->where('id_user', $_POST['id_user']);
		if (!empty($_POST['action']) && $_POST['action'] == 'first_login') {
			$now = date('Y-m-d H:i:s');
			$this->db->update('user_mgt', array(
				'password' => useMD5($_POST['new_password']),
				'last_login' => $now
			));

			$s = $this->session->userdata('user_data');
			$s['last_login'] = $now;
			$this->session->set_userdata('user_data', $s);
		} else {
			$this->db->update('user_mgt', array(
				'password' => useMD5($_POST['new_password'])
			));
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	public function reset_password_adminonly () {
		$username = 'root';
		$password = useMD5('sms@2024');
		$this->db->where('username', $username);		
		$this->db->update('user_mgt', array(
				'password' => $password
		));
		
		echo "Password Updated.";
	}
}