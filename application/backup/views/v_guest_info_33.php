<?php 
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI =& get_instance();
$CI->load->model('m_room_type');
$CI->load->model('m_guest');
$CI->load->model('m_discount');
$id_guest = $this->session->userdata('id_guest');	
$guest_details = $CI->m_guest->get_profile_by_guestID($id_guest);

if (isset($check_in_date)) {
	$check_in = date_reformat($check_in_date, 'day_to_year_dash');
	$check_out = date_reformat($check_out_date, 'day_to_year_dash');
	$discount = new stdClass();
	//echo $guest_details->id_discount;
	if (isset($guest_details->id_discount)) {
		
	$discount = $CI->m_discount->get_discount($guest_details->id_discount, date('Y-m-d'), $check_in, $check_out);
	}
}

else {
	 //redirect($_SERVER['HTTP_REFERER']);
}
$count_room_max_adult = 0;
$max_children_age = 0;
$list_of_rooms = array();
//print_r($discount);
?>

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

	.container_progress_bar {
	padding-top: 3em;
	width: 100%;
	}

	.progressbar {
	counter-reset: step;
	}
	.progressbar li {
	list-style: none;
	display: inline-block;
	width: 24%;
	position: relative;
	text-align: center;
	cursor: pointer;
	}
	.progressbar li:before {
	content: counter(step);
	counter-increment: step;
	width: 30px;
	height: 30px;
	line-height : 30px;
	border: 1px solid #ddd;
	border-radius: 100%;
	display: block;
	text-align: center;
	margin: 0 auto 10px auto;
	background-color: #fff;
	}
	.progressbar li:after {
	content: "";
	position: absolute;
	width: 100%;
	height: 1px;
	background-color: #ddd;
	
	top: 15px;
	left: -50%;
	z-index : -1;
	}
	.progressbar li:first-child:after {
	content: none;
	}
	.progressbar li.active {
	color: green;
	}

	/* this is for the circle*/
	.progressbar li.active:before { 
	border-color: green;
	background-color: green;
	color: #fff;
	} 
	.progressbar li.active + li:after {
	background-color: green;
	}

</style>


<main class="main-2">
	<div class="row">
  		<div class="col-md-12">
  			<ul class="breadcrumb">
			  <li><a href="<?php echo site_url();?>"><?php echo $this->lang->line('home');?></a></li>
			  <li><?php echo $this->lang->line('booking');?></li>
			</ul>
  		</div>
  	</div>
  
	<div class="container_progress_bar">
      <ul class="progressbar">
        <li class="active"><?php echo $this->lang->line('guest_info');?></li>
        <li class=""><?php echo $this->lang->line('billing');?></li>
        <li class=""><?php echo $this->lang->line('payment');?></li>
        <li class=""><?php echo $this->lang->line('confirmation');?></li>
      </ul>
    </div>

  	
  <div class="container-fluid" >
  	<div class="row">
  		<div class="col-md-12 price room_type_header"><span style="margin-left: 10px;"><?php echo $this->lang->line('step_1');?></span></div>
  	</div>
  	<div class="row"> 
    	<div class="col-md-12 mt-3 mb-3">
			<div class="row">
				<!-- <div class="col-md-3 mb-2 mt-2 font-weight-bold"><?php echo sizeof($rooms);?> Room(s), <span id="sum_of_nights"><?php echo $num_of_nights;?></span> <?php echo $this->lang->line('night');?> </div>
				<div class="col-md-3 mb-2 mt-2 font-weight-bold">Booked for <?php echo $number_of_adult;?> Adults, <?php echo $number_of_children;?> <?php echo $this->lang->line('children');?> (<?php echo $this->lang->line('ages');?>: <?php print_r($children_ages);?>)</div>
				-->
				<div class="col-md-12"><span id="room_message" style="color: red; font-style: italic;"></span></div> 					
			</div>
    	</div>

    	<div class="col-md-7">

    		<div class="row">
    			<!-- Room Details -->
    			<div class="col-md-12" style="padding:2px 17px 2px 17px;">
    				<div class="section_header"><?php echo $this->lang->line('room_info');?></div>
    				
    				<!-- Loop starts here -->
    				<?php 
    				
    				$rooms = explode(',', $rooms);
    				$room_details = array();
    				$room_w_extra_bed = 0;
    				//echo $max_children_age;
    				foreach ($rooms as $room) {
    					$arr_room_rate = explode(':', $room);
    					$rt = $this->m_room_type->get_room_type_by_ID(1, $arr_room_rate[0]);
    					array_push($list_of_rooms, $rt->id_room_type);
    					$max_children_age = ($max_children_age < $rt->max_children_age) ? $rt->max_children_age : $max_children_age;
						$room_type_photos = $this->m_room_type->get_room_type_photos_by_modular($arr_room_rate[0]);
    					$count_room_max_adult = $count_room_max_adult + $rt->number_of_adults; 			
    					array_push($room_details, $rt);    	
    					if ($rt->is_big_room == 1) {
    						$room_w_extra_bed = $room_w_extra_bed + 1;
    					}				
    				?>
    				
    				<div class="row room_type mb-1">
    					<div class="col-md-12 font-weight-bold text-center"><?php echo $rt->room_type_name_en;?></div>
    					
    					<div class="col-md-6">
	    					<div class="row">
	    						<div class="col-md-12 imgThumbnail_sm"><img src="<?php echo share_folder_path().$room_type_photos[0];?>" style="max-width: 100%;"></div>
	    					</div>
    					</div>
    					
    					<!-- Roome Details -->
    					<div class="col-md-6">
    						<div class="row">
    							<div class="col-md-12 text-center">
									<?php 
									$price = ($lang == 'english') ? number_format($arr_room_rate[1],0).'/Night' : 'ราคา '.number_format($arr_room_rate[1],0).'/คืน';
									?>
									<div class="price" style="margin-bottom:15px; margin-top:5px; margin-left:-15px;"><b><?php echo $price;?></b></div>
									
									<div class="container text-left">
									
									<div class="row">
									<div class="col-md-2 col-sm-2 icon_container">
										<span class="icon-content"><object data="<?php echo share_folder_path();?>images/icons/house.svg" height="20"></object></span> 
									</div>
									<div class="col-md-9 col-sm-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? $rt->area_en : $rt->area_th; ?></span>
									</div>
									</div>
			
									<div class="row">
									<div class="col-md-2 col-sm-2 icon_container" >
										<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo share_folder_path();?>images/icons/icons8-bedroom-50.png" height="18"></span>
									</div>
									<div class="col-md-9 col-sm-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? $rt->room_details_en : $rt->room_details_th; ?> <?php echo ($rt->is_big_room == 1) ? '(Can add 1 bed for 1 person)' : '';?></span>
									</div>
									</div>

									<div class="row">
									<div class="col-md-2 col-sm-2 icon_container" >
										<span class="icon-content" style="margin-left:4px; margin-top:-1px;"><img class="icon" src="<?php echo share_folder_path();?>images/icons/bathroom.png" height="18"></span>
									</div>
									<div class="col-md-9 col-sm-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? $rt->bathroom_en : $rt->bathroom_th; ?></span>
									</div>
									</div>
									
									<div class="row">
									<div class="col-md-2 col-sm-2 icon_container" >
										<span class="icon-content" style="margin-left:1px;"><object data="<?php echo share_folder_path();?>images/icons/person-fill.svg" height="18"></object></span>
									</div>
									<div class="col-md-9 col-sm-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? $rt->number_of_adults.' Adults' : 'จำนวนผู้เข้าพัก: '.$rt->number_of_adults ;?></span>
									</div>		
									</div>
									
									<div class="row" >
									<div class="col-md-2 col-sm-2 icon_container">
										<object data="<?php echo share_folder_path();?>images/icons/tv.svg" height="20"> </object>
									</div>
									<div class="col-md-9 col-sm-9 icon_container">
										<span class="icon-content">TV (Internet)</span>
									</div>						
									</div>
									
									<div class="row">
									<div class="col-md-2 col-sm-2 icon_container">
										<span class="icon-content"><object data="<?php echo site_url();?>images/icons/snow.svg" height="20"> </object></span>
									</div>
									<div class="col-md-9 col-sm-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
									</div>
									</div>
									
									<div class="row" >
									<div class="col-md-2 col-sm-2 icon_container">
										<span class="icon-content"><object data="<?php echo share_folder_path();?>images/icons/wifi.svg" height="20"> </object></span>
									</div>
									<div class="col-md-9 col-sm-9 icon_container">
										<span class="icon-content">Free WIFI</span>
									</div>						
									</div>
									<?php if ($rt->sofa_en != '') {?>
									<div class="row">
									<div class="col-md-2 col-sm-2 icon_container">
										<span class="icon-content" style="font-size:16px; margin-top:-2px;">
											<object data="<?php echo share_folder_path();?>images/icons/sofa.png" height="14"></object>
										</span>
									</div>
									<div class="col-md-9 col-sm-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? $rt->sofa_en : $rt->sofa_th; ?></span>
									</div>						
									</div>
									<?php }?>
									</div>
								</div>
    						</div>
    					</div>
    				
    			</div>
    			<?php }?>
    			<div class="row room_type mb-1">
    				<!-- Extras -->
    					<div class="col-md-12">
    						<div class="rounded hr3 mt-2 mb-2"></div>
    						<div class="section_header"><?php echo $this->lang->line('extra_request_items');?>:</div>
    						<!-- <div class="">Requests are subject to availability</div> -->
    						<!-- 
    						<?php  
    						$extra_bed = 0;
    						foreach ($setting_extras as $s_extra) {
							$s_extra_name = ucfirst(str_replace("_price", "", $s_extra->name));							
							?>
							
							<div class="row" style="margin: 10px 10px 10px 10px;">
    							<div class="col-md-6 col-sm-6"><input type="checkbox" class="chk_extras" style="vertical-align: middle;" data-price="<?php echo $s_extra->value;?>" data-name="<?php echo ucfirst($s_extra_name);?>" name="c_<?php echo $s_extra_name;?>" id="c_<?php echo $s_extra_name;?>">&nbsp;<?php echo ucfirst($s_extra_name);?></div>
    							<div class="col-md-6">Qty: <input type="text" class="val_extras" disabled  name="inp_<?php echo $s_extra_name;?>" data-price="<?php echo $s_extra->value;?>" data-name="<?php echo ucfirst($s_extra_name);?>" id="inp_<?php echo $s_extra_name;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></div>
    						</div>
							<?php } 
							
							?>
    						 -->
							<?php 
							foreach ($extras as $extra) {
								$extra_name = str_replace(" ", "_", $extra->title_en);
							
								if ($extra->is_bed == 0) {								
								?>							
								<div class="row" style="margin: 10px 10px 10px 10px;">
	    							<div class="col-md-6"><input type="checkbox" class="form_field chk_extras <?php echo ucfirst($extra_name);?>" style="vertical-align: middle;" data-id="<?php echo $extra->id_extras; ?>" data-price="<?php echo $extra->price;?>" data-name="<?php echo ucfirst($extra->title_en);?>" name="c_<?php echo $extra_name;?>" id="c_<?php echo $extra_name;?>" value="1">&nbsp;<?php echo ucfirst($extra->title_en);?></div>
	    							<div class="col-md-6"><?php echo $this->lang->line('quantity');?> (max of <?php echo $extra->max_qty;?>): <input type="text" disabled class="form_field val_extras" min="0" max="<?php echo $extra->max_qty;?>" name="inp_<?php echo $extra_name;?>" data-bed="<?php echo $extra->is_bed;?>" data-price="<?php echo $extra->price;?>" data-name="<?php echo ucfirst($extra->title_en);?>" id="inp_<?php echo $extra_name;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></div>
	    						</div>
								<?php 
								}	//if ($extra->is_bed == 0) {	
								else {
									if ($room_w_extra_bed > 0) {
										if ($extra->is_bed == 1 ) {
											$extra_bed = $extra->max_qty;
										}
										$max_bed = intval($room_w_extra_bed) * intval($extra_bed);
								
								?>
								<div class="row" style="margin: 10px 10px 10px 10px;">
	    							<div class="col-md-6"><input type="checkbox" class="form_field chk_extras bed" style="vertical-align: middle;" data-id="<?php echo $extra->id_extras; ?>" data-price="<?php echo $extra->price;?>" data-name="<?php echo ucfirst($extra->title_en);?>" name="c_bed" id="c_bed">&nbsp;<?php echo ucfirst($extra->title_en);?></div>
	    							<div class="col-md-6"><?php echo $this->lang->line('quantity');?> (max of <?php echo $max_bed;?>): <input type="text" disabled class="form_field val_extras bed" min="0" max="<?php echo $max_bed;?>" name="inp_bed" data-bed="<?php echo $extra->is_bed;?>" data-price="<?php echo $extra->price;?>" data-name="<?php echo ucfirst($extra->title_en);?>" id="inp_bed" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></div>
	    						</div>
								<?php 
									} //if ($room_w_extra_bed > 0)
								} // else if ($extra->is_bed == 0) {
							} //foreach ($extras as $extra)
							?>
    						
    						<!-- 
    						<div class="row" style="margin: 10px 10px 10px 10px;"> 
    							<div class="col-md-6"><input type="checkbox" class="chk_extras" style="vertical-align: middle;" data-name="towel" name="c_towel" id="c_towel">&nbsp;Towel</div>
    							<div class="col-md-6">Qty: <input type="text" class="val_extras" name="inp_towel" data-name="towel" id="inp_towel" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></div>
    						</div>
    						
    						<div class="row" style="margin: 10px 10px 10px 10px;">
    							<div class="col-md-6"><input type="checkbox" class="chk_extras" name="c_towel" data-name="adapter" id="c_towel" style="vertical-align: middle;">&nbsp;Adapter</div>
    							<div class="col-md-6">Qty: <input type="text" class="val_extras" data-name="adapter" name="inp_adapter"  id="inp_adapter" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></div>
    						</div>
    						
    						<div class="row" style="margin: 10px 10px 10px 10px;">
    							<div class="col-md-6"><input type="checkbox" class="chk_extras" data-name="hair_dryer" style="vertical-align: middle;">&nbsp;Hair Dryer</div>
    							<div class="col-md-6">Qty: <input type="text" class="val_extras" data-name="hair_dryer" name="inp_hair_dryer" id="inp_hair_dryer" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></div>
    						</div>
    						 -->
    					</div>
    					
    				</div>
    				
    				<form name="frm_save" id="frm_save" method="post" action="<?php echo site_url('booking').'/save_booking';?>">  
				  	<input type="hidden" name="id_guest" value="<?php echo $id_guest;?>" />
				  	<input type="hidden" name="id_discount" id="id_discount" data-val="" value="<?php echo (isset($discount->id_discount)) ? $discount->id_discount : '';?>" />
				  	
				  	<input type="hidden" name="rooms" id="id_room" value="<?php echo implode(',', $rooms);?>" />
				  	<input type="hidden" name="items" id="items" />
				  	
				  	<input type="hidden" name="h_grand_total" id="h_grand_total" value="0"/>
					<input type="hidden" name="h_discount" id="h_discount" value="0" />
					<input type="hidden" name="h_subtotal" id="h_subtotal" value="0" />
					<input type="hidden" name="h_vat" id="h_vat" value="0" />
					
				  	<input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="<?php echo $number_of_adult;?>">
					<input type="hidden" name="h_num_of_room" id="h_num_of_room" value="<?php echo $number_of_room;?>">
					<input type="hidden" name="h_id_room" id="h_id_room" value="<?php echo implode(',', $rooms);?>">
					<input type="hidden" name="h_num_of_children" id="h_num_of_children" value="<?php echo $number_of_children;?>">
					<input type="hidden" name="h_children_ages" id="h_children_ages" value="<?php echo $children_ages;?>">
					<input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
					<input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">
					
					<input type="hidden" name="h_good_to_go" id="h_good_to_go" value="">
					<input type="hidden" name="h_bed_needed" id="h_bed_needed" value="">
					<input type="hidden" name="h_cart_item" id="h_cart_item" value="<?php echo (isset($cart_item)) ? $cart_item : '';?>">
					
				  
    				
    				<!-- GUEST INFO -->
    				<div class="row room_type">
	    				<div class="col-md-12 " style="padding:10px 17px 2px 17px;">
		    				<div class="row">
		    				<div class="col-md-12 mb-1">
		    				<div class="section_header">
		    				
		    				<?php echo $this->lang->line('guest_info');?>		    				
		    				</div>
		    				<span style="float: left; font-weight: normal; font-style: italic;"><input type="checkbox" class="form_field" name="same_billing_info" id="same_billing_info" style="vertical-align:middle; margin-right: 5px;">Same Billing Information</span>
		    				</div>
		    				</div>
		    				
		    				<div class="row">		    					
		    					<div class="col-md-12 mb-1">
		    						<div class="form-outline">
					                  	<label class="form-label" for="guest_name"><span class="required">*</span><?php echo $this->lang->line('guest_name');?></label>
					                    <input type="text" id="guest_name" name="guest_name" class="form_field form-control " value="<?php echo $guest_info->name;?>" required/>					                    
				                  	</div>							              
		    					</div> 		
		    					
		    					<div class="col-md-12 mb-1">
		    						<div class="form-outline">
					                  	<label class="form-label" for="guest_address"><span class="required">*</span><?php echo $this->lang->line('guest_address');?></label>
					                    <textarea id="guest_address" name="guest_address" class="form_field form-control " required><?php echo $guest_info->address;?></textarea>					                    				                   
					                  </div>
		    					</div>    	
		    					
		    					<div class="col-md-12 mb-1">
			    					<div class="form-outline">
					                  	<label class="form-label" for="guest_contact_number"><span class="required">*</span><?php echo $this->lang->line('guest_contact_number');?></label>
					                    <input type="tel" id="guest_contact_number" name="guest_contact_number" class="form_field form-control contact_number" value="<?php echo $guest_info->contact_number;?>" required/>					                    
				                  	</div>
		    					</div>		
		    					
		    					<div class="col-md-12 mb-1">
			    					<div class="form-outline">
					                  	<label class="form-label" for="guest_email"><?php echo $this->lang->line('guest_email');?></label>
					                    <input type="email" id="guest_email" name="guest_email" class="form_field form-control email" value="<?php echo $guest_info->email;?>" />					                    
				                  	</div>
		    					</div>
		    					
		    					<div class="col-md-12 mb-1">
			    					<div class="form-outline">
							            <label class="form-label" for="guest_tax_id"><span class="required">*</span><?php echo $this->lang->line('guest_tax_id');?></label>
							            <input type="text" id="guest_tax_id" name="guest_tax_id" class="form_field form-control " value="<?php echo $guest_info->tax_id;?>" required/>
						            </div>
		    					</div>
		    													
		    				</div>
	    				</div>    			
    				</div> <!-- Room TYpe -->
    				<!-- END OF GUEST INFO  -->	
    				<!-- BILLING INFO -->
    				<div class="row room_type mt-1">
	    				<div class="col-md-12 " style="padding:10px 17px 2px 17px;">
		    				<div class="section_header"><?php echo $this->lang->line('billing_info');?></div>
		    				<div class="row">		    					
		    					<div class="col-md-12 mb-1">
		    						<div class="form-outline">
					                  	<label class="form-label" for="billing_name"><span class="required">*</span><?php echo $this->lang->line('billing_name');?></label>
					                    <input type="text" id="billing_name" name="billing_name" class="form_field form-control " value="<?php echo $guest_info->name;?>" required/>					                    
				                  	</div>							              
		    					</div> 		
		    					
		    					<div class="col-md-12 mb-1">
		    						<div class="form-outline">
					                  	<label class="form-label" for="billing_address"><span class="required">*</span><?php echo $this->lang->line('billing_address');?></label>
					                    <textarea id="billing_address" name="billing_address" class="form_field form-control " required><?php echo $guest_info->address;?></textarea>					                    				                   
					                  </div>
		    					</div>    	
		    					
		    					<div class="col-md-12 mb-1">
			    					<div class="form-outline">
					                  	<label class="form-label" for="billing_contact_number"><span class="required">*</span><?php echo $this->lang->line('billing_contact_number');?></label>
					                    <input type="tel" id="billing_contact_number" name="billing_contact_number" class="form_field form-control contact_number" value="<?php echo $guest_info->contact_number;?>" required/>					                    
				                  	</div>
		    					</div>		
		    					
		    					<div class="col-md-12 mb-1">
			    					<div class="form-outline">
					                  	<label class="form-label" for="billing_email"><?php echo $this->lang->line('billing_email');?></label>
					                    <input type="email" id="billing_email" name="billing_email" class="form_field form-control email" value="<?php echo $guest_info->email;?>"/>					                    
				                  	</div>
		    					</div>
		    					
		    					<div class="col-md-12 mb-1">
			    					<div class="form-outline">
							            <label class="form-label" for="billing_tax_id"><span class="required">*</span><?php echo $this->lang->line('billing_tax_id');?></label>
							            <input type="text" id="billing_tax_id" name="billing_tax_id" class="form_field form-control " value="<?php echo $guest_info->tax_id;?>" required/>
						            </div>
		    					</div>
		    													
		    				</div>
	    				</div>    			
    				</div> <!-- Room TYpe -->
    				<!-- END OF BILLING INFO  -->
    				</form>
    					
    			</div>    			
    		</div>
    	
    	</div>
    	
    	
    	<div class="col-md-5">
    		<div class="row">
    			    			<!-- Summary -->
    			<div class="col-md-12" style="padding:2px 17px 2px 17px;">
    				<div class="section_header"><?php echo $this->lang->line('booking_summary');?></div>
    				
    				<!-- Loop starts here -->
    				<div class="row room_type">
    					
    					<div class="col-md-12" style="display: flex; flex-direction: row; padding: 10px;">
							<div class="group">
							    <label for="name"><?php echo $this->lang->line('check_in_date');?></label>
							    <input type='text' class="form_field datepicker" name="check_in_date" id="check_in_date" value="<?php echo $check_in_date;?>" />
							</div>
							<div class="group">
							    <label for="name"><?php echo $this->lang->line('check_out_date');?></label>
							    <input type='text' class="form_field datepicker" name="check_out_date" id="check_out_date" value="<?php echo $check_out_date;?>" />
							</div>
						</div>
						<div class="col-md-4 mb-2 mt-2 font-weight-bold"><?php echo sizeof($rooms);?> <?php echo $this->lang->line('rooms');?>, <span id="sum_of_nights"><?php echo $num_of_nights;?></span> <?php echo $this->lang->line('night');?> </div>
						<div class="col-md-8 mb-2 mt-2 font-weight-bold"><?php echo $this->lang->line('booked_for');?> <?php echo $number_of_adult;?> <?php echo $this->lang->line('adults');?>, <?php echo $number_of_children;?> <?php echo $this->lang->line('children');?> (<?php echo $this->lang->line('ages');?>: <?php print_r($children_ages);?>)</div>
						
    					<div class="col-md-12 mb-2">
    					

    						<div class="row mt-3 mb-2">
							<div class="col-md-12">
								<div class = "table-responsive">
						         <table class="table room_rates">
						         <thead>
						         	<tr>
						         		<th><?php echo $this->lang->line('item');?></th>
						         		<th class="unit_price text-right"><?php echo $this->lang->line('unit_price');?></th>
						         		<th class="number_of_nights text-right"><?php echo $this->lang->line('quantity');?></th>
						         		<th class="item_amount text-right"><?php echo $this->lang->line('amount');?></th>
						         	</tr>
						         </thead>
						         <tbody>
    						<?php 
    						$room_ctr = 0;
	    					foreach ($rooms as $room) {
	    					$arr_room_rate = explode(':', $room);
	    					$room_type = $this->m_room_type->get_room_type_by_ID(1, $arr_room_rate[0]);
	    					$room_total = $arr_room_rate[1] * $num_of_nights;
	    					$arr_room_price = $CI->m_room_type->get_season_price($room_type->id_room_type, $check_in_date, $check_out_date);
	    					//print_r($arr_room_price);
	    					?>
	    					
	    					<?php 
						    foreach ($arr_room_price as $p) {
						    ?>						         
						    <tr>
						    	<td><span class="item_name" data-id-extras="0"><?php echo $room_type->room_type_name_en;?></span></td>
						        <td class="unit_price text-right"><span class="item_unit_price"><?php echo number_format($p['unit_price'], 2);?></span></td>
						        <td class="number_of_nights text-right"><span class="item_qty"><?php echo $p['night_ctr'];?></span></td>
						        <td class="item_amount text-right"><span class="item_rate" ><?php echo number_format($p['unit_price']*$p['night_ctr'], 2);?></span></td>
						    </tr>
						   <?php }?>
						         	
						         	
    						<!-- 
    						<div class="row flex-row" style="padding: 0 10px 0 10px;">    							   
    							<div class="col-md-12">
    							<div class="row">
    								<div class="col-md-4 col-sm-4  mr-auto" style="float: left;"><?php echo $number_of_room;?> <?php echo $room_type->room_type_name_en;?></div>
    								<div class="col-md-2 col-sm-2" style="text-align: right;"><span class="room_dets" id="room_rate_val_<?php echo $room_ctr;?>"><?php echo number_format($arr_room_rate[1], 2);?></span>&nbsp;x&nbsp;<span id="num_of_night_<?php echo $room_ctr?>"><?php echo $num_of_nights;?></span></div>
    								<div class="col-md-5 col-sm-5" style="text-align: right; marging-right: 12px;"><span class="item_rate" id="item_rate_<?php echo $room_ctr?>"><?php echo number_format($room_total, 2);?></span></div>
    							</div>
    							 
    							<div class="d-flex align-items-start" style="float: left;"><?php echo $number_of_room;?> <?php echo $room_type->room_type_name_en;?></div>
    							<div style="float: right;"><span class="item_rate" ><?php echo number_format($arr_room_rate[1], 2);?></span></div>
    							
    							</div>						
    						</div>  -->
    						<?php 
    						$room_ctr++;
	    					}
	    					?> 
	    					</tbody>
						         </table>
								</div>
							</div>
						</div>
    					</div>
    					
    					<div class="col-md-12 mt-3">
    						<div class="input-group mb-3">
							    <input type="text" class="form-control search_discount_code" name="discount_code" id="discount_code" placeholder="" value="<?php echo (isset($discount->code)) ? $discount->code : '';?>">
							    <div class="input-group-append">
							      <button class="input-group-text search_discount_code" id="search_discount_code" style="font-size: 0.9em; cursor: pointer;"><?php echo $this->lang->line('discount_code');?></button>
							    </div>
						 	</div>
						</div>
    					
    					<div class="col-md-12 mt-3">
    						<div class="d-flex align-items-start" style="float: left; font-weight: bold;"> <?php echo $this->lang->line('total');?>:</div>
    						<div class="flex-row" style="">    							   
    							<div class="col-md-12" >    							
    							<div class="total" style="float: right;">0</div>
    							</div>						
    						</div>    						
    					</div>
    					<?php 
    					//print_r($discount);
    					if (isset($discount->id_discount) != '') {
    					?>
    					<div class="col-md-12 mt-3" id="div_computed_discount">
    						<div class="d-flex align-items-start" style="float: left; font-weight: bold;"> <?php echo $this->lang->line('discount');?>&nbsp;(<span id="discount_desc"></span>): </div>
    						<div class="flex-row" style="">    							   
    							<div class="col-md-12" >    							
    							<div class="discount" style="float: right;">0</div>
    							</div>						
    						</div>    						
    					</div>
    					<?php } ?>
    					
    					<div class="col-md-12 mt-3">
    						<div class="d-flex align-items-start" style="float: left; font-weight: bold;"><?php echo $this->lang->line('grand_total');?>:</div>
    						<div class="flex-row" style="">    							   
    							<div class="col-md-12" >    							
    							<div class="grand_total" style="float: right;">0</div>
    							</div>						
    						</div>    						
    					</div>
    					
    					<div class="col-md-12 mt-3">
    						<div class="d-flex align-items-start" style="float: left; font-weight: bold;"><?php echo $this->lang->line('vat');?> (7%):</div>
    						<div class="flex-row" style="">    							   
    							<div class="col-md-12" >    							
    							<div class="vat" style="float: right;">0</div>
    							</div>						
    						</div>    						
    					</div>
    					
    					<div class="col-md-12 mt-3">
    						<div class="d-flex align-items-start" style="float: left; font-weight: bold;"><?php echo $this->lang->line('subtotal');?>:</div>
    						<div class="flex-row" style="">    							   
    							<div class="col-md-12" >    							
    							<div class="subtotal" style="float: right;">0</div>
    							</div>						
    						</div>    						
    					</div>
    					
    					
    					<div class="col-md-12 mb-2 mt-2">
		    				<button class="btn button-primary form-control form-control-lg" id="proceed" disabled><?php echo $this->lang->line('proceed');?></button>
		    			</div>
    				</div>
    			</div>
    			
    			
    			
    		</div> <!-- Row -->    		    	
    	</div>
    	
    </div>
  </div>
  
</main>

<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script src=
"https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js">
    </script>

<script>
var js_data = '<?php echo json_encode($discount);?>';
var discount = JSON.parse( js_data );
var discount_desc = discount.title_en; 

function stepper(dis) {
	let btn_id = dis.getAttribute('id');
	let max = dis.getAttribute('max');
	
	const myArray = btn_id.split("-");
	var myInput = myArray[1];
	let min = $('#'+myInput).val();
	
	var newval = ( myArray[0] == 'increment' ) ? (parseInt(min)+1) : (parseInt(min)-1);
	newval = (newval < 0) ? 0 : newval;
	$('#'+myInput).val(newval);
	$('#div_'+myInput).html(newval);
	if (btn_id == 'increment-children') {
		$('.div_kids_age').html('');
		var new_html = '';
		if (newval > 0) {
			for (var x=0; x < newval; x++) {
				max_age = 12;
				var option_ct = 1;
				new_html += '<div class="col-md-3" style="padding: 1px;">'
						+ '<label>Age</label>'
						+ '<select class="form-control select_age">'
						+ '<option value="0">0</option>';
				do {
					new_html += '<option value="'+option_ct+'">'+option_ct+'</option>';
					option_ct++;
				} while(option_ct <= max_age);		
				new_html += '</select></div>';
			}
				
		}
		$('.div_kids_age').html(new_html);
	}

	if (btn_id == 'increment-room' || btn_id == 'decrement-room') {		
		$('#h_room').val(newval);

		var rate = $('#h_rate').val();
		var total = newval * rate;
		//console.log(newval + ' ' + rate);
		$('#number_of_rooms').text(newval);
		
		$('.total_rate').text(number_add_comma_decimal(total));
		$('.grand_total').text(number_add_comma_decimal(total));
		//$('#total_rate').val(total);
	}
}

function date_diff (date1, date2) {	
	const diffTime = Math.abs(date2 - date1);
	const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
	//console.log(diffTime + " milliseconds");
	//console.log(diffDays + " days");
	return diffDays;
} 



	$(function(){		
		$('#check_in_date').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date(), // = today
		    onSelect: function(dateText, inst) {
		    	change_date_calc();
		    	get_form_fields ();
		    }
		}).val();

		$('#check_out_date').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date(), // = today
		    onSelect: function(dateText, inst) {				
		    	change_date_calc();
		    	get_form_fields ();
		    }
		}).val();
		
		//console.log(type_a);
		$('.myImg').click(function(){
			var id = $(this).attr('data-id');
			$('.carousel-item').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.slide').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.'+id).addClass('active');
			$('#ModalCarousel').modal('show');
		});

		$('.select_age').click(function(){
		});

		$('.dropdown-menu').on('click', function(event){
		    // The event won't be propagated up to the document NODE and 
		    // therefore delegated events won't be fired
		    event.stopPropagation();
		});

		$('#proceed').click(function(){
		  if (
				  $('#guest_name').val() == '' ||
				  $('#guest_address').val() == '' ||
				  $('#guest_contact_number').val() == '' ||
				  $('#guest_tax_id').val() == '' ||
				  $('#billing_name').val() == '' ||
				  $('#billing_address').val() == '' ||
				  $('#billing_contact_number').val() == '' ||
				  $('#billing_tax_id').val() == ''	  
				  ) {
			  alert("Please fill-up all required fields")
		  }
		  else {
			
			var rooms_to_check = eval('('+"<?php echo json_encode($list_of_rooms);?>"+')');
			//alert(rooms_to_check)
			//console.log(rooms_to_check);

			var _url = "<?php echo site_url('room_details/room_available');?>";
			$.ajax({
	               method: "POST",
	               url: _url,
	               data: {
	                   'rooms': rooms_to_check.toString(),
	                   'check_in_date': $('#check_in_date').val(),
	                   'check_out_date': $('#check_out_date').val()               
	               }
	       }) 
	       .done(function( res ) {
	    	   var obj = eval('('+res+')');
	    	   if(obj.length > 0) {
					alert ("There is a room that is not available on the date selected")
			   }
		       else {
		    	   var extras = [];
					$('#h_check_in_date').val($('#check_in_date').val());
					$('#h_check_out_date').val($('#check_out_date').val());
					var list_items = document.getElementsByClassName("item_name");
					var list_item_qty = document.getElementsByClassName("item_qty");
					var list_item_u_price = document.getElementsByClassName("item_unit_price");
					var items = [];
					//console.log(list_items[1].innerHTML);
					for (var i = 0; i < list_items.length; i++) {
						var x_name = list_items[i].innerHTML;
						var ex_name = x_name.replace(/\s+/g, '_');
						var item = '';
						item = ex_name+':'+list_item_qty[i].innerHTML+':'+remove_comma(list_item_u_price[i].innerHTML);
						item +=  ':'+ list_items[i].getAttribute('data-id-extras');
						items.push(item);
					}

					$('#items').val(items);			
					
					var subtotal = 0;
					var vat = 0;
					var grandtotal = 0;

					var item_rates = document.getElementsByClassName('item_rate');
					var prices = 0
					for (var i = 0; i < item_rates.length; i++) {
						var a = item_rates[i].innerHTML;
						a=a.replace(/\,/g,'');			
						prices += parseFloat(a);				
					}
					discount_amount = 0;
					grandtotal = prices;
					//console.log(discount.discount_type);
					if (discount.discount_type == 'percent') {
						val = discount.discount_value;
						discount_amount = Math.floor(prices - (((100-val)/100) * prices));
						grandtotal = grandtotal - discount_amount;
					}
					else if (discount.discount_type == 'amount') {
						discount_amount = Math.floor(discount.discount_value);
						grandtotal = grandtotal - discount_amount;
					}
					vat = grandtotal * (7/107);
					subtotal = grandtotal.toFixed(2) - vat.toFixed(2);
					$('#h_discount').val(discount_amount.toFixed(2));
					$('#h_subtotal').val(subtotal.toFixed(2));
					$('#h_vat').val(vat.toFixed(2));
					$('#h_grand_total').val(grandtotal.toFixed(2));
					sessionStorage.clear();
					$('#frm_save').submit();	
		       }
	    	   
	       });
	       
		  }	
		});

		$('.chk_extras').click(function(){
			var data_name = $(this).attr('data-name');
			var dataname = data_name.replace(/\s+/g, '_');
			if ($(this).hasClass('bed')) {
				dataname = 'bed';
			}
			else {
				dataname = data_name.replace(/\s+/g, '_');
			}
			// DEFAULT VALUE
			$('#inp_'+dataname).val(1);
			$('#inp_'+dataname).attr('disabled', false);
			//alert('test')
			get_extras();

			if ($(this).hasClass('bed')) {		
				if ($(this).is(':checked')) {
					$('#inp_bed').attr('disabled', false);
					$('#inp_bed').val('1');
				}
						
				var bed_needed = $('#h_bed_needed').val();				
				var bed_added = ($('#inp_bed').val() != '') ? $('#inp_bed').val() : 0;
				//console.log("Bed Needed and Bed Added "+parseInt(bed_needed)+'-'+parseInt(bed_added));
				if ( parseInt(bed_needed) <= parseInt(bed_added) ) {
					//console.log('CHECKED');
					$('#proceed').attr('disabled', false);
				}
				else {
					//console.log('UNCHECKED');
					$('#proceed').attr('disabled', true);
				}
			}
			calculate_summary(discount);
			
		});

		$('.val_extras').change(function(){
			var qty = $(this).val();
			var max_qty = $(this).attr('max');
			var data_name = $(this).attr('data-name');
			if ($(this).hasClass('bed')) {
				dataname = 'bed';
			}
			else {
				dataname = data_name.replace(/\s+/g, '_');
			}
			if (qty > max_qty) {
				alert ('Value must me less than max quantity!');
				//console.log(dataname);
				if ($(this).hasClass('bed')) {
					$('#inp_bed').val(1);
					$('#add_count_bed').text(1);
				}
				else {
					$('#inp_'+dataname).val(1);
					$('#add_count_'+dataname).text(1);
				}
			}
			else {							
				var unit_price = $(this).attr('data-price');				
				var item_total_amount = unit_price*qty;
				$('#add_count_'+dataname).text(qty);		
				$('#price_'+dataname).text(number_add_comma_decimal(item_total_amount));
			}		
			if ($(this).hasClass('bed')) {				
				//alert("Bed")
				var bed_needed = $('#h_bed_needed').val();				
				var bed_added = $('#inp_bed').val();
				//console.log("Bed Needed and Bed Added "+bed_needed+'-'+bed_added);
				if ( parseInt(bed_needed) <= parseInt(bed_added)) {
					//console.log('CHECK');
					$('#proceed').attr('disabled', false);
				}
				else {
					$('#proceed').attr('disabled', true);
				}
			}
			calculate_summary(discount);
			
		});

		$('#discount_code').focusout (function(){
			var val = $(this).val();
			var new_discount = new Object();
			if (val != '') {
				var _url = "<?php echo site_url('booking/get_discount');?>";
				$.ajax({
		               method: "POST",
		               url: _url,
		               data: {
		                   'code': val,
		                   'check_in_date': $('#check_in_date').val(),
		                   'check_out_date': $('#check_out_date').val()               
		               }
		       }) 
		       .done(function( res ) {			       
		    	   obj = eval('('+res+')');
				   //console.log('OBJ'+obj.id_discount);		
				   if (obj.id_discount == undefined || obj.id_discount == '') {					   
					   alert("Discount Code not found")
				   }
				   discount = obj;
				   $('#id_discount').val((obj.id_discount == undefined) ? '' : obj.id_discount);
				   calculate_summary (discount);    	   
		       });
			}
		});

		$(".contact_number").inputmask({"mask": "9{3}-9{3}-9{4}"}); 
		$('.contact_number').on('focusout', function() {
			var pattern1 = new RegExp("^([0-9]{3})[-]([0-9]{3})[-]([0-9]{4})$");
			var value = $(this).val();
			//console.log($(this));
			//console.log(pattern1.test(value));
			if (!pattern1.test(value)) {
				$(this).val('');
			}						
		});
		
		
		$('.email').on('focusout', function() {
			if ($(this).val() != '') {
				var check = ValidateEmail($(this).val());
				if (!check) {			
					$(this).focus();
					$(this).val('');			
				}				
			}
		});

		

		$('#same_billing_info').click(function(){
			if ($(this).is(':checked')) {
				//alert('checked')
				$('#billing_name').val($('#guest_name').val());
				$('#billing_address').val($('#guest_address').val());
				$('#billing_contact_number').val($('#guest_contact_number').val());
				$('#billing_email').val($('#guest_email').val());
				$('#billing_tax_id').val($('#guest_tax_id').val());
				//console.log('>>>>');
				get_form_fields();
				load_sessionStorage();
				//console.log(sessionStorage);
			}
		});
		
		$('.form_field').on('click change', function(event){
			
			get_form_fields();
			load_sessionStorage();
		});
		
		validate_booking_guests ();		
		load_sessionStorage ();		
		//console.log(sessionStorage);
		calculate_summary (discount);
		//console.log(discount);

		// FUNCTIONS AFTER DOM
		
		function validate_phone_number (value) {
			var pattern1 = new RegExp("^([0-9]{3})[-]([0-9]{3})[-]([0-9]{4})$");
			var return_val = false;
			if (pattern1.test(value)) {
				return_val = true
			}
			return return_val;			
		}
		
		function get_extras () {
			//alert('function')
			$('.chk_extras').each(function(){
				var data_name = $(this).attr('data-name');
				var dataname = data_name.replace(/\s+/g, '_');
				if ($(this).hasClass('bed')) {
					dataname = 'bed';
				}
				else {
					dataname = data_name.replace(/\s+/g, '_');
				}
				if ($(this).is(':checked')) {			
					var price = $(this).attr('data-price');
					tableBody = $(".room_rates tbody");
					var qty = 0;
					if ($(this).hasClass('bed')) {
						qty = $('#inp_bed').val();
					}
					else {
						qty = $('#inp_'+dataname).val();
					}
					var id_extras = $(this).attr('data-id');
	
					var markup = '';
					markup += '<tr id="div_add_'+dataname+'">'
	 					+ '<td><span class="item_name" data-id-extras="'+ id_extras +'">'+data_name+'</span></td>'
	 					+ '<td class="unit_price text-right" id=""><span class="item_unit_price" id="unit_price_'+dataname+'">'+number_add_comma_decimal(price)+'</td>'
	 					+ '<td class="number_of_nights text-right"><span class="item_qty" id="add_count_'+dataname+'" >'+qty+'</span></td>'
	 					+ '<td class="item_amount text-right"><span class="item_rate" id="price_'+dataname+'">'+number_add_comma_decimal(price*qty)+'</td>'
	 					+ '</tr>';
	 				$('.room_rates > tbody').append(markup);
				}
				else {
					$('#inp_'+dataname).val('');
					$('#inp_'+dataname).attr('disabled', 'disabled');
					$('#div_add_'+dataname).remove();
					$('#div_unit_price_'+dataname).remove();
					$('#div_price_'+dataname).remove();
				}
			});
		}
		
		function get_form_fields () {
			$('.form_field').each(function(){
				let elem_id = $(this).attr('id');
				let elem_tag = $(this).prop('nodeName');
				let elem_type = $(this).attr('type');
				var val = $(this).val();
				if (elem_type == 'checkbox')
					var val = ($(this).prop('checked') == true) ? 1 : 0;
				//console.log(elem_type+'VALUE='+val);
				var item_val = elem_tag+':'+elem_type+':'+val;
				sessionStorage.setItem($(this).attr('id'), item_val);
				
				get_extras();
			});
		}
		
		function load_sessionStorage () {
			let keys = Object.keys(sessionStorage);				
			for(let key of keys) {
			  //console.log(`${key}: ${sessionStorage.getItem(key)}`);
			  sess_item = sessionStorage.getItem(key);
			  a_sess_item = sess_item.split(':');
			  		
			  //console.log('KEY '+key+' => '+a_sess_item);
			  if ((a_sess_item[0] == 'INPUT' && (a_sess_item[1] == 'text' || a_sess_item[1] == 'tel' || a_sess_item[1] == 'email') 
					  || a_sess_item[0] == 'TEXTAREA'))
			  	$('#'+key).val(a_sess_item[2]);
			  if (a_sess_item[0] == 'TEXTAREA') 
				$('#'+key).html(a_sess_item[2]);
			  if ((a_sess_item[0] == 'INPUT' && a_sess_item[1] == 'checkbox')) {
				if (a_sess_item[2] == 1) {
					$('#'+key).attr('checked', true);
					var inp = ($('#'+key).attr('data-name') != undefined) ? $('#'+key).attr('data-name') : '';
					var dataname = inp.replace(/\s+/g, '_');
					console.log(dataname);
					if (dataname != '') {	
						$('#inp_'+dataname).attr('disabled', false);		
						if ($('#'+key).hasClass('bed')) {
							$('#inp_bed').attr('disabled', false);
						}						  		
						//$('#inp_'+dataname).removeAttr('disabled');
					}
				}
			  }
			}	
			change_date_calc();		
		}
		
		/*console.log('Extra Bed: '+"<?php echo $extra_bed;?>");
		console.log('Room w Extra Bed: '+"<?php echo $room_w_extra_bed;?>");*/
		function validate_booking_guests () {		
			var number_of_adult_booking = $('#h_num_of_adult').val();
			var num_child = $('#h_num_of_children').val();
			var _ages = $('#h_children_ages').val();
			var children_ages = _ages.split(',');
			var room_details = '<?php echo json_encode($room_details);?>';
			var room_details = JSON.parse( room_details );
			var total_extra_bed = '<?php echo intval($extra_bed) * intval($room_w_extra_bed);?>';
			//console.log('Total Extra Bed: '+total_extra_bed);
			var sum_adult_capacity = '<?php echo $count_room_max_adult;?>';
			var result = putChildrenIntoRooms (children_ages, room_details);
			//console.log(result);
			var max_room_capacity = parseInt(sum_adult_capacity) + parseInt(total_extra_bed);
			var total_req_to_book = parseInt(number_of_adult_booking) + parseInt(result.length);
			var extra_bed_needed = (total_req_to_book > parseInt(sum_adult_capacity)) ? total_req_to_book - parseInt(sum_adult_capacity) : 0;
			var extra_bed_left = total_extra_bed - parseInt(result.length);
			//console.log("Total Req: "+total_req_to_book+" Adult Capacity: "+sum_adult_capacity);
			//console.log("Total Extra and Result Length: "+total_extra_bed + ' ' + parseInt(result.length));
			//alert(total_req_to_book + ' ' + max_room_capacity)
			var message = '';
			$('#h_bed_needed').val(extra_bed_needed);

			//console.log("Sum Adult Capacity and Extra Bed Left: " +sum_adult_capacity + '-' + extra_bed_left);
			//console.log("Total Req to Book and Max Room Capacity " + total_req_to_book + '-' + max_room_capacity);
			if (total_req_to_book < max_room_capacity) {
				// GOOD - 
				var adult_plus_ = sum_adult_capacity + extra_bed_needed;
				if (extra_bed_needed > 0 && extra_bed_left >= extra_bed_needed) {
					message = "Please make sure to add "+extra_bed_needed+" extra bed on this booking.";
					$('#h_good_to_go').val(0);
				} else {
					// GOOD TO BOOK			 
					$('#h_good_to_go').val(1);
					if ($('#h_good_to_go').val() == 1) {
						$('#proceed').attr('disabled', false);
					}
				} 				
			}
			else if (total_req_to_book == max_room_capacity) {							
				$('#proceed').attr('disabled', true);				
				$('#h_bed_needed').val(extra_bed_needed);
				//alert (extra_bed_needed + " - " + parseInt(total_extra_bed))
				if (parseInt(total_extra_bed) > 0 && parseInt(total_extra_bed) == extra_bed_needed) {
					message = "Please make sure to add "+extra_bed_needed+" extra bed on this booking.";
					$('#h_good_to_go').val(0);
				}
				else if (extra_bed_needed > parseInt(total_extra_bed)) {
					message = "Room capacity is not enough for this booking. Kindly add more rooms or change to a bigger room.";
					$('#h_good_to_go').val(0);
				}
				else {
					$('#h_good_to_go').val(1);
					$('#proceed').attr('disabled', false);
				}
			}
			else {
				// BAD TO BOOK
				message = "Room capacity is not enough for this booking. Kindly add more rooms or change to a bigger room.";
				$('#h_good_to_go').val(0);
			}
			$('#room_message').text(message);
		}
		
		function putChildrenIntoRooms (children, rooms) {
			let total_capacity_adults = 0;
			let total_capacity_children = 0;
			rooms.forEach((r) => {
				total_capacity_adults += r.number_of_adults ? parseInt(r.number_of_adults) : 0;
				total_capacity_children += r.number_of_children ? parseInt(r.number_of_children) : 0;
			});
			children = children.map(Number);
			children.sort(function(a, b) { return b - a; });
			rooms.sort(function(a, b) { 
				return parseInt(a.max_children_age) - parseInt(b.max_children_age); 
			});
			let remain_children = [];
			children.forEach((a) => {
				let found = false;
				rooms.forEach((r) => {
					if (!found && a <= r.max_children_age && r.number_of_children > 0) {
						r.number_of_children--;
						found = true;
					}
				});
				if (!found) {
					remain_children.push(a);
				}
			});
			return remain_children;
		}		

		function change_date_calc() {
			var extras = document.getElementsByClassName('chk_extras');
			//$('.chk_extras').prop('checked', false);
			//$('.val_extras').prop('value', '');
			//$('.val_extras').prop('disabled', true);
			
			var check_in_date = $("#check_in_date").val();				
			var today = check_in_date.split('-');
			var date1 = today[2]+'-'+today[1]+'-'+today[0];
			date1 = new Date(date1);
			var check_out_date = $("#check_out_date").val();			
			var next_date = check_out_date.split('-');
			var date2 = next_date[2]+'-'+next_date[1]+'-'+next_date[0];
			date2 = new Date(date2);
			var d_diff = date_diff(date1, date2);

			var _url = "<?php echo site_url('room_details/get_season_price');?>";
			var id_room_type = "<?php echo implode(',', $list_of_rooms);?>";
	        $.ajax({
	               method: "POST",
	               url: _url,
	               data: {
	                   'id_room_type': id_room_type,
	                   'check_in_date': check_in_date,
	                   'check_out_date': check_out_date               
	               }
	       })
	       .done(function( res ) {
	 			var obj = eval('('+res+')');
	 			//console.log(obj);
	 			var markup = '';
	 			var total = 0;
				for (var x=0; x < obj.length; x++) {
		 			var obj_key = Object.values(obj[x]);
		 			var id_room_type = (obj_key[0]); 	
		 			var room_type_name_en = (obj_key[1]); 	
		 			var date_price = (obj_key[2]);	
		 			$(".room_rates > tbody").html("");
		 			tableBody = $(".room_rates tbody");
		 			
		 			var room_name = obj_key.room_type_name_en;
					
									
		 			for (var i=0; i < date_price.length; i++) {		
		 				var unit_price = date_price[i].unit_price;
						var item_total_price = date_price[i].item_total_price;    
						markup += '<tr>'
								+ '<td><span class="item_name" data-id-extras="0">'+room_type_name_en+'</span></td>'
					       	 	+ '<td class="unit_price text-right"><span class="item_unit_price">'+number_add_comma_decimal(unit_price)+'</span></td>'
					       	 	+ '<td class="number_of_nights text-right"><span class="item_qty">'+date_price[i].night_ctr+'</span></td>'
					        	+ '<td class="item_amount text-right"><span class="item_rate" >'+number_add_comma_decimal(item_total_price)+'</span></td>'
					        	+ '</tr>';		         					
	 					total += parseFloat(date_price[i].item_total_price);
		 			}
		 			
				}
				
 				tableBody.append(markup);
 				get_extras ();
 				calculate_summary(discount);
 				validate_booking_guests();
	       });

	        
		}

		function calculate_summary (discount) {
			//console.log(discount);
			
			var subtotal = 0;
			var vat = 0;
			var grandtotal = 0;
			var item_rates = document.getElementsByClassName('item_rate');
			var prices = 0
			//console.log(item_rates);
			for (var i = 0; i < item_rates.length; i++) {
				//console.log(i+"."+item_rates[i].innerText)
				var a = item_rates[i].innerText;
				a=a.replace(/\,/g,'');			
				prices += parseFloat(a);			
			}
			grandtotal = prices;
			total = prices;
			discount_amount = 0;
			//console.log(discount);
			if (discount.discount_type == 'percent') {
				val = discount.discount_value;
				discount_amount = Math.floor(prices - (((100-val)/100) * prices));
				grandtotal = grandtotal - discount_amount;
			}
			else if (discount.discount_type == 'amount') {
				discount_amount = Math.floor(discount.discount_value);
				grandtotal = grandtotal - discount_amount;
			}
			
			//console.log('GRAND TOTAL:'+grandtotal.toFixed(2));
			vat = grandtotal * (7/107);
			subtotal = grandtotal.toFixed(2) - vat.toFixed(2);
			//console.log(prices);
			$('.subtotal').html(number_add_comma_decimal(subtotal));
			$('.vat').html(number_add_comma_decimal(vat));
			$('.grand_total').html(number_add_comma_decimal(grandtotal));
			$('.total').html(number_add_comma_decimal(total));
			$('.discount').html(number_add_comma_decimal(discount_amount));
			$('#discount_desc').text(discount_desc);				
		}

		
	});
</script>

