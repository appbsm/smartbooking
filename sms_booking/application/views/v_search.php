<?php $lang = $this->input->get('lang');
$CI =& get_instance();
$CI->load->model('m_room_type');

?>

<main class="main-2">
    <!-- SECTION FOR SEARCH -->
    <div class="container-fluid text-center ">
		<form name="frm_search" id="frm_search" method="post" action="<?php echo site_url('home/search');?>">
		<div class="row" style="display: flex; flex-direction: row;">
				<div class="col-md-6" style="display: flex; flex-direction: row; padding: 10px 20px 10px 10px;">
					<div class="group">
					    <label for="name">Check-in Date</label>
					    <input type='text' class=" datepicker" name="check_in_date" id="check_in_date" value="<?php echo $check_in_date;?>"/>

					</div>
					<div class="group">
					    <label for="name">Check-out Date</label>
					    <input type='text' class=" datepicker" name="check_out_date" id="check_out_date" value="<?php echo $check_out_date;?>"/>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="dropdown" style="margin-top: 10px; padding: 10px 10px 10px 10px;">
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
				</div>
				
				<div class="col-md-2" style="display: flex; flex-direction: row; padding: 10px; padding: 10px 20px 10px 20px; margin-top: 5px">
					<button id="search" class="form-control" style="cursor: pointer;">SEARCH</button>
				</div>

		</div>
		</form>
	</div>

  <div class="container-fluid" >
  	<div class="row"> 
    	
    	<?php 
    	$first_photo = $project_photos[0];

    	?>
    	<div class="col-md-6 top-left-grid" style="text-align: right;">
    	<img class="myImg imgThumbnail_bg img_border" data-id="1" src="<?php echo site_url().$first_photo->project_photo_url;?>" style="max-width: 100%;">
    	</div>

    	<div class="col-md-6" style="padding-right: 30px;">
    		<div class="row">
    			<?php 
    			foreach ($project_photos as $key => $photo) {
    			$ctr = $key + 1;
    			if ($key > 0 && $key < 5) {    	
    						
    			?>
    			<div class="col-md-6 top-right-grid">
    			<img class="myImg imgThumbnail_bg img_border" data-id="<?php echo $ctr;?>" src="<?php echo site_url().$photo->project_photo_url;?>" style="max-width: 100%;">
    			</div>
    			<?php }
    			}
    			?>
    		</div>
    		
    		
    	</div>

    			<div class="col-md-12 text-center mt-3 mb-3">
    				<a href="<?php echo site_url('project_info');?>" class="btn button-primary" id="">Project Info Details</a>
    			</div>

    </div>


	<div><hr></div>

	<!-- Room Types -->
	<div class="container-fluid text-center">
		<div class="row" >
			<div class="col-md-12" style="margin-top:10px;">
				<span class="roomtypes"><?php echo $lang == 'en' ? 'Search Result' : 'Search Result'; ?> (<?php echo sizeof($result);?>) Found</span>
			</div>
			
			<?php 
			$room_ctr = 0;
			foreach ($result as $rt) {
			$modular_type = array('a', 'b', 'c', 'e');
			$photos = $CI->m_room_type->get_room_type_photos($rt->id_room_type);
			
			
				?>
				<div class="col-md-6" style="padding:2px 17px 2px 17px;">
				<div class="row room_type">
					<div class="col-md-12">
						<div class="room-type-name"><a href="<?php echo site_url('room_details').'?type='.$rt->id_room_type;?>"><?php echo $rt->room_type_name_en;?></a></div>
					</div>
					<div class="col-md-7">
						<div class="row">
						<?php 
						$ctr1 = 0;
						do { 
						if ($ctr1 == 0) {
							echo '<div class="col-md-12 imgThumbnail_sm" ><img class="room_img" data-type="'.$modular_type[$room_ctr].'" data-ctr="'.$ctr1.'" src="'.site_url().$photos[$ctr1]->room_photo_url.'" style="max-width: 100%;"></div>';
						}
						else {
							echo '<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" data-type="'.$modular_type[$room_ctr].'" data-ctr="'.$ctr1.'" src="'.site_url().$photos[$ctr1]->room_photo_url.'" style="max-width: 100%;"></div>';
						}
						?>
						<?php 
						$ctr1++;
						}while ($ctr1 < 4);?>	
						
							
							
						</div>
					</div>
					<div class="col-md-5">
						<?php 
						$price = ($lang == 'en') ? number_format($rt->default_rate,2).'/Night' : 'ราคา '.number_format($rt->default_rate,0).'/คืน';
						?>
						<div class="price" style="margin-bottom:15px; margin-top:5px; margin-left:-15px;"><b><?php echo $price;?></b></div>
						
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
					
					<div class="col-md-6 mb-2 text-right" > 
						<button class="btn button-primary add_to_cart" data-id="<?php echo $rt->id_room_type;?>" data-price="<?php echo $rt->default_rate;?>" id="">Add to Cart</button>
					</div>
					<div class="col-md-6 mb-2 text-left"> 
						<a href="<?php echo site_url('room_details').'?type='.$rt->id_room_type;?>" class="btn button-primary" id="">Book Now</a>
					</div>
				</div>
			</div>
			
			<?php 
			$room_ctr++;
			}?>
			
			
			
		</div>
  	</div>

  	<div><hr></div>
  	
  </div>

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
      <img class="d-block w-100" src="<?php echo site_url().$h->project_photo_url;?>" alt="slide <?php echo $ctr;?>">
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
		    }
		  }).val();

		$('#check_out_date').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date() // = today		   
		  }).val();

		
		var type_a = <?php echo json_encode($type_a); ?>; 
		var type_b = <?php echo json_encode($type_b); ?>; 
		var type_c = <?php echo json_encode($type_c); ?>; 
		var type_e = <?php echo json_encode($type_e); ?>;
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

		$(".room_img").on('click', function(e){
			var mymodal = document.getElementById("ModalRoomCarousel");
			var self = $(this);
			var type = self.attr('data-type');
			var name = self.data('name'); // or src = self.attr('src');
			var src = self.attr('src');
			var photo_ctr = self.attr('data-ctr');
			//console.log(mymodal);
			var arr_photos = [];
			if (type == 'a') {
				arr_photos = type_a;
			}
			else if (type == 'b') {
				arr_photos = type_b;
			}
			else if (type == 'c') {
				arr_photos = type_c;
			}
			else if (type == 'e') {
				arr_photos = type_e;
			}
			//console.log(arr_photos.length);
			var ol = '';
			var inner_room = '';
			for (var x=0; x < arr_photos.length; x++) {
				var i = x+1;
				var active = (x == photo_ctr) ? 'active' : '';
				console.log(arr_photos[x]);
				var url = "<?php echo site_url();?>" + arr_photos[x];
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
			console.log(ol);	
			console.log(inner_room);	
			//$('#ModalRoomCarousel').show();					
			
			
		});

		$('.dropdown-menu').on('click', function(event){
		    // The event won't be propagated up to the document NODE and 
		    // therefore delegated events won't be fired
		    event.stopPropagation();
		});

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
	 			//var obj = eval('('+res+')');
	 			console.log(res);
	 		    alert('Successful added to cart')
	       });
		});

		$('#search').click(function(){
			$('#frm_search').submit();
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
	});
</script>
	
</body>
</html>

