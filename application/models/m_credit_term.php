<?php
class M_credit_term extends CI_Model
{
	function get_credit_term($guest_id)
	{
		$result = array();
		$select = "select c.id_credit,c.credit_term from guest_info as gi left join credit as c on c.id_credit = gi.id_credit"
			. " where gi.id_guest= '" . $guest_id . "' ";
		$query = $this->db->query($select);
		if ($query->num_rows()) {
			$r = $query->result();
			$result = $r[0];
		}
		return $result;
	}
}
