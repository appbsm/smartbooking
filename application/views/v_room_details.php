<?php $lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI =& get_instance();
$CI->load->model('m_room_type');
$rt = $room_type;
$date = date('Y-m-d');
$rate = $CI->m_room_type->get_day_rate ($rt->id_room_type, $date);
if ($rate == '') {
	$rate = $rt->default_rate;				
}

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
	.form-control, label, a {
		color: #000 !important;
	}
	a:hover {
		color: #000 !important;
	}
	.price {
		margin: 10px 0 0 0!important;
		background-color: #102958;
		color: white;
		text-shadow: 2px 2px 4px #000000;
	}

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
	.btn-add_to_cart {
		/*width: auto;
		height: auto;*/
		text-transform: uppercase;
		/*line-height: 30px;*/
		color: #fff !important;
		font-size: small !important;
		background-color: #102958 !important;
		border-color: #102958 !important;
	}
	.btn-add_to_cart:hover {
        background-color: #102958 !important;
		border-color: #102958 !important;
		color: #fff !important;
    }
	.book_now:hover {
		background-color: #102958 !important;
		border-color: #102958 !important;
		color: #fff !important;
    }
	.book_now {
		/*width: auto;
		height: auto;*/
		text-transform: uppercase;
		/*line-height: 30px;*/
		color: #fff !important;
		font-size: small !important;
		background-color: #102958 !important;
		border-color: #102958 !important;
	}
	
	.button__badge {
		margin-right: 0px;
		font-size: 0.6em !important;
		position: absolute;
		top: -8px !important;
		right: -4px !important;
	}
</style>

<?php 

?>

<main class="main-2" style="margin-top: 35px;">
 
  	<div class="row">
  		<!-- <div class="col-md-12">
  			<ul class="breadcrumb">
			  <li><a href="<?php echo site_url();?>"><?php echo $this->lang->line('home');?></a></li>
			  <li><?php echo $this->lang->line('room_details');?></li>
			</ul>
  		</div> -->
  	</div>
  <section class="text-center container">
    
  </section>
  
	<div class="container">
		<!--
		<div class="row">
			<div class="col-md-12 price room_type_header"><span style="margin-left: 10px;"><?php echo ($lang == 'english') ? $room_type->room_type_name_en : $room_type->room_type_name_th;?></span><?php echo $lang=='english' ?' Price ':' ราคา ';?><span id="hdr_room_rate"><?php echo number_format($rate,2);?></span> / <?php echo $this->lang->line('night');?></div>
		</div>
		-->
		<div class="row">
			<div class="col-md-7 mt-2">
				<div class="row">
					<?php 
					$first_photo = $room_type_photos[0];
					?>
					<div class="col-md-12 top-left-grid" style="text-align: right;">
					<img class="myImg imgThumbnail_bg img_border" data-id="1" src="<?php echo share_folder_path().$first_photo;?>" style="max-width: 100%;">
					</div>
				</div>
				<hr>
				<div class="row mb-5">
					<div class="col-md-12">
						<div class="col-md-12 section_header" style="display: flex; flex-direction: row; padding: 10px; ">
							<span style=""><?php echo $room_type->number_of_adults;?> <?php echo $this->lang->line('guests');?></span>
							<span style="padding: 0 10px 0 10px; ">|</span>
							<span><?php echo ($lang == 'english') ? $room_type->room_details_en : $room_type->room_details_th;?></span>
						</div>
						
						
						<!-- <div class="col-md-12">
							<div class="row">
								<div class="col-md-6 mb-4">
								<div class="row" style="">
								<div class="col-md-12"><div class="section_header "><?php echo $this->lang->line('features');?></div></div>
													
									<div class="col-md-12">
									<div class="container text-left">
									
									<div class="row">
									<div class="col-md-2 icon_container">
										<span class="icon-content"><object data="<?php echo share_folder_path();?>images/icons/house.svg" height="20"></object></span> 
									</div>
									<div class="col-md-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? $rt->area_en : $rt->area_th; ?></span>
									</div>
									</div>

									<div class="row">
									<div class="col-md-2 col-sm-2 icon_container" >
										<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo share_folder_path();?>images/icons/icons8-bedroom-50.png" height="18"></span>
									</div>
									<div class="col-md-9 col-sm-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? $rt->room_details_en : $rt->room_details_th; ?></span>
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
										<span class="icon-content"><object data="<?php echo share_folder_path();?>images/icons/snow.svg" height="20"> </object></span>
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
								
								<div class="col-md-6">
								<div class="row" style="">
								<div class="col-md-12"><div class="section_header "><?php echo $this->lang->line('amenities');?></div></div>
																	
										<?php foreach ($room_amenities as $f) { ?>
										<div class="col-md-6">		
										<div class="container text-left">
										<div class="row">
										<div class="col-md-2 col-sm-2 icon_container" >
											<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo share_folder_path().$f->icon;?>" height="20"></span>
										</div>
										<div class="col-md-9 col-sm-9 icon_container">
											<span class="icon-content"><?php echo $lang == 'english' ? $f->desc_en : $f->desc_th; ?></span>
										</div>
										</div>	
										</div>
										</div>												
										<?php }?>
									
								</div>
								</div>
								

								<div class="col-md-6">
									<div class="section_header "><?php echo $this->lang->line('locations_nearby');?></div>
									<div class="row mb2">			
						
											<div class="col-md-12">		
												<div class="table-responsive">
												<table class="table table-bordered" >
												<tr>
												<th><?php echo $this->lang->line('location');?></th>
												<th><?php echo $this->lang->line('distance');?>(km)</th>
												</tr>
												<?php foreach ($locations_nearby as $l) {?>
													<tr>
														<td><?php echo ($lang == 'english') ? $l->location_name_en : $l->location_name_th;?></td>
														<td style="text-align: center;"><?php echo $l->distance_km;?></td>
													</tr>
												<?php }?>  
												</table>  
												</div>		
											</div>
						
									</div>
								</div>

							</div>
						
						</div> 
					</div>-->		
				</div>

				</div>										
			</div>
			<div class="col-md-5 mt-2">
				<div class="col-md-12 p-0 ">
				<!--<div class="row mb-4 ml-4 mt-2" style="width: 100%; border: 1px solid #81BB4A; border-radius: 10px; ">-->
				<div class="row mb-4 ml-0 mt-2" style="width: 100%; border: 1px solid #CCC; border-radius: 10px; ">
				<!-- <div class="row mb-4" style="width: 100%;"> -->
					<div class="col-md-12" style="font-size: 1.2em; font-weight: bold; text-align: center; width: 80%;">
					
					
					</div>
					
					<div class="col-md-12" style="display: flex; flex-direction: row; padding: 10px; font-size: 14px;">
						<div class="group ml-0 pr-2">
							<label for="name" class="mb-0"><?php echo $this->lang->line('check_in_date');?></label>
							<input type='text' class=" datepicker" name="check_in_date" id="check_in_date" value="<?php echo $check_in_date;?>"/>
						</div>
						<div class="group ml-0 pr-1">
							<label for="name" class="mb-0"><?php echo $this->lang->line('check_out_date');?></label>
							<input type='text' class=" datepicker" name="chec_out_date" id="check_out_date" value="<?php echo $check_out_date;?>"/>
						</div>
					</div>
					
					
					<div class="col-md-12 mb-3" style="font-size: 14px;">
						<div class="dropdown" >
							<button class="btn dropdown-toggle w-100 search_input btn-adults" style="width: 100%; border-radius: 4px; border-color: #CCC !important;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span id="div_adult" style="color: #000 !important;"><?php echo $num_of_adult;?></span> <?php echo $this->lang->line('adults');?>, 
								<span id="div_children" style="color: #000 !important;"><?php echo $num_of_children;?></span> <?php echo $this->lang->line('children');?>, 
								<span id="div_room" style="color: #000 !important;"><?php echo $num_of_room;?></span> <?php echo $this->lang->line('rooms');?>
							</button>
							<div class="dropdown-menu" style="vertical-align: bottom; background: white; z-index: 1;" aria-labelledby="dropdownMenuButton">
									<div class="stepper">
									<div style="display: flex; justify-content: center;"><?php echo $this->lang->line('adult');?></div>
									<div style="display: flex; justify-content: center;  ">							    
									<button class="btn_stepper " id="decrement-adult" onClick="stepper(this);"> - </button>
									<input class="input_number" type="number" min="0" max="<?php echo $room_type->number_of_adults;?>" step="1" value="<?php echo $num_of_adult;?>" id ="adult" readonly>
									<button class="btn_stepper " id="increment-adult" onClick="stepper(this);" datat-min="0" data-max="<?php echo $room_type->number_of_adults;?>"> + </button>
									</div>
									<div class="rounded hr3 mt-2 mb-2"></div>
									<div style="display: flex; justify-content: center;"><?php echo $this->lang->line('children');?></div>
									<div style="display: flex; justify-content: center; background-color: ">							    
									<button class="btn_stepper " id="decrement-children" onClick="stepper(this);"> - </button>
									<input class="input_number" type="number" min="0" max="100" step="1" value="<?php echo $num_of_children;?>" id ="children" readonly>
									<button class="btn_stepper " id="increment-children" onClick="stepper(this);"> + </button>
									</div>
									
								<div class="kids_age">
									<div class="col-md-12">
										<div class="row div_kids_age">
										<?php 
										if ( $num_of_children > 0 ) {
										$c_ages = explode(',', $children_ages);
										
										foreach ($c_ages as $age) {
										?>
										<div class="col-md-3" style="padding: 1px;">
										<label>Age</label>
										<select class="form-control select_age" name="select_age[]">
										<?php 
										$max_age = app_settings('max_children_age');
										$option_ct = 0;
										do{?>
										<option value="<?php echo $option_ct;?>" <?php echo ($option_ct == $age) ? 'selected' : '';?>><?php echo $option_ct;?></option>
										<?php 
										$option_ct++;
										} while($option_ct <= $max_age);?>
										</select></div>
										<?php 
										}
										}
										?>
										</div>
									</div>
									</div> <!-- Kids Age -->
								<div class="rounded hr3 mt-2"></div>
									
									<div style="display: flex; justify-content: center;"><?php echo $this->lang->line('rooms');?></div>
									<div style="display: flex; justify-content: center;  box-shadow: 0 20px 30px rgba(0,0,0,0.1)">							    
									<button class="btn_stepper " id="decrement-room" onClick="stepper(this);"> - </button>
									<input class="input_number" type="number" min="0" max="100" step="1" value="1" id ="room" readonly>
									<button class="btn_stepper " id="increment-room" onClick="stepper(this);"> + </button>							  							   
									</div>

									<!--<div style="display: flex; justify-content: center; padding: 5px; font-size: 0.8em; background-color: #F8F8F9;">-->
									<div class="mt-2 mb-0" style="display: flex; justify-content: center; padding: 8px; font-size: 0.8em; backdrop-filter: blur(10px); background-color: rgb(189 219 251 / 45%) !important;">
									<?php if ($lang == 'english') {?>
									Please be informed that the maximum age for children is <?php echo app_settings('max_children_age');?> 
									years old. Kindly add children aged more than <?php echo app_settings('max_children_age');?> years as adult.
									<?php }
									else {
									?>
										เด็กที่จะเข้าพักในโครงการจะต้องเลือกเข้าพักเป็นผู้ใหญ่เท่านั้น
									<?php } ?>
									</div>
								</div>
							</div>
							</div>
						
						<div class="rounded hr3 mt-2 mb-3"></div>
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
									<tr>
										<td><?php echo $rt->room_type_name_en;?></td>
										<td class="unit_price text-right"><?php echo number_format($rate, 2);?></td>					         		
										<td class="number_of_nights text-right">1</td>
										<td class="item_amount text-right"><?php echo number_format($rate, 2);?></td>
									</tr>
									<tr>
										<td colspan="3"><span id="total" style="font-weight: bold;" ><?php echo $this->lang->line('total_amount');?></span></td>
										<td class="item_amount text-right"><?php echo number_format($rate, 2);?></td>
									</tr>
								</tbody>	
								</table>
								<div style="margin: auto; font-size: 1em; text-align:right; margin-right: 5px;"><em>(<?php echo $this->lang->line('vary_price');?>)</em></div>
								</div>
							</div>
						</div>
						
						<div class="row mt-3 mb-2">
							<!-- 
							<div class="col-md-6" style="font-weight: bold;">
								<span class="rate"><?php echo number_format($rate);?></span><span style="padding: 0 5px 0 5px;">x</span><span id="num_of_night">1</span>&nbsp;Night
							</div>
							<div class="col-md-6" style="font-weight: bold; text-align: right;">
								<span class="total_rate"><?php echo number_format($rate*1);?></span>
							</div>
							
							<div class="col-md-6 mt-3" style="font-weight: bold;">
								<span class="">Total</span>
							</div>
							<div class="col-md-6 mt-3" style="font-weight: bold; text-align: right;">
								<span class="grand_total"><?php echo number_format($rate*1);?></span>
							</div>
							-->
						</div>
							
						
					</div>
								
				</div>
						<div class="row mt-3 ml-0">	
							<div class="col-md-6 mb-2 text-right" > 
								<button class="btn button-primary-w form-control add_to_cart btn-add_to_cart" data-id="<?php echo $rt->id_room_type;?>" data-price="<?php echo $rt->default_rate;?>" id="add_to_cart"><?php //echo $this->lang->line('add_to_cart');?><?php echo $lang == "english" ? 'ADD TO CART' : 'เก็บใส่ตะกร้า'; ?></button>
							</div>
							<div class="col-md-6 mb-2 text-left"> 
								<button class="btn button-primary form-control book_now" id="book_now"><?php //echo $this->lang->line('book_now');?><?php echo $lang == "english" ? 'BOOK NOW' : 'จองตอนนี้'; ?></button>

							</div>
						</div>
				</div>
				<div id="room_available" class="col-md-12 section_header" style="display: flex; flex-direction: row; padding: 10px; font-size: 14px; color: #a6a6a6; justify-content: flex-end;">
							<span style=""><?php echo $lang == "english" ? 'There is a room that is not available on the date selected.' : 'ห้องพักนี้ไม่ว่างในวันที่คุณเลือก'; ?></span>
				</div>
			</div>
		</div>
	</div>		
  </div>


<form name="frm_book" id="frm_book" method="post" action="<?php echo site_url('booking').'/guest_info';?>"> 
<input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="<?php echo $num_of_adult;?>">
<input type="hidden" name="h_num_of_room" id="h_num_of_room" value="<?php echo $num_of_room;?>">
<input type="hidden" name="h_id_room" id="h_id_room" value="<?php echo $room_type->id_room_type.':'.$rate;?>">
<input type="hidden" name="h_rate" id="h_rate" value="<?php echo $rate;?>">
<input type="hidden" name="h_num_of_children" id="h_num_of_children" value="<?php echo $num_of_children;?>">
<input type="hidden" name="h_children_ages" id="h_children_ages" value="<?php echo $children_ages;?>">
<input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
<input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">
<input type="hidden" name="page" id="page" value="room_details">
</form>

</main>



<!-- Modal Project -->
<div class="container text-center">
<div class="modal fade" id="ModalCarousel" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

 <!-- Sliding images statring here --> 
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <?php 
    $ctr = 1;
    foreach ($room_type_photos as $h) {
    ?>
    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $ctr-1;?>" class="slide "<?php echo $ctr;?>"></li>
    <?php 
    $ctr++;
    }
    ?>
    
  </ol>
  <div class="carousel-inner">
  	<?php 
    $ctr = 1;
    foreach ($room_type_photos as $h) {
    ?>
    <div class="carousel-item <?php echo $ctr;?> active" >
      <img class="d-block w-100" src="<?php echo share_folder_path().$h;?>" alt="slide <?php echo $ctr;?>">
    </div>
    <?php 
    $ctr++;
    }
    ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  
</div>
    </div>
  </div>
</div>
</div>


<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>

<!-- /////////////////////////////////////////////////// -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>

function stepper(dis) {
	let btn_id = dis.getAttribute('id');
	let max = dis.getAttribute('max');
	let data_max = dis.getAttribute('data-max');
	console.log(max)
	
	const myArray = btn_id.split("-");
	var myInput = myArray[1];
	let min = $('#'+myInput).val();
	
	var newval = ( myArray[0] == 'increment' ) ? (parseInt(min)+1) : (parseInt(min)-1);
	newval = (newval < 0) ? 0 : newval;
	// Revise this to add max
	$('#'+myInput).val(newval);
	$('#div_'+myInput).html(newval);
	/*if (newval < data_max) {
		$('#'+myInput).val(newval);
		$('#div_'+myInput).html(newval);
	}
	else {
		alert("Maximum for this is "+data_max);
	}*/
	//console.log(newval);
	if (btn_id == 'increment-children') {
		$('.div_kids_age').html('');
		var new_html = '';
		if (newval > 0) {
			for (var x=0; x < newval; x++) {
				max_age = '<?php echo app_settings('max_children_age');?>';
				var option_ct = 1;
				new_html += '<div class="col-md-3" style="padding: 1px;">'
						+ '<label>Age</label>'
						+ '<select class="form-control select_age" name="select_age[]">'
						+ '<option value="0">0</option>';
				do {
					new_html += '<option value="'+option_ct+'">'+option_ct+'</option>';
					option_ct++;
				} while(option_ct <= max_age);		
				new_html += '</select></div>';
			}
				
		}
		//console.log(new_html);
		$('.div_kids_age').html(new_html);
	}
	
	if (btn_id == 'decrement-children') {		
		var new_html = '';
		if (newval > 0) {
			for (var x=0; x < newval; x++) {
				max_age = '<?php echo app_settings('max_children_age');?>';
				var option_ct = 1;
				new_html += '<div class="col-md-3" style="padding: 1px;">'
						+ '<label>Age</label>'
						+ '<select class="form-control select_age" name="select_age[]">'
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


	$(function(){		
		var today = new Date();
        var tomorrow = new Date(today);
        tomorrow.setDate(today.getDate()+1);
        tomorrow.toLocaleDateString();
        var today_date = ('0' + today.getDate()).slice(-2) + '-'
        + ('0' + (today.getMonth()+1)).slice(-2) + '-'
        + today.getFullYear();         

        
		var tomorow_date = ('0' + tomorrow.getDate()).slice(-2) + '-'
         + ('0' + (tomorrow.getMonth()+1)).slice(-2) + '-'
         + tomorrow.getFullYear();         
		if ($("#check_in_date").val() == '') {		
			$("#check_in_date").val(today_date);
			$("#check_out_date").val(tomorow_date);
			
		}
		if ($('#div_adult').html() == '') {
			$('#div_adult').html(2);
			$('#div_children').html(0);
			$('#div_room').html(1);
		}
		$("#h_check_in_date").val($('#check_in_date').val());
		$("#h_check_out_date").val($('#check_out_date').val());

		$('#check_in_date').datepicker({
		    format: 'dd-mm-yyyy',
			changeMonth: true,
			changeYear: true,
			startDate: new Date(), // = today
			autoclose: true
		}).on('changeDate', function(e) {
		        var in_date = $(this).val();
				check_in_date = in_date.split("-");

		        //var d = new Date(check_in_date[2], parseInt(check_in_date[1])-1, check_in_date[0]);
		        var today = new Date(check_in_date[2], parseInt(check_in_date[1])-1, check_in_date[0]);
		        var tomorrow = new Date(today);
		        tomorrow.setDate(today.getDate()+1);
		        tomorrow.toLocaleDateString();
				var tomorow_date = ('0' + tomorrow.getDate()).slice(-2) + '-'
	             + ('0' + (tomorrow.getMonth()+1)).slice(-2) + '-'
	             + tomorrow.getFullYear();         
				$("#check_out_date").val(tomorow_date);
				change_date_calc();
				check_room();
		});

		$('#check_out_date').datepicker({
		    format: 'dd-mm-yyyy',
		    changeMonth: true,
		    changeYear: true,
		    startDate: new Date(), // = today
		    onSelect: function(dateText, inst) {
		    	change_date_calc();
		    	check_room();
		    }
		}).val();

		function check_room() {
			var id_room = "<?php echo $room_type->id_room_type;?>";
			var rooms_to_check = [];
			rooms_to_check.push(id_room);

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
	       .done(function(res) {
	       		var obj = eval('('+res+')');
	       		// alert('done'+obj.length);
	    	   	if(obj.length > 0) {
	    	   		$('#room_available').show();
	    	   	}else{
	    	   		$('#room_available').hide();
	    	   	}
	       });
		}

		check_room();

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

		
		$('#book_now').click(function() {
			var id_room = "<?php echo $room_type->id_room_type;;?>";
			//console.log("Room"+id_room);
			var rooms_to_check = [];
			rooms_to_check.push(id_room);
			
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
	    	   		var lang = '<?php echo $lang; ?>';
	    	   		if(lang == 'english'){
						alert ("There is a room that is not available on the date selected");
					}else{
						alert ("ห้องพักนี้ไม่ว่างในวันที่คุณเลือก");
					}
			   }
		       else {
		    	   //rooms.push(id_room+':'+room_rate);
		    	   //$('#h_id_room').val(rooms.toString());
		    	   $('#h_num_of_adult').val($('#div_adult').text());
				   $('#h_num_of_room').val($('#div_room').text());
				   $('#h_num_of_children').val($('#div_children').text());
					var children_ages = [];
					var ages = document.getElementsByClassName("select_age");
					if (ages.length > 0) {
						for (var i = 0; i < ages.length; i++) {
							//console.log(ages[i].value);
							children_ages.push(ages[i].value);
						}
					}
					else {
						children_ages.push(0);
					}
					$('#h_children_ages').val(children_ages.toString());
					$('#h_check_in_date').val($('#check_in_date').val());
					$('#h_check_out_date').val($('#check_out_date').val());
					$('#frm_book').submit();
		       }
	    	   
	       });

			
		});

	
		/////
		var cart_count = $('.button__badge').text();
		$('.add_to_cart').click(function() {
			var id_room_type = $(this).attr('data-id');
			var room_rate = $(this).attr('data-price');
			//alert(id_room_type)
			var _url = "<?php echo site_url('cart/add_to_cart');?>";
			
	        $.ajax({
	               method: "POST",
	               url: _url,
	               data: {
	                   'id_room_type': id_room_type,
	                   'room_rate': room_rate               
	               }
	       })
	       .done(function( res ) {
	    	   	var obj = eval('('+res+')');			
				alert(obj.message);
				$('.button__badge').text(obj.count);	 
	       });
		});

		change_date_calc();

		function change_date_calc() {
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
			var id_room_type = "<?php echo $rt->id_room_type;?>";
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
		         					+ '<td>'+room_type_name_en+'</td>'
		         					+ '<td class="unit_price text-right">'+number_add_comma_decimal(unit_price)+'</td>'
		         					+ '<td class="number_of_nights text-right">'+date_price[i].night_ctr+'</td>'
		         					+ '<td class="item_amount text-right">'+number_add_comma_decimal(item_total_price)+'</td>'
		         					+ '</tr>';
	 					total += parseFloat(date_price[i].item_total_price);
		 			}
		 			
				}
				markup += '<tr>'
         			+ '<td colspan="3"><span id="total" style="font-weight: bold;" ><?php echo $this->lang->line('total_amount');?></span></td>'
         			+ '<td class="item_amount text-right">'+number_add_comma_decimal(total)+'</td>'
         			+ '</tr>';
 				tableBody.append(markup);
	       });

	        $('#num_of_night').text(d_diff);
			var rate = $('#h_rate').val();
			var total_rate = d_diff*rate;
			$('.total_rate').text(number_add_comma_decimal(total_rate));
			$('.grand_total').text(number_add_comma_decimal(total_rate));
			$("#h_check_in_date").val($('#check_in_date').val());
			$("#h_check_out_date").val($('#check_out_date').val());
		}
	});
	sessionStorage.clear();
</script>

<br/><br/>
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