<?php
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI = &get_instance();
$CI->load->model('m_room_type');

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

	tr>td {
		line-height: 20px;
		padding: 5px;
	}

	.booking_expired {
		background-color: red;
		color: white;
	}


	/* Fixed sidenav, full height */
	.sidenav {
		/* height: 100%; */
		/* width: 200px; */
		/* position: fixed; */
		/* z-index: 1; */
		/* top: 0; */
		/* left: 0; */
		/* background-color: #111; */
		overflow-x: hidden;
		padding-top: 20px;
	}

	/* Style the sidenav links and the dropdown button */
	.sidenav a,
	.dropdown-btn {
		padding: 6px 8px 6px 16px;
		text-decoration: none;
		font-size: 16px;
		color: #818181;
		display: block;
		border: none;
		background: none;
		/* width: 100%; */
		text-align: left;
		cursor: pointer;
		outline: none;
	}

	/* On mouse-over */
	.sidenav a:hover,
	.dropdown-btn:hover {
		color: #000000;
	}


	/* Add an active class to the active dropdown button */
	.active {
		/* background-color: green; */
		color: #81BB4A;
	}

	/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
	.dropdown-container {
		display: none;
		/* background-color: #262626; */
		padding-left: 8px;
	}

	/* Optional: Style the caret down icon */
	.fa-caret-down {
		float: right;
		padding-right: 8px;
	}

	/* Some media queries for responsiveness */
	@media screen and (max-height: 450px) {
		.sidenav {
			padding-top: 15px;
		}

		.sidenav a {
			font-size: 18px;
		}
	}
</style>

<?php

?>


<div class="main-2">
	<div class="container">
		<div class="row" id="profile">
			<div class="col-md-12 price room_type_header"><span style="margin-left: 10px;"><?php echo $this->lang->line('profile'); ?></span></div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<div class="sidenav">
					<a href="<?php echo site_url('booking/history'); ?>" class="dropdown-btn"><?php echo _r('Booking History', 'ประวัติการจอง'); ?>
					</a>
					<div class="dropdown-container">
						<a href="#"><?php echo _r('Booking History', 'ประวัติการจอง'); ?></a>
					</div>
					<a href="<?php echo site_url('profile/edit_profile_code'); ?>" class="dropdown-btn"><?php echo _r('Discount Code', 'โค้ดส่วนลด'); ?>
					</a>
					<a href="<?php echo site_url('profile/edit_profile_security'); ?>" class="dropdown-btn"><?php echo _r('Security', 'ความปลอดภัย'); ?>
					</a>

					<a><?php echo _r('Personal information', 'ข้อมูลส่วนตัว'); ?>
						<i class="fa fa-caret-down"></i>
					</a>
					<div>
						<a href="#profile" style="color:#81BB4A;margin-left:10px;"><?php echo _r('Username', 'ชื่อผู้ใช้งาน'); ?></a>
						<a href="#collapse-name1" style="color:#81BB4A;margin-left:10px;"><?php echo _r('Email', 'อีเมลล์'); ?></a>
						<a href="#collapse-email1" style="color:#81BB4A;margin-left:10px;"><?php echo _r('Phone Number', 'เบอร์โทรติดต่อ'); ?></a>
						<a href="#collapse-phone1" style="color:#81BB4A;margin-left:10px;"><?php echo _r('Address', 'ที่อยู่'); ?></a>
						<a href="#collapse-credit-term" style="color:#81BB4A;margin-left:10px;"><?php echo _r('Credit Term', 'เครดิต'); ?></a>
					</div>
				</div>
			</div>
			<div class="col-md-10">
				<form name="frm_save1" id="frm_save1" method="post" action="<?php echo site_url('profile') . '/update_profile'; ?>" enctype="multipart/form-data">
					<input type="hidden" name="id_guest" id="id_guest" value="<?php echo $guest_info->id_guest; ?>">
					<div class="row border-r-10 mt-5">
						<div class="col-12 collapse multi-collapse show" id="collapse-name1">
							<div class="row" style="height:200px;">
								<div class="col-2"></div>
								<div class="col-8 mt-5">
									<div class="row">
										<div class="col-4 mt-5 text-right">
											<?php
											if ($guest_info->photo_url != '') { ?>
												<img src="<?php echo share_folder_path() . $guest_info->photo_url; ?>" class="rounded-circle mx-auto d-block" style="height:50px;width:50px;" alt="">
											<?php } ?>
										</div>

										<div class="col-8 mt-5 self-align-center">

											<h5><?php echo $guest_info->firstname; ?> <?php echo $guest_info->lastname; ?></h5>
										</div>
									</div>
								</div>
								<div class="col-2 mt-4"><a data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapse-name1 collapse-name2"><?php echo $this->lang->line('edit'); ?></a></div>
							</div>
						</div>


						<?php /*
						<div class="col-12 collapse multi-collapse show" id="collapse-name1">
							<div class="row" style="height:200px;">
								<!--<div class="col-12 mt-4 text-right"><a data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapse-name1 collapse-name2"><?php echo $this->lang->line('edit');?></a></div>-->
								<div class="col-4 mt-5 text-right">
								<?php 								
								if ($guest_info->photo_url != '') { ?>
								<img src="<?php echo share_folder_path() . $guest_info->photo_url; ?>"  class="rounded-circle mx-auto d-block" style="height:50px;width:50px;" alt="">
								<?php } ?>
								</div>
								
								<div class="col-8 mt-5 self-align-center">
									<br>
									<h5><?php echo $guest_info->firstname; ?> <?php echo $guest_info->lastname; ?></h5>
								</div>
								<div class="col-2 mt-4"><a data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapse-name1 collapse-name2"><?php echo $this->lang->line('edit');?></a></div>
							</div>
						</div>
						*/ ?>

						<div class="col collapse multi-collapse" id="collapse-name2">
							<div class="row" style="height:300px;">
								<div class="col-2"></div>
								<div class="col-8 ">
									<br><br>
									<div class="row">
										<div class="col-4">
											<?php
											if ($guest_info->photo_url != '') { ?>
												<img src="<?php echo share_folder_path() . $guest_info->photo_url; ?>" class="rounded-circle mx-auto d-block" style="height:50px;width:50px;">
											<?php } ?>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-outline">
												<label class="form-label" for="guest_photo"><?php echo $this->lang->line('upload_photo'); ?></label>

												<input type="file" id="guest_photo" name="guest_photo" class="form-control" />
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-outline">
												<label class="form-label" for="firstname"><span class="required">*</span><?php echo $this->lang->line('firstname'); ?></label>
												<input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $guest_info->firstname; ?>" required />
											</div>

										</div>
										<div class="col-sm-3">

											<div class="form-outline">
												<label class="form-label" for="lastname"><span class="required">*</span><?php echo $this->lang->line('lastname'); ?></label>
												<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $guest_info->lastname; ?>" required />
											</div>

										</div>
										<div class="col-sm-2 mt-2 text-center">
											<button class="btn btn-save" type="submit" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapse-name1 collapse-name2" id="save"><?php echo _r('Save', 'บันทึก'); ?></button>
										</div>
									</div>
								</div>
								<div class="col-2 mt-4 pl-0"><a data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="collapse-name1 collapse-name2"><?php echo _r('Cancel', 'ยกเลิก'); ?></a></a></div>
							</div>
						</div>
					</div>

					<div class="row border-r-10 mt-5">
						<div class="col collapse multi-collapse-email show" id="collapse-email1">
							<div class="row" style="height:200px;">
								<div class="col-2"></div>
								<div class="col-8 mt-5">
									<div class="form-outline">
										<label class="form-label" for="email"><span class="required">*</span><?php echo $this->lang->line('email'); ?></label>
										<input type="email" id="email" name="email" class="form-control" value="<?php echo $guest_info->email; ?>" required disabled />
									</div>
								</div>
								<div class="col-2 mt-4"><a data-toggle="collapse" data-target=".multi-collapse-email" aria-expanded="false" aria-controls="collapse-email1 collapse-email2"><?php echo $this->lang->line('edit'); ?></a></div>
							</div>
						</div>
						<div class="col collapse multi-collapse-email" id="collapse-email2">
							<div class="row" style="height:250px;">
								<div class="col-2"></div>
								<div class="col-8 mt-5">
									<div class="row">
										<div class="col-md-2 mb-4">
										</div>
										<div class="col-md-8">
											<div class="form-outline">
												<label class="form-label" for="email"><span class="required">*</span><?php echo $this->lang->line('email'); ?></label>
												<input type="email" id="email" name="email" class="form-control" value="<?php echo $guest_info->email; ?>" required />
											</div>
										</div>
										<div class="col-sm-1 mt-2 text-center">
											<button class="btn btn-save" type="submit" data-toggle="collapse" data-target=".multi-collapse-email" aria-expanded="false" aria-controls="collapse-email1 collapse-email2" id="save"><?php echo _r('Save', 'บันทึก'); ?></button>
										</div>
									</div>
								</div>
								<div class="col-2 mt-4 pl-0"><a data-toggle="collapse" data-target=".multi-collapse-email" aria-expanded="false" aria-controls="collapse-email1 collapse-email2"><?php echo _r('Cancel', 'ยกเลิก'); ?></a></div>
							</div>
						</div>

					</div>

					<div class="row border-r-10 mt-5">
						<div class="col collapse multi-collapse-phone show" id="collapse-phone1">
							<div class="row" style="height:200px;">
								<div class="col-2"></div>
								<div class="col-8 mt-5">
									<div class="form-outline">
										<label class="form-label" for="contact_number"><span class="required">*</span><?php echo $this->lang->line('contact_number'); ?></label>
										<input type="tel" id="contact_number" name="contact_number" class="form-control" value="<?php echo $guest_info->contact_number; ?>" disabled />
									</div>
								</div>
								<div class="col-2 mt-4"><a data-toggle="collapse" data-target=".multi-collapse-phone" aria-expanded="false" aria-controls="collapse-phone1 collapse-phone2"><?php echo $this->lang->line('edit'); ?></a></div>
							</div>
						</div>

						<div class="col collapse multi-collapse-phone" id="collapse-phone" 2>
							<div class="row" style="height:250px;">
								<div class="col-2 mt-4"></div>
								<div class="col-8 mt-4">
									<br><br>
									<div class="row">
										<div class="col-md-2 mb-4">
										</div>
										<div class="col-md-8">
											<div class="form-outline">
												<label class="form-label" for="contact_number"><span class="required">*</span><?php echo $this->lang->line('contact_number'); ?></label>
												<input type="tel" id="contact_number" name="contact_number" class="form-control" value="<?php echo $guest_info->contact_number; ?>" />
											</div>
										</div>
										<div class="col-md-2 mb-2 mt-2 text-center">
											<button class="btn btn-save" type="submit" data-toggle="collapse" data-target=".multi-collapse-phone" aria-expanded="false" aria-controls="collapse-phone1 collapse-phone2" id="save"><?php echo _r('Save', 'บันทึก'); ?></button>
										</div>
									</div>
								</div>

								<div class="col-2 mt-4 pl-0"><a data-toggle="collapse" data-target=".multi-collapse-phone" aria-expanded="false" aria-controls="collapse-phone1 collapse-phone2"><?php echo _r('Cancel', 'ยกเลิก'); ?></a></div>
							</div>
						</div>


					</div>
					<div class="row border-r-10 mt-5">
						<div class="col collapse multi-collapse-address show" id="collapse-address">
							<div class="row" style="height:200px;">
								<div class="col-2"></div>
								<div class="col-8 mt-5">
									<div class="form-outline">
										<label class="form-label" for="address"><?php echo $this->lang->line('address'); ?></label>
										<input type="text" id="address" name="address" class="form-control" value="<?php echo $guest_info->address; ?>" disabled></input>
									</div>
								</div>
								<div class="col-2 mt-4"><a data-toggle="collapse" data-target=".multi-collapse-address" aria-expanded="false" aria-controls="collapse-address1 collapse-address2"><?php echo $this->lang->line('edit'); ?></a></div>
							</div>
						</div>
						<div class="col collapse multi-collapse-address" id="collapse-address">
							<div class="row" style="height:250px;">
								<div class="col-2 mt-4"></div>
								<div class="col-8 mt-4">
									<br><br>
									<div class="row">
										<div class="col-md-2 mb-4">
										</div>
										<div class="col-md-8">
											<div class="form-outline">
												<label class="form-label" for="address"><?php echo $this->lang->line('address'); ?></label>
												<input type="text" id="address" name="address" class="form-control" value="<?php echo $guest_info->address; ?>"></input>
											</div>
										</div>
										<div class="col-md-2 mb-2 mt-2 text-center">
											<button class="btn btn-save" type="submit" data-toggle="collapse" data-target=".multi-collapse-address" aria-expanded="false" aria-controls="collapse-address1 collapse-address2" id="save"><?php echo _r('Save', 'บันทึก'); ?></button>
										</div>
									</div>
								</div>
								<div class="col-2 mt-4 pl-0"><a data-toggle="collapse" data-target=".multi-collapse-address" aria-expanded="false" aria-controls="collapse-address1 collapse-address2"><?php echo _r('Cancel', 'ยกเลิก'); ?></a></div>
							</div>
						</div>
					</div>
					<div class="row border-r-10 mt-5">
						<div class="col collapse multi-collapse-credit_term show" id="collapse-credit_term">
							<div class="row" style="height:200px;">
								<div class="col-2"></div>
								<div class="col-8 mt-5">
									<div class="form-outline">
										<label class="form-label" for="credit_term"><?php echo $this->lang->line('credit_term'); ?></label>
										<input type="text" id="credit_term" name="credit_term" class="form-control" value="<?php echo $guest_info->credit_term." ".$this->lang->line('days'); ?>" disabled></input>
									</div>
								</div>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>




<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo site_url(); ?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url(); ?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js">
</script>


<script>
	/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
	var dropdown = document.getElementsByClassName("dropdown-btn");
	var i;

	for (i = 0; i < dropdown.length; i++) {
		dropdown[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var dropdownContent = this.nextElementSibling;
			if (dropdownContent.style.display === "block") {
				dropdownContent.style.display = "none";
			} else {
				dropdownContent.style.display = "block";
			}
		});
	}









	function ValidateEmail(mail) {
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
			return (true)
		} else {
			alert("You have entered an invalid email address!")
			return (false)
		}
	}

	$("#contact_number").inputmask({
		"mask": "9{3}-9{3}-9{4}"
	});
	$('#contact_number').on('focusout', function() {
		var pattern1 = new RegExp("^([0-9]{3})[-]([0-9]{3})[-]([0-9]{4})$");
		var value = $(this).val();
		if (pattern1.test(value) || value == '') {
			$('#save').attr('disabled', false);
		} else {
			$('#contact_number').focus();
			$('#save').attr('disabled', true);
		}
	});

	//$("#contact_number").inputmask({"9{1,5}-9{1,5}"}); 

	//$("#contact_number").inputmask('*{8,40}', { clearIncomplete: true, greedy: false });

	$('#email').on('focusout', function() {
		if ($(this).val() != '') {
			var check = ValidateEmail($(this).val());
			if (!check) {
				$(this).focus();
				$(this).val('');
			} else {
				var _url = "<?php echo site_url('profile/check_email_exist'); ?>";
				$.ajax({
						method: "POST",
						url: _url,
						data: {
							'email': $(this).val()
						}
					})
					.done(function(res) {
						if (res > 0) {
							alert('Email already exists.')
							$('#email').val('');
						}
					});
			}
		}
	});
</script>