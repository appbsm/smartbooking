<?php 
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI =& get_instance();
$CI->load->model('m_room_type');

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap.min.css">

<style>
	.nav-link.active {
		background-color: #81BB4A!important;
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

	tr > td {
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
	.sidenav a, .dropdown-btn {
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
	.sidenav a:hover, .dropdown-btn:hover {
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
	  .sidenav {padding-top: 15px;}
	  .sidenav a {font-size: 16px;}
	}
	.button__badge {
		margin-right: 0px;
		font-size: 0.6em !important;
		position: absolute;
		top: -8px !important;
		right: -4px !important;
	}
	.menu-bar {
		width: 100%;
		max-width: 100%;
		display: flex;
		justify-content: space-around;
		font-weight: 400;
	}
	
	.price {
		/*background-color: #2a2a2e;*/
		background-color: #5392f9;
		color: white;
		text-shadow: 2px 2px 4px #000000;
	}
	.border-r-10 {
		/*border: 1px solid #81BB4A;*/
		border: 1px solid #5392f9;
		border-radius: 10px;
	}
	.form-control:disabled, .form-control[readonly], .form-control {
		height: 32px;
	}
	.btn-save {
		width: auto;
		height: auto;
		text-transform: uppercase;
		/*line-height: 30px !important;*/
		color: #fff !important;
		font-size: 14px !important;
		background-color: #5392f9 !important;
		border-color: #5392f9 !important;
		padding: 6px 12px;
	}
	.btn-save:hover {
        background-color: #fff !important;
        color: #5392f9 !important; 
		border-color: #5392f9 !important;
    }
</style>

<?php 

?>


<div class="main-2">
	<div class="container" >
  		<div class="row" id="profile">
  			<div class="col-md-12 price room_type_header"><span style="margin-left: 10px;"><?php echo $this->lang->line('profile');?></span></div>
  		</div>
		<div class="row">
			<div class="col-md-2">
				<div class="sidenav">
					<a style="font-weight: 600;" href="<?php echo site_url('booking/history');?>" class="dropdown-btn"><?php echo _r('Booking History', 'ประวัติการจอง');?>
					</a>
					<div class="dropdown-container">
						<a href="#"><?php echo _r('Booking History', 'ประวัติการจอง');?></a>
					</div>
					<a style="font-weight: 600;" href="<?php echo site_url('profile/edit_profile_code');?>" class="dropdown-btn"><?php echo _r('Discount Code', 'โค้ดส่วนลด');?>
					</a>
					<a style="font-weight: 600;"><?php echo _r('Security', 'ความปลอดภัย');?>
						<i class="fa fa-caret-down"></i>
					</a>
					<div>
						<a href="#" style="color:#81BB4A;margin-left:10px;"><?php echo _r('Password', 'รหัสผ่าน');?></a>
					</div>
					<a style="font-weight: 600;" href="<?php echo site_url('profile/edit_profile');?>" class="dropdown-btn"><?php echo $this->lang->line('profile');?>
						
					</a>
				</div>
			</div>
			<div class="col-md-10">



				<form name="frm_update" id="frm_update" method="post" action="<?php echo site_url('profile').'/update_password';?>">
					<div class="row border-r-10 mt-4">
    					<input type="hidden" name="id_guest_p" id="id_guest_p" value="<?php echo $guest_info->id_guest;?>">   
						<div class="col collapse multi-collapse-security show" id="collapse-security1">
							<div class="row" style="height:200px;">
								<div class="col-2"></div>
								<div class="col-8 mt-4">
												
					                  <div class="form-outline">
					                  	<label class="form-label mb-0" for="username" style="font-weight: 500;"><?php echo $this->lang->line('username');?></label>
					                    <input disabled type="text" id="username" name="username" class="form-control" value="<?php echo $guest_info->username;?>"  />					                    
					                  </div>					
					                
					               				
					                  <div class="form-outline">
					                  	<label class="form-label mb-0 mt-3" for="password" style="font-weight: 500;"><?php echo $this->lang->line('password');?></label>
					                    <input disabled type="password" id="password" name="password" class="form-control" value="<?php echo $guest_info->password;?>" />					                    
					                  </div>					
					                
								</div>
								<div class="col-2 mt-4">
									<a data-toggle="collapse" data-target=".multi-collapse-security" aria-expanded="false" aria-controls="collapse-security1 collapse-security2">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="22" height="22" viewBox="0 0 256 256" xml:space="preserve">

											<defs>
											</defs>
											<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
												<circle cx="45" cy="45" r="45" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(32,143,232); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
												<path d="M 69.913 67.417 l -5.059 -16.592 c -0.007 -0.022 -0.021 -0.041 -0.028 -0.063 c -0.035 -0.102 -0.08 -0.201 -0.132 -0.297 c -0.02 -0.038 -0.037 -0.077 -0.06 -0.114 c -0.079 -0.126 -0.169 -0.247 -0.279 -0.357 L 37.047 22.685 c -3.574 -3.574 -9.39 -3.574 -12.964 0 l -1.398 1.398 c -3.574 3.574 -3.574 9.39 0 12.964 l 27.309 27.309 c 0.11 0.11 0.231 0.2 0.357 0.279 c 0.037 0.023 0.076 0.039 0.114 0.06 c 0.097 0.052 0.195 0.097 0.297 0.132 c 0.022 0.008 0.041 0.021 0.063 0.028 l 16.592 5.059 C 67.608 69.972 67.805 70 68 70 c 0.522 0 1.033 -0.205 1.414 -0.586 C 69.937 68.892 70.129 68.124 69.913 67.417 z M 25.513 26.911 l 1.398 -1.398 c 2.016 -2.015 5.293 -2.014 7.308 0 l 25.895 25.895 l -8.705 8.705 L 25.513 34.219 C 23.499 32.204 23.499 28.926 25.513 26.911 z M 55.178 62 L 62 55.178 l 2.992 9.814 L 55.178 62 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
											</g>
										</svg>
										<?php echo $this->lang->line('edit'); ?>
									</a>
								</div>
							</div>
						</div>
						<div class="col collapse multi-collapse-security" id="collapse-security2">
							<div class="row" style="height:250px;">
							<div class="col-2"></div>
							<div class="col-8">
								<br><br>
								<div class="row">
									<!--<div class="col-md-2 mb-4">
									</div>-->
									<!--<div class="col-md-8">-->
										<div class="form-outline">
											<label class="form-label mb-0" for="username" style="font-weight: 500;"><?php echo $this->lang->line('username');?></label>
											<input type="text" id="username" name="username" class="form-control" value="<?php echo $guest_info->username;?>"  />					                    
										  </div>					
										
													
										  <div class="form-outline">
											<label class="form-label mb-0 mt-3" for="password" style="font-weight: 500;"><?php echo $this->lang->line('password');?></label>
											<input type="password" id="password" name="password" class="form-control" value="<?php echo $guest_info->password;?>" />					                    
										  </div>
									<!--</div>
									<div class="col-md-2 mb-2 mt-4">


									</div>-->
								</div>
							</div>
							<div class="col-2 mt-4 text-center">
								<div class="row">
									<div class="col-12">
										<a data-toggle="collapse" data-target=".multi-collapse-security" aria-expanded="false" aria-controls="collapse-security1 collapse-security2">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="22" height="22" viewBox="0 0 256 256" xml:space="preserve">

												<defs>
												</defs>
												<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
													<path d="M 45 90 C 20.187 90 0 69.813 0 45 C 0 20.187 20.187 0 45 0 c 24.813 0 45 20.187 45 45 C 90 69.813 69.813 90 45 90 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(236,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
													<path d="M 28.902 66.098 c -1.28 0 -2.559 -0.488 -3.536 -1.465 c -1.953 -1.952 -1.953 -5.118 0 -7.07 l 32.196 -32.196 c 1.951 -1.952 5.119 -1.952 7.07 0 c 1.953 1.953 1.953 5.119 0 7.071 L 32.438 64.633 C 31.461 65.609 30.182 66.098 28.902 66.098 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
													<path d="M 61.098 66.098 c -1.279 0 -2.56 -0.488 -3.535 -1.465 L 25.367 32.438 c -1.953 -1.953 -1.953 -5.119 0 -7.071 c 1.953 -1.952 5.118 -1.952 7.071 0 l 32.195 32.196 c 1.953 1.952 1.953 5.118 0 7.07 C 63.657 65.609 62.377 66.098 61.098 66.098 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
												</g>
											</svg>
											<?php echo _r('Cancel', 'ยกเลิก'); ?>
										</a>
									</div>
								</div>
								<div class="row mt-0">
									<div class="col-12"> 
										<br><br><br><br>
										<button class="btn btn-save" type="submit" data-toggle="collapse" data-target=".multi-collapse-security" aria-expanded="false" aria-controls="collapse-security1 collapse-security2" id="update"><?php echo _r('Save', 'บันทึก'); ?></button>
									</div>
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






<!-- 

<main class="main-2">

  <div class="container-fluid" >
  	<div class="row">
  		<div class="col-md-12 price room_type_header"><span style="margin-left: 10px;"><?php echo $this->lang->line('profile');?></span></div>
  	</div>
  	<div class="row"> 
    	<div class="col-md-6 mt-3 mb-3">
    	<form name="frm_save" id="frm_save" method="post" action="<?php echo site_url('profile').'/update_profile';?>" enctype="multipart/form-data">
    	<input type="hidden" name="id_guest" id="id_guest" value="<?php echo $guest_info->id_guest;?>">    							
    							<div class="row">
					                <div class="col-md-12 mb-2">
					
					                  <div class="form-outline">
					                  	<label class="form-label" for="firstname"><span class="required">*</span><?php echo $this->lang->line('firstname');?></label>
					                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $guest_info->firstname;?>" required />					                    
					                  </div>
					
					                </div>
					                <div class="col-md-12 mb-2">
					
					                  <div class="form-outline">
					                  	<label class="form-label" for="lastname"><span class="required">*</span><?php echo $this->lang->line('lastname');?></label>
					                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $guest_info->lastname;?>" required />					                    
					                  </div>
					
					                </div>
					           </div>
					              
					           <div class="row">
					              <div class="col-md-12 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="contact_number"><span class="required">*</span><?php echo $this->lang->line('contact_number');?></label>
					                    
					                    <input type="tel" id="contact_number" name="contact_number" class="form-control" value="<?php echo $guest_info->contact_number;?>" required />					                    
					                  </div>					
					                </div>
					                
					                <div class="col-md-12 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="email"><span class="required">*</span><?php echo $this->lang->line('email');?></label>
					                    <input type="email" id="email" name="email" class="form-control" value="<?php echo $guest_info->email;?>" required />					                    
					                  </div>					
					                </div>
    						</div>  
    						
    						<div class="row">
    							
					        	<div class="col-md-12 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="tax_id"><span class="required">*</span><?php echo $this->lang->line('tax_id');?></label>
					                    <input type="text" id="tax_id" name="tax_id" class="form-control" value="<?php echo $guest_info->tax_id;?>" required />					                    
					                  </div>					
					                </div>
					                
					            <div class="col-md-12 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="address"><?php echo $this->lang->line('address');?></label>
					                    <textarea id="address" name="address" class="form-control"><?php echo $guest_info->address;?></textarea>					                    				                    
					                  </div>					
					            </div>
    						</div>
    						
    						<div class="row">
    							
					        	<div class="col-md-12">
						  			<div class="form-outline">
						                <label class="form-label" for="guest_photo"><?php echo $this->lang->line('upload_photo');?></label>
						                <img src="<?php echo share_folder_path() . $guest_info->photo_url; ?>" style="max-height: 100px">
						            	<input type="file" id="guest_photo" name="guest_photo" class="form-control" />					                    
						            </div>
					            </div>
    						</div>
    						
    							
    						
    						<div class="row mt-4 mb-4"> 
    							<div class="col-md-12 d-flex justify-content-center">
				    				
				    				<button class="btn button-primary" id="save"><?php echo $this->lang->line('save');?></button>&nbsp;&nbsp;
				    				<button class="btn button-default" id="cancel"><?php echo $this->lang->line('cancel');?></button>
				    			</div>
    						</div>
    </form>
    </div>

  	<div class="col-md-6 mt-3 mb-3">
  		<div class="row">
  			<div class="col-md-12">
  				<form name="frm_update" id="frm_update" method="post" action="<?php echo site_url('profile').'/update_password';?>">
    				<input type="hidden" name="id_guest_p" id="id_guest_p" value="<?php echo $guest_info->id_guest;?>">   
    				<div class="row">
					                <div class="col-md-6 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="username"><?php echo $this->lang->line('username');?></label>
					                    <input type="text" id="username" name="username" class="form-control" value="<?php echo $guest_info->username;?>"  />					                    
					                  </div>					
					                </div>
					                <div class="col-md-6 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="password"><?php echo $this->lang->line('password');?></label>
					                    <input type="password" id="password" name="password" class="form-control" value="<?php echo $guest_info->password;?>" />					                    
					                  </div>					
					                </div>
					        </div>
					        
					        
					        
					        <div class="row mt-4 mb-4"> 
    							<div class="col-md-12 d-flex justify-content-center">
				    				
				    				<button class="btn button-primary" id="update"><?php echo $this->lang->line('update');?></button>&nbsp;&nbsp;
				    				<button class="btn button-default" id="cancel_1"><?php echo $this->lang->line('cancel');?></button>
				    			</div>
    						</div>
   	 		</form>
  		</div>
  		
  		<div class="col-md-12 font-weight-bold"><?php echo $this->lang->line('user_discount');?></div>
  		<div class="col-md-12">
  			<table class="table-bordered w-100" style="padding: 5px;">
  				<?php if (isset($discount->code)) {
  				$booking_expired = (strtotime(date('Y-m-d')) > strtotime($discount->end_date_booking)) ? 'booking_expired' : '';
  				?>
  				<tr>
  					<td><?php echo $this->lang->line('discount_code');?></td>
  					<td><?php echo $discount->code;?></td>
  				</tr>
  				<tr>
  					<td><?php echo $this->lang->line('discount_type');?></td>
  					<td><?php echo $discount->discount_type;?></td>
  				</tr>
  				<tr>
  					<td><?php echo $this->lang->line('discount_value');?></td>
  					<td><?php echo $discount->discount_value;?></td>
  				</tr>
  				<tr>
  					<td><?php echo $this->lang->line('booking_start_date');?></td>
  					<td><?php echo date('d-m-Y', strtotime($discount->start_date_booking));?></td>
  				</tr>
  				<tr>
  					<td><?php echo $this->lang->line('booking_end_date');?></td>
  					<td class="<?php echo $booking_expired;?>"><?php echo date('d-m-Y', strtotime($discount->end_date_booking));?> <?php echo ($booking_expired != '') ? '(Expired)' : '';?></td>
  				</tr>
  				<tr>
  					<td><?php echo $this->lang->line('check_in_start_date');?></td>
  					<td><?php echo date('d-m-Y', strtotime($discount->start_date_check_in));?></td>
  				</tr>
  				<tr>
  					<td><?php echo $this->lang->line('check_in_end_date');?></td>
  					<td><?php echo date('d-m-Y', strtotime($discount->end_date_check_in));?></td>
  				</tr>
  				<?php }
  				else {
  				?>
  				<tr>
  					<td><?php echo $this->lang->line('no_user_discount');?></td>
  					
  				</tr>
  				<?php }?>
  			</table>
  		</div>
  		</div>
    </div>
  
  
  </div>
  
  
</div>
</main>

 -->



<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script src=
"https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js">
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









function ValidateEmail(mail) 
{  
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
  {
    return (true)
  }
  else {
  	alert("You have entered an invalid email address!")
  	return (false)
  }
}

$("#contact_number").inputmask({"mask": "9{3}-9{3}-9{4}"}); 
$('#contact_number').on('focusout', function() {
	var pattern1 = new RegExp("^([0-9]{3})[-]([0-9]{3})[-]([0-9]{4})$");
	var value = $(this).val();
	if (pattern1.test(value) || value == '') {
		$('#save').attr('disabled', false);
	}
	else {
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
			}
			else {
				var _url = "<?php echo site_url('profile/check_email_exist');?>";
				$.ajax({
		               method: "POST",
		               url: _url,
		               data: {
		                   'email': $(this).val()             
		               }
		       })
		       .done(function( res ) {
		    	   if (res > 0) {
			    	   alert('Email already exists.')
		    		   $('#email').val('');
			       } 	    	   
		       });
			}
		}
	});
</script>

