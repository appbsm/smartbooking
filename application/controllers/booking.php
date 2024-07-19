<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_project_info');
		$this->load->model('m_guest');
		$this->load->model('m_booking');
		$this->load->model('m_extra');
		$this->load->model('m_cart');
		$this->load->model('m_package');
		$this->load->model('m_discount');
		$this->load->model('m_credit_term');
		//if(!$this->session->userdata('id_guest')){
		//redirect('login');
		//header("Location: ". login_url());
		//}
		$this->id_project_info = 1;
		$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
		if ($lg == 'thai') {
			$this->lang->load('content', 'thai');
		} elseif ($lg == 'english') {
			$this->lang->load('content', 'english');
		}
		$this->language  = $lg;
	}

	function daysBetween($dt1, $dt2)
	{
		return date_diff(
			date_create($dt2),
			date_create($dt1)
		)->format('%a');
	}

	public function test_date_diff()
	{
		$date1 = '06-01-2023';
		$date2 = '10-01-2023';
		$diff = $this->daysBetween($date1, $date2);
		echo $diff;
	}

	public function guest_info()
	{
		$id_guest = $this->session->userdata('id_guest');
		if (!empty($_POST)) {
			if ($this->input->post('h_id_room') != '') {
				$data['rooms'] = $this->input->post('h_id_room');
			}
			if ($this->input->post('h_id_package') != '') {
				$id_package = $this->input->post('h_id_package');
				$data['id_package'] = $id_package;
			}
			$data['number_of_adult'] = $this->input->post('h_num_of_adult');
			$data['number_of_room'] = $this->input->post('h_num_of_room');
			$data['number_of_children'] = $this->input->post('h_num_of_children');
			$data['children_ages'] = $this->input->post('h_children_ages');
			$data['page'] = $this->input->post('page');
			$check_in_date = $this->input->post('h_check_in_date');
			$check_out_date = $this->input->post('h_check_out_date');

			$data['extras'] = $this->m_extra->get_extra_from_extras();
			$data['num_of_nights'] = $this->daysBetween($check_in_date, $check_out_date);
			$data['check_in_date'] = $check_in_date;
			$data['check_out_date'] = $check_out_date;
			$credit_term = $this->m_credit_term->get_credit_term($id_guest);
			if($id_guest != '' && property_exists($credit_term, 'credit_term') && $credit_term->credit_term){
				$data['due_date'] = date('d-m-Y', strtotime("+".$credit_term->credit_term." day", strtotime($check_out_date)));
				$data['id_credit'] = $credit_term->id_credit;
				$data['credit_term'] = $credit_term->credit_term;
			}else{
				$data['due_date'] = '';
				$data['id_credit'] = '';
				$data['credit_term'] = '';
			}
			
			$this->session->set_userdata('booking_items', json_encode($data));
			//print_r($this->session->userdata('booking_items'));
		} else {
			$data = (array)json_decode($this->session->userdata('booking_items'));
		}
		//print_r($data);
		
		if ($id_guest != '') {
			if ($this->session->userdata('booking_items') != '') {
				$data = (array)json_decode($this->session->userdata('booking_items'));

				$guest = $this->m_guest->get_profile_by_guestID($id_guest);
				$data['guest_info'] = $guest;
				
			} else {
				redirect('home');
			}
		} 
		$this->load->view('v_header');
		$this->load->view('v_guest_info', $data);
		$this->load->view('v_footer');
		/*else {
			redirect('login');
		}*/
	}

	public function guest_info_old()
	{
		$id_guest = $this->session->userdata('id_guest');
		//echo $this->session->userdata('id_guest');
		
		$data['guest_info'] = $this->m_guest->get_profile_by_guestID($id_guest);
		$check_in_date = '';
		$check_out_date = '';
		// If post comes from room_details or from cart
		//echo "<br>book 1<br>";
		//print_r($_SESSION);
		if (!empty($_POST)) {
			//echo "<br>book 2<br>";
			$data['rooms'] = $this->input->post('h_id_room');
			$data['number_of_adult'] = $this->input->post('h_num_of_adult');
			$data['number_of_room'] = $this->input->post('h_num_of_room');
			$data['number_of_children'] = $this->input->post('h_num_of_children');
			$data['children_ages'] = $this->input->post('h_children_ages');
			$data['cart_item'] = $this->input->post('h_cart_item');
			$check_in_date = $this->input->post('h_check_in_date');
			$check_out_date = $this->input->post('h_check_out_date');

			$data['extras'] = $this->m_extra->get_extra_from_extras();
			$data['num_of_nights'] = $this->daysBetween($check_in_date, $check_out_date);
			$data['check_in_date'] = $check_in_date;
			$data['check_out_date'] = $check_out_date;
			//echo "with post";

		} // if not post but room is selected from room_details
		else if ($this->session->userdata('id_room_type') != '') {
			//echo "<br>book 3<br>";	
			$data['number_of_adult'] = $this->session->userdata('num_of_adult');
			$data['number_of_room'] = $this->session->userdata('num_of_room');
			$data['number_of_children'] =  $this->session->userdata('num_of_children');
			$data['children_ages'] =  $this->session->userdata('children_ages');
			$check_in_date =  $this->session->userdata('check_in_date');
			$check_out_date =  $this->session->userdata('check_out_date');
			//$in_date = explode('-', $check_in_date);
			$curr_date = date_reformat($check_in_date, 'day_to_year_dash');
			$room = $this->m_room_type->get_room_type_by_ID($this->id_project_info, $this->session->userdata('id_room_type'));
			$rate = $this->m_room_type->get_day_rate($room->id_room_type, $curr_date);
			$data['rooms'] = $room->id_room_type . ':' . $rate;
			$data['extras'] = $this->m_extra->get_extra_from_extras();
			$data['num_of_nights'] = $this->daysBetween($check_in_date, $check_out_date);
			//$data['check_in_date'] = $check_in_date;
			//$data['check_out_date'] = $check_out_date;

		}


		//print_r($data);
		// IF user is logged in and post comes from room_details

		if ($id_guest != '' && $this->session->userdata('cart_data') == '') {
			//echo "<br>book 4<br>";	
			$data['id_guest'] = $id_guest;
			$this->load->view('v_header');
			$this->load->view('v_guest_info', $data);
			$this->load->view('v_footer');
		} // this is redirect from cart to login to booking
		else if ($id_guest != '' && $this->session->userdata('cart_data') != '') {
			//echo "<br>book 5<br>";
			$data = (array)json_decode($this->session->userdata('cart_data'));
			//print_r($data);
			//echo "<br>GUEST: ".$id_guest."<br>";
			$guest = $this->m_guest->get_profile_by_guestID($id_guest);
			//print_r($guest);
			$data['guest_info'] = $guest;
			$this->load->view('v_header');
			$this->load->view('v_guest_info', $data);
			$this->load->view('v_footer');
		} // this is redirect from cart to login
		else {
			//echo "<br>book 6<br>";	
			//print_r($data);


			$this->session->set_userdata('cart_data', json_encode($data));

			//echo "CART";
			//print_r($this->session->userdata('cart_data'));
			//print_r($_SESSION);
			//$this->load->view('v_login');
			redirect('login');
			//header("Location: ". login_url().'?page=booking');
		}
	}

	public function get_discount()
	{
		if (!empty($_POST)) {
			$code = $this->input->post('code');
			$check_in_date = date_reformat($this->input->post('check_in_date'), 'day_to_year_dash');
			$check_out_date = date_reformat($this->input->post('check_out_date'), 'day_to_year_dash');
			$discount = $this->m_discount->get_discount_by_code($code, date('Y-m-d'), $check_in_date, $check_out_date);
			echo json_encode($discount);
		}
	}

	public function get_extra_bed_count()
	{
		if (!empty($_POST)) {
			$room_types = $this->input->post('room_');
		}
	}

	public function save_booking()
	{

		// Start transaction
		// $this->db->trans_begin();
		// try {
	       $id_guest = $this->input->post('id_guest');
	       $name = explode(" ", $this->input->post('guest_name'));
	       $lastname = $name[sizeof($name)-1];
	       $firstname = '';
	       foreach ($name as $ind => $n) {
	           if ((sizeof($name)-1) > $ind) {
	               $firstname = ($firstname == '') ? $n : $firstname.' '.$n;
	           }
	       }
	       $existing_guest = $this->m_guest->get_guest_by_name_tax_id($firstname, $lastname, $this->input->post('guest_tax_id'));
	       if (isset($existing_guest->id_guest)) {
	           $id_guest = $existing_guest->id_guest;
	       }
	       if ($id_guest == '') {
	           // Create a new Guest Info
	           $data_guest = array(
	               'name' => $this->input->post('guest_name'),	               
	               'firstname' => $firstname,
	               'lastname' => $lastname,
	               'contact_number' => $this->input->post('guest_contact_number'),
	               'address' => $this->input->post('guest_address'),
	               'email' => $this->input->post('guest_email'),
	               'tax_id' => $this->input->post('guest_tax_id'),
	               'is_active' => 1,
	               'date_created' => date('Y-m-d H:i:s')
	           );
	           $id_guest = $this->m_guest->insert_profile($data_guest);	
	       }
	    	
			$booking_num = $this->m_booking->generate_booking_number();
			$id_project_project_info = 1;
			$next_day = date('d-m-Y', strtotime("+1 day", strtotime(date('d-m-Y'))));
			$check_in_date = date_reformat($this->input->post('h_check_in_date') ? $this->input->post('h_check_in_date') : date('d-m-Y'), 'day_to_year_dash');
			$check_out_date = date_reformat($this->input->post('h_check_out_date') ? $this->input->post('h_check_out_date') : $next_day, 'day_to_year_dash');

			$rooms = explode(',', $this->input->post('rooms'));
			$items = explode(',', $this->input->post('items'));

			$id_package = explode(',', $this->input->post('packages'));
			$page = $this->input->post('page');

			// get discount
			
			$this->load->model('m_discount');
			$id_discount = $this->input->post('id_discount');
			$discount = $this->m_discount->get_discount($id_discount, date('Y-m-d'), $check_in_date, $check_out_date);
			// Save Booking
			$booking_status = 'Booked';
			if($this->input->post('id_credit')){
				$booking_status = 'Verifying';
			}
			if (isset($discount->discount_type) && $discount->discount_type == 'percent' && intval($discount->discount_value) == 100) {
				$booking_status = 'Confirmed';
			}
			$data = array();
			$data = array(
				'booking_number' => $booking_num,
			    'id_guest_info' => $id_guest,
				'guest_name' => $this->input->post('guest_name'),
				'guest_contact_number' => $this->input->post('guest_contact_number'),
				'guest_address' => $this->input->post('guest_address'),
				'guest_email' => $this->input->post('guest_email'),
				'guest_tax_id' => $this->input->post('guest_tax_id'),
				'billing_name' => $this->input->post('billing_name'),
				'billing_contact_number' => $this->input->post('billing_contact_number'),
				'billing_address' => $this->input->post('billing_address'),
				'billing_email' => $this->input->post('billing_email'),
				'billing_tax_id' => $this->input->post('billing_tax_id'),
				'booking_date' => date('Y-m-d H:i:s'),
				'check_in_date' => $check_in_date,
				'check_out_date' => $check_out_date,
				'number_of_adults' => intval(trim($this->input->post('h_num_of_adult'))),
				'number_of_children' => intval(trim($this->input->post('h_num_of_children'))),
				'children_age' => ($this->input->post('h_num_of_children') > 0) ? trim($this->input->post('h_children_ages')) : '',
				'number_of_rooms' => sizeof($rooms),
				'id_discount_code' => $id_discount,
				'discount_code' => empty($discount->code) ? '' : $discount->code,
				'discounted_amount' => floatval(str_replace(',', '', trim($this->input->post('h_discount')))), //str_replace(',', '', $this->input->post('h_discount')) ,
				'sub_total' => floatval(str_replace(',', '', trim($this->input->post('h_subtotal')))), //str_replace(',', '', $this->input->post('h_subtotal')),
				'vat' => floatval(str_replace(',', '', trim($this->input->post('h_vat')))), //str_replace(',', '', $this->input->post('h_vat')),
				'grand_total' => floatval(str_replace(',', '', trim($this->input->post('h_grand_total')))), //str_replace(',', '', $this->input->post('h_grand_total')),
				'balance_amount' => floatval(str_replace(',', '', trim($this->input->post('h_grand_total')))),
				'status' => $booking_status,
				'discount_type' => (isset($discount->discount_type)) ? $discount->discount_type : '',
				'discount_value' => (isset($discount->discount_value)) ? $discount->discount_value : '',
				'credit_due_date' => $this->input->post('due_date') ? date('Y-m-d' , strtotime($this->input->post('due_date'))) : null,
				'id_credit' => $this->input->post('id_credit') ? $this->input->post('id_credit') : null,
				'credit_term' => $this->input->post('credit_term') ? $this->input->post('credit_term') : null,
				'credit_description' =>  $this->input->post('credit_term') ?  $this->input->post('credit_term')." Days" : null
			);

			$this->m_booking->insert_booking($data);

			// ROOMS AND PACKAGE
			$total_package_item_price = 0;
			$package_room_details = array();
			if ($this->input->post('packages') != '') {
				foreach ($id_package as $pkg) {
					$p = explode(':', $pkg);
					$package_items = $this->m_package->get_package_items_by_id($p[0]);
					$rd = array();
					foreach ($package_items as $i) {
						$room_type_details = $this->m_room_type->get_room_by_type($i->id_room_type, $check_in_date, $check_out_date);
						$total_package_item_price += floatval($room_type_details[0]->default_rate);
						$room_to_save = $room_type_details[0]->id_room_details;
						$data_room = array(
							'booking_number' => $booking_num,
							'id_room_details' => $room_to_save,
							'id_room_type' => $room_type_details[0]->id_room_type,
							'room_type_name_en' => $room_type_details[0]->room_type_name_en,
							'id_package' => $i->id_package,
							'package_qty' => $p[2]
						);
						$this->m_booking->insert_booking_room($data_room);

						// Save room in package
						if ($room_to_save != '') {
							$rom = new stdClass();
							$rom->id_room_details = $room_to_save;
							$rom->package_qty = $p[2];
							$rd[] = $rom;
						}

						// UPDATE CART
						if ($page == 'cart_items') {
						    $this->m_cart->delete_to_cart_by_package($i->id_package, $id_guest, $p[2]);
						}
					}
					$package_room_details[$p[0]] = $rd;
				}
			}

			$room_room_details = array();

			if ($this->input->post('rooms') != '') {
				foreach ($rooms as $room) {
					$arr_room_rate = explode(':', $room);
					$room_type_details = $this->m_room_type->get_room_by_type($arr_room_rate[0], $check_in_date, $check_out_date);

					$room_type = $room_type_details[0];

					$data_room = array(
						'booking_number' => $booking_num,
						'id_room_details' => $room_type->id_room_details,
						'id_room_type' => $room_type->id_room_type,
						'room_type_name_en' => $room_type->room_type_name_en
					);
					$this->m_booking->insert_booking_room($data_room);

					// Save room 
					$room_room_details[$room_type->id_room_type] = $room_type->id_room_details;
					// UPDATE CART
					if ($page == 'cart_items') {
					    $this->m_cart->delete_to_cart_by_room_type($arr_room_rate[0], $id_guest, $arr_room_rate[2]);
					}
				}
			}

			foreach ($items as $i) {
				$item = explode(':', $i);

				if ($item[4] == 'package') {
					$package_rooms = $package_room_details[$item[3]];
					$this->db->where('booking_number', $booking_num);
					$booking_result = $this->db->get('booking')->result_array();
					$booking = $booking_result[0];
					$full_package_cost = floatval($item[2]);
					$package_price = round($full_package_cost * $booking['grand_total'] / ($booking['grand_total'] + $booking['discounted_amount']), 6);
					$package_qty = $item[1];
					foreach ($package_rooms as $val) {
						$r_room_details = $this->m_room_type->get_room_details_by_id($val->id_room_details);
						// Apply discount
						$full_unit_cost = $r_room_details->default_rate;
						$unit_cost = round($full_unit_cost * $booking['grand_total'] / ($booking['grand_total'] + $booking['discounted_amount']), 6);
						$extra = ($item[4] == 'extra') ? 1 : null;
						$data_item = array(
							'id_booking' => $booking['id_booking'],
							'booking_number' => $booking_num,
							//'id_item' => $item[3],
							'item_name' => $r_room_details->room_type_name_en,
							//'item_type' => $item[4], 
							'quantity' => $item[1],
							//'unit_cost' => str_replace(',', '', $item[2]),
							'full_unit_cost' => $full_unit_cost,
							'unit_cost' => $unit_cost,
							'discount' => round($full_unit_cost - $unit_cost, 6),
							'is_multiplied_by_night' => 0,
							'date_created' => date('Y-m-d H:i:s'),
							'id_extras' => $extra,
							'id_package' => $item[3],
							'package_qty' => $val->package_qty,
							'package_name' => str_replace('_', ' ', $item[0]),
							'package_price' => $package_price,
							'id_room_details' => $r_room_details->id_room_details,
							'full_package_price' => $full_package_cost
						);
						$id_booking_item = $this->m_booking->insert_booking_item($data_item);
						$this->save_item_date($id_booking_item, $check_in_date, $check_out_date);
					}
				} else {
					$cost = 0;

					// Save Booking Items
					$this->db->where('booking_number', $booking_num);
					$booking_result = $this->db->get('booking')->result_array();
					$booking = $booking_result[0];

					// Apply discount
					$full_unit_cost = intval(str_replace(',', '', $item[2]));
					$unit_cost = round($full_unit_cost * $booking['grand_total'] / ($booking['grand_total'] + $booking['discounted_amount']), 6);
					$extra = ($item[4] == 'extra') ? $item[3] : null;
					$id_room_type = ($item[4] == 'room') ? $item[3] : null;
					$id_room_details = ($item[4] == 'room') ? $room_room_details[$item[3]] : null;
					$data_item = array(
						'id_booking' => $booking['id_booking'],
						'booking_number' => $booking_num,
						//'id_item' => $item[3],
						'item_name' => str_replace('_', ' ', $item[0]),
						//'item_type' => $item[4], 
						'quantity' => $item[1],
						//'unit_cost' => str_replace(',', '', $item[2]),
						'full_unit_cost' => $full_unit_cost,
						'unit_cost' => $unit_cost,
						'discount' => round($full_unit_cost - $unit_cost, 6),
						'is_multiplied_by_night' => 0,
						'date_created' => date('Y-m-d H:i:s'),
						'id_extras' => $extra,
						'id_room_details' => $id_room_details
					);

					$id_booking_item = $this->m_booking->insert_booking_item($data_item);
					if ($item[4] == 'room') {
						$this->save_item_date($id_booking_item, $check_in_date, $check_out_date);
					}
					if ($item[4] == 'extra') {
						$new_date = date('Y-m-d', strtotime($check_in_date . ' +1 day'));
						$this->save_item_date($id_booking_item, $check_in_date, $new_date);
					}
				}
			}

			// $this->db->trans_commit();
			// Send Email Booked
			$this->session->set_flashdata('message_success', 'success');
			$this->_checkSendEmailBooked($booking);
			$this->session->set_userdata('booking_items', '');
			$this->session->set_userdata('room_details', '');
			redirect('booking/billing' . '?number=' . $booking_num);

		// } catch (Exception $e) {
			// $this->db->trans_rollback();
			// $this->session->set_flashdata('message_success', $e->getMessage());
			// if (isset($_SERVER['HTTP_REFERER'])) {
			// 	redirect($_SERVER['HTTP_REFERER']);
			// } else {
			// 	// Default to the home page if there's no referrer.
			// 	redirect(base_url());
			// }
		// }
	}

	private function save_item_date($id_booking_item, $check_in_date, $check_out_date)
	{
		$new_date = $check_in_date;
		do {
			$data = array(
				'id_booking_item' => $id_booking_item,
				'date' => $new_date
			);
			$this->m_booking->insert_booking_item_date($data);
			$new_date = date('Y-m-d', strtotime($new_date . ' +1 day'));
		} while (strtotime($new_date) < strtotime($check_out_date));
	}

	public function loop_date()
	{
		$check_in_date = '2023-03-29';
		$check_out_date = '2023-04-02';
		$new_date = $check_in_date;
		do {
			echo date('Y-m-d', strtotime($new_date)) . "<br>";
			$new_date = date('Y-m-d', strtotime($new_date . ' +1 day'));
		} while (strtotime($new_date) < strtotime($check_out_date));
	}

	public function test_check_in_array()
	{
		$array_1 = array('id_array' => 1, 'id_content' => 'abc');
		$array_2 = array('id_array' => 2, 'id_content' => 'efg');
		$array_3[] = $array_1;
		$array_3[] = $array_2;
		$search = 1;
		$key = array_search('efg', array_column($array_3, 'id_content'));
		echo $key;
	}

	public function billing()
	{

		$booking_number = $this->input->get('number');
		$booking = $this->m_booking->get_booking_by_booking_number($booking_number);
		$data['discount'] = $this->m_discount->get_discount($booking->id_discount_code, $booking->booking_date, $booking->check_in_date, $booking->check_out_date);
		$items = $this->m_booking->get_items_by_id_booking($booking->id_booking);
		// PROCESS THE ITEMS
		$processed_items = array();
		$curr_package = array();
		foreach ($items as $key => $item) {
			$curr_item = new stdClass();
			$discount = 0;
			if ($item->id_package != '') {
				if (!in_array($item->id_package, $curr_package)) {
					$curr_package[] = $item->id_package;
					$_discount = $this->m_booking->package_booking_item_discount($booking_number, $item->id_package);
					$discount = $_discount->discount;
					$curr_item->id_package = $item->id_package;
					$curr_item->desc = $item->package_name;
					$curr_item->unit_price = $item->package_price;
					$curr_item->quantity = $item->quantity;
					$curr_item->full_unit_price = $item->full_package_price;
				} else {
					continue;
				}
			} else {
				$discount = $item->discount;
				$curr_item->desc = $item->item_name;
				$curr_item->unit_price = $item->unit_cost;
				$curr_item->full_unit_price = $item->full_unit_cost;
				$curr_item->quantity = $item->quantity;
			}

			$type = '';
			if ($item->id_package != '') {
				$type = 'package';
			} else if ($item->id_extras != '') {
				$type = 'extras';
			} else {
				$type = 'room';
			}
			$curr_item->is_multiplied_by_night = $item->is_multiplied_by_night;
			$curr_item->type = $type;
			$curr_item->discount = $discount;
			$processed_items[] = $curr_item;
		}

		$data['items'] = $processed_items;
		$data['booking_number'] = $booking_number;
		$data['booking'] = $booking;
		$data['date_diff'] = $this->daysBetween($booking->check_in_date, $booking->check_out_date);
		$data['guest'] = $this->m_guest->get_profile_by_guestID($booking->id_guest_info);
		$data['project_info'] = $this->m_project_info->get_project_info(1);
		// echo "<pre>";print_r($data);die;
		$this->load->view('v_header');
		$this->load->view('v_billing', $data);
		$this->load->view('v_footer');
	}

	public function test_cost_price()
	{
		$booking_num = '2023-00281';
		$id_package = 1;
		$package_rooms = $this->m_package->get_package_items_by_id($id_package);
		$this->db->where('booking_number', $booking_num);
		$booking_result = $this->db->get('booking')->result_array();
		$booking = $booking_result[0];
		$full_package_cost = 5000;
		echo "Grand Total: " . $booking['grand_total'] . "<br>";
		echo "Discount Amount: " . $booking['discounted_amount'] . "<br>";
		$package_price = round($full_package_cost * $booking['grand_total'] / (($booking['grand_total'] + $booking['discounted_amount'])), 6);
		$package_qty = 1;
		foreach ($package_rooms as $key => $val) {
			$r_room_details = $this->m_room_type->get_room_details_by_id($val->id_room_type);
			// Apply discount
			$full_unit_cost = $r_room_details->default_rate;
			$unit_cost = round($full_unit_cost * $booking['grand_total'] / ($booking['grand_total'] + $booking['discounted_amount']), 6);
			echo "Full Unit Cost: " . $full_unit_cost . "<br>";
			echo "Unit Cost: " . $unit_cost . "<br>";
		}
	}

	public function payment()
	{
		$booking_number = $this->input->get('number');
		$booking = $this->m_booking->get_booking_by_booking_number($booking_number);
		$data['booking_payment'] = $this->m_booking->get_booking_total_payment($booking_number);
		$data['payment_history'] = $this->m_booking->get_booking_payment($booking_number);
		$data['booking_number'] = $booking_number;
		$data['booking'] = $booking;
		//print_r($booking);
		$this->load->view('v_header');
		$this->load->view('v_payment', $data);
		$this->load->view('v_footer');
	}

	public function save_payment()
	{
		if ($_FILES['transfer_slip']['name'] != '') {
			$booking_number = str_replace('-', '_', $this->input->post('booking_number'));
			$old_booking = $this->m_booking->get_booking_by_booking_number($this->input->post('booking_number'));
			//echo $_FILES["delivery_doc_file"]["name"];
			$doc_link = '';
			$target_dir = 'upload/transfer_slip/'; //'upload/transfer_slip/'; 
			//$target_dir = "delivery_documents/";
			$old_file_1 = basename($_FILES["transfer_slip"]["name"]);
			$extension = substr($old_file_1, strpos($old_file_1, '.'), strlen($old_file_1));
			$timestamp = date('YmdHis');
			$target_file = $old_booking->id_booking . '_' . uniqid() . $extension; //$booking_number.'_'.$timestamp.$extension;

			$config['file_name'] 			= $target_file;
			$config['upload_path']          = '../share_folder/sms_booking/' . $target_dir;
			$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
			$config['overwrite']    		= true;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('transfer_slip')) {
				$data_error = array('error' => $this->upload->display_errors());
				print_r($data_error);
			} else {
				$data_error = array('upload_data' => $this->upload->data());
				$doc_link = $target_dir . $target_file;
			}
			$trns_date = date_reformat($this->input->post('transfer_date'), 'day_to_year_dash');
			$data_file = array(
				'id_booking' => $this->input->post('id_booking'),
				'booking_number' => $this->input->post('booking_number'),
				'transfer_slip' => $doc_link,
				'transfer_date' => $trns_date,
				'transfer_time' => $this->input->post('transfer_time'),
				'transferred_amount' => floatval(str_replace(',', '', $this->input->post('amount')))

			);
			$this->m_booking->save_booking_payment($data_file, $this->input->post('booking_number'));
			//


			$new_booking = $this->m_booking->get_booking_by_booking_number($this->input->post('booking_number'));
			//print_r($new_booking);
			//echo "<br>";
			//print_r((array) $new_booking);
			//echo "<br>";
			//echo $old_booking->status;
			$this->_checkSendEmailVerifying((array) $new_booking, $old_booking->status);

			$tp = $this->m_booking->get_booking_total_payment($this->input->post('booking_number'));
			$total_payment = (isset($tp->total_payment)) ? $tp->total_payment : 0;
			$balance = $old_booking->grand_total - $total_payment;
			$data_booking = array(
				'transfer_date' => $trns_date,
				'balance_amount' => $balance,
				'transferred_amount' => $total_payment,
				'status' => 'Verifying'
			);
			$this->m_booking->update_booking($data_booking, $this->input->post('booking_number'));

			redirect('booking/thankyou_payment' . '?booking_number=' . $this->input->post('booking_number'));
		} else {
		}
	}

	public function test_send_email()
	{

		$this->_sendEmail($to = 'mychelle@buildersmart.com', $subject = 'Test', $message = 'Test', $attachment = '');
	}

	public function thankyou_payment()
	{
		$booking_number = $this->input->get('booking_number');

		$booking = $this->m_booking->get_booking_by_booking_number($booking_number);
		//$data['items'] = $this->m_booking->get_items_by_booking_number($booking_number);
		$data['items'] = $this->m_booking->get_items_by_id_booking($booking->id_booking);
		$data['booking_number'] = $booking_number;
		$data['booking'] = $booking;
		$data['guest'] = $this->m_guest->get_profile_by_guestID($booking->id_guest_info);
		$data['date_diff'] = $this->daysBetween($booking->check_in_date, $booking->check_out_date);
		$this->load->view('v_header');
		$this->load->view('v_payment_thank_you', $data);
		$this->load->view('v_footer');
	}

	public function history()
	{
		$id_guest_info = $this->session->userdata('id_guest');
		$data['booking_history'] = $this->m_booking->get_booking_history($id_guest_info);
		$this->load->view('v_header');
		$this->load->view('v_booking_history', $data);
		$this->load->view('v_footer');
	}

	public function booking_details()
	{
		$booking_number = $this->input->get('booking_number');
		$booking = $this->m_booking->get_booking_by_booking_number($booking_number);
		//print_r($booking);
		$data['discount'] = $this->m_discount->get_discount($booking->id_discount_code, $booking->booking_date, $booking->check_in_date, $booking->check_out_date);
		//$data['items'] = $this->m_booking->get_items_by_booking_number($booking_number);
		$items = $this->m_booking->get_items_by_id_booking($booking->id_booking);
		// PROCESS THE ITEMS
		$processed_items = array();
		$curr_package = array();
		foreach ($items as $key => $item) {
			$curr_item = new stdClass();
			$discount = 0;
			if ($item->id_package != '') {
				if (!in_array($item->id_package, $curr_package)) {
					$curr_package[] = $item->id_package;
					$_discount = $this->m_booking->package_booking_item_discount($booking_number, $item->id_package);
					$discount = $_discount->discount;
					$curr_item->id_package = $item->id_package;
					$curr_item->desc = $item->package_name;
					$curr_item->unit_price = $item->package_price;
					$curr_item->quantity = $item->quantity;
					$curr_item->full_unit_price = $item->full_package_price;
				} else {
					continue;
				}
			} else {
				$discount = $item->discount;
				$curr_item->desc = $item->item_name;
				$curr_item->unit_price = $item->unit_cost;
				$curr_item->full_unit_price = $item->full_unit_cost;
				$curr_item->quantity = $item->quantity;
			}

			$type = '';
			if ($item->id_package != '') {
				$type = 'package';
			} else if ($item->id_extras != '') {
				$type = 'extras';
			} else {
				$type = 'room';
			}
			$curr_item->is_multiplied_by_night = $item->is_multiplied_by_night;
			$curr_item->type = $type;
			$curr_item->discount = $discount;
			$processed_items[] = $curr_item;
		}
		//print_r($processed_items);
		$data['items'] = $processed_items;


		//$booking = $this->m_booking->get_booking_by_booking_number($booking_number);
		//$data['items'] = $this->m_booking->get_items_by_booking_number($booking_number);
		//$data['items'] = $this->m_booking->get_items_by_id_booking($booking->id_booking);
		$data['booking_number'] = $booking_number;
		$data['booking'] = $booking;
		$data['guest'] = $this->m_guest->get_profile_by_guestID($booking->id_guest_info);
		$data['date_diff'] = $this->daysBetween($booking->check_in_date, $booking->check_out_date);
		$this->load->view('v_header');
		$this->load->view('v_booking_details', $data);
		$this->load->view('v_footer');
	}

	public function test_booking_number()
	{
		$booking_number = $this->m_booking->generate_booking_number();
		print_r($booking_number);
	}

	/*** FROM K. SAI ***/
	function formatBaht($v = 0)
	{
		return number_format($v, 2);
	}

	public function _checkSendEmailBooked($booking_info = array())
	{
		if (empty($booking_info)) {
			return;
		}

		if ($booking_info['status'] == 'Booked') {
			$guest = $this->m_guest->get_profile_by_guestID($booking_info['id_guest_info']);
			$guest = (array) $guest;

			$subject = 'คุณทำการจองห้องพัก Smart Modular System เรียบร้อยแล้ว (' . $booking_info['booking_number'] . ')';
			$message = '<b>Guest Name:</b> ' . $booking_info['guest_name']
				. '<br><b>Check In Date:</b> ' . $booking_info['check_in_date']
				. '<br><b>Check Out Date:</b> ' . $booking_info['check_out_date']
				. '<br><b>Total Price:</b> ' . $this->formatBaht($booking_info['grand_total'])
				. '<br><br><hr><br><br>' . $this->setting['booked_email_template'];
			$attachment = $this->_saveInvoice($booking_info['id_booking']);
			return $this->_sendEmail($guest['email'], $subject, $message, $attachment);
		}
	}

	public function _checkSendEmailVerifying($booking_info = array(), $old_status = '')
	{
		if (empty($booking_info)) {
			return;
		}

		if ($booking_info['status'] == 'Verifying' && $old_status == 'Booked') {
			$guest = $this->m_guest->get_profile_by_guestID($booking_info['id_guest_info']);
			$guest = (array) $guest;

			$subject = 'ลูกค้าทำการจองห้องพัก Smart Modular System และอัพโหลดสลิปเรียบร้อยแล้ว กรุณาตรวจสอบยอดเงินและยืนยันการโอน (' . $booking_info['booking_number'] . ')';
			$message = '<b>Guest Name:</b> ' . $booking_info['guest_name']
				. '<br><b>Check In Date:</b> ' . $booking_info['check_in_date']
				. '<br><b>Check Out Date:</b> ' . $booking_info['check_out_date']
				. '<br><b>Total Price:</b> ' . $this->formatBaht($booking_info['grand_total'])
				. '<br><br><hr><br><br>' . $this->setting['verifying_email_template'];
			$attachment = $this->_saveInvoice($booking_info['id_booking']);
			return $this->_sendEmail($this->setting['admin_email'], $subject, $message, $attachment);
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
		//$smtp_user = 'smbooking@smresort.asia';
		$smtp_user = EMAIL_USER;
		//echo EMAIL_USER;
		//echo "<br>".EMAIL_PASSWORD;
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
		$image = site_url() . "images/SMS_Logo_Final.png";
		$pdf->Cell(30, 40, $pdf->Image($image, $pdf->GetX(), $pdf->GetY(), 30), 0, 0, 'L', false);

		$pdf->SetY($pdf->GetY() + 13);
		$pdf->SetFont('angsa', 'B', 18);
		$pdf->Cell(30, 0, '');
		$pdf->Cell(80, 11.5, _t($booking['project_name_en'], $booking['project_name_th']));

		$pdf->SetFont('angsa', 'I', 18);
		$pdf->SetFillColor(129, 187, 74);
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
		$pdf->SetY(43);
		$pdf->SetX(10);
		$pdf->SetFont('angsa', '', 16);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Company Name:', 'ชื่อบริษัท:'));
		$pdf->MultiCell(60, 7, _t($booking['business_name_en'], $booking['business_name_th']), 0, 'L', false);

		/////
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Company Address:', 'ที่อยู่บริษัท:'));
		$pdf->MultiCell(60, 7, _t($booking['business_address_en'], $booking['business_address_th']), 0, 'L', false);

		/////
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Company TAX ID:', 'เลขประจำตัวผู้เสียภาษี:'));
		$pdf->Cell(60, 7, $booking['business_tax_id']);

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Contact Number:', 'เบอร์โทรติดต่อ:'));
		$pdf->Cell(60, 7, $booking['business_info_phone_number']);

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
		$pdf->Cell(60, 7, $booking['guest_name']);

		$pdf->SetX(140);
		$pdf->Cell(38, 7, _t('Check-in Date:', 'วันที่เข้าพัก:'));
		$pdf->Cell(20, 7, formatDate($booking['check_in_date']), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Customer TAX ID:', 'เลขประจำตัวผู้เสียภาษี:'));
		$pdf->Cell(60, 7, empty($booking['guest_tax_id']) ? '-' : $booking['guest_tax_id']);

		$pdf->SetX(140);
		$pdf->Cell(38, 7, _t('Check-out Date:', 'วันที่ออก:'));
		$pdf->Cell(20, 7, formatDate($booking['check_out_date']), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 7);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(40, 7, _t('Contact Number:', 'เบอร์โทรติดต่อ:'));
		$pdf->Cell(60, 7, empty($booking['guest_contact_number']) ? '-' : $booking['guest_contact_number']);

		$pdf->SetX(140);
		$pdf->Cell(38, 7, _t('Number of Nights:', 'จำนวนวันเข้าพัก:'));
		$pdf->Cell(20, 7, dateDiff($booking['check_in_date'], $booking['check_out_date']), 0, 0, 'R');

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
		$pdf->Cell(15, 10, _t('No.', 'ลำดับ'), 1, 0, 'C');
		$pdf->Cell(67, 10, _t('Description', 'รายละเอียด'), 1, 0, 'C');
		$pdf->Cell(25, 10, _t('Unit Price', 'ราคา'), 1, 0, 'C');
		$pdf->Cell(25, 10, _t('Discount', 'ส่วนลด'), 1, 0, 'C');
		$pdf->Cell(18, 10, _t('Quantity', 'จำนวน'), 1, 0, 'C');
		$pdf->Cell(25, 10, _t('Total', 'ยอดรวม'), 1, 0, 'C');
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
			$pdf->SetY($pdf->GetY() + 10);
			$pdf->Cell(9, 0, '');
			$pdf->Cell(15, 10, (count($package) + $i + 1) . '.', 1, 0, 'C');
			$pdf->Cell(67, 10, '  ' . $bi['item_name'], 1, 0, 'L');
			$pdf->Cell(25, 10, number_format($bi['full_unit_cost'], 2) . '  ', 1, 0, 'R');
			$pdf->Cell(25, 10, number_format($bi['discount'], 2) . '  ', 1, 0, 'R');
			$pdf->Cell(18, 10, $bi['quantity'], 1, 0, 'C');
			$pdf->Cell(25, 10, number_format($bi['unit_cost'] * $bi['quantity'], 2) . '  ', 1, 0, 'R');
		}

		////////// Note ------------------------------------------------------------------------------------------------------------------------------------
		$pdf->SetY($pdf->GetY() + 15);
		$pdf->SetFont('angsa', 'B', 16);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(190.3, 7, $booking['project_policy_description_en'] ? _t('Notes:', 'หมายเหตุ:') : '', 0, 'L', true);

		$pdf->SetFont('angsa', '', 15);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->MultiCell(190.3, 7, '         ' . _t($booking['project_policy_description_en'], $booking['project_policy_description_th']), 0, 'L', true);
		$pdf->Cell(190.3, 3, '', 0, 0, 'L', true);

		return $pdf;
	}

	private function pdf_thai_charset($lang, $str)
	{
		return ($lang == 'english') ? iconv('UTF-8', 'TIS-620', $str) : $str;
	}

	public function _saveInvoice($id_booking = '')
	{
		if (empty($id_booking)) {
			return;
		}

		$this->db->where('id_booking', $id_booking);
		$booking = $this->db->get('booking')->row_array();
		$filename =  getcwd() . '/upload/invoice_pdf/' . $booking['booking_number'] . '.pdf';

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

	/////
	public function test_remove_comma()
	{
		$amount = '35,050.00';
		echo floatval(str_replace(',', '', $amount));
	}

	public function test_top_room()
	{
		$room_type_details = $this->m_room_type->get_room_by_type(1, '2023-01-27', '2023-01-28');
		print_r($room_type_details[0]);
	}

	public function test_delete_cart()
	{

		$this->m_cart->delete_to_cart_by_room_type(1, $this->session->userdata('id_guest'), 1);
	}

	public function test_date_format()
	{
		$date = '21-02-2023';
		echo date_reformat($date, 'day_to_year_dash');
	}

	/*function date_reformat($date, $type) {
		$new_date = '';
		if ($type = 'day_to_year') {
			$in_date = explode('-', $date);
			$new_date = $in_date[2].'-'.$in_date[1].'-'.$in_date[0];
		}
		return new_date;
	}*/

	function test_delete_to_cart_by_package()
	{
		$id_package = 4;
		$this->m_cart->delete_to_cart_by_package($id_package, $this->session->userdata('id_guest'), 1);
	}
}
