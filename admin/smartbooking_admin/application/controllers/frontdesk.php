<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontdesk extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'frontdesk';
		$this->load->library('../controllers/pos');
    }

	public function dashboard()
	{
		if (!has_permission('dashboard', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['days'] = 2;
		$this->_data['today'] = date('d/m/Y');
		$this->_data['tomorrow'] = date('d/m/Y', strtotime('tomorrow'));
		$this->_data['next_day'] = date('d/m/Y', strtotime('+'. $this->_data['days'] .' day'));

		$today = date('Y-m-d');
		$tomorrow = date('Y-m-d', strtotime('tomorrow'));
		$next_day = date('Y-m-d', strtotime('+'. $this->_data['days'] .' day'));

		// Daily Booking
		$this->db->where('CONVERT(VARCHAR(10), booking_date, 120) =', $today);
		$this->db->where_in('status', array('Booked', 'Verifying', 'Confirmed'));
		$booking = $this->db->get('booking')->result_array();

		$tmp = array();
		foreach ($booking as $i => $b) {
			$this->db->where('id_guest', $b['id_guest_info']);
			$guest = $this->db->get('guest_info')->row_array();
			$booking[$i]['guest_name'] = $guest['name'];

			if (!$this->pos->_is_expired($b)) {
				$tmp[] = $booking[$i];
			}
		}
		$this->_data['booking'] = $tmp;

		// Occupied
		$this->_data['occupied'] = array(
			'today' => $this->_getOccupiedByDate($today),
			'tomorrow' => $this->_getOccupiedByDate($tomorrow),
			'next_day' => $this->_getOccupiedByDate($next_day)
		);

		$this->render();
	}

	public function _getOccupiedByDate($date = '')
	{
		if (empty($date)) {
			$date = date('Y-m-d');
		}

		// Occupied & Available
		$rooms_count = 0;
		$rooms_occupied = 0;

		$this->db->where('active', 1);
		$rooms = $this->db->get('room_details')->result_array();

		foreach ($rooms as $i => $room) {
			$this->db->where('id_room_type', $room['id_room_type']);
			$room_type = $this->db->get('room_type')->row_array();
			if (empty($room_type['active'])) {
				continue;
			}
			$rooms_count++;

			$this->db->select('*')
					 ->from('booking_room')
					 ->join('booking', 'booking_room.booking_number = booking.booking_number')
					 ->where_not_in('booking.status', array('Checked-out', 'Cancel', 'Expired'))
					 ->where('booking_room.id_room_details', $room['id_room_details']);
			$booking_room = $this->db->get()->result_array();

			$occupied = false;
			foreach ($booking_room as $b) {
				if (!$this->pos->_is_expired($b) && $b['check_in_date'] <= $date && $date < $b['check_out_date']) {
					$occupied = true;
				}
			}

			if ($occupied) {
				$rooms_occupied++;
			}
		}

		// Arriving
		$this->db->where('status', 'Confirmed');
		$this->db->where('check_in_date', $date);
		$arriving = $this->db->get('booking')->result_array();

		foreach ($arriving as $i => $b) {
			$this->db->where('booking_number', $b['booking_number']);
			$booking_room = $this->db->get('booking_room')->result_array();

			$tmp = array();
			foreach ($booking_room as $br) {
				$tmp[] = $br['room_name_en'];
			}
			$arriving[$i]['room_number'] = implode(', ', $tmp);
		}

		// Checking Out
		$this->db->where('status', 'Checked-in');
		$this->db->where('check_out_date', $date);
		$checking_out = $this->db->get('booking')->result_array();

		foreach ($checking_out as $i => $b) {
			$this->db->where('booking_number', $b['booking_number']);
			$booking_room = $this->db->get('booking_room')->result_array();

			$tmp = array();
			foreach ($booking_room as $br) {
				$tmp[] = $br['room_name_en'];
			}
			$checking_out[$i]['room_number'] = implode(', ', $tmp);
		}

		//
		return array(
			'occupied' => floor($rooms_occupied / $rooms_count * 100),
			'available' => $rooms_count - $rooms_occupied,
			'arriving' => $arriving,
			'checking_out' => $checking_out
		);
	}

	public function getOccupiedByDate()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$ret['message'] = $this->_getOccupiedByDate($_POST['date']);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function calendar()
	{
		if (!has_permission('calendar', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['calendar'] = $this->_getCalendar();
		$this->render();
	}

	public function _getCalendar($date_from = '', $date_to = '', $booking_status = 'All')
	{
		if (empty($date_from)) {
			$start_date = date('Y-m-d');
		} else {
			$start_date = $date_from;
		}

		if (empty($date_to)) {
			$end_date = date('Y-m-d', strtotime('+6 day', strtotime($start_date)));
		} else {
			$end_date = $date_to;
		}

		//
		$dates = array();
		$d = $start_date;
		do {
			$dates[] = $d;
			$d = date('Y-m-d', strtotime('+1 day', strtotime($d)));
		} while ($d <= $end_date);

		// get room
		$room_data = array();
		$this->db->where('active', 1);
		$room_detail = $this->db->get('room_details')->result_array();

		foreach ($room_detail as $r) {
			$this->db->where('id_room_type', $r['id_room_type']);
			$room_type = $this->db->get('room_type')->row_array();

			if (empty($room_type['active'])) {
				continue;
			}

			$r['id_project_info'] = $room_type['id_project_info'];
			$r['room_type_name_en'] = $room_type['room_type_name_en'];
			$r['room_type_name_th'] = $room_type['room_type_name_th'];
			$r['booking'] = array();
			$room_data[$r['id_room_details']] = $r;
		}

		// get booking
		$this->db->select('*');
		$this->db->from('booking_room');
		$this->db->join('booking', 'booking_room.booking_number = booking.booking_number');
		$this->db->where_not_in('booking.status', array('Checked-out', 'Cancel', 'Expired'));
		$this->db->where('booking.check_out_date >=', $start_date);
		$this->db->where('booking.check_in_date <=', $end_date);
		$booking_room = $this->db->get()->result_array();

		foreach ($booking_room as $i => $b) {
			if ($this->pos->_is_expired($b)) {
				continue;
			}

			if ($b['check_out_date'] > $end_date) {
				$b['grid_length'] = dateDiff($b['check_in_date'], $end_date) + 0.53;
			} else {
				$b['grid_length'] = dateDiff($b['check_in_date'], $b['check_out_date']);
			}

			$b['grid_start'] = dateDiff($start_date, $b['check_in_date']);
			if ($b['check_in_date'] < $start_date) {
				$b['grid_length'] -= -0.525 - $b['grid_start'];
				$b['grid_start'] = -0.525;
			}

			if ($booking_status == 'All' || $booking_status == $b['status']) {
				if (!empty($room_data[$b['id_room_details']])) {
					$room_data[$b['id_room_details']]['booking'][] = $b;
				}
			}
		}

		// sort room booking
		$tmp = array();
		foreach ($room_data as $i => $r) {
			usort($room_data[$i]['booking'], function($a, $b) {
				return $a['check_in_date'] > $b['check_in_date'] ? 1 : 0;
			});
			$tmp[] = $room_data[$i];
		}
		$room_data = $tmp;

		return array(
			'start_date' => $start_date,
			'end_date' => $end_date,
			'dates' => $dates,
			'room_data' => $room_data
		);
	}

	public function getCalendar()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$range = empty($_POST['range']) ? 'Day' : $_POST['range'];
		$from_day = $_POST['from_day'];
		$to_day = $_POST['to_day'];
		$month = $_POST['month'];

		if ($range == 'Day') {
			if (empty($from_day) || empty($to_day)) {
				$start = date('Y-m-d');
				$end = date('Y-m-d');
			} else {
				$start = $from_day;
				$end = $to_day;
			}
		} else if ($range == 'Month') {
			if (empty($month)) {
				$start = date('Y-m-01');
				$end = date('Y-m-t');
			} else {
				$start = $month .'-01';
				$end = $month . date('-t', strtotime($start));
			}
		}

		$ret['message'] = $this->_getCalendar($start, $end, $_POST['booking_status']);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function reservations()
	{
		if (!has_permission('reservations', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['projects'] = $this->db->get('project_info')->result_array();
		$this->_data['rooms'] = $this->Room_details->getRooms();

		$first_project = $this->db->get('project_info')->row_array();
		$this->_data['reservations'] = $this->_getReservations('', $first_project['id_project_info']);

		$this->render();
	}

	public function _getReservations($booking_number = '', $project = 'All', $room = 'All', $status = 'All', $date_type = 'Booked', $date_from = '', $date_to = '')
	{
		$this->db->select('*');
		$this->db->select('user_mgt.name AS staff_name');
		$this->db->from('booking');
		$this->db->join('user_mgt', 'booking.staff_id = user_mgt.id_user', 'left');
		$this->db->join('discount', 'booking.id_discount_code = discount.id_discount', 'left');

		if (!empty($booking_number)) {
			$this->db->like('booking_number', $booking_number);
		}

		/////
		$date = date('Y-m-d');
		if (empty($date_from)) {
			$date_from = $date;
			$date_from_full = $date .' 00:00:00.000';
		} else {
			$date_from_full = $date_from .' 00:00:00.000';
		}
		if (empty($date_to)) {
			$date_to = $date;
			$date_to_full = $date .' 23:59:59.999';
		} else {
			$date_to_full = $date_to .' 23:59:59.999';
		}

		if ($date_type == 'Booked') {
			$this->db->where('booking_date >=', $date_from_full);
			$this->db->where('booking_date <=', $date_to_full);
		} else if ($date_type == 'Confirmed') {
			$this->db->where('transfer_date >=', $date_from);
			$this->db->where('transfer_date <=', $date_to);
		} else if ($date_type == 'Check-in') {
			$this->db->where('check_in_date >=', $date_from);
			$this->db->where('check_in_date <=', $date_to);
		} else if ($date_type == 'Check-out') {
			$this->db->where('check_out_date >=', $date_from);
			$this->db->where('check_out_date <=', $date_to);
		}

		$tmp = array();
		$booking = $this->db->get()->result_array();

		foreach ($booking as $i => $b) {
			if ($this->pos->_is_expired($b)) {
				$b['status'] = 'Expired';
			}

			if ($status == 'All' || $status == $b['status']) {
				$this->db->select('*')
						->from('booking_room')
						->join('room_details', 'booking_room.id_room_details = room_details.id_room_details')
						->join('room_type', 'room_details.id_room_type = room_type.id_room_type')
						->where('booking_room.booking_number', $b['booking_number']);
				$booking_room = $this->db->get()->result_array();

				$found = false;
				foreach ($booking_room as $br) {
					if (($project == 'All' || $project == $br['id_project_info']) && ($room == 'All' || $room == $br['id_room_details'])) {
						$found = true;
						break;
					}
				}

				if ($found) {
					$b['booking_room'] = $booking_room;
					$tmp[] = $b;
				}
			}
		}

		return $tmp;
	}

	public function getReservations()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$range = empty($_POST['range']) ? 'Day' : $_POST['range'];
		$from_day = $_POST['from_day'];
		$to_day = $_POST['to_day'];
		$month = $_POST['month'];

		if ($range == 'Day') {
			if (empty($from_day) || empty($to_day)) {
				$start = date('Y-m-d');
				$end = date('Y-m-d');
			} else {
				$start = $from_day;
				$end = $to_day;
			}
		} else if ($range == 'Month') {
			if (empty($month)) {
				$start = date('Y-m-01');
				$end = date('Y-m-t');
			} else {
				$start = $month .'-01';
				$end = $month . date('-t', strtotime($start));
			}
		}

		$ret['message'] = $this->_getReservations($_POST['booking_number'], $_POST['project'], $_POST['room'], $_POST['booking_status'], $_POST['date_type'], $start, $end);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function guest_booking()
	{
		if (!has_permission('guest_booking', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['guest_info'] = $this->_get_guest_booking();
		$this->render();
	}

	public function _get_guest_booking($id_guest_info = 0, $date_type = 'Booked', $date_from = '', $date_to = '')
	{
		$this->db->select('*');
		$this->db->from('booking_room');
		$this->db->join('room_details', 'booking_room.id_room_details = room_details.id_room_details');
		$this->db->join('booking', 'booking_room.booking_number = booking.booking_number');

		$date = date('Y-m-d');
		if (empty($date_from)) {
			$date_from = $date;
			$date_from_full = $date .' 00:00:00.000';
		} else {
			$date_from_full = $date_from .' 00:00:00.000';
		}
		if (empty($date_to)) {
			$date_to = $date;
			$date_to_full = $date .' 23:59:59.999';
		} else {
			$date_to_full = $date_to .' 23:59:59.999';
		}

		if ($date_type == 'Booked') {
			$this->db->where('booking.booking_date >=', $date_from_full);
			$this->db->where('booking.booking_date <=', $date_to_full);
		} else if ($date_type == 'Confirmed') {
			$this->db->where('booking.transfer_date >=', $date_from);
			$this->db->where('booking.transfer_date <=', $date_to);
		} else if ($date_type == 'Check-in') {
			$this->db->where('booking.check_in_date >=', $date_from);
			$this->db->where('booking.check_in_date <=', $date_to);
		} else if ($date_type == 'Check-out') {
			$this->db->where('booking.check_out_date >=', $date_from);
			$this->db->where('booking.check_out_date <=', $date_to);
		}

		if (!empty($id_guest_info)) {
			$this->db->where('booking.id_guest_info', $id_guest_info);
		}

		$this->db->order_by('booking.id_booking');
		$booking_room = $this->db->get()->result_array();

		foreach ($booking_room as $i => $b) {
			if ($this->pos->_is_expired($b)) {
				$booking_room[$i]['status'] = 'Expired';
			}
		}

		return $booking_room;
	}

	public function get_guest_booking()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$range = empty($_POST['range']) ? 'Day' : $_POST['range'];
		$from_day = $_POST['from_day'];
		$to_day = $_POST['to_day'];
		$month = $_POST['month'];

		if ($range == 'Day') {
			if (empty($from_day) || empty($to_day)) {
				$start = date('Y-m-d');
				$end = date('Y-m-d');
			} else {
				$start = $from_day;
				$end = $to_day;
			}
		} else if ($range == 'Month') {
			if (empty($month)) {
				$start = date('Y-m-01');
				$end = date('Y-m-t');
			} else {
				$start = $month .'-01';
				$end = $month . date('-t', strtotime($start));
			}
		}

		$ret['message'] = $this->_get_guest_booking($_POST['guest_id'], $_POST['date_type'], $start, $end);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function room_register()
	{
		if (!has_permission('room_register', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['projects'] = $this->db->get('project_info')->result_array();
		$this->_data['rooms'] = $this->Room_details->getRooms();

		$first_project = $this->db->get('project_info')->row_array();
		$this->_data['room_register'] = $this->_get_room_register($first_project['id_project_info']);

		$this->render();
	}

	public function _get_room_register($project = 'All', $room = 'All', $room_status = 'All', $booking_status = 'All', $show_only_last_booking = false)
	{
		// check room occupied
		$is_occupied = array();
		$room_details = $this->db->get('room_details')->result_array();
		foreach ($room_details as $r) {
			$is_occupied[$r['id_room_details']] = $this->_is_room_occupied($r['id_room_details']);
		}

		//
		$this->db->select('*');
		$this->db->select('room_type.active AS room_type_active');
		$this->db->select('room_details.active AS room_details_active');
		$this->db->from('booking_room');
		$this->db->join('booking', 'booking_room.booking_number = booking.booking_number');
		$this->db->join('room_details', 'booking_room.id_room_details = room_details.id_room_details');
		$this->db->join('room_type', 'room_details.id_room_type = room_type.id_room_type');

		if ($project != 'All') {
			$this->db->where('room_type.id_project_info', $project);
		}
		if ($room != 'All') {
			$this->db->where('room_details.id_room_details', $room);
		}
		$this->db->order_by('room_type.id_project_info, room_type.id_room_type, room_details.room_number, booking.booking_date DESC');

		$booking_room = $this->db->get()->result_array();
		$tmp = array();
		foreach ($booking_room as $b) {
			// check booking status
			if ($this->pos->_is_expired($b)) {
				$b['status'] = 'Expired';
			}

			if ($booking_status == 'All' || $booking_status == $b['status']) {
				// check room status
				$now = date('Y-m-d H:i:s');
				$b['room_status'] = 'Available';

				if (empty($b['room_type_active']) || empty($b['room_details_active'])) {
					$b['room_status'] = 'Blocked';
				} else if ($is_occupied[$b['id_room_details']]) {
					$b['room_status'] = 'Occupied';
				}

				if ($room_status == 'All' || $room_status == $b['room_status']) {
					if ($show_only_last_booking == 'true' && count($tmp) > 0 && $b['id_room_details'] == $tmp[count($tmp) - 1]['id_room_details']) {
						continue;
					}

					$tmp[] = $b;
				}
			}
		}

		return $tmp;
	}

	public function get_room_register()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$ret['message'] = $this->_get_room_register($_POST['project'], $_POST['room'], $_POST['room_status'], $_POST['booking_status'], $_POST['show_only_last_booking']);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function _is_room_occupied($id_room_details = '')
	{
		if (empty($id_room_details)) {
			return false;
		}
		$now = date('Y-m-d');

		$this->db->select('*');
		$this->db->from('booking_room');
		$this->db->join('booking', 'booking_room.booking_number = booking.booking_number');
		$this->db->where('booking_room.id_room_details', $id_room_details);
		$booking_room = $this->db->get()->result_array();

		foreach ($booking_room as $b) {
			if ($this->pos->_is_expired($b)) {
				$b['status'] = 'Expired';
			}

			if (!in_array($b['status'], array('Checked-out', 'Cancel', 'Expired')) && $b['check_out_date'] >= $now) {
				return true;
			}
		}

		return false;
	}
}