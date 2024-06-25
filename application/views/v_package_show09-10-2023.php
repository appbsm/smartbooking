<?php 
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai'; 
$CI =& get_instance();
$CI->load->model('m_room_type');

?>

<style>


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

<main class="main-2 mt-4">
   
  <div class="container-fluid" >
  	<div class="row"> 
    	
    	<?php 
    	$first_photo = $project_photos[0];

    	?>
    	<div class="col-md-9 top-left-grid" style="text-align: right;">
    	<img class="myImg imgThumbnail_bg img_border" data-id="1" src="<?php echo share_folder_path().$first_photo->project_photo_url;?>" style="max-width: 100%;">
    	</div>

    	<div class="col-md-3" style="padding-right: 30px;">
    		
    			<?php 
    			foreach ($project_photos as $key => $photo) {
    			$ctr = $key + 1;
    			if ($key > 0 && $key < 4) {    	
    						
    			?>
				<div class="row">
    			<div class="col-md-12 mb-1 top-right-grid">
    			<img class="myImg imgThumbnail_bg img_border" data-id="<?php echo $ctr;?>" src="<?php echo share_folder_path().$photo->project_photo_url;?>" style="max-width: 100%;">
    			</div>
				</div>
    			<?php }
    			}
    			?>
    		
    		
    		
    	</div>

    	<!-- <div class="col-md-12 text-center mt-3 mb-3">
    		<a href="<?php echo site_url('project_info');?>" class="btn button-primary" id=""><?php echo $this->lang->line('project_info_details');?></a>
    	</div> -->

    </div>


	<div><hr></div>


	<!-- Room package			 -->
	<div class="container">
		<?php 
		
		if (isset($package)) {
		$line_ctr = 0;
		//foreach ($package as $pr) {
		$pr = $package[0];	
		$package_price = ($lang == 'english') ? number_format($pr->price,0).'/Night' : 'ราคา '.number_format($pr->price,0).'/คืน';
		?>

		<div class="row">
			<div class="col-md-12 mb-3" style="display: flex; flex-direction: row;">
						<div class="group">
							<label for="name"><?php echo $this->lang->line('check_in_date');?></label>
							<input type='text' class=" datepicker search_input" name="check_in_date" id="check_in_date" value=""/>
						</div>
						<div class="group">
							<label for="name"><?php echo $this->lang->line('check_out_date');?></label>
							<input type='text' class=" datepicker search_input" name="check_out_date" id="check_out_date" value=""/>
						</div>
					</div>
			<div class="col-md-12">
				<div class="row mb-2">
					<div class="col-md-12 pt-2 price room_type_header text-center p-2">
						<h6><?php echo ($lang == 'english') ? $pr->name : $pr->name;?> - <?php echo $package_price;?></h6>
					</div>
				</div>
				<div class="row">

				<?php 
				//print_r($room_types);
				//echo share_folder_path();
				$room_ctr = 0;
				$date = date('Y-m-d');
				foreach ($room_types as $key => $rt) {
					//print_r($rt);
					$room_type = $rt['room_type'];
					$photos = $CI->m_room_type->get_room_type_photos($room_type->id_room_type);
					//print_r($photos);
					$rate = $CI->m_room_type->get_day_rate ($room_type->id_room_type, $date);
					if ($rate == '') {
						$rate = $rt->default_rate;				
					}
					
				?>
					<div class="col-md-6">
						<div class="row">
							<div class="col-12">
								<h6><?php echo ($lang == 'english') ? $room_type->room_type_name_en : $room_type->room_type_name_th;?></h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-7">
								
								<div class="slideshow" id="slideshow-<?php echo $line_ctr;?>">
									<?php 
										foreach ($photos as $ctr1 => $photo){
									?>
										<div>
										<!-- <img class="room_img" data-ctr="<?php echo $ctr1;?>" src="<?php echo share_folder_path().$photo->room_photo_url;?>" width="100%"> -->
										<img class="room_img" data-ctr="<?php echo $ctr1;?>" data-type="<?php echo $room_type->id_room_type;?>" src="<?php echo share_folder_path().$photo->room_photo_url;?>" width="100%">
										</div>
									<?php }?>
								</div>



							</div>
							
							
							
							<div class="col-md-5">
								<div class="row">
								<div class="mob_space"></div>
									<!-- <div class="col-12">						
										<?php 
										$price = ($lang == 'english') ? number_format($room_type->default_rate,0).'/Night' : 'ราคา '.number_format($room_type->default_rate,0).'/คืน';
										?>
										<div class="price text-right pr-2"><del><b><?php echo $price;?></b><del></div>
									</div> -->
								</div>
								
								<div class="row">
									<div class="col-12">
										
										<div class="row">
											<div class="col-2 text-left icon_container">
												<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
											</div>
											<div class="col-9 text-left icon_container">
												<span class="icon-content"><?php echo $lang == 'english' ? $room_type->area_en : $room_type->area_th; ?></span>
											</div>
										</div>
				
										<div class="row">
											<div class="col-2 text-left icon_container" >
												<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><object data="<?php echo share_folder_path();?>images/icons/icons8-bedroom-50.png" height="18"></object></span>
											</div>
											<div class="col-9 text-left icon_container">
												<span class="icon-content"><?php echo $lang == 'english' ? $room_type->room_details_en : $room_type->room_details_th; ?></span>
											</div>
										</div>
				
										<div class="row">
											<div class="col-2 text-left icon_container" >
												<span class="icon-content" style="margin-left:4px; margin-top:-1px;"><object data="<?php echo share_folder_path();?>images/icons/bathroom.png" height="18"></object></span>
											</div>
											<div class="col-9 text-left icon_container">
												<span class="icon-content"><?php echo $lang == 'english' ? $room_type->bathroom_en : $room_type->bathroom_th; ?></span>
											</div>
										</div>

										<div class="row">
											<div class="col-2 text-left icon_container" >
												<span class="icon-content" style="margin-left:1px;"><object data="<?php echo share_folder_path();?>images/icons/person-fill.svg" height="18"></object></span>
											</div>
											<div class="col-9 text-left icon_container">
												<span class="icon-content"><?php echo $lang == 'english' ? $room_type->number_of_adults.' Adults' : 'จำนวนผู้เข้าพัก: '.$room_type->number_of_adults ;?></span>
											</div>		
										</div>

										<div class="row" >
											<div class="col-2 text-left icon_container">
												<object data="<?php echo share_folder_path();?>images/icons/tv.svg" height="20"> </object>
											</div>
											<div class="col-9 text-left icon_container">
												<span class="icon-content">TV (Internet)</span>
											</div>						
										</div>
										
										<div class="row">
											<div class="col-2 text-left icon_container">
												<span class="icon-content"><object data="<?php echo share_folder_path();?>images/icons/snow.svg" height="20"> </object></span>
											</div>
											<div class="col-9 text-left icon_container">
												<span class="icon-content"><?php echo $lang == 'english' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
											</div>
										</div>
									
									
										<div class="row" >
											<div class="col-2 text-left icon_container">
												<span class="icon-content"><object data="<?php echo share_folder_path();?>images/icons/wifi.svg" height="20"> </object></span>
											</div>
											<div class="col-9 text-left icon_container">
												<span class="icon-content">Free WIFI</span>
											</div>						
										</div>
										<?php if ($room_type->sofa_en != '') {?>
										<div class="row">
											<div class="col-2 text-left icon_container">
												<span class="icon-content" style="font-size:16px; margin-top:-2px;">
													<object data="<?php echo share_folder_path();?>images/icons/sofa.png" height="14"></object>
												</span>
											</div>
											<div class="col-9 text-left icon_container">
												<span class="icon-content"><?php echo $lang == 'english' ? $room_type->sofa_en : $room_type->sofa_th; ?></span>
											</div>						
										</div>
									<?php }?>

									</div>
								</div>
							</div>
						</div>
					</div>
				<?php 
					$line_ctr++;
					$room_ctr++;
				}?>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 mb-2 text-center" > 
						<button class="btn button-primary-w add_to_cart" data-id="<?php echo $pr->id_package;?>" data-price="<?php echo $pr->price;?>" id="" style="margin-right: 5px;"><?php echo $this->lang->line('add_to_cart');?></button>
						<a href="javascript:;" data-package="<?php echo $pr->id_package;?>" data-price="<?php echo $pr->price;?>" class="btn button-primary book_now" id="" style="margin-left: 5px;"><?php echo $this->lang->line('book_now');?></a>
					</div>
				</div>		
			</div>
		</div>

		<?php 
		}
		//}// END OF foreach package
		?>

	</div>
	<!-- end Room package			 -->

</main>

<form name="frm_room" id="frm_room" method="post" action="<?php echo site_url('booking/guest_info');?>">
	<input type="hidden" name="h_id_package" id="h_id_package" value="">
	<input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="">
	<input type="hidden" name="h_num_of_children" id="h_num_of_children" value="">
	<input type="hidden" name="h_children_ages" id="h_children_ages" value="">
	<input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
	<input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">
</form>


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
    foreach ($project_photos as $h) {
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
    foreach ($project_photos as $h) {
    ?>
    <div class="carousel-item <?php echo $ctr;?> active" >
      <img class="d-block w-100" src="<?php echo share_folder_path().$h->project_photo_url;?>" alt="slide <?php echo $ctr;?>">
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
<?php /*foreach ($types_photos as $key => $tp) {?>
<input type="hidden" name="hiddentype_<?php echo $key?>" id="hiddentype_<?php echo $key?>" value='<?php echo json_encode($tp);?>' />
<?php }*/?>


<!-- Modal Rooms -->
<div class="container text-center">
<div class="modal fade" id="ModalRoomCarousel" tabindex="-1" role="dialog" aria-labelledby="ModalRoomCarouselLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

 <!-- Sliding images statring here --> 
  <div id="carouselRoomExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    
  </ol>
  
  <div class="carousel-inner" id="carousel_inner_room">
  	
  </div>
  <a class="carousel-control-prev" href="#carouselRoomExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href=#carouselRoomExampleIndicators role="button" data-slide="next">
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
				max_age = '<?php echo app_settings('max_children_age');?>';
				var option_ct = 1;
				new_html += '<div class="col-md-3" style="padding: 1px;">'
						+ '<label><?php echo $this->lang->line('ages');?></label>'
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
						+ '<label><?php echo $this->lang->line('ages');?></label>'
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
		
		$('.total_rate').text(numFor.format(total));
		$('.grand_total').text(numFor.format(total));
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
		$("#check_in_date").val(today_date);
		$("#check_out_date").val(tomorow_date);
		
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
				$("#h_check_in_date").val($('#check_in_date').val());
				$("#h_check_out_date").val($('#check_out_date').val());
		    }
		  }).val();

		$('#check_out_date').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date(), // = today		
		    onSelect: function(dateText, inst) {
		    	$("#h_check_in_date").val($('#check_in_date').val());
				$("#h_check_out_date").val($('#check_out_date').val());
		    }   
		  }).val();
		
		$("#h_check_in_date").val($('#check_in_date').val());
		$("#h_check_out_date").val($('#check_out_date').val());
		/*
		if ($("#check_in_date").val() == '' && $("#check_out_date").val()) {
			$('.search_button').prop('disabled', true);
		}
		else {
			$('.search_button').prop('disabled', false);
			$("#h_check_in_date").val($('#check_in_date').val());
			$("#h_check_out_date").val($('#check_out_date').val());
		}
		*/
		
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
				$("#h_check_in_date").val($('#check_in_date').val());
				$("#h_check_out_date").val($('#check_out_date').val());
		    }
		  }).val();

		$('#check_out_date').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date(), // = today		
		    onSelect: function(dateText, inst) {
		    	$("#h_check_in_date").val($('#check_in_date').val());
				$("#h_check_out_date").val($('#check_out_date').val());
		    }   
		  }).val();

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

		$(".room_img").on('click', function(e){
			var mymodal = document.getElementById("ModalRoomCarousel");
			var self = $(this);
			var id_room_type = self.attr('data-type');
			var _url = "<?php echo site_url('room_details/get_room_photos');?>";
			$.ajax({
				method: 'POST',
				url: _url,
				data: {
					'id_room_type': id_room_type 
				} 
			})
			.done(function(res){
				var obj = eval('('+res+')');
				//console.log(obj);
				arr_photos = obj;
				var ol = '';
				var inner_room = '';
				photo_ctr = 0;
				for (var x=0; x < arr_photos.length; x++) {
					var i = x+1;
					var active = (x == photo_ctr) ? 'active' : '';
					//console.log(arr_photos[x]);
					var url = "<?php echo share_folder_path();?>" + arr_photos[x];
					var li = '<li data-target="#carouselRoomExampleIntors" datdicaa-slide-to="'+x+'" class="slide '+i+'"></li>';
						 
					var room = '<div class="carousel-item '+x+' '+active+'">'
				             + '<img class="d-block w-100" src="'+url+'" alt="slide '+i+'">'
				    		 + '</div>';
				   
				    ol += li;	 
		    		inner_room += room;
				}
				
				$('#carouselRoomExampleIndicators > ol').html(ol);
				$('#carousel_inner_room').html(inner_room); 
				$('#ModalRoomCarousel').carousel();	
				$('#ModalRoomCarousel').modal('show');
			});
			
			//console.log(type);
			/*var name = self.data('name'); // or src = self.attr('src');
			var src = self.attr('src');
			var photo_ctr = self.attr('data-ctr');
			//console.log(mymodal);
			var arr_photos = [];
			
			var arr_type = "hiddentype_"+type;
			//console.log(arr_type);
			ar_photos = $('#'+arr_type).val();
			arr_photos = JSON.parse(ar_photos);
			//console.log(arr_photos);
			var ol = '';
			var inner_room = '';
			
			for (var x=0; x < arr_photos.length; x++) {
				var i = x+1;
				var active = (x == photo_ctr) ? 'active' : '';
				//console.log(arr_photos[x]);
				var url = "<?php echo share_folder_path();?>" + arr_photos[x];
				var li = '<li data-target="#carouselRoomExampleIntors" datdicaa-slide-to="'+x+'" class="slide '+i+'"></li>';
					 
				var room = '<div class="carousel-item '+x+' '+active+'">'
			             + '<img class="d-block w-100" src="'+url+'" alt="slide '+i+'">'
			    		 + '</div>';
			   
			    ol += li;	 
	    		inner_room += room;
			}
			
			$('#carouselRoomExampleIndicators > ol').html(ol);
			$('#carousel_inner_room').html(inner_room); 
			$('#ModalRoomCarousel').carousel();	
			$('#ModalRoomCarousel').modal('show');
			*/
			//console.log(ol);	
			//console.log(inner_room);	
			//$('#ModalRoomCarousel').show();					
			
			
		});

		$('.dropdown-menu').on('click', function(event){
		    // The event won't be propagated up to the document NODE and 
		    // therefore delegated events won't be fired
		    event.stopPropagation();
		});

		var cart_count = $('.button__badge').text();
		$('.add_to_cart').click(function() {			
			var id_package = $(this).attr('data-id');
			var room_rate = $(this).attr('data-price');
			
			//alert(id_package)
			var _url = "<?php echo site_url('cart/add_to_cart');?>";
			
	        $.ajax({
	               method: "POST",
	               url: _url,
	               data: {
	            	   'id_package': id_package,
	                   'room_rate': room_rate               
	               }
	       })
	       .done(function( res ) {
	 			var obj = eval('('+res+')');
	 			console.log(obj);		
				alert(obj.message);
				$('.button__badge').text(obj.count);	 
	       });
		       
		});

		$('.search_button').click(function(e){
			e.preventDefault();
		    //return false;
		    $('#search_type').val($(this).attr('data-search-type'));
			//$('#s_id_room_type').val($(this).attr('data-roomtype'));
			$('#s_check_in_date').val($('#check_in_date').val());
			$('#s_check_out_date').val($('#check_out_date').val());
			$('#s_num_of_adult').val($('#div_adult').text());
			$('#s_num_of_room').val($('#div_room').text());
			$('#s_num_of_children').val($('#div_children').text());
			var children_ages = [];
			var ages = document.getElementsByClassName("select_age");
			for (var i = 0; i < ages.length; i++) {
				//console.log(ages[i].value);
				children_ages.push(ages[i].value);
			}
			var package_sel = [];
			$('.package_cbox').each(function(i, obj) {
				if ($(this).is(':checked')) {					
					package_sel.push($(this).val());
				}
			});
			$('#packages').val(package_sel.toString());
			$('#s_children_ages').val(children_ages.toString());
			$('#frm_search').submit();
		});

		
		$('.book_now').click(function(){
			//alert('test')		
			var package_val = $(this).attr('data-package')+':'+$(this).attr('data-price')+':1:package';
			$('#h_id_package').val(package_val);	
			$('#h_check_in_date').val($('#check_in_date').val());
			$('#h_check_out_date').val($('#check_out_date').val());
			$('#h_num_of_adult').val($('#div_adult').text());
			//$('#h_num_of_room').val($('#div_room').text());
			$('#h_num_of_children').val($('#div_children').text());
			var children_ages = [];
			var ages = document.getElementsByClassName("select_age");
			for (var i = 0; i < ages.length; i++) {
				//console.log(ages[i].value);
				children_ages.push(ages[i].value);
			}
			$('#h_children_ages').val(children_ages.toString());
			$('#frm_room').submit();
			
		});

		/*$(".room_img").on('click', function(e){
			var mymodal = document.getElementById("myModal");
			var self = $(this);
			var name = self.data('name'); // or src = self.attr('src');
			var src = self.attr('src');
			console.log(mymodal);
			var modalImg = document.getElementById("img01");
			var captionText = document.getElementById("caption");
			modalImg.style.display = "block";	
			modalImg.src = src;
			// captionText.innerHTML = this.alt;
			$('#myModal').modal('show');
		});*/

		

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

		$(".checkbox-dropdown").click(function () {
		    $(this).toggleClass("is-active");
		});

		$(".checkbox-dropdown ul").click(function(e) {
		    e.stopPropagation();
		});
		
		
	});
	sessionStorage.clear();
	
</script>


