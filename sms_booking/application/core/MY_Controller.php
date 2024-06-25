<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $_data = array();
    public $setting = array();

    function __construct() {
        parent::__construct();
        //$this->_data['active_menu'] = '';
        date_default_timezone_set("Asia/Bangkok");
        //check_auth();

        // Get Setting
        $settings = $this->db->get('setting')->result_array();
        $tmp = array();
        foreach ($settings as $s) {
            $tmp[$s['name']] = $s['value'];
        }
        $this->setting = $tmp;
        $this->_data['setting'] = $tmp;
    }
}