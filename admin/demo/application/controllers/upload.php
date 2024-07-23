<?php defined('BASEPATH') OR exit('No direct script access allowed');
class upload extends CI_Controller {
 
	public function __construct(){
		parent::__construct();
		$this->load->model('m_upload');
	}
    public function upload_image () {
		
		if (!empty($_POST)) {
			$package_id = $this->input->post('package_id');
			// $data = array(
			// 	'package_id' => $this->input->post('package_id')
			// );
			//$this->m_upload->upload_image($data, $package_id);
			if ($_FILES['package_photo']['name'] != '') {											
					$doc_link = '';
					$target_dir = 'upload/package_photo/';
					$old_file_1 = basename($_FILES["package_photo"]["name"]);
					$extension = substr($old_file_1,strpos($old_file_1, '.'),strlen($old_file_1));
					
					$target_file = $package_id .'_'. uniqid() . $extension; //$this->rand().$extension;
		
					$config['file_name'] 			= $target_file;
					$config['upload_path']          = '../share_folder/sms_booking/'. $target_dir;
			        $config['allowed_types']        = 'gif|jpg|png|jpeg';
			        $config['overwrite']    		= true;

		        	$this->load->library('upload', $config);
					$this->upload->initialize($config);
		        	
					if ( ! $this->upload->do_upload('package_photo')) 
					{
		        		$data_error = array('error' => $this->upload->display_errors());
		        		print_r($data_error);
		        	}
		        	else
		        	{
		        		$data_error = array('upload_data' => $this->upload->data());	        		
		        		$doc_link = $target_dir.$target_file;
		        	}		        	
	        		
					$data = array(
						'package_photo_url' => $doc_link,
					);
					$this->m_upload->upload_image($data, $package_id);						
			}
			redirect('packages/package_management');						
		}
	}
 
}
?>