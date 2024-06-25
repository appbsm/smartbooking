<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

	//$first_load = true;
	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_gallery');
		
		$lang = $this->input->get('lang');
		if ($lang) {
			$this->session->set_userdata('site_lang', $lang);
			redirect('gallery');
		}
		$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'english'; 
		
		if($lg=='thai'){
		    $this->lang->load('content','thai');
		}
		elseif($lg=='english'){
		    $this->lang->load('content','english');
		}
	}
	
	public function index()
	{
		
		$data = array();
		$data['gallery_categories'] = $this->m_gallery->get_gallery_categories();
		$this->load->view('v_gallery', $data);
	}
	
	public function photo_album () {
		$id_gallery = $this->uri->segment(3);
		$data['gallery_photos'] = $this->m_gallery->get_gallery_photos ($id_gallery);
		//print_r($data['gallery_photos']);
		//$this->load->view('v_gallery_photo', $data);
		$this->load->view('v_gallery_photo_slider', $data);
	}
	
	/*
	public function gallery_swipe () {
		$id_gallery = $this->uri->segment(3);
		$data['gallery_photos'] = $this->m_gallery->get_gallery_photos ($id_gallery);
		//int_r($data['gallery_photos']);
		$this->load->view('photo_swipe', $data);
	}
	
	public function gallery_js_slider () {
		$id_gallery = $this->uri->segment(3);
		$data['gallery_photos'] = $this->m_gallery->get_gallery_photos ($id_gallery);
		//int_r($data['gallery_photos']);
		$this->load->view('slider_js', $data);
	}
	
	public function gallery_blueimp () {
		$id_gallery = $this->uri->segment(3);
		$data['gallery_photos'] = $this->m_gallery->get_gallery_photos ($id_gallery);
		//int_r($data['gallery_photos']);
		$this->load->view('v_gallery_photo_slider', $data);
	}
	*/
}
