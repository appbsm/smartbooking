<?php $lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI =& get_instance();
$CI->load->model('m_room_type');
//$rt = $room_type;
$date = date('Y-m-d');
//$rate = $CI->m_room_type->get_day_rate ($rt->id_room_type, $date);
/*if ($rate == '') {
	$rate = $rt->default_rate;				
}*/

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

.slideshow > div { 
  position: absolute; 
  display: flex;
  flex-direction: column;
  top: 10px; 
  left: 10px; 
  right: 10px; 
  bottom: 10px; 
}
</style>

<?php 

?>

<main class="main-2">
 
  	<div class="row">
  		<div class="col-md-12">
  			<ul class="breadcrumb">
			  <li><a href="<?php echo site_url();?>"><?php echo $this->lang->line('home');?></a></li>
			  <li><?php echo $this->lang->line('room_details');?></li>
			</ul>
  		</div>
  	</div>
 
	<div class="container-fluid text-center">
		<div class="row">
		<?php 
		
		$package_price = ($lang == 'english') ? number_format($package[0]->price,0).'/Night' : 'ราคา '.number_format($package[0]->price,0).'/คืน';
		?>
	  		<div class="col-md-12 price room_type_header"><?php echo ($lang == 'english') ? $package[0]->name : $package[0]->name;?> - <?php echo $package_price;?></div>
	  	</div>
	
		<div class="row" >
			<div class="col-md-12" style="margin-top:10px;">
				<span class="roomtypes"><?php echo $this->lang->line('room_types'); ?></span>
			</div>
			<?php 
			//print_r($room_types);
			//echo share_folder_path();
			$room_ctr = 0;
			$date = date('Y-m-d');
			foreach ($room_types as $key => $rt) {
				$room_type = $rt['room_type'];
				$photos = $rt['room_type_photos'];
				//print_r($photos);
				$rate = $CI->m_room_type->get_day_rate ($room_type->id_room_type, $date);
				if ($rate == '') {
					$rate = $rt->default_rate;				
				}
			?>

				<div class="col-md-6" style="padding:2px 17px 2px 17px;">
				<div class="row room_type" style="display: block;">
					
									
					<div class="col-md-12">
						<div class="room-type-name"><?php echo ($lang == 'english') ? $room_type->room_type_name_en : $room_type->room_type_name_th;?></div>
					</div>
					<div class="col-md-12">
						<div class="slideshow" id="slideshow-<?php echo $key;?>">
								<?php 
									foreach ($photos as $ctr1 => $photo){
								?>
								  <div>
								    <img class="room_img" data-ctr="<?php echo $ctr1;?>" src="<?php echo share_folder_path().$photo;?>" width="100%">
								  </div>
								<?php }?>
							</div>
					</div>
					
					<div class="col-md-12">
						<?php 
						$price = ($lang == 'english') ? number_format($room_type->default_rate,0).'/Night' : 'ราคา '.number_format($rate,0).'/คืน';
						?>
						<div class="price" ><b><?php echo $price;?></b></div>					
					</div>
					
					<div class="col-md-12" style="background-color: white;">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-sm-6">
						
								<div class="container">
								
									<div class="row mb-4">
										<div class="col-md-2 col-sm-2 text-left icon_container">
											<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
										</div>
										<div class="col-md-9 text-left col-sm-9 icon_container">
											<span class="icon-content"><?php echo $lang == 'english' ? $room_type->area_en : $room_type->area_th; ?></span>
										</div>
									</div>
			
									<div class="row mb-4">
										<div class="col-md-2 col-sm-2 text-left icon_container" >
											<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo share_folder_path();?>images/icons/icons8-bedroom-50.png" height="18"></span>
										</div>
										<div class="col-md-9 text-left col-sm-9 icon_container">
											<span class="icon-content"><?php echo $lang == 'english' ? $room_type->room_details_en : $room_type->room_details_th; ?></span>
										</div>
									</div>
			
									<div class="row mb-4">
										<div class="col-md-2 text-left col-sm-2 icon_container" >
											<span class="icon-content" style="margin-left:4px; margin-top:-1px;"><img class="icon" src="<?php echo share_folder_path();?>images/icons/bathroom.png" height="18"></span>
										</div>
										<div class="col-md-9 text-left col-sm-9 icon_container">
											<span class="icon-content"><?php echo $lang == 'english' ? $room_type->bathroom_en : $room_type->bathroom_th; ?></span>
										</div>
									</div>
									
									
											
								</div>				
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-6">
						
								<div class="container">
								
									<div class="row mb-4">
										<div class="col-md-2 text-left col-sm-2 icon_container" >
											<span class="icon-content" style="margin-left:1px;"><object data="<?php echo share_folder_path();?>images/icons/person-fill.svg" height="18"></object></span>
										</div>
										<div class="col-md-9 text-left col-sm-9 icon_container">
											<span class="icon-content"><?php echo $lang == 'english' ? $room_type->number_of_adults.' Adults' : 'จำนวนผู้เข้าพัก: '.$room_type->number_of_adults ;?></span>
										</div>		
									</div>
									
								<div class="row mb-4" >
									<div class="col-md-2 text-left col-sm-2 icon_container">
										<object data="<?php echo share_folder_path();?>images/icons/tv.svg" height="20"> </object>
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content">TV (Internet)</span>
									</div>						
								</div>
								
								<div class="row mb-4">
									<div class="col-md-2 text-left col-sm-2 icon_container">
										<span class="icon-content"><object data="<?php echo share_folder_path();?>images/icons/snow.svg" height="20"> </object></span>
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
									</div>
								</div>
									
			
									
											
								</div>				
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-6">
							<div class="container">
								
								
								
								
								<div class="row mb-4" >
									<div class="col-md-2 text-left col-sm-2 icon_container">
										<span class="icon-content"><object data="<?php echo share_folder_path();?>images/icons/wifi.svg" height="20"> </object></span>
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content">Free WIFI</span>
									</div>						
								</div>
								<?php if ($room_type->sofa_en != '') {?>
								<div class="row mb-4">
									<div class="col-md-2 text-left col-sm-2 icon_container">
										<span class="icon-content" style="font-size:16px; margin-top:-2px;">
											<object data="<?php echo share_folder_path();?>images/icons/sofa.png" height="14"></object>
										</span>
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? $room_type->sofa_en : $room_type->sofa_th; ?></span>
									</div>						
								</div>
								<?php }?>

				   			 </div>
						</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php 
			$room_ctr++;
			}?>
			
			<div class="col-md-12 col-sm-12 mb-2 text-center" > 
				<button class="btn button-primary add_to_cart" data-id="<?php echo $room_type->id_room_type;?>" data-price="<?php echo $room_type->default_rate;?>" id="" style="margin-right: 5px;"><?php echo $this->lang->line('add_to_cart');?></button>
				<a href="javascript:;" data-roomtype="<?php echo $room_type->id_room_type;?>" class="btn button-primary book_now" id="" style="margin-left: 5px;"><?php echo $this->lang->line('book_now');?></a>
			</div>
			
		</div>
  	</div>
	


<!-- 
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
 -->
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
				
				change_date_calc();
				
		    }
		  }).val();

		$('#check_out_date').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date(), // = today
		    onSelect: function(dateText, inst) {
		    	change_date_calc();
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
					alert ("There is a room that is not available on the date selected")
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

			$('.slideshow').each(function(i, obj) {
				$('#slideshow-'+i+' > div:gt(0)').hide();
				setInterval(function() { 
					  $('#slideshow-'+i+' > div:first')
					  .fadeOut(1000)
					  .next()
					  .fadeIn(1000)
					  .end()
					  .appendTo('#slideshow-'+i);
					}, 3000); // 3 seconds
			});
		}
	});
	sessionStorage.clear();
</script>

