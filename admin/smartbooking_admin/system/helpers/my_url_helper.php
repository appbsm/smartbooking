<?php
	function server_path() {
		return getcwd() .'/';
	}
	function share_folder() {
		return '../share_folder/sms_booking/';
	}
	function home_url() {
		return site_url();
	}
	function change_language_url() {
		return site_url() .'home/change_language';
	}

	///// User Login
	function user_auth_url() {
		return site_url() .'user/auth';
	}
	function user_login_url() {
		//return site_url() .'user/login';
		//$new_url = str_replace('smartbooking_admin_test/', '',site_url());
		$new_url = str_replace('smartbooking_admin/', '',site_url());
		return $new_url .'index.php';
	}
	function user_logout_url() {
		return site_url() .'user/logout';
	}
	function forgot_password_url() {
		return site_url() .'user/forgot_password';
	}
	function change_password_url() {
		return site_url() .'user/change_password';
	}

	///// Dashboard
	function dashboard_url() {
		return site_url() .'frontdesk/dashboard';
	}
	function get_occupied_by_date_url() {
		return site_url() .'frontdesk/getOccupiedByDate';
	}
	function calendar_url() {
		return site_url() .'frontdesk/calendar';
	}
	function get_calendar_url() {
		return site_url() .'frontdesk/getCalendar';
	}
	function reservations_url() {
		return site_url() .'frontdesk/reservations';
	}
	function get_reservations_url() {
		return site_url() .'frontdesk/getReservations';
	}
	function guest_booking_url() {
		return site_url() .'frontdesk/guest_booking';
	}
	function get_guest_booking_url() {
		return site_url() .'frontdesk/get_guest_booking';
	}
	function room_register_url() {
		return site_url() .'frontdesk/room_register';
	}
	function get_room_register_url() {
		return site_url() .'frontdesk/get_room_register';
	}

	///// POS Booking
	function guest_url() {
		return site_url() .'booking/guest';
	}
	function save_guest_url() {
		return site_url() .'pos/save_guest';
	}
	function edit_guest_url($id = '') {
		return site_url() .'pos/edit_guest/'. $id;
	}
	function delete_guest_url() {
		return site_url() .'pos/delete_guest';
	}
	function search_guest_url() {
		return site_url() .'pos/search_guest';
	}
	function booking_url() {
		return site_url() .'booking/booking';
	}
	function get_booking_url() {
		return site_url() .'pos/getBooking';
	}
	function edit_booking_url($id = '') {
		return site_url() .'pos/edit_booking/'. $id;
	}
	function late_booking_url($id = '') {
		return site_url() .'pos/late_booking/'. $id;
	}
	function delete_booking_url() {
		return site_url() .'pos/delete_booking';
	}
	function save_booking_url() {
		return site_url() .'pos/save_booking';
	}
	function update_booking_status_url() {
		return site_url() .'pos/update_booking_status';
	}
	function calculate_booking_price_url() {
		return site_url() .'pos/calculate_booking_price';
	}
	function show_invoice_url($id = '') {
		return site_url() .'pos/showInvoice/'. $id;
	}

	///// POS Order
	function order_url() {
		return site_url() .'pos/order';
	}
	function get_order_url() {
		return site_url() .'pos/getOrders';
	}
	function edit_order_url($id = '') {
		return site_url() .'pos/edit_order/'. $id;
	}
	function delete_order_url() {
		return site_url() .'pos/delete_order';
	}
	function save_order_url() {
		return site_url() .'pos/save_order';
	}
	function update_order_status_url() {
		return site_url() .'pos/update_order_status';
	}
	function calculate_order_price_url() {
		return site_url() .'pos/calculate_order_price';
	}
	function show_order_url($id = '') {
		return site_url() .'pos/showOrder/'. $id;
	}

	///// Report
	function reservation_report_url() {
		return site_url() .'report/reservation_report';
	}
	function get_reservation_report_url() {
		return site_url() .'report/get_reservation_report';
	}
	function daily_revenue_report_url() {
		return site_url() .'report/daily_revenue_report';
	}
	function get_daily_revenue_report_url() {
		return site_url() .'report/get_daily_revenue_report';
	}
	function payment_report_url() {
		return site_url() .'report/payment_report';
	}
	function get_payment_report_url() {
		return site_url() .'report/get_payment_report';
	}
	function ar_report_url() {
		return site_url() .'report/ar_report';
	}
	function get_ar_report_url() {
		return site_url() .'report/get_ar_report';
	}


	///// Setting
	// Setting => project
	function project_management_url() {
		return site_url() .'project/project_management';
	}
	function project_management_test_url() {
		return site_url() .'project_test/project_management';
	}
	function edit_project_url($id = '') {
		return site_url() .'project/edit_project/'. $id;
	}
	function save_project_url() {
		return site_url() .'project/save_project';
	}
	function delete_project_url() {
		return site_url() .'project/delete_project';
	}
	function save_project_photo_url() {
		return site_url() .'project/save_project_photo';
	}
	function save_project_highlights_url() {
		return site_url() .'project/save_project_highlights';
	}
	function save_business_url() {
		return site_url() .'project/save_business';
	}
	function delete_business_url() {
		return site_url() .'project/delete_business';
	}
	function save_point_of_interest_url() {
		return site_url() .'project/save_point_of_interest';
	}
	function delete_point_of_interest_url() {
		return site_url() .'project/delete_point_of_interest';
	}
	function save_policy_url() {
		return site_url() .'project/save_policy';
	}
	function delete_policy_url() {
		return site_url() .'project/delete_policy';
	}
	function save_facility_url() {
		return site_url() .'project/save_facility';
	}
	function delete_facility_url() {
		return site_url() .'project/delete_facility';
	}
	function select_facility_url() {
		return site_url() .'project/select_facility';
	}

	// Setting => Unit Rate
	function unit_management_url() {
		return site_url() .'unit/unit_management'; 
	}

	function edit_unit_id() {
		return site_url() .'unit/unit_management'; 
	}
	function edit_setting_url() {
		return site_url() .'unit/unit_management'; 
	}
	function delete_setting_url() {
		return site_url() .'unit/unit_management'; 
	}

	// Setting => internet
	function internet_management_url() {
		return site_url() .'internet/internet_management';
	}
	function edit_internet_url($id = '') {
		return site_url() .'internet/edit_internet/'.$id;
	}
	function delete_internet_url() {
		return site_url() .'internet/delete_internet';
	}
	function save_internet_url() {
		return site_url() .'internet/save_internet';
	}
	function get_internet_by_project() {
		return site_url() .'internet/get_internet_by_project/';
	}
	function get_internet_by_room_details() {
		return site_url() .'internet/get_internet_by_room_details/';
	}

	// Setting => water
	function water_management_url() {
		return site_url() .'water/water_management';
	}
	function edit_water_url($id = '') {
		return site_url() .'water/edit_water/'. $id;
	}
	function delete_water_url() {
		return site_url() .'water/delete_water';
	}
	function save_water_url() {
		return site_url() .'water/save_water';
	}
	function get_water_by_project() {
		return site_url() .'water/get_water_by_project/';
	}
	function get_water_by_room_details() {
		return site_url() .'water/get_water_by_room_details/';
	}

	// Using Record => internet
	function record_internet_management_url() {
		return site_url() .'record_internet/record_internet_management';
	}
	function save_record_internet_url() {
		return site_url() .'record_internet/save_record_internet';
	}
	function edit_record_internet_url($id = '') {
		return site_url() .'record_internet/edit_record_internet/'. $id;
	}

	// Using Record => water
	function record_water_management_url() {
		return site_url() .'record_water/record_water_management';
	}
	function save_record_water_url() {
		return site_url() .'record_water/save_record_water';
	}
	function edit_record_water_id($id = '') {
		return site_url() .'record_water/edit_record_water_id/'. $id;
	}
	function edit_record_water_url($id = '') {
		return site_url() .'record_water/edit_record_water/'. $id;
	}
	function get_record_water_by_project() {
		return site_url() .'record_water/get_water_by_project/';
	}
	function get_record_water_by_room_details() {
		return site_url() .'record_water/get_record_water_by_room_details/';
	}
	function get_record_water_by_room_number() {
		return site_url() .'record_water/get_record_water_by_room_number/';
	}
	function get_record_water_by_meter() {
		return site_url() .'record_water/get_record_water_by_meter/';
	}
	function get_record_water_by_meter_date() {
		return site_url() .'record_water/get_record_water_by_meter_date/';
	}

	// Using Record => electric
	function record_electric_management_url() {
		return site_url() .'record_electric/record_electric_management';
	}
	function save_record_electric_url() {
		return site_url() .'record_electric/save_record_electric';
	}
	function edit_record_electric_id($id = '') {
		return site_url() .'record_electric/edit_record_electric_id/'. $id;
	}
	function edit_record_electric_url($id = '') {
		return site_url() .'record_electric/edit_record_electric/'. $id;
	}
	function get_record_electric_by_project() {
		return site_url() .'record_electric/get_electric_by_project/';
	}
	function get_record_electric_by_room_details() {
		return site_url() .'record_electric/get_record_electric_by_room_details/';
	}
	function get_record_electric_by_room_number() {
		return site_url() .'record_electric/get_record_electric_by_room_number/';
	}
	function get_record_electric_by_meter() {
		return site_url() .'record_electric/get_record_electric_by_meter/';
	}
	function get_record_electric_by_meter_date() {
		return site_url() .'record_electric/get_record_electric_by_meter_date/';
	}

	// Setting => electric
	function electric_management_url() {
		return site_url() .'electric/electric_management';
	}
	function edit_electric_url($id = '') {
		return site_url() .'electric/edit_electric/'. $id;
	}
	function save_electric_url() {
		return site_url() .'electric/save_electric';
	}
	function delete_electric_url() {
		return site_url() .'electric/delete_electric';
	}
	function get_electric_by_project() {
		return site_url() .'electric/get_electric_by_project/';
	}
	function get_electric_by_room_details() {
		return site_url() .'electric/get_electric_by_room_details/';
	}

	// Setting => room
	function room_management_url() {
		return site_url() .'room/room_management';
	}
	function edit_room_type_url($id = '') {
		return site_url() .'room/edit_room_type/'. $id;
	}
	function save_room_type_url() {
		return site_url() .'room/save_room_type';
	}
	function delete_room_type_url() {
		return site_url() .'room/delete_room_type';
	}
	function save_room_type_photo_url() {
		return site_url() .'room/save_room_type_photo';
	}
	function save_seasonal_price_url() {
		return site_url() .'room/save_seasonal_price';
	}
	function delete_seasonal_price_url() {
		return site_url() .'room/delete_seasonal_price';
	}
	function save_amenity_url() {
		return site_url() .'room/save_amenity';
	}
	function delete_amenity_url() {
		return site_url() .'room/delete_amenity';
	}
	function select_amenity_url() {
		return site_url() .'room/select_amenity';
	}
	function save_room_detail_url() {
		return site_url() .'room/save_room_detail';
	}
	function delete_room_detail_url() {
		return site_url() .'room/delete_room_detail';
	}
	// Setting => extra
	function extra_url() {
		return site_url(). 'extra/extra_management';
	}
	function save_extra_url() {
		return site_url() .'extra/save_extra';
	}
	function delete_extra_url() {
		return site_url() .'extra/delete_extra';
	}
	// Setting => package
	function package_url() {
		return site_url() .'packages/package_management';
	}
	function edit_package_url($id = '') {
		return site_url() .'packages/edit_package/'. $id;
	}
	function calculate_package_price_url() {
		return site_url() .'packages/calculate_package_price';
	}
	function save_package_url() {
		return site_url() .'packages/save_package';
	}
	function delete_package_url($id = '') {
		return site_url() .'packages/delete_package/'. $id;
	}
	// Setting => discount
	function discount_url() {
		return site_url() .'discounts/discount_management';
	}
	function save_discount_url() {
		return site_url() .'discounts/save_discount';
	}
	function delete_discount_url() {
		return site_url() .'discounts/delete_discount';
	}
	// Setting => email_setting
	function edit_email_setting_url() {
		return site_url() .'email_setting/edit_email_setting';
	}
	function save_email_setting_url() {
		return site_url() .'email_setting/save_email_setting';
	}
	// Setting => config_setting
	function edit_config_setting_url() {
		return site_url() .'config_setting/edit_config_setting';
	}
	function save_config_setting_url() {
		return site_url() .'config_setting/save_config_setting';
	}
	
	// MYCHELLE -- Setting => gallery
	function gallery_management_url() {
		return site_url() .'gallery/gallery_management';
	}
	
	function save_gallery_category_url() {
		return site_url() .'gallery/save_gallery_category';
	}
	
	function add_photo_gallery_url($id='') {
		return site_url() .'gallery/add_photo_gallery/'. $id;
	}
	
	function save_gallery_photo_url() {
		return site_url() .'gallery/save_gallery_photo';
	}
	
	function update_gallery_photo_url() {
		return site_url() .'gallery/update_gallery_photo';
	}
	
	function delete_photo_url() {
		return site_url() .'gallery/delete_gallery_photo';
	}
	
	function delete_gallery_url() {
		return site_url() .'gallery/delete_gallery';
	}
	
	function update_gallery_category_url() {
		return site_url() .'gallery/update_gallery_category';
	}

	// MYCHELLE -- Setting => unit
	function sms_unit_management_url() {
		return site_url() .'sms_unit/unit_management';
	}

	function save_sms_unit_url() {
		return site_url() .'sms_unit/save_sms_unit';
	}
	
	function update_sms_unit_url() {
		return site_url() .'sms_unit/update_sms_unit';
	}

	function delete_sms_unit_url() {
		return site_url() .'sms_unit/delete_sms_unit';
	}

	function add_photo_unit_url($id='') {
		return site_url() .'sms_unit/add_photo_unit/'. $id;
	}

	function save_sms_unit_photo_url() {
		return site_url() .'sms_unit/save_sms_unit_photo';
	}

	function update_unit_photo_url() {
		return site_url() .'sms_unit/update_sms_unit_photo';
	}

	function delete_sms_unit_photo_url() {
		return site_url() .'sms_unit/delete_sms_unit_photo';
	}

	///// HR
	// HR => role
	function role_management_url() {
		return site_url() .'hr/role_management';
	}
	function delete_role_url() {
		return site_url() .'hr/delete_role';
	}
	function edit_role_url($id = '') {
		return site_url() .'hr/edit_role/'. $id;
	}
	function save_role_url() {
		return site_url() .'hr/save_role';
	}
	// HR => user
	function user_management_url() {
		return site_url() .'hr/user_management';
	}
	function delete_user_url() {
		return site_url() .'hr/delete_user';
	}
	function edit_user_url($id = '') {
		return site_url() .'hr/edit_user/'. $id;
	}
	function save_user_url() {
		return site_url() .'hr/save_user';
	}
	// MYCHELLE -- Setting => Credit
	function credit_url() {
		return site_url() .'credit/credit_management';
	}

	function delete_credit_url() {
		return site_url() .'credit/delete_credit';
	}

	function save_credit_url() {
		return site_url() .'credit/save_credit';
	}
?>