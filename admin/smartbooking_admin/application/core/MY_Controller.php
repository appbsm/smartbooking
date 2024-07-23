<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $_data = array();
    public $settings = array();

    function __construct() {
        parent::__construct();
        $this->_data['active_menu'] = '';
        date_default_timezone_set("Asia/Bangkok");
		
        $no_auth_controllers = array('user2');
        if (!in_array(strtolower($this->router->class), $no_auth_controllers)) { 
            check_auth();
        }

        // Load Models
        $model_files = scandir(__DIR__ ."\..\models");
        foreach($model_files as $file) {
            $f = explode('.', $file);
            if ($f[1] === 'php') {
                $this->load->model(ucfirst($f[0]));
            }
        }

        // Get Setting
        $setting_rows = $this->db->get('setting')->result_array();
        $tmp = array();
        foreach ($setting_rows as $s) {
            $tmp[$s['name']] = $s['value'];
        }
        $this->settings = $tmp;
        $this->_data['settings'] = $tmp;
    }

	public function render()
	{
        $this->load->view('layout/header', $this->_data);
		$this->load->view($this->router->fetch_class() .'/'. $this->router->method, $this->_data);
		$this->load->view('layout/footer', $this->_data);
	}
}