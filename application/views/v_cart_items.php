<?php
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI = &get_instance();
$CI->load->model('m_room_type');
$check_in_date = date('d-m-Y');
$check_out_date = date('d-m-Y', strtotime($check_in_date . '+1 day'));
?>

<style>
	.nav-link.active {
		background-color: #81BB4A !important;
	}

	.room_type_header {
		font-size: 1.4em;
		font-weight: bold;
		color: #eee;
	}

	hr {
		border: 0;
		border-top: 1px solid #CCC;
	}

	.hr3 {
		border: 0;
		height: 2px;
		background-image: linear-gradient(to right, transparent, #CCC, transparent);
	}

	.section_header {
		font-weight: bold;
		font-size: 1.1em;
	}

	.cross_out {
		text-decoration: line-through;
	}

	.red_color {
		color: red;
	}

	.table th,
	.table td {
		vertical-align: middle !important;
	}
	/* Styles for Mobile Phones */
	@media (max-width: 480px) {
		.mw-300{
			max-width: 200px;
		}
	}

	/* Styles for Portrait Tablets */
	@media (min-width: 481px) and (max-width: 768px) {
		.mw-300{
			max-width: 300px;
		}
	}

	/* Styles for Landscape Tablets and Small Desktops */
	@media (min-width: 769px) and (max-width: 1024px) {
		.mw-300{
			max-width: 300px;
		}
	}

	/* Styles for Large Desktops */
	@media (min-width: 1201px) {
		.mw-300{
			max-width: 300px;
		}
	}
	
	.button__badge {
		margin-right: 0px;
		font-size: 0.6em !important;
		position: absolute;
		top: -8px !important;
		right: -4px !important;
	}
	.form-control-ckinout {
		/*padding: 1.165rem .75rem !important;*/
		padding: .375rem .75rem !important;
	}
	.price {
		/*background-color: #2a2a2e;*/
		background-color: #5392f9;
		color: white;
		text-shadow: 2px 2px 4px #000000;
	}
	.btn-adults {
		border: 1px solid #dee2e6 !important;
		background-color: unset !important; 
		color: #000 !important;
		/*border: 1px solid #5392f9 !important;
		background-color: #5392f9 !important; 
		color: #FFF !important;*/
		padding: 2px !important;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.border-r-10 {
		/*border: 1px solid #81BB4A;*/
		border: 1px solid #ccc;
		border-radius: 10px;
	}
	.btn-backnext {
		width: auto;
		height: auto;
		text-transform: uppercase;
		line-height: 1.5 !important;
		color: #fff !important;
		font-size: 14px !important;
		background-color: #102958 !important;
		border-color: #102958 !important;
		padding: 6px 12px !important;
	}
	.btn-backnext:hover {
        background-color: #102958 !important;
        color: #fff !important; 
		border-color: #102958 !important;

    }
	.fa-xl {
		font-size: 1em;
		line-height: 0.04167em;
		vertical-align: -0.125em;
	}
	.fa-lg {
		font-size: 1.55em;
		line-height: 0.05em;
		vertical-align: -0.075em;
	}
	.input_number_sm {
		-moz-appearance: textfield;
		text-align: center !important;
		padding-left: 10px;
		border: none;
		background-color: #fff;
		color: #202030;
		width: 40px;
		font-size: 1rem !important;
	}
	.btn_stepper_sm {
		color: #3264fe;
		background-color: unset !important;
		border: none;
		font-size: 20px;
		cursor: pointer;
		outline: 0 !important;
	}
	.form-control, label {
		color: #000 !important;
	}
	.btn_stepper {
		background-color: #102958 !important;
		border: none;
		border-radius: 50%;
		width: 25px;
		height: 25px;
		display: flex;
		align-items: center;
		justify-content: center;
		align-items: center;
	}

	.btn_stepper:focus {
		outline: none;
	}

	.input_number {
		text-align: center !important;
		border: 1px solid #CCC;
		background-color: white;
		width: 30%;
		margin: 0 8px;
	}

	.input_number:focus {
		outline: none;
	}
</style>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
$this->load->model('m_package');

$id_project_info = 1;
$p_date = 0;
$r_date = 0;
?>


<main class="main-2">
	<div class="container">
	<!--
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12 price room_type_header mt-3" style="margin-top: 40px !important;">
					<h5><span style="margin-left: 10px;"><?php echo $this->lang->line('my_cart'); ?></span></h5>
				</div>
			</div>

		</div>
		-->
		
		<div class="row" style=" padding: 20px; margin-top: 20px; font-size: 14px !important;">
			<!-- <div class="col-md-12"> -->
			<!-- <div style="width: 100%; padding: 10px;"> -->

			<div class="col-md-4">
				<!-- <div class="group"> -->
				<label for="name" style="font-weight: 500;" class="mb-0"><?php echo $this->lang->line('check_in_date'); ?></label>
				<input type='text' class="form-control datepicker search_input " style="color: #000; !important" name="check_in_date" id="check_in_date" value="<?= $check_in_date; ?>" />
				<!-- </div> -->
			</div>
			<div class="col-md-4">
				<label for="name" style="font-weight: 500;" class="mb-0"><?php echo $this->lang->line('check_out_date'); ?></label>
				<input type='text' class="form-control datepicker search_input " style="color: #000; !important" name="check_out_date" id="check_out_date" value="<?= $check_out_date; ?>" />
			</div>

			<div class="col-md-4">
				<label class="ml-1 mb-0" for="name" style="font-weight: 500; color: #000; !important"><?php echo $lang == "english" ? 'Adult' : 'ผู้เข้าพัก'; ?></label>
				<div class="dropdown">
					<button class="btn dropdown-toggle w-100 search_input btn-adults" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span id="div_adult" style="color: #000 !important;">
							<?php echo @$search_data['adult'] ? $search_data['adult'] : 2; ?>
						</span> <?php echo $this->lang->line('adults'); ?>, 
						<span id="div_children" style="color: #000 !important;"><?php echo @$search_data['children'] ? $search_data['children'] : 0; ?></span> 
						<?php echo $this->lang->line('children'); ?> <!-- , <span id="div_room">1</span> Rooms -->
					</button>
					<div class="dropdown-menu" style="vertical-align: bottom;" aria-labelledby="dropdownMenuButton">
						<div class="stepper">
							<div style="display: flex; justify-content: center;"><?php echo $this->lang->line('adult'); ?></div>
							<div style="display: flex; justify-content: center;  ">
								<button class="btn_stepper " id="decrement-adult" onClick="stepper(this);"> - </button>
								<input class="input_number" type="number" min="0" max="100" step="1" value="<?= @$search_data['adult'] ? $search_data['adult'] : 2; ?>" id="adult" readonly>
								<button class="btn_stepper " id="increment-adult" onClick="stepper(this);"> + </button>
							</div>
							<div class="rounded hr3 mt-2 mb-2"></div>
							<div style="display: flex; justify-content: center;"><?php echo $this->lang->line('children'); ?></div>
							<div style="display: flex; justify-content: center;">
								<button class="btn_stepper " id="decrement-children" onClick="stepper(this);"> - </button>
								<input class="input_number" type="number" min="0" max="100" step="1" value="<?= @$search_data['children'] ? $search_data['children'] : 0; ?>" id="children" readonly>
								<button class="btn_stepper " id="increment-children" onClick="stepper(this);"> + </button>
							</div>

							<div class="kids_age">
								<div class="col-md-12">
									<div class="row div_kids_age">
										<?php if ($search_data['children'] > 0) { ?>
											<?php foreach ($search_data['select_age'] as $key => $val) { ?>
												<div class="col-md-4" style="padding: 5px;">
													<label>อายุ</label><select class="form-control select_age" name="select_age[]">
														<option value="0" <?php if ($val == 0) {
																				echo "selected";
																			} ?>>0</option>
														<option value="1" <?php if ($val == 1) {
																				echo "selected";
																			} ?>>1</option>
													</select>
												</div>
											<?php } ?>
										<?php } ?>

									</div>
								</div>
							</div> <!-- Kids Age -->
							<div class="rounded hr3 mt-2"></div>
							<!-- 
									<div style="display: flex; justify-content: center;">Rooms</div>
									<div style="display: flex; justify-content: center; background-color: white; box-shadow: 0 20px 30px rgba(0,0,0,0.1)">							    
									<button class="btn_stepper " id="decrement-room" onClick="stepper(this);"> - </button>
									<input class="input_number" type="number" min="0" max="100" step="1" value="1" id ="room" readonly>
									<button class="btn_stepper " id="increment-room" onClick="stepper(this);"> + </button>
									</div>
									-->
						</div>
					</div>
				</div>
				<!-- </div> -->
				<!-- </div> -->
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 ">
				<input type="checkbox" style="height:15px; width:15px; margin-left: 8px;" class="select_all cb" onClick="toggle(this);">
				<p class="ml-2 mt-0" style="font-weight: 500; color: #000; !important; font-size: 14px !important;"><?php echo $lang == "english" ? 'Select All' : 'เลือกทั้งหมด'; ?></p>
			</div>
			<div class="col-md-9">
				<!-- package or room -->
				<?php
				//print_r($_SESSION);
				$date = date('Y-m-d');
				$ctr = 1;
				if (sizeof($cart_items) > 0) {
					foreach ($cart_items as $key => $item) {
						if (isset($item->id_room_type)) {
							$room_type = $CI->m_room_type->get_room_type_by_ID($id_project_info, $item->id_room_type);

							$room_count = $CI->m_room_type->get_count_available_rooms($item->id_room_type, date('Y-m-d'), date("Y-m-d", strtotime('tomorrow')));
							$room_qty = ($room_count > $item->quantity) ? $item->quantity : $room_count;
							$rate = $CI->m_room_type->get_day_rate($room_type->id_room_type, $date);
							if ($rate == '') {
								$rate = $rt->default_rate;
							}
							$first_photo = $CI->m_room_type->get_first_photo_room_type($item->id_room_type);
				?>
							<div class="row mx-1 mb-2">
								<div class="col-12 border-r-10">
									<div class="row">
										<div class="col-10">

										</div>
										<div class="col-2 text-right mt-3">
											<a class="delete-item" data-id="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key; ?>"><i class="fa-solid fa-trash-can fa-xl" style="color: #030303;"></i><?php //echo $this->lang->line('delete');
																																																											?></a>
										</div>
									</div>
									<div class="row">

										<div class="col-md-10">
											<div class="row">
												<div class="col-1 text-right">
													<input <?php echo ($room_count == 0) ? 'disabled' : ''; ?> style="height:15px;width:15px;" type="checkbox" class="chk_item cb room" id="id_room_<?php echo $item->id_room_type ?>" data-id="room_<?php echo $item->id_room_type ?>" data-item-type="room" data-item="<?php echo $item->id_room_type ?>" data-price="<?php echo $rate; ?>">
												</div>
												<div class="col-md-6 text-center">
													<img class="img-thumbnail mw-300"  src="<?php echo share_folder_path() . $first_photo->room_photo_url; ?>" />
												</div>
												<div class="col-md-5 align-self-center text-center">
													<h6 style="color: #000; !important"><?php echo $lang == 'english' ? $room_type->room_type_name_en : $room_type->room_type_name_th; ?></h6>
												</div>

											</div>
										</div>
										<div class="col-md-2 align-self-center pl-0">
											<div style="display: flex; justify-content: center; background-color: white; vertical-align: bottom; font-size: 12px!important;">
												<button class="btn_stepper_sm" data-max="<?php echo $room_count; ?>" data-cart-item="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key; ?>" data-room="<?php echo $item->id_room_type; ?>" id="decrement-room-<?php echo $item->id_room_type; ?>" onClick="stepper_room(this);"><i class="fa-solid fa-circle-minus fa-lg" style="color: #000000;"></i></button>
												<input class="input_number_sm room_stepper ml-2" type="number" min="1" max="<?php echo $room_count; ?>" step="1" value="<?php echo ($room_qty == 0) ? 1 : $room_qty; ?>" id="room_<?php echo $item->id_room_type; ?>" readonly>
												<button class="btn_stepper_sm" data-max="<?php echo $room_count; ?>" data-cart-item="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key; ?>" data-room="<?php echo $item->id_room_type; ?>" id="increment-room-<?php echo $item->id_room_type; ?>" onClick="stepper_room(this);"><i class="fa-solid fa-circle-plus fa-lg" style="color: #000000;"></i></button>
											</div>
										</div>

									</div>
									<div class="row ml-5 my-2">
										<div class="col-6">
											<div class="row">
												<div class="col-12">
													<!-- วันที่เข้าพัก -->
												</div>
												<div class="col-12">
													<!-- 14 เมษา 2023 - 15 เมษา 2023 -->
													<!-- <a name="r_date_in<?php echo $r_date; ?>" id="r_date_in<?php echo $r_date; ?>"></a> - <a name="r_date_out<?php echo $r_date; ?>" id="r_date_out<?php echo $r_date; ?>"></a> -->
												</div>
											</div>
										</div>
										<div class="col-6 text-right">
											<div class="row"  style="font-size: 0.8rem !important;">
												<div class="col-12" id="changed_date_rate">
													<?php echo number_format($rate * $item->quantity, 2); ?>
												</div>
												<div class="col-12">
													<em>รวมภาษีและค่าธรรมเนียม</em>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- end package od room -->

						<?php
						} // END OF if ($item->id_room_type
						else if (isset($item->id_package)) {
							$is_package_available = $this->m_package->is_package_available($item->id_package, date('Y-m-d', strtotime($check_in_date)), date('Y-m-d', strtotime($check_out_date)));
							$package_rooms = $this->m_package->get_package_items_by_id($item->id_package);
							$package_count = $this->m_package->get_available_package(date('Y-m-d'), $item->id_package);
							$room_qty = ($package_count > $item->quantity) ? $item->quantity : $package_count;


							$id_cart = (isset($item->id_cart_item)) ? $item->id_cart_item : $key;
						?>

							<div class="row mx-1 mb-2">
								<div class="col-12 border-r-10">
									<div class="row mt-3">
										<div class="col-1 text-right">
											<input <?php echo ($is_package_available == 0) ? 'disabled' : ''; ?> style="height:15px; width:15px;" type="checkbox" class="chk_item cb package" data-id="package_<?php echo $package_rooms[0]->id_package; ?>" id="id_package_<?php echo $package_rooms[0]->id_package; ?>" data-item-type="package" data-item="<?php echo $package_rooms[0]->id_package; ?>" data-price="<?php echo $package_rooms[0]->price; ?>">
										</div>
										<div class="col-9 pl-0">
											<h5><?php echo $package_rooms[0]->name; ?></h5>
										</div>
										<div class="col-2 text-right">
											<a class="delete-item" data-id="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key; ?>">
												<i class="fa-solid fa-trash-can fa-xl" style="color: #030303;"></i>
											</a>
										</div>
									</div>
									<div class="row">
										<div class="col-md-10"></div>
										<div class="col-md-2 pl-0 align-self-center">

											<div class="text-center" style="display: flex; justify-content: center; background-color: white; vertical-align: bottom; font-size: 12px!important;">
												<button class="btn_stepper_sm bg-fa-lg" data-max="<?php echo sizeof($package_count); ?>" data-cart-item="<?php echo ($this->session->userdata('id_guest') != '') ? $id_cart : $key; ?>" data-package="<?php $package_rooms[0]->id_package; ?>" id="decrement-package-<?php echo $package_rooms[0]->id_package; ?>" onClick="stepper_package(this);">
													<i class="fa-solid fa-circle-minus fa-lg" style="color: #000000;"></i>
												</button>

												<input class="input_number_sm room_stepper ml-2" type="number" min="0" max="<?php echo sizeof($package_count); ?>" step="1" value="<?php echo ($room_qty == 0) ? 1 : $room_qty; ?>" id="package_<?php echo $item->id_package; ?>" readonly>


												<button class="btn_stepper_sm" data-max="<?php echo sizeof($package_count); ?>" data-cart-item="<?php echo ($this->session->userdata('id_guest') != '') ? $id_cart : $key; ?>" data-room="<?php echo $package_rooms[0]->id_package; ?>" id="increment-room-<?php echo $package_rooms[0]->id_package; ?>" onClick="stepper_package(this);">
													<i class="fa-solid fa-circle-plus" style="color: #000000;"></i>
												</button>


											</div>

										</div>
									</div>

									<?php
									$i_show = 1;
									foreach ($package_rooms as $item) {
										$first_photo = $CI->m_room_type->get_first_photo_room_type($item->id_room_type);
										$room_type = $CI->m_room_type->get_room_type_by_ID($id_project_info, $item->id_room_type);

									?>

										<div class="row mb-2">
											<div class="col-1 text-right"></div>
											<div class="col-sm-5 text-center">
												<img src="<?php echo share_folder_path() . $first_photo->room_photo_url; ?>" class="mw-300"/>
											</div>
											<div class="col-sm-6 align-self-center text-center">
												<h6><?php echo $lang == 'english' ? $room_type->room_type_name_en : $room_type->room_type_name_th; ?></h6>
											</div>

										</div>

									<?php $i_show++;
									} ?>

									<div class="row ml-5 my-2">
										<div class="col-6">
											<div class="row">
												<div class="col-12">
													<!-- วันที่เข้าพัก -->
												</div>
												<div class="col-12">
													<!-- 14 เมษา 2023 - 15 เมษา 2023 -->
													<!-- <a name="p_date_in<?php echo $p_date; ?>" id="p_date_in<?php echo $p_date; ?>"></a> - <a name="p_date_out<?php echo $p_date; ?>" id="p_date_out<?php echo $p_date++; ?>"></a>										 -->
												</div>
											</div>
										</div>
										<div class="col-6 text-right">
											<div class="row"  style="font-size: 0.8rem !important;">
												<div class="col-12">
													<?php echo number_format($package_rooms[0]->price, 2); ?>
												</div>
												<div class="col-12">
													<em>รวมภาษีและค่าธรรมเนียม</em>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
				<?php
						} // else if ($item->id_room_type
					} // foreach($cart_items as $key => $item) {
				} // IF
				?>

			</div>
			<div class="col-md-3">
				<div class="col-md p-2 m-0 border-r-10">
					<div class="row">
						<div class="col-md-12 m-2 text-center d-flex flex-row justify-content-between">
							<label style="font-size: 1em !important; font-weight: bold; margin: 8px 5px 5px 5px;"><?php echo $this->lang->line('total'); ?>: </label>
							<div id="total" style="font-size: 1em !important; font-weight: bold; padding: 8px 20px 5px 0;">0.00</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-sm-12 my-3 text-center">
							<button class="btn button-secondary btn-backnext" onclick="location.href='<?php echo site_url('/')?>'" id="back_to_cart"><?php echo $this->lang->line('back'); ?></button>
							<button class="btn button-primary btn-backnext" id="proceed_to_booking"><?php echo $this->lang->line('proceed_to_booking'); ?></button>
						</div>
					</div>
				</div>
			</div>

		</div>
</main>

<form name="frm_book" id="frm_book" method="post" action="<?php echo site_url('booking') . '/guest_info'; ?>">
	<input type="hidden" name="h_id_room" id="h_id_room" value="">
	<input type="hidden" name="h_id_package" id="h_id_package" value="">
	<input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="">
	<input type="hidden" name="h_num_of_room" id="h_num_of_room" value="">
	<input type="hidden" name="h_num_of_children" id="h_num_of_children" value="">
	<input type="hidden" name="h_children_ages" id="h_children_ages" value="">
	<input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
	<input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">
	<input type="hidden" name="page" id="page" value="cart_items">
</form>





<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo site_url(); ?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url(); ?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>

<!-- /////////////////////////////////////////////////// -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
	function toggle(source) {
		checkboxes = document.getElementsByClassName('chk_item');
		for (var i = 0, n = checkboxes.length; i < n; i++) {
			var x = checkboxes[i].disabled;
			if (!x)
				checkboxes[i].checked = source.checked;
		}
	}

	function stepper(dis) {
		let btn_id = dis.getAttribute('id');
		let max = dis.getAttribute('max');
		const myArray = btn_id.split("-");
		var myInput = myArray[1];
		let min = $('#' + myInput).val();

		var newval = (myArray[0] == 'increment') ? (parseInt(min) + 1) : (parseInt(min) - 1);
		newval = (newval < 0) ? 0 : newval;
		$('#' + myInput).val(newval);
		$('#div_' + myInput).html(newval);
		//console.log(newval);
		if (btn_id == 'increment-children') {
			$('.div_kids_age').html('');
			var new_html = '';
			if (newval > 0) {
				for (var x = 0; x < newval; x++) {
					max_age = '<?php echo app_settings('max_children_age'); ?>';
					var option_ct = 1;
					new_html += '<div class="col-md-3" style="padding: 1px;">' +
						'<label><?php echo $this->lang->line('ages'); ?></label>' +
						'<select class="form-control select_age" name="select_age[]">' +
						'<option value="0">0</option>';
					do {
						new_html += '<option value="' + option_ct + '">' + option_ct + '</option>';
						option_ct++;
					} while (option_ct <= max_age);
					new_html += '</select></div>';
				}

			}
			//console.log(new_html);
			$('.div_kids_age').html(new_html);
		}

		if (btn_id == 'decrement-children') {
			var new_html = '';
			if (newval > 0) {
				for (var x = 0; x < newval; x++) {
					max_age = '<?php echo app_settings('max_children_age'); ?>';
					var option_ct = 1;
					new_html += '<div class="col-md-3" style="padding: 1px;">' +
						'<label><?php echo $this->lang->line('ages'); ?></label>' +
						'<select class="form-control select_age" name="select_age[]">' +
						'<option value="0">0</option>';
					do {
						new_html += '<option value="' + option_ct + '">' + option_ct + '</option>';
						option_ct++;
					} while (option_ct <= max_age);
					new_html += '</select></div>';
				}
			}
			$('.div_kids_age').html(new_html);
		}


	}

	function stepper_room(dis) {
		let btn_id = dis.getAttribute('id');
		let max = dis.getAttribute('data-max');
		//console.log(max);
		var id_room_type = dis.getAttribute('data-room');
		var id_cart_item = dis.getAttribute('data-cart-item');
		//console.log(id_room_type);
		const myArray = btn_id.split("-");
		var myInput = myArray[1];
		let min = $('#room_' + id_room_type).val();
		//console.log(min);
		var newval = (myArray[0] == 'increment') ? (parseInt(min) + 1) : (parseInt(min) - 1);
		newval = (newval < 0) ? 0 : newval;
		//alert(newval)

		//$('#'+myInput).val(newval);
		if (myArray[0] == 'decrement') {
			if (newval > 0) {
				$('#room_' + id_room_type).val(newval);
				var _url = "<?php echo site_url('cart/update_cart_ajax'); ?>";
				$.ajax({
						method: "POST",
						url: _url,
						data: {
							'id_cart_item': id_cart_item,
							'id_room_type': id_room_type,
							'quantity': newval
						}
					})
					.done(function(res) {});
			} else {
				delete_row(id_cart_item);
			}
		}
		if (myArray[0] == 'increment') {
			if (newval <= max) {
				$('#room_' + id_room_type).val(newval);
				var _url = "<?php echo site_url('cart/update_cart_ajax'); ?>";
				$.ajax({
						method: "POST",
						url: _url,
						data: {
							'id_cart_item': id_cart_item,
							'id_room_type': id_room_type,
							'quantity': newval
						}
					})
					.done(function(res) {});
			} else {
				alert("Max available room reached")
			}
		}


		calc_total_price();
	}

	function stepper_package(dis) {
		let btn_id = dis.getAttribute('id');
		let max = dis.getAttribute('data-max');
		var id_package = dis.getAttribute('data-package');
		var id_cart_item = dis.getAttribute('data-cart-item');
		//console.log(id_room_type);
		const myArray = btn_id.split("-");
		var myInput = myArray[1];
		let min = $('#package_' + id_cart_item).val();
		//console.log(min);
		var newval = (myArray[0] == 'increment') ? (parseInt(min) + 1) : (parseInt(min) - 1);
		newval = (newval < 0) ? 0 : newval;
		//alert(newval)

		//$('#'+myInput).val(newval);
		if (myArray[0] == 'decrement') {
			if (newval > 0) {
				$('#package_' + id_package).val(newval);
				var _url = "<?php echo site_url('cart/update_cart_package'); ?>";
				$.ajax({
						method: "POST",
						url: _url,
						data: {
							'id_cart_item': id_cart_item,
							'id_package': id_package,
							'quantity': newval
						}
					})
					.done(function(res) {});
			} else {
				delete_row(id_cart_item);
			}
		}
		if (myArray[0] == 'increment') {
			if (newval <= max) {
				$('#package_' + id_package).val(newval);
				var _url = "<?php echo site_url('cart/update_cart_package'); ?>";
				$.ajax({
						method: "POST",
						url: _url,
						data: {
							'id_cart_item': id_cart_item,
							'id_package': id_package,
							'quantity': newval
						}
					})
					.done(function(res) {});
			} else {
				alert("Max available room reached")
			}
		}


		calc_total_price();
	}

	function get_room_count_on_change_date() {
		var className = document.getElementsByClassName('chk_item');
		var rooms = [];
		var rooms_to_check = [];

		for (var i = 0; i < className.length; i++) {
			var item_type = className[i].getAttribute('data-item-type');
			var id_item = className[i].getAttribute('data-item');
			var id_ = className[i].getAttribute('data-id');
			console.log(id_ + ' ' + id_item + ' ' + item_type);

			//console.log(id_room_type);
			if (item_type == 'room') {
				var _url = "<?php echo site_url('cart/get_available_room_by_room_type'); ?>";
				$.ajax({
						method: "POST",
						url: _url,
						data: {
							'id_room_type': id_item,
							'id_item': id_,
							'check_in_date': $('#check_in_date').val(),
							'check_out_date': $('#check_out_date').val()
						}
					})
					.done(function(res) {
						var obj = eval('(' + res + ')');
						console.log("RooM: " + obj.id_room_type + ' = ' + obj.room_count);
						console.log(obj);
						if (obj.room_count == 0) {
							console.log('red');
							$('#tr_' + obj._id_item).addClass('red_color');
							$('.cb').prop('checked', false);
							$('#id_' + obj._id_item).attr('disabled', true);
						} else {
							//console.log('test');
							$('#tr_' + obj._id_item).removeClass('red_color');

							$('#id_' + obj._id_item).prop('disabled', false);
							// set data-max 
						}
						//$('#room_'+obj.id_room_type).val(obj.room_count);
						$('#room_' + obj.id_room_type).attr('max', obj.room_count);
						$('#increment-room-' + obj.id_room_type).attr('data-max', obj.room_count);
						$('#decrement-room-' + obj.id_room_type).attr('data-max', obj.room_count);
						console.log("Date changed");
						$('#changed_date_rate').html(number_add_comma_decimal(obj.price));
						$('#id_'+obj._id_item).attr('data-price', obj.price);
					});
			} else if (item_type == 'package') {
				var _url = "<?php echo site_url('cart/get_available_package'); ?>";
				$.ajax({
						method: "POST",
						url: _url,
						data: {
							'id_package': id_item,
							'id_item': id_,
							'check_in_date': $('#check_in_date').val(),
							'check_out_date': $('#check_out_date').val()
						}
					})
					.done(function(res) {
						var obj = eval('(' + res + ')');
						console.log(obj);
						if (obj.package_count == 0) {
							console.log('red');
							$('#tr_' + obj._id_item).addClass('red_color');
							$('.cb').prop('checked', false);
							$('#id_' + obj._id_item).attr('disabled', true);
						} else {
							//console.log('test');
							$('#tr_' + obj._id_item).removeClass('red_color');
							$('#id_' + obj._id_item).prop('disabled', false);
							// set data-max 
						}
						//$('#'+obj._id_item).val(obj.package_count);
						$('#' + obj._id_item).attr('max', obj.package_count);
						$('#increment-package-' + obj.id_package).attr('data-max', obj.package_count);
						$('#decrement-package-' + obj.id_package).attr('data-max', obj.package_count);
					});
			}
			
		}
	}

	function delete_row(id_cart_item) {
		var r = confirm("<?php echo $this->lang->line('message_delete_item'); ?>");
		if (r) {
			var _url = "<?php echo site_url('cart/delete_to_cart'); ?>";

			$.ajax({
					method: "POST",
					url: _url,
					data: {
						'id_cart_item': id_cart_item
					}
				})
				.done(function(res) {
					//var obj = eval('('+res+')');
					//console.log(res);
					alert('<?php echo $this->lang->line('delete_successful'); ?>')
					location.reload();
				});
		}

	}

	function calc_total_price() {
		var total = 0;
		var className = document.getElementsByClassName('chk_item');

		for (var i = 0; i < className.length; i++) {
			if (className[i].checked) {
				var item_type = className[i].getAttribute('data-item-type');
				if (item_type == 'room') {
					var id_room_type = className[i].getAttribute('data-item');
					item_total_price = (parseFloat(className[i].getAttribute('data-price')) * parseInt($('#room_' + id_room_type).val()));
					total = total + item_total_price;
				} else {
					var id_package = className[i].getAttribute('data-item');
					item_total_price = (parseFloat(className[i].getAttribute('data-price')));
					total = total + item_total_price;
				}
			}
		}
		document.getElementById('total').innerHTML = '';
		document.getElementById('total').append(number_add_comma_decimal(total));
	}

	$(function() {

		$('#check_in_date').datepicker({
			format: 'dd-mm-yyyy',
			changeMonth: true,
			changeYear: true,
			startDate: new Date(), // = today
			onSelect: function(dateText, inst) {

				var in_date = $(this).val();
				check_in_date = in_date.split("-");

				//var d = new Date(check_in_date[2], parseInt(check_in_date[1])-1, check_in_date[0]);
				var today = new Date(check_in_date[2], parseInt(check_in_date[1]) - 1, check_in_date[0]);
				var tomorrow = new Date(today);
				tomorrow.setDate(today.getDate() + 1);
				tomorrow.toLocaleDateString();
				var tomorow_date = ('0' + tomorrow.getDate()).slice(-2) + '-' +
					('0' + (tomorrow.getMonth() + 1)).slice(-2) + '-' +
					tomorrow.getFullYear();
				$("#check_out_date").val(tomorow_date);
				//alert();
				$("date_in").text(tomorow_date);
				$('.cb').prop('checked', false);
				$('.cb').attr('disabled', false);
				$('.table tr').removeClass("cross_out");
				var total = 0;
				$('#total').text(number_add_comma_decimal(total));
				get_room_count_on_change_date();

			}
		}).val();

		$('#check_out_date').datepicker({
			format: 'dd-mm-yyyy',
			changeMonth: true,
			changeYear: true,
			startDate: new Date(), // = today
			onSelect: function(dateText, inst) {
				$('.cb').prop('checked', false);
				$('.cb').attr('disabled', false);
				$('.table tr').removeClass("cross_out");
				var total = 0;
				$('#total').text(number_add_comma_decimal(total));
				get_room_count_on_change_date();
			}
		}).val();

		$('#check_in_date').on('changeDate', function(e) {
	      var selectedDate = e.format('dd-mm-yyyy');
	      var tomorrow = new Date(e.date);
	      tomorrow.setDate(tomorrow.getDate() + 1);
	      $('#check_out_date').datepicker('setDate', tomorrow);	
		});

		var today = new Date();
		var tomorrow = new Date(today);
		tomorrow.setDate(today.getDate() + 1);
		tomorrow.toLocaleDateString();
		var today_date = ('0' + today.getDate()).slice(-2) + '-' +
			('0' + (today.getMonth() + 1)).slice(-2) + '-' +
			today.getFullYear();


		var tomorow_date = ('0' + tomorrow.getDate()).slice(-2) + '-' +
			('0' + (tomorrow.getMonth() + 1)).slice(-2) + '-' +
			tomorrow.getFullYear();
		if (!$("#check_in_date").val()) {
			$("#check_in_date").val(today_date);
		}
		if (!$("#check_out_date").val()) {
			$("#check_out_date").val(tomorow_date);
		}

		var dd1 = today_date.substring(0, 2);
		var mm1 = today_date.substring(3, 5);
		var yy1 = today_date.substring(6, 10);
		//alert(dd1+" "+mm1+" "+yy1);

		var st_mm = "";
		if (mm1 == '01') {
			st_mm = "ม.ค.";
		}
		if (mm1 == '02') {
			st_mm = "ก.พ.";
		}
		if (mm1 == '03') {
			st_mm = "มี.ค.";
		}
		if (mm1 == '04') {
			st_mm = "เม.ย.";
		}
		if (mm1 == '05') {
			st_mm = "พ.ค.";
		}
		if (mm1 == '06') {
			st_mm = "มิ.ย.";
		}
		if (mm1 == '07') {
			st_mm = "ก.ค.";
		}
		if (mm1 == '08') {
			st_mm = "ส.ค.";
		}
		if (mm1 == '09') {
			st_mm = "ก.ย.";
		}
		if (mm1 == '10') {
			st_mm = "ต.ค.";
		}
		if (mm1 == '11') {
			st_mm = "พ.ย.";
		}
		if (mm1 == '12') {
			st_mm = "ธ.ค.";
		}


		var dd2 = tomorow_date.substring(0, 2);
		var mm2 = tomorow_date.substring(3, 5);
		var yy2 = tomorow_date.substring(6, 10);
		var st_mm2 = "";
		if (mm2 == '01') {
			st_mm2 = "ม.ค.";
		}
		if (mm2 == '02') {
			st_mm2 = "ก.พ.";
		}
		if (mm2 == '03') {
			st_mm2 = "มี.ค.";
		}
		if (mm2 == '04') {
			st_mm2 = "เม.ย.";
		}
		if (mm2 == '05') {
			st_mm2 = "พ.ค.";
		}
		if (mm2 == '06') {
			st_mm2 = "มิ.ย.";
		}
		if (mm2 == '07') {
			st_mm2 = "ก.ค.";
		}
		if (mm2 == '08') {
			st_mm2 = "ส.ค.";
		}
		if (mm2 == '09') {
			st_mm2 = "ก.ย.";
		}
		if (mm2 == '10') {
			st_mm2 = "ต.ค.";
		}
		if (mm2 == '11') {
			st_mm2 = "พ.ย.";
		}
		if (mm2 == '12') {
			st_mm2 = "ธ.ค.";
		}


		$("#r_date_in").text(dd1 + " " + st_mm + " " + yy1);
		$("#r_date_out").text(dd2 + " " + st_mm2 + " " + yy2)





		//alert(tomorow_date);

		$('.select_age').click(function() {});

		$('.dropdown-menu').on('click', function(event) {
			// The event won't be propagated up to the document NODE and 
			// therefore delegated events won't be fired
			event.stopPropagation();
		});

		$('#book_now').click(function() {
			$('#h_num_of_adult').val($('#div_adult').text());
			$('#h_num_of_room').val($('#div_room').text());
			$('#h_num_of_children').val($('#div_children').text());
			var children_ages = [];
			var ages = document.getElementsByClassName("select_age");
			for (var i = 0; i < ages.length; i++) {
				//console.log(ages[i].value);
				children_ages.push(ages[i].value);
			}
			$('#h_children_ages').val(children_ages.toString());
			$('#h_check_in_date').val($('#check_in_date').val());
			$('#h_check_out_date').val($('#check_out_date').val());
			$('#frm_book').submit();
		});

		$('.delete-item').click(function() {
			var id = $(this).attr('data-id');
			delete_row(id);
		});

		$('.chk_item').click(function() {
			calc_total_price();
		});



		$('.select_all').click(function() {
			var total = 0;
			var className = document.getElementsByClassName('chk_item');
			for (var i = 0; i < className.length; i++) {
				if (className[i].checked) {
					total += parseFloat(className[i].getAttribute('data-price'));
				}
			}
			document.getElementById('total').innerHTML = '';
			document.getElementById('total').append(number_add_comma_decimal(total));
		})

		$('#proceed_to_booking').click(function() {

			if ($('#check_in_date').val() == '' || $('#check_out_date').val() == '') {
				alert('Select Date to Book.')
			} else {
				var className = document.getElementsByClassName('chk_item');

				var rooms = [];
				var rooms_to_check = [];
				var packages = [];
				var packages_to_check = [];

				for (var i = 0; i < className.length; i++) {
					var id_room = className[i].getAttribute('data-item');
					var item_type = className[i].getAttribute('data-item-type');

					if (className[i].checked == true) {
						var room_rate = className[i].getAttribute('data-price');
						var room_count = $('#room_' + id_room).val();
						if (item_type == 'room') {
							//console.log(id_room+':'+room_rate); 
							rooms.push(id_room + ':' + room_rate + ':' + room_count + ':' + item_type);
							rooms_to_check.push(id_room);
						} else if (item_type == 'package') {
							packages.push(id_room + ':' + room_rate + ':' + 1 + ':' + item_type);
							packages_to_check.push(id_room);
						}


					}
					/*var a = item_rates[i].innerHTML;
					a=a.replace(/\,/g,'');			
					prices += parseFloat(a);
					*/
				}
				//console.log(rooms_to_check);
				if (rooms.length == 0 && packages.length == 0) {
					alert('Select a room to book.')
				} else {
					var proceed_to_booking = 0;
					//if (item_type == 'room') {
					console.log(rooms_to_check.toString());
					var _url = "<?php echo site_url('room_details/room_available'); ?>";
					$.ajax({
							method: "POST",
							url: _url,
							data: {
								'rooms': rooms_to_check.toString(),
								'check_in_date': $('#check_in_date').val(),
								'check_out_date': $('#check_out_date').val()
							}
						})
						.done(function(res) {
							var obj = eval('(' + res + ')');
							console.log(obj);
							for (var i = 0; i < obj.length; i++) {
								console.log(obj[i]);
								$('#tr_room_' + obj[i]).addClass('red_color');
								$('.cb').prop('checked', false);
								$('#id_room_' + obj[i]).attr('disabled', 'disabled');
							}

							if (obj.length > 0 && obj[0] != '') {
								alert("<?php echo $this->lang->line('room_not_available'); ?>")
							} else {
								$('#h_id_package').val(packages.toString());
								$('#h_id_room').val(rooms.toString());
								$('#h_num_of_adult').val($('#div_adult').text());
								$('#h_num_of_room').val($('#div_room').text());
								$('#h_num_of_children').val($('#div_children').text());

								var children_ages = [];
								var ages = document.getElementsByClassName("select_age");
								for (var i = 0; i < ages.length; i++) {
									children_ages.push(ages[i].value);
								}
								$('#h_children_ages').val(children_ages.toString());
								$('#h_check_in_date').val($('#check_in_date').val());
								$('#h_check_out_date').val($('#check_out_date').val());
								$('#frm_book').submit();
							}
						});
					//}
					//else {

					//}

				}
			}
		});

		var total = 0;
		var className = document.getElementsByClassName('chk_item');
		for (var i = 0; i < className.length; i++) {
			if (className[i].checked) {
				total += parseFloat(className[i].getAttribute('data-price'));
			}
		}
		document.getElementById('total').innerHTML = '';
		document.getElementById('total').append(number_add_comma_decimal(total));
	});
	sessionStorage.clear();
</script>

<button type="button" onclick="topFunction()" class="return-to-top btn-returntop" id="returnTopBtn" title="Go to top" style="float: right; background-color: #102958 !important; color: #FFF !important; border: #102958; margin: -16px 2px; ">↑</button>

<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  var mybutton = document.getElementById("returnTopBtn");
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>