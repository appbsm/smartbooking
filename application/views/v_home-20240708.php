<?php
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI = &get_instance();
$CI->load->model('m_room_type');

?>
<title>Smart Booking</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
	.dropdown-toggle{
		color: #000 !important;
		border: 1px solid #ccc;
		background-color: #fff !important;
	}
	.dropdown-item.active, .dropdown-item:active {
		background-color: #5392f9 !important;
	}

	.span, .icon-content {
		color: #000 !important;
	}
	.carousel-item.active {
		z-index: 0 !important;
		opacity: 1;
	}
	.slideshow {
		/* position: absolute; */
		/* display: flex;
		flex-direction: column;
		top: 10px;
		left: 10px;
		right: 10px;
		bottom: 10px; */
		height: auto !important;
	}

	.eclipes-name {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.content-image {
		width: 100%;
	}

	.content-detail {
		width: 100%;

	}

	.product-card {
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}

	.content-product {
		margin-top: 10px;
		display: flex;
		flex-direction: row;
	}
	.footer{
		display: flex;
		flex-direction: row;
		justify-content: end;
	}
	
	.description-banner {
		/*background-color: #e2e0e0;
		color: #839287;*/
		background-color: rgb(42, 42, 46);
		color: rgb(215, 215, 219);
		/*color: rgb(83 146 249);*/
		text-align: center;
		padding: 20px;
		font-size: 16px;
		font-weight: 400;
	}
	.long-text {
		display: none; /* ซ่อนข้อความยาวในตอนแรก */
		font-size: 1em !important;
		margin: 0;
		color: rgba(255, 255, 255, 1.00);
		text-shadow: 2px 2px 4px #000000;
	}
	.short-text {
		margin: 0;
		font-size: 1em !important;
		color: rgba(255, 255, 255, 1.00);
		text-shadow: 2px 2px 4px #000000;
	}
	.a-readmore {
		/*color: #839287;
		color: rgb(215, 215, 219) !important;
		color: rgb(83 146 249) !important;*/
		color: #fff !important;
		text-shadow: 2px 2px 4px #000000;
	}
	.readmore-toggle {
		display: block;
		cursor: pointer;
		/*color: #839287;*/
		font-size: 1em !important;
		margin-top: 10px;
		background-color: rgb(42, 42, 46);
		color: rgb(215, 215, 219);
		/*color: rgb(83 146 249);*/
	}

	.readmore-toggle:hover {
		text-decoration: underline;
		font-size: 1em !important;
	}
	
	.em-readmore {
		/*color: rgb(83 146 249) !important; */
		color: rgb(215, 215, 219) !important;
	}
	
	.tx-title-header {
		color: #000 !important;
		text-shadow: 0px 0px 1px #000
	}
	.tx-title-sub {
		color: #000 !important;
	}
	
	/*PROMOTION & PACKAGE*/
	.card {
	  border: none;
	  border-radius: 0;
	  box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
	}
	.carousel-inner {
	  /*padding: 1em;*/
	}
	.carousel-control-prev,
	.carousel-control-next {
	  background-color: #e1e1e1;
	  width: 6vh;
	  height: 6vh;
	  border-radius: 50%;
	  top: 50%;
	  transform: translateY(-50%);
	}
	.carousel-control-prev span,
	.carousel-control-next span {
	  width: 1.5rem;
	  height: 1.5rem;
	}
	@media screen and (min-width: 577px) {
	  .cards-wrapper {
		display: flex;
	  }
	  .card {
		margin: 0 0.5em;
		width: calc(100% / 2);
	  }
	  .image-wrapper {
		height: 20vw;
		margin: 0 auto;
	  }
	}
	@media screen and (max-width: 576px) {
	  .card:not(:first-child) {
		display: none;
	  }
	}
	.image-wrapper img {
	  max-width: 100%;
	  max-height: 100%;
	}
	.package-tx-title {
		color: #0d6efd !important;
		font-size: 18px ;
		font-weight: 600;
		cursor: pointer;
	}
	.package-tx-title:hover {
		color: #000 !important;
		font-size: 18px ;
		font-weight: 600;
		cursor: pointer;
	}
	.package-tx-sub {
		color: #000 !important;
		font-size: 14px ;
		cursor: pointer;
		font-weight: 600;
		margin-bottom: 8px;
	}
	.package-tx {
		-webkit-line-clamp: 2;
		/*color: rgba(249, 109, 1, 1.00);*/
		color: rgb(249 1 1);
		font-style: normal;
		font-size: 14px ;
		font-weight: 700;
		margin-bottom: 8px;
	}
	.package-tx-line {
		color: rgba(143, 143, 143, 1.00);
		font-style: normal;
		text-decoration-line: line-through;
		font-size: 14px ;
		margin: 0;
	}
	.package-period-tt {
		-webkit-line-clamp: 2;
		font-style: normal;
		font-size: 12px ;
		margin: 0;
		font-weight: 700;
	}
	.package-period {
		-webkit-line-clamp: 2;
		color: #000 !important;
		font-style: normal;
		font-size: 14px ;
		margin: 0;
	}
	.package-img {
		width: 100%;
		height: 100%;
	}
	.discount {
		position: absolute;
		background-color: #e12d2d;
		top: 16px;
		width: 86px;
		border-radius: 4px;
		text-align: center;
		margin: -16px;
	}
	.discount-no {
		font-size: 16px !important;
		color: #fff !important;
		margin: 0;
	}
	.discount-title {
		font-size: x-small !important;
		color: #fff !important;
		margin: 0;
	}
	.btn-more {
		width: auto;
		height: auto;
		text-transform: uppercase;
		line-height: 30px;
		color: #fff !important;
		font-size: small !important;
		/*background-color: #839287;
		border-color: #839287;*/
		background-color: #5392f9 !important;
		border-color: #5392f9 !important;
	}
	.btn-add_to_cart {
		width: auto;
		height: auto;
		text-transform: uppercase;
		line-height: 30px;
		color: #fff !important;
		font-size: small !important;
		background-color: #5392f9 !important;
		border-color: #5392f9 !important;
	}
	.btn-add_to_cart:hover {
        background-color: #fff !important;
        color: #5392f9 !important; 
		border-color: #5392f9 !important;
    }
	/*PROMOTION & PACKAGE*/
	
	/*Room Types*/
	.roomtype-tx-title {
		color: #000 !important;
		font-size: 18px ;
		font-weight: 500;
		cursor: pointer;
	}
	.roomtype-tx-title:hover {
		color: #0d6efd !important;
		font-size: 18px ;
		font-weight: 500;
		cursor: pointer;
	}
	
	
	/*accordion*/
	.accordion-button {
		background-color: #f8f9fa;
		color: #000;
		font-size: 1.25rem;
	}
	.accordion-button:focus {
		box-shadow: none;
	}
	.accordion-button:not(.collapsed) {
		color: #000;
		background-color: #e9ecef;
	}
	.accordion-body {
		/*font-size: 1rem;
		color: #6c757d;*/
		color: #000;
		font-size: 14px;
	}	
	.accordion-button.button-accordion {
        background-color: #fff !important; 
        /*color: #839287 !important; */
		color: #000 !important;
        border: none !important; 
		font-size: 14px !important;
		padding: 10px 8px;
    }
	.accordion-item {
		color: var(--bs-accordion-color);
		background-color: var(--bs-accordion-bg);
		border-left: none !important;
		border-right: none !important;
		border-top: none !important;
		border-bottom: var(--bs-accordion-border-width) solid var(--bs-accordion-border-color);
	}
	
	/*accordion*/
	.card-roomtype {
		width: 100%;
		max-width: 100%;
		height: 100%;
	}
	.icon-service {
		width: 20px;
		height: 20px;
	}
	.tx-service {
		/*color: #839287 !important;*/
		color: #000 !important;
		font-size: 14px !important;
		font-weight: 400;
	}
	.location {
		font-size: 14px !important;
		/*color: #839287 !important;*/
		color: #000 !important;
		margin: 0 0;
		line-height: 20px;
		font-weight: 400;
	}
	.img-sec span, .gallery_section .img-sec span {
		position: absolute;
		background: red;
		color: #fff;
		padding: 2px 20px;
		right: 0;
		bottom: 24px;
	}
	.img-sec span:before, .gallery_section .img-sec span:before {
		content: "";
		width: 21px;
		height: 21px;
		background: red;
		position: absolute;
		left: -10px;
		top: 4px;
		transform: rotate(45deg);
	}
	.img-sec span:after, .gallery_section .img-sec span:after {
		content: "";
		width: 8px;
		height: 8px;
		background: #fff;
		position: absolute;
		top: 10px;
		border-radius: 50%;
		left: 0;
	}
		/*Room Types*/
	
	.button__badge {
		margin-right: 0px;
		font-size: 0.6em !important;
		position: absolute;
		top: -8px !important;
		right: -4px !important;
	}
	
	.form-control-ckinout {
		padding: 1.165rem .75rem !important;
	}
	.form-control-btnsearch {
		padding: 1.165rem .75rem !important;
	}
	a {
		color: rgb(90, 90, 90) !important;
		text-decoration: none !important;
	}
	a:hover {
		color: #007bff !important;
		text-decoration: none !important;
		background-color: transparent !important;
		-webkit-text-decoration-skip: objects !important;
	}
	.book_now:hover {
        background-color: #fff !important;
        color: #5392f9 !important; 
		border-color: #5392f9 !important;
    }
	.book_now {
		width: auto;
		height: auto;
		text-transform: uppercase;
		line-height: 30px;
		color: #fff !important;
		font-size: small !important;
		background-color: #5392f9 !important;
		border-color: #5392f9 !important;
	}
	
	.search-bg {
		/*background-color: #f8f7f9 ;*/
		backdrop-filter: blur(10px);
		background-color: rgb(255 255 255 / 48%) !important;
	}
	.btn-filter {
		background-color: #fff !important;
		color: #000 !important;
		border: #5392f9 !important;
	}
	.btn-search {
		background-color: #5392f9 !important;
		color: #fff !important;
		border: #5392f9 !important;
	}



	/* Styles for Mobile Phones */
	@media (max-width: 480px) {
		.content-detail {
			margin-top: 10px;
			position: relative;
		}

		.content-product {
			display: flex;
			flex-direction: column;
		}
		.content-image{
			width: 100%;
			/* height: 220px; */
		}
	}

	/* Styles for Portrait Tablets */
	@media (min-width: 481px) and (max-width: 768px) {
		.content-detail {
			margin-top: 10px;
			position: relative;
		}

		.content-product {
			display: flex;
			flex-direction: column;
		}
		.content-image{
			width: 100%;
			/* height: 300px; */
		}
	}

	/* Styles for Landscape Tablets and Small Desktops */
	@media (min-width: 769px) and (max-width: 1024px) {
		.content-detail {
			position: relative;
			/* margin-top: 20px; */
		}

		.content-product {
			display: flex;
			flex-direction: row;
		}
		.content-image{
			width: 100%;
			/* height:auto; */
		}
		.amenities-nearby-column {
			display: flex;
		}
	}

	/* Styles for Large Desktops */
	@media (min-width: 1201px) {
		.content-detail {
			position: relative;
		}

		.content-product {
			display: flex;
			flex-direction: row;
		}
		.content-image{
			width: 100%;
			/* height: 400px; */
		}
	}
	@media (min-width: 1024px) {
		.carousel-inner-packgage .carousel-item img {
			height: 500px;
			object-fit: cover; /* Optional: This will ensure the image covers the 500px height without distortion */
		}
		.img-cover {
			height: 500px !important;
		}
		.amenities-nearby-column {
			display: flex;
		}
		body {
			/*width: 100%;
			max-width: 1500px; 
			margin: 0 auto; 
			*/
		}
		
</style>

<!-- Package -->
<!-- <link rel="stylesheet" href="<?= site_url() ?>/css/style.css"> -->
<link rel="stylesheet" href="<?= site_url() ?>/css/tiny-slider.css">
<link rel="stylesheet" href="<?= site_url() ?>/css/package.css">
<!-- <link rel="stylesheet" href="<?= site_url() ?>/css/main.css"> -->
<link rel="icon" type="image/png" sizes="16x16" href="<?= site_url() ?>/images/10.png">
<link rel="stylesheet" href="<?= site_url() ?>assets/select-picker/css/bootstrap-select.min.css">


<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class=" home-p mb-4 mt-2">
	<!-- Carousel Start -->
	<div id="carousel carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
		<!-- <ol class="carousel-indicators">
		<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	</ol> -->
		<div class="carousel-inner">
			<?php
			$ctr = 1;
			foreach ($project_photos as $key => $photo) {
			?>
				<div class="carousel-item <?php echo ($ctr == 1) ? 'active' : ''; ?>">
					<img class="d-block w-100 img-cover" src="<?php echo share_folder_path() . $photo->project_photo_url; ?>" alt="First slide">
				</div>
			<?php $ctr++;
			} ?>
		</div>
		<!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a> -->
	</div>
	<!-- Carousel End -->


	<!-- SECTION FOR SEARCH -->
	<div class="container-fluid text-center search-box">
		<form name="frm_search" id="frm_search" method="post" action="<?php echo site_url('home/search'); ?>">
			<input type="hidden" name="s_id_room_type" id="s_id_room_type" value="">
			<input type="hidden" name="s_num_of_adult" id="s_num_of_adult" value="">
			<input type="hidden" name="s_num_of_room" id="s_num_of_room" value="">
			<input type="hidden" name="s_num_of_children" id="s_num_of_children" value="">
			<input type="hidden" name="s_children_ages" id="s_children_ages" value="">
			<input type="hidden" name="search_type" id="search_type" value="">
			<input type="hidden" name="packages" id="packages" value="">
			<input type="hidden" name="project_id" id="project_id" value="">

			<div class="container mt-5">
				<div class="row search-bg pt-3" style="border: 2px solid #C6C6C7; border-radius: 5px; padding: 5px 0 5px 0; margin: 0 4px 0 4px;">
					<div class="col-lg-3 ">
						<div class="col-md-12 text-left">
							<label class="ml-1" for="name"><?php echo $lang == "english" ? 'Location' : 'สถานที่'; ?> </label>
							<!-- <input type='text' class=" form-control search_input" value=""/>	 -->
							<select class="form-control selectpicker search_input" data-live-search="true" name="project_id" id="project_id">
								<?php foreach ($project_all as $pj) { ?>
									<option value="<?php echo $pj->id_project_info ?>"><?php echo $lang == "english" ? $pj->project_name_en : $pj->project_name_th; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-xs-6">
						<div class="col-md-12 text-left">
							<label class="ml-1" for="name"><?php echo $this->lang->line('check_in_date'); ?></label>

							<input type='text' class=" form-control form-control-ckinout datepicker search_input" name="check_in_date" id="check_in_date" value="" />
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-xs-6">
						<div class="col-md-12 text-left">
							<label class="ml-1" for="name"><?php echo $this->lang->line('check_out_date'); ?></label>
							<input type='text' class="form-control form-control-ckinout datepicker search_input" name="check_out_date" id="check_out_date" value="" />
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<!-- <div class="col-md-12 mt-2"><b><?php echo $this->lang->line('search_by_room'); ?></b></div> -->
						<div class="col-md-12 mb-2 text-left">
							<label class="ml-1" for="name"><?php echo $lang == "english" ? 'Adult' : 'ผู้เข้าพัก'; ?></label>
							<div class="dropdown">
								<button class="btn dropdown-toggle w-100 search_input" style="color: #000 !important; background-color: #fff !important; width:100%;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<div class="d-inline-flex">
										<span id="div_adult">2&nbsp;</span> <?php echo $this->lang->line('adults'); ?>, 
										<span id="div_children">&nbsp;0&nbsp;</span> <?php echo $this->lang->line('children'); ?>, 
										<span id="div_room">&nbsp;1</span>
									</div> <?php echo $this->lang->line('rooms'); ?>
								</button>
								<div class="dropdown-menu" style="vertical-align: bottom;" aria-labelledby="dropdownMenuButton" style="">
									<div class="stepper">
										<div style="display: flex; justify-content: center;"><?php echo $this->lang->line('adult'); ?></div>
										<div style="display: flex; justify-content: center; background-color: white; ">
											<button type="button" class="btn_stepper " id="decrement-adult" onClick="stepper(this);"> - </button>
											<input class="input_number" type="number" min="0" max="100" step="1" value="2" name="adult" id="adult" readonly>
											<button type="button" class="btn_stepper " id="increment-adult" onClick="stepper(this);"> + </button>
										</div>
										<div class="rounded hr3 mt-2 mb-2"></div>
										<div style="display: flex; justify-content: center;"><?php echo $this->lang->line('children'); ?></div>
										<div style="display: flex; justify-content: center;">
											<button type="button" class="btn_stepper " id="decrement-children" onClick="stepper(this);"> - </button>
											<input class="input_number" type="number" min="0" max="100" step="1" value="0" name="children" id="children" readonly>
											<button type="button" class="btn_stepper " id="increment-children" onClick="stepper(this);"> + </button>
										</div>

										<div class="kids_age">
											<div class="col-md-12">
												<div class="row div_kids_age">

												</div>
											</div>
										</div> <!-- Kids Age -->
										<div class="rounded hr3 mt-2"></div>

										<div style="display: flex; justify-content: center;"><?php echo $this->lang->line('rooms'); ?></div>
										<div style="display: flex; justify-content: center; background-color: white; box-shadow: 0 20px 30px rgba(0,0,0,0.1)">
											<button type="button" class="btn_stepper " id="decrement-room" onClick="stepper(this);"> - </button>
											<input class="input_number" type="number" min="0" max="100" step="1" value="1" name="room" id="room" readonly>
											<button type="button" class="btn_stepper " id="increment-room" onClick="stepper(this);"> + </button>
										</div>
										<div class="rounded hr3 mt-2" style="padding: 5px; font-size: 0.8em;"><?php echo $this->lang->line('notes'); ?>:
											<?php if ($lang == 'english') { ?>
												Please be informed that the maximum age for children is <?php echo app_settings('max_children_age'); ?>
												years old. Kindly add children aged more than <?php echo app_settings('max_children_age'); ?> years as adult.
											<?php } else {
											?>
												เด็กที่จะเข้าพักในโครงการจะต้องเลือกเข้าพักเป็นผู้ใหญ่เท่านั้น
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-6">
						<div class="col-md-12 mb-2 text-left">
							<label for="name">&nbsp;</label>
							<button disabled id="search" class="form-control form-control-btnsearch search_input search_button btn-default btn-search" data-search-type="search_room" style="background-color:#81BB4A;cursor: pointer; display: flex; align-items: center; justify-content: center; ">
								<?php echo $this->lang->line('search'); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		



		<!-- <div class="col-md-6">
				
				<div class="row">
					<div class="col-md-12 mt-2"><b><?php echo $this->lang->line('search_by_package'); ?></b></div>
					<div class="col-md-6 mb-2">
						<div class="checkbox-dropdown" style="">
						  <?php //echo $this->lang->line('choose_package');
							?>
						  <ul class="checkbox-dropdown-list">
							<?php //foreach ($packages as $package) {
							?>
							<li>
							  <label>
								<input class="package_cbox" type="checkbox" value="<?php echo $package->id_package; ?>" name="package" /><?php echo $package->name; ?></label>
							</li>
							<?php //}
							?>
							
						  </ul>
						</div>
					</div>
				
				<div class="col-md-6">
					<div >
						<button disabled id="search_package" class="form-control search_input search_button btn-default" data-search-type="search_package" style="cursor: pointer; padding: 0 50px 0 50px;"><?php echo $this->lang->line('search_package'); ?></button>
					</div>
				</div>
			</div>
		</div> -->

	</div>
		<!-- Descripttion -->
		<script>
		/*
			document.addEventListener('DOMContentLoaded', function() {
				document.getElementById('readMoreBtn').addEventListener('click', function() {
					var longText = document.querySelector('.long-text');
					var btn = document.getElementById('readMoreBtn');

					if (longText.style.display === 'none') {
						longText.style.display = 'block';
						btn.textContent = 'ซ่อนข้อความ';
					} else {
						longText.style.display = 'none';
						btn.textContent = 'อ่านต่อ';
					}
				});
			});
		*/
		document.addEventListener('DOMContentLoaded', function() {
			document.getElementById('readMoreBtn').addEventListener('click', function() {
				var longText = document.querySelector('.long-text');
				var btn = document.getElementById('readMoreBtn');

				if (longText.style.display === 'none') {
					longText.style.display = 'block';
					btn.innerHTML = '<?php
								if (sizeof($packages) > 0) {
									echo ($lang == 'english') ? 'Read less...' : 'ซ่อนข้อความ...';
								}
							?><i class="fas fa-angle-down"></i>';
				} else {
					longText.style.display = 'none';
					btn.innerHTML = '<?php
								if (sizeof($packages) > 0) {
									echo ($lang == 'english') ? 'Read more...' : 'อ่านต่อ...';
								}
							?><i class="fas fa-angle-up"></i>';
				}
			});
		});

		</script>
		<div class="col-md-12 mb-4 description-banner">
			<div class="section-heading text-center mb-3">
				<a href="https://smsmartbooking.buildersmart.com/project_info" target="_blank" class="a-readmore" id="aboutus">
					<h4 style="font-weight: 600;">
						<?php
							if (sizeof($packages) > 0) {
								echo ($lang == 'english') ? 'SM Resort' : 'SM Resort';
							}
						?>
					</h4>
				</a>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="content">
						<p class="short-text">
							<?php
								if (sizeof($packages) > 0) {
									echo ($lang == 'english') ? 'Relax amidst the stunning scenery, surrounded by nature and fresh air.
SM Resort redefines a new style of accommodation with its modern resort collection under the BuildSmart Group. Located in the picturesque Khao Yai area' : 'เอสเอ็ม รีสอร์ท คือนิยามของที่พักแนวใหม่ คอลเลคชั่นรีสอร์ททันสมัย ในเครือของบริษัท บิวเดอสมาร์ท พร้อมการพลิกโฉมใหม่อย่างโดดเด่นบนพื้นที่เขาใหญ่';
								}
							?>
						</p>
						<p class="long-text">
							<?php
								if (sizeof($packages) > 0) {
									echo ($lang == 'english') ? 'SM Resort redefines a new style of accommodation with its modern resort collection under the BuildSmart Group. Located in the picturesque Khao Yai area, SM Resort offers a remarkable transformation to welcome guests. With various activities available, we are ready to provide a new kind of experience for travelers. Additionally, we host a variety of gatherings and events, ensuring to create precious memories for you. <a href="https://smsmartbooking.buildersmart.com/project_info" target="_blank" class="em-readmore"><em><i class="fas fa-angle-double-left"></i>Read more...<i class="fas fa-angle-double-right"></i></em></a>' : ' เพื่อต้อนรับแขกผู้มาเยือน พร้อมทั้งมีกิจกรรมต่างๆมากมาย พร้อมแล้วที่จะมอบประสบการณ์ในแบบฉบับใหม่ให้กับนักเดินทาง  รวมถึงงานเลี้ยงสังสรรค์ต่างๆ ที่พร้อมแล้วที่จะสร้างความทรงจำอันล้ำค่าเพื่อคุณ  <a href="https://smsmartbooking.buildersmart.com/project_info" target="_blank" class="em-readmore"><em><i class="fas fa-angle-double-left"></i>อ่านต่อ...<i class="fas fa-angle-double-right"></i></em></a>';
								}
							?>
						</p>
						<!--<button id="readMoreBtn" class="mt-3">อ่านต่อ...</button>-->
						<span id="readMoreBtn" class="readmore-toggle">
							<?php
								if (sizeof($packages) > 0) {
									echo ($lang == 'english') ? 'Read more...' : 'อ่านต่อ...';
								}
							?>
							<i class="fas fa-angle-up"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
		<!-- Descripttion -->
</div>

<!-- PROMOTION & PACKAGE -->
<div class="slider-wrapper slider1-wrapper" style="padding-top: 30px;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12"> 
				<h4 style="text-align: center; padding-bottom: 15px;" id="nav_packagep_promotions">
					<a id="package" href="javascript:;" class="tx-title-header">
						<?php echo $lang == "english" ? 'Package & Promotions' : 'แพ็คเกจและโปรโมชั่น'; ?>
					</a>
				</h4>
				<div id="carouselExampleControls-Package" class="carousel slide" data-bs-ride="carousel">
				  <div class="carousel-inner-packgage">
					<div class="carousel-item active">
					  <div class="cards-wrapper">
						<div class="card">
						  <div class="image-wrapper">
							<img class="package-img" src="https://sharefolder.buildersmart.com/sms_booking/upload/package_photo/8_648ad3a488cab.jpg" alt="...">
						  </div>
						  <div class="card-body">
							<h5 class="package-tx-title">SM Resort Showroom @ Khaoyai</h5>
							<p class="package-tx-sub">Promotion package rent out all rooms for @24 Persons (MAX)</p>
							<p class="package-tx-line mt-2">THB19,800</p>
							<p class="package-tx">THB19,300</p>
							<p class="package-period-tt mt-2">
								<span>Promo period</span>
								<!--<span style="float: right;">Min. transaction</span>-->
							</p>
							<p class="package-period">
								<i class="far fa-calendar"></i> &nbsp;<span>01 AUG 2023 - 31 DEC 2024</span>
								<!--<span style="float: right;">THB19,800</span>-->
							</p>
							<div class="discount">
								<p class="discount-title">Discount</p>
								<p class="discount-no">10%</p>
							</div>
							<a href="#" class="btn mt-2 btn-more" style="float: right;">Read More</a>
						  </div>
						</div>
						<div class="card">
						  <div class="image-wrapper">
							<img class="package-img" src="https://sharefolder.buildersmart.com/sms_booking/upload/package_photo/8_648ad3a488cab.jpg" alt="...">
						  </div>
						  <div class="card-body">
							<h5 class="package-tx-title">SM Resort Showroom @ Khaoyai</h5>
							<p class="package-tx-sub">Promotion package rent out all rooms for @24 Persons (MAX)</p>
							<p class="package-tx-line mt-2">THB19,800</p>
							<p class="package-tx">THB19,300</p>
							<p class="package-period-tt mt-2">
								<span>Promo period</span>
							</p>
							<p class="package-period">
								<i class="far fa-calendar"></i> &nbsp;<span>01 AUG 2023 - 31 DEC 2024</span>
							</p>
							<div class="discount">
								<p class="discount-title">Discount</p>
								<p class="discount-no">10%</p>
							</div>
							<a href="#" class="btn mt-2 btn-more" style="float: right;">Read More</a>
						  </div>
						</div>
						<div class="card">
						  <div class="image-wrapper">
							<img class="package-img" src="https://sharefolder.buildersmart.com/sms_booking/upload/package_photo/8_648ad3a488cab.jpg" alt="...">
						  </div>
						  <div class="card-body">
							<h5 class="package-tx-title">SM Resort Showroom @ Khaoyai</h5>
							<p class="package-tx-sub">Promotion package rent out all rooms for @24 Persons (MAX)</p>
							<p class="package-tx-line mt-2">THB19,800</p>
							<p class="package-tx">THB19,300</p>
							<p class="package-period-tt mt-2">
								<span>Promo period</span>
							</p>
							<p class="package-period">
								<i class="far fa-calendar"></i> &nbsp;<span>01 AUG 2023 - 31 DEC 2024</span>
							</p>
							<div class="discount">
								<p class="discount-title">Discount</p>
								<p class="discount-no">10%</p>
							</div>
							<a href="#" class="btn mt-2 btn-more" style="float: right;">Read More</a>
						  </div>
						</div>
					  </div>
					</div>
					<div class="carousel-item">
					  <div class="cards-wrapper">
						<div class="card">
						  <div class="image-wrapper">
							<img class="package-img" src="https://sharefolder.buildersmart.com/sms_booking/upload/package_photo/8_648ad3a488cab.jpg" alt="...">
						  </div>
						  <div class="card-body">
							<h5 class="package-tx-title">SM Resort Showroom @ Khaoyai</h5>
							<p class="package-tx-sub">Promotion package rent out all rooms for @24 Persons (MAX)</p>
							<p class="package-tx-line mt-2">THB19,800</p>
							<p class="package-tx">THB19,300</p>
							<p class="package-period-tt mt-2">
								<span>Promo period</span>
								<!--<span style="float: right;">Min. transaction</span>-->
							</p>
							<p class="package-period">
								<i class="far fa-calendar"></i> &nbsp;<span>01 AUG 2023 - 31 DEC 2024</span>
								<!--<span style="float: right;">THB19,800</span>-->
							</p>
							<div class="discount">
								<p class="discount-title">Discount</p>
								<p class="discount-no">10%</p>
							</div>
							<a href="#" class="btn mt-2 btn-more" style="float: right;">Read More</a>
						  </div>
						</div>
						<div class="card">
						  <div class="image-wrapper">
							<img class="package-img" src="https://sharefolder.buildersmart.com/sms_booking/upload/package_photo/8_648ad3a488cab.jpg" alt="...">
						  </div>
						  <div class="card-body">
							<h5 class="package-tx-title">SM Resort Showroom @ Khaoyai</h5>
							<p class="package-tx-sub">Promotion package rent out all rooms for @24 Persons (MAX)</p>
							<p class="package-tx-line mt-2">THB19,800</p>
							<p class="package-tx">THB19,300</p>
							<p class="package-period-tt mt-2">
								<span>Promo period</span>
							</p>
							<p class="package-period">
								<i class="far fa-calendar"></i> &nbsp;<span>01 AUG 2023 - 31 DEC 2024</span>
							</p>
							<div class="discount">
								<p class="discount-title">Discount</p>
								<p class="discount-no">10%</p>
							</div>
							<a href="#" class="btn mt-2 btn-more" style="float: right;">Read More</a>
						  </div>
						</div>
						<div class="card">
						  <div class="image-wrapper">
							<img class="package-img" src="https://sharefolder.buildersmart.com/sms_booking/upload/package_photo/8_648ad3a488cab.jpg" alt="...">
						  </div>
						  <div class="card-body">
							<h5 class="package-tx-title">SM Resort Showroom @ Khaoyai</h5>
							<p class="package-tx-sub">Promotion package rent out all rooms for @24 Persons (MAX)</p>
							<p class="package-tx-line mt-2">THB19,800</p>
							<p class="package-tx">THB19,300</p>
							<p class="package-period-tt mt-2">
								<span>Promo period</span>
							</p>
							<p class="package-period">
								<i class="far fa-calendar"></i> &nbsp;<span>01 AUG 2023 - 31 DEC 2024</span>
							</p>
							<div class="discount">
								<p class="discount-title">Discount</p>
								<p class="discount-no">10%</p>
							</div>
							<a href="#" class="btn mt-2 btn-more" style="float: right;">Read More</a>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  <!-- Have a problem prev and next -->
				  <!--
				  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls-Package" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				  </button>
				  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls-Package" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				  </button>
				  -->
				</div>
			</div> 
		</div> 
	</div> 
</div>
<script>
	const multipleItemCarousel = document.querySelector("#carouselExampleControls-Package");
		if (window.matchMedia("(min-width:576px)").matches) {
		  const carousel = new bootstrap.Carousel(multipleItemCarousel, {
			interval: false
		  });

		  var carouselWidth = $(".carousel-inner-packgage")[0].scrollWidth;
		  var cardWidth = $(".carousel-item").width();

		  var scrollPosition = 0;

		  $(".carousel-control-next").on("click", function () {
			if (scrollPosition < carouselWidth - cardWidth * 4) {
			  scrollPosition = scrollPosition + cardWidth;
			  $(".carousel-inner-packgage").animate({ scrollLeft: scrollPosition }, 600);
			}
		  });
		  $(".carousel-control-prev").on("click", function () {
			if (scrollPosition > 0) {
			  scrollPosition = scrollPosition - cardWidth;
			  $(".carousel-inner-packgage").animate({ scrollLeft: scrollPosition }, 600);
			}
		  });
		} else {
		  $(multipleItemCarousel).addClass("slide");
		}
		*/
</script>
<!-- PROMOTION & PACKAGE -->

<!-- Package -->
<!--
<div class="section mt-4">
	<div class="container">
		<div class="col-md-12 mb-4 ">
			<div class="section-heading text-center">
				<h5>
					<?php
					if (sizeof($packages) > 0) {
						echo ($lang == 'english') ? 'Package' : 'แพ็คเกจ';
					}
					?>
				</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<swiper-container slides-per-view="<?= count($packages) > 2 ? 2 : (count($packages) == 1 ? 1 : 1); ?>">
					<?php foreach ($packages as $package) { ?>
						<swiper-slide>
							<img src="<?php echo share_folder_path() . $package->package_photo_url; ?>" alt="Image" class="img-fluid" />
							<div class="property-content mt-3">
								<div class="mb-2 eclipes-name"><span><?php echo $package->name; ?></span></div>
								<div>
									<span class="d-block mb-2 text-black-50"><?php echo ($lang == 'english') ? 'Price' : 'ราคา'; ?> <?php echo number_format($package->price); ?> <?php echo ($lang == 'english') ? 'Baht' : 'บาท'; ?></span>
									<span class="city d-block mb-3"></span>

									<div class="specs d-flex mb-4">
										<span class="d-block d-flex align-items-center me-3">
											<span class="icon-bed me-2"></span>
											<span class="caption"></span>
										</span>
										<span class="d-block d-flex align-items-center">
											<span class="icon-bath me-2"></span>
											<span class="caption"></span>
										</span>
									</div>
									<div class="col text-center">
										<a href="<?php echo site_url('package/package_details') . '/' . $package->id_package; ?>" class="btn btn-primary-w btn btn-detail-color py-2 px-3"><?php echo ($lang == 'english') ? 'Details' : 'รายละเอียด'; ?> </a>
									</div>
								</div>
							</div>
						</swiper-slide>
					<?php } ?>
				</swiper-container>
			</div>
		</div>
	</div>
</div>
-->
<!-- End Package -->

<!-- Room Types -->



<div class="container mt-5">
	<div class="row text-center mb-0" id="nav_roomstype">
		<div class="col-md-12">
			<h4>
				<a id="roomtype" href="javascript:;" class="tx-title-header"><?php //echo $this->lang->line('room_types'); ?>
					<?php echo ($lang == 'english') ? "Room Types" : "ประเภทของห้อง" ?>
				</a>
			</h4>
		</div>
	</div>
	
	<!-- New Room Types -->
	<!--
	<div class="row">
		<?php
			$ctr = 0;
			$date = date('Y-m-d');
			foreach ($room_types as $key => $rt) {
				$rate = $CI->m_room_type->get_day_rate($rt->id_room_type, $date);
				if ($rate == '') {
					$rate = $rt->default_rate;
				}
				$photos = $CI->m_room_type->get_room_type_photos($rt->id_room_type);
		?>
		<div class="col-md-12 ml-2 text-center mt-4">
			<div class="header">
				<div class="pl-4 text-left">
					<a href="http://192.168.20.22/sm_booking1/detail.php" target="_blank">
						<h5 class="roomtype-tx-title"><?php echo ($lang == 'english') ? $rt->room_type_name_en : $rt->room_type_name_th; ?></h5>
					</a>
				</div>
			</div>
		</div>
		<?php $ctr++;
		} ?>
	</div>
	-->

<!-- -------------------------------New Room Types------------------------------------- -->

	<?php 
		$CI = &get_instance();
		$room_types = $CI->db->get('room_type')->result();
		$room_details = $CI->db->get('room_type')->result();
		$highlights = $CI->db->get('project_highlights')->result();
		$amenities = $CI->db->get('room_type_amenities')->result();
		$point_of_interest = $CI->db->get('point_of_interest')->result();
		$policies = $CI->db->get('project_policy')->result();
		
		$index = 0;
		foreach ($room_types as $key => $rt) {
			$rate = $CI->m_room_type->get_day_rate($rt->id_room_type, $date);
			if ($rate == '') {
				$rate = $rt->default_rate;
			}
			$photos = $CI->m_room_type->get_room_type_photos($rt->id_room_type);

			// Determine if current row should be left or right
			$isLeft = ($index % 2 == 0);
			
			$room_type_en = $rt->room_type_name_en;
			$room_type_th = $rt->room_type_name_th;
			

    ?>
	
	<div class="col-md-12 ml-2 text-center mt-4">
		<div class="header">
			<div class="pl-4 text-center mt-4 mb-4">
				<a href="http://192.168.20.22/sm_booking1/detail.php" target="_blank">
					<!--<h4 class="roomtype-tx-title"><?php echo $room_type_en . " - " . $room_type_th; ?></h4>-->
					<h4 class="roomtype-tx-title"><?php echo $room_type_en ; ?></h4>

				</a>
			</div>
		</div>
	</div>



    <div class="row mb-4">
		
        <!--<div class="col-md-6 col-sm-12 <?php echo $isLeft ? '' : 'order-md-2'; ?>" style="border: 1px solid #cccccc52; border-radius: 5px; box-shadow: rgb(0 0 0 / 9%) 0px 1px 4px 1px;">-->
		<div class="col-md-6 col-sm-12 <?php echo $isLeft ? '' : 'order-md-2'; ?>" >

            <div class="accordion" id="accordionExample<?php echo $index; ?>" style="padding: 0 8px;">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOneInfo<?php echo $index; ?>">
                        <button class="accordion-button collapsed button-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneInfo<?php echo $index; ?>" aria-expanded="false" aria-controls="collapseOne">
                            <?php
                                if (sizeof($packages) > 0) {
                                    echo ($lang == 'english') ? 'Room Information' : 'รายละเอียดห้อง';
                                }
                            ?>
                        </button>
                    </h2>
                    <div id="collapseOneInfo<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="headingOneInfo<?php echo $index; ?>" data-bs-parent="#accordionExample<?php echo $index; ?>">
                        <div class="accordion-body">
                            <div class="col-md-12" style="padding-right: 0;">
                                <div class="row">
								<!--
                                    <div class="row mx-auto mt-2">
                                        <div class="col-3 mx-auto icon_container">
                                            <span class="icon-content"><object data="http://192.168.20.22/smartbooking_front_test/images/icons/house.svg" height="20"></object></span>
                                        </div>
                                        <div class="col-9 icon_container">
                                            <span class="icon-content"><?php echo ($lang == 'english') ? 'Area 18 Sq.m' : 'ขนาดพื้นที่ห้อง: 18 ตรม.'; ?></span>
                                        </div>
                                    </div>

                                    <div class="row mx-auto mt-2">
                                        <div class="col-3 text-left icon_container">
                                            <span class="icon-content"><object data="https://sharefolder.buildersmart.com/sms_booking/images/icons/icons8-bedroom-50.png" height="18"></object></span>
                                        </div>
                                        <div class="col-9 text-left icon_container">
                                            <span class="icon-content"><?php echo ($lang == 'english') ? '1 Queen-bed' : 'ห้องนอน: 1 (Queen-Bed)'; ?></span>
                                            
                                        </div>
                                    </div>
								-->
									<?php
                                    foreach ($room_details as $detail) {
                                        if ($detail->id_room_type == $rt->id_room_type) { ?>
                                            <div class="row mx-auto mt-2">
                                                <div class="col-3 mx-auto icon_container">
                                                    <span class="icon-content">
                                                        <object data="http://192.168.20.22/smartbooking_front_test/images/icons/house.svg" height="20"></object>
                                                    </span>
                                                </div>
                                                <div class="col-9 icon_container">
                                                    <span class="icon-content"><?php echo ($lang == 'english') ? $detail->area_en : $detail->area_th; ?></span>
                                                </div>
                                            </div>

                                            <div class="row mx-auto mt-2">
                                                <div class="col-3 text-left icon_container">
                                                    <span class="icon-content">
                                                        <object data="https://sharefolder.buildersmart.com/sms_booking/images/icons/icons8-bedroom-50.png" height="18"></object>
                                                    </span>
                                                </div>
                                                <div class="col-9 text-left icon_container">
                                                    <span class="icon-content"><?php echo ($lang == 'english') ? $detail->room_details_en : $detail->room_details_th; ?></span>
                                                </div>
                                            </div>
                                        <?php }
                                    } ?>
								
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne<?php echo $index; ?>">
                        <button class="accordion-button collapsed button-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?php echo $index; ?>" aria-expanded="false" aria-controls="collapseOne">
                            <?php
                                if (sizeof($packages) > 0) {
                                    echo ($lang == 'english') ? 'Highlights' : 'ไฮไลท์';
                                }
                            ?>
                        </button>
                    </h2>
                    <div id="collapseOne<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne<?php echo $index; ?>" data-bs-parent="#accordionExample<?php echo $index; ?>">
                        <div class="accordion-body">
                            <div class="col-md-12" style="padding-right: 0;">
                                <div class="row">
								<!--
                                    <div class="col-sm-3 mb-2 text-center">
                                        <img src="http://192.168.20.22/sm_booking1/includes/image.php?filename=upload/project_highlight/1_63bb731cd4018.png" class="icon-service"><br>
                                        <h6 class="mt-1 tx-service">
                                            <?php
                                                if (sizeof($packages) > 0) {
                                                    echo ($lang == 'english') ? 'Wifi' : 'ไวไฟ';
                                                }
                                            ?>
                                        </h6>
                                    </div>
								
                                    <div class="col-sm-3 mb-2 text-center">
                                        <img src="http://192.168.20.22/sm_booking1/includes/image.php?filename=upload/project_highlight/1_63bb7dd7c487e.png" class="icon-service"><br>
                                        <h6 class="mt-1 tx-service">
                                            <?php
                                                if (sizeof($packages) > 0) {
                                                    echo ($lang == 'english') ? 'Mountain View' : 'วิวภูเขา';
                                                }
                                            ?>
                                        </h6>
                                    </div>
								-->
									<?php foreach ($highlights as $highlight) { ?>
										<div class="col-sm-3 mb-2 text-center">
											<img src="http://192.168.20.22/sm_booking1/includes/image.php?filename=<?php echo $highlight->icon; ?>" class="icon-service"><br>
											<h6 class="mt-1 tx-service">
												<?php
													echo ($lang == 'english') ? $highlight->description_en : $highlight->description_th;
												?>
											</h6>
										</div>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne<?php echo $index; ?>">
                        <button class="accordion-button collapsed button-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo<?php echo $index; ?>" aria-expanded="false" aria-controls="collapseOne">
                            <?php
								if (sizeof($packages) > 0) {
									echo ($lang == 'english') ? 'Facilities & Amenities' : 'สาธารณูปโภค & สิ่งอำนวยความสะดวก';
								}
							?>
                        </button>
                    </h2>
                    <div id="collapseTwo<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne<?php echo $index; ?>" data-bs-parent="#accordionExample<?php echo $index; ?>">
                        <div class="accordion-body">
                            <div class="col-md-12" style="padding-right: 0;">
                                <div class="row">
                                    <?php foreach ($amenities as $amenity) {
                                            if ($amenity->id_room_type == $rt->id_room_type) { ?>
                                                <div class="col-sm-3 mb-4 text-center">
                                                    <img src="http://192.168.20.22/sm_booking1/includes/image.php?filename=<?php echo $amenity->icon; ?>" class="icon-service">
                                                    <h6 class="mt-1 tx-service"><?php echo ($lang == 'english') ? $amenity->desc_en : $amenity->desc_th; ?></h6>
                                                </div>
                                        <?php }
                                        } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne<?php echo $index; ?>">
                        <button class="accordion-button collapsed button-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree<?php echo $index; ?>" aria-expanded="false" aria-controls="collapseOne">
                            <?php
								if (sizeof($packages) > 0) {
									echo ($lang == 'english') ? 'Nearby Locations' : 'สถานที่ใกล้เคียง';
								}
							?>
                        </button>
                    </h2>
                    <div id="collapseThree<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne<?php echo $index; ?>" data-bs-parent="#accordionExample<?php echo $index; ?>">
                        <div class="accordion-body">
                            <div class="col-md-12" style="padding: 0;">		
								<div class="table-responsive" style="font-size: small; line-height: 15px;">
									<table class="table table-bordered" style="border-color: #ccc !important;">
										<tbody>
											<tr class="text-center">
                                        <th class="location">
                                            <?php echo ($lang == 'english') ? 'Location' : 'ชื่อสถานที่'; ?>
                                        </th>
                                        <th class="location">
                                            <?php echo ($lang == 'english') ? 'Distance(km)' : 'ระยะทาง(km)'; ?>
                                        </th>
                                    </tr>
                                    <?php foreach ($point_of_interest as $poi) { ?>
                                        <tr>
                                            <td class="location">
                                                <span class="location">
                                                    <?php echo ($lang == 'english') ? $poi->location_name_en : $poi->location_name_th; ?>
                                                </span>
                                            </td>
                                            <td class="location">
                                                <span class="location" style="float: right;">
                                                    <?php echo $poi->distance_km . ' ' . (($lang == 'english') ? 'km' : 'ม.'); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php } ?>
										</tbody>
									</table>  
								</div>		
							</div>
                        </div>
                    </div>
                </div>
				
				<div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne<?php echo $index; ?>">
                        <button class="accordion-button collapsed button-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour<?php echo $index; ?>" aria-expanded="false" aria-controls="collapseOne">
                            <?php
								if (sizeof($packages) > 0) {
									echo ($lang == 'english') ? 'Conditions And Policies' : 'เงื่อนไขและข้อกำหนดในการเข้าพัก';
								}
							?>
                        </button>
                    </h2>
                    <div id="collapseFour<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne<?php echo $index; ?>" data-bs-parent="#accordionExample<?php echo $index; ?>">
                        <div class="accordion-body">
                            <div class="col-md-12" style="padding: 0;">
								<span>
									<u>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'Cancellation Policy' : 'นโยบายการยกเลิกการจอง';
										}
										?>
									</u>
								</span>
								<ol>
									<li>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'Payment transfer should be done within 2 hours after booking. If not transferred, the system will automatically cancel the booking.' : 'การโอนเงินต้องเสร็จสิ้นภายใน 2 ชั่วโมงหลังการจอง มิฉะนั้นระบบจะยกเลิกการจองโดยอัตโนมัติ';
										}
										?>
									</li>
								</ol>
								<span>
									<u>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'Showroom Policy' : 'นโยบายโชว์รูม';
										}
										?>
									</u>
								</span>
								<ol>
									<li>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'Hotel check-in time is 02:00 PM, check-out time is 12:00 PM. If check-in early or check-out late, there is a ฿500/Hr extra charge as per showroom condition.' : 'เวลาเช็คอิน 14.00 น. เวลาเช็คเอ้าท์ 12.00 น. หากเข้าพักก่อน หรือ เช็คเอ้าท์เกิน ชั่วโมงละ 500 บาท ตามเงื่อนไขโชว์รูม';
										}
										?>
									</li>
									<li>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'Pets are not allowed in the showroom area.' : 'ไม่อนุญาตให้นำสัตว์เลี้ยงเข้าพักภายในบริเวณโชว์รูม';
										}
										?>
									</li>
									<li>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'Cooking is not allowed in the room area, except in the area provided by the showroom.' : 'ไม่อนุญาตให้ประกอบอาหารภายในบริเวณที่พัก ยกเว้นเฉพาะพื้นที่ที่ทางโชว์รูมจัดไว้ให้เท่านั้น';
										}
										?>
									</li>
									<li>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'Please remain silent between 10:00 PM and 06:00 AM.' : 'ขอความกรุณางดใช้เสียง ตั้งแต่เวลา 22.00 น. - 06.00 น.';
										}
										?>
									</li>
									<li>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'In case guests damage showroom properties, they must compensate monetarily for the value of the properties.' : 'ในกรณีทำให้ทรัพย์สินของโชว์รูมเสียหาย ลูกค้าต้องชดใช้คืนตามมูลค่าของทรัพย์สินนั้น';
										}
										?>
									</li>
									<li>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'Smoking is not allowed in the room area and showroom area, except in the area provided by the showroom. Violators will be fined ฿2,000.' : 'งดสูบบุหรี่ในห้องพัก และบริเวณโชว์รูม ฝ่าฝืนปรับ 2,000 บาท (ลูกค้าสามารถสูบบุหรี่ในพื้นที่ที่โชว์รูมจัดไว้ให้เท่านั้น)';
										}
										?>
									</li>
									<li>
										<?php
										if (sizeof($packages) > 0) {
											echo ($lang == 'english') ? 'Fireworks, crackers, or sky lantern ignitions are not allowed in the showroom area. Violators will be fined ฿2,000.' : 'งดจุดพลุ, ประทัด, ดอกไม้ไฟ หรือ โคมลอย ในบริเวณโชว์รูม ฝ่าฝืนปรับ 2,000 บาท';
										}
										?>
									</li>
								</ol>
							</div>

                        </div>
                    </div>
                </div>
				
				<div class="footer mt-3 mb-2" style="justify-content: flex-start;">
					<div class="ml-2 text-right">
						<div class="ml-2 text-right">
							<button class="btn button-primary-w add_to_cart btn-add_to_cart" data-id="1" data-price="1500" id="" style="margin-right: 5px;" fdprocessedid="t8mt0r">
								<?php
									if (sizeof($packages) > 0) {
										echo ($lang == 'english') ? 'Add To Cart' : 'เก็บใส่ตะกร้า';
									}
								?>
							</button>
							<a href="javascript:;" data-roomtype="1" class="btn button-primary book_now book_now:hover" id="" style="margin-left: 5px;">
								<?php
									if (sizeof($packages) > 0) {
										echo ($lang == 'english') ? 'Book Now' : 'จองตอนนี้';
									}
								?>
							</a>
						</div>
					</div>
				</div>
				
            </div>
			
        </div>

        <div class="col-md-6 col-sm-12 <?php echo $isLeft ? 'order-md-1' : ''; ?>">
            <div class="cards-wrapper">
                <div class="card card-roomtype img-sec">                
                    <div class="hover-img " style="width: 100%; height: 100%;">
                        <?php //foreach ($photos as $ctr1 => $photo) { ?>
                        <a href="javascript:;"> 
                            <img src="<?php echo share_folder_path() . $photos[0]->room_photo_url; ?>" class="img-fluid" alt="Room Image">
                            <!-- <img class="room_img img-thumbnail" data-type="<?php echo $ctr; ?>" data-ctr="<?php //echo $ctr1; ?>" src="<?php //echo share_folder_path() . $photo->room_photo_url; ?>" width="100%"> -->
                        </a>
                        <?php //} ?>
                    </div>

                    <?php
                        $price = ($lang == 'english') ? number_format($rate, 0) . '/Night' : 'ราคา ' . number_format($rate, 0) . '/คืน';
                    ?>
                    <span style="font-size: smaller;"><?php echo $price; ?></span>                                 
                </div>
            </div>
        </div>

    </div>
    <?php $index++; } ?>



	

<!-- -------------------------------End New Room Types------------------------------------- -->

<!-- Room Types -->

<div class="container mt-1">
	<div class="header">
		<div class="pl-4 text-center mt-4 mb-4">
			<a href="http://192.168.20.22/sm_booking1/detail.php" target="_blank">
				<h4 class="roomtype-tx-title">
					<?php echo ($lang == 'english') ? $rt->room_type_name_en : $rt->room_type_name_th; ?>
				</h4>
				<p><?php echo ($lang == 'english') ? $rt->modular_type_en : $rt->modular_type_th; ?></p>
			</a>
		</div>
	</div>


	<div class="row">

		<?php
		$ctr = 0;
		$date = date('Y-m-d');
		foreach ($room_types as $key => $rt) {
			$rate = $CI->m_room_type->get_day_rate($rt->id_room_type, $date);
			if ($rate == '') {
				$rate = $rt->default_rate;
			}
			$photos = $CI->m_room_type->get_room_type_photos($rt->id_room_type);
		?>
			<div class="col-md-6 mt-4">
				<div class="product-card">
					<div class="header">
						<div class="pl-4 text-left">
							<a href="http://192.168.20.22/sm_booking1/detail.php" target="_blank">
								<h5 class="roomtype-tx-title"><?php echo ($lang == 'english') ? $rt->room_type_name_en : $rt->room_type_name_th; ?></h5>
							</a>
						</div>
					</div>
					<div class="content-product">
						<div class="content-image">
							<div class="slideshow m-0 p-0" id="slideshow-<?php echo $key; ?>">
								<?php
								foreach ($photos as $ctr1 => $photo) {
								?>
									<div style="">
										<img class="room_img img-thumbnail" data-type="<?php echo $ctr; ?>" data-ctr="<?php echo $ctr1; ?>" src="<?php echo share_folder_path() . $photo->room_photo_url; ?>" width="100%">
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="content-detail">
							<div class="row mb-3 mt-2 price">
								<div class="col-md-12 mx-0 text-center">
									<?php
									$price = ($lang == 'english') ? number_format($rate, 0) . '/Night' : 'ราคา ' . number_format($rate, 0) . '/คืน';
									?>
									<div class="price"><b><?php echo $price; ?></b></div>
								</div>
							</div>
							<div class="row mx-auto mt-2">
								<div class="col-3 mx-auto icon_container">
									<span class="icon-content"><object data="<?php echo site_url(); ?>images/icons/house.svg" height="20"></object></span>
								</div>
								<div class="col-9 icon_container">
									<span class="icon-content"><?php echo $lang == 'english' ? $rt->area_en : $rt->area_th; ?></span>
								</div>
							</div>
							<div class="row mx-auto mt-2">
								<div class="col-3 text-left icon_container">
									<!-- <span class="icon-content"><img class="icon" src="<?php echo share_folder_path(); ?>images/icons/icons8-bedroom-50.png" height="18"></span> -->
									<span class="icon-content"><object data="<?php echo share_folder_path(); ?>images/icons/icons8-bedroom-50.png" height="18"></object></span>
								</div>
								<div class="col-9 text-left icon_container">
									<span class="icon-content"><?php echo $lang == 'english' ? $rt->room_details_en : $rt->room_details_th; ?></span>
								</div>
							</div>
							<div class="row mx-auto mt-2">
								<div class="col-3 text-left icon_container">
									<span class="icon-content  ml-1"><object data="<?php echo share_folder_path(); ?>images/icons/bathroom.png" height="18"></object></span>
								</div>
								<div class="col-9 text-left icon_container">
									<span class="icon-content"><?php echo $lang == 'english' ? $rt->bathroom_en : $rt->bathroom_th; ?></span>
								</div>
							</div>
							<div class="row mx-auto mt-2">
								<div class="col-3 text-left icon_container">
									<span class="icon-content" style="margin-left:1px;"><object data="<?php echo share_folder_path(); ?>images/icons/person-fill.svg" height="18"></object></span>
								</div>
								<div class="col-9 text-left icon_container">
									<span class="icon-content"><?php echo $lang == 'english' ? $rt->number_of_adults . ' Adults' : 'จำนวนผู้เข้าพัก: ' . $rt->number_of_adults; ?></span>
								</div>
							</div>
							<div class="row mx-auto mt-2">
								<div class="col-3 text-left icon_container">
									<object data="<?php echo share_folder_path(); ?>images/icons/tv.svg" height="20"> </object>
								</div>
								<div class="col-9 text-left icon_container">
									<span class="icon-content">TV (Internet)</span>
								</div>
							</div>
							<div class="row mx-auto mt-2">
								<div class="col-3 text-left icon_container">
									<span class="icon-content"><object data="<?php echo share_folder_path(); ?>images/icons/snow.svg" height="20"> </object></span>
								</div>
								<div class="col-9 text-left icon_container">
									<span class="icon-content"><?php echo $lang == 'english' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
								</div>
							</div>
							<div class="row mx-auto mt-2">
								<div class="col-3 text-left icon_container">
									<span class="icon-content"><object data="<?php echo share_folder_path(); ?>images/icons/wifi.svg" height="20"> </object></span>
								</div>
								<div class="col-9 text-left icon_container">
									<span class="icon-content">Free WIFI</span>
								</div>
							</div>
							<?php if ($rt->sofa_en != '') { ?>
								<div class="row mx-auto mt-2">
									<div class="col-3 text-left icon_container">
										<span class="icon-content" style="font-size:16px; margin-top:-2px;">
											<object data="<?php echo share_folder_path(); ?>images/icons/sofa.png" height="14"></object>
										</span>
									</div>
									<div class="col-9 text-left icon_container">
										<span class="icon-content"><?php echo $lang == 'english' ? $rt->sofa_en : $rt->sofa_th; ?></span>
									</div>
								</div>
							<?php } ?>

						</div>
					</div>
					<div class="footer">
						<div class="ml-2 text-right">
							<button class="btn button-primary-w add_to_cart btn-add_to_cart" data-id="<?php echo $rt->id_room_type; ?>" data-price="<?php echo $rt->default_rate; ?>" id="" style="margin-right: 5px;"><?php echo $this->lang->line('add_to_cart'); ?></button>
							<a href="javascript:;" data-roomtype="<?php echo $rt->id_room_type; ?>" class="btn button-primary book_now" id="" style="margin-left: 5px;"><?php echo $this->lang->line('book_now'); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php $ctr++;
		} ?>

	</div>
</div>

<form name="frm_room" id="frm_room" method="post" action="<?php echo site_url('room_details'); ?>">
	<input type="hidden" name="project_id" id="project_id" value="">
	<input type="hidden" name="h_id_room_type" id="h_id_room_type" value="">
	<input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="">
	<input type="hidden" name="h_num_of_room" id="h_num_of_room" value="">
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

					<!-- Sliding images stating here -->
					<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<?php
							$ctr = 1;
							foreach ($project_photos as $h) {
							?>
								<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $ctr - 1; ?>" class="slide <?php echo $ctr; ?>"></li>
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
								<div class="carousel-item <?php echo $ctr; ?> active">
									<img class="d-block w-100" src="<?php echo share_folder_path() . $h->project_photo_url; ?>" alt="slide <?php echo $ctr; ?>">
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
<?php foreach ($types_photos as $key => $tp) { ?>
	<input type="hidden" name="hiddentype_<?php echo $key ?>" id="hiddentype_<?php echo $key ?>" value='<?php echo json_encode($tp); ?>' />
<?php } ?>


<!-- Modal Rooms -->
<div class="container text-center">
	<div class="modal fade" id="ModalRoomCarousel" tabindex="-1" role="dialog" aria-labelledby="ModalRoomCarouselLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

					<!-- Sliding images stating here -->
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

<!-- facilities & amenities and nearby location-->
<!--
<div class="container mt-5">
	<div class="row">
		<div class="col-md-12 ml-2 text-center mt-4">
			<h4 style="text-align: center; padding-bottom: 15px;" id="nav_packagep_promotions">
				<a id="nearby_locations" href="javascript:;" class="tx-title-header">
					<?php echo $lang == "english" ? 'Facilities & Amenities and Nearby Locations' : 'สิ่งอำนวยความสะดวก และ สถานที่ใกล้เคียง'; ?>
				</a>
			</h4>
		</div>
	</div>
	<div class="row mb-0" id="nav_roomstype">
		<div class="col-md-12 amenities-nearby-column">
			<div class="col-md-8">
			<div class="section_header "id="facilities_amenities">
				<h6 style="font-weight: 600;">รายละเอียดโครงการ</h6>
			</div>		
			<div class="row mb-2">	
				<div class="container-fluid mb-4">		
					<div class="col-md-12">			
		    			<span>เอส เอ็ม รีสอร์ท โชว์รูม เขาใหญ่</span>
		    		</div>
		    	</div>
			</div>
	
			<div class="section_header "><u>จุดเด่นของโครงการ</u></div>
			<div class="row mb-2">			
				<div class="container-fluid mb-4">
					<div class="col-md-12">		
						<div class="h_container" style="display: flex; flex-direction: row; ">	
		    				<div style="bottom: 0; padding-right: 50px;">
								&nbsp;<img src="https://sharefolder.buildersmart.com/sms_booking/upload/project_highlight/1_63bb731cd4018.png" width="18">
								<span class="highlights_desc" style="font-size: 1.1em;">ไวไฟ</span>
		    				</div>
		    				<div style="bottom: 0; padding-right: 50px;">
								&nbsp;<img src="https://sharefolder.buildersmart.com/sms_booking/upload/project_highlight/1_63bb7dd7c487e.png" width="18">
								<span class="highlights_desc" style="font-size: 1.1em;">วิวภูเขา</span>
		    				</div>
		    			</div>		
		    		</div>
				</div>
			</div>
			
			<div class="section_header "><u>สิ่งอำนวยความสะดวกของโครงการ</u></div>
				<div class="row">			
					<div class="container-fluid mb-4">
						<div class="col-md-12">	
							<div class="row" id="pj-con">	
								<div class="col-md-6" style="bottom: 0; ">
								
								<input type="checkbox" checked="checked" style="vertical-align:middle; pointer-events:none;">
								&nbsp;<img src="https://sharefolder.buildersmart.com/sms_booking/upload/facility_icon/24_63bba1a28104f.png" width="18">
								<span class="highlights_desc" style="font-size: 1.1em;"> สวน</span>
								</div>
												<div class="col-md-6" style="bottom: 0; ">
								
								<input type="checkbox" checked="checked" style="vertical-align:middle; pointer-events:none;">
								&nbsp;<img src="https://sharefolder.buildersmart.com/sms_booking/upload/facility_icon/2_63bb9f9e65dcb.png" width="18">
								<span class="highlights_desc" style="font-size: 1.1em;"> ไวไฟฟรี</span>
								</div>
												<div class="col-md-6" style="bottom: 0; ">
								
								<input type="checkbox" checked="checked" style="vertical-align:middle; pointer-events:none;">
								&nbsp;<img src="https://sharefolder.buildersmart.com/sms_booking/upload/facility_icon/21_63bba16c5dc37.png" width="18">
								<span class="highlights_desc" style="font-size: 1.1em;"> บริการทำความสะอาดรายวัน</span>
								</div>
												<div class="col-md-6" style="bottom: 0; ">
								
								<input type="checkbox" checked="checked" style="vertical-align:middle; pointer-events:none;">
								&nbsp;<img src="https://sharefolder.buildersmart.com/sms_booking/upload/facility_icon/1_641d577616c9f.png" width="18">
								<span class="highlights_desc" style="font-size: 1.1em;"> วิวภูเขา</span>
								</div>
							
							</div>	
						</div>
					</div>
				</div>
	
				<div class="section_header "><u>เงื่อนไขและข้อกำหนดในการเข้าพัก</u></div>
					<div class="row">			
						<div class="container-fluid mb-4">
							<div class="col-md-12">			
								<span>นโยบายการยกเลิกการจอง</span>
								<ol>		
									<li>การโอนเงินต้องเสร็จสิ้นภายใน 2 ชั่วโมงหลังการจอง มิฉะนั้นระบบจะยกเลิกการจองโดยอัตโนมัติ</li>			
								</ol>
								<span>นโยบายโชว์รูม</span>    			
								<ol>
									<li>เวลาเช็คอิน 14.00 น. เวลาเช็คเอ้าท์ 12.00 น. หากเข้าพักก่อน หรือ เช็คเอ้าท์เกิน ชั่วโมงละ 500 บาท ตามเงื่อนไขโชว์รูม</li>				
									<li>ไม่อนุญาตให้นำสัตว์เลี้ยงเข้าพักภายในบริเวณโชว์รูม</li>					
									<li>ไม่อนุญาตให้ประกอบอาหารภายในบริเวณที่พัก ยกเว้นเฉพาะพื้นที่ที่ทางโชว์รูมจัดไว้ให้เท่านั้น</li>					
									<li>ขอความกรุณางดใช้เสียง ตั้งแต่เวลา 22.00 น. - 06.00 น.</li>					
									<li>ในกรณีทำให้ทรัพย์สินของโชว์รูมเสียหายให้ชดใช้คืนตามมูลค่าของทรัพย์สินนั้น</li>					
									<li>งดสูบบุหรี่ในห้องพัก และบริเวณโชว์รูม ฝ่าฝืนปรับ 2,000 บาท (ลูกค้าสามารถสูบบุหรี่ในพื้นที่ที่โชว์รูมจัดไว้ให้เท่านั้น)</li>					
									<li>งดจุดพลุ, ประทัด, ดอกไม้ไฟ หรือ โคมลอย ในบริเวณโชว์รูม ฝ่าฝืนปรับ 2,000 บาท</li>			
								</ol>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="section_header ">
						<h6 style="font-weight: 600;">สถานที่ใกล้เคียง</h6>
					</div>
					<div class="row mb4">
						<div class="col-md-12">		
							<div class="table-responsive">
								<table class="table table-bordered" style="border-color: #ccc;">
									<tbody>
										<tr style="text-align: center;">
											<th>ชื่อสถานที่</th>
											<th>ระยะทาง(km)</th>
										</tr>
										<tr>
											<td>ครัวอิ่มแปล้</td>
											<td style="text-align: center;">0.07</td>
										</tr>
										<tr>
											<td>The Pandora Camp Khaoyai</td>
											<td style="text-align: center;">10</td>
										</tr>
										<tr>
											<td>Toscana Valley</td>
											<td style="text-align: center;">10</td>
										</tr>
										<tr>
											<td>เขาใหญ่อาร์ตมิวเซียม</td>
											<td style="text-align: center;">15</td>
										</tr>
										<tr>
											<td>My Ozone Animal Club</td>
											<td style="text-align: center;">25</td>
										</tr>
										<tr>
											<td>Scenical World </td>
											<td style="text-align: center;">30</td>
										</tr>
										<tr>
											<td>Khao Yai National Park</td>
											<td style="text-align: center;">30</td>
										</tr>
									</tbody>
								</table>  
							</div>		
						</div>
					</div>
				</div>
			</div>
		</div>
	
	<div class="row text-center mb-0" id="nav_roomstype">
		<div class="col-md-12">
			<div id="google-map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5462.972307432571!2d101.55065412783209!3d14.490156270739496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311c3b5927861817%3A0x4ef8dd372f4d0716!2sSMS%20Showroom!5e0!3m2!1sth!2sth!4v1683184985267!5m2!1sth!2sth" width=100% height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
		</div>
	</div>
</div>
-->
<!-- facilities & amenities and nearby location -->

<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo site_url(); ?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url(); ?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo site_url(); ?>assets/select-picker/js/bootstrap-select.min.js"></script>
<script src="<?php echo site_url(); ?>assets/swiper-element/js/swiper-element-bundle.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-element-bundle.min.js"></script> -->


<!-- package -->
<!--<script src="<?= site_url() ?>/js/tiny-slider.js"></script>
<script src="<?= site_url() ?>/js/aos.js"></script>
<script src="<?= site_url() ?>/js/custom.js"></script>-->


<script>
	$('.carousel').carousel({
		interval: 15000
	})


	function stepper(dis) {
		let btn_id = dis.getAttribute('id');
		let max = dis.getAttribute('max');


		const myArray = btn_id.split("-");
		var myInput = myArray[1];
		let min = $('#' + myInput).val();

		var newval = (myArray[0] == 'increment') ? (parseInt(min) + 1) : (parseInt(min) - 1);
		newval = (newval < 0) ? 0 : newval;
		$('#' + myInput).val(newval);
		$('#div_' + myInput).html(newval);
		//console.log(newval);
		if (btn_id == 'increment-children') {
			$('.div_kids_age').html('');
			var new_html = '';
			if (newval > 0) {
				for (var x = 0; x < newval; x++) {
					max_age = '<?php echo app_settings('max_children_age'); ?>';
					var option_ct = 1;
					new_html += '<div class="col-md-4" style="padding: 5px;">' +
						'<label><?php echo $this->lang->line('ages'); ?></label>' +
						'<select class="form-control select_age" name="select_age[]">' +
						'<option value="0">0</option>';
					do {
						new_html += '<option value="' + option_ct + '">' + option_ct + '</option>';
						option_ct++;
					} while (option_ct <= max_age);
					new_html += '</select></div>';
				}

			}
			//console.log(new_html);
			$('.div_kids_age').html(new_html);
		}

		if (btn_id == 'decrement-children') {
			var new_html = '';
			if (newval > 0) {
				for (var x = 0; x < newval; x++) {
					max_age = '<?php echo app_settings('max_children_age'); ?>';
					var option_ct = 1;
					new_html += '<div class="col-md-3" style="padding: 1px;">' +
						'<label><?php echo $this->lang->line('ages'); ?></label>' +
						'<select class="form-control select_age" name="select_age[]">' +
						'<option value="0">0</option>';
					do {
						new_html += '<option value="' + option_ct + '">' + option_ct + '</option>';
						option_ct++;
					} while (option_ct <= max_age);
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

	$(function() {
		var today = new Date();
		var tomorrow = new Date(today);
		tomorrow.setDate(today.getDate() + 1);
		tomorrow.toLocaleDateString();
		var today_date = ('0' + today.getDate()).slice(-2) + '-' +
			('0' + (today.getMonth() + 1)).slice(-2) + '-' +
			today.getFullYear();


		var tomorow_date = ('0' + tomorrow.getDate()).slice(-2) + '-' +
			('0' + (tomorrow.getMonth() + 1)).slice(-2) + '-' +
			tomorrow.getFullYear();
		$("#check_in_date").val(today_date);
		$("#check_out_date").val(tomorow_date);
		if ($("#check_in_date").val() == '' && $("#check_out_date").val()) {
			$('.search_button').prop('disabled', true);
		} else {
			$('.search_button').prop('disabled', false);
			$("#h_check_in_date").val($('#check_in_date').val());
			$("#h_check_out_date").val($('#check_out_date').val());
		}


		$('#check_in_date').datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			minDate: new Date(), // = today
			onSelect: function(dateText, inst) {

				var in_date = $(this).val();
				check_in_date = in_date.split("-");

				//var d = new Date(check_in_date[2], parseInt(check_in_date[1])-1, check_in_date[0]);
				var today = new Date(check_in_date[2], parseInt(check_in_date[1]) - 1, check_in_date[0]);
				var tomorrow = new Date(today);
				tomorrow.setDate(today.getDate() + 1);
				tomorrow.toLocaleDateString();
				var tomorow_date = ('0' + tomorrow.getDate()).slice(-2) + '-' +
					('0' + (tomorrow.getMonth() + 1)).slice(-2) + '-' +
					tomorrow.getFullYear();
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

		$('.myImg').click(function() {
			var id = $(this).attr('data-id');
			$('.carousel-item').each(function(i, obj) {
				$(this).removeClass('active');
			});
			$('.slide').each(function(i, obj) {
				$(this).removeClass('active');
			});
			$('.' + id).addClass('active');
			$('#ModalCarousel').modal('show');
		});

		$(".room_img").on('click', function(e) {
			var mymodal = document.getElementById("ModalRoomCarousel");
			var self = $(this);
			var type = self.attr('data-type');
			//console.log(type);
			var name = self.data('name'); // or src = self.attr('src');
			var src = self.attr('src');
			var photo_ctr = self.attr('data-ctr');
			//console.log(mymodal);
			var arr_photos = [];

			var arr_type = "hiddentype_" + type;
			//console.log(arr_type);
			ar_photos = $('#' + arr_type).val();
			arr_photos = JSON.parse(ar_photos);
			//console.log(arr_photos);
			var ol = '';
			var inner_room = '';

			for (var x = 0; x < arr_photos.length; x++) {
				var i = x + 1;
				var active = (x == photo_ctr) ? 'active' : '';
				//console.log(arr_photos[x]);
				var url = "<?php echo share_folder_path(); ?>" + arr_photos[x];
				var li = '<li data-target="#carouselRoomExampleIntors" datdicaa-slide-to="' + x + '" class="slide ' + i + '"></li>';

				var room = '<div class="carousel-item ' + x + ' ' + active + '">' +
					'<img class="d-block w-100" src="' + url + '" alt="slide ' + i + '">' +
					'</div>';

				ol += li;
				inner_room += room;
			}

			$('#carouselRoomExampleIndicators > ol').html(ol);
			$('#carousel_inner_room').html(inner_room);
			$('#ModalRoomCarousel').carousel();
			$('#ModalRoomCarousel').modal('show');

			//console.log(ol);	
			//console.log(inner_room);	
			//$('#ModalRoomCarousel').show();					


		});

		$('.dropdown-menu').on('click', function(event) {
			// The event won't be propagated up to the document NODE and 
			// therefore delegated events won't be fired
			event.stopPropagation();
		});

		var cart_count = $('.button__badge').text();
		$('.add_to_cart').click(function() {
			var id_room_type = $(this).attr('data-id');
			var room_rate = $(this).attr('data-price');

			//alert(id_room_type)
			var _url = "<?php echo site_url('cart/add_to_cart'); ?>";

			$.ajax({
					method: "POST",
					url: _url,
					data: {
						'id_room_type': id_room_type,
						'room_rate': room_rate
					}
				})
				.done(function(res) {
					var obj = eval('(' + res + ')');
					alert(obj.message);
					$('.button__badge').text(obj.count);
				});
		});

		$('.search_button').click(function(e) {
			e.preventDefault();
			//return false;
			$('#search_type').val($(this).attr('data-search-type'));
			//$('#s_id_room_type').val($(this).attr('data-roomtype'));
			$('#project_id').val($('#project_id').val());
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



		$('.book_now').click(function() {
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
			$('#slideshow-' + i + ' > div:gt(0)').hide();
			setInterval(function() {
				$('#slideshow-' + i + ' > div:first')
					.fadeOut(1)
					.next()
					.fadeIn(1000)
					.end()
					.appendTo('#slideshow-' + i);
			}, 3000); // 3 seconds
		});
		/*
		$('.slideshow').each(function(i, obj) {
			$('#slideshow-' + i + ' > div:gt(0)').hide();
			setInterval(function() {
				$('#slideshow-' + i + ' > div:first')
					.fadeOut(1) 
					.next()
					.fadeIn(4000)
					.end()
					.appendTo('#slideshow-' + i);
			}, 5000); 
		});
		*/

		
		


		$(".checkbox-dropdown").click(function() {
			$(this).toggleClass("is-active");
		});

		$(".checkbox-dropdown ul").click(function(e) {
			e.stopPropagation();
		});

		$('.package_cbox').click(function() {
			var package_sel = [];
			$('.package_cbox').each(function(i, obj) {
				if ($(this).is(':checked')) {
					package_sel.push($(this).val());
				}
			});
			//console.log(package_sel);
		});


	});
	sessionStorage.clear();
</script>
