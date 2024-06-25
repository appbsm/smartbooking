<?php 
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI =& get_instance();
$CI->load->model('m_room_type');
$CI->load->model('m_project_info');
?>

<style>
.nav-link.active {
	background-color: #81BB4A!important;
}

.section_header {
	font-size: 1.4em;
	font-weight: bold;
	color: #515A5A;
}



</style>

<main class="main-2">
  <div class="row">
  		<div class="col-md-12">
  			<ul class="breadcrumb">
			  <li><a href="<?php echo site_url();?>"><?php echo $this->lang->line('home');?></a></li>
			  <li><?php echo $this->lang->line('project_info_details');?></li>
			</ul>
  		</div>
  	</div>
  <section class="text-center container">
    
  </section>
  <div class="container-fluid" >
  	
  	
  	<!--
	<div class="row">
  		<div class="col-md-12"><h3><?php echo ($lang == 'english') ? $project_details->project_name_en : $project_details->project_name_th;?></h3></div>
  		<div class="col-md-12"><?php echo $project_details->whole_address_en;?></div>
  	</div> -->
  	<div class="row"> 
    	
    	<?php 
    	$first_photo = $project_photos[0];
    	
    	
    	?>
    	<div class="col-md-6 top-left-grid" style="text-align: right;">
    	<img class="myImg imgThumbnail_bg img_border" data-id="1" src="<?php echo share_folder_path().$first_photo->project_photo_url;?>" style="max-width: 100%;">
    	</div>
    	
    	
    	
    	
    	
    	<div class="col-md-6" style="padding-right: 30px;">
    		<div class="row">
    			<?php 
    			foreach ($project_photos as $key => $photo) {
    			$ctr = $key + 1;
    			if ($key > 0 && $key < 5) {    	
    						
    			?>
    			<div class="col-md-6 top-right-grid">
    			<img class="myImg imgThumbnail_bg img_border" data-id="<?php echo $ctr;?>" src="<?php echo share_folder_path().$photo->project_photo_url;?>" style="max-width: 100%;">
    			</div>
    			<?php }
    			}
    			?>
    		</div>
    		
    		
    	</div>
    </div>


	<div><hr></div>
	<!-- 
		<div class="row">
			<div class="col-md-12 mb-2">
			<nav class="nav nav-pills flex-column flex-sm-row">
			  <a class="flex-lg-fill text-sm-center nav-link active" href="#">Overview</a>
			  <a class="flex-sm-fill text-sm-center nav-link" href="#">Facilities</a>
			  <a class="flex-sm-fill text-sm-center nav-link" href="#">Location</a>
			  <a class="flex-sm-fill text-sm-center nav-link" href="#">Policies</a>
			  <a class="flex-sm-fill text-sm-center nav-link" href="#">Rooms</a>
			</nav>
			</div>
			
			
		</div>
	 -->
	 
	<div class="row">
		<div class="col-md-8">
			<div class="section_header "><?php echo $this->lang->line('project_overview');?></div>		
			<div class="row mb-2">	
				<div class="container-fluid mb-4">		
					<div class="col-md-12">			
		    			<?php echo ($lang == 'english') ? $project_details->overview_en : $project_details->overview_th;;?>
		    		
		    		</div>
		    	</div>
			</div>
	
			<div class="section_header "><?php echo $this->lang->line('project_highlights');?></div>
			<div class="row mb-2">			
				<div class="container-fluid mb-4">
					<div class="col-md-12">		
						<div class="h_container" style="display: flex; flex-direction: row; ">	
		    			<?php foreach ($project_highlights as $h) {?>
		    				<div style="bottom: 0; padding-left: 30px;">
		    				
		    				<!-- <input type="checkbox" style="vertical-align:middle;"> -->
		    				&nbsp;<img src="<?php echo share_folder_path().$h->icon;?>" width="18">
		    				<span class="highlights_desc" style="font-size: 1.1em;"><?php echo ($lang == 'english') ? $h->description_en : $h->description_th;?></span>
		    				</div>
		    			<?php }?>    
		    			</div>		
		    		</div>
				</div>
			</div>
			
			<div class="section_header "><?php echo $this->lang->line('project_facility');?></div>
	<div class="row">			
		<div class="container-fluid mb-4">
			<div class="col-md-12">	
				<div class="row">	
				<!-- <div class="h_container" style="display: flex; flex-direction: column; "> -->	
				
    			<?php 
    			
    			foreach ($property_facility as $f) {?>
    				<div class="col-md-6" style="bottom: 0; ">
    				
    				<input type="checkbox" <?php echo (in_array($f->long_desc_en, $project_facility)) ? 'checked="checked"' : ''?> style="vertical-align:middle; pointer-events:none;">
    				&nbsp;<img src="<?php echo share_folder_path().$f->icon;?>" width="18">
    				<span class="highlights_desc" style="font-size: 1.1em;"> <?php echo ($lang == 'english') ? $f->long_desc_en : $f->long_desc_th;?></span>
    				</div>
    			<?php }?>    
    			<!-- </div>	-->
    			</div>	
    		</div>
		</div>
	</div>
	
	<div class="section_header "><?php echo $this->lang->line('conditions_and_policies');?></div>
	<div class="row">			
		<div class="container-fluid mb-4">
			<div class="col-md-12">			
    			
    			<?php 
    			
    			foreach ($project_policy as $p) {
    			$policy_type = ($lang == 'english') ? $p->policy_type_en : $p->policy_type_th;
    			echo "<span>".$policy_type.'</span>';
    			
    			$policies = $CI->m_project_info->get_property_policy(1, $p->policy_type_en);
    			?>
    			<ol>
    			<?php 
    			foreach ($policies as $policy) {
    			?>
    			
    			
    				<li><?php echo ($lang == 'english') ? $policy->description_en: $policy->description_th;?></li>
    			  	
    			
    			<?php }?>  
				</ol>
				<?php } ?>
    		</div>
		</div>
	</div>
			
		</div>
	
		<div class="col-md-4">
			<div class="section_header "><?php echo $this->lang->line('locations_nearby');?></div>
			<div class="row mb4">			

					<div class="col-md-12">		
						<div class="table-responsive">
  						<table class="table table-bordered" >
						<tr>
						<th><?php echo $this->lang->line('location');?></th>
		    			<th><?php echo $this->lang->line('distance');?>(km)</th>
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
	
	
	
	
	
	
		
	

	<!-- Room Types -->
	<div class="section_header "><?php echo $this->lang->line('room_types');?></div>
	
	<div class="container-fluid text-center">
		<div class="row" >
			
			<?php 
			$room_ctr = 0;
			$date = date('Y-m-d');
			foreach ($room_types as $rt) {
			$rate = $CI->m_room_type->get_day_rate ($rt->id_room_type, $date);
			if ($rate == '') {
				$rate = $rt->default_rate;				
			}
			$photos = $CI->m_room_type->get_room_type_photos($rt->id_room_type);
			
			
				?>
				<div class="col-md-6" style="padding:2px 17px 2px 17px;">
				<div class="row room_type">
					<div class="col-md-12">
						<div class="room-type-name"><?php echo ($lang == 'english') ? $rt->room_type_name_en : $rt->room_type_name_th;;?></div>
					</div>
					<div class="col-md-7">
						<div class="row">
						<?php 
						$ctr1 = 0;
						do { 
						if ($ctr1 == 0) {
							echo '<div class="col-md-12 imgThumbnail_sm" ><img class="room_img" data-type="'.$modular_type[$room_ctr].'" data-ctr="'.$ctr1.'" src="'.share_folder_path().$photos[$ctr1]->room_photo_url.'" style="max-width: 100%;"></div>';
						}
						else {
							echo '<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" data-type="'.$modular_type[$room_ctr].'" data-ctr="'.$ctr1.'" src="'.share_folder_path().$photos[$ctr1]->room_photo_url.'" style="max-width: 100%;"></div>';
						}
						?>
						<?php 
						$ctr1++;
						}while ($ctr1 < 4);?>	
						
							
							
						</div>
					</div>
					<div class="col-md-5">
						<?php 
						$price = ($lang == 'english') ? number_format($rt->default_rate,0).'/Night' : 'ราคา '.number_format($rate,0).'/คืน';
						?>
						<div class="price" style="margin-bottom:15px; margin-top:5px; margin-left:-15px;"><b><?php echo $price;?></b></div>
						
						<div class="container text-left">
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
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
			
			<?php 
			$room_ctr++;
			}?>
			
			
			
		</div>
  	</div>

  	<div><hr></div>
  	
  </div>

</main>

<?php foreach ($types_photos as $key => $tp) {?>
<input type="hidden" name="hiddentype_<?php echo $key?>" id="hiddentype_<?php echo $key?>" value='<?php echo json_encode($tp);?>' />
<?php }?>
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
}

	$(function(){
		

		$('.datepicker').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		  // change : updateDate
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
			var type = self.attr('data-type');
			console.log(type);
			var name = self.data('name'); // or src = self.attr('src');
			var src = self.attr('src');
			var photo_ctr = self.attr('data-ctr');
			//console.log(mymodal);
			var arr_photos = [];
			
			var arr_type = "hiddentype_"+type;
			console.log(arr_type);
			ar_photos = $('#'+arr_type).val();
			arr_photos = JSON.parse(ar_photos);
			console.log(arr_photos);
			var ol = '';
			var inner_room = '';
			
			for (var x=0; x < arr_photos.length; x++) {
				var i = x+1;
				var active = (x == photo_ctr) ? 'active' : '';
				console.log(arr_photos[x]);
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
			
			console.log(ol);	
			console.log(inner_room);	
			//$('#ModalRoomCarousel').show();					
			
			
		});

		$('.dropdown-menu').on('click', function(event){
		    // The event won't be propagated up to the document NODE and 
		    // therefore delegated events won't be fired
		    event.stopPropagation();
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
