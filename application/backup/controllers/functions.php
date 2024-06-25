<?php
	/*
	public function _checkSendEmailBooked($booking_info = array(), $old_status = '')
	{
		if (empty($booking_info)) {
			return;
		}

		if ($booking_info['status'] == 'Booked' && empty($old_status)) {
			$this->db->where('id_guest', $booking_info['id_guest_info']);
			$guest = $this->db->get('guest_info')->row_array();

			$subject = 'คุณทำการจองห้องพัก Smart Modular System เรียบร้อยแล้ว ('. $booking_info['booking_number'] .')';
			$message = '<b>Check In Date:</b> '. $booking_info['check_in_date']
					  .'<br><b>Check Out Date:</b> '. $booking_info['check_out_date']
					  .'<br><b>Total Price:</b> '. formatBaht($booking_info['grand_total'])
					  .'<br><br><hr><br><br>'. $this->setting['booked_email_template'];
			$attachment = $this->_saveInvoice($booking_info['id_booking']);
			return $this->_sendEmail($guest['email'], $subject, $message, $attachment);
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
					  .'<br><b>Total Price:</b> '. formatBaht($booking_info['grand_total'])
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
		unlink($attachment);

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

		$this->db->where('id_booking', $id_booking);
		$booking_item = $this->db->get('booking_item')->result_array();

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
	*/