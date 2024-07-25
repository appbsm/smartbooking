<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Record_water extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'record';
		$this->load->library('../controllers/home');
    }

	public function record_water_management()
	{
		if (!has_permission('record_water_management', 'view')) {
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

		$selected_project = $this->input->get('project');
	    $selected_room_type = $this->input->get('room_type');
	    $selected_room_details = $this->input->get('room_details');

	    $fields = $this->db->list_fields('water_record');
		$tmp = array();
		foreach ($fields as $field) {
			$tmp[$field] = '';
		}
		$tmp[0]['current_unit']='0';
		$water_info = $tmp;

		$room_type_id = $this->input->get('room_type', true);
		$water_info['id_project_info'] = $selected_project;
		$water_info['id_room_type'] = $room_type_id;
		$water_info['id_room_details'] = $selected_room_details;

		$this->_data['water_info'] = $water_info;

		/////////////////////////////////////////////////////

		$this->db->select("er.*,el.meter_id,p.project_name_en,p.project_name_th,r.room_type_name_en,r.room_type_name_th,rd.room_name_en,rd.room_name_th,FORMAT(record_date, 'dd-MM-yyyy') AS record_date_f");
		$this->db->from('water_record er');
		$this->db->join('water_list el', 'el.id = er.water_list_id','left');
		$this->db->join('project_info p', 'el.id_project_info = p.id_project_info','left');
		$this->db->join('room_type r', 'el.id_room_type = r.id_room_type','left');
		$this->db->join('room_details rd', 'el.id_room_details = rd.id_room_details','left');

		if($d_from != ''){
		$this->db->where('er.record_date >=',date('Y-m-d',strtotime($d_from)));
		}
		if($d_to != ''){
		$this->db->where('er.record_date <=',date('Y-m-d',strtotime($d_to)));
		}

		if($selected_project != ''){
			$this->db->where('p.id_project_info =',$selected_project);
		}

		if($selected_room_type != ''){
			$this->db->where('r.id_room_type =',$selected_room_type);
		}
		if($selected_room_details != ''){
			$this->db->where('rd.id_room_details =',$selected_room_details);
		}

		$water_record = $this->db->get()->result_array();
		
		$run_id=1;
		foreach ($water_record as $i => $r) {
			$water_record[$i]['run_id'] = $run_id;
			$run_id++;
		}

		$this->_data['water_record'] = $water_record;

		/////////////// get dropdown
		$this->db->select('*');
		$this->db->from('project_info');
		$this->db->order_by('id_project_info', 'ASC');
		$this->db->limit(1);
		$project_info_first = $this->db->get()->result_array();

		
		if (count($project_info_first) > 0) {
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$this->db->where('id_project_info',$project_info_first[0]['id_project_info']);
			$room_type = $this->db->get('room_type')->result_array();
			$this->_data['room_type'] = $room_type;

			if ($selected_room_type) {
				// $this->db->where('id_room_type',$water_info[0]['id_room_type']);
				$this->db->where('id_room_type', $selected_room_type);
				$room_details = $this->db->get('room_details')->result_array();
				$this->_data['room_details'] = $room_details;
			}
		}

		$this->render();
		// $this->load->view('record_water_management',$data);
	}

	public function save_record_water()
	{	
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (isset($_POST['water_info'])) {
			$water_info = json_decode($_POST['water_info'], true);
			if (isset($water_info['id'])) {
			    unset($water_info['id']);
			}

			$water_info['water_list_id'] = $_POST['meter_id'];
			$water_info['current_unit'] = $water_info['current_unit'];
			$water_info['previous_unit'] = $_POST['previous_unit'];

			$date_parts = explode('-',$water_info['record_date']);
			$mysql_date = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
			$water_info['record_date'] = $mysql_date;
			$this->db->where('type','water');
		    $result = $this->db->get('setting_unit_rate')->result_array();
		    $ret['result'] = 'true';
			if (!empty($result)) {
			    $water_info['unit_rate'] = $result[0]['unit_rate'];
			} else {
			    $water_info['unit_rate'] = 0;
			}

			////////////////////////
			if (empty($water_info['ct'])) {
				$water_info['ct'] = 0;
			}
			
			$water_info['qty'] = $water_info['current_unit']-$water_info['previous_unit'];
			$water_info['create_date'] = date('Y-m-d H:i:s');

			unset($water_info['meter_id']);
			unset($water_info['id_project_info']);
			unset($water_info['id_room_type']);
			unset($water_info['id_room_details']);

			$water_info['update_date'] = date('Y-m-d H:i:s');

			try {
				$ret['result'] = 'true';
				$this->db->insert('water_record',$water_info);
			} catch (Throwable $e) {
				$ret['result'] = 'false';
    			$ret['message'] = $e->getMessage();
    			echo json_encode($ret);
			}
		} else {
        	$ret['message'] = 'Missing water_info';
        	$ret['result'] = 'false';
    	}
    	
		echo json_encode($ret);
	}

	public function edit_record_water_id($id = '')
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
        // สมมติว่าเรามีฟังก์ชัน savewaterRecord() ที่ทำการบันทึกข้อมูล
        // $saved = $this->savewaterRecord($current_unit, $previous_unit, $qty, $unit_rate);

    	$value = $current_unit-$previous_unit;
    	$data = array(
            'current_unit' => $current_unit,
            'qty' => $value
        );
        $this->db->where('id', $id);
        $updated = $this->db->update('water_record', $data);

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


	public function edit_record_water($id = '')
	{

		if (!has_permission('record_water_management', 'view')) {
			header("Location: ". home_url());
		}

		$this->db->select('er.*,el.meter_id,el.id_project_info,el.id_room_type,el.id_room_details');
		$this->db->where('er.id',$id);
		$this->db->from('water_record er');
		$this->db->join('water_list el', 'el.id = er.water_list_id','left');
		$water_info = $this->db->get()->result_array();

		if (count($water_info) > 0) {
			$this->_data['water_info'] = $water_info[0];
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$this->db->where('id_project_info',$water_info[0]['id_project_info']);
			$room_type = $this->db->get('room_type')->result_array();
			$this->_data['room_type'] = $room_type;

			$this->db->where('id_room_type',$water_info[0]['id_room_type']);
			$room_details = $this->db->get('room_details')->result_array();
			$this->_data['room_details'] = $room_details;

			$this->db->where('id_room_type',$water_info[0]['id_room_type']);
			$water_list = $this->db->get('water_list')->result_array();
			$this->_data['water_list'] = $water_list;

			$this->db->select('water_record.water_list_id, water_record.record_date, water_record.current_unit, water_record.previous_unit');
		    $this->db->from('water_record');
		    $this->db->join('(SELECT water_list_id, MAX(record_date) as last_record_date FROM water_record WHERE water_list_id = ' .$this->db->escape($id). ' and record_date <= '.$this->db->escape($water_info[0]['record_date']).' GROUP BY water_list_id) max_id', 'water_record.record_date = max_id.last_record_date AND water_record.water_list_id = max_id.water_list_id');
		    $this->db->where('water_record.water_list_id',$id);
		    $water_record_old = $this->db->get()->result_array();

		    $this->_data['lastRecordDate'] = $water_record_old[0]['record_date'];

		    $this->_data['current_using'] = $water_record_old[0]['current_unit'] - $water_record_old[0]['previous_unit'];

		    $this->_data['previous_unit'] = $water_record_old[0]['previous_unit'];
		    // $this->_data['lastRecordDate'] = $water_record_old[0]['record_date'];
		    // $this->_data['lastRecordDate'] = $water_record_old[0]['record_date'];
		    // AND record_date <='2024-05-01'
			// lastRecordDate: '-',
            // previous_unit: '',
            // current_using: ''

		}else{
			$project_info = $this->db->get('project_info')->result_array();
			$this->_data['project_info'] = $project_info;

			$fields = $this->db->list_fields('water_record');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$this->_data['water_info'] = $tmp;
		}

		$this->render();
	}

	public function get_water_by_project($project_id) {
	    $this->db->where('id_project_info',$project_id);
	    $result = $this->db->get('room_type')->result_array();
	    echo json_encode($result);
	}

	public function get_record_water_by_room_details($room_id) {
	    $this->db->where('id_room_type',$room_id);
	    $result = $this->db->get('room_details')->result_array();
	    echo json_encode($result);
	}

	public function get_record_water_by_room_number($room_id) {
	    $this->db->where('id_room_details',$room_id);
	    $this->db->limit(1);
	    $result = $this->db->get('water_list')->result_array();
	    echo json_encode($result);
	}

	public function get_record_water_by_meter($water_list_id) {
		$this->db->select('water_list_id, MAX(record_date) as last_record_date');
	    $this->db->where('water_list_id',$water_list_id);
	    $this->db->group_by('water_list_id');
	    $result = $this->db->get('water_record')->result_array();

	    if (count($result) == 0) {
			$fields = $this->db->list_fields('water_record');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$tmp[0]['last_record_date']='null';
			$result = $tmp;
		}

	    echo json_encode($result);
	}

	public function get_record_water_by_meter_date($water_list_id) {
		$this->db->select('water_record.water_list_id, water_record.record_date, water_record.current_unit, water_record.previous_unit');
	    $this->db->from('water_record');
	    $this->db->join('(SELECT water_list_id, MAX(record_date) as last_record_date FROM water_record WHERE water_list_id = ' . $this->db->escape($water_list_id) . ' GROUP BY water_list_id) max_id', 'water_record.record_date = max_id.last_record_date AND water_record.water_list_id = max_id.water_list_id');
	    $this->db->where('water_record.water_list_id', $water_list_id);
	    // $this->db->group_by('water_list_id');
	    $result = $this->db->get()->result_array();

		if (count($result) == 0) {
			$fields = $this->db->list_fields('water_record');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$tmp[0]['current_unit']='0';
			$result = $tmp;
		}

	    echo json_encode($result);
	}

	public function delete_water()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		// check empty room type id
		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty water ID';
			echo json_encode($ret);
			return;
		}

		$this->db->where('id', $_POST['id']);
		$this->db->delete('water_record');

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