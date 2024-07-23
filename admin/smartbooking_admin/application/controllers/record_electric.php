<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Record_electric extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'record';
		$this->load->library('../controllers/home');
    }

	public function record_electric_management()
	{
		if (!has_permission('record_electric_management', 'view')) {
			header("Location: ". home_url());
		}

		$d_from = $this->input->get('date_from');
	 	if($d_from == ''){
	 		$this->_data['date_from'] = '01-'.date('m-Y');
	 	}else{
			$this->_data['date_from'] = $d_from;
		}
	 	$d_to = $this->input->get('date_to');
	 	if($d_to == ''){
	 		$this->_data['date_to'] =  date('t-m-Y',strtotime('01-'.date('m-Y')));
	 	}else{
			$this->_data['date_to'] = $d_to;
		}
		$month = $this->input->get('month_select');
		$year = $this->input->get('year_selected');

		$this->_data['month'] = $month;
		$this->_data['year'] = $year;
		/////////////////////////////////////////////////////

		$this->db->select("er.*,el.meter_id,p.project_name_en,p.project_name_th,r.room_type_name_en,r.room_type_name_th,rd.room_name_en,rd.room_name_th,FORMAT(record_date, 'dd-MM-yyyy') AS record_date_f");
		$this->db->from('electric_record er');
		$this->db->join('electric_list el', 'el.id = er.electric_list_id','left');
		$this->db->join('project_info p', 'el.id_project_info = p.id_project_info','left');
		$this->db->join('room_type r', 'el.id_room_type = r.id_room_type','left');
		$this->db->join('room_details rd', 'el.id_room_details = rd.id_room_details','left');

		if($d_from != ''){
		$this->db->where('er.record_date >=',date('Y-m-d',strtotime($d_from)));
		}
		if($d_to != ''){
		$this->db->where('er.record_date <=',date('Y-m-d',strtotime($d_to)));
		}

		$electric_record = $this->db->get()->result_array();
		
		$run_id=1;
		foreach ($electric_record as $i => $r) {
			$electric_record[$i]['run_id'] = $run_id;
			$run_id++;
		}

		$this->_data['electric_record'] = $electric_record;

		$this->render();
		// $this->load->view('record_electric_management',$data);
	}

	public function save_record_electric()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');
		// $ret = [];

		if (isset($_POST['electric_info'])) {
			$electric_info = json_decode($_POST['electric_info'], true);

			// $id_electric = $electric_info['id'];
			// unset($electric_info['id']);

			if (isset($electric_info['id'])) {
			    unset($electric_info['id']);
			}

			$electric_info['electric_list_id'] = $_POST['meter_id'];
			$electric_info['current_unit'] = $electric_info['current_unit'];
			$electric_info['previous_unit'] = $_POST['previous_unit'];

			$date_parts = explode('-',$electric_info['record_date']);
			$mysql_date = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
			$electric_info['record_date'] = $mysql_date;
			// $ret['result'] = 'false';
	    	// $ret['message'] = $electric_info['record_date'];

			$this->db->where('type','electric');
		    $result = $this->db->get('setting_unit_rate')->result_array();
		    $ret['result'] = 'true';
			if (!empty($result)) {
			    $electric_info['unit_rate'] = $result[0]['unit_rate'];
			} else {
			    $electric_info['unit_rate'] = 0;
			}

			if($electric_info['ct']==''){
				$electric_info['ct'] = 0;
			}
			
			$electric_info['qty'] = $electric_info['current_unit']-$electric_info['previous_unit'];
			$electric_info['create_date'] = date('Y-m-d H:i:s');

			unset($electric_info['meter_id']);
			unset($electric_info['id_project_info']);
			unset($electric_info['id_room_type']);
			unset($electric_info['id_room_details']);

			$electric_info['update_date'] = date('Y-m-d H:i:s');

			try {
				$ret['result'] = 'true';
				// $ret['message'] = var_dump($electric_info);
				$this->db->insert('electric_record',$electric_info);
				// $ret['id_electric'] = $this->db->insert_id();
			} catch (Throwable $e) {
				$ret['result'] = 'false';
    			$ret['message'] = $e->getMessage();
    			echo json_encode($ret);
			}

			// }else{
			// 	$ret['message'] = 'No id';
        	// 	$ret['result'] = 'false';
				// unset($_POST['create_date']);

				// unset($_POST['meter_id']);
				// unset($_POST['id_project_info']);
				// unset($_POST['id_room_type']);
				// unset($_POST['id_room_details']);

				// $_POST['update_date'] = date('Y-m-d H:i:s');

				// $ret['id_electric'] = $id_electric;
				// $_POST['update_date'] = date('Y-m-d H:i:s');
				// $this->db->where('id', $id_electric);

				// try {
				// 	$this->db->update('electric_record',$_POST);
				// 	$ret['result'] = 'true';
				// } catch (Exception $e) {
				// 	$ret['result'] = 'false';
	    		// 	$ret['message'] = $e->getMessage();
				// }
				// $ret['result'] = 'true';
			// }

		} else {
        	$ret['message'] = 'Missing electric_info';
        	$ret['result'] = 'false';
    	}
    	
		echo json_encode($ret);
	}

	public function edit_record_electric_id($id = '')
	{

    header('Content-Type: application/json; charset=utf-8');
    $response = array('success' => false, 'message' => '');

    // รับข้อมูลจาก POST
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $current_unit = isset($_POST['current_unit']) ? intval($_POST['current_unit']) : 0;
    $previous_unit = isset($_POST['previous_unit']) ? intval($_POST['previous_unit']) : 0;
    $qty = isset($_POST['qty']) ? floatval($_POST['qty']) : 0;
    $unit_rate = isset($_POST['unit_rate']) ? floatval($_POST['unit_rate']) : 0;

    // ตรวจสอบข้อมูลที่รับมา
    if ($current_unit <= $previous_unit) {

        $response['message'] = 'Current unit must be greater than previous unit.';
    } else {
        // ดำเนินการที่ต้องการ เช่น บันทึกข้อมูลลงฐานข้อมูล
        // สมมติว่าเรามีฟังก์ชัน saveElectricRecord() ที่ทำการบันทึกข้อมูล
        // $saved = $this->saveElectricRecord($current_unit, $previous_unit, $qty, $unit_rate);

    	$value = $current_unit-$previous_unit;
    	$data = array(
            'current_unit' => $current_unit,
            'qty' => $value
        );
        $this->db->where('id', $id);
        $updated = $this->db->update('electric_record', $data);

        // ตรวจสอบว่าการบันทึกข้อมูลสำเร็จหรือไม่
        // if ($saved) {
            $response['success'] = true;
            $response['message'] = 'Data saved successfully.';
        // } else {
        //     $response['message'] = 'Failed to save data.';
        // }
    }

    echo json_encode($response);
	}


	public function edit_record_electric($id = '')
	{

		if (!has_permission('record_electric_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->select('er.*,el.meter_id,el.id_project_info,el.id_room_type,el.id_room_details');
		$this->db->where('er.id',$id);
		$this->db->from('electric_record er');
		$this->db->join('electric_list el', 'el.id = er.electric_list_id','left');
		$electric_info = $this->db->get()->result_array();

		if (count($electric_info) > 0) {
			$this->_data['electric_info'] = $electric_info[0];
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$this->db->where('id_project_info',$electric_info[0]['id_project_info']);
			$room_type = $this->db->get('room_type')->result_array();
			$this->_data['room_type'] = $room_type;

			$this->db->where('id_room_type',$electric_info[0]['id_room_type']);
			$room_details = $this->db->get('room_details')->result_array();
			$this->_data['room_details'] = $room_details;

			$this->db->where('id_room_type',$electric_info[0]['id_room_type']);
			$electric_list = $this->db->get('electric_list')->result_array();
			$this->_data['electric_list'] = $electric_list;

			$this->db->select('electric_record.electric_list_id, electric_record.record_date, electric_record.current_unit, electric_record.previous_unit');
		    $this->db->from('electric_record');
		    $this->db->join('(SELECT electric_list_id, MAX(record_date) as last_record_date FROM electric_record WHERE electric_list_id = ' .$this->db->escape($id). ' and record_date <= '.$this->db->escape($electric_info[0]['record_date']).' GROUP BY electric_list_id) max_id', 'electric_record.record_date = max_id.last_record_date AND electric_record.electric_list_id = max_id.electric_list_id');
		    $this->db->where('electric_record.electric_list_id',$id);
		    $electric_record_old = $this->db->get()->result_array();

		    $this->_data['lastRecordDate'] = $electric_record_old[0]['record_date'];

		    $this->_data['current_using'] = $electric_record_old[0]['current_unit'] - $electric_record_old[0]['previous_unit'];

		    $this->_data['previous_unit'] = $electric_record_old[0]['previous_unit'];
		    // $this->_data['lastRecordDate'] = $electric_record_old[0]['record_date'];
		    // $this->_data['lastRecordDate'] = $electric_record_old[0]['record_date'];
		    // AND record_date <='2024-05-01'
			// lastRecordDate: '-',
            // previous_unit: '',
            // current_using: ''

		}else{
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$fields = $this->db->list_fields('electric_record');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$this->_data['electric_info'] = $tmp;
		}

		$this->render();
	}

	public function get_electric_by_project($project_id) {
	    $this->db->where('id_project_info',$project_id);
	    $result = $this->db->get('room_type')->result_array();
	    echo json_encode($result);
	}

	public function get_record_electric_by_room_details($room_id) {
	    $this->db->where('id_room_type',$room_id);
	    $result = $this->db->get('room_details')->result_array();
	    echo json_encode($result);
	}

	public function get_record_electric_by_room_number($room_id) {
	    $this->db->where('id_room_details',$room_id);
	    $this->db->limit(1);
	    $result = $this->db->get('electric_list')->result_array();
	    echo json_encode($result);
	}

	public function get_record_electric_by_meter($electric_list_id) {
		$this->db->select('electric_list_id, MAX(record_date) as last_record_date');
	    $this->db->where('electric_list_id',$electric_list_id);
	    $this->db->group_by('electric_list_id');
	    $result = $this->db->get('electric_record')->result_array();

	    if (count($result) == 0) {
			$fields = $this->db->list_fields('electric_record');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$tmp[0]['last_record_date']='null';
			$result = $tmp;
		}

	    echo json_encode($result);
	}

	public function get_record_electric_by_meter_date($electric_list_id) {
		$this->db->select('electric_record.electric_list_id, electric_record.record_date, electric_record.current_unit, electric_record.previous_unit');
	    $this->db->from('electric_record');
	    $this->db->join('(SELECT electric_list_id, MAX(record_date) as last_record_date FROM electric_record WHERE electric_list_id = ' . $this->db->escape($electric_list_id) . ' GROUP BY electric_list_id) max_id', 'electric_record.record_date = max_id.last_record_date AND electric_record.electric_list_id = max_id.electric_list_id');
	    $this->db->where('electric_record.electric_list_id', $electric_list_id);
	    // $this->db->group_by('electric_list_id');
	    $result = $this->db->get()->result_array();

		if (count($result) == 0) {
			$fields = $this->db->list_fields('electric_record');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$tmp[0]['current_unit']='0';
			$result = $tmp;
		}

	    echo json_encode($result);
	}

	public function delete_electric()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		// check empty room type id
		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Electric ID';
			echo json_encode($ret);
			return;
		}

		$this->db->where('id', $_POST['id']);
		$this->db->delete('electric_record');

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function save_room_detail()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['room_detail']['id_room_details'])) {
			$this->db->where('id_room_type', $_POST['room_detail']['id_room_type']);
			$room_types = $this->db->get('room_type')->result_array();
			$room_type = $room_types[0];

			$_POST['room_detail']['room_type_name_en'] = $room_type['room_type_name_en'];
			$_POST['room_detail']['room_type_name_th'] = $room_type['room_type_name_th'];
			$_POST['room_detail']['date_created'] = date('Y-m-d H:i:s');

			$this->db->insert('room_details', $_POST['room_detail']);
		} else {
			$this->db->where('id_room_details', $_POST['room_detail']['id_room_details']);
			unset($_POST['room_detail']['id_room_details']);
			$this->db->update('room_details', $_POST['room_detail']);
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_room_detail()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Room Detail ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_room_details', $_POST['id']);
			$booking_room = $this->db->get('booking_room')->result_array();

			if (count($booking_room) > 0) {
				$ret['message'] = 'Can not delete, there are bookings of this room.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_room_details', $_POST['id']);
			$this->db->delete('room_details');
		}

		$ret['result'] = 'true';
		echo json_encode($ret);
	}
}