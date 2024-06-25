<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_units extends MY_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_project_info');
		$this->load->model('m_guest');
		$this->load->model('m_booking');
		$this->load->model('m_extra');
		$this->load->model('m_cart');
		$this->load->model('m_package');
		$this->load->model('m_discount');
	 	//if(!$this->session->userdata('id_guest')){
		 	//redirect('login');
		 	//header("Location: ". login_url());
		//}
		$this->id_project_info = 1;
		$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai'; 
		if($lg=='thai'){
		    $this->lang->load('content','thai');
		}
		elseif($lg=='english'){
		    $this->lang->load('content','english');
		}
		$this->language  = $lg;
	}
	
	public function index()
	{   
	    $data = array();
	     $data['sms_unit'] = $this->get_sms_unit();
	     $this->load->view('sms_unit/v_sms_unit', $data);
	}
	
	public function photo_album () {
	    $id_sms_unit = $this->uri->segment(3);
	    $data['sms_unit'] = $this->get_sms_unit_photos ($id_sms_unit) ;
	    //print_r($data['sms_unit']);
	    //$this->load->view('v_gallery_photo', $data);
	    $this->load->view('sms_unit/v_sms_unit_photo', $data);
	}
	
	
	/***** PRIVATE FUNCTIONS START *****/
	private function get_sms_unit () {
	    $query = $this->db->get('sms_unit');
	    return $query->result_array();
	}
	
	private function get_sms_unit_by_id ($id_sms_unit) {
	    $result = array();
	    $this->db->select("*");
	    $this->db->from('sms_unit');
	    $this->db->where('id_sms_unit', $id_sms_unit);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0) {
	        $res = $query->result_array();
	        $result = $res[0];
	    }
	    return $result;
	}
	
	private function get_sms_unit_photos ($id_sms_unit) {
	    $this->db->select('up.*, u.*');
	    $this->db->from('sms_unit u');
	    $this->db->join('sms_unit_photo up', 'up.id_sms_unit = u.id_sms_unit', 'LEFT');
	    $this->db->where('u.id_sms_unit', $id_sms_unit);
	    $this->db->order_by('up.sequence_order', 'ASC');
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	private function get_photo_by_id ($id_unit_photo) {
	    $result = array();
	    $this->db->select("*");
	    $this->db->from('sms_unit_photo');
	    $this->db->where('id_unit_photo', $id_unit_photo);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0) {
	        $res = $query->result_array();
	        $result = $res[0];
	    }
	    return $result;
	}
	
	private function get_count_photos ($id_sms_unit) {
	    $count = 0;
	    $this->db->select('COUNT(*) as count');
	    $this->db->from('sms_unit_photo');
	    $this->db->where('id_sms_unit', $id_sms_unit);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0) {
	        $res = $query->result();
	        $count = $res[0]->count;
	    }
	    return $count;
	}
}
