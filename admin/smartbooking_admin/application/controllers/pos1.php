<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pos extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->_data['active_menu'] = 'frontdesk';
	}

	public function guest()
	{
		if (!has_permission('guest', 'view')) {
			header("Location: " . home_url());
		}

		$guests = $this->db->get('guest_info')->result_array();
		foreach ($guests as $i => $guest) {
			$guests[$i]['photo_url'] = $guests[$i]['photo_url'] ? getImageUrl($guest['photo_url']) : '';
		}
		$this->_data['guests'] = $guests;

		$this->render();
	}

	public function edit_guest($id = '')
	{
		if (!has_permission('guest', 'view')) {
			header("Location: " . home_url());
		}

		///// Guest Info
		$this->db->where('id_guest', $id);
		$guests = $this->db->get('guest_info')->result_array();

		if (count($guests) > 0) {
			$guests[0]['photo_url'] = $guests[0]['photo_url'] ? getImageUrl($guests[0]['photo_url']) : '';
			$this->_data['guest'] = $guests[0];
		} else {
			$fields = $this->db->list_fields('guest_info');
			$tmp = array();
			foreach ($fields as $field) {
				$tmp[$field] = '';
			}
			$tmp['id_discount'] = '0';

			$this->_data['guest'] = $tmp;
		}

		///// Discount
		$discount = $this->db->get('discount')->result_array();
		$fields = $this->db->list_fields('discount');
		$tmp = array();
		foreach ($fields as $field) {
			if ($field != 'date_created') {
				$tmp[$field] = '';
			}
		}
		$tmp['id_discount'] = '0';
		array_unshift($discount, $tmp);
		$this->_data['discount'] = $discount;

		///// Credit - Added By Mychelle
		$credit = $this->db->get('credit')->result_array();
		$fields = $this->db->list_fields('credit');
		$tmp = array();
		foreach ($fields as $field) {
			if ($field != 'date_created') {
				$tmp[$field] = '';
			}
		}
		$tmp['id_credit'] = '0';
		array_unshift($credit, $tmp);
		$this->_data['credit'] = $credit;

		$this->render();
	}

	public function save_guest()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('email', $_POST['email']);
		if (!empty($_POST['id_guest'])) {
			$this->db->where('id_guest !=', $_POST['id_guest']);
		}
		$check_guests = $this->db->get('guest_info')->result_array();
		if (count($check_guests) > 0) {
			$ret['message'] = 'This email was used.';
			echo json_encode($ret);
			return;
		}

		$this->db->where('username', $_POST['username']);
		if (!empty($_POST['id_guest'])) {
			$this->db->where('id_guest !=', $_POST['id_guest']);
		}
		$check_guests = $this->db->get('guest_info')->result_array();
		if (count($check_guests) > 0) {
			$ret['message'] = 'This username was used.';
			echo json_encode($ret);
			return;
		}

		/////
		$photo_url = $_POST['photo_url'];
		unset($_POST['photo_url']);
		if (empty($_POST['id_guest'])) {
			$_POST['date_created'] = date('Y-m-d H:i:s');
			$_POST['password'] = useMD5($_POST['password']);
			unset($_POST['id_guest']);

			$this->db->insert('guest_info', $_POST);
			$ret['message'] = $this->db->insert_id();
		} else {
			$id_guest = $_POST['id_guest'];
			unset($_POST['id_guest']);

			$this->db->where('id_guest', $id_guest);
			$this->db->update('guest_info', $_POST);
			$ret['message'] = $id_guest;
		}

		$_POST['photo_url'] = _upload('guest_photo', $photo_url, $ret['message']);
		if ($_POST['photo_url'] == '-') {
			$ret['message'] = 'Invalid Image File Type.';
			echo json_encode($ret);
			return;
		}

		$this->db->where('id_guest', $ret['message']);
		$this->db->update('guest_info', array('photo_url' => $_POST['photo_url']));

		// Check Unlink Deleted Image
		$this->load->library('../controllers/home');
		$this->home->check_deleted_image(false, 'guest_photo', $ret['message']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_guest()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Guest ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_guest_info', $_POST['id']);
			$booking = $this->db->get('booking')->result_array();

			if (count($booking) > 0) {
				$ret['message'] = 'Can not delete, there are bookings of this guest.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_guest', $_POST['id']);
			$this->db->delete('guest_info');
		}

		// Check Unlink Deleted Image
		$this->load->library('../controllers/home');
		$this->home->check_deleted_image(false, 'guest_photo', $_POST['id']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function search_guest()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$q = $_POST['query'];
		$this->db->like("CONCAT(firstname, ' ', lastname)", $q);
		$this->db->or_like('contact_number', $q);
		$this->db->or_like('email', $q);
		$this->db->or_like('username', $q);
		$result = $this->db->get('guest_info')->result_array();

		$now = date('Y-m-d');
		$tmp = array();
		foreach ($result as $i => $r) {
			// discount
			$result[$i]['id_discount'] = '';
			$result[$i]['discount_code'] = '';
			$result[$i]['id_credit'] = '';
			$result[$i]['credit_description'] = '';
			$result[$i]['credit_term'] = 0;

			$this->db->where('id_discount', $r['id_discount']);
			$discount = $this->db->get('discount')->result_array();
			if (count($discount) > 0 && $discount[0]['start_date_booking'] <= $now && $now <= $discount[0]['end_date_booking']) {
				$result[$i]['id_discount'] = $discount[0]['id_discount'];
				$result[$i]['discount_code'] = $discount[0]['code'];
			}
			
			if ($r['id_credit'] != '') {
				$this->db->where('id_credit', $r['id_credit']);
				$credit = $this->db->get('credit')->result_array();
				if (count($credit) > 0) {
					$result[$i]['id_credit'] = $credit[0]['id_credit'];
					$result[$i]['credit_term'] = $credit[0]['credit_term'];
					$result[$i]['credit_description'] = $credit[0]['credit_description'];
				}
			}

			// bookings
			$this->db->where('id_guest_info', $r['id_guest']);
			$this->db->where_not_in('status', array('Cancel', 'Expired'));
			$result[$i]['bookings'] = $this->db->get('booking')->result_array();

			//
			$result[$i]['photo_url'] = $r['photo_url'] ? getImageUrl($r['photo_url']) : (site_url() . 'asset/image/user.jpg');
			if (!empty($r['is_active'])) {
				$tmp[] = $result[$i];
			}
		}

		$ret['message'] = $tmp;
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function booking()
	{
		if (!has_permission('booking', 'view')) {
			header("Location: " . home_url());
		}

		$this->_data['projects'] = $this->db->get('project_info')->result_array();
		$this->_data['rooms'] = $this->Room_details->getRooms();

		$first_project = $this->db->get('project_info')->row_array();
		$this->_data['booking'] = $this->_getBooking(0, $first_project['id_project_info']);

		$this->render();
	}

	public function _getBooking($id_guest_info = 0, $project = 'All', $room = 'All', $booking_number = '', $booking_status = 'All', $date_type = 'Booked', $date_from = '', $date_to = '')
	{
		if (!empty($booking_number)) {
			$this->db->like('booking_number', trim($booking_number));
		}
		if (!empty($id_guest_info)) {
			$this->db->where('id_guest_info', $id_guest_info);
		}
		if ($booking_status !== 'All') {
			$this->db->where('status', $booking_status);
		}

		$date = date('Y-m-d');
		if (empty($date_from)) {
			$date_from = $date;
			$date_from_full = $date . ' 00:00:00.000';
		} else {
			$date_from_full = $date_from . ' 00:00:00.000';
		}
		if (empty($date_to)) {
			$date_to = $date;
			$date_to_full = $date . ' 23:59:59.999';
		} else {
			$date_to_full = $date_to . ' 23:59:59.999';
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

		$booking = $this->db->get('booking')->result_array();

		$tmp_booking = array();
		foreach ($booking as $i => $b) {
			$booking[$i]['booking_date'] = date('Y-m-d', strtotime($b['booking_date']));

			$this->db->where('id_guest', $b['id_guest_info']);
			$guest = $this->db->get('guest_info')->row_array();
			$booking[$i]['guest_name'] = $guest['name'];

			if ($this->_is_expired($b)) {
				$booking[$i]['status'] = 'Expired';
			}

			$this->db->select('*');
			$this->db->from('booking_room');
			if ($project != 'All') {
				$this->db->join('room_details', 'booking_room.id_room_details = room_details.id_room_details');
				$this->db->join('room_type', 'room_details.id_room_type = room_type.id_room_type');
			}
			$this->db->where('booking_number', $b['booking_number']);
			$booking_room = $this->db->get()->result_array();

			$found = true;
			if ($project != 'All') {
				$found = false;
				foreach ($booking_room as $br) {
					if ($br['id_project_info'] == $project) {
						$found = true;
						break;
					}
				}
			}
			if ($room != 'All') {
				$found = false;
				foreach ($booking_room as $br) {
					if ($br['id_room_details'] == $room) {
						$found = true;
						break;
					}
				}
			}

			if ($found) {
				// Get Booking Payments
				$this->db->select('*');
				$this->db->from('booking_payment');
				$this->db->where('id_booking', $b['id_booking']);
				$booking_payment = $this->db->get()->result_array();
				foreach ($booking_payment as $j => $p) {
					$booking_payment[$j]['transfer_slip'] = getImageUrl($p['transfer_slip']);
				}
				$booking[$i]['booking_payment'] = $booking_payment;

				$tmp_booking[] = $booking[$i];
			}
		}

		return $tmp_booking;
	}

	public function getBooking()
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
				$start = $month . '-01';
				$end = $month . date('-t', strtotime($start));
			}
		}

		$ret['message'] = $this->_getBooking($_POST['guest_id'], $_POST['project'], $_POST['room'], $_POST['booking_number'], $_POST['booking_status'], $_POST['date_type'], $start, $end);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_booking()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Booking ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_extras >', 0);
			$this->db->where('id_booking', $_POST['id']);
			$booking_extra = $this->db->get('booking_item')->result_array();

			if (count($booking_extra) > 0) {
				$ret['message'] = 'Can not delete, delete all booking_extras first.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_booking', $_POST['id']);
			$booking_payment = $this->db->get('booking_payment')->result_array();

			if (count($booking_payment) > 0) {
				$ret['message'] = 'Can not delete, delete all booking_payment first.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_booking', $_POST['id']);
			$booking = $this->db->get('booking')->row_array();
			$this->db->where('booking_number', $booking['booking_number']);
			$this->db->delete('booking_room');

			$this->db->where('id_booking', $_POST['id']);
			$this->db->delete('booking_item');

			$this->db->where('id_booking', $_POST['id']);
			$this->db->delete('booking');
		}

		// Check Unlink Deleted Image
		$this->load->library('../controllers/home');
		$this->home->check_deleted_image(false, 'transfer_slip', $_POST['id']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function edit_booking($id = '')
	{
		if (!has_permission('booking', 'view')) {
			header("Location: " . home_url());
		}

		///// Booking Info
		$this->db->where('id_booking', $id);
		$booking = $this->db->get('booking')->result_array();

		if (count($booking) > 0) {
			$tmp = $booking[0];
			$this->db->where('id_guest', $tmp['id_guest_info']);
			$guest = $this->db->get('guest_info')->row_array();
			$tmp['guest_name'] = $guest['name'];
			$this->_data['booking_info'] = $tmp;

			///// Booking items
			$this->db->where('id_booking', $id);
			$booking_item = $this->db->get('booking_item')->result_array();

			///// Booking Payments
			$this->db->where('booking_number', $tmp['booking_number']);
			$this->_data['booking_payment'] = $this->db->get('booking_payment')->result_array();
			foreach ($this->_data['booking_payment'] as $i => $p) {
				$this->_data['booking_payment'][$i]['transfer_slip'] = getImageUrl($p['transfer_slip']);
			}

		} else {
			$fields = $this->db->list_fields('booking');
			$tmp = array();
			foreach ($fields as $field) {
				if (!in_array($field, array('is_backend', 'staff_id'))) {
					$tmp[$field] = '';
				}
			}
			$tmp['booking_date'] = date('Y-m-d H:i:s');
			$tmp['status'] = 'Booked';
			$tmp['guest_name'] = '';

			if (!empty($_GET['check-in-date'])) {
				$tmp['check_in_date'] = $_GET['check-in-date'];
			} else {
				$tmp['check_in_date'] = date('Y-m-d');
			}

			if (!empty($_GET['check-out-date'])) {
				$tmp['check_out_date'] = $_GET['check-out-date'];
			} else {
				$tmp['check_out_date'] = date('Y-m-d', strtotime('+1 day', strtotime($tmp['check_in_date'])));
			}

			$this->_data['booking_info'] = $tmp;
			$this->_data['booking_payment'] = array();
			$booking_item = array();
		}

		$this->_data['booking_payment_blank_row'] = $this->Booking_payment->get_blank_row();
		$this->_data['booking_payment_blank_row']['id_booking_payment'] = 0;
		$this->_data['booking_payment_blank_row']['id_booking'] = $tmp['id_booking'];
		$this->_data['booking_payment_blank_row']['booking_number'] = $tmp['booking_number'];

		// booking item dates
		foreach ($booking_item as $i => $bi) {
			$this->db->where('id_booking_item', $bi['id_booking_item']);
			$booking_item_dates = $this->db->get('booking_item_date')->result_array();
			$booking_item[$i]['dates'] = array_col($booking_item_dates, 'date');
		}
		$this->_data['booking_item'] = $booking_item;

		///// Rooms
		$rooms = array();
		$projects = $this->db->get('project_info')->result_array();

		foreach ($projects as $project) {
			$this->db->where('id_project_info', $project['id_project_info']);
			$this->db->order_by('display_sequence');
			$room_types = $this->db->get('room_type')->result_array();

			foreach ($room_types as $room_type) {
				$this->db->where('id_room_type', $room_type['id_room_type']);
				$this->db->order_by('room_number');
				$room_details = $this->db->get('room_details')->result_array();

				foreach ($room_details as $room_detail) {
					$tmp = $room_detail;
					$tmp['id_project_info'] = $project['id_project_info'];
					$tmp['project_name_en'] = $project['project_name_en'];
					$tmp['project_name_th'] = $project['project_name_th'];
					$tmp['number_of_adults'] = $room_type['number_of_adults'];
					$tmp['number_of_children'] = $room_type['number_of_children'];
					$tmp['max_children_age'] = $room_type['max_children_age'];
					$tmp['display_sequence'] = $room_type['display_sequence'];
					$tmp['is_big_room'] = $room_type['is_big_room'];
					$tmp['is_selected'] = 0;
					$tmp['active'] = !empty($room_type['active']) && !empty($room_detail['active']) ? 1 : 0;

					$rooms[$tmp['id_room_details']] = $tmp;
				}
			}
		}

		// select room
		$this->db->where('booking_number', $this->_data['booking_info']['booking_number']);
		$booking_room = $this->db->get('booking_room')->result_array();

		foreach ($booking_room as $br) {
			if (empty($br['id_package'])) {
				$rooms[$br['id_room_details']]['is_selected'] = 1;
			}
		}

		foreach ($rooms as $i => $r) {
			if (empty($r['active']) && empty($r['is_selected'])) {
				unset($rooms[$i]);
			} else {
				$rooms[$i]['first_select'] = $r['is_selected'] ? 1 : 0;
			}
		}

		if (count($booking) == 0 && !empty($_GET['room'])) {
			$get_rooms = explode(',', $_GET['room']);
			foreach ($get_rooms as $get_room) {
				$rooms[$get_room]['is_selected'] = 1;
			}
		}
		$this->_data['rooms'] = $rooms;

		///// Extra
		$this->db->where('active', 1);
		$this->_data['extras'] = $this->db->get('extras')->result_array();
		// select extra
		$this->db->where('id_booking', $id);
		$this->db->where('id_extras >', 0);
		$items = $this->db->get('booking_item')->result_array();
		$tmp1 = array();
		$tmp2 = array();

		$extra_price = array();
		foreach ($this->_data['extras'] as $e) {
			$tmp1[$e['id_extras']] = 0;
			$tmp2[$e['id_extras']] = 0;
			$extra_price[$e['id_extras']] = $e['price'];
		}

		foreach ($items as $item) {
			$tmp1[$item['id_extras']] = $item;
			$tmp2[$item['id_extras']] = $item['quantity'];
		}

		$this->_data['select_extra'] = $tmp1;
		$this->_data['select_extra_qty'] = $tmp2;

		// Package
		$package = $this->Package->getPackage();
		$packages = array();

		$this->db->where('booking_number', $this->_data['booking_info']['booking_number']);
		$booking_item = $this->db->get('booking_item')->result_array();

		foreach ($package as $i => $p) {
			$package[$i]['qty'] = 0;
			$package[$i]['is_selected'] = 0;
			$package[$i]['origin_price'] = $p['price'];

			foreach ($booking_item as $bi) {
				if ($bi['id_package'] == $p['id_package']) {
					$package[$i]['price'] = $bi['full_package_price'];
				}
			}
			$packages[$p['id_package']] = $package[$i];
		}

		// select package
		foreach ($booking_item as $bi) {
			if (!empty($bi['id_package'])) {
				$packages[$bi['id_package']]['package_qty'] = $bi['package_qty'];
				$packages[$bi['id_package']]['is_selected'] = 1;
			}
		}

		foreach ($packages as $i => $p) {
			if (empty($p['is_active']) && empty($p['is_selected'])) {
				unset($packages[$i]);
			}
		}
		$this->_data['packages'] = $packages;

		///// Credit - Added By Mychelle
		$this->db->order_by('credit_term', 'ASC');
		$credit = $this->db->get('credit')->result_array();
		$fields = $this->db->list_fields('credit');		
		$this->_data['credit'] = $credit;
		

		$this->render();
	}

	public function _is_expired($booking = array())
	{
		if (empty($booking['status']) || empty($booking['booking_date'])) {
			return false;
		}

		$now = date('Y-m-d H:i:s');
		if ($booking['status'] == 'Expired' || ($booking['status'] == 'Booked' && hourDiff($booking['booking_date'], $now) >= 2)) {
			return true;
		}

		return false;
	}

	public function _is_expired_order($order = array())
	{
		if (empty($order['status']) || empty($order['date_created'])) {
			return false;
		}

		$now = date('Y-m-d H:i:s');
		if ($order['status'] == 'Expired' || ($order['status'] == 'Ordered' && hourDiff($order['date_created'], $now) >= 2)) {
			return true;
		}

		return false;
	}

	// Calculate Booking Price
	public function _calculate_booking_price($booking = '', $booking_item = array(), $rooms = array(), $packages = array(), $extras = array())
	{
		$ret = array('sub_total' => 0, 'vat' => 0, 'grand_total' => 0, 'discounted_amount' => 0, 'booking_item' => array());
		if (empty($booking)) {
			return $ret;
		}

		// dates
		$start_date = $booking['check_in_date'];
		$end_date = $booking['check_out_date'];
		if ($start_date >= $end_date) {
			return $ret;
		}

		$dates = array();
		$date = $start_date;
		do {
			$dates[] = $date;
			$date = date('Y-m-d', strtotime($date . '+1 days'));
		} while ($date < $end_date);

		// room price
		$old_booking = empty($booking['id_booking']) ? array() : $this->Booking->get_by_id($booking['id_booking']);
		$tmp_rooms = array();
		foreach ($rooms as $room) {
			if (isset($room['is_selected']) && $room['is_selected'] == 0) {
				continue;
			}
			$tmp_rooms[] = $room;

			if (!empty($old_booking) && $booking['check_in_date'] == $old_booking['check_in_date'] && $booking['check_out_date'] == $old_booking['check_out_date'] && $room['first_select']) {
				$found = false;
				if (!empty($booking_item)) {
					foreach ($booking_item as $bi) {
						if (empty($bi['id_package']) && !empty($bi['id_room_details']) && $bi['id_room_details'] == $room['id_room_details']) {
							$found = true;
							$ret['grand_total'] += $bi['full_unit_cost'] * $bi['quantity'];
							$ret['booking_item'][] = array(
								'id_booking' => $bi['id_booking'],
								'item_name' => $bi['item_name'],
								'quantity' => $bi['quantity'],
								'unit_cost' => $bi['full_unit_cost'],
								'discount' => 0,
								'full_unit_cost' => $bi['full_unit_cost'],
								'id_extras' => '',
								'id_room_details' => $bi['id_room_details'],
								'dates' => $bi['dates']
							);
						}
					}
				}

				if ($found) {
					continue;
				}
			}

			$this->db->where('id_room_details', $room['id_room_details']);
			$room_detail = $this->db->get('room_details')->row_array();

			$this->db->where('id_room_type', $room_detail['id_room_type']);
			$room_type = $this->db->get('room_type')->row_array();

			$start_date = $booking['check_in_date'];
			$end_date = $booking['check_out_date'];
			$date = $start_date;

			// Seasonal Price
			$this->db->where('id_room_type', $room_detail['id_room_type']);
			$this->db->order_by('is_priority ^ 1');
			$seasonal_prices = $this->db->get('seasonal_price')->result_array();
			do {
				$found = false;
				foreach ($seasonal_prices as $seasonal_price) {
					$d = strtolower(date('D', strtotime($date)));

					if ($seasonal_price['start_date'] <= $date && $date <= $seasonal_price['end_date']) {
						$used_price = empty($seasonal_price[$d . '_rate']) ? $seasonal_price['rate'] : $seasonal_price[$d . '_rate'];
						$found = true;
						break;

						// check season repeat
					} elseif (!empty($seasonal_price['season_repeat']) && $seasonal_price['start_date'] <= $date) {
						$year = date('Y', strtotime($date));
						$start_date_repeat = $year . date('-m-d', strtotime($seasonal_price['start_date']));
						$end_date_repeat = $year . date('-m-d', strtotime($seasonal_price['end_date']));
						if ($end_date_repeat < $start_date_repeat) {
							$end_date_repeat = (intval($year) + 1) . date('-m-d', strtotime($seasonal_price['end_date']));
						}

						if ($start_date_repeat <= $date && $date <= $end_date_repeat) {
							$used_price = empty($seasonal_price[$d . '_rate']) ? $seasonal_price['rate'] : $seasonal_price[$d . '_rate'];
							$found = true;
							break;
						} else {
							$year = intval($year) - 1;
							$start_date_repeat2 = $year . date('-m-d', strtotime($seasonal_price['start_date']));
							$end_date_repeat2 = $year . date('-m-d', strtotime($seasonal_price['end_date']));
							if ($end_date_repeat2 < $start_date_repeat2) {
								$end_date_repeat2 = (intval($year) + 1) . date('-m-d', strtotime($seasonal_price['end_date']));
							}

							if ($seasonal_price['start_date'] <= $start_date_repeat2 && $start_date_repeat2 <= $date && $date <= $end_date_repeat2) {
								$used_price = empty($seasonal_price[$d . '_rate']) ? $seasonal_price['rate'] : $seasonal_price[$d . '_rate'];
								$found = true;
								break;
							}
						}
					}
				}

				if (!$found) {
					$used_price = $room_type['default_rate'];
				}
				$ret['grand_total'] += $used_price;

				$found_repeat = false;
				foreach ($ret['booking_item'] as $i => $booking_item) {
					if ($booking_item['id_room_details'] == $room['id_room_details'] && $booking_item['unit_cost'] == $used_price) {
						$ret['booking_item'][$i]['quantity']++;
						$ret['booking_item'][$i]['dates'][] = $date;
						$found_repeat = true;
						break;
					}
				}

				if (!$found_repeat) {
					$ret['booking_item'][] = array(
						'id_booking' => $booking['id_booking'],
						'item_name' => $room['room_type_name_en'],
						'quantity' => 1,
						'unit_cost' => $used_price,
						'discount' => 0,
						'full_unit_cost' => $used_price,
						'id_extras' => '',
						'id_room_details' => $room['id_room_details'],
						'dates' => array($date)
					);
				}

				$date = date('Y-m-d', strtotime($date . '+1 days'));
			} while ($date < $end_date);
		}

		// package
		foreach ($packages as $package) {
			if (isset($package['is_selected']) && $package['is_selected'] == 0) {
				continue;
			}

			$ret['grand_total'] += $package['price'] * $package['package_qty'] * dateDiff($booking['check_in_date'], $booking['check_out_date']);

			$total_package_item_price = 0;
			foreach ($package['package_item'] as $pi) {
				$total_package_item_price += $pi['default_rate'] * $pi['qty'];
			}
			foreach ($package['package_item'] as $i => $pi) {
				$package['package_item'][$i]['unit_cost'] = round($pi['default_rate'] * $package['price'] / $total_package_item_price, 6);
			}

			for ($i = 0; $i < $package['package_qty']; $i++) {
				foreach ($package['package_item'] as $pi) {
					for ($j = 0; $j < $pi['qty']; $j++) {
						$this->db->select('*');
						$this->db->from('room_details rd');
						$this->db->join('room_type rt', 'rd.id_room_type = rt.id_room_type');
						$this->db->where('rt.id_room_type', $pi['id_room_type']);
						$this->db->where('rd.active', 1);
						$this->db->where('rt.active', 1);
						$this->db->where("rd.id_room_details NOT IN ("
							. "SELECT br.id_room_details "
							. "FROM booking b "
							. "LEFT JOIN booking_room br ON b.booking_number = br.booking_number "
							. "WHERE b.check_in_date < '" . $booking['check_out_date'] . "' "
							. "AND b.check_out_date > '" . $booking['check_in_date'] . "' "
							. "AND b.status NOT IN ('Checked-out', 'Cancel', 'Expired') "
							. "AND b.id_booking !='" . $booking['id_booking'] . "' "
							. ")");

						if (!empty($tmp_rooms)) {
							$this->db->where_not_in('rd.id_room_details', array_col($tmp_rooms, 'id_room_details'));
						}

						$room_details = $this->db->get()->result_array();
						if (count($room_details) > 0) {
							$room_detail = $room_details[0];

							$found_repeat = false;
							foreach ($ret['booking_item'] as $k => $booking_item) {
								if ($booking_item['id_room_details'] == $room_detail['id_room_details'] && $booking_item['unit_cost'] == $pi['unit_cost'] && $booking_item['id_package'] == $package['id_package']) {
									$ret['booking_item'][$k]['quantity']++;
									$ret['booking_item'][$k]['dates'] = $dates;
									$found_repeat = true;
									break;
								}
							}

							if (!$found_repeat) {
								$ret['booking_item'][] = array(
									'id_booking' => $booking['id_booking'],
									'item_name' => $pi['room_type_name_en'],
									'quantity' => dateDiff($booking['check_in_date'], $booking['check_out_date']),
									'unit_cost' => $pi['unit_cost'],
									'discount' => 0,
									'full_unit_cost' => $pi['unit_cost'],
									'id_extras' => '',
									'id_room_details' => $room_detail['id_room_details'],
									'dates' => $dates,
									'id_package' => $package['id_package'],
									'package_qty' => $package['package_qty'],
									'package_name' => $package['name'],
									'package_price' => $package['price'],
									'full_package_price' => $package['price']
								);
							}
						}
					}
				}
			}
		}

		// extra
		foreach ($extras as $extra) {
			if (!empty($extra['quantity']) && intval($extra['quantity']) > 0) {
				$ret['grand_total'] += intval($extra['quantity']) * floatval($extra['full_unit_cost']);
				$ret['booking_item'][] = array(
					'id_booking' => $booking['id_booking'],
					'item_name' => $extra['item_name'],
					'quantity' => intval($extra['quantity']),
					'unit_cost' => $extra['full_unit_cost'],
					'discount' => 0,
					'full_unit_cost' => $extra['full_unit_cost'],
					'id_extras' => $extra['id_extras'],
					'dates' => array($booking['check_in_date'])
				);
			}
		}

		// coupon discount
		if (!empty($booking['discount_code'])) {
			$this->db->where('code', $booking['discount_code']);
			$this->db->order_by('id_discount', 'DESC');
			$discounts = $this->db->get('discount');

			if ($discounts->num_rows() > 0) {
				$discount = $discounts->row_array();
				$old_booking = !empty($booking['id_booking']) ? $this->Booking->get_by_id($booking['id_booking']) : array();
				$now = date('Y-m-d');

				if ((!empty($booking['id_booking']) || ($discount['start_date_booking'] <= $now && $now <= $discount['end_date_booking'])) && $discount['start_date_check_in'] <= $booking['check_in_date'] && $booking['check_in_date'] <= $discount['end_date_check_in']) {
					if (!empty($old_booking['id_discount_code']) && $old_booking['id_discount_code'] == $discount['id_discount']) {
						$discounted_amount = $old_booking['discount_type'] == 'percent' ? floor($ret['grand_total'] * $old_booking['discount_value'] / 100) : $old_booking['discount_value'];
					} else {
						$discounted_amount = $discount['discount_type'] == 'percent' ? floor($ret['grand_total'] * $discount['discount_value'] / 100) : $discount['discount_value'];
					}

					$old_grand_total = $ret['grand_total'];
					if ($ret['grand_total'] >= $discounted_amount) {
						$ret['discounted_amount'] = $discounted_amount;
						$ret['grand_total'] -= $discounted_amount;
					} else {
						$ret['discounted_amount'] = $ret['grand_total'];
						$ret['grand_total'] = 0;
					}

					foreach ($ret['booking_item'] as $i => $booking_item) {
						$ret['booking_item'][$i]['unit_cost'] = round($ret['booking_item'][$i]['unit_cost'] * $ret['grand_total'] / $old_grand_total, 6);
						$ret['booking_item'][$i]['discount'] = round($ret['booking_item'][$i]['full_unit_cost'] - $ret['booking_item'][$i]['unit_cost'], 6);

						if (!empty($ret['booking_item'][$i]['full_package_price'])) {
							$ret['booking_item'][$i]['package_price'] = round($ret['booking_item'][$i]['full_package_price'] * $ret['grand_total'] / $old_grand_total, 6);
						}
					}
				}
			}
		}

		// cal vat
		$ret['vat'] = round($ret['grand_total'] * 7 / 107, 2);
		$ret['sub_total'] = round($ret['grand_total'] - $ret['vat'], 2);
		return $ret;
	}

	public function calculate_booking_price()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['booking'])) {
			$ret['message'] = 'Empty Booking Info';
			echo json_encode($ret);
			return;
		}

		$ret['message'] = $this->_calculate_booking_price($_POST['booking'], empty($_POST['booking_item']) ? array() : $_POST['booking_item'], $_POST['rooms'], $_POST['packages'], $_POST['extras']);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	// Save Booking
	public function _getBookingNumber()
	{
		$current_year = date('Y');

		$this->db->order_by('id_booking', 'DESC');
		$bookings = $this->db->get('booking')->result_array();
		if (count($bookings) == 0) {
			$lastest_year = $current_year;
		} else {
			$lastest_year = date('Y', strtotime($bookings[0]['booking_date']));
		}

		if ($lastest_year == $current_year) {
			$this->db->where('name', 'booking_number_running');
			$this->db->update('setting', array('value' => $this->settings['booking_number_running'] + 1, 'updated' => date('Y-m-d H:i:s')));
			return $lastest_year . '-' . str_pad($this->settings['booking_number_running'] + 1, 5, '0', STR_PAD_LEFT);
		} else {
			$this->db->where('name', 'booking_number_running');
			$this->db->update('setting', array('value' => 1, 'updated' => date('Y-m-d H:i:s')));
			return $lastest_year . '-00001';
		}
	}

	public function save_booking()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$booking_info = $_POST['booking_info'];
		$id_booking = $booking_info['id_booking'];
		unset($booking_info['id_booking']);
		$old_booking = !empty($id_booking) ? $this->Booking->get_by_id($id_booking) : array();

		// check if room available
		$rooms = empty($_POST['rooms']) ? array() : $_POST['rooms'];
		foreach ($rooms as $room) {
			$this->db->select('*')
				->from('booking_room')
				->join('booking', 'booking_room.booking_number = booking.booking_number')
				->where('booking.id_booking !=', $id_booking)
				->where_not_in('booking.status', array('Checked-out', 'Cancel', 'Expired'))
				->where('booking_room.id_room_details', $room['id_room_details']);
			$booking_room = $this->db->get()->result_array();

			foreach ($booking_room as $br) {
				if (!$this->_is_expired($br) && $br['check_in_date'] < $booking_info['check_out_date'] && $br['check_out_date'] > $booking_info['check_in_date']) {
					$ret['message'] = 'Room (' . $room['room_number'] . ') is not available in this period';
					echo json_encode($ret);
					return;
				}
			}
		}

		// search room available for package
		$packages = empty($_POST['packages']) ? array() : $_POST['packages'];
		foreach ($packages as $package) {
			if (isset($package['is_selected']) && $package['is_selected'] == 0) {
				continue;
			}

			if ($booking_info['check_in_date'] < $package['start_date'] || $booking_info['check_in_date'] > $package['end_date']) {
				$ret['message'] = 'Package (' . $package['name'] . ') is not available in this period';
				echo json_encode($ret);
				return;
			}

			for ($i = 0; $i < $package['package_qty']; $i++) {
				foreach ($package['package_item'] as $pi) {
					for ($j = 0; $j < $pi['qty']; $j++) {
						$this->db->select('*');
						$this->db->from('room_details rd');
						$this->db->join('room_type rt', 'rd.id_room_type = rt.id_room_type');
						$this->db->where('rt.id_room_type', $pi['id_room_type']);
						$this->db->where('rd.active', 1);
						$this->db->where('rt.active', 1);
						$this->db->where("rd.id_room_details NOT IN ("
							. "SELECT br.id_room_details "
							. "FROM booking b "
							. "LEFT JOIN booking_room br ON b.booking_number = br.booking_number "
							. "WHERE b.check_in_date < '" . $booking_info['check_out_date'] . "' "
							. "AND b.check_out_date > '" . $booking_info['check_in_date'] . "' "
							. "AND b.status NOT IN ('Checked-out', 'Cancel', 'Expired') "
							. "AND b.id_booking !='" . $id_booking . "' "
							. ")");

						if (!empty($rooms)) {
							$this->db->where_not_in('rd.id_room_details', array_col($rooms, 'id_room_details'));
						}

						$room_details = $this->db->get()->result_array();
						if (count($room_details) == 0) {
							$ret['message'] = 'Room Type (' . $pi['room_type_name_en'] . ') in Package (' . $package['name'] . ') is not available in this period';
							echo json_encode($ret);
							return;
						} else {
							$room_detail = $room_details[0];
							$rooms[] = array(
								'id_room_type' => $room_detail['id_room_type'],
								'id_room_details' => $room_detail['id_room_details'],
								'room_type_name_en' => $room_detail['room_type_name_en'],
								'room_name_en' => $room_detail['room_name_en'],
								'room_number' => $room_detail['room_number'],
								'id_package' => $pi['id_package'],
								'package_qty' => $package['package_qty'],
								'package_name' => $package['name']
							);
						}
					}
				}
			}
		}
		$booking_info['number_of_rooms'] = empty($rooms) ? 0 : count($rooms);

		// discount
		if (empty($booking_info['discounted_amount'])) {
			$booking_info['discount_code'] = null;
			$booking_info['id_discount_code'] = null;
		} else {
			if (empty($old_booking['id_discount_code']) || $old_booking['id_discount_code'] != $booking_info['id_discount_code']) {
				$this->db->where('code', $booking_info['discount_code']);
				$this->db->order_by('id_discount', 'DESC');
				$discounts = $this->db->get('discount');

				if ($discounts->num_rows() > 0) {
					$discount = $discounts->row_array();
					$booking_info['id_discount_code'] = $discount['id_discount'];
					$booking_info['discount_type'] = $discount['discount_type'];
					$booking_info['discount_value'] = $discount['discount_value'];
				}
			}
		}

		// Save Booking
		$now = date('Y-m-d H:i:s');
		if (empty($id_booking)) {
			$user_data = $this->session->userdata('user_data');
			$booking_info['staff_id'] = $user_data['id_user'];
			$booking_info['is_backend'] = 1;
			$booking_info['booking_date'] = $now;
			$booking_info['booking_number'] = $this->_getBookingNumber();

			$this->db->insert('booking', $booking_info);
			$ret['message'] = $this->db->insert_id();
		} else {
			if (empty($booking_info['staff_id'])) {
				$booking_info['staff_id'] = null;
			}

			$this->db->where('id_booking', $id_booking);
			$this->db->update('booking', $booking_info);
			$ret['message'] = $id_booking;
		}
		$old_status = !empty($old_booking) && !empty($old_booking['status']) ? $old_booking['status'] : '';

		// Save Booking Items
		$this->db->where('id_booking', $ret['message']);
		$booking_item = $this->db->get('booking_item')->result_array();
		foreach ($booking_item as $bi) {
			$this->db->where('id_booking_item', $bi['id_booking_item']);
			$this->db->delete('booking_item_date');
		}
		$this->db->where('id_booking', $ret['message']);
		$this->db->delete('booking_item');

		foreach ($_POST['booking_item'] as $item) {
			if (empty($item['id_extras'])) {
				$item['id_extras'] = '';
			}

			$item['id_booking'] = $ret['message'];
			$booking_row = $this->Booking->get_by_id($item['id_booking']);
			$item['booking_number'] = $booking_row['booking_number'];
			$item['date_created'] = date('Y-m-d H:i:s');

			$dates = array();
			if (!empty($item['dates'])) {
				$dates = $item['dates'];
				unset($item['dates']);
			}

			unset($item['id_booking_item']);
			$this->db->insert('booking_item', $item);
			$id_booking_item = $this->db->insert_id();

			if (!empty($dates)) {
				foreach ($dates as $date) {
					$this->db->insert('booking_item_date', array(
						'id_booking_item' => $id_booking_item,
						'date' => $date
					));
				}
			}
		}

		// Save Booking Rooms
		$this->db->where('booking_number', $booking_info['booking_number']);
		$this->db->delete('booking_room');

		foreach ($rooms as $room) {
			if (empty($room)) {
				continue;
			}

			$tmp = array(
				'booking_number' => $booking_info['booking_number'],
				'id_room_details' => $room['id_room_details'],
				'id_room_type' => $room['id_room_type'],
				'room_type_name_en' => $room['room_type_name_en'],
				'room_name_en' => $room['room_name_en'],
				'id_package' => empty($room['id_package']) ? null : $room['id_package'],
				'package_qty' => empty($room['package_qty']) ? null : $room['package_qty'],
				'package_name' => empty($room['package_name']) ? null : $room['package_name']
			);
			$this->db->insert('booking_room', $tmp);
		}

		// Send Booked Email & Send Confirmed Email
		
		$booking_info['id_booking'] = $ret['message'];
		$this->_checkSendEmailBooked($booking_info, $old_status);
		$this->_checkSendEmailConfirmed($booking_info, $old_status);
		
		// Save Booking Payment
		$this->db->where('booking_number', $booking_info['booking_number']);
		$old_slip = $this->db->get('booking_payment')->num_rows();

		$this->db->where('booking_number', $booking_info['booking_number']);
		$this->db->delete('booking_payment');

		$new_slip = 0;
		$max_transfer_date = null;
		$total_transfer_amount = 0;

		if (!empty($_POST['booking_payment'])) {
			foreach ($_POST['booking_payment'] as $i => $p) {
				if (empty($p['transfer_slip'])) {
					continue;
				}

				$new_slip++;
				$total_transfer_amount += floatval($p['transferred_amount']);

				if (empty($max_transfer_date) || $p['transfer_date'] > $max_transfer_date) {
					$max_transfer_date = $p['transfer_date'];
				}

				$p['transfer_slip'] = _upload('transfer_slip', $p['transfer_slip'], $booking_info['id_booking']);
				if ($p['transfer_slip'] == '-') {
					$ret['message'] = 'Invalid Image File Type.';
					echo json_encode($ret);
					return;
				}

				if (isset($p['id_booking_payment'])) {
					unset($p['id_booking_payment']);
				}
				$p['id_booking'] = $booking_info['id_booking'];
				$p['booking_number'] = $booking_info['booking_number'];
				$this->db->insert('booking_payment', $p);
			}
		}

		$this->db->where('id_booking', $ret['message']);
		$this->db->update('booking', array(
			'transfer_date' => $max_transfer_date,
			'transferred_amount' => round($total_transfer_amount, 6),
			'balance_amount' => round($booking_info['grand_total'] - $total_transfer_amount, 2)
		));

		// Check change status to Verifying
		if ((empty($old_booking) || empty($old_status) || $old_status == 'Booked') && $old_slip == 0 && $new_slip > 0 || ((empty($old_status) || $old_status == 'Booked') && !empty($booking_info['id_credit']))) {
		//if ((empty($old_booking) || empty($old_status) || $old_status == 'Booked') && $old_slip == 0 && $new_slip > 0 || (empty($old_status) && !empty($booking_info['id_credit']))) {
			$this->db->where('id_booking', $ret['message']);
			$this->db->update('booking', array('status' => 'Verifying'));
		}
		

		// Check Unlink Deleted Image
		$this->load->library('../controllers/home');
		$this->home->check_deleted_image(false, 'transfer_slip', $ret['message']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function update_booking_status()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('id_booking', $_POST['id_booking']);
		$this->db->update('booking', array('status' => $_POST['booking_status']));

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	// Send Email
	public function _checkSendEmailBooked($booking_info = array(), $old_status = '')
	{
		if (empty($booking_info)) {
			return;
		}

		if ($booking_info['status'] == 'Booked' && empty($old_status)) {
			$this->db->where('id_guest', $booking_info['id_guest_info']);
			$guest = $this->db->get('guest_info')->row_array();
			$subject = 'คุณทำการจองห้องพัก Smart Modular System เรียบร้อยแล้ว (' . $booking_info['booking_number'] . ')';
			$message = '<b>Guest Name:</b> ' . $booking_info['guest_name']
				. '<br><b>Check In Date:</b> ' . $booking_info['check_in_date']
				. '<br><b>Check Out Date:</b> ' . $booking_info['check_out_date']
				. '<br><b>Total Price:</b> ' . formatBaht($booking_info['grand_total'])
				. '<br><br><hr><br><br>' . $this->settings['booked_email_template'];
			$attachment = $this->_saveInvoice($booking_info['id_booking']);
			//return $this->_sendEmail('mychelle@buildersmart.com', $subject, $message, $attachment);
			return $this->_sendEmail($guest['email'], $subject, $message, $attachment);
		}
	}

	public function _checkSendEmailConfirmed($booking_info = array(), $old_status = '')
	{
		if ($booking_info['status'] == 'Confirmed' && (empty($old_status) || $old_status == 'Booked' || $old_status == 'Verifying')) {
			// update confirm_staff_id
			$user_data = $this->session->userdata('user_data');
			$this->db->where('id_booking', $booking_info['id_booking']);
			$this->db->update('booking', array('confirm_staff_id' => $user_data['id_user']));

			//
			$this->db->where('id_guest', $booking_info['id_guest_info']);
			$guest = $this->db->get('guest_info')->row_array();

			$subject = 'คุณชำระเงินการจองห้องพัก Smart Modular System เรียบร้อยแล้ว (' . $booking_info['booking_number'] . ')';
			$message = '<b>Guest Name:</b> ' . $booking_info['guest_name']
				. '<br><b>Check In Date:</b> ' . $booking_info['check_in_date']
				. '<br><b>Check Out Date:</b> ' . $booking_info['check_out_date']
				. '<br><b>Total Price:</b> ' . formatBaht($booking_info['grand_total'])
				. '<br><br><hr><br><br>' . $this->settings['confirmed_email_template'];
			$attachment = $this->_saveInvoice($booking_info['id_booking']);
			return $this->_sendEmail($guest['email'], $subject, $message, $attachment);
		}
	}

	public function _sendEmail($to = '', $subject = '', $message = '', $attachment = '')
	{
		$ret = array('result' => 'false', 'message' => '');
		if (empty($to) || empty($subject) || empty($message)) {
			$ret['message'] = 'Empty Param';
			return $ret;
		}

		//$smtp_user = 'helpdesk@buildersmart.com';//'sms.booking@hotmail.com';
		$smtp_user = EMAIL_USER;
		$this->load->library('email', array(
			'protocol'    => 'smtp',
			'smtp_host'   => 'smtp-legacy.office365.com',
			'smtp_port'   => 587,
			'smtp_user'   => $smtp_user,
			'smtp_pass'   => EMAIL_PASSWORD, //'Hor93452',//'Bsm@2023',
			'smtp_crypto' => 'tls',
			'mailtype'    => 'html',
			'charset'     => 'utf-8',
			'wordwrap'    => TRUE
		));

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";

		$this->email->set_newline("\r\n");
		$this->email->from($smtp_user, 'SMS Booking');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if (!empty($attachment)) {
			$this->email->attach($attachment);
		}

		if ($this->email->send()) {
			$ret['result'] = 'true';
		} else {
			$ret['message'] = $this->email->print_debugger();
		}

		if (!empty($attachment)) {
			unlink($attachment);
		}

		return $ret;
	}

	public function _getInvoice($id_booking = '')
	{
		if (empty($id_booking)) {
			return;
		}

		$this->db->select('*')
			->select('business_info.phone_number AS "business_info_phone_number"')
			->select('project_info.phone_number AS "project_phone_number"')
			->select('project_policy.description_en AS "project_policy_description_en", project_policy.description_th AS "project_policy_description_th"')
			->from('booking')
			->join('guest_info', 'booking.id_guest_info = guest_info.id_guest')
			->join('booking_room', 'booking.booking_number = booking_room.booking_number')
			->join('room_details', 'booking_room.id_room_details = room_details.id_room_details')
			->join('room_type', 'room_details.id_room_type = room_type.id_room_type')
			->join('project_info', 'room_type.id_project_info = project_info.id_project_info')
			->join('project_policy', "project_info.id_project_info = project_policy.id_project_info AND project_policy.policy_type_en = 'Cancellation Policy'", 'LEFT')
			->join('business_info', 'project_info.id_business_info = business_info.id_business_info')
			->where('booking.id_booking', $id_booking);
		$booking = $this->db->get()->row_array();
		/////
		require(APPPATH . '/third_party/fpdf/fpdf.php');
		define('FPDF_FONTPATH', 'font/');
		$pdf = new FPDF();
		$pdf->AddFont('angsa', '', 'angsa.php');
		$pdf->AddFont('angsa', 'B', 'angsab.php');
		$pdf->AddFont('angsa', 'I', 'angsai.php');

		$pdf->AddPage();
		$image = site_url() . "images/sms_resort.png";
		$pdf->Cell(30, 40, $pdf->Image($image, $pdf->GetX(), $pdf->GetY(), 30), 0, 0, 'L', false);

		$pdf->SetY($pdf->GetY() + 13);
		$pdf->SetFont('angsa', 'B', 18);
		$pdf->SetX(15);
		$pdf->Cell(30, 0, '');
		$pdf->Cell(80, 11.5, _t($booking['project_name_en'], $booking['project_name_th']));

		$pdf->SetFont('angsa', 'I', 18);
		$pdf->SetX(120);
		$pdf->SetFillColor(131, 146, 135);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(80, 8, _t('Booking Number: ', 'เลขที่การจอง: ') . $booking['booking_number'], 0, 0, 'C', true);

		////////// Right Side ----------------------------------------------------------------------------------------------------------------------------
		$pdf->SetY(43);
		$pdf->SetX(120);
		$pdf->SetFont('angsa', '', 16);
		$pdf->Cell(80, 6.5, _t('Invoice # ', 'หมายเลขใบเสร็จ # ') . $booking['id_booking'], 0, 0, 'L', true);

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->SetX(123);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('angsa', '', 16);
		$pdf->Cell(55, 7, _t('Total Before Discount', 'ยอดรวมก่อนส่วนลด'));
		$pdf->Cell(20, 7, number_format($booking['grand_total'] + $booking['discounted_amount'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->SetX(123);
		$pdf->Cell(55, 7, _t('Discount ', 'ส่วนลด ') . ($booking['discounted_amount'] > 0 ? ($booking['discount_type'] == 'percent' ? ('(' . $booking['discount_value'] . '%)') : ('(฿' . $booking['discount_value'] . ')')) : ''));
		$pdf->Cell(20, 7, number_format($booking['discounted_amount'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->SetX(123);
		$pdf->SetFont('angsa', 'B', 16);
		$pdf->Cell(55, 7, _t('Grand Total', 'ยอดรวมทั้งสิ้น'));
		$pdf->Cell(20, 7, number_format($booking['grand_total'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 9);
		$pdf->SetX(123);
		$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 75, $pdf->GetY());
		$pdf->SetX(123);
		$pdf->SetFont('angsa', '', 16);
		$pdf->Cell(55, 7, _t('VAT', 'ภาษี') . ' (7%)');
		$pdf->Cell(20, 7, number_format($booking['vat'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 5);
		$pdf->SetX(123);
		$pdf->Cell(55, 7, _t('Subtotal', 'ยอดก่อนภาษี'));
		$pdf->Cell(20, 7, number_format($booking['sub_total'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->SetX(120);
		$pdf->Cell(80, 6.5, '', 0, 0, '', true);

		////////// Left Side ----------------------------------------------------------------------------------------------------------------------------
		$pdf->SetY(35);
		$pdf->SetX(10);
		$pdf->SetFont('angsa', '', 14);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Company Name:', 'ชื่อบริษัท:'));
		$pdf->MultiCell(60, 7, _t($booking['project_name_en'], $booking['project_name_th']), 0, 'L', false);

		/////
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Company Address:', 'ที่อยู่บริษัท:'));
		$pdf->MultiCell(60, 7, _t($booking['whole_address_en'], $booking['whole_address_th']), 0, 'L', false);

		/////
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Company TAX ID:', 'เลขประจำตัวผู้เสียภาษี:'));
		$pdf->Cell(60, 7, $booking['business_tax_id']);

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Contact Number:', 'เบอร์โทรติดต่อ:'));
		$pdf->Cell(60, 7, $booking['project_phone_number']);

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Bank:', 'ชื่อธนาคาร:'));
		$pdf->Cell(60, 7, 'Kasikorn Bank');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Account Name:', 'ชื่อบัญชี:'));
		$pdf->Cell(60, 7, 'BuilderSmart (Public) Co., Ltd.');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Account Number:', 'หมายเลขบัญชี:'));
		$pdf->Cell(60, 7, '145-1-69629-3');

		/////
		$pdf->SetY($pdf->GetY() + 2);
		$pdf->Cell(113, 0, '');

		/////
		// $pdf->SetY($pdf->GetY() + 7);
		// $pdf->Cell(110, 0, '');

		/////
		$pdf->SetY($pdf->GetY() + 9);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Customer Name:', 'ชื่อลูกค้า:'));
		$pdf->Cell(60, 7, iconv('UTF-8', 'TIS-620', $booking['guest_name']));

		// $pdf->SetY($pdf->GetY() + 9);
		// $pdf->Cell(8, 0, '');
		// $pdf->Cell(32, 7, _t('Customer Name:', 'ชื่อลูกค้า:'));
		// $pdf->Cell(60, 7, $booking['guest_name']);

		$pdf->SetY($pdf->GetY() + 9);
		$pdf->Cell(8, 0, '');

		$pdf->SetY($pdf->GetY() - 9);
		$pdf->SetX(155);
		$pdf->Cell(30, 7, _t('Check-in Date:', 'วันที่เข้าพัก:'));
		$pdf->Cell(13, 7, formatDate($booking['check_in_date']), 0, 0, 'R');

		$auto_new_line = 500; // 29 text;

		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Address:', 'ที่อยู่:'));
		// $pdf->Cell(60, 7, $booking['guest_address']);
		$stack_for_guest = array();
		if (isset($booking['guest_address']) && $booking['guest_address']) {
			$split_str_guest = str_split($booking['guest_address'], $auto_new_line);

			foreach ($split_str_guest as $key => $value) {	
				$pdf->Cell(60, 7, iconv('UTF-8', 'TIS-620', $value));
				// $pdf->SetY($pdf->GetY() + 7);
				$pdf->SetX(50);
				array_push($stack_for_guest, 1);
			}
		} else {
			$split_str_guest = array();
			$pdf->Cell(60, 7, '-');
		}

		// if (isset($stack_for_guest) && $stack_for_guest) {
		// 	for ($i = 0; $i < count($stack_for_guest); $i++) {
		// 		$pdf->SetY($pdf->GetY() - 7);
		// 	}
		// }

		$pdf->SetX(155);
		$pdf->Cell(30, 7, _t('Check-out Date:', 'วันที่ออก:'));
		$pdf->Cell(13, 7, formatDate($booking['check_out_date']), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Customer TAX ID:', 'เลขประจำตัวผู้เสียภาษี:'));
		$pdf->Cell(60, 7, empty($booking['guest_tax_id']) ? '-' : $booking['guest_tax_id']);

		$pdf->SetX(155);
		$pdf->Cell(30, 7, _t('Number of Nights:', 'จำนวนวันเข้าพัก:'));
		// $pdf->SetX(170);
		$pdf->Cell(13, 7, dateDiff($booking['check_in_date'], $booking['check_out_date']), 0, 0, 'R');

		
		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Contact Number:', 'เบอร์โทรติดต่อ:'));
		$pdf->Cell(60, 7, empty($booking['guest_contact_number']) ? '-' : $booking['guest_contact_number']);

		//billing detail
		$pdf->SetY($pdf->GetY() + 11);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Customer Name:', 'ชื่อใบเสร็จ:'));
		$pdf->Cell(60, 7, iconv('UTF-8', 'TIS-620', $booking['billing_name']));

		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Address:', 'ที่อยู่:'));
		$stack_for_billing = array();
		if (isset($booking['billing_address']) && $booking['billing_address']) {
			$split_str = str_split($booking['billing_address'], $auto_new_line);
			$stack = 60; //current line of  billing_address
			foreach ($split_str as $key => $value) {
				$str = '';
				$str = iconv('UTF-8', 'TIS-620', $value);
				$pdf->Cell(60, 7, $str);
				// $stack += 7;
				// $pdf->SetY($pdf->GetY() + 7);
				$pdf->SetX(50);
				array_push($stack_for_billing, 1);
			}
		} else {
			$split_str = array();
			$pdf->Cell(40, 7, '-');
		}

		// $pdf->SetX(90);
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Customer TAX ID:', 'เลขประจำตัวผู้เสียภาษี:'));
		$pdf->Cell(60, 7, empty($booking['billing_tax_id']) ? '-' : $booking['billing_tax_id']);

		// $pdf->SetX(90);
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(32, 7, _t('Contact Number:', 'เบอร์โทรติดต่อ:'));
		$pdf->Cell(60, 7, empty($booking['billing_contact_number']) ? '-' : $booking['billing_contact_number']);

		///////// Booking Item ----------------------------------------------------------------------------------------------------------------------------
		$pdf->SetY($pdf->GetY() + 9);
		$pdf->SetFont('angsa', 'B', 16);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(190.3, 7, _t('Booking Items:', 'รายการการจอง:'), 0, 0, 'L', true);

		///// header
		$pdf->SetY($pdf->GetY() + 10);
		$pdf->SetFont('angsa', 'B', 13);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Cell(9, 0, '');
		$pdf->Cell(15, 8, _t('No.', 'ลำดับ'), 1, 0, 'C');
		$pdf->Cell(67, 8, _t('Description', 'รายละเอียด'), 1, 0, 'C');
		$pdf->Cell(25, 8, _t('Unit Price', 'ราคา'), 1, 0, 'C');
		$pdf->Cell(25, 8, _t('Discount', 'ส่วนลด'), 1, 0, 'C');
		$pdf->Cell(18, 8, _t('Quantity', 'จำนวน'), 1, 0, 'C');
		$pdf->Cell(25, 8, _t('Total', 'ยอดรวม'), 1, 0, 'C');
		$pdf->SetFont('angsa', '', 13);

		///// table
		// package
		$this->db->select('bi.id_package, bi.package_qty, bi.package_name, bi.package_price, bi.full_package_price, bi.quantity');
		$this->db->from('booking_item bi');
		$this->db->where('id_package >', 0);
		$this->db->where('id_booking', $id_booking);
		$this->db->group_by('bi.id_package, bi.package_qty, bi.package_name, bi.package_price, bi.full_package_price, bi.quantity');
		$package = $this->db->get()->result_array();

		$this->db->where('id_package >', 0);
		$this->db->where('id_booking', $id_booking);
		$booking_item = $this->db->get('booking_item')->result_array();

		foreach ($package as $i => $p) {
			$pdf->SetY($pdf->GetY() + 10);
			$pdf->Cell(9, 0, '');
			$pdf->Cell(15, 10, ($i + 1) . '.', 1, 0, 'C');
			$pdf->Cell(67, 10, '  ' . $p['package_name'], 1, 0, 'L');
			$pdf->Cell(25, 10, number_format($p['full_package_price'], 2) . '  ', 1, 0, 'R');
			$pdf->Cell(25, 10, number_format($p['full_package_price'] - $p['package_price'], 2) . '  ', 1, 0, 'R');
			$pdf->Cell(18, 10, $p['package_qty'] * $p['quantity'], 1, 0, 'C');
			$pdf->Cell(25, 10, number_format($p['package_price'] * $p['package_qty'] * $p['quantity'], 2) . '  ', 1, 0, 'R');

			foreach ($booking_item as $j => $bi) {
				if ($bi['id_package'] == $p['id_package']) {
					$pdf->SetY($pdf->GetY() + 10);
					$pdf->Cell(9, 0, '');
					$pdf->Cell(15, 10, '', 1, 0, 'C');
					$pdf->Cell(160, 10, '  ' . $bi['item_name'], 1, 0, 'L');
				}
			}
		}

		// non package
		$this->db->where('(id_package = 0 OR id_package IS NULL)');
		$this->db->where('id_booking', $id_booking);
		$booking_item = $this->db->get('booking_item')->result_array();

		foreach ($booking_item as $i => $bi) {
			$pdf->SetY($pdf->GetY() + 8);
			$pdf->Cell(9, 0, '');
			$pdf->Cell(15, 8, (count($package) + $i + 1) . '.', 1, 0, 'C');
			$pdf->Cell(67, 8, '  ' . $bi['item_name'], 1, 0, 'L');
			$pdf->Cell(25, 8, number_format($bi['full_unit_cost'], 2) . '  ', 1, 0, 'R');
			$pdf->Cell(25, 8, number_format($bi['discount'], 2) . '  ', 1, 0, 'R');
			$pdf->Cell(18, 8, $bi['quantity'], 1, 0, 'C');
			$pdf->Cell(25, 8, number_format($bi['unit_cost'] * $bi['quantity'], 2) . '  ', 1, 0, 'R');
		}

		////////// Note ------------------------------------------------------------------------------------------------------------------------------------
		$pdf->SetY($pdf->GetY() + 15);
		$pdf->SetFont('angsa', 'B', 16);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(190.3, 7, $booking['project_policy_description_en'] ? _t('Notes:', 'หมายเหตุ:') : '', 0, 'L', true);

		$pdf->SetFont('angsa', '', 15);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(190.3, 7, '         ' . _t($booking['project_policy_description_en'], $booking['project_policy_description_th']), 0, 'L', true);
		$pdf->Cell(190.3, 3, '', 0, 0, 'L', true);

		return $pdf;
	}

	public function _saveInvoice($id_booking = '')
	{
		if (empty($id_booking)) {
			return;
		}

		$booking = $this->Booking->get_by_id($id_booking);
		$filename = server_path() . 'upload/invoice_pdf/' . $booking['booking_number'] . '.pdf';

		$pdf = $this->_getInvoice($id_booking);
		$pdf->Output($filename, 'F');
		return $filename;
	}

	public function showInvoice($id_booking = '')
	{
		if (empty($id_booking)) {
			return;
		}

		$pdf = $this->_getInvoice($id_booking);
		$pdf->Output();
	}

	///// Order
	public function order()
	{
		if (!has_permission('order', 'view')) {
			header("Location: " . home_url());
		}

		$this->_data['projects'] = $this->db->get('project_info')->result_array();
		$this->_data['rooms'] = $this->Room_details->getRooms();

		$first_project = $this->db->get('project_info')->row_array();
		$this->_data['order'] = $this->_getOrders(0, $first_project['id_project_info']);

		$this->_data['active_menu'] = 'pos';
		$this->render();
	}

	public function _getOrders($id_guest_info = 0, $project = 'All', $room = 'All', $order_number = '', $order_status = 'All', $date_type = 'Created', $date_from = '', $date_to = '')
	{
		$this->db->select('o.*, b.booking_number');
		$this->db->from('orders o');
		$this->db->join('booking b', 'o.id_booking = b.id_booking', 'LEFT');

		if (!empty($order_number)) {
			$this->db->like('o.order_number', trim($order_number));
		}
		if (!empty($id_guest_info)) {
			$this->db->where('o.id_guest_info', $id_guest_info);
		}
		if ($order_status !== 'All') {
			$this->db->where('o.status', $order_status);
		}

		$date = date('Y-m-d');
		if (empty($date_from)) {
			$date_from = $date;
			$date_from_full = $date . ' 00:00:00.000';
		} else {
			$date_from_full = $date_from . ' 00:00:00.000';
		}
		if (empty($date_to)) {
			$date_to = $date;
			$date_to_full = $date . ' 23:59:59.999';
		} else {
			$date_to_full = $date_to . ' 23:59:59.999';
		}

		if ($date_type == 'Created') {
			$this->db->where('o.date_created >=', $date_from_full);
			$this->db->where('o.date_created <=', $date_to_full);
		} else if ($date_type == 'Confirmed') {
			$this->db->where('o.transfer_date >=', $date_from);
			$this->db->where('o.transfer_date <=', $date_to);
		} else if ($date_type == 'Service') {
			$this->db->where('o.order_date >=', $date_from);
			$this->db->where('o.order_date <=', $date_to);
		}

		if ($project != 'All') {
			$this->db->where('o.id_project_info', $project);
		}

		$order = $this->db->get()->result_array();

		$tmp_order = array();
		foreach ($order as $i => $o) {
			$order[$i]['date_created'] = date('Y-m-d', strtotime($o['date_created']));

			$this->db->where('id_guest', $o['id_guest_info']);
			$guest = $this->db->get('guest_info')->row_array();
			$order[$i]['guest_name'] = $guest['name'];

			if ($this->_is_expired_order($o)) {
				$order[$i]['status'] = 'Expired';
			}

			$this->db->select('*');
			$this->db->from('booking_room');
			if ($room != 'All') {
				$this->db->join('room_details', 'booking_room.id_room_details = room_details.id_room_details');
				$this->db->join('room_type', 'room_details.id_room_type = room_type.id_room_type');
			}
			$this->db->where('booking_number', $o['booking_number']);
			$booking_room = $this->db->get()->result_array();

			$found = true;
			if ($room != 'All') {
				$found = false;
				foreach ($booking_room as $br) {
					if ($br['id_room_details'] == $room) {
						$found = true;
						break;
					}
				}
			}

			if ($found) {
				// Get Order Payments
				$this->db->select('*');
				$this->db->from('order_payment');
				$this->db->where('id_order', $o['id_order']);
				$order_payment = $this->db->get()->result_array();
				foreach ($order_payment as $j => $p) {
					$order_payment[$j]['transfer_slip'] = getImageUrl($p['transfer_slip']);
				}
				$order[$i]['order_payment'] = $order_payment;

				$tmp_order[] = $order[$i];
			}
		}

		return $tmp_order;
	}

	public function getOrders()
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
				$start = $month . '-01';
				$end = $month . date('-t', strtotime($start));
			}
		}

		$ret['message'] = $this->_getOrders($_POST['guest_id'], $_POST['project'], $_POST['room'], $_POST['order_number'], $_POST['order_status'], $_POST['date_type'], $start, $end);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function delete_order()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['id'])) {
			$ret['message'] = 'Empty Order ID';
			echo json_encode($ret);
			return;
		} else {
			$this->db->where('id_order', $_POST['id']);
			$order_payment = $this->db->get('order_payment')->result_array();

			if (count($order_payment) > 0) {
				$ret['message'] = 'Can not delete, delete all order payments first.';
				echo json_encode($ret);
				return;
			}

			$this->db->where('id_order', $_POST['id']);
			$this->db->delete('order_item');

			$this->db->where('id_order', $_POST['id']);
			$this->db->delete('orders');
		}

		// Check Unlink Deleted Image
		$this->load->library('../controllers/home');
		$this->home->check_deleted_image(false, 'order_transfer_slip', $_POST['id']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function edit_order($id = '')
	{
		if (!has_permission('booking', 'view')) {
			header("Location: " . home_url());
		}

		///// Projects
		$this->_data['projects'] = $this->db->get('project_info')->result_array();

		///// Booking Info
		$this->db->where('id_order', $id);
		$order = $this->db->get('orders')->result_array();

		if (count($order) > 0) {
			$tmp = $order[0];
			$this->db->where('id_guest', $tmp['id_guest_info']);
			$guest = $this->db->get('guest_info')->row_array();
			$tmp['guest_name'] = $guest['name'];
			$this->_data['order_info'] = $tmp;

			///// Order items
			$this->db->where('id_order', $id);
			$this->_data['order_item'] = $this->db->get('order_item')->result_array();

			///// Order Payments
			$this->db->where('id_order', $id);
			$this->_data['order_payment'] = $this->db->get('order_payment')->result_array();
			foreach ($this->_data['order_payment'] as $i => $p) {
				$this->_data['order_payment'][$i]['transfer_slip'] = getImageUrl($p['transfer_slip']);
			}

			///// Bookings
			$this->db->where('id_guest_info', $tmp['id_guest_info']);
			$this->db->where_not_in('status', array('Cancel', 'Expired'));
			$this->_data['bookings'] = $this->db->get('booking')->result_array();
		} else {
			$fields = $this->db->list_fields('orders');
			$tmp = array();
			foreach ($fields as $field) {
				if (!in_array($field, array('staff_id'))) {
					$tmp[$field] = '';
				}
			}
			$tmp['date_created'] = date('Y-m-d H:i:s');
			$tmp['status'] = 'Ordered';
			$tmp['guest_name'] = '';
			$tmp['order_date'] = date('Y-m-d');
			$tmp['id_project_info'] = $this->_data['projects'][0]['id_project_info'];

			$this->_data['order_info'] = $tmp;
			$this->_data['order_item'] = array();
			$this->_data['order_payment'] = array();
			$this->_data['bookings'] = array();
		}

		$this->_data['order_payment_blank_row'] = $this->Order_payment->get_blank_row();
		$this->_data['order_payment_blank_row']['id_order_payment'] = 0;
		$this->_data['order_payment_blank_row']['id_order'] = $tmp['id_order'];

		///// Extra
		$this->db->where('is_bed', 0);
		$this->db->where('active', 1);
		$this->_data['extras'] = $this->db->get('extras')->result_array();
		// select extra
		$this->db->where('id_order', $id);
		$this->db->where('id_extras >', 0);
		$items = $this->db->get('order_item')->result_array();
		$tmp1 = array();
		$tmp2 = array();

		$extra_price = array();
		foreach ($this->_data['extras'] as $e) {
			$tmp1[$e['id_extras']] = 0;
			$tmp2[$e['id_extras']] = 0;
			$extra_price[$e['id_extras']] = $e['price'];
		}

		foreach ($items as $item) {
			$tmp1[$item['id_extras']] = $item;
			$tmp2[$item['id_extras']] = $item['quantity'];
		}

		$this->_data['select_extra'] = $tmp1;
		$this->_data['select_extra_qty'] = $tmp2;

		$this->_data['active_menu'] = 'pos';
		$this->render();
	}

	public function save_order()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$order_info = $_POST['order_info'];
		$id_order = $order_info['id_order'];
		unset($order_info['id_order']);

		$now = date('Y-m-d H:i:s');
		$old_order = '';
		if (empty($id_order)) {
			$user_data = $this->session->userdata('user_data');
			$order_info['staff_id'] = $user_data['id_user'];
			$order_info['date_created'] = $now;
			$order_info['order_number'] = $this->_getOrderNumber();

			$this->db->insert('orders', $order_info);
			$ret['message'] = $this->db->insert_id();
		} else {
			if (empty($order_info['staff_id'])) {
				$order_info['staff_id'] = null;
			}

			$this->db->where('id_order', $id_order);
			$old_order = $this->db->get('orders')->row_array();

			$this->db->where('id_order', $id_order);
			$this->db->update('orders', $order_info);
			$ret['message'] = $id_order;
		}
		$old_status = !empty($old_order) && !empty($old_order['status']) ? $old_order['status'] : '';

		// Save Order Items
		$this->db->where('id_order', $ret['message']);
		$this->db->delete('order_item');

		foreach ($_POST['order_item'] as $item) {
			if (empty($item['id_extras'])) {
				$item['id_extras'] = '';
			}

			$item['id_order'] = $ret['message'];
			$order_row = $this->Orders->get_by_id($item['id_order']);
			$item['date_created'] = date('Y-m-d H:i:s');
			unset($item['id_order_item']);

			$this->db->insert('order_item', $item);
		}

		// Save Order Payment
		$this->db->where('id_order', $ret['message']);
		$old_slip = $this->db->get('order_payment')->num_rows();

		$this->db->where('id_order', $ret['message']);
		$this->db->delete('order_payment');

		$new_slip = 0;
		$max_transfer_date = null;
		$total_transfer_amount = 0;

		if (!empty($_POST['order_payment'])) {
			foreach ($_POST['order_payment'] as $i => $p) {
				if (empty($p['transfer_slip'])) {
					continue;
				}

				$new_slip++;
				$total_transfer_amount += floatval($p['transferred_amount']);

				if (empty($max_transfer_date) || $p['transfer_date'] > $max_transfer_date) {
					$max_transfer_date = $p['transfer_date'];
				}

				$p['transfer_slip'] = _upload('order_transfer_slip', $p['transfer_slip'], $ret['message']);
				if ($p['transfer_slip'] == '-') {
					$ret['message'] = 'Invalid Image File Type.';
					echo json_encode($ret);
					return;
				}

				if (isset($p['id_order_payment'])) {
					unset($p['id_order_payment']);
				}

				$p['id_order'] = $ret['message'];
				$this->db->insert('order_payment', $p);
			}
		}

		$this->db->where('id_order', $ret['message']);
		$this->db->update('orders', array(
			'transfer_date' => $max_transfer_date,
			'transferred_amount' => round($total_transfer_amount, 6),
			'balance_amount' => round($order_info['grand_total'] - $total_transfer_amount, 2)
		));

		// Check change status to Verifying
		if ((empty($old_order) || empty($old_status) || $old_status == 'Ordered') && $old_slip == 0 && $new_slip > 0) {
			$this->db->where('id_order', $ret['message']);
			$this->db->update('orders', array('status' => 'Verifying'));
		}

		// Check Unlink Deleted Image
		$this->load->library('../controllers/home');
		$this->home->check_deleted_image(false, 'order_transfer_slip', $ret['message']);

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function update_order_status()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		$this->db->where('id_order', $_POST['id_order']);
		$this->db->update('orders', array('status' => $_POST['order_status']));

		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function _getOrderNumber()
	{
		$current_year = date('Y');

		$this->db->order_by('id_order', 'DESC');
		$orders = $this->db->get('orders')->result_array();
		if (count($orders) == 0) {
			$lastest_year = $current_year;
		} else {
			$lastest_year = date('Y', strtotime($orders[0]['date_created']));
		}

		if ($lastest_year == $current_year) {
			$this->db->where('name', 'order_number_running');
			$this->db->update('setting', array('value' => $this->settings['order_number_running'] + 1, 'updated' => date('Y-m-d H:i:s')));
			return 'OD-' . $lastest_year . '-' . str_pad($this->settings['order_number_running'] + 1, 5, '0', STR_PAD_LEFT);
		} else {
			$this->db->where('name', 'order_number_running');
			$this->db->update('setting', array('value' => 1, 'updated' => date('Y-m-d H:i:s')));
			return 'OD-' . $lastest_year . '-00001';
		}
	}

	public function _getOrder($id_order = '')
	{
		if (empty($id_order)) {
			return;
		}

		$this->db->select('*')
			->select('business_info.phone_number AS "business_info_phone_number"')
			->select('project_policy.description_en AS "project_policy_description_en", project_policy.description_th AS "project_policy_description_th"')
			->from('orders')
			->join('guest_info', 'orders.id_guest_info = guest_info.id_guest')
			->join('project_info', 'orders.id_project_info = project_info.id_project_info')
			->join('project_policy', "project_info.id_project_info = project_policy.id_project_info AND project_policy.policy_type_en = 'Cancellation Policy'", 'LEFT')
			->join('business_info', 'project_info.id_business_info = business_info.id_business_info')
			->where('orders.id_order', $id_order);
		$order = $this->db->get()->row_array();

		$this->db->where('id_order', $id_order);
		$order_item = $this->db->get('order_item')->result_array();

		/////
		require(APPPATH . '/third_party/fpdf/fpdf.php');
		define('FPDF_FONTPATH', 'font/');
		$pdf = new FPDF();
		$pdf->AddFont('angsa', '', 'angsa.php');
		$pdf->AddFont('angsa', 'B', 'angsab.php');
		$pdf->AddFont('angsa', 'I', 'angsai.php');

		$pdf->AddPage();
		$image = site_url() . "images/SMS_Logo_Final.png";
		$pdf->Cell(30, 40, $pdf->Image($image, $pdf->GetX(), $pdf->GetY(), 30), 0, 0, 'L', false);

		$pdf->SetY($pdf->GetY() + 13);
		$pdf->SetFont('angsa', 'B', 18);
		$pdf->Cell(30, 0, '');
		$pdf->Cell(80, 11.5, _t($order['project_name_en'], $order['project_name_th']));

		$pdf->SetFont('angsa', 'I', 18);
		$pdf->SetFillColor(131, 146, 135);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(80, 8, _t('Order Number: ', 'เลขที่ออเดอร์: ') . $order['order_number'], 0, 0, 'C', true);

		////////// Right Side ----------------------------------------------------------------------------------------------------------------------------
		$pdf->SetY(43);
		$pdf->SetX(120);
		$pdf->SetFont('angsa', '', 16);
		$pdf->Cell(80, 6.5, _t('Invoice # ', 'หมายเลขใบเสร็จ # ') . $order['id_order'], 0, 0, 'L', true);

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->SetX(123);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('angsa', 'B', 16);
		$pdf->Cell(55, 7, _t('Grand Total', 'ยอดรวมทั้งสิ้น'));
		$pdf->Cell(20, 7, number_format($order['grand_total'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 9);
		$pdf->SetX(123);
		$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 75, $pdf->GetY());
		$pdf->SetX(123);
		$pdf->SetFont('angsa', '', 16);
		$pdf->Cell(55, 7, _t('VAT', 'ภาษี') . ' (7%)');
		$pdf->Cell(20, 7, number_format($order['vat'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 5);
		$pdf->SetX(123);
		$pdf->Cell(55, 7, _t('Subtotal', 'ยอดก่อนภาษี'));
		$pdf->Cell(20, 7, number_format($order['sub_total'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->SetX(120);
		$pdf->Cell(80, 6.5, '', 0, 0, '', true);

		////////// Left Side ----------------------------------------------------------------------------------------------------------------------------
		$pdf->SetY(43);
		$pdf->SetX(10);
		$pdf->SetFont('angsa', '', 16);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Company Name:', 'ชื่อบริษัท:'));
		$pdf->MultiCell(60, 7, _t($order['business_name_en'], $order['business_name_th']), 0, 'L', false);

		/////
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Company Address:', 'ที่อยู่บริษัท:'));
		$pdf->MultiCell(60, 7, _t($order['business_address_en'], $order['business_address_th']), 0, 'L', false);

		/////
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Company TAX ID:', 'เลขประจำตัวผู้เสียภาษี:'));
		$pdf->Cell(60, 7, $order['business_tax_id']);

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Contact Number:', 'เบอร์โทรติดต่อ:'));
		$pdf->Cell(60, 7, $order['business_info_phone_number']);

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Bank:', 'ชื่อธนาคาร:'));
		$pdf->Cell(60, 7, 'Kasikorn Bank');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Account Name:', 'ชื่อบัญชี:'));
		$pdf->Cell(60, 7, 'BuilderSmart (Public) Co., Ltd.');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Account Number:', 'หมายเลขบัญชี:'));
		$pdf->Cell(60, 7, '145-1-69629-3');

		/////
		$pdf->SetY($pdf->GetY() + 4);
		$pdf->Cell(113, 0, '');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(110, 0, '');

		/////
		$pdf->SetY($pdf->GetY() + 9);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Customer Name:', 'ชื่อลูกค้า:'));
		$pdf->Cell(60, 7, $order['guest_name']);

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Customer TAX ID:', 'เลขประจำตัวผู้เสียภาษี:'));
		$pdf->Cell(60, 7, empty($order['guest_tax_id']) ? '-' : $order['guest_tax_id']);

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Contact Number:', 'เบอร์โทรติดต่อ:'));
		$pdf->Cell(60, 7, empty($order['guest_contact_number']) ? '-' : $order['guest_contact_number']);

		$pdf->SetX(148);
		$pdf->Cell(30, 7, _t('Service Date:', 'วันที่ใช้บริการ:'));
		$pdf->Cell(20, 7, formatDate($order['order_date']), 0, 0, 'R');

		///////// Order Item ----------------------------------------------------------------------------------------------------------------------------
		$pdf->SetY($pdf->GetY() + 9);
		$pdf->SetFont('angsa', 'B', 16);
		$pdf->SetFillColor(131, 146, 135);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(190.3, 7, _t('Order Items:', 'รายการออเดอร์:'), 0, 0, 'L', true);

		/////
		$pdf->SetY($pdf->GetY() + 10);
		$pdf->SetFont('angsa', 'B', 13);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Cell(9, 0, '');
		$pdf->Cell(15, 10, _t('No.', 'ลำดับ'), 1, 0, 'C');
		$pdf->Cell(92, 10, _t('Description', 'รายละเอียด'), 1, 0, 'C');
		$pdf->Cell(25, 10, _t('Unit Price', 'ราคา'), 1, 0, 'C');
		$pdf->Cell(18, 10, _t('Quantity', 'จำนวน'), 1, 0, 'C');
		$pdf->Cell(25, 10, _t('Total', 'ยอดรวม'), 1, 0, 'C');
		$pdf->SetFont('angsa', '', 13);
		foreach ($order_item as $i => $oi) {
			$pdf->SetY($pdf->GetY() + 10);
			$pdf->Cell(9, 0, '');
			$pdf->Cell(15, 10, ($i + 1) . '.', 1, 0, 'C');
			$pdf->Cell(92, 10, '  ' . $oi['item_name'], 1, 0, 'L');
			$pdf->Cell(25, 10, number_format($oi['unit_cost'], 2) . '  ', 1, 0, 'R');
			$pdf->Cell(18, 10, $oi['quantity'], 1, 0, 'C');
			$pdf->Cell(25, 10, number_format($oi['unit_cost'] * $oi['quantity'], 2) . '  ', 1, 0, 'R');
		}

		////////// Note ------------------------------------------------------------------------------------------------------------------------------------
		$pdf->SetY($pdf->GetY() + 15);
		$pdf->SetFont('angsa', 'B', 16);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(190.3, 7, $order['project_policy_description_en'] ? _t('Notes:', 'หมายเหตุ:') : '', 0, 'L', true);

		$pdf->SetFont('angsa', '', 15);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->MultiCell(190.3, 7, '         ' . _t($order['project_policy_description_en'], $order['project_policy_description_th']), 0, 'L', true);
		$pdf->Cell(190.3, 3, '', 0, 0, 'L', true);

		return $pdf;
	}

	public function showOrder($id_order = '')
	{
		if (empty($id_order)) {
			return;
		}

		$pdf = $this->_getOrder($id_order);
		$pdf->Output();
	}

	// Calculate Order Price
	public function _calculate_order_price($order = '', $order_extra = array())
	{
		$ret = array('sub_total' => 0, 'vat' => 0, 'grand_total' => 0, 'order_item' => array());
		if (empty($order)) {
			return $ret;
		}

		// extra
		foreach ($order_extra as $extra) {
			if (!empty($extra['quantity']) && intval($extra['quantity']) > 0) {
				$ret['grand_total'] += intval($extra['quantity']) * floatval($extra['unit_cost']);
				$ret['order_item'][] = array(
					'id_order' => $order['id_order'],
					'id_extras' => $extra['id_extras'],
					'item_name' => $extra['item_name'],
					'quantity' => intval($extra['quantity']),
					'unit_cost' => $extra['unit_cost']
				);
			}
		}

		// cal vat
		$ret['vat'] = round($ret['grand_total'] * 7 / 107, 2);
		$ret['sub_total'] = round($ret['grand_total'] - $ret['vat'], 2);
		return $ret;
	}

	public function calculate_order_price()
	{
		header('Content-Type: application/json; charset=utf-8');
		$ret = array('result' => 'false', 'message' => '');

		if (empty($_POST['order'])) {
			$ret['message'] = 'Empty Order Info';
			echo json_encode($ret);
			return;
		}

		$ret['message'] = $this->_calculate_order_price($_POST['order'], $_POST['order_item']);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function test_send_email()
	{
		$this->db->select('*');
		$this->db->from('booking');
		$this->db->where('booking_number', '2023-00327');
		$order = $this->db->get()->row_array();
		$old_status = '';
		$this->_checkSendEmailBooked($order, $old_status);
		//$this->_sendEmail($to = 'mychelle@buildersmart.com', $subject = 'Test', $message = 'Test', $attachment = '');
	}
}
