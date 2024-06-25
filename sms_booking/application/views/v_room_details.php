<?php $lang = $this->input->get('lang');
$CI =& get_instance();
$CI->load->model('m_room_type');
$rt = $room_type;
$date = date('Y-m-d');
$rate = $CI->m_room_type->get_day_rate ($rt->id_room_type, $date);
if ($rate == '') {
	$rate = $rt->default_rate;				
}
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
</style>

<?php 

?>

<main class="main-2">

  <section class="text-center container">
    
  </section>
  <div class="container-fluid" >
  	<div class="row">
  		<div class="col-md-12 price room_type_header"><?php echo $room_type->room_type_name_en;?></div>
  	</div>
  	<div class="row"> 
    	
    	<?php 
    	$first_photo = $room_type_photos[0];
    	
    	
    	?>
    	<div class="col-md-6 top-left-grid" style="text-align: right;">
    	<img class="myImg imgThumbnail_bg img_border" data-id="1" src="<?php echo site_url().$first_photo;?>" style="max-width: 100%;">
    	</div>
    	
    	
    	
    	
    	
    	<div class="col-md-6" style="padding-right: 30px;">
    		<div class="row">
    			<?php 
    			foreach ($room_type_photos as $key => $photo) {
    				//print_r($photo);
    			$ctr = $key + 1;
    			if ($key > 0 && $key < 5) {    	
    						
    			?>
    			<div class="col-md-6 top-right-grid">
    			<img class="myImg imgThumbnail_bg img_border" data-id="<?php echo $ctr;?>" src="<?php echo site_url().$photo;?>" style="max-width: 100%;">
    			</div>
    			<?php }
    			}
    			?>
    		</div>
    		
    		
    	</div>
    </div>


	
	<div class="row mx-auto mt-5 mb-5">
		<div class="col-md-8">
			<div class="col-md-12 section_header" style="display: flex; flex-direction: row; padding: 10px; ">
			<span style=""><?php echo $room_type->number_of_adults;?> Guests</span>
			<span style="padding: 0 10px 0 10px; ">|</span>
			<span><?php echo $room_type->room_details_en;?> Guests</span>
			</div>
			<hr>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6 mb-4">
					<div class="row" style="">
					<div class="col-md-12"><div class="section_header ">Features</div></div>
										
						<div class="col-md-12">
						
						
						<div class="container text-left">
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? $rt->area_en : $rt->area_th; ?></span>
						</div>
						</div>

						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container" >
							<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" height="18"></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? $rt->room_details_en : $rt->room_details_th; ?></span>
						</div>
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container" >
							<span class="icon-content" style="margin-left:1px;"><object data="<?php echo site_url();?>images/icons/person-fill.svg" height="18"></object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? $rt->number_of_adults.' Adults' : 'จำนวนผู้เข้าพัก: '.$rt->number_of_adults ;?></span>
						</div>		
						</div>
						
						<div class="row" >
						<div class="col-md-2 col-sm-2 icon_container">
							<object data="<?php echo site_url();?>images/icons/tv.svg" height="20"> </object>
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
							<span class="icon-content"><?php echo $lang == 'en' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
						</div>
						</div>
						
						<div class="row" >
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/wifi.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">Free WIFI</span>
						</div>						
						</div>
						<?php if ($rt->sofa_en != '') {?>
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="font-size:16px; margin-top:-2px;">
								<object data="<?php echo site_url();?>images/icons/sofa.png" height="14"></object>
							</span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? $rt->sofa_en : $rt->sofa_th; ?></span>
						</div>						
						</div>
						<?php }?>
						</div>
					</div>

					</div>
					</div>
					
					<div class="col-md-6">
					<div class="row" style="">
					<div class="col-md-12"><div class="section_header ">Amenities</div></div>
														
							<?php foreach ($room_amenities as $f) { ?>
							<div class="col-md-6">		
							<div class="container text-left">
							<div class="row">
							<div class="col-md-2 col-sm-2 icon_container" >
								<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo site_url().$f->icon;?>" height="20"></span>
							</div>
							<div class="col-md-9 col-sm-9 icon_container">
								<span class="icon-content"><?php echo $lang == 'en' ? $f->desc_en : $f->desc_th; ?></span>
							</div>
							</div>	
							</div>
							</div>												
							<?php }?>
						
					</div>
					</div>
					

					<div class="col-md-6">
						<div class="section_header ">Locations Nearby</div>
						<div class="row mb2">			
			
								<div class="col-md-12">		
									<div class="table-responsive">
			  						<table class="table table-bordered" >
									<tr>
									<th>Location</th>
					    			<th>Distance(km)</th>
					    			</tr>
					    			<?php foreach ($locations_nearby as $l) {?>
					    				<tr>
					    					<td><?php echo $l->location_name_en;?></td>
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
		</div>
	
		
		<div class="col-md-4 ">
			
			<div class="row mb-4" style="width: 100%; border: 1px solid #7F8C8D; border-radius: 10px; ">
				<div class="col-md-12 price mt-4" style="font-size: 1.2em; font-weight: bold; text-align: center; ">
				<span id="hdr_room_rate"><?php echo number_format($room_type->default_rate);?></span> per Night
				<div style="margin: auto; font-size: 0.8em;">(Price may vary depending on the date selected)</div>
				</div>
				
				<div class="col-md-12" style="display: flex; flex-direction: row; padding: 10px;">
					<div class="group">
					    <label for="name">Check-in Date</label>
					    <input type='text' class=" datepicker" name="check_in_date" id="check_in_date" value=""/>
					</div>
					<div class="group">
					    <label for="name">Check-out Date</label>
					    <input type='text' class=" datepicker" name="chec_out_date" id="check_out_date" value=""/>
					</div>
				</div>
				
				
				<div class="col-md-12 mb-3">
					<div class="dropdown" >
						  <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <span id="div_adult">2</span> Adults, <span id="div_children">0</span> Children, <span id="div_room">1</span> Rooms
						  </button>
						  <div class="dropdown-menu" style="vertical-align: bottom;" aria-labelledby="dropdownMenuButton">
							    <div class="stepper">
							    <div style="display: flex; justify-content: center;">Adult</div>
							    <div style="display: flex; justify-content: center; background-color: white; ">							    
							    <button class="btn_stepper " id="decrement-adult" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="2" id ="adult" readonly>
							    <button class="btn_stepper " id="increment-adult" onClick="stepper(this);"> + </button>
							    </div>
								<div class="rounded hr3 mt-2 mb-2"></div>
							    <div style="display: flex; justify-content: center;">Children</div>
							    <div style="display: flex; justify-content: center; background-color: ">							    
							    <button class="btn_stepper " id="decrement-children" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="0" id ="children" readonly>
							    <button class="btn_stepper " id="increment-children" onClick="stepper(this);"> + </button>
							    </div>
							    
							   <div class="kids_age">
							    <div class="col-md-12">
									<div class="row div_kids_age">
							    	
							    	</div>
							    </div>
							    </div> <!-- Kids Age -->
							   <div class="rounded hr3 mt-2"></div>
							    
							    <div style="display: flex; justify-content: center;">Rooms</div>
							    <div style="display: flex; justify-content: center; background-color: white; box-shadow: 0 20px 30px rgba(0,0,0,0.1)">							    
							    <button class="btn_stepper " id="decrement-room" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="1" id ="room" readonly>
							    <button class="btn_stepper " id="increment-room" onClick="stepper(this);"> + </button>
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
					         		<th>Item</th>
					         		<th class="unit_price text-right">Unit Price</th>
					         		<th class="number_of_nights text-right">Qty</th>
					         		<th class="item_amount text-right">Amount</th>
					         	</tr>
					         </thead>
					         <tbody>
					         	<tr>
					         		<td>Standard Room</td>
					         		<td class="unit_price text-right"><?php echo $rt->room_type_name_en;?></td>
					         		<td class="number_of_nights text-right">1</td>
					         		<td class="item_amount text-right"><?php echo $rate;?></td>
					         	</tr>
					         	<tr>
					         		<td colspan="3"><span id="total" style="font-weight: bold;" >Total</span></td>
					         		<td class="item_amount text-right"><?php echo $rate;?></td>
					         	</tr>
					         </tbody>	
					         </table>
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
						
					<div class="row mt-3">	
					<div class="col-md-6 mb-2 text-right" > 
						<button class="btn button-primary form-control" id="add_to_cart">Add to Cart</button>
					</div>
					<div class="col-md-6 mb-2 text-left"> 
						<button class="btn button-primary form-control" id="book_now">Book Now</button>
					</div>
					</div>
				</div>
				
				
			</div>
			
			
			
		</div>
		
		
		
	</div>
	
		
  </div>


<form name="frm_book" id="frm_book" method="post" action="<?php echo site_url('booking').'/guest_info';?>"> 
<input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="">
<input type="hidden" name="h_num_of_room" id="h_num_of_room" value="">
<input type="hidden" name="h_id_room" id="h_id_room" value="<?php echo $this->input->get('type').':'.$rate;?>">
<input type="hidden" name="h_rate" id="h_rate" value="<?php echo $rate;?>">
<input type="hidden" name="h_num_of_children" id="h_num_of_children" value="">
<input type="hidden" name="h_children_ages" id="h_children_ages" value="">
<input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
<input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">
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
      <img class="d-block w-100" src="<?php echo site_url().$h;?>" alt="slide <?php echo $ctr;?>">
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
<script>
const numFor = Intl.NumberFormat('en-US');


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
	//console.log(newval);
	if (btn_id == 'increment-children') {
		$('.div_kids_age').html('');
		var new_html = '';
		if (newval > 0) {
			for (var x=0; x < newval; x++) {
				max_age = 12;
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

	if (btn_id == 'increment-room' || btn_id == 'decrement-room') {		
		$('#h_room').val(newval);

		var rate = $('#h_rate').val();
		var total = newval * rate;
		//console.log(newval + ' ' + rate);
		$('#number_of_rooms').text(newval);
		
		$('.total_rate').text(numFor.format(total));
		$('.grand_total').text(numFor.format(total));
		//$('#total_rate').val(total);
	}
}

function date_diff (date1, date2) {	
	const diffTime = Math.abs(date2 - date1);
	const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
	console.log(diffTime + " milliseconds");
	console.log(diffDays + " days");
	return diffDays;
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
		$("#check_in_date").val(today_date);
		$("#check_out_date").val(tomorow_date);

		/*
		$('.datepicker').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date(), // = today
		    onSelect: function(dateText, inst) {
				
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

				
		    }
		  }).val();
		  */

		//$('.datepicker').on('focusout',focusHandler);
		
		$('#check_in_date').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date(), // = today
		    onSelect: function(dateText, inst) {
				
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

				var check_in_date = $("#check_in_date").val();
				var check_out_date = $("#check_out_date").val();
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
			       //console.log(res);
		 			var obj = eval('('+res+')');
		 			var obj_key = Object.values(obj);	 			
		 			$(".room_rates > tbody").html("");
		 			tableBody = $(".room_rates tbody");
		 			var markup = '';
		 			var room_name = "<?php echo $rt->room_type_name_en;?>";
					var total = 0;
		 			for (var i=0; i < obj_key.length; i++) {		    
			 			markup += '<tr>'
		         					+ '<td>'+room_name+'</td>'
		         					+ '<td class="unit_price text-right">'+obj_key[i].unit_price+'</td>'
		         					+ '<td class="number_of_nights text-right">'+obj_key[i].night_ctr+'</td>'
		         					+ '<td class="item_amount text-right">'+obj_key[i].item_total_price+'</td>'
		         					+ '</tr>';
	 					total += parseFloat(obj_key[i].item_total_price);
		 			}
		 			markup += '<tr>'
		         			+ '<td colspan="3"><span id="total" style="font-weight: bold;" >Total</span></td>'
		         			+ '<td class="item_amount text-right">'+total+'</td>'
		         			+ '</tr>';
		 			tableBody.append(markup);
	         		//$('#hdr_room_rate').text(numFor.format(obj_key[i].unit_price));
		       });
				
		    }
		  }).val();

		$('#check_out_date').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date(), // = today
		    onSelect: function(dateText, inst) {
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
	 			var obj_key = Object.values(obj);	 			
	 			$(".room_rates > tbody").html("");
	 			tableBody = $(".room_rates tbody");
	 			var markup = '';
	 			var room_name = "<?php echo $rt->room_type_name_en;?>";
				var total = 0;
	 			for (var i=0; i < obj_key.length; i++) {		    
		 			markup += '<tr>'
	         					+ '<td>'+room_name+'</td>'
	         					+ '<td class="unit_price text-right">'+obj_key[i].unit_price+'</td>'
	         					+ '<td class="number_of_nights text-right">'+obj_key[i].night_ctr+'</td>'
	         					+ '<td class="item_amount text-right">'+obj_key[i].item_total_price+'</td>'
	         					+ '</tr>';
 					total += parseFloat(obj_key[i].item_total_price);
	 			}
	 			markup += '<tr>'
	         			+ '<td colspan="3"><span id="total" style="font-weight: bold;" >Total</span></td>'
	         			+ '<td class="item_amount text-right">'+total+'</td>'
	         			+ '</tr>';
	 			tableBody.append(markup);
	 			//$('#hdr_room_rate').text(numFor.format(obj_key[i].unit_price));
	       });
			
			$('#num_of_night').text(d_diff);
			var rate = $('#h_rate').val();
			var total_rate = d_diff*rate;
			$('.total_rate').text(numFor.format(total_rate.toFixed(2)));
			$('.grand_total').text(numFor.format(total_rate.toFixed(2)));
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

		
	});
</script>
	
</body>
</html>

