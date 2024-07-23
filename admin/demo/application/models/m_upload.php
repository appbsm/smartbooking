<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class m_upload extends CI_Model{
	
	public $table = 'package';
	function upload_image ($data, $package_id) {

		//echo $package_id.$data;
		$this->db->where('id_package', $package_id);
		$this->db->update('package', $data);
		//echo $this->db->last_query();
	}
}