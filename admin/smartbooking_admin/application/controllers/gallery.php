<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class gallery extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'setting';
		$this->load->library('../controllers/home');
    }

	/***** PRIVATE FUNCTIONS START *****/
	private function get_gallery_categories () {
		$query = $this->db->get('gallery_category');		
		return $query->result_array();
	}
	
	private function get_gallery_photos ($id_gal_cat) {
		$this->db->select('gp.*, gc.*');
		$this->db->from('gallery_category gc');
		$this->db->join('gallery_photo gp', 'gp.id_gallery_category = gc.id_gallery_category', 'LEFT');
		$this->db->where('gc.id_gallery_category', $id_gal_cat);
		$this->db->order_by('gp.sequence_order', 'ASC');
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	private function get_photos_by_id_gallery ($id_gal_cat) {
		$this->db->select('*');
		$this->db->from('gallery_photo');
		$this->db->where('id_gallery_category', $id_gal_cat);
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	private function get_photo_by_id ($id_photo_gallery) {
		$result = array();
		$this->db->select("*");
		$this->db->from('gallery_photo');
		$this->db->where('id_gallery_photo', $id_photo_gallery);
		$query = $this->db->get();	
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0];
		}
		return $result;
	}
	
	private function get_gallery_by_id ($id_gallery_category) {
		$result = array();
		$this->db->select("*");
		$this->db->from('gallery_category');
		$this->db->where('id_gallery_category', $id_gallery_category);
		$query = $this->db->get();	
		if ($query->num_rows() > 0) {
			$res = $query->result_array();
			$result = $res[0];
		}
		return $result;
	}
	
	private function get_count_photos ($id_gal_cat) {
		$count = 0;
		$this->db->select('COUNT(*) as count');
		$this->db->from('gallery_photo');
		$this->db->where('id_gallery_category', $id_gal_cat);
		$query = $this->db->get();	
		if ($query->num_rows() > 0) {
			$res = $query->result();
			$count = $res[0]->count;
		}
		return $count;
	}
	
	private function delete_photo_file ($id_photo) {

		// This will delete the file from the folder
		$old_photo = $this->get_photo_by_id ($id_photo);
		//return $old_photo;
		$pathInPieces = explode('\\', $_SERVER['DOCUMENT_ROOT']);
		$server_path = substr($_SERVER['DOCUMENT_ROOT'], 0, strpos($_SERVER['DOCUMENT_ROOT'], $pathInPieces[3]));
		$sharedfolder = 'share_folder/sms_booking/';
		$oldfile        = $server_path. $sharedfolder . $old_photo['photo_url'];

		if(file_exists($oldfile)) {

			unlink($oldfile);
		}
		return 1;
	}
	
	private function delete_all_photos ($id_gallery_category) {
		$this->db->where('id_gallery_category', $id_gallery_category);
		$this->db->delete('gallery_photo');
		//return $this->db->error();
	}
	
	private function delete_photo_data ($id_photo_gallery) {
		$this->db->where('id_gallery_photo', $id_photo_gallery);
		$this->db->delete('gallery_photo');
		//return $this->db->error();
	}
	
	private function delete_gallery_data ($id_gallery_category) {
		$this->db->where('id_gallery_category', $id_gallery_category);
		$this->db->delete('gallery_category');
		//return $this->db->error();
	}
	
	private function delete_gallery_file ($id_gallery_category) {
		// This will delete the file from the folder
		$old_album = $this->get_gallery_by_id ($id_gallery_category);
		$pathInPieces = explode('\\', $_SERVER['DOCUMENT_ROOT']);
		$server_path = substr($_SERVER['DOCUMENT_ROOT'], 0, strpos($_SERVER['DOCUMENT_ROOT'], $pathInPieces[3]));
		$sharedfolder = 'share_folder/sms_booking/';
		$oldfile        = $server_path. $sharedfolder . $old_album['category_thumbnail'];
		if(file_exists($oldfile)) {
			unlink($oldfile);
		}
		return 1;
	}
	
	
	
	/***** PRIVATE FUNCTIONS END *****/
	
	public function gallery_management()
	{
		if (!has_permission('gallery_management', 'view')) {
			header("Location: ". home_url());
		}
		
		$gallery_categories = $this->get_gallery_categories();
		foreach ($gallery_categories as $i => $r) {		
			$gallery_categories[$i]['image'] = getImageUrl($r['category_thumbnail']);
		}
		$this->_data['gallery_categories'] = $gallery_categories;
		$this->render();
	}
	
	public function add_photo_gallery() {
		$id_gal_cat = $this->uri->segment(3);
		$gallery_photos = $this->get_gallery_photos($id_gal_cat);
		foreach ($gallery_photos as $i => $r) {		
			$gallery_photos[$i]['image'] = getImageUrl($r['photo_url']);
		}
		$first = $gallery_photos[0];		
		$this->_data['first'] = $first;
		$this->_data['gallery_photos'] = $gallery_photos;
		$this->_data['photo_count'] = $this->get_count_photos($id_gal_cat);
		$this->render();
	}		
	
	public function save_gallery_category()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		
		
		$_POST['date_created'] = date('Y-m-d H:i:s');		
		$this->db->insert('gallery_category', $_POST);
		$ret['message'] = $this->db->insert_id();
		
		//print_r($_POST);
		$filename = $_FILES['file']['name'];
		// Valid file extensions
		$valid_extensions = array("jpg","jpeg","png","pdf");

		// File extension
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		// Check extension
		if(in_array(strtolower($extension),$valid_extensions) ) {
			$folder = 'gallery_photo';
			$path        = "upload/". $folder ."/";
			$imagename   = uniqid() .'.'. $extension;
			$file        = server_path() . share_folder() . $path . $imagename;
			
		   // Upload file
		   if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){
						
			$save_url = $path . $imagename;
			$this->db->where('id_gallery_category', $ret['message']);
			$this->db->update('gallery_category', array('category_thumbnail' => $save_url));
		   }else{
			  echo 0;
		   }
		}else{
		   echo 0;
		}
		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	public function save_gallery_photo()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id = $_POST['id_gallery_category'];
		
		
		$_POST['date_created'] = date('Y-m-d H:i:s');		
		$this->db->insert('gallery_photo', $_POST);
		$ret['message'] = $this->db->insert_id();
		
		//print_r($_POST);
		$filename = $_FILES['file']['name'];
		// Valid file extensions
		$valid_extensions = array("jpg","jpeg","png","pdf");

		// File extension
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		// Check extension
		if(in_array(strtolower($extension),$valid_extensions) ) {
			$folder = 'gallery_photo';
			$path        = "upload/". $folder ."/";
			$imagename   = uniqid() .'.'. $extension;
			$file        = server_path() . share_folder() . $path . $imagename;
		   // Upload file
		   if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){
						
			$save_url = $path . $imagename;
			$this->db->where('id_gallery_photo', $ret['message']);
			$this->db->update('gallery_photo', array('photo_url' => $save_url));
		   }else{
			  echo 0;
		   }
		}else{
		   echo 0;
		}		

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	public function update_gallery_category() {
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id = $_POST['id_gallery_category'];
		
		
		//print_r($_POST);
		$filename = $_FILES['file']['name'];
		// Valid file extensions
		$valid_extensions = array("jpg","jpeg","png","pdf");

		// File extension
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		// Check extension
		$save_url = '';
		if(in_array(strtolower($extension),$valid_extensions) ) {
			$folder = 'gallery_photo';
			$path        = "upload/". $folder ."/";
			$imagename   = (empty($id) ? '' : ($id .'_')) . uniqid() .'.'. $extension;
			$file        = server_path() . share_folder() . $path . $imagename ;
		   // Upload file
		   if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){
						
			$save_url = $path . $imagename;
			$data = array(				
				'category_thumbnail' => $save_url
			);
			
			$this->db->where('id_gallery_category', $id);
			$this->db->update('gallery_category', $data);
		   }else{
			  echo 0;
		   }
		}else{
		   echo 0;
		}		
		$data = array(
			'gallery_name_en' => $_POST['gallery_name_en'],
			'gallery_name_th' => $_POST['gallery_name_th']
		);
		
		$this->db->where('id_gallery_category', $id);
		$this->db->update('gallery_category', $data);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	public function test_photo () {
		$id_photo = 8;
		$old_photo = $this->get_photo_by_id (8);
		
		$pathInPieces = explode('\\', $_SERVER['DOCUMENT_ROOT']);
		$server_path = substr($_SERVER['DOCUMENT_ROOT'], 0, strpos($_SERVER['DOCUMENT_ROOT'], $pathInPieces[3]));
		print_r($_SERVER['DOCUMENT_ROOT']);
		echo "<br>";
		print_r($server_path);
		$sharedfolder = 'share_folder/sms_booking/';
		$oldfile        = $server_path. $sharedfolder . $old_photo['photo_url'];
		
		echo "<br>";
		print_r($oldfile);
		
		$this->delete_photo_file ($id_photo);
	}
	
	public function update_gallery_photo()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$id_gallery_photo = $_POST['id_gallery_photo'];
		$id = $_POST['id_gallery_category'];
		
		$filename = $_FILES['file']['name'];
		if (!empty($filename)) {
			// Delete Photo file
			$this->delete_photo_file($id_gallery_photo);
						
			// Valid file extensions
			$valid_extensions = array("jpg","jpeg","png","pdf");
			// File extension
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			// Check extension
			if(in_array(strtolower($extension),$valid_extensions) ) {
				$folder = 'gallery_photo';
				$path        = "upload/". $folder ."/";
				$imagename   = (empty($id) ? '' : ($id .'_')) . uniqid() .'.'. $extension;
				$file        = server_path() . share_folder() . $path . $imagename ;
			   // Upload file
			   if(move_uploaded_file($_FILES['file']['tmp_name'], $file)){						
				$save_url = $path . $imagename;
				$this->db->where('id_gallery_photo', $id_gallery_photo);
				$this->db->update('gallery_photo', array('photo_url' => $save_url));
			   }else{
				  echo 0;
			   }
			}else{
			   echo 0;
			}	
		}		
		$data = array(
			'photo_desc' => $_POST['photo_desc'],
			'sequence_order' => $_POST['sequence_order']
		);
		$this->db->where('id_gallery_photo', $id_gallery_photo);
		$this->db->update('gallery_photo',$data);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	public function delete_gallery_photo () {
		$ret = array('result' => 'false', 'message' => '');
		if (!empty($_POST)) {
			$id_gallery_photo = $_POST['id_gallery_photo'];
			$deleted = 0;
			if ($id_gallery_photo != '') {
				// Delete Photo file			
				$deleted = $this->delete_photo_file($id_gallery_photo);			
				if ($deleted == 1) {
					// Delete Photo Data			
					$ret['message'] = $this->delete_photo_data($id_gallery_photo);
				}
			}
			$ret['result'] = 'true';		
			echo json_encode($ret);	
		}
	}
	
	
	public function test_photos () {
		$id_gallery_category = 22;
		$gallery_photos = $this->get_photos_by_id_gallery($id_gallery_category);
		
		$old_photo = $this->get_photo_by_id (28);
		print_r($gallery_photos);
		
		echo "<br>";
		print_r($old_photo);
		$pathInPieces = explode('\\', $_SERVER['DOCUMENT_ROOT']);
		$server_path = substr($_SERVER['DOCUMENT_ROOT'], 0, strpos($_SERVER['DOCUMENT_ROOT'], $pathInPieces[3]));
		$sharedfolder = 'share_folder/sms_booking/';
		$oldfile        = $server_path. $sharedfolder . $old_photo['photo_url'];
		echo "<br>";
		print_r($oldfile);
	}
	
	public function delete_gallery () {
		$ret = array('result' => 'false', 'message' => '');
		if (!empty($_POST)) {
			$id_gallery_category = $_POST['id_gallery_category'];
			$deleted = 0;
			
			
			if ($id_gallery_category != '') {
				// Delete All Photos in the FOLDER first			
				$gallery_photos = $this->get_photos_by_id_gallery($id_gallery_category);	
				
				foreach ($gallery_photos as $gp) {
					// Delete Photo file			
					$ret['message'] = $gp['id_gallery_photo'];
					$deleted = $this->delete_photo_file($gp['id_gallery_photo']);
				}
				// Delete All Photos in the DATABASE under the Gallery				
				$this->delete_all_photos ($id_gallery_category);
			
				// Delete Gallery file			
				$deleted = $this->delete_gallery_file($id_gallery_category);			
				if ($deleted == 1) {
					// Delete GALLERY Data			
					$ret['message'] = $this->delete_gallery_data($id_gallery_category);
				}
			}
			$ret['result'] = 'true';	
			echo json_encode($ret);	
		}
	}
	
	function test_delete_gallery_photos () {
		$id_gallery_category = 24;
		$gallery_photos = $this->get_photos_by_id_gallery($id_gallery_category);	
		foreach ($gallery_photos as $gp) {
					// Delete Photo file			
					$ret['message'] = $gp['id_gallery_photo'];
					$deleted = $this->delete_photo_file($gp['id_gallery_photo']);
				}
	}
}