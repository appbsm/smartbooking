<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_excel extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('Excel');
		$this->load->model('m_guest');
		$this->load->model('m_booking');
		$this->load->model('m_discount');
		
		$this->date_form = 'day_to_year_dash';
	}

		public function read_excel () {
		    /*require_once APPPATH."/third_party/PHPExcel.php"; 
		    if (!defined('PHPEXCEL_ROOT')) {
		        define('PHPEXCEL_ROOT', dirname(__FILE__) . '/');
		        require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
		        
		    }*/
		    include APPPATH.'third_party/PHPExcel/IOFactory.php';
		    $filename = "./import/BK_ARR_2023.xlsx";
		    //echo $_SERVER['DOCUMENT_ROOT'];
		    //echo ROOT_DIR;
		    
		    //$excel::toArray([],$filename);
		    
		    /** Load $inputFileName to a Spreadsheet Object  **/
		    //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
		    
		    
		    if (file_exists($filename)) {
		        try {
		            $inputFileType = PHPExcel_IOFactory::identify($filename);
		            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		            $objPHPExcel = $objReader->load($filename);
		        } catch(Exception $e) {
		            die('Error loading file "'.pathinfo($filename,PATHINFO_BASENAME).'": '.$e->getMessage());
		        }
		        
		        $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		        $array_data = array();
		        
		        $room_list = array('A', 'B', 'C', 'E', 'J1', 'J2');
		        $room_types = array(
		            'A' => 'Type A',
		            'B' => 'Type B',
		            'C' => 'Type C',
		            'E' => 'Type E',
		            'J1' => 'Type J1',
		            'J2' => 'Type J2'
		        );
		        
		        foreach ($rowIterator as $ctr => $row) {
		            $cellIterator = $row->getCellIterator();
		            $cellIterator->setIterateOnlyExistingCells(false);
		            $rowIndex = $row->getRowIndex();
		            $array_data[$rowIndex] = array('A' => '', 'B' => '', 'C' => '', 'D' => '', 'E' => '', 'F' => '', 'G' => '');
		            //echo $ctr;
		            foreach ($cellIterator as $cell) {
		                if ('A' == $cell->getColumn()) { // A. BOOKING Date
		                    //echo $cell->getColumn();
		                    $array_data[$rowIndex][$cell->getColumn()] =  date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getCalculatedValue()));
		                } else if ('B' == $cell->getColumn()) { // B. CHECK-IN
		                    $array_data[$rowIndex][$cell->getColumn()] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getCalculatedValue()));
		                } else if ('C' == $cell->getColumn()) { // C. CHECK-OUT
		                    $array_data[$rowIndex][$cell->getColumn()] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getCalculatedValue()));
		                } else if ('D' == $cell->getColumn()) { // D. ROOM
		                    $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
		                } else if ('E' == $cell->getColumn()) { // E. NUM OF NIGHTs
		                    $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
		                } else if ('F' == $cell->getColumn()) { // F. GUEST NAME
		                    $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
		                } else if ('G' == $cell->getColumn()) { // G. ADDRESS
		                    //$array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
		                    $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
		                } else if ('H' == $cell->getColumn()) { // H. NUM OF GUEST
		                    $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
		                    //$array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
    		            } else if ('I' == $cell->getColumn()) { // I. UNIT PRICE
    		                $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
    		            } else if ('J' == $cell->getColumn()) { // I. PRICE
    		                $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
    		            } else if ('K' == $cell->getColumn()) { // I. DISCOUNT
    		                $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
    		            } else if ('L' == $cell->getColumn()) { // L. DISCOUNT CODE
    		                $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
    		            } else if ('M' == $cell->getColumn()) { // M. GRAND TOTAL
    		                $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
    		            } else if ('N' == $cell->getColumn()) { // N. REMARK
    		                $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
    		            }/* else if ('O' == $cell->getColumn()) {
    		                $array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
    		            }*/
    		            
		            } // foreach ($cellIterator as $cell) {
		        } // foreach ($rowIterator as $ctr => $row) {
		            
		            $id_package = 9999;
		            foreach ($array_data as $ctr_data => $data) {
		                
		                echo "<br><b>COUNTER".$ctr_data."</b><br>";
		                if ($ctr_data > 1) {
        		            
                            
        		            if ($data['F'] != '') {
        		                // 1. Insert Guest
        		                $id_guest_info = 0;
        		                $id_guest_info = $this->get_guest_info($data['F']);        		                
        		                //$guest = $this->m_guest->get_profile_by_guestID($id_guest_info);
        		                //echo $id_guest_info;
        		                //print_r($guest);
        		                echo "<br><br>";
        		                print_r($data);
        		                echo "<br><br>";
        		                if ($data['D'] == 'All') {
        		                    $rooms = $room_list;
        		                }
        		                else {
        		                    $rooms = explode(',', $data['D']);
        		                }

        		                // 2. Booking
        		                $booking = array();
        		                $discount_amount = $data['K'];
        		                $booking['booking_number'] = $this->generate_booking_number_backdate($data['B']);
        		                //print_r($booking_number);
        		                $booking['check_in_date'] = $data['B'];
        		                $booking['check_out_date'] = $data['C'];
        		                $booking['number_of_adults'] = $data['H'];
        		                $booking['number_of_children'] = 0;
        		                $booking['guest_name'] = $data['F'];
        		                $booking['billing_name'] = $data['F'];
        		                $booking['id_guest_info'] = $id_guest_info;
        		                $booking['booking_date'] = $data['A'];
        		                $booking['grand_total'] = intval($data['M']);        		                
        		                $booking['vat'] = round($booking['grand_total'] * 7 / 107, 2);
        		                $booking['sub_total'] = round($booking['grand_total'] - $booking['vat'], 2);
        		                $booking['status'] = 'Checked-out';
        		                $booking['discount_code'] = $data['L'];
        		                $booking['discount_type'] = ($data['L'] != '') ? 'percent' : '';
        		                $booking['discounted_amount'] = $discount_amount;
        		                $booking['sub_total'] = $booking['grand_total'] - $booking['vat'] ; 		                
        		                $booking['transferred_amount'] = $booking['grand_total'];
        		                $booking['staff_id'] = 999999;
        		                $booking['number_of_rooms'] = count($rooms);
        		                $booking['is_backend'] = 1;
        		                echo "<br><br>";
        		                print_r($booking);
        		                echo "ROOMS";
        		                print_r($rooms);
        		                echo "<br><br>";
        		                // SAVE BOOKING TO GET ID
        		                $this->m_booking->insert_booking($booking);	
        		                
        		                
        		                
        		                $id_booking = $this->db->insert_id();
        		                echo "LAST INSERTED ID".$id_booking;
        		                
        		                /*echo "BOOKING DATA: <br>";
        		                print_r($booking);
        		                echo "<br>";*/
        		                foreach ($rooms as $room) {
            		                // 3. Booking Room
        		                    $modular_type = $room_types[$room];
        		                    $room_type = $this->get_room_by_modular_type($modular_type);
        		                    echo "<br>ROOM TYPE<br>";
        		                    print_r($room_type);
        		                    echo "<br><br>";
            		                $room_to_save = $this->get_room_by_type($room_type->id_room_type, $booking['check_in_date'], $booking['check_out_date']);
            		                echo "ROOM TO SAVE";
            		                print_r($room_to_save);
            		                $data_room = array(
            		                    'booking_number' => $booking['booking_number'],
            		                    'id_room_details' => $room_to_save[0]->id_room_details,
            		                    'id_room_type' =>$room_type->id_room_type,
            		                    'room_type_name_en' => $room_type->room_type_name_en,
            		                    'room_name_en' => $room_to_save[0]->room_name_en,
            		                    'id_package'  => ($data['N'] == 'Package') ? $id_package : NULL,
            		                    'package_qty' => ($data['N'] == 'Package') ? 1 : NULL,
            		                    'package_name' => ($data['N'] == 'Package') ? $id_package : NULL
            		                );
            		                echo "BOOKING ROOM: <br>";
            		                print_r($data_room);
            		                echo "<br>";
            		                //print_r($data_room);
            		                //echo "<br>";
            		                $this->m_booking->insert_booking_room($data_room);
            		                // Apply discount
            		                $full_unit_cost = $data['J'];
            		                $unit_cost = $data['J'] - $discount_amount;            		                
            		                // 4.  Booking item
            		                $data_item = array(
            		                    'id_booking' => $id_booking,
            		                    'booking_number' => $booking['booking_number'],
            		                    'item_name' => $room_type->room_type_name_en,
            		                    'quantity' => 1,
            		                    'unit_cost' => $unit_cost,
            		                    'date_created' => date('Y-m-d H:i:s'),
            		                    'is_multiplied_by_night' => NULL,
            		                    'full_unit_cost' => $full_unit_cost,            		                    
            		                    'discount' => $discount_amount,
            		                    'id_room_details' => $room_to_save[0]->id_room_details,
            		                    'id_package' => ($data['N'] == 'Package') ? $id_package : NULL,
            		                    'package_qty' => ($data['N'] == 'Package') ? 1 : NULL,
            		                    'package_name' => ($data['N'] == 'Package') ? $id_package : NULL,
            		                    'package_price' => ($data['N'] == 'Package') ? $unit_cost : NULL,
            		                    'full_package_price' => ($data['N'] == 'Package') ? $full_unit_cost : NULL
            		                );
            		                $id_booking_item = $this->m_booking->insert_booking_item($data_item);
            		                echo "BOOKING Item: <br>";
            		                print_r($data_item);
            		                echo "<br>";
            		                
            		                // 5. Item Date
            		                
            		                $data_item_date = array('id_booking_item' => $id_booking_item, 'date' => $booking['check_in_date']);
            		                $this->m_booking->insert_booking_item_date($data_item_date);
            		                echo "BOOKING Item Date: <br>";
            		                print_r($data_item_date);
            		                echo "<br>";
            		                
        		                }  //     		     
        		                $id_package--;
        		            } // if ($data['B'] != '') {
		                } //if ($ctr_data > 1) {
		            } //foreach ($array_data as $ctr_data => $data) {		            
		            //print_r($booking);
		            echo "<br><br>";		           
		    }
		    else {
		        echo "No File";
		    }
		    
		}
		
		function generate_booking_number_backdate ($booking_date) {
		    $current_year = date('Y');
		    
		    $this->db->order_by('id_booking', 'DESC');
		    $bookings = $this->db->get('booking')->result_array();
		  
		    $lastest_year = date('Y', strtotime($booking_date));

		    $this->db->where('name', 'booking_number_running');
		    $setting_row = $this->db->get('setting')->result_array();
		    $booking_number_running = $setting_row[0]['value'];
		    
		    $this->db->where('name', 'booking_number_running');
		    $this->db->update('setting', array('value' => $booking_number_running + 1, 'updated' => date('Y-m-d H:i:s')));
		    
		    if ($booking_number_running >= 100000) {
		        return $lastest_year .'-'. str_pad($booking_number_running + 1, 5, '0', STR_PAD_LEFT);
		    } else {
		        return $lastest_year .'-'. str_pad($booking_number_running + 1, 5, '0', STR_PAD_LEFT);
		    }
		    
		}
		
		function get_guest_info ($name) {
		    $result = 0;
		    $this->db->where('name', $name);
		    $query = $this->db->get('guest_info');
		    if ($query->num_rows() > 0) {
		        $r = $query->result();
		        $result = $r[0]->id_guest;
		    }
		    else {
		        $data = array('name' => $name);
		        $this->db->insert('guest_info', $data);
		        $result = $this->db->insert_id();
		    }
		    return $result;
		}
		
		function get_room_by_modular_type ($modular_type) {
		    $result = new stdClass();
		    $this->db->where('modular_type_en', $modular_type);
		    $query = $this->db->get('room_type');
		    echo $this->db->last_query();
		    if ($query->num_rows() > 0) {
		        $r = $query->result();
		        $result = $r[0];
		    }
		    return $result;
		}
		
		function get_room_by_type ($id_room_type, $check_in_date, $check_out_date) {
		    
		    // new
		    $result = array();
		    $select = "select * from room_details rd "
		        . "left join room_type rt on rt.id_room_type = rd.id_room_type "
		            . "where "
		                . "rd.active = 1 AND rt.active = 1 AND "
		                    . "rt.id_room_type = ". $id_room_type ." AND "
		                        . "rd.id_room_details NOT IN ( "
		                            . "select br.id_room_details from booking_room br "
		                                . "left join booking b on br.booking_number = b.booking_number "
		                                    . "where "
		                                        . "b.check_out_date > '". $check_in_date ."' AND "
		                                            . "b.check_in_date < '". $check_out_date ."' AND "
		                                                . "b.status != 'Expired' AND b.status != 'Checked-out' AND b.status != 'Cancel'"
		                                                    . ")";
		                                                    $query = $this->db->query($select);
		                                                    //echo $this->db->last_query();
		                                                    if ($query->num_rows() > 0) {
		                                                        $result = $query->result();
		                                                    }
		                                                    return $result;
		}
		
		function str_to_date ($EXCEL_DATE) {
		    //$UNIX_DATE = ($EXCEL_DATE - 25569) * 86400;
		    return  gmdate("d-m-Y H:i:s", strtotime($EXCEL_DATE));
		    
		}
		
		function get_discount_by_code ($code) {
		    $result = new stdClass();
		    $select = "select * from discount "		       
                . "WHERE code = '".$code."' "
            ;
            $query = $this->db->query($select);
            //echo $this->db->last_query();
            if ($query->num_rows() > 0) {
                $r = $query->result();
                $result = $r[0];
            }
            return $result;
		}
		
		function report_payment ($start_of_month, $end_of_month) {
		    $objPHPExcel = new PHPExcel();
		    $sheet = $objPHPExcel->getActiveSheet();
		    // Set document properties
		    $objPHPExcel->getProperties()->setCreator("smsmart_booking_system");
		    $objPHPExcel->getProperties()->setTitle("End Of Month Payment Report");
		    $objPHPExcel->getProperties()->setSubject("End Of Month Payment Report");
		    $objPHPExcel->getProperties()->setDescription("End Of Month Payment Report");
		    $objPHPExcel->getProperties()->setKeywords("smsmart_booking_system");
		    $objPHPExcel->getProperties()->setCategory("Report");
		    
		    //$start_of_month = date('Y-m-01');
		    //$end_of_month = date('Y-m-t');		    		   		    		
		    
		    // HEADER OF THE REPORT		 
		    $style_report_header = array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		        'font' => array(
		            'bold' => true
		        ),
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
		    );
		    $style_report_header_italic = array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		        'font' => array(
		            'bold' => true,
		            'italic' => 'italic', 
		            'size' => 12
		        ),
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
		    );
		    // HEADER OF THE Table
		    $style_table_header = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'A9D08E')
		        ),
		        'font' => array(
		            'bold' => true,
		            'italic' => 'italic'		            
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    // Cell Text Center
		    $style_cell_center = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    // Cell Text Right
		    $style_cell_right = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    // Cell Text LEFT
		    $style_cell_left = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    
		    // FOOTER TOTAL CENTER
		    $style_footer_total_center = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'BDD7EE')
		        ),
		        'font' => array(
		            'bold' => true
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    // FOOTER TOTAL RIGHT
		    $style_footer_total_right = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		        ),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'BDD7EE')
		        ),
		        'font' => array(
		            'bold' => true
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    
		    $objPHPExcel->getActiveSheet()->getStyle("A1:T1")
		    ->getAlignment()
		    ->setWrapText(true); 
		    $objPHPExcel->getActiveSheet()->mergeCells('A1:T1');
		    $sheet->getStyle("A1:T1")->applyFromArray($style_report_header_italic);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'รายงานรายได้ SM Resort @ Khao Yai ');
		    
		    $objPHPExcel->getActiveSheet()->mergeCells('A2:T2');
		    $sheet->getStyle("A2:T2")->applyFromArray($style_report_header);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'ตั้งแต่วันที่ '.date('d/m/Y', strtotime($start_of_month)).' ถึง '.date('d/m/Y', strtotime($end_of_month)));
            
		    $objPHPExcel->getActiveSheet()->getStyle("A3:T3")
		    ->getAlignment()
		    ->setWrapText(true);
		    $sheet->getStyle("A3:T3")->applyFromArray($style_table_header);
		    // SET HEADER TITLE
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3',   'ลำดับ');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'วันที่ทำการจอง');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'หมายเลข Booking');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', 'ชื่อผู้เข้าพัก');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', 'วัน check-in');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'วัน check-out');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', 'จำนวนวันเข้าพัก');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', 'ราคา');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', 'รายการ');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', 'จำนวนผู้เข้าพัก (A|C)');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', 'ช่องทางการจอง');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', 'สถานะการชำระเงิน');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', 'วันที่ชำระเงิน');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', 'เลขที่ใบเสร็จ');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', 'ยืนยันการโอนโดย');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', 'Total Before Discount   ');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', 'Discount');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', 'ยอดรวม');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', 'VAT');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', 'Grand Total');
		    
		    
		    // SET WIDTH PER CELL
		    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); // Number
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13); // Booking Date
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13); // Booking Number
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Guest Name
		    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13); // Check-in Date
		    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13); // Check-out Date
		    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8); // Number of Nights
		    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Price Per Item
		    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Rooms
		    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10); // PAX Adult | Children
		    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Backend or Front-end
		    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10); // Payment Status
		    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13); // Paid Date
		    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13); // Invoice #
		    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Staff Name
		    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20); // Total Before Discount
		    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20); // Discount
		    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Subtotal 
		    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20); // VAT
		    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20); // Grabd Total
		    
		    $line_ctr = 1;
		    
		    $result = $this->_getPayments($start_of_month, $end_of_month);
		    $pax_array = array();
		    $cell_no = $line_ctr + 3;	   
			foreach ($result as $i => $b) {
		        $pax_array[] = $b['pax'];
		             
		        $length_of_stay = dateDiff($b['check_in_date'], $b['check_out_date']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$cell_no, $line_ctr);    		    
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$cell_no, date('d-m-Y', strtotime($b['booking_date'])));
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$cell_no, $b['booking_number']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$cell_no, $b['guest_name']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$cell_no, date('d-m-Y', strtotime($b['check_in_date'])));
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$cell_no, date('d-m-Y', strtotime($b['check_out_date'])));
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$cell_no, $length_of_stay);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$cell_no, $b['rate']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$cell_no, $b['item_description']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$cell_no, $b['pax']);    		    
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$cell_no, $b['channel']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$cell_no, $b['payment_status']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$cell_no, ($b['paid_date'] != '') ? date('d-m-Y', strtotime($b['paid_date'])) : '');
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$cell_no, $b['receipt_no']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$cell_no, $b['staff_name']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$cell_no, $b['total_before_discount'], 2);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$cell_no, $b['discount']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$cell_no, $b['sub_total']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$cell_no, $b['vat']);
    		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$cell_no, $b['total']);
    		    
    		    $sheet->getStyle('P'.$cell_no.':T'.$cell_no)->getNumberFormat()->setFormatCode('#,##0.00');
    		    
    		    $sheet->getStyle('A'.$cell_no)->applyFromArray($style_cell_center);
    		    $sheet->getStyle('B'.$cell_no)->applyFromArray($style_cell_center);	
    		    $sheet->getStyle('C'.$cell_no)->applyFromArray($style_cell_center);	
    		    $sheet->getStyle('D'.$cell_no)->applyFromArray($style_cell_left);	
    		    $sheet->getStyle('E'.$cell_no)->applyFromArray($style_cell_center);	
    		    $sheet->getStyle('F'.$cell_no)->applyFromArray($style_cell_center);	
    		    $sheet->getStyle('G'.$cell_no)->applyFromArray($style_cell_right);	
    		    $sheet->getStyle('H'.$cell_no)->applyFromArray($style_cell_left);	
    		    $sheet->getStyle('I'.$cell_no)->applyFromArray($style_cell_left);	
    		    $sheet->getStyle('J'.$cell_no)->applyFromArray($style_cell_center);	
    		    $sheet->getStyle('K'.$cell_no)->applyFromArray($style_cell_center);	
    		    $sheet->getStyle('L'.$cell_no)->applyFromArray($style_cell_center);	
    		    $sheet->getStyle('M'.$cell_no)->applyFromArray($style_cell_center);	
    		    $sheet->getStyle('N'.$cell_no)->applyFromArray($style_cell_left);	
    		    $sheet->getStyle('O'.$cell_no)->applyFromArray($style_cell_left);	
    		    $sheet->getStyle('P'.$cell_no)->applyFromArray($style_cell_right);	
    		    $sheet->getStyle('Q'.$cell_no)->applyFromArray($style_cell_right);	
    		    $sheet->getStyle('R'.$cell_no)->applyFromArray($style_cell_right);	
    		    $sheet->getStyle('S'.$cell_no)->applyFromArray($style_cell_right);	
    		    $sheet->getStyle('T'.$cell_no)->applyFromArray($style_cell_right);	    		 
    		    
    		    $objPHPExcel->getActiveSheet()->getStyle("A".$cell_no.":T".$cell_no)
    		    ->getAlignment()
    		    ->setWrapText(true);  
    		    $line_ctr++;
		    }
		    
		    // SUMMARY 
		    $total_row = $cell_no+2;
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$total_row, 'Total'); 		    
		    $cells_total = array('G', 'P', 'Q', 'R', 'S', 'T');		    
		    foreach ($cells_total as $ct) {
		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($ct.$total_row, "=SUM(".$ct."3:".$ct.($cell_no).")");
		    }
		    
		    // PAX 		    
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$total_row, $this->sumByCol_stringToArray($pax_array));
		    $sheet->getStyle('P'.$cell_no.':T'.$cell_no)->getNumberFormat()->setFormatCode('#,##0.00');
		    $sheet->getStyle('P'.$cell_no.':T'.$cell_no)->getNumberFormat()->setFormatCode('#,##0.00');
		    $sheet->getStyle('P'.($total_row).':T'.$total_row)->getNumberFormat()->setFormatCode('#,##0.00');
		    $sheet->getStyle('A'.($total_row).':O'.$total_row)->applyFromArray($style_footer_total_center);
		    $sheet->getStyle('P'.$total_row.':T'.$total_row)->applyFromArray($style_footer_total_right);
		    
		    
		    // CREATE EXCEL FILE
		    $objPHPExcel->getActiveSheet()->setTitle('Payment Report');
		    $objPHPExcel->setActiveSheetIndex(0);
		    //ob_end_clean();
		    //header('Content-type: application/vnd.ms-excel');
		    //header('Content-Disposition: attachment;filename ="Payment Report '.date('M-y').'.xlsx"');
		    //header('Cache-Control: max-age=0');
		    
		    //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		    //$objWriter->setPreCalculateFormulas(true);
		    //$objWriter->save('php://output');
		   
		    // Save our file xlsx
		    //$filename = 'upload/payment_report/รายงานรายรับประจำเดือน '.date('M-y').'.xlsx'; // LOCAL
		    $filename = getcwd().'/upload/payment_report/รายงานรายรับประจำเดือน '.date('M-y', strtotime($start_of_month)).'.xlsx';
		    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');// Excel 2010
		    $objWriter->save($filename);
		    
		    return $filename;
		}
		
		function report_ar ($start_of_month, $end_of_month) {
		    $objPHPExcel = new PHPExcel();
		    $sheet = $objPHPExcel->getActiveSheet();
		    // Set document properties
		    $objPHPExcel->getProperties()->setCreator("smsmart_booking_system");
		    $objPHPExcel->getProperties()->setTitle("End Of Month Payment Report");
		    $objPHPExcel->getProperties()->setSubject("End Of Month Payment Report");
		    $objPHPExcel->getProperties()->setDescription("End Of Month Payment Report");
		    $objPHPExcel->getProperties()->setKeywords("smsmart_booking_system");
		    $objPHPExcel->getProperties()->setCategory("Report");
		    
		    //$start_of_month = date('Y-m-01');
		    //$end_of_month = date('Y-m-t');
		    
		    // HEADER OF THE REPORT
		    $style_report_header = array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		        'font' => array(
		            'bold' => true
		        ),
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
		    );
		    $style_report_header_italic = array(
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		        'font' => array(
		            'bold' => true,
		            'italic' => 'italic',
		            'size' => 12
		        ),
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
		    );
		    // HEADER OF THE Table
		    $style_table_header = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'A9D08E')
		        ),
		        'font' => array(
		            'bold' => true,
		            'italic' => 'italic'
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    // Cell Text Center
		    $style_cell_center = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    // Cell Text Right
		    $style_cell_right = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    // Cell Text LEFT
		    $style_cell_left = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    
		    // FOOTER TOTAL CENTER
		    $style_footer_total_center = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        ),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'BDD7EE')
		        ),
		        'font' => array(
		            'bold' => true
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    // FOOTER TOTAL RIGHT
		    $style_footer_total_right = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		        ),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'BDD7EE')
		        ),
		        'font' => array(
		            'bold' => true
		        ),
		        'borders' => array(
		            'allborders' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
		        ),
		    );
		    
		    $objPHPExcel->getActiveSheet()->getStyle("A1:T1")
		    ->getAlignment()
		    ->setWrapText(true);
		    $objPHPExcel->getActiveSheet()->mergeCells('A1:T1');
		    $sheet->getStyle("A1:T1")->applyFromArray($style_report_header_italic);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'รายงานค้างชำระ SM Resort @ Khao Yai');
		    
		    $objPHPExcel->getActiveSheet()->mergeCells('A2:T2');
		    $sheet->getStyle("A2:T2")->applyFromArray($style_report_header);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'End of Date: '.date('d/m/Y', strtotime($end_of_month)));
		    
		    $objPHPExcel->getActiveSheet()->getStyle("A3:T3")
		    ->getAlignment()
		    ->setWrapText(true);
		    $sheet->getStyle("A3:T3")->applyFromArray($style_table_header);
		    // SET HEADER TITLE
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3',   'ลำดับ');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'วันที่ทำการจอง');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'หมายเลข Booking');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', 'ชื่อผู้เข้าพัก');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', 'วัน check-in');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'วัน check-out');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', 'จำนวนวันเข้าพัก');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', 'ราคา');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', 'รายการ');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', 'จำนวนผู้เข้าพัก (A|C)');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', 'ช่องทางการจอง');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', 'สถานะการชำระเงิน');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', 'วันที่ชำระเงิน');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', 'เลขที่ใบเสร็จ');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', 'ยืนยันการโอนโดย');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', 'Total Before Discount   ');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', 'Discount');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', 'ยอดรวม');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', 'VAT');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', 'Grand Total');
		    
		    
		    // SET WIDTH PER CELL
		    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); // Number
		    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13); // Booking Date
		    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13); // Booking Number
		    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Guest Name
		    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13); // Check-in Date
		    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13); // Check-out Date
		    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8); // Number of Nights
		    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Price Per Item
		    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20); // Rooms
		    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10); // PAX Adult | Children
		    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Backend or Front-end
		    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10); // Payment Status
		    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13); // Paid Date
		    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13); // Invoice #
		    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Staff Name
		    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20); // Total Before Discount
		    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20); // Discount
		    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20); // Subtotal
		    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20); // VAT
		    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20); // Grabd Total
		    
		    $line_ctr = 1;
		    
		    $result = $this->_getAR($end_of_month);
		    $pax_array = array();
			$cell_no = 0;
		    foreach ($result as $i => $b) {
    		        $pax_array[] = $b['pax'];
    		        $cell_no = $line_ctr + 3;
    		        $length_of_stay = dateDiff($b['check_in_date'], $b['check_out_date']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$cell_no, $line_ctr);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$cell_no, date('d-m-Y', strtotime($b['booking_date'])));
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$cell_no, $b['booking_number']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$cell_no, $b['guest_name']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$cell_no, date('d-m-Y', strtotime($b['check_in_date'])));
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$cell_no, date('d-m-Y', strtotime($b['check_out_date'])));
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$cell_no, $length_of_stay);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$cell_no, $b['rate']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$cell_no, $b['item_description']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$cell_no, $b['pax']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$cell_no, $b['channel']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$cell_no, $b['payment_status']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$cell_no, ($b['paid_date'] != '') ? date('d-m-Y', strtotime($b['paid_date'])) : '');
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$cell_no, $b['receipt_no']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$cell_no, $b['staff_name']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$cell_no, $b['total_before_discount'], 2);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$cell_no, $b['discount']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$cell_no, $b['sub_total']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$cell_no, $b['vat']);
    		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$cell_no, $b['total']);
    		        
    		        $sheet->getStyle('P'.$cell_no.':T'.$cell_no)->getNumberFormat()->setFormatCode('#,##0.00');
    		        
    		        $sheet->getStyle('A'.$cell_no)->applyFromArray($style_cell_center);
    		        $sheet->getStyle('B'.$cell_no)->applyFromArray($style_cell_center);
    		        $sheet->getStyle('C'.$cell_no)->applyFromArray($style_cell_center);
    		        $sheet->getStyle('D'.$cell_no)->applyFromArray($style_cell_left);
    		        $sheet->getStyle('E'.$cell_no)->applyFromArray($style_cell_center);
    		        $sheet->getStyle('F'.$cell_no)->applyFromArray($style_cell_center);
    		        $sheet->getStyle('G'.$cell_no)->applyFromArray($style_cell_right);
    		        $sheet->getStyle('H'.$cell_no)->applyFromArray($style_cell_left);
    		        $sheet->getStyle('I'.$cell_no)->applyFromArray($style_cell_left);
    		        $sheet->getStyle('J'.$cell_no)->applyFromArray($style_cell_center);
    		        $sheet->getStyle('K'.$cell_no)->applyFromArray($style_cell_center);
    		        $sheet->getStyle('L'.$cell_no)->applyFromArray($style_cell_center);
    		        $sheet->getStyle('M'.$cell_no)->applyFromArray($style_cell_center);
    		        $sheet->getStyle('N'.$cell_no)->applyFromArray($style_cell_left);
    		        $sheet->getStyle('O'.$cell_no)->applyFromArray($style_cell_left);
    		        $sheet->getStyle('P'.$cell_no)->applyFromArray($style_cell_right);
    		        $sheet->getStyle('Q'.$cell_no)->applyFromArray($style_cell_right);
    		        $sheet->getStyle('R'.$cell_no)->applyFromArray($style_cell_right);
    		        $sheet->getStyle('S'.$cell_no)->applyFromArray($style_cell_right);
    		        $sheet->getStyle('T'.$cell_no)->applyFromArray($style_cell_right);
    		        
    		        $objPHPExcel->getActiveSheet()->getStyle("A".$cell_no.":T".$cell_no)
    		        ->getAlignment()
    		        ->setWrapText(true);
    		        $line_ctr++;
		    }
		    
		    // SUMMARY
		    $total_row = $cell_no+2;
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$total_row, 'Total');
		    $cells_total = array('G', 'P', 'Q', 'R', 'S', 'T');
		    foreach ($cells_total as $ct) {
		        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($ct.$total_row, "=SUM(".$ct."3:".$ct.($cell_no).")");
		    }
		    
		    // PAX
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$total_row, $this->sumByCol_stringToArray($pax_array));
		    $sheet->getStyle('P'.$cell_no.':T'.$cell_no)->getNumberFormat()->setFormatCode('#,##0.00');
		    $sheet->getStyle('P'.$cell_no.':T'.$cell_no)->getNumberFormat()->setFormatCode('#,##0.00');
		    $sheet->getStyle('P'.($total_row).':T'.$total_row)->getNumberFormat()->setFormatCode('#,##0.00');
		    
		    $sheet->getStyle('A'.($total_row).':O'.$total_row)->applyFromArray($style_footer_total_center);
		    $sheet->getStyle('P'.$total_row.':T'.$total_row)->applyFromArray($style_footer_total_right);
		    
		    
		    // CREATE EXCEL FILE
		    $objPHPExcel->getActiveSheet()->setTitle('AR Report');
		    $objPHPExcel->setActiveSheetIndex(0);
		    //ob_end_clean();
		    //header('Content-type: application/vnd.ms-excel');
		    //header('Content-Disposition: attachment;filename ="Payment Report '.date('M-y').'.xlsx"');
		    //header('Cache-Control: max-age=0');
		    
		    //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		    //$objWriter->setPreCalculateFormulas(true);
		    //$objWriter->save('php://output');
		    
		    // Save our file xlsx
		    $filename = getcwd().'/upload/payment_report/รายงานลูกหนี้ค้างชำระ '.date('M-y', strtotime($start_of_month)).'.xlsx'; // PROD
		    //$filename = 'upload/payment_report/รายงานลูกหนี้ค้างชำระ '.date('M-y').'.xlsx'; // LOCAL
		    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');// Excel 2010
		    $objWriter->save($filename);
		    
		    return $filename;
		}
		
		public function _getPayments($start_date, $end_date)
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
		    $this->db->where('check_in_date >=', $start_date);
		    $this->db->where('check_in_date <=', $end_date);
		    $this->db->order_by('booking.check_in_date');
		    $booking = $this->db->get()->result_array();
		    //echo $this->db->last_query();
		    $rows = array();
		    
		    foreach ($booking as $i => $b) {
		  
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
		            'length_of_stay' => $length_of_stay,
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
		
		public function _getAR($end_date)
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
		    $this->db->where('check_in_date <=', $end_date);
		    $this->db->where('booking.balance_amount > 0');
		    $this->db->order_by('booking.check_in_date');
		    $booking = $this->db->get()->result_array();
		    //echo $this->db->last_query();
		    $rows = array();
		    
		    foreach ($booking as $i => $b) {
		        if (!$this->_is_expired($b)) {
					
				
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
		            'length_of_stay' => $length_of_stay,
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
		
		function sumByCol_stringToArray($array = array(), $col='') {
		    $result = '';
		    $sum1 = 0;
		    $sum2 = 0;		   
		    foreach ($array as $r) {
		        $col_split = explode('|', $r);
		        $sum1 += intval($col_split[0]);
		        $sum2 += intval($col_split[1]);
		    }		   
		    $result = $sum1.' | '.$sum2;
		    return $result;
		}
		
		function check_mondays_test ($date = '2023-11-01') {
			$return = false;
			$timestamp = strtotime($date);
			if(date('j', $timestamp) === '1') {
			   echo "It is the first day of the month today";
			}
		    else {
				echo date('j', $timestamp);
			}
			if(date('D', $timestamp) === 'Mon') {
			   echo "It is Monday today";
			}
			else {
				echo date('D', $timestamp);
			}
		}
		
		function check_mondays ($date) {
			$return = false;
			$timestamp = strtotime($date);			
			if(date('D', $timestamp) === 'Mon') {
			   $return = true;
			}
			return $return;
		}
		
		function check_first_of_month ($date) {
			$return = false;
			$timestamp = strtotime($date);
			if(date('j', $timestamp) === '1') {
			   $return = true;
			}		   			
			return $return;
		}
		
		function test_date_send_report () {
			echo ($this->check_mondays('2023-11-07')) ? 'Send Report' : "Don't send...";
		}
		
		function send_monthly_report_old () {
		    //$start_of_month = date('Y-m-01');
		    //$end_of_month = date('Y-m-t');
		    //echo date('Y-m-d').' '. date('Y-m-t');
			
			
			
		    if ($this->check_mondays(date('Y-m-d'))) {
    		    $attachment = array();
				$start_of_month = date('Y-m-01');
				$end_of_month = date('Y-m-t');	
    		    array_push($attachment, $this->report_payment($start_of_month, $end_of_month));
    		    array_push($attachment, $this->report_ar($start_of_month, $end_of_month));
    		    
    		    $subject = 'รายงานรายรับประจำเดือนและยอดลูกหนี้ค้างชำระ';
    		    $message = '<div style="font-family: Tahoma;"><p style="font-size: 16px;">เรียนทุกท่าน</p>'
    		        . '<p style="font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;เอกสารที่แนบมาเป็นรายงานรายรับประจำเดือน '.date('t M Y').' และยอดลูกหนี้ค้างชำระสิ้นสุดของเดือน '.date('t M Y').' ที่โครงการ เอส เอ็ม รีสอร์ท โชว์รูม เขาใหญ่ ซึ่งส่งอัตโนมัติโดยระบบ</p>'
    		        . '<p style="font-size: 16px;">ขอขอบคุณ</p>'
					. '<br><br><p style="font-size: 16px;">หมายเหตุ: อีเมล์นี้ถูกส่งโดยระบบอัตโนมัติ กรุณาอย่าตอบกลับอีเมล์นี้</p>'
    		        . '</div>';
    		    //$mail_to = 'mychelle@buildersmart.com, Panya@buildersmart.com';
    		    $mail_to = 'Sunchai@buildersmart.com, Saranya@alloysolutions.asia, Sirisak@alloysolutions.asia, Panya@buildersmart.com';
    		    $this->_sendEmail($mail_to, $subject, $message, $attachment);
		    }
			
			if ($this->check_first_of_month(date('Y-m-d'))) {
    		    $attachment = array();
				$d = strtotime ("-1 Months");
				$start_of_month = date('Y-m-d', $d);
				$end_of_month = date('Y-m-t', $d);	
    		    array_push($attachment, $this->report_payment());
    		    array_push($attachment, $this->report_ar());
    		    
    		    $subject = 'รายงานรายรับประจำเดือนและยอดลูกหนี้ค้างชำระ';
    		    $message = '<div style="font-family: Tahoma;"><p style="font-size: 16px;">เรียนทุกท่าน</p>'
    		        . '<p style="font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;เอกสารที่แนบมาเป็นรายงานรายรับประจำเดือน '.date('t M Y').' และยอดลูกหนี้ค้างชำระสิ้นสุดของเดือน '.date('t M Y').' ที่โครงการ เอส เอ็ม รีสอร์ท โชว์รูม เขาใหญ่ ซึ่งส่งอัตโนมัติโดยระบบ</p>'
    		        . '<p style="font-size: 16px;">ขอขอบคุณ</p>'
					. '<br><br><p style="font-size: 16px;">หมายเหตุ: อีเมล์นี้ถูกส่งโดยระบบอัตโนมัติ กรุณาอย่าตอบกลับอีเมล์นี้</p>'
    		        . '</div>';
    		    $mail_to = 'mychelle@buildersmart.com';
    		    //$mail_to = 'Sunchai@buildersmart.com, Saranya@alloysolutions.asia, Sirisak@alloysolutions.asia, Panya@buildersmart.com';
    		    $this->_sendEmail($mail_to, $subject, $message, $attachment);
		    }
		}
		
		function send_monthly_report () {
		    //$start_of_month = date('Y-m-01');
		    //$end_of_month = date('Y-m-t');
		    //echo date('Y-m-d').' '. date('Y-m-t');
			
			//$date_to_process = '2024-01-01';
			$date_to_process = date('Y-m-d');
			
			
			if ($this->check_first_of_month($date_to_process)) {
    		    $attachment = array();
				$d = strtotime ("-1 Months");
				$start_of_month = date('Y-m-d', $d);
				$end_of_month = date('Y-m-t', $d);	
    		    array_push($attachment, $this->report_payment($start_of_month, $end_of_month));
    		    array_push($attachment, $this->report_ar($start_of_month, $end_of_month));  
				$subject = 'รายงานรายรับประจำเดือนและยอดลูกหนี้ค้างชำระ';
    		    $message = '<div style="font-family: Tahoma;"><p style="font-size: 16px;">เรียนทุกท่าน</p>'
    		        . '<p style="font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;เอกสารที่แนบมาเป็นรายงานรายรับประจำเดือน '.$end_of_month.' และยอดลูกหนี้ค้างชำระสิ้นสุดของเดือน '.$end_of_month.' ที่โครงการ เอส เอ็ม รีสอร์ท โชว์รูม เขาใหญ่ ซึ่งส่งอัตโนมัติโดยระบบ</p>'
    		        . '<p style="font-size: 16px;">ขอขอบคุณ</p>'
					. '<br><br><p style="font-size: 16px;">หมายเหตุ: อีเมล์นี้ถูกส่งโดยระบบอัตโนมัติ กรุณาอย่าตอบกลับอีเมล์นี้</p>'
    		        . '</div>';
    		    //$mail_to = 'mychelle@buildersmart.com';
    		    $mail_to = 'Sunchai@buildersmart.com, Saranya@alloysolutions.asia, Sirisak@alloysolutions.asia, Panya@buildersmart.com';
    		    $this->_sendEmail($mail_to, $subject, $message, $attachment);
		    }
		    else if ($this->check_mondays($date_to_process)) {
    		    $attachment = array();
				$start_of_month = date('Y-m-01');
				$end_of_month = date('Y-m-t');	
    		    array_push($attachment, $this->report_payment($start_of_month, $end_of_month));
    		    array_push($attachment, $this->report_ar($start_of_month, $end_of_month));
				$subject = 'รายงานรายรับประจำเดือนและยอดลูกหนี้ค้างชำระ';
    		    $message = '<div style="font-family: Tahoma;"><p style="font-size: 16px;">เรียนทุกท่าน</p>'
    		        . '<p style="font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;เอกสารที่แนบมาเป็นรายงานรายรับประจำเดือน '.date('t M Y').' และยอดลูกหนี้ค้างชำระสิ้นสุดของเดือน '.date('t M Y').' ที่โครงการ เอส เอ็ม รีสอร์ท โชว์รูม เขาใหญ่ ซึ่งส่งอัตโนมัติโดยระบบ</p>'
    		        . '<p style="font-size: 16px;">ขอขอบคุณ</p>'
					. '<br><br><p style="font-size: 16px;">หมายเหตุ: อีเมล์นี้ถูกส่งโดยระบบอัตโนมัติ กรุณาอย่าตอบกลับอีเมล์นี้</p>'
    		        . '</div>';
    		    //$mail_to = 'mychelle@buildersmart.com';
    		    $mail_to = 'Sunchai@buildersmart.com, Saranya@alloysolutions.asia, Sirisak@alloysolutions.asia, Panya@buildersmart.com';
    		    $this->_sendEmail($mail_to, $subject, $message, $attachment);
		    }
			
			
			
				
			/*foreach ($attachment as $a) {
				print_r($a);
				echo "<br><br>";
			}*/
		}
		
		public function _sendEmail($to = '', $subject = '', $message = '', $attachment = array())
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
		    $this->email->to($to);
		    if (count($attachment) > 0) {
		        foreach ($attachment as $a) {
		          $this->email->attach($a);
		        }
		    }
			$this->email->set_mailtype("html");
		    //$this->email->IsHTML(true);
		    if ($this->email->send()) {
		        $ret['result'] = 'true';
		    } else {
		        $ret['message'] = $this->email->print_debugger();
		    }		    		   
		    
		    return $ret;
		}
		
	}
	
	
