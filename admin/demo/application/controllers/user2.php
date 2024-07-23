<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User2 extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // ตรวจสอบการเข้าสู่ระบบ
        // if (!$this->session->userdata('user_data')) {
        //     redirect('login');
        // }

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
        header("Location: http://192.168.20.22/smartbooking_admin/index.php?message=false");
    } else {
        $this->session->set_userdata('user_data', $result[0]);
        $ret['result'] = 'true';
        $ret['username'] = $_POST['username'];
        $ret['password'] = $_POST['password'];
        $ret['message'] = 'true';
		header("Location: http://192.168.20.22/smartbooking_admin/demo/");
    }

    echo json_encode($ret);
	}


    /*public function auth()
    {
        header('Content-Type: application/json; charset=utf-8');
        $ret = array('result' => 'false test', 'message' => '');

        $this->db->where('username', $_POST['username']);
        $this->db->where('password', useMD5($_POST['password']));
        $this->db->where('active', 1);
        $result = $this->db->get('user_mgt')->result_array();

        if (count($result) == 0) {
            $ret['message'] = 'Username or Password is wrong.';
            //header("Location: login_test.php");
        } else {
            $this->session->set_userdata('user_data', $result[0]);
            // header("Location: ". home_url());
			//http://192.168.20.22/smartbooking_admin/demo/
            header("Location: http://192.168.20.22/smartbooking_admin/demo/");
            $ret['result'] = 'true';
			$ret['username'] = $_POST['username'];
			$ret['password'] = $_POST['password'];
			$ret['message'] = 'true';
        }
		
        //header("Location: ". user_login_url());
		//header("Location: http://192.168.20.22/smartbooking_admin/demo/");
        echo json_encode($ret);
    }*/

    public function test(){
        // parent::__construct();
        $this->load->library('session');
        // $this->load->helper('url');

        $this->db->where('username','root');
        $this->db->where('password',useMD5('sms@2024'));
        $this->db->where('active', 1);
        $result = $this->db->get('user_mgt')->result_array();
        $this->session->set_userdata('user_data', $result[0]);
    }

    public function auth_company(){
        $this->load->library('session');

        $this->db->where('username','root');
        $this->db->where('password',useMD5('sms@2024'));
        $this->db->where('active', 1);
        $result = $this->db->get('user_mgt')->result_array();
        $this->session->set_userdata('user_data', $result[0]);

        // $this->load->library('../controllers/pos');
        // redirect('/login');
        // $autoload['libraries'] = array('session');
        // $this->load->library('session');

        $this->load->library('session');
        $sess_cookie_name = $this->config->item('sess_cookie_name');

        $this->db->where('username', $_POST['username']);
        $this->db->where('password', useMD5($_POST['password']));
        $this->db->where('active', 1);
        $result = $this->db->get('user_mgt')->result_array();

        if (count($result) == 0) {
            $ret['message'] = 'Username or Password is wrong.';
            $ret['result'] = 'false';
        } else {

            $this->session->set_userdata('user_data', $result[0]);
            $ret['result'] = 'true';
            $ret['user_data'] = $result[0];
            $ret['sess_cookie_name'] = $sess_cookie_name;

            if (!empty($result[0]['last_login'])) {
                $this->db->where('id_user', $result[0]['id_user']);
                $this->db->update('user_mgt', array(
                    'last_login' => date('Y-m-d H:i:s')
                ));
            }
            $user_data = $this->session->userdata('user_data');
            if ($user_data) {
                $ret['username'] = $result[0]['username'];
                $ret['password'] = $user_data['password'];
                // $ret['sess_cookie_name'] = $sess_cookie_name;
            }
        }

        // echo json_encode($ret);
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($ret));
    }

    public function index() {
        // หน้าหลักสำหรับ User2 Controller
        $this->load->view('user2_dashboard');
    }

    public function some_method() {
        // เมธอดอื่นๆ ที่คุณต้องการสร้าง
        echo "This is some method in User2 controller";


    }
}
