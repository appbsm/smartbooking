<?php
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI = &get_instance();
$CI->load->model('m_room_type');

?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
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
</style>

<!-- Package -->
<!-- <link rel="stylesheet" href="<?= site_url() ?>/css/style.css"> -->
<link rel="stylesheet" href="<?= site_url() ?>/css/tiny-slider.css">
<link rel="stylesheet" href="<?= site_url() ?>/css/package.css">
<!-- <link rel="stylesheet" href="<?= site_url() ?>/css/main.css"> -->

<link rel="stylesheet" href="<?= site_url() ?>assets/select-picker/css/bootstrap-select.min.css">


<div class=" home-p mb-4 mt-4">
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
					<img class="d-block w-100" src="<?php echo share_folder_path() . $photo->project_photo_url; ?>" alt="First slide">
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
				<div class="row search-bg pt-3" style="border: 1px solid #C6C6C7; border-radius: 5px; padding: 5px 0 5px 0; margin: 0 4px 0 4px;">
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

							<input type='text' class=" form-control datepicker search_input" name="check_in_date" id="check_in_date" value="" />
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-xs-6">
						<div class="col-md-12 text-left">
							<label class="ml-1" for="name"><?php echo $this->lang->line('check_out_date'); ?></label>
							<input type='text' class="form-control datepicker search_input" name="check_out_date" id="check_out_date" value="" />
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<!-- <div class="col-md-12 mt-2"><b><?php echo $this->lang->line('search_by_room'); ?></b></div> -->
						<div class="col-md-12 mb-2 text-left">
							<label class="ml-1" for="name"><?php echo $lang == "english" ? 'Adult' : 'ผู้เข้าพัก'; ?></label>
							<div class="dropdown">
								<button class="btn dropdown-toggle w-100 search_input" style="color: #495057; width:100%;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<div class="d-inline-flex"><span id="div_adult">2</span> <?php echo $this->lang->line('adults'); ?>, <span id="div_children">0</span> <?php echo $this->lang->line('children'); ?>, <span id="div_room">1</span></div> <?php echo $this->lang->line('rooms'); ?>
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
							<button disabled id="search" class="form-control search_input search_button btn-default" data-search-type="search_room" style="background-color:#81BB4A;cursor: pointer; "><?php echo $this->lang->line('search'); ?></button>
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

</div>


<!-- Package -->
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

<!-- End Package -->
<div class="container mt-1">
	<div class="row">
		<div class="col-md-12 ml-2 text-center">
			<h5><?php echo $this->lang->line('room_types'); ?></h5>
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
							<h6><?php echo ($lang == 'english') ? $rt->room_type_name_en : $rt->room_type_name_th; ?></h6>
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
							<button class="btn button-primary-w add_to_cart" data-id="<?php echo $rt->id_room_type; ?>" data-price="<?php echo $rt->default_rate; ?>" id="" style="margin-right: 5px;"><?php echo $this->lang->line('add_to_cart'); ?></button>
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