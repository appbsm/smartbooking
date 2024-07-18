<?php 
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI =& get_instance();
$CI->load->model('m_room_type');
$CI->load->model('m_project_info');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
	.nav-link.active {
		background-color: #81BB4A!important;
	}

	.section_header {
		/*font-size: 1.4em;*/
		font-size: 1.12em;
		font-weight: bold;
		/*color: #515A5A;*/
		color: #000;
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
	.btn-add_to_cart {
		width: auto;
		height: auto;
		text-transform: uppercase;
		line-height: 24px !important;
		color: #fff !important;
		font-size: small !important;
		background-color: #102958 !important;
		border-color: #102958 !important;
	}
	.btn-add_to_cart:hover {
        background-color: #102958 !important;
        color: #fff !important; 
		border-color: #102958 !important;
    }
	.btn-book_now {
		width: auto;
		height: auto;
		text-transform: uppercase;
		line-height: 24px !important;
		color: #fff !important;
		font-size: small !important;
		background-color: #102958 !important;
		border-color: #102958 !important;
	}
	.btn-book_now:hover {
        background-color: #102958 !important;
        color: #fff !important; 
		border-color: #102958 !important;
    }
	.button__badge {
		margin-right: 0px;
		font-size: 0.6em !important;
		position: absolute;
		top: -8px !important;
		right: -4px !important;
	}
	
	.price {
		/*background-color: #2a2a2e;*/
		background-color: #102958;
		color: white;
		text-shadow: 2px 2px 4px #000000;
	}
	
	.form-control, label, a {
		color: #000 !important;
	}
	a:hover {
		color: #000 !important;
	}
</style>

<main class="main-2">
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
		<div class="col-md-12 mt-1 mb-3" id="room-type">
			<div class="row">
				<div class="col-md-4 text-left">
					<h5 style="color: #000 !important;"><?php echo $lang==('english')? $project_details->project_name_en : $project_details->project_name_th;?></h5>
				</div>
				<div class="col-md-8 text-right" style="font-size: 0.875rem !important;">	
				<!-- <nav class="navbar sticky-top navbar-light bg-light">				 -->
					<ul class="nav sticky-top justify-content-end">
						<li class="nav-item">
							<a href="#room-type" class="nav-link"><?php echo $this->lang->line('room_types'); ?></a>
						</li>
						<li class="nav-item">
							<a href="#pj-ov" class="nav-link"><?php echo $this->lang->line('project_overview');?></a>
						</li>
						<li class="nav-item">
							<a href="#pj-fac" class="nav-link"><?php echo $this->lang->line('project_facility');?></a>
						</li>
						<li class="nav-item">
							<a href="#pj-con"  class="nav-link"><?php echo $this->lang->line('conditions_and_policies');?></a>
						</li>
						<li class="nav-item">
							<a href="#google-map"  class="nav-link"><?php echo $lang=='english' ? 'Map':'แผนที่';?> </a>
						</li>
					</ul>
				</div>
			</div>  				
    	</div>
    </div>


	<div><hr></div>


	



	<!-- Room type -->
	 



	 <div  class="container mt-5">
		<div class="row">
			<div class="col-md-12 ml-2 text-left"  style="font-size: 0.875rem !important;">
				<h5 style="color: #000 !important;"><?php echo $this->lang->line('room_types'); ?></h5>
			</div>
		</div>
		<div class="row">
		<?php 
			foreach ($room_types as $key => $rt) {
				$photos = $CI->m_room_type->get_room_type_photos($rt->id_room_type);
			?>
			<?php }?>
			
			<?php 
			$room_ctr = 0;
			$date = date('Y-m-d');
			foreach ($room_types as $key => $rt) {
			$rate = $CI->m_room_type->get_day_rate ($rt->id_room_type, $date);
			if ($rate == '') {
				$rate = $rt->default_rate;				
			}
			$photos = $CI->m_room_type->get_room_type_photos($rt->id_room_type);
				?>
			
			<div class="col-md-6 mt-3">
				<div class="row">
					<div class="col-md-12 pl-4 text-left" style="background-color:;">
						<h6 style="color: #000 !important;"><div class="room-type-name"><?php echo ($lang == 'english') ? $rt->room_type_name_en : $rt->room_type_name_th;?></div></h6>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="font-size: 0.875rem !important;">
						<div class="row">
							<div class="col-md-7" style="background-color:;height:300px">
								<div class="slideshow" id="slideshow-<?php echo $key;?>">
									<?php 
										foreach ($photos as $ctr1 => $photo){
									?>
									<div>
										<img class="room_img" data-type="<?php echo $modular_type[$room_ctr];?>" data-ctr="<?php echo $ctr1;?>" src="<?php echo share_folder_path().$photo->room_photo_url;?>" width="100%">
									</div>
									<?php }?>
								</div>	

							</div>
							<div class="col-md-5" style="background-color:;height:300px">
								<div class="row mb-3 mt-2 price">
									<div class="col-md-12 mx-0 text-center" style="font-size: 0.875rem !important;">
									<?php 
									$price = ($lang == 'english') ? number_format($rt->default_rate,0).'/Night' : 'ราคา '.number_format($rate,0).'/คืน';
									?>
									<div class="price" ><b><?php echo $price;?></b></div>				
									</div>
								</div>

								<div class="row">
									<div class="col-md-2 col-sm-2 text-left icon_container">
										<span class="icon-content" style="color: #000 !important;"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content" style="color: #000 !important; font-size: 0.875rem !important;"><?php echo $lang == 'english' ? $rt->area_en : $rt->area_th; ?></span>
									</div>
								</div>
			
								<div class="row">
									<div class="col-2 text-left icon_container" >
											<!-- <span class="icon-content"><img class="icon" src="<?php echo share_folder_path();?>images/icons/icons8-bedroom-50.png" height="18"></span> -->
											<span class="icon-content" style="color: #000 !important;"><object data="<?php echo share_folder_path();?>images/icons/icons8-bedroom-50.png" height="18"></object></span>
										</div>
										<div class="col-9 text-left icon_container">
											<span class="icon-content" style="color: #000 !important; font-size: 0.875rem !important;"><?php echo $lang == 'english' ? $rt->room_details_en : $rt->room_details_th; ?></span>
										</div>
								</div>
								<div class="row">
									<div class="col-2 text-left icon_container" >
										<span class="icon-content  ml-1" style="color: #000 !important;"><object data="<?php echo share_folder_path();?>images/icons/bathroom.png" height="18"></object></span>
									</div>
									<div class="col-9 text-left icon_container">
										<span class="icon-content" style="color: #000 !important; font-size: 0.875rem !important;"><?php echo $lang == 'english' ? $rt->bathroom_en : $rt->bathroom_th; ?></span>
									</div>
								</div>		
								<div class="row">
									<div class="col-md-2 text-left col-sm-2 icon_container" >
										<span class="icon-content" style="margin-left:1px; color: #000 !important;"><object data="<?php echo share_folder_path();?>images/icons/person-fill.svg" height="18"></object></span>
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content" style="color: #000 !important; font-size: 0.875rem !important;"><?php echo $lang == 'english' ? $rt->number_of_adults.' Adults' : 'จำนวนผู้เข้าพัก: '.$rt->number_of_adults ;?></span>
									</div>		
								</div>
								
								<div class="row" >
									<div class="col-md-2 text-left col-sm-2 icon_container">
										<object data="<?php echo share_folder_path();?>images/icons/tv.svg" height="20"> </object>
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content"style="color: #000 !important; font-size: 0.875rem !important;">TV (Internet)</span>
									</div>						
								</div>
								
								<div class="row">
									<div class="col-md-2 text-left col-sm-2 icon_container">
										<span class="icon-content"style="color: #000 !important;"><object data="<?php echo share_folder_path();?>images/icons/snow.svg" height="20"> </object></span>
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content"style="color: #000 !important; font-size: 0.875rem !important;"><?php echo $lang == 'english' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
									</div>
								</div>

								<div class="row" >
									<div class="col-md-2 text-left col-sm-2 icon_container">
										<span class="icon-content"style="color: #000 !important;"><object data="<?php echo share_folder_path();?>images/icons/wifi.svg" height="20"> </object></span>
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content"style="color: #000 !important; font-size: 0.875rem !important;">Free WIFI</span>
									</div>						
								</div>
								<?php if ($rt->sofa_en != '') {?>
								<div class="row">
									<div class="col-md-2 text-left col-sm-2 icon_container">
										<span class="icon-content" style="font-size:16px; margin-top:-2px;color: #000 !important;">
											<object data="<?php echo share_folder_path();?>images/icons/sofa.png" height="14"></object>
										</span>
									</div>
									<div class="col-md-9 text-left col-sm-9 icon_container">
										<span class="icon-content"style="color: #000 !important; font-size: 0.875rem !important;"><?php echo $lang == 'english' ? $rt->sofa_en : $rt->sofa_th; ?></span>
									</div>						
								</div>
								<?php }?>
									
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 ml-2 text-right" style="font-size: 0.875rem !important;">
					<button class="btn button-primary-w add_to_cart btn-add_to_cart" data-id="<?php echo $rt->id_room_type;?>" data-price="<?php echo $rt->default_rate;?>" id="" style="margin-right: 5px;"><?php echo $this->lang->line('add_to_cart');?></button>
						<a href="javascript:;" data-roomtype="<?php echo $rt->id_room_type;?>" class="btn button-primary book_now  btn-book_now" id="" style="margin-left: 5px;"><?php echo $this->lang->line('book_now');?></a>
					</div>
				</div>
			</div >

			<?php 
			$room_ctr++;
			}?>
		</div>
	</div>
	<div id="pj-ov"></div>
  	<div class="my-5" ><hr></div>

	<div class="container">
	<div class="row" id="pj-fac">
		<div class="col-md-8">
			<div class="section_header "><?php echo $this->lang->line('project_overview');?></div>		
			<div class="row mb-2">	
				<div class="container-fluid mb-4">		
					<div class="col-md-12" style="font-size: 0.875rem !important;">			
		    			<?php echo ($lang == 'english') ? $project_details->overview_en : $project_details->overview_th;;?>
		    		
		    		</div>
		    	</div>
			</div>
	
			<div class="section_header "><?php echo $this->lang->line('project_highlights');?></div>
			<div class="row mb-2">			
				<div class="container-fluid mb-4">
					<div class="col-md-12" style="font-size: 0.875rem !important;">		
						<div class="h_container" style="display: flex; flex-direction: row; ">	
		    			<?php foreach ($project_highlights as $h) {?>
		    				<div style="bottom: 0; padding-right: 50px;">
		    				
		    				<!-- <input type="checkbox" style="vertical-align:middle;"> -->
		    				&nbsp;<img src="<?php echo share_folder_path().$h->icon;?>" width="18">
		    				<span class="highlights_desc" style="font-size: 1.1em;color: #000 !important;"><?php echo ($lang == 'english') ? $h->description_en : $h->description_th;?></span>
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
				<div class="row" id="pj-con">	
				<!-- <div class="h_container" style="display: flex; flex-direction: column; "> -->	
				
    			<?php 
    			
    			foreach ($property_facility as $f) {?>
    				<div class="col-md-6" style="bottom: 0; font-size: 0.875rem !important;">
    				
    				<input type="checkbox" <?php echo (in_array($f->long_desc_en, $project_facility)) ? 'checked="checked"' : ''?> style="vertical-align:middle; pointer-events:none;">
    				&nbsp;<img src="<?php echo share_folder_path().$f->icon;?>" width="18">
    				<span class="highlights_desc" style="font-size: 1.1em; color: #000 !important;"> <?php echo ($lang == 'english') ? $f->long_desc_en : $f->long_desc_th;?></span>
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
			<div class="col-md-12" style="font-size: 0.875rem !important;">			
    			
    			<?php 
    			//print_r($project_policy);
    			foreach ($project_policy as $p) {
    				$policy_type = ($lang == 'english') ? $p->policy_type_en : $p->policy_type_th;
    				echo "<span>".$policy_type.'</span>';   			
    				$policies = $CI->m_project_info->get_property_policy(1, $p->policy_type_en);
    			?>
    			<ol>
					<?php foreach ($policies as $policy) {?>			
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
						<table class="table table-bordered" style="border-color: #dee2e6; color: #000 !important; font-size: 0.875rem !important;">
							<tr>
								<th><?php echo $this->lang->line('location');?></th>
								<th><?php echo $this->lang->line('distance');?>(km)</th>
							</tr>
						<?php foreach ($locations_nearby as $l) {?>
							<tr>
								<td style="color: #000 !important;"><?php echo $l->location_name_en;?></td>
								<td style="text-align: center; color: #000 !important;"><?php echo $l->distance_km;?></td>
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

</main>
<!-- Google map -->
<div id="google-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5462.972307432571!2d101.55065412783209!3d14.490156270739496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311c3b5927861817%3A0x4ef8dd372f4d0716!2sSMS%20Showroom!5e0!3m2!1sth!2sth!4v1683184985267!5m2!1sth!2sth" width=100% height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<!-- End Google map -->

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

<form name="frm_room" id="frm_room" method="post" action="<?php echo site_url('room_details');?>">
	<input type="hidden" name="h_id_room_type" id="h_id_room_type" value="">
	<input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="">
	<input type="hidden" name="h_num_of_room" id="h_num_of_room" value="">
	<input type="hidden" name="h_num_of_children" id="h_num_of_children" value="">
	<input type="hidden" name="h_children_ages" id="h_children_ages" value="">
	<input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
	<input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">
</form>


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
		$("#h_check_in_date").val($('#check_in_date').val());
		$("#h_check_out_date").val($('#check_out_date').val());
		

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

		$('.book_now').click(function(){
			$('#h_id_room_type').val($(this).attr('data-roomtype'));
			$('#h_check_in_date').val($('#check_in_date').val());
			$('#h_check_out_date').val($('#check_out_date').val());
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
			$('#frm_room').submit();
		});
	});
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