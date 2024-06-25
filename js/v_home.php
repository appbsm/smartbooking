<?php
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI = &get_instance();
$CI->load->model('m_room_type');

?>

    <!-- Icons font CSS-->
    <link href="<?= site_url();?>/assets/vendor/search-box/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <!-- <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all"> -->
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="<?= site_url();?>/assets/vendor/search-box/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?= site_url();?>/assets/vendor/search-box/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="<?= site_url();?>/assets/vendor/search-box/css/main.css" rel="stylesheet" media="all">



<!-- Carousel Start -->
<div id="header-carousel" class="carousel slide carousel-slide-home my-0 py-0" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $ctr = 1;
        foreach ($project_photos as $h) {
        ?>
            <div class="carousel-item c-item <?php if ($ctr === 1) {
                                                    echo "active";
                                                } ?> ">
                <img class="w-100 c-img" src="<?php echo share_folder_path() . $h->project_photo_url; ?>" alt="Image<?php echo $ctr; ?>">
            </div>
        <?php
            $ctr++;
        }
        ?>
        <div>
            <div class="carousel-caption">
            <form name="frm_search" id="frm_search" method="post" action="<?php echo site_url('home/search');?>">
                <div class="row">
                    <div class="col-md-4">
                        <!-- <label for="locationInput" class="form-label">Location</label> -->
                        <!-- <input type="text" class="form-control" id="locationInput" placeholder="<?php echo ($lang == 'english') ? 'Location' : 'ตำแหน่งที่ตั้ง'; ?>"> -->
                        <!-- <select class="form-select selectpicker" title="location" aria-label="Default select example" data-live-search="true">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                        </select> -->
                        <!-- <div class="input-group">
                                    <label class="label">Going to</label>
                                    <input class="input--style-1" type="text" name="address" placeholder="Show room name" required="required">
                                    <i class="zmdi zmdi-pin input-group-symbol"></i>
                        </div> -->
                        <div class="input-group">
                        <!-- <label class="label">Going to</label> -->
                        <select class="selectpicker input--style-1" title="location" name="address" aria-label="Default select example" data-live-search="true">
                            <option value="1" selected>เขาใหญ่</option>
                        </select>
                        </div>
                    </div>
                    <?php 
                        $objDateTime = new DateTime('NOW');

                        $date_substr = substr($objDateTime->format('d/m/Y'),0,2)+1;
                        $date_next = substr($objDateTime->format('d/m/Y'),2,7);
                        
                        //echo $date_substr.$date_next;
                        //echo $objDateTime->format('d/m/Y');
                    ?>
                    <div class="col-md-2">
                        <!-- <label for="checkInInput" class="form-label">Check-in</label> -->
                        <div class="input-group">
                        <label class="label">check-in</label>
                        <input class="input--style-1 check_in_date" type="text" name="check-in" value="<?= $objDateTime->format('d/m/Y');?>" placeholder="" id="input-start">
                        <i class="zmdi zmdi-calendar-alt input-group-symbol"></i>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <!-- <label for="checkOutInput" class="form-label">Check-out</label> -->
                        <div class="input-group">
                                            <label class="label">check-out</label>
                                            <input class="input--style-1 check_out_date" type="text" value="<?= $date_substr.$date_next;?>" name="check-out" placeholder="" id="input-end">
                                            <i class="zmdi zmdi-calendar-alt input-group-symbol"></i>
                                        </div>

                    </div>
                    <div class="col-md-3">
                        <!-- <label for="adultsInput" class="form-label">Adults</label> -->
                        <div class="input-group">
                                    <label class="label">travellers</label>
                                    <i class="zmdi zmdi-account-add input-group-symbol"></i>
                                    <div class="input-group-icon" id="js-select-special">
                                        <input class="input--style-1" type="text" name="traveller" value="1 Adult, 0 Children, 1 Room" disabled="disabled" id="info">
                                        <i class="zmdi zmdi-chevron-down input-icon"></i>
                                    </div>
                                    <div class="dropdown-select">
                                        <ul class="list-room">
                                            <li class="list-room__item">
                                                <ul class="list-person">
                                                    <li class="list-person__item">
                                                        <span class="name">Room</span>
                                                        <div class="quantity quantity">
                                                            <span class="minus">-</span>
                                                            <input class="inputQty" name="room" type="number" min="0" value="1">
                                                            <span class="plus">+</span>
                                                        </div>
                                                    </li>
                                                    <li class="list-person__item">
                                                        <span class="name">Adults</span>
                                                        <div class="quantity quantity1">
                                                            <span class="minus">-</span>
                                                            <input class="inputQty" name="adult" type="number" min="0" value="1">
                                                            <span class="plus">+</span>
                                                        </div>
                                                    </li>
                                                    <li class="list-person__item">
                                                        <span class="name">Children</span>
                                                        <div class="quantity quantity2">
                                                            <span class="minus">-</span>
                                                            <input class="inputQty" name="children" type="number" min="0" value="0">
                                                            <span class="plus">+</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                    </div>
                    <div class="col-md-1 mt-2">
                        <!-- <label for="adultsInput" class="form-label">&nbsp;</label> -->
                        <input type="submit" class="btn btn-search" value="<?php echo ($lang == 'english') ? 'Search' : 'ค้นหา'; ?>" id="" placeholder="">
                    </div>
                    </form>
                </div>


            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->



    <!-- Package -->
    <div class="section">
        <div class="container">
            <div class="col-lg-6 offset-lg-3">
                <div class="section-heading text-center">
                    <h2><?php echo ($lang == 'english') ? 'Package' : 'แพ็คเกจ'; ?></h2>
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p> -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="property-slider-wrap">
                        <div class="property-slider">

                            <?php foreach ($packages as $package) { ?>
                                <div class="property-item">
                                    <a href="property-single.html" class="img">
                                        <img src="<?= base_url() ?>/assets/imgs/home/Home_5.jpg" alt="Image" class="img-fluid" />
                                    </a>
                                    <div class="property-content">
                                        <div class="mb-2"><span><?php echo $package->name; ?></span></div>
                                        <div>
                                            <span class="d-block mb-2 text-black-50"><?php echo ($lang == 'english') ? 'Price' : 'ราคา'; ?> <?php echo number_format($package->price); ?></span>
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

                                            <a href="package/#<?php echo $package->id_project_info . $package->name; ?>" class="btn btn-detail-color py-2 px-3">รายละเอียด</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- .item -->
                            <?php } ?>
                        </div>
                        <div id="property-nav" class="controls" tabindex="0" aria-label="Carousel Navigation">
                            <span class="prev" data-controls="prev" aria-controls="property" tabindex="-1">
                                <</span>
                                    <span class="next" data-controls="next" aria-controls="property" tabindex="-1">></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Package -->


    <!-- Room type -->
    <div class="">
        <div class="container">
            <div class="col-lg-2 offset-lg-0">
                <div class="section-heading text-left">
                    <h2><?php echo ($lang == 'english') ? 'Room type' : 'ห้องพัก'; ?></h2>
                    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p> -->
                </div>
            </div>

            <div class="row">

                <?php
                foreach ($room_types as $key => $rt) {
                    $photos = $CI->m_room_type->get_room_type_photos($rt->id_room_type);
                ?>
                <?php } ?>
                <?php
                $room_ctr = 0;
                $date = date('Y-m-d');
                foreach ($room_types as $key => $rt) {
                    $rate = $CI->m_room_type->get_day_rate($rt->id_room_type, $date);
                    if ($rate == '') {
                        $rate = $rt->default_rate;
                    }
                    $photos = $CI->m_room_type->get_room_type_photos($rt->id_room_type);
                ?>
                    <div class="col-lg-6 col-sm-6">
                        <h6><?php echo ($lang == 'english') ? $rt->room_type_name_en : $rt->room_type_name_th; ?></h6>
                        <input type="hidden" id="pj_info" value="<?= $rt->id_project_info;?>">
                        <br>
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="image">

                                        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php
                                                $ctr = 1;
                                                foreach ($photos as $ctr1 => $photo) { ?>
                                                    <div class="carousel-item <?php if ($ctr == 1) {
                                                                                    echo "active";
                                                                                } ?>" data-bs-interval="2000">
                                                        <img class="img-roomlist" src="<?php echo share_folder_path() . $photo->room_photo_url; ?>" alt="">
                                                    </div>
                                                <?php $ctr++;
                                                } ?>

                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-lg-6 align-self-center">
                                    <div class="content">
                                        <!-- <span class="info">*Limited Offer Today</span> -->
                                        <div class="bg-price">
                                            <?php $price = ($lang == 'english') ? number_format($rt->default_rate, 0) . '/Night' : 'ราคา ' . number_format($rate, 0) . '/คืน'; ?>
                                            <h4><?php echo $price; ?></h4>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-2">
                                                <span class="icon-content"><object data="<?php echo share_folder_path(); ?>images/icons/house.svg" height="20"></object></span>
                                            </div>
                                            <div class="col-9">
                                                <span class="icon-content"><?php echo $lang == 'english' ? $rt->area_en : $rt->area_th; ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo share_folder_path(); ?>images/icons/icons8-bedroom-50.png" height="18"></span>
                                            </div>
                                            <div class="col-9">
                                                <span class="icon-content"><?php echo $lang == 'english' ? $rt->room_details_en : $rt->room_details_th; ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <span class="icon-content" style="margin-left:4px; margin-top:-1px;"><img class="icon" src="<?php echo share_folder_path(); ?>images/icons/bathroom.png" height="18"></span>
                                            </div>
                                            <div class="col-9">
                                                <span class="icon-content"><?php echo $lang == 'english' ? $rt->bathroom_en : $rt->bathroom_th; ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <span class="icon-content" style="margin-left:1px;"><object data="<?php echo share_folder_path(); ?>images/icons/person-fill.svg" height="18"></object></span>
                                            </div>
                                            <div class="col-9">
                                                <span class="icon-content"><?php echo $lang == 'english' ? $rt->number_of_adults . ' Adults' : 'จำนวนผู้เข้าพัก: ' . $rt->number_of_adults; ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <object data="<?php echo share_folder_path(); ?>images/icons/tv.svg" height="20"> </object>
                                            </div>
                                            <div class="col-9">
                                                <span class="icon-content">TV (Internet)</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <span class="icon-content"><object data="<?php echo share_folder_path(); ?>images/icons/snow.svg" height="20"> </object></span>
                                            </div>
                                            <div class="col-9">
                                                <span class="icon-content"><?php echo $lang == 'english' ? 'Air Conditioning' : 'เครื่องปรับอากาศ'; ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <span class="icon-content"><object data="<?php echo share_folder_path(); ?>images/icons/wifi.svg" height="20"> </object></span>
                                            </div>
                                            <div class="col-9">
                                                <span class="icon-content">Free WIFI</span>
                                            </div>
                                        </div>
                                        <?php if ($rt->sofa_en != '') { ?>
                                            <div class="row">
                                                <div class="col-2">
                                                    <object data="<?php echo share_folder_path(); ?>images/icons/sofa.png" height="14"></object>
                                                </div>
                                                <div class="col-9">
                                                    <span class="icon-content"><?php echo $lang == 'english' ? $rt->sofa_en : $rt->sofa_th; ?></span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <!-- <p><a href="/rooms/">View room detail</a></p> -->
                                    <br>
                                    <div class="row justify-content-md-end">
                                        <div class="col-6 p-0">
                                            <div class="main-button-add-cart">
                                                <!-- <a href="reservation.html">เพิ่ม</a> -->
                                                <a class="add_to_cart" href="javascript:;" data-id="<?php echo $rt->id_room_type;?>" data-price="<?php echo $rt->default_rate;?>" data-room_type="<?php echo $rt->id_room_type; ?>"><?php echo $this->lang->line('add_to_cart'); ?></a>
                                            </div>
                                        </div>
                                        <div class="col-6 p-0">
                                            <div class="main-button-booking">
                                                <a class="book_now" href="javascript:;" data-id="<?php echo $rt->id_room_type;?>" data-price="<?php echo $rt->default_rate;?>" data-room_type="<?php echo $rt->id_room_type; ?>"><?php echo $this->lang->line('book_now'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- input form JS control #booking Now-->
    <form name="frm_book" id="frm_book" method="post" action="<?php echo site_url('booking').'/guest_info';?>"> 
        <input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="">
        <input type="hidden" name="h_num_of_room" id="h_num_of_room" value="">
        <input type="hidden" name="h_id_room" id="h_id_room" value="">
        <input type="hidden" name="h_rate" id="h_rate" value="">
        <input type="hidden" name="h_num_of_children" id="h_num_of_children" value="">
        <input type="hidden" name="h_children_ages" id="h_children_ages" value="">
        <input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
        <input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">
        <input type="hidden" name="page" id="page" value="home">
    </form>
    <!-- End room type -->

    <form name="frm_room" id="frm_room" method="post" action="<?php echo site_url('room_details');?>">
        <input type="hidden" name="h_id_room_type" id="h_id_room_type" value="">
        <input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="">
        <input type="hidden" name="h_num_of_room" id="h_num_of_room" value="">
        <input type="hidden" name="h_num_of_children" id="h_num_of_children" value="">
        <input type="hidden" name="h_children_ages" id="h_children_ages" value="">
        <input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
        <input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">	
    </form>



    <!-- Jquery JS-->
    <script src="<?= site_url();?>/assets/vendor/search-box/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="<?= site_url();?>/assets/vendor/search-box/vendor/select2/select2.min.js"></script>
    <script src="<?= site_url();?>/assets/vendor/search-box/vendor/jquery-validate/jquery.validate.min.js"></script>
    <script src="<?= site_url();?>/assets/vendor/search-box/vendor/bootstrap-wizard/bootstrap.min.js"></script>
    <script src="<?= site_url();?>/assets/vendor/search-box/vendor/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="<?= site_url();?>/assets/vendor/search-box/vendor/datepicker/moment.min.js"></script>
    <script src="<?= site_url();?>/assets/vendor/search-box/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="<?= site_url();?>/assets/vendor/search-box/js/global.js"></script>

    

<script src="<?= site_url() ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= site_url() ?>/assets/vendor/bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>


<!-- bootstrap select -->
<script src="<?= site_url() ?>/assets/vendor/select-search/bootstrap-select.min.js"></script>

<!-- Template Javascript -->
<script src="<?= site_url() ?>/assets/js/main.js"></script>


<!-- package -->
<script src="<?= site_url() ?>/assets/js/tiny-slider.js"></script>
<script src="<?= site_url() ?>/assets/js/aos.js"></script>
<script src="<?= site_url() ?>/assets/js/custom.js"></script>


<script>
	$(function(){
		var cart_count = $('.button__badge').text();
		$('.add_package_to_cart').click(function() {	
           // alert("click");
			var id_package = $(this).attr('data-id');
			var room_rate = $(this).attr('data-price');
			
			//alert(id_room_type)
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
				alert(obj.message);
				$('.button__badge').text(obj.count);	 
	       });
		});		

		$('.book_package_now').click(function(){
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

        $('.add_to_cart').click(function() {	
            //alert("click");
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

		$('.select_all').click(function(){
			var total = 0;
			var className = document.getElementsByClassName('chk_item');
			for (var i = 0; i < className.length; i++) {
				if (className[i].checked) {
					total += parseFloat(className[i].getAttribute('data-price'));
				}				
			}
			calc_total_price();
			//document.getElementById('total').innerHTML = '';
			//document.getElementById('total').append(number_add_comma_decimal(total));
		})

		$('.delete-item').click(function() {
			var id = $(this).attr('data-id');
			delete_row (id);
		});

		$('.chk_item').click(function(){
			calc_total_price();
		});



		$('.book_now').click(function(){
			$('#h_id_room_type').val($(this).attr('data-room_type'));
			$('#h_check_in_date').val($('#check_in_date').val());
			$('#h_check_out_date').val($('#check_out_date').val());
			$('#h_num_of_adult').val($('#div_adult').text());
			$('#h_num_of_room').val($('#div_room').text());
			$('#h_num_of_children').val($('#div_children').text());
			
			alert($(this).attr('data-room_type'));
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
		
		
		$('.dropdown-menu').on('click', function(event){
		    // The event won't be propagated up to the document NODE and 
		    // therefore delegated events won't be fired
		    event.stopPropagation();
		});

		$('#proceed_to_booking').click(function(){
						
				if ($('#check_in_date').val() == '' || $('#check_out_date').val() == '') {
					alert('Select Date to Book.')
				}
				else {
				var className = document.getElementsByClassName('chk_item');				
				var rooms = []; 
				var rooms_to_check = [];
				var packages = [];
				var packages_to_check = [];
				
				
				for (var i = 0; i < className.length; i++) {
					var id_room = className[i].getAttribute('data-item');
					var item_type = className[i].getAttribute('data-item-type');
						
					if (className[i].checked == true) {	
						var room_rate = className[i].getAttribute('data-price');
						var room_count = $('#room_'+id_room).val();
						
						if (item_type == 'room') {							
							//console.log(id_room+':'+room_rate); 
							rooms.push(id_room+':'+room_rate+':'+room_count+':'+item_type);
							rooms_to_check.push(id_room);
						}
						else if (item_type == 'package') {
							packages.push(id_room+':'+room_rate+':'+1+':'+item_type);
							packages_to_check.push(id_room);							
						}			
					}						
				}
				//console.log(rooms_to_check);
				if (rooms.length == 0 && packages.length == 0) {
					alert('Select a room to book.')
				}else {
					var proceed_to_booking = 0;
					var _url = "<?php echo site_url('room_details/room_available');?>";
					//alert(_url+rooms_to_check.toString()+'..'+$('#check_in_date').val()+'...'+$('#check_out_date').val());
					//alert("asdd");
					$.ajax({							
						method: "POST",
						url: _url,
						data: {
							'pj_info': $('#pj_info').val(),
							'rooms': rooms_to_check.toString(),
							'check_in_date': $('#check_in_date').val(),
							'check_out_date': $('#check_out_date').val(),              
						},
						error: function(jqXHR, textStatus, errorThrown) {
						console.log(textStatus, errorThrown);
						}
					})
					.done(function( res ) {
						//alert("ddd");
						var obj = eval('('+res+')');
						console.log(obj);
						for (var i=0; i<obj.length; i++) {
							console.log(obj[i]);
							$('#tr_room_'+obj[i]).addClass('red_color');
							$('.cb').prop('checked', false);
							$('#id_room_'+obj[i]).attr('disabled', 'disabled');
						}
						alert("can do");
						if(obj.length > 0 && obj[0] != '') {
								//alert ("<?php echo $this->lang->line('room_not_available');?>")
						}
						else {
							
								$('#h_id_package').val(packages.toString());
								$('#h_id_room').val(rooms.toString());
								$('#h_num_of_adult').val($('#div_adult').text());
								$('#h_num_of_room').val($('#div_room').text());
								$('#h_num_of_children').val($('#div_children').text());
				
								var children_ages = [];
								var ages = document.getElementsByClassName("select_age");
								for (var i = 0; i < ages.length; i++) {
									children_ages.push(ages[i].value);
								}
								$('#h_children_ages').val(children_ages.toString());
								$('#h_check_in_date').val($('#check_in_date').val());		
								$('#h_check_out_date').val($('#check_out_date').val());	
												
								$('#frm_book').submit();   
						}
					});						
				}
				}
			});






		function toggle(source) {
			checkboxes = document.getElementsByClassName('chk_item');
			for(var i=0, n=checkboxes.length;i<n;i++) {
			var x = checkboxes[i].disabled;
			if (!x)
				checkboxes[i].checked = source.checked;
			}
			//calc_total_price();
		}


		
   
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

			
		}

function stepper_room(dis) {
	let btn_id = dis.getAttribute('id');
	let max = dis.getAttribute('data-max');
	//console.log(max);
	var id_room_type = dis.getAttribute('data-room');
	var id_cart_item = dis.getAttribute('data-cart-item');
	//console.log(id_room_type);
	const myArray = btn_id.split("-");
	var myInput = myArray[1];
	let min = $('#room_'+id_room_type).val();
	//console.log(min);
	var newval = ( myArray[0] == 'increment' ) ? (parseInt(min)+1) : (parseInt(min)-1);
	newval = (newval < 0) ? 0 : newval;
	//alert(newval)
	
	//$('#'+myInput).val(newval);
	if (myArray[0] == 'decrement') {
		if (newval > 0) {
			$('#room_'+id_room_type).val(newval);
			var _url = "<?php echo site_url('cart/update_cart_ajax');?>";
			$.ajax({
		        method: "POST",
		        url: _url,
		        data: {
		            'id_cart_item': id_cart_item,
		            'id_room_type': id_room_type,
		            'quantity': newval            
		        }
			})
			.done(function( res ) {
			});			
		}
		else {
			delete_row (id_cart_item);
		}
	}
	if (myArray[0] == 'increment') {
		if (newval <= max) {
			$('#room_'+id_room_type).val(newval);
			var _url = "<?php echo site_url('cart/update_cart_ajax');?>";
			$.ajax({
		        method: "POST",
		        url: _url,
		        data: {
		            'id_cart_item': id_cart_item,
		            'id_room_type': id_room_type,
		            'quantity': newval            
		        }
			})
			.done(function( res ) {
			});
		}
		else {
			alert("Max available room reached")
		}
	}
	
	
	calc_total_price();
}

	function stepper_package(dis) {
	let btn_id = dis.getAttribute('id');
	let max = dis.getAttribute('data-max');
	var id_package = dis.getAttribute('data-package');
	var id_cart_item = dis.getAttribute('data-cart-item');
	//console.log(id_room_type);
	const myArray = btn_id.split("-");
	var myInput = myArray[1];
	let min = $('#package_'+id_cart_item).val();
	//console.log(min);
	var newval = ( myArray[0] == 'increment' ) ? (parseInt(min)+1) : (parseInt(min)-1);
	newval = (newval < 0) ? 0 : newval;
	//alert(newval)
	
	//$('#'+myInput).val(newval);
	if (myArray[0] == 'decrement') {
		if (newval > 0) {
			$('#package_'+id_package).val(newval);
			var _url = "<?php echo site_url('cart/update_cart_package');?>";
			$.ajax({
		        method: "POST",
		        url: _url,
		        data: {
		            'id_cart_item': id_cart_item,
		            'id_package': id_package,
		            'quantity': newval            
		        }
			})
			.done(function( res ) {
			});			
		}
		else {
			delete_row (id_cart_item);
		}
	}
	if (myArray[0] == 'increment') {
		if (newval <= max) {
			$('#package_'+id_package).val(newval);
			var _url = "<?php echo site_url('cart/update_cart_package');?>";
			$.ajax({
		        method: "POST",
		        url: _url,
		        data: {
		            'id_cart_item': id_cart_item,
		            'id_package': id_package,
		            'quantity': newval            
		        }
			})
			.done(function( res ) {
			});
		}
		else {
			alert("Max available room reached")
		}
	}
	
	
	calc_total_price();
	}





		function delete_row (id_cart_item) {
		var r = confirm("<?php echo $this->lang->line('message_delete_item');?>");
		if (r) {				
			var _url = "<?php echo site_url('cart/delete_to_cart');?>";
			
			$.ajax({
				method: "POST",
				url: _url,
				data: {
					'id_cart_item': id_cart_item              
				}
			})
			.done(function( res ) {
					//var obj = eval('('+res+')');
					//console.log(res);
					alert('<?php echo $this->lang->line('delete_successful');?>')
					location.reload();
			});
		}
		
	}




		function calc_total_price() {
		var total = 0;
		var className = document.getElementsByClassName('chk_item');

		for (var i = 0; i < className.length; i++) {							
			if (className[i].checked) {
				
				var item_type = className[i].getAttribute('data-item-type');
				
				if (item_type == 'room') {
					var id_room_type = className[i].getAttribute('data-item');
						item_total_price = (parseFloat(className[i].getAttribute('data-price')) * parseInt($('#room_'+id_room_type).val()));
						total = total + item_total_price;
						//alert(total);
				}
				else {
					var id_package = className[i].getAttribute('data-item');
					item_total_price = (parseFloat(className[i].getAttribute('data-price')) );
					total = total + item_total_price;
				}
			}				
		}
		//const totalNumber = total.toLocaleString("en-US");

		document.getElementById('total').innerHTML = '';
		document.getElementById('total').append(number_add_comma_decimal(total));
		}
	sessionStorage.clear();
    </script>


    