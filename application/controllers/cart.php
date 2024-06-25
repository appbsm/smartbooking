<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_guest');
		$this->load->model('m_cart');
		$this->load->model('m_package');
		$this->load->model('m_project_info');
		$this->load->model('m_stringlib');		
		
		$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai'; 
		if($lg=='thai'){
		    $this->lang->load('content','thai');
		}
		elseif($lg=='english'){
		    $this->lang->load('content','english');
		}

	}
	
	public function index()
	{
		$data = array();
		$id_guest_info = $this->session->userdata('id_guest');	
		if ($id_guest_info != '') {
			$this->session->set_userdata('cart_data', '');
			$this->session->set_userdata('my_cart', '');
			//echo "My Cart: ".$this->session->userdata('my_cart').'<br>';
			//echo "Cart Data: ".$this->session->userdata('cart_data').'<br>';
			//print_r($_SESSION);
			
			$data['cart_items'] = $this->m_cart->get_cart_items($id_guest_info);							
		}
		else  {
		 	$my_cart = $this->session->userdata('my_cart');
			//print_r($my_cart);
		 	$data['cart_items'] = $my_cart;
		}		
		$data['id_project_info'] = 1;
		$data['search_data'] = json_decode($this->session->userdata('search_data'),true);

		$this->load->view('v_header');
		$this->load->view('v_cart_items', $data);
		$this->load->view('v_footer');		
	}
	
	
	
	function add_to_cart () {
		try{
			$id_guest_info = $this->session->userdata('id_guest');	
			$cart_count_message = new stdClass();
			$cart_count_message->message = '';
			$cart_count_message->count = 0;

			if($id_guest_info != '') {			
				if ($this->input->post('id_package') != '') {
					$id_package = $this->input->post('id_package');
					$package_rooms = $this->m_package->get_package_items_by_id($id_package);
					$cart_item_by_package = $this->m_cart->get_cart_item_by_package ($id_guest_info, $id_package);
					$quantity = 1;				
					$data = array(
						'id_guest_info' => $id_guest_info,
						'id_package' => $id_package,
						'package_name_en' => $package_rooms[0]->name,
						'unit_price' => $package_rooms[0]->price,
						'quantity' => 1,
						'date_created' => date('Y-m-d H:i:s')
					);
					$this->m_cart->insert_to_cart_package($data, $id_package, $id_guest_info);	
					$message = $this->lang->line('successful_added_to_cart');
				}
				else {
					$id_room_type = $this->input->post('id_room_type');
					$room_rate = $this->input->post('room_rate');
					$room_type = $this->m_room_type->get_room_type_by_ID(1, $id_room_type);
					$cart_item_by_type = $this->m_cart->get_cart_item_by_type($id_guest_info, $id_room_type);
					$rooms_by_type = $this->m_room_type->get_rooms_by_type($id_room_type);
					if (isset($cart_item_by_type->id_room_type)) {
						if ($cart_item_by_type->quantity < count($rooms_by_type)) {
							$data = array(
								'id_guest_info' => $id_guest_info,
								'id_room_type' => $id_room_type,
								'room_type_name_en' => $room_type->room_type_name_en,
								'room_type_name_th' => $room_type->room_type_name_th,
								'unit_price' => $room_rate,
								'quantity' => 1,
								'date_created' => date('Y-m-d H:i:s')
							);
							$this->m_cart->insert_to_cart($data, $id_room_type, $id_guest_info);
							$message = $this->lang->line('successful_added_to_cart');
						}
						else {
							
							$message = $this->lang->line('message_max_num_of_room_reached');
						}
					}
					else {
						$data = array(
							'id_guest_info' => $id_guest_info,
							'id_room_type' => $id_room_type,
							'room_type_name_en' => $room_type->room_type_name_en,
							'room_type_name_th' => $room_type->room_type_name_th,
							'unit_price' => $room_rate,
							'quantity' => 1,
							'date_created' => date('Y-m-d H:i:s')
						);
						$this->m_cart->insert_to_cart($data, $id_room_type, $id_guest_info);
						$message = $this->lang->line('successful_added_to_cart');
					}
					$cart_count = $this->m_cart->get_cart_item_count ($id_guest_info);						
				}
				$cart_count = $this->m_cart->get_cart_item_count ($id_guest_info);
			}
			else {
				if ($this->input->post('id_package') != '') {
					$id_package = $this->input->post('id_package');
					$package_rooms = $this->m_package->get_package_items_by_id($id_package);
					$my_cart = array();				
					$key = -1;
					if ($this->session->userdata('my_cart') != '') {
						$my_cart = $this->session->userdata('my_cart');
					}	
					$key=array_search($id_package, array_column(json_decode(json_encode($my_cart),TRUE), 'id_package'));
					$curr_qty = 1;
					if ($key > -1) {
						
					}
					else {
						$item = new stdClass();				
						$item->id_package = $id_package;
						 $item->quantity = $curr_qty;
						 $item->status = '';
						 array_push($my_cart, $item);
						 $message = $this->lang->line('successful_added_to_cart');
					}
					$this->session->set_userdata('my_cart', $my_cart);	
					$cart_count = sizeof($this->session->userdata('my_cart'));
				}
				else {
					$id_room_type = $this->input->post('id_room_type');
					
					$my_cart = array();				
					$key = -1;
					if ($this->session->userdata('my_cart') != '') {
						$my_cart = $this->session->userdata('my_cart');
					}	
					$rooms_by_type = $this->m_room_type->get_rooms_by_type($id_room_type);
					$key=array_search($id_room_type, array_column(json_decode(json_encode($my_cart),TRUE), 'id_room_type'));

					$curr_qty = 1;
					if ($key > -1) {	
						
						$curr_qty = $my_cart[$key]->quantity;		
						if ($curr_qty < sizeof($rooms_by_type)) {
							$my_cart[$key]->quantity = $curr_qty + 1;		
							$message = $this->lang->line('successful_added_to_cart');	
						}
						else {
							$message = $this->lang->line('message_max_num_of_room_reached');
						}	
					}	
					else {	
						$item = new stdClass();				
						$item->id_room_type = $id_room_type;
						 $item->quantity = $curr_qty;
						 $item->status = '';
						 array_push($my_cart, $item);
						 $message = $this->lang->line('successful_added_to_cart');
					}
					$this->session->set_userdata('my_cart', $my_cart);	
					$cart_count = sizeof($this->session->userdata('my_cart'));
				}
				
			}
			$cart_count_message->message = $message;
			$cart_count_message->count = $cart_count;	
			echo json_encode($cart_count_message);	
		}catch(Exception $e){
			// echo json_encode(['count' => 0 ,'message' => $e->getMessage()]);	
		}

	}
	
	public function get_available_room_by_room_type () {
		if (!empty($_POST)) {
			/*$in_date = explode('-', $this->input->post('check_in_date'));
			$check_in_date = $in_date[2].'-'.$in_date[1].'-'.$in_date[0];
			$out_date = explode('-', $this->input->post('check_out_date'));
			$check_out_date = $out_date[2].'-'.$out_date[1].'-'.$out_date[0];*/			
			$check_in_date = date_reformat($this->input->post('check_in_date'), 'day_to_year_dash');
			$check_out_date = date_reformat($this->input->post('check_out_date'), 'day_to_year_dash');
			$id_room_type = $this->input->post('id_room_type');
			$room_count = $this->m_room_type->get_count_available_rooms($id_room_type, $check_in_date, $check_out_date);
			$room_details = new stdClass();
			$room_details->id_room_type = $id_room_type;
			$room_details->room_count = $room_count;
			$room_details->_id_item = $this->input->post('id_item');
			$room_details->price = $this->m_room_type->get_day_rate($id_room_type, $check_in_date);
			echo json_encode($room_details);
		}
	}
	
	public function get_available_package () {		
		if (!empty($_POST)) {
			$check_in_date = date_reformat($this->input->post('check_in_date'), 'day_to_year_dash');
			$check_out_date = date_reformat($this->input->post('check_out_date'), 'day_to_year_dash');			
			$id_package = $this->input->post('id_package');
			//echo $id_package;
			$result = $this->m_package->get_available_package ($check_in_date, $id_package);
			$room_details = new stdClass();
			//print_r(sizeof($result));
			$room_details->id_package = $id_package;
			$room_details->package_count = sizeof($result);			
			$room_details->_id_item = $this->input->post('id_item');
			echo json_encode($room_details);
		}
	}
	
	function test_array_key () {
		$id_room_type = 1;
		$my_cart = array();
		
		
		$key = -1;
		if ($this->session->userdata('my_cart') != '') {
			$my_cart = $this->session->userdata('my_cart');
		}
		print_r($my_cart);	
		echo '<br>';		
		$key=array_search($id_room_type, array_column(json_decode(json_encode($my_cart),TRUE), 'id_room_type'));
		
		print_r($my_cart[$key]);
		
		//$curr_qty = 1;
		echo "KEY: ".$key."<br>";
		if ($key > -1) {
			echo "HERE";
			$curr_qty = $my_cart[$key]->quantity;		
			$my_cart[$key]->quantity = $curr_qty + 1;	
			echo '<br>';
			print_r($my_cart[$key]);
			echo '<br>';
		}	
		else {	
			$item = new stdClass();				
			$item->id_room_type = $id_room_type;
		 	$item->quantity = $curr_qty;
		 	$item->status = '';
		 	array_push($my_cart, $item);
		}
		echo "<br>FINAL: <br>";
		print_r($my_cart);
		$this->session->set_userdata('my_cart', $my_cart);
		print_r($this->session->userdata('my_cart'));
	}
	
	function delete_to_cart () {
		if(!empty($_POST)) {
			$id_cart_item = $this->input->post('id_cart_item');
			if ($this->session->userdata('id_guest')) {						
				$this->m_cart->delete_to_cart($id_cart_item);
			}
			else {
				$my_cart = $this->session->userdata('my_cart');
				unset($my_cart[$id_cart_item]);				
				$this->session->set_userdata('my_cart', $my_cart);
			}			
		}
	}
	
	function update_cart_ajax () {
		if (!empty($_POST)) {
			$id_cart_item = $this->input->post('id_cart_item');
			$id_room_type = $this->input->post('id_room_type');
			$quantity = $this->input->post('quantity');
			$id_guest_info = $this->session->userdata('id_guest');
			$data = array('quantity' => $quantity);
			$this->db->m_cart->update_cart ($data, $id_guest, $id_room_type);	
		}
	}
	
	function update_cart_package () {
		if (!empty($_POST)) {
			$id_cart_item = $this->input->post('id_cart_item');
			$id_package = $this->input->post('id_package');
			$quantity = $this->input->post('quantity');
			$id_guest_info = $this->session->userdata('id_guest');
			$data = array('quantity' => $quantity);
			$this->db->m_cart->update_cart_package ($data, $id_guest, $id_package);	
		}
	}
	
	function test_package_available () {
		$packages = 1;
		$check_in_date = '2023-03-16';
		$result = $this->m_package->get_available_package ($check_in_date, $packages);
		print_r($result);
	}
}
