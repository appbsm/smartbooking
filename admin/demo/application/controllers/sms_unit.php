<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sms_unit extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
		$this->load->library('../controllers/home');
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

	private function delete_sms_unit_file ($id_sms_unit) {
		// This will delete the file from the folder
		$old_album = $this->get_sms_unit_by_id ($id_sms_unit);
		$pathInPieces = explode('\\', $_SERVER['DOCUMENT_ROOT']);
		$server_path = substr($_SERVER['DOCUMENT_ROOT'], 0, strpos($_SERVER['DOCUMENT_ROOT'], $pathInPieces[3]));
		$sharedfolder = 'share_folder/sms_booking/';
		$oldfile        = $server_path. $sharedfolder . $old_album['unit_thumbnail'];
		//$oldfile        = $old_album['unit_thumbnail'];
		if(file_exists($oldfile)) {
			unlink($oldfile);
		}
		return 1;
	}

	private function delete_all_photos ($id_sms_unit) {
		$this->db->where('id_sms_unit', $id_sms_unit);
		$this->db->delete('sms_unit_photo');
		//return $this->db->error();
	}

	private function delete_sms_unit_data ($id_sms_unit) {
		$this->db->where('id_sms_unit', $id_sms_unit);
		$this->db->delete('sms_unit');
		//return $this->db->error();
	}

	private function delete_photo_file ($id_photo) {

		// This will delete the file from the folder
		$old_photo = $this->get_photo_by_id ($id_photo);
		//return $old_photo;
		$pathInPieces = explode('\\', $_SERVER['DOCUMENT_ROOT']);
		$server_path = substr($_SERVER['DOCUMENT_ROOT'], 0, strpos($_SERVER['DOCUMENT_ROOT'], $pathInPieces[3]));
		$sharedfolder = 'share_folder/sms_booking/';
		$oldfile        = $server_path. $sharedfolder . $old_photo['photo_url'];
		//$oldfile        = $old_photo['unit_photo_url'];
		if(file_exists($oldfile)) {
			unlink($oldfile);
		}
		return 1;
	}

	private function delete_photo_data ($id_unit_photo) {
		$this->db->where('id_unit_photo', $id_unit_photo);
		$this->db->delete('sms_unit_photo');
		//return $this->db->error();
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

	
	
	/***** PRIVATE FUNCTIONS END *****/
	
	public function unit_management()
	{
		if (!has_permission('unit_management', 'view')) {
			header("Location: ". home_url());
		}
		
		$sms_units = $this->get_sms_unit();
		foreach ($sms_units as $i => $r) {		
			$sms_units[$i]['image'] = getImageUrl($r['unit_thumbnail']);
		}
		$this->_data['sms_units'] = $sms_units;
		$this->render();
	}

	public function save_sms_unit()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		
		
		$_POST['date_created'] = date('Y-m-d H:i:s');		
		$this->db->insert('sms_unit', $_POST);
		$ret['message'] = $this->db->insert_id();
		
		//print_r($_POST);
		$filename = $_FILES['file']['name'];
		// Valid file extensions
		$valid_extensions = array("jpg","jpeg","png","pdf");

		// File extension
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		// Check extension
		if(in_array(strtolower($extension),$valid_extensions) ) {
			$folder = 'sms_units';
			$path        = "upload/". $folder ."/";
			$imagename   = uniqid() .'.'. $extension;
			//$file        =  $path . $imagename;
			$file        = server_path() . share_folder() . $path . $imagename;						
		   // Upload file
		   if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){
						
			$save_url = $path . $imagename;
			$this->db->where('id_sms_unit', $ret['message']);
			$this->db->update('sms_unit', array('unit_thumbnail' => $save_url));
		   }else{
			  echo 0;
		   }
		}else{
		   echo 0;
		}
		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	public function update_sms_unit() {
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id = $_POST['id_sms_unit'];
		
		
		//print_r($_POST);
		$filename = $_FILES['file']['name'];
		// Valid file extensions
		$valid_extensions = array("jpg","jpeg","png","pdf");

		// File extension
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		// Check extension
		$save_url = '';
		if(in_array(strtolower($extension),$valid_extensions) ) {
			$folder = 'sms_units';
			$path        = "upload/". $folder ."/";
			$imagename   = (empty($id) ? '' : ($id .'_')) . uniqid() .'.'. $extension;
			//$file        = $path . $imagename ;
			$file        = server_path() . share_folder() . $path . $imagename ;
			
		   // Upload file
		   if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){
						
			$save_url = $path . $imagename;
			$data = array(				
				'unit_thumbnail' => $save_url
			);
			
			$this->db->where('id_sms_unit', $id);
			$this->db->update('sms_unit', $data);
		   }else{
			  echo 0;
		   }
		}else{
		   echo 0;
		}		
		$data = array(
			'unit_name_en' => $_POST['unit_name_en'],
			'unit_name_th' => $_POST['unit_name_th'],
			'unit_description_en' => $_POST['unit_description_en'],
			'unit_description_th' => $_POST['unit_description_th']
		);
		
		$this->db->where('id_sms_unit', $id);
		$this->db->update('sms_unit', $data);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	public function delete_sms_unit () {
		$ret = array('result' => 'false', 'message' => '');
		if (!empty($_POST)) {
			$id_sms_unit = $_POST['id_sms_unit'];
			$deleted = 0;
			
			
			if ($id_sms_unit != '') {
				// Delete All Photos in the FOLDER first			
				$unit_photos = $this->get_sms_unit_photos($id_sms_unit);	
				
				foreach ($unit_photos as $u) {
					// Delete Photo file			
					$ret['message'] = $u['id_unit_photo'];
					$deleted = $this->delete_photo_file($gp['id_unit_photo']);
				}
				// Delete All Photos in the DATABASE under the SMS Unit				
				$this->delete_all_photos ($id_sms_unit);
			
				// Delete Gallery file			
				$deleted = $this->delete_sms_unit_file($id_sms_unit);			
				if ($deleted == 1) {
					// Delete GALLERY Data			
					$ret['message'] = $this->delete_sms_unit_data($id_sms_unit);
				}
			}
			$ret['result'] = 'true';	
			echo json_encode($ret);	
		}
	}

	public function add_photo_unit() {
		$id_sms_unit = $this->uri->segment(3);
		$sms_unit_photos = $this->get_sms_unit_photos($id_sms_unit);
		//print_r($sms_unit_photos);
		foreach ($sms_unit_photos as $i => $r) {		
			$sms_unit_photos[$i]['image'] = getImageUrl($r['unit_photo_url']);
		}
		$first = isset($sms_unit_photos[0]) ? $sms_unit_photos[0] : array();		
		//print_r($first);
		$this->_data['first'] = $first;
		$this->_data['sms_unit_photos'] = $sms_unit_photos;
		$this->_data['photo_count'] = $this->get_count_photos($id_sms_unit);
		$this->render();
	}		

	public function save_sms_unit_photo()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id = $_POST['id_sms_unit'];
		
		
		$_POST['date_created'] = date('Y-m-d H:i:s');		
		$this->db->insert('sms_unit_photo', $_POST);
		$ret['message'] = $this->db->insert_id();
		
		//print_r($_POST);
		$filename = $_FILES['file']['name'];
		// Valid file extensions
		$valid_extensions = array("jpg","jpeg","png","pdf");

		// File extension
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		// Check extension
		if(in_array(strtolower($extension),$valid_extensions) ) {
			$folder = 'sms_units';
			$path        = "upload/". $folder ."/";
			$imagename   = uniqid() .'.'. $extension;
			//$file        =  $path . $imagename;
			$file        = server_path() . share_folder() . $path . $imagename;
			
		   // Upload file
		   if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){
						
			$save_url = $path . $imagename;
			$this->db->where('id_unit_photo', $ret['message']);
			$this->db->update('sms_unit_photo', array('unit_photo_url' => $save_url));
		   }else{
			  echo 0;
		   }
		}else{
		   echo 0;
		}		

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function update_sms_unit_photo()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_unit_photo = $_POST['id_unit_photo'];
		$id = $_POST['id_sms_unit'];
		
		$filename = $_FILES['file']['name'];
		if (!empty($filename)) {
			// Delete Photo file
			$this->delete_photo_file($id_unit_photo);
						
			// Valid file extensions
			$valid_extensions = array("jpg","jpeg","png","pdf");
			// File extension
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			// Check extension
			if(in_array(strtolower($extension),$valid_extensions) ) {
				$folder = 'sms_units';
				$path        = "upload/". $folder ."/";
				$imagename   = (empty($id) ? '' : ($id .'_')) . uniqid() .'.'. $extension;
				//$file        = $path . $imagename ;
				$file        = server_path() . share_folder() . $path . $imagename ;
				
			   // Upload file
			   if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){						
				$save_url = $path . $imagename;
				$this->db->where('id_unit_photo', $id_unit_photo);
				$this->db->update('sms_unit_photo', array('unit_photo_url' => $save_url));
			   }else{
				  echo 0;
			   }
			}else{
			   echo 0;
			}	
		}		
		$data = array(
			'unit_photo_desc_en' => $_POST['unit_photo_desc_en'],
			'sequence_order' => $_POST['sequence_order']
		);
		$this->db->where('id_unit_photo', $id_unit_photo);
		$this->db->update('sms_unit_photo',$data);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_sms_unit_photo () {
		$ret = array('result' => 'false', 'message' => '');
		if (!empty($_POST)) {
			$id_unit_photo = $_POST['id_unit_photo'];
			$deleted = 0;
			if ($id_unit_photo != '') {
				// Delete Photo file			
				$deleted = $this->delete_photo_file($id_unit_photo);			
				if ($deleted == 1) {
					// Delete Photo Data			
					$ret['message'] = $this->delete_photo_data($id_unit_photo);
				}
			}
			$ret['result'] = 'true';		
			echo json_encode($ret);	
		}
	}

	
}