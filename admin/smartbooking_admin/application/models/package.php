<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Package extends MY_Model {
    public $table = 'package';

    public function getPackage()
    {
        $this->db->select('p.*, pj.project_name_en, pj.project_name_th');
        $this->db->from('package p');
        $this->db->join('project_info pj', 'p.id_project_info = pj.id_project_info');
        $package = $this->db->get()->result_array();
       
        foreach ($package as $i => $p) {
            $this->db->select('pi.*, r.*');
            $this->db->from('package_item pi');
            $this->db->join('room_type r', 'pi.id_room_type = r.id_room_type', 'LEFT');
            $this->db->where('pi.id_package', $p['id_package']);

            $package[$i]['package_item'] = $this->db->get()->result_array();
            $package[$i]['package_photo'] = getImageUrl($package[$i]['package_photo_url']);
        }
        return $package;
    }
}