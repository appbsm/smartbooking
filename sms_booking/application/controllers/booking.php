<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MY_Controller {

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('m_room_type');
		$this->load->model('m_project_info');
		$this->load->model('m_guest');
		$this->load->model('m_booking');
		$this->load->model('m_extra');
	 	if(!$this->session->userdata('id_guest')){
		 	redirect('login');
		}
	}
	
	function daysBetween($dt1, $dt2) {
	    return date_diff(
	        date_create($dt2),  
	        date_create($dt1)
	    )->format('%a');
	}
	
	public function test_date_diff () {
		$date1 = '06-01-2023';
		$date2 = '10-01-2023';
		$diff = $this->daysBetween($date1, $date2);
		echo $diff;
	}
	
	public function guest_info()
	{
		$id_guest = $this->session->userdata('id_guest');
		$data['guest_info'] = $this->m_guest->get_profile_by_guestID($id_guest);
		
		if (!empty($_POST)) {
			$data['rooms'] = $this->input->post('h_id_room');
			$data['number_of_adult'] = $this->input->post('h_num_of_adult');
			$data['number_of_room'] = $this->input->post('h_num_of_room');
			$data['number_of_children'] = $this->input->post('h_num_of_children');
			
			$data['children_ages'] = $this->input->post('h_children_ages');
			$data['check_in_date'] = $this->input->post('h_check_in_date');
			$data['check_out_date'] = $this->input->post('h_check_out_date');
			//$data['room_id'] = $room_id;
			$data['id_guest'] = $id_guest;			
			$data['extras'] = $this->m_extra->get_extra_from_extras();
			$data['setting_extras'] = $this->m_extra->get_extra_from_settings();
			$data['num_of_nights'] = $this->daysBetween($this->input->post('h_check_in_date'), $this->input->post('h_check_out_date'));
	
			$this->load->view('v_header');
			$this->load->view('v_guest_info', $data);
			$this->load->view('v_footer');
		}
	}

	
	public function save_booking () {
		$booking_num = $this->m_booking->generate_booking_number();
		$id_project_project_info = 1;
		
		//$booking_num = '';
		$in_date = explode('-', $this->input->post('h_check_in_date'));
		$check_in_date = $in_date[2].'-'.$in_date[1].'-'.$in_date[0];
		$out_date = explode('-', $this->input->post('h_check_out_date'));
		$check_out_date = $out_date[2].'-'.$out_date[1].'-'.$out_date[0];
		$rooms = explode(',', $this->input->post('rooms'));
		$items = explode(',', $this->input->post('items'));
		//print_r($items);	
		//print_r($rooms);	
		foreach ($rooms as $room) {
			$arr_room_rate = explode(':', $room);
			$room_type = $this->m_room_type->get_room_type_by_ID($id_project_project_info, $arr_room_rate[0]);
			/*$data_item = array(
				'booking_number' => $booking_num,
				'item_name' => $room_type->room_type_name_en,
				'quantity' => 1,
				'unit_cost' => $arr_room_rate[1],
				'is_multiplied_by_night' => 1,
				'date_created' => date('Y-m-d H:i:s')
			);
			//print_r($data_room);
			$this->m_booking->insert_booking_item($data_item);
			*/
			$data_room = array(
				'booking_number' => $booking_num,
				'id_room_type' => $room_type->id_room_type,
				'room_type_name_en' => $room_type->room_type_name_en
			);
			$this->m_booking->insert_booking_room($data_room);
		}
		
		foreach ($items as $i) {
			$item = explode(':', $i);
			$cost = 0;
			$data_item = array(
				'booking_number' => $booking_num,
				'item_name' => $item[0],
				'quantity' => $item[1],
				'unit_cost' => $item[2],
				'is_multiplied_by_night' => 0,
				'date_created' => date('Y-m-d H:i:s')
			);
			$this->m_booking->insert_booking_item($data_item);
		}
		
		$data = array(
			'booking_number' => $booking_num,
			'id_guest_info' => $this->input->post('id_guest'),		
			'booking_date' => date('Y-m-d H:i:s'),
			'check_in_date' => $check_in_date,
			'check_out_date' => $check_out_date,
			'number_of_adults' => $this->input->post('h_num_of_adult'),
			'number_of_children' => $this->input->post('h_num_of_children'),
			'children_age' => $this->input->post('h_children_ages'),
			'number_of_rooms' => sizeof($rooms),
			'discounted_amount' => $this->input->post('h_discount'), //str_replace(',', '', $this->input->post('h_discount')) ,
			'sub_total' => $this->input->post('h_subtotal'), //str_replace(',', '', $this->input->post('h_subtotal')),
			'vat' => $this->input->post('h_vat'), //str_replace(',', '', $this->input->post('h_vat')),
			'grand_total' => $this->input->post('h_grand_total'), //str_replace(',', '', $this->input->post('h_grand_total')),
			'status' => 'Booked'
		);
		//print_r($data);
		$this->m_booking->insert_booking($data);	
		redirect('booking/billing'.'?number='.$booking_num);
	}
	
	public function billing()
	{
		$booking_number = $this->input->get('number');
		$booking = $this->m_booking->get_booking_by_booking_number($booking_number);
		$data['items'] = $this->m_booking->get_items_by_booking_number($booking_number);
		$data['booking_number'] = $booking_number;
		$data['booking'] = $booking;
		$data['date_diff'] = $this->daysBetween($booking->check_in_date, $booking->check_out_date);
		$data['guest'] = $this->m_guest->get_profile_by_guestID($booking->id_guest_info);
		$this->load->view('v_header');
		$this->load->view('v_billing', $data);
		$this->load->view('v_footer');

	}
	
	public function payment()
	{
		$booking_number = $this->input->get('number');
		$booking = $this->m_booking->get_booking_by_booking_number($booking_number);		
		$data['booking_number'] = $booking_number;
		$data['booking'] = $booking;
		//print_r($booking);
		$this->load->view('v_header');
		$this->load->view('v_payment', $data);
		$this->load->view('v_footer');

	}
	
	public function save_payment () {
		if ($_FILES['transfer_slip']['name'] != '') {		
				$booking_number = str_replace('-', '_', $this->input->post('booking_number'));
				$old_booking = $this->m_booking->get_booking_by_booking_number($this->input->post('booking_number'));
				//echo $_FILES["delivery_doc_file"]["name"];
				$doc_link = '';
				$target_dir = 'upload/transfer_slip/'; 
				//$target_dir = "delivery_documents/";
				$old_file_1 = basename($_FILES["transfer_slip"]["name"]);
				$extension = substr($old_file_1,strpos($old_file_1, '.'),strlen($old_file_1));
				$timestamp = date('YmdHis');
				$target_file = $booking_number.'_'.$timestamp.$extension;
	
				$config['file_name'] 			= $target_file;
				$config['upload_path']          = $target_dir;
		        $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
		        $config['overwrite']    		= true;

	        	$this->load->library('upload', $config);
				$this->upload->initialize($config);
	        	
				if ( ! $this->upload->do_upload('transfer_slip')) 
				{
	        		$data_error = array('error' => $this->upload->display_errors());
	        		print_r($data_error);
	        	}
	        	else
	        	{
	        		$data_error = array('upload_data' => $this->upload->data());	        		
	        		$doc_link = $target_dir.$target_file;
	        	}
        		$trns_date = explode('-', $this->input->post('transfer_date'));
	        	$data_file = array(				
					'transfer_slip' => $doc_link,
	        		'transfer_date' => $trns_date[2].'-'.$trns_date[1].'-'.$trns_date[0],
	        		'transfer_time' => $this->input->post('transfer_time'),
	        		'transferred_amount' => floatval(str_replace(',', '', $this->input->post('amount'))),
	        		'status' => 'Verifying'
				);			
				$this->m_booking->update_booking($data_file, $this->input->post('booking_number'));

				$new_booking = $this->m_booking->get_booking_by_booking_number($this->input->post('booking_number'));
				print_r($new_booking);
				echo "<br>";
				print_r((array) $new_booking);
				echo "<br>";
				echo $old_booking->status;
				$this->_checkSendEmailBooked((array) $new_booking, $old_booking->status);
				
				redirect('booking/thankyou_payment'.'?booking_number='.$this->input->post('booking_number'));
		}
	}
	
	public function test_send_email () {
		
		$this->_sendEmail($to = 'mychelle@buildersmart.com', $subject = 'Test', $message = 'Test', $attachment = '');
	}
	
	public function thankyou_payment () {
		$booking_number = $this->input->get('booking_number');
		
		$booking = $this->m_booking->get_booking_by_booking_number($booking_number);
		
		
		$data['items'] = $this->m_booking->get_items_by_booking_number($booking_number);
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
	
	public function booking_details () {
		$booking_number = $this->input->get('booking_number');
		$booking = $this->m_booking->get_booking_by_booking_number($booking_number);
		$data['items'] = $this->m_booking->get_items_by_booking_number($booking_number);
		$data['booking_number'] = $booking_number;
		$data['booking'] = $booking;
		$data['guest'] = $this->m_guest->get_profile_by_guestID($booking->id_guest_info);
		$data['date_diff'] = $this->daysBetween($booking->check_in_date, $booking->check_out_date);
		$this->load->view('v_header');
		$this->load->view('v_booking_details', $data);
		$this->load->view('v_footer');
		
	}
	
	public function test_booking_number () {
		$booking_number = $this->m_booking->generate_booking_number();
		print_r($booking_number);
	}
	
	/*** FROM K. SAI ***/
	function formatBaht($v = 0) {
        return '฿'. number_format($v, 2);
    }
	
	
	public function _checkSendEmailBooked($booking_info = array(), $old_status = '')
	{
		if (empty($booking_info)) {
			return;
		}

		if ($booking_info['status'] == 'Verifying' && $old_status == 'Booked') {
			//$this->db->where('id_guest', $booking_info['id_guest_info']);
			//$guest = $this->db->get('guest_info')->row_array();
			$guest = $this->m_guest->get_profile_by_guestID($booking_info['id_guest_info']);
			print_r($guest);
			$guest = (array) $guest;
			$subject = 'คุณทำการจองห้องพัก Smart Modular System เรียบร้อยแล้ว ('. $booking_info['booking_number'] .')';
			$message = '<b>Check In Date:</b> '. $booking_info['check_in_date']
					  .'<br><b>Check Out Date:</b> '. $booking_info['check_out_date']
					  .'<br><b>Total Price:</b> '. $this->formatBaht($booking_info['grand_total'])
					  .'<br><br><hr><br><br>'. $this->setting['booked_email_template'];
			//$attachment = $this->_saveInvoice($booking_info['id_booking']);
			return $this->_sendEmail($guest['email'], $subject, $message, $attachment='');
		}
	}

	public function _checkSendEmailConfirmed($booking_info = array(), $old_status = '')
	{
		if ($booking_info['status'] == 'Confirmed' && (empty($old_status) || $old_status == 'Booked')) {
			$this->db->where('id_guest', $booking_info['id_guest_info']);
			$guest = $this->db->get('guest_info')->row_array();

			$subject = 'คุณชำระเงินการจองห้องพัก Smart Modular System เรียบร้อยแล้ว ('. $booking_info['booking_number'] .')';
			$message = '<b>Check In Date:</b> '. $booking_info['check_in_date']
					  .'<br><b>Check Out Date:</b> '. $booking_info['check_out_date']
					  .'<br><b>Total Price:</b> '. $this->formatBaht($booking_info['grand_total'])
					  .'<br><br><hr><br><br>'. $this->setting['confirmed_email_template'];
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

		$smtp_user = 'helpdesk@buildersmart.com';//'sms.booking@hotmail.com';
		$this->load->library('email', array(
			'protocol'    => 'smtp',
			'smtp_host'   => 'smtp-legacy.office365.com',
			'smtp_port'   => 587,
			'smtp_user'   => $smtp_user,
			'smtp_pass'   => 'Hor93452',//'Bsm@2023',
			'smtp_crypto' => 'tls',
			'mailtype'    => 'html',
			'charset'     => 'utf-8',
			'wordwrap'    => TRUE
		));

		$headers = "MIME-Version: 1.0" ."\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8" ."\r\n";

		$this->email->set_newline("\r\n");
		$this->email->from($smtp_user, 'SMS Booking');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if (!empty($attachment)) {
			$this->email->attach($attachment);
		}

		if($this->email->send()) {
			$ret['result'] = 'true';
		} else {
			$ret['message'] = $this->email->print_debugger();
		}
		//unlink($attachment);

		return $ret;
	}

	public function _saveInvoice($id_booking = '')
	{
		if (empty($id_booking)) {
			return;
		}

		$this->db->select('*')
				 ->from('booking')
				 ->join('guest_info', 'booking.id_guest_info = guest_info.id_guest')
				 ->join('booking_room', 'booking.booking_number = booking_room.booking_number')
				 ->join('room_details', 'booking_room.id_room_details = room_details.id_room_details')
				 ->join('room_type', 'room_details.id_room_type = room_type.id_room_type')
				 ->join('project_info', 'room_type.id_project_info = project_info.id_project_info')
				 ->where('booking.id_booking', $id_booking);
		$booking = $this->db->get()->row_array();

		//$this->db->where('id_booking', $id_booking);
		//$booking_item = $this->db->get('booking_item')->result_array();
		$booking_item = $this->m_booking->get_items_by_id_booking($id_booking);
		/////
		require(APPPATH .'/third_party/fpdf/fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage();
		$image = site_url() ."images/SMS_Logo_Final.png";
		$pdf->Cell(30, 40, $pdf->Image($image, $pdf->GetX(), $pdf->GetY(), 30), 0, 0, 'L', false);
		
		$pdf->SetY($pdf->GetY() + 13);
		$pdf->SetFont('Arial', 'B', 12.5);
		$pdf->Cell(30, 0, '');
		$pdf->Cell(80, 11.5, 'SMS Showroom at Khao Yai');

		$pdf->SetFont('Arial', 'BI', 12.5);
		$pdf->SetFillColor(129, 187, 74);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(80, 7.5, 'Booking Number: '. $booking['booking_number'], 0, 0, 'C', true);

		/////
		$pdf->SetY($pdf->GetY() + 20);
		$pdf->SetFont('Arial', '', 10.5);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(35, 7, 'Company Name:');
		$pdf->Cell(67, 7, $booking['project_name_en']);

		$pdf->SetFont('Arial', '', 10.5);
		$pdf->SetFillColor(129, 187, 74);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(80, 6.5, 'Invoice # '. $booking['id_booking'], 0, 0, 'L', true);

		/////
		$pdf->SetY($pdf->GetY() + 8);
		$pdf->SetFont('Arial', '', 10.5);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(35, 7, 'Contact Number:');
		$pdf->Cell(70, 7, $booking['phone_number']);

		$pdf->SetFont('Arial', 'B', 10.5);
		$pdf->Cell(55, 7, 'Subtotal');
		$pdf->SetFont('Arial', '', 10.5);
		$pdf->Cell(20, 7, number_format($booking['sub_total'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 8);
		$pdf->SetFont('Arial', '', 10.5);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(35, 7, 'Bank:');
		$pdf->Cell(70, 7, 'Kasikorn Bank');

		$pdf->Cell(55, 7, 'VAT 7%');
		$pdf->Cell(20, 7, number_format($booking['vat'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 8);
		$pdf->SetFont('Arial', '', 10.5);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(35, 7, 'Account Name:');
		$pdf->Cell(70, 7, 'BuilderSmart (Public) Co., Ltd.');

		$pdf->SetFont('Arial', 'B', 10.5);
		$pdf->Cell(55, 7, 'Total');
		$pdf->SetFont('Arial', '', 10.5);
		$pdf->Cell(20, 7, number_format($booking['grand_total'], 2), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 8);
		$pdf->SetFont('Arial', '', 10.5);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(35, 7, 'Account Number:');
		$pdf->Cell(67, 7, '145-1-69629-3');

		$pdf->SetFont('Arial', '', 10.5);
		$pdf->SetFillColor(129, 187, 74);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(80, 6.5, '', 0, 0, '', true);

		/////
		$pdf->SetY($pdf->GetY() + 20);
		$pdf->SetFont('Arial', '', 10.5);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(35, 7, 'Customer Name:');
		$pdf->Cell(92, 7, $booking['guest_name']);

		$pdf->Cell(33, 7, 'Check-in Date:');
		$pdf->Cell(20, 7, date('d-m-Y', strtotime($booking['check_in_date'])), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 8);
		$pdf->SetFont('Arial', '', 10.5);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(8, 0, '');
		$pdf->Cell(35, 7, 'Contact Number:');
		$pdf->Cell(92, 7, $booking['contact_number']);

		$pdf->Cell(33, 7, 'Check-out Date:');
		$pdf->Cell(20, 7, date('d-m-Y', strtotime($booking['check_out_date'])), 0, 0, 'R');

		/////
		$pdf->SetY($pdf->GetY() + 15);
		$pdf->SetFont('Arial', 'B', 10.5);
		$pdf->SetFillColor(129, 187, 74);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(190.3, 7, '        Service Rendered:', 0, 0, 'L', true);

		///// Booking Item
		$pdf->SetY($pdf->GetY() + 10);
		$pdf->SetFont('Arial', 'B', 8.5);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetDrawColor(200, 200, 200);
		$pdf->Cell(9, 0, '');
		$pdf->Cell(25, 10, 'No.', 1, 0, 'C');
		$pdf->Cell(50, 10, 'Description', 1, 0, 'C');
		$pdf->Cell(33, 10, 'Unit Cost', 1, 0, 'C');
		$pdf->Cell(33, 10, 'Quantity', 1, 0, 'C');
		$pdf->Cell(33, 10, 'Total', 1, 0, 'C');
		$pdf->SetFont('Arial', '', 8.5);
		foreach ($booking_item as $i => $bi) {
			$pdf->SetY($pdf->GetY() + 10);
			$pdf->Cell(9, 0, '');
			$pdf->Cell(25, 10, $i + 1, 1, 0, 'C');
			$pdf->Cell(50, 10, '  '. $bi['item_name'], 1, 0, 'L');
			$pdf->Cell(33, 10, number_format($bi['unit_cost'], 2) .'  ', 1, 0, 'R');
			$pdf->Cell(33, 10, $bi['quantity'] .'  ', 1, 0, 'R');
			$pdf->Cell(33, 10, number_format($bi['unit_cost'] * $bi['quantity'], 2) .'  ', 1, 0, 'R');
		}

		/////
		$pdf->SetY($pdf->GetY() + 15);
		$pdf->SetFont('Arial', 'B', 10.5);
		$pdf->SetFillColor(129, 187, 74);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Cell(190.3, 7, '        Notes:', 0, 0, 'L', true);

		$pdf->SetY($pdf->GetY() + 6.9);
		$pdf->SetFont('Arial', '', 9.5);
		$pdf->SetFillColor(129, 187, 74);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(190.3, 7, '             This will serve as your invoice. Please settle the amount stated within 2 hours, then proceed to the next step for the', 0, 0, 'L', true);

		$pdf->SetY($pdf->GetY() + 6.9);
		$pdf->SetFont('Arial', '', 9.5);
		$pdf->SetFillColor(129, 187, 74);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(190.3, 7, '             confirmation of your booking. Thank you.', 0, 0, 'L', true);

		$pdf->SetY($pdf->GetY() + 6.9);
		$pdf->SetFont('Arial', '', 9.5);
		$pdf->SetFillColor(129, 187, 74);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(190.3, 3, '', 0, 0, 'L', true);

		/////
		$filename = server_path() .'upload/invoice_pdf/'. $booking['booking_number'] .'.pdf';
		$pdf->Output($filename, 'F');
		return $filename;
	}

	public function test_remove_comma () {
		$amount = '35,050.00';
		echo floatval(str_replace(',', '',$amount));
	}
}
