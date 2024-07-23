<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    function get_by_id($id = '')
    {
        if (empty($id)) {
            return array();
        }

        $exception = array(
            'guest_info'          => 'id_guest',
            'module_mgt'          => 'id_module',
            'point_of_interest'   => 'id_project_location',
            'project_facility'    => '',
            'project_highlights'  => 'id_highlights',
            'project_photos'      => 'id_project_photo',
            'role_mgt'            => 'id_role',
            'role_module'         => '',
            'room_type_amenities' => '',
            'user_mgt'            => 'id_user',
            'orders'              => 'id_order'
        );

        if (in_array($this->table, array_keys($exception))) {
            $id_column = $exception[$this->table];
        } else {
            $id_column = 'id_'. $this->table;
        }

        if (empty($id_column)) {
            return array();
        }

        $this->db->where($id_column, $id);
        return $this->db->get($this->table)->row_array();
    }

    function get_by_col($col = '', $val = '')
    {
        if (empty($col) || empty($val)) {
            return array();
        }

        $this->db->where($col, $val);
        return $this->db->get($this->table)->row_array();
    }

    function get_fields()
    {
        return $this->db->list_fields($this->table);
    }

    function get_blank_row()
    {
        $row = array();
        $fields = $this->get_fields();
        foreach ($fields as $f) {
            $row[$f] = '';
        }

        return $row;
    }
}