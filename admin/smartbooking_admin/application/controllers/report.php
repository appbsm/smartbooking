<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends MY_Controller {
	function __construct() {
        parent::__construct();
		$this->_data['active_menu'] = 'report';
		$this->load->library('../controllers/pos');
    }

	// Reservation Report
	public function reservation_report()
	{
		if (!has_permission('reservation_report', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['reservations'] = $this->_getReservations();
		$this->render();
	}

	

	public function _getReservations($date_type = 'Booked', $date_from = '', $date_to = '')
	{
		$this->db->select('*');
		$this->db->select('booking.number_of_adults AS adults, booking.number_of_children AS children, user_mgt.name AS staff_name');
		$this->db->from('booking');
		$this->db->join('booking_item', 'booking.booking_number = booking_item.booking_number');
		$this->db->join('room_details', 'booking_item.id_room_details = room_details.id_room_details', 'LEFT');
		$this->db->join('room_type', 'room_details.id_room_type = room_type.id_room_type', 'LEFT');
		$this->db->join('user_mgt', 'booking.staff_id = user_mgt.id_user', 'LEFT');
		$this->db->join('discount', 'booking.id_discount_code = discount.id_discount', 'LEFT');
		$this->db->where_not_in('booking.status', array('Expired', 'Cancel'));

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

		$booking = $this->db->get()->result_array();
		$rows = array();

		foreach ($booking as $i => $b) {
			if ($this->pos->_is_expired($b)) {
				$b['status'] = 'Expired';
			}

			if (!empty($b['id_package'])) {
				$found = false;
				foreach ($rows as $j => $r) {
					if ($r['id_booking'] == $b['id_booking'] && $r['type'] == 'package' && $r['id_package'] == $b['id_package']) {
						$rows[$j]['data'][] = $b;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$rows[] = array(
						'id_booking' => $b['id_booking'],
						'type' => 'package',
						'id_package' => $b['id_package'],
						'data' => array($b)
					);
				}
			} elseif (!empty($b['id_room_details'])) {
				$found = false;
				foreach ($rows as $j => $r) {
					if ($r['id_booking'] == $b['id_booking'] && $r['type'] == 'room' && $r['id_room_details'] == $b['id_room_details']) {
						$rows[$j]['data'][] = $b;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$rows[] = array(
						'id_booking' => $b['id_booking'],
						'type' => 'room',
						'id_room_details' => $b['id_room_details'],
						'data' => array($b)
					);
				}
			} elseif (!empty($b['id_extras'])) {
				$found = false;
				foreach ($rows as $j => $r) {
					if ($r['id_booking'] == $b['id_booking'] && $r['type'] == 'extra' && $r['id_extras'] == $b['id_extras']) {
						$rows[$j]['data'][] = $b;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$rows[] = array(
						'id_booking' => $b['id_booking'],
						'type' => 'extra',
						'id_extras' => $b['id_extras'],
						'data' => array($b)
					);
				}
			}
		}

		foreach ($rows as $i => $row) {
			$full_unit_cost_arr = array_col($row['data'], 'full_unit_cost');
			sort($full_unit_cost_arr);

			$d = $row['data'][0];
			//print_r(substr($d['booking_date'], 0, 10));
			//echo "<br>";
			$length_of_stay = dateDiff($d['check_in_date'], $d['check_out_date']);
			$rows[$i] = array(
				'no' => $i + 1,
				'id_booking' => $d['id_booking'],
				'booking_number' => $d['booking_number'],
				'guest_name' => $d['guest_name'],
				'booking_date' => date('Y-m-d', strtotime($d['booking_date'])),
				'check_in_date' => $d['check_in_date'],
				'check_out_date' => $d['check_out_date'],
				'item_description' => empty($d['id_package']) ? $d['item_name'] : $d['package_name'],
				'pax' => $d['adults'] .' | '. $d['children'],
				'channel' => $d['is_backend'] ? 'Backend' : 'Front',
				'staff_name' => empty($d['staff_name']) ? '' : $d['staff_name'],
				'length_of_stay' => $length_of_stay,
				'rate' => empty($d['id_package']) ? implode(' | ', numberFormatArray($full_unit_cost_arr)) : number_format($d['full_package_price']),
				'quantity' => 0,
				'total_before_discount' => empty($d['id_package']) ? 0 : number_format($d['full_package_price'] * $length_of_stay),
				'sub_total' => 0,
				'vat' => 0,
				'discount' => empty($d['id_package']) ? 0 : (($d['full_package_price'] - $d['package_price']) * $d['package_qty'] * $d['quantity']),
				'total' => empty($d['id_package']) ? 0 : ($d['package_price'] * $d['package_qty'] * $d['quantity'])
			);

			foreach ($row['data'] as $j => $r) {
				if (empty($d['id_package'])) {
					$rows[$i]['quantity'] += $r['quantity'];	
					$rows[$i]['total_before_discount'] += $r['full_unit_cost'] * $r['quantity'];	
					$rows[$i]['total'] += $r['unit_cost'] * $r['quantity'];					
					$rows[$i]['discount'] += $r['discount'] * $r['quantity'];
				}
			}

			$rows[$i]['vat'] = round($rows[$i]['total'] * 7 / 107, 2);
			$rows[$i]['total'] = round($rows[$i]['total'], 2);			
			$rows[$i]['sub_total'] = round($rows[$i]['total'] - $rows[$i]['vat'], 2);
			$rows[$i]['discount'] = round($rows[$i]['discount'], 2);
		}

		return $rows;
	}

	public function get_reservation_report()
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

		$ret['message'] = $this->_getReservations($_POST['date_type'], $start, $end);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	public function test_report () {
		$date_type = "Booking";
		$start = '2023-09-01';
		$end = '2023-09-30';
		//$res = $this->_getReservations($date_type, $start, $end); // 
		
		
		$range = 'Month';
		$from_day = '2023-09-01';
		$to_day = '2023-09-30';
		$month = '2023-10';
		$res = $this->_getRevenue($from_day, $to_day);

		print_r($res);
		/*
		foreach ($res as $row) {
			print_r($row);
			echo "<br>";
		}
		*/
	}

	// Daily Revenue Report
	public function daily_revenue_report()
	{
		if (!has_permission('daily_revenue_report', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['revenue'] = $this->_getRevenue();
		$this->render();
	}

	public function _getRevenue($date_from = '', $date_to = '')
	{
		///// Booking Item
		$this->db->select('*');
		$this->db->select('user_mgt.name AS staff_name, booking_item_date.date AS date');
		$this->db->from('booking_item');
		$this->db->join('booking_item_date', 'booking_item.id_booking_item = booking_item_date.id_booking_item');
		$this->db->join('booking', 'booking_item.id_booking = booking.id_booking');
		$this->db->join('user_mgt', 'booking.staff_id = user_mgt.id_user', 'left');
		$this->db->join('discount', 'booking.id_discount_code = discount.id_discount', 'left');

		$date = date('Y-m-d');
		if (empty($date_from)) {
			$date_from = $date;
		}
		if (empty($date_to)) {
			$date_to = $date;
		}

		$this->db->where('booking_item_date.date >=', $date_from);
		$this->db->where('booking_item_date.date <=', $date_to);
		$this->db->where_in('booking.status', array('Verifying', 'Confirmed', 'Checked-in', 'Checked-out', 'Cancel'));
		$this->db->order_by('booking.id_booking');

		$booking_item = $this->db->get()->result_array();
		$rows = array();

		foreach ($booking_item as $i => $b) {
			if ($this->pos->_is_expired($b)) {
				$b['status'] = 'Expired';
			}

			if (!empty($b['id_package'])) {
				$found = false;
				foreach ($rows as $j => $r) {
					if ($r['id_booking'] == $b['id_booking'] && $r['type'] == 'package' && $r['id_package'] == $b['id_package'] && $r['date'] == $b['date']) {
						$rows[$j]['data'][] = $b;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$rows[] = array(
						'id_booking' => $b['id_booking'],
						'type' => 'package',
						'id_package' => $b['id_package'],
						'date' => $b['date'],
						'data' => array($b)
					);
				}
			} elseif (!empty($b['id_room_details'])) {
				$found = false;
				foreach ($rows as $j => $r) {
					if ($r['id_booking'] == $b['id_booking'] && $r['type'] == 'room' && $r['id_room_details'] == $b['id_room_details'] && $r['date'] == $b['date']) {
						$rows[$j]['data'][] = $b;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$rows[] = array(
						'id_booking' => $b['id_booking'],
						'type' => 'room',
						'id_room_details' => $b['id_room_details'],
						'date' => $b['date'],
						'data' => array($b)
					);
				}
			} elseif (!empty($b['id_extras'])) {
				$found = false;
				foreach ($rows as $j => $r) {
					if ($r['id_booking'] == $b['id_booking'] && $r['type'] == 'extra' && $r['id_extras'] == $b['id_extras'] && $r['date'] == $b['date']) {
						$rows[$j]['data'][] = $b;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$rows[] = array(
						'id_booking' => $b['id_booking'],
						'type' => 'extra',
						'id_extras' => $b['id_extras'],
						'date' => $b['date'],
						'data' => array($b)
					);
				}
			}
		}

		foreach ($rows as $i => $row) {
			$d = $row['data'][0];
			//print_r($d);
			$length_of_stay = dateDiff($d['check_in_date'], $d['check_out_date']);
			$rows[$i] = array(
				'revenue_type' => $d['status'] == 'Cancel' ? 'Cancellations' : ($row['type'] == 'extra' ? 'Extra Charge' : 'Room Booking'),
				'id_booking' => $d['id_booking'],
				'id_order' => '',
				'booking_channel' => $d['is_backend'] ? 'Backend' : 'Front',
				'booking_date' => date('Y-m-d', strtotime($d['booking_date'])),
				'check_in_date' => $d['check_in_date'],
				'date' => $d['date'],
				'booking_number' => $d['booking_number'],
				'order_number' => '',
				'item_description' => empty($d['id_package']) ? $d['item_name'] : $d['package_name'],
				'staff_name' => empty($d['staff_name']) ? '' : $d['staff_name'],
				'credit_term' => $d['credit_term'],
				'credit_due_date' => $d['credit_due_date'],
				'status' => $d['status'],
				'total_before_discount' => empty($d['id_package']) ? ($d['full_unit_cost'] * ($row['type'] == 'extra' ? $d['quantity'] : 1)) : ($d['package_price'] * $d['package_qty']),
				'sub_total' => 0,
				'vat' => 0,
				'discount' => empty($d['id_package']) ? ($d['discount'] * ($row['type'] == 'extra' ? $d['quantity'] : 1)) : (($d['full_package_price'] - $d['package_price']) * $d['package_qty']),
				'total' => empty($d['id_package']) ? ($d['unit_cost'] * ($row['type'] == 'extra' ? $d['quantity'] : 1)) : ($d['package_price'] * $d['package_qty'])				
			);

			$rows[$i]['vat'] = round($rows[$i]['total'] * 7 / 107, 2);
			$rows[$i]['total_before_discount'] = round($rows[$i]['total_before_discount'], 2);
			//$rows[$i]['total_before_discount'] = 0;
			$rows[$i]['total'] = round($rows[$i]['total'], 2);
			$rows[$i]['sub_total'] = round($rows[$i]['total'] - $rows[$i]['vat'], 2);
			$rows[$i]['discount'] = round($rows[$i]['discount'], 2);
		}
		$booking_revenue = $rows;

		///// Order Item
		$this->db->select('*');
		$this->db->select('user_mgt.name AS staff_name, orders.status As status, orders.order_date AS date');
		$this->db->from('order_item');
		$this->db->join('orders', 'order_item.id_order = orders.id_order');
		$this->db->join('user_mgt', 'orders.staff_id = user_mgt.id_user', 'LEFT');
		$this->db->join('booking', 'orders.id_booking = booking.id_booking', 'LEFT');

		$date = date('Y-m-d');
		if (empty($date_from)) {
			$date_from = $date;
		}
		if (empty($date_to)) {
			$date_to = $date;
		}

		$this->db->where('orders.order_date >=', $date_from);
		$this->db->where('orders.order_date <=', $date_to);
		$this->db->where_in('orders.status', array('Verifying', 'Confirmed', 'Checked-in', 'Checked-out', 'Cancel'));
		$this->db->order_by('orders.id_order');

		$order_item = $this->db->get()->result_array();
		$rows = array();

		foreach ($order_item as $i => $b) {
			if ($this->pos->_is_expired_order($b)) {
				$b['status'] = 'Expired';
			}

			$found = false;
			foreach ($rows as $j => $r) {
				if ($r['id_order'] == $b['id_order'] && $r['type'] == 'extra' && $r['id_extras'] == $b['id_extras'] && $r['date'] == $b['order_date']) {
					$rows[$j]['data'][] = $b;
					$found = true;
					break;
				}
			}

			if (!$found) {
				$rows[] = array(
					'id_order' => $b['id_order'],
					'type' => 'extra',
					'id_extras' => $b['id_extras'],
					'date' => $b['order_date'],
					'data' => array($b)
				);
			}
		}

		foreach ($rows as $i => $row) {
			$d = $row['data'][0];
			
			$rows[$i] = array(
				'revenue_type' => $d['status'] == 'Cancel' ? 'Cancellations' : 'Extra Charge',
				'id_booking' => empty($d['id_booking']) ? '' : $d['id_booking'],
				'id_order' => $d['id_order'],
				'booking_channel' => empty($d['id_booking']) ? 'Backend' : ($d['is_backend'] ? 'Backend' : 'Front'),
				'check_in_date' => $d['order_date'],
				'date' => $d['date'],
				'booking_number' => $d['booking_number'],
				'order_number' => $d['order_number'],
				'item_description' => $d['item_name'],
				'staff_name' => empty($d['staff_name']) ? '' : $d['staff_name'],
				'credit_term' => $d['credit_term'],
				'credit_due_date' => $d['credit_due_date'],
				'status' => $d['status'],				
				'total_before_discount' => $d['unit_cost'] * $d['quantity'],
				'sub_total' => 0,
				'vat' => 0,
				'discount' => 0,
				'total' => $d['unit_cost'] * $d['quantity']
			);

			$rows[$i]['vat'] = round($rows[$i]['total'] * 7 / 107, 2);
			//$rows[$i]['total_before_discount'] = 0;
			$rows[$i]['total_before_discount'] = round($rows[$i]['total_before_discount'], 2);
			$rows[$i]['total'] = round($rows[$i]['total'], 2);
			$rows[$i]['sub_total'] = round($rows[$i]['total'] - $rows[$i]['vat'], 2);
			$rows[$i]['discount'] = round($rows[$i]['discount'], 2);
		}
		$order_revenue = $rows;

		/////
		return array_merge($booking_revenue, $order_revenue);
	}

	public function get_daily_revenue_report()
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

		$ret['message'] = $this->_getRevenue($start, $end);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	// Payment Report
	public function payment_report()
	{
		if (!has_permission('payment_report', 'view')) {
			header("Location: ". home_url());
		}

		$this->_data['reservations'] = $this->_getPayments();
		$this->render();
	}

	public function _getPayments($date_type = 'Booked', $date_from = '', $date_to = '', $payment_status = '')
	{
		$this->db->select('*');
		$this->db->select('booking.number_of_adults AS adults, booking.number_of_children AS children, user_mgt.name AS staff_name');
		$this->db->from('booking');
		$this->db->join('booking_item', 'booking.booking_number = booking_item.booking_number');
		$this->db->join('room_details', 'booking_item.id_room_details = room_details.id_room_details', 'LEFT');
		$this->db->join('room_type', 'room_details.id_room_type = room_type.id_room_type', 'LEFT');
		$this->db->join('user_mgt', 'booking.confirm_staff_id = user_mgt.id_user', 'LEFT');
		$this->db->join('discount', 'booking.id_discount_code = discount.id_discount', 'LEFT');
		$this->db->where_not_in('booking.status', array('Expired', 'Cancel'));

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

		$this->db->order_by('booking.id_booking, booking_item.full_unit_cost');
		$booking = $this->db->get()->result_array();
		$rows = array();

		foreach ($booking as $i => $b) {
			if ($this->pos->_is_expired($b)) {
				$b['status'] = 'Expired';
			}

			$found = false;
			foreach ($rows as $j => $r) {
				if ($r['id_booking'] == $b['id_booking']) {
					$rows[$j]['data'][] = $b;
					$found = true;
					break;
				}
			}

			if (!$found) {
				$rows[] = array(
					'id_booking' => $b['id_booking'],
					'data' => array($b)
				);
			}
		}

		foreach ($rows as $i => $row) {
			$item_price = array();
			$item_name = array();
			$package = array();
			$room = array();

			foreach ($row['data'] as $d) {
				if (!empty($d['id_extras'])) {
					$item_price[] = $d['full_unit_cost'];
					$item_name[] = $d['item_name'];
				}
			}
			foreach ($row['data'] as $d) {
				if (!empty($d['id_room_details']) && empty($d['id_package'])) {
					$item_price[] = $d['full_unit_cost'];
					if (!in_array($d['id_room_details'], $room)) {
						$room[] = $d['id_room_details'];
						$item_name[] = $d['item_name'];
					}
				}
			}
			foreach ($row['data'] as $d) {
				if (!empty($d['id_package']) && !in_array($d['id_package'], $package)) {
					$package[] = $d['id_package'];
					$item_price[] = $d['full_package_price'];
					$item_name[] = $d['package_name'];
				}
			}

			$d = $row['data'][0];
			$length_of_stay = dateDiff($d['check_in_date'], $d['check_out_date']);
			$rows[$i] = array(
				'no' => $i + 1,
				'id_booking' => $d['id_booking'],
				'booking_number' => $d['booking_number'],
				'guest_name' => $d['guest_name'],
				'booking_date' => date('Y-m-d', strtotime($d['booking_date'])),
				'check_in_date' => $d['check_in_date'],
				'check_out_date' => $d['check_out_date'],
				'status' => $d['status'],
				'payment_status' => $d['balance_amount'] == 0 ? 'Paid' : ($d['transferred_amount'] == 0 ? 'Not Paid' : 'Partial'),
				'paid_date' => empty($d['transfer_date']) ? '' : $d['transfer_date'],
				'receipt_no' => empty($d['transfer_date']) ? '' : ('# '. $d['id_booking']),
				'item_description' => implode(', ', $item_name),
				'pax' => $d['adults'] .' | '. $d['children'],
				'channel' => $d['is_backend'] ? 'Backend' : 'Front',
				'credit_term' => $d['credit_term'],
				'credit_due_date' => $d['credit_due_date'],
				'staff_name' => empty($d['staff_name']) ? '' : $d['staff_name'],
				'length_of_stay' => dateDiff($d['check_in_date'], $d['check_out_date']),
				'rate' => implode(' | ', numberFormatArray($item_price)),
				'total_before_discount' => empty($d['id_package']) ? 0 : ($d['package_price'] * $d['package_qty'] * $d['quantity']),
				'sub_total' => 0,
				'vat' => 0,
				'discount' => empty($d['id_package']) ? 0 : (($d['full_package_price'] - $d['package_price']) * $d['package_qty'] * $d['quantity']),
				'total' => empty($d['id_package']) ? 0 : ($d['package_price'] * $d['package_qty'] * $d['quantity'])
			);

			foreach ($row['data'] as $j => $r) {
				if (empty($d['id_package'])) {
					$rows[$i]['total_before_discount'] += $r['full_unit_cost'] * $r['quantity'];
					$rows[$i]['total'] += $r['unit_cost'] * $r['quantity'];
					$rows[$i]['discount'] += $r['discount'] * $r['quantity'];
				}
			}

			$rows[$i]['vat'] = round($rows[$i]['total'] * 7 / 107, 2);
			$rows[$i]['total'] = round($rows[$i]['total'], 2);
			$rows[$i]['total_before_discount'] = round($rows[$i]['total_before_discount'], 2);
			$rows[$i]['sub_total'] = round($rows[$i]['total'] - $rows[$i]['vat'], 2);
			$rows[$i]['discount'] = round($rows[$i]['discount'], 2);
		}

		// filter
		$tmp = array();
		foreach ($rows as $i => $row) {
			if (!empty($payment_status) && $payment_status != 'All' && $payment_status != $row['payment_status']) {
				continue;
			}

			$tmp[] = $row;
		}
		$rows = $tmp;

		return $rows;
	}

	public function get_payment_report()
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

		$ret['message'] = $this->_getPayments($_POST['date_type'], $start, $end, $_POST['payment_status']);
		$ret['result'] = 'true';
		echo json_encode($ret);
	}

	
	/* NOT USED
	public function _getAR($date_type = 'Booked', $date_from = '', $date_to = '', $payment_status = '')
	{
		$this->db->select('*');
		$this->db->select('booking.number_of_adults AS adults, booking.number_of_children AS children, user_mgt.name AS staff_name');
		$this->db->from('booking');
		$this->db->join('booking_item', 'booking.booking_number = booking_item.booking_number');
		$this->db->join('room_details', 'booking_item.id_room_details = room_details.id_room_details', 'LEFT');
		$this->db->join('room_type', 'room_details.id_room_type = room_type.id_room_type', 'LEFT');
		$this->db->join('user_mgt', 'booking.confirm_staff_id = user_mgt.id_user', 'LEFT');
		$this->db->join('discount', 'booking.id_discount_code = discount.id_discount', 'LEFT');
		$this->db->where_not_in('booking.status', array('Expired', 'Cancel'));

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

		$this->db->order_by('booking.id_booking, booking_item.full_unit_cost');
		$booking = $this->db->get()->result_array();
		$rows = array();

		foreach ($booking as $i => $b) {
			if ($this->pos->_is_expired($b)) {
				$b['status'] = 'Expired';
			}

			$found = false;
			foreach ($rows as $j => $r) {
				if ($r['id_booking'] == $b['id_booking']) {
					$rows[$j]['data'][] = $b;
					$found = true;
					break;
				}
			}

			if (!$found) {
				$rows[] = array(
					'id_booking' => $b['id_booking'],
					'data' => array($b)
				);
			}
		}

		foreach ($rows as $i => $row) {
			$item_price = array();
			$item_name = array();
			$package = array();
			$room = array();

			foreach ($row['data'] as $d) {
				if (!empty($d['id_extras'])) {
					$item_price[] = $d['full_unit_cost'];
					$item_name[] = $d['item_name'];
				}
			}
			foreach ($row['data'] as $d) {
				if (!empty($d['id_room_details']) && empty($d['id_package'])) {
					$item_price[] = $d['full_unit_cost'];
					if (!in_array($d['id_room_details'], $room)) {
						$room[] = $d['id_room_details'];
						$item_name[] = $d['item_name'];
					}
				}
			}
			foreach ($row['data'] as $d) {
				if (!empty($d['id_package']) && !in_array($d['id_package'], $package)) {
					$package[] = $d['id_package'];
					$item_price[] = $d['full_package_price'];
					$item_name[] = $d['package_name'];
				}
			}

			$d = $row['data'][0];
			$length_of_stay = dateDiff($d['check_in_date'], $d['check_out_date']);
			$rows[$i] = array(
				'no' => $i + 1,
				'id_booking' => $d['id_booking'],
				'booking_number' => $d['booking_number'],
				'guest_name' => $d['guest_name'],
				'booking_date' => date('Y-m-d', strtotime($d['booking_date'])),
				'check_in_date' => $d['check_in_date'],
				'check_out_date' => $d['check_out_date'],
				'payment_status' => $d['balance_amount'] == 0 ? 'Paid' : ($d['transferred_amount'] == 0 ? 'Not Paid' : 'Partial'),
				'paid_date' => empty($d['transfer_date']) ? '' : $d['transfer_date'],
				'receipt_no' => empty($d['transfer_date']) ? '' : ('# '. $d['id_booking']),
				'item_description' => implode(', ', $item_name),
				'pax' => $d['adults'] .' | '. $d['children'],
				'channel' => $d['is_backend'] ? 'Backend' : 'Front',
				'credit_term' => $d['credit_term'],
				'credit_due_date' => $d['credit_due_date'],
				'staff_name' => empty($d['staff_name']) ? '' : $d['staff_name'],
				'length_of_stay' => dateDiff($d['check_in_date'], $d['check_out_date']),
				'rate' => implode(' | ', numberFormatArray($item_price)),
				'total_before_discount' => empty($d['id_package']) ? 0 : ($d['package_price'] * $d['package_qty'] * $d['quantity']),
				'sub_total' => 0,
				'vat' => 0,
				'discount' => empty($d['id_package']) ? 0 : (($d['full_package_price'] - $d['package_price']) * $d['package_qty'] * $d['quantity']),
				'total' => empty($d['id_package']) ? 0 : ($d['package_price'] * $d['package_qty'] * $d['quantity'])
			);

			foreach ($row['data'] as $j => $r) {
				if (empty($d['id_package'])) {
					$rows[$i]['total_before_discount'] += $r['full_unit_cost'] * $r['quantity'];
					$rows[$i]['total'] += $r['unit_cost'] * $r['quantity'];
					$rows[$i]['discount'] += $r['discount'] * $r['quantity'];
				}
			}

			$rows[$i]['vat'] = round($rows[$i]['total'] * 7 / 107, 2);
			$rows[$i]['total'] = round($rows[$i]['total'], 2);
			$rows[$i]['total_before_discount'] = round($rows[$i]['total_before_discount'], 2);
			$rows[$i]['sub_total'] = round($rows[$i]['total'] - $rows[$i]['vat'], 2);
			$rows[$i]['discount'] = round($rows[$i]['discount'], 2);
		}

		// filter
		$tmp = array();
		foreach ($rows as $i => $row) {
			if (!empty($payment_status) && $payment_status != 'All' && $payment_status != $row['payment_status']) {
				continue;
			}

			$tmp[] = $row;
		}
		$rows = $tmp;

		return $rows;
	} */
	
	// AR Report
	public function ar_report()
	{
		if (!has_permission('ar_report', 'view')) {
			header("Location: ". home_url());
		}
		$arr_payments = array();
		$payments = $this->_getPayments();
		$xclude = array('Cancel', 'Expired');
		foreach ($payments as $p) {
			if (!in_array($p['status'], $xclude)) {
				$arr_payments[] = $p;
			}
		}
		$this->_data['reservations'] = $arr_payments;
		
		$this->render();
	}


	public function get_ar_report()
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
		$arr_payments = array();
		$payments = $this->_getPayments($_POST['date_type'], $start, $end, $_POST['payment_status']);
		$xclude = array('Cancel', 'Expired');
		foreach ($payments as $p) {
			if (!in_array($p['status'], $xclude)) {
				$arr_payments[] = $p;
			}
		}
		$ret['message'] = $arr_payments;
		$ret['result'] = 'true';
		echo json_encode($ret);
	}
	
	
}