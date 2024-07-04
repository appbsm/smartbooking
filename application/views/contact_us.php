<html lang="en"><head>
<title>Smart Booking</title>
  <link rel="icon" type="image/x-icon" href="http://192.168.20.22/smartbooking_front_test/images/10.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <link href="https://fonts.googleapis.com/css2?family=Syne&amp;display=swap" rel="stylesheet">  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="http://192.168.20.22/smartbooking_front_test/bootstrap-4.0.0-dist/css/bootstrap.css">

  <!-- icon font-awesome -->
  <link href="http://192.168.20.22/smartbooking_front_test/assets/font-awesome/css/all.min.css" rel="stylesheet">

  <link href="http://192.168.20.22/smartbooking_front_test/css/styles.css" rel="stylesheet">
  <link href="http://192.168.20.22/smartbooking_front_test/css/css.css" rel="stylesheet">
  <link href="http://192.168.20.22/smartbooking_front_test/css/custom_header_en.css" rel="stylesheet">  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?v=1001">
  <!--<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>-->

  
   
  <style>
    

    .button {
      color: white;
      display: inline-block;
      /* Inline elements with width and height. TL;DR they make the icon buttons stack from left-to-right instead of top-to-bottom */
      position: relative;
      /* All 'absolute'ly positioned elements are relative to this one */

    }

    .button__badge {
      background-color: #fa3e3e;
      border-radius: 50%;
      color: white;

      padding: 0 5px 0 5px;
      margin-right: 10px;
      font-size: 0.8em !important;

      position: absolute;
      /* Position the badge within the relatively positioned button */
      top: 0;

      right: 0;
    }

    input,
    textarea,
    button,
    span {
      font-size: 1em !important;
      /* font-family: arial; */
    }
	
	.btn-sign-in:hover {
        background-color: #839287 !important; 
        color: #fff !important; 
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
	
	.menu-bar {
		width: 100%;
		max-width: 100%;
		display: flex;
		justify-content: space-around;
		font-weight: 400;
	}
	
	.btn_sign_in {
		width: 100%;
        padding: 10px;
        background-color: #5392f9 !important;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
	}
	.btn_sign_in:hover {
        background-color: #5392f9b3 !important;
        color: #fff !important;
        border: #5392f9 !important;
	}
	
  </style>

  <script>
    const numFor = new Intl.NumberFormat('en-US');

    function ValidateEmail(mail) {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return (true)
      } else {
        alert("You have entered an invalid email address!")
        return (false)
      }
    }

    function number_add_comma_decimal(num) {
      num = parseFloat(num).toFixed(2);
      return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function number_add_comma(num) {
      //num = parseFloat(num).toFixed(2);
      return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function remove_comma(num) {
      return num.replace(/\,/g, '');
    }

    function date_diff(date1, date2) {
      const diffTime = Math.abs(date2 - date1);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      //console.log(diffTime + " milliseconds");
      //console.log(diffDays + " days");
      return diffDays;
    }
    let width = screen.width;
    //console.log(width);
  </script>
<style>
        @font-face {
            font-family: 'NotoSans_online_security'; 
            src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/assets/fonts/noto-sans-regular.woff);
        }

        @font-face {
            font-family: 'NotoSans_medium_online_security'; 
            src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/assets/fonts/noto-sans-medium.ttf);
        }

        @font-face {
            font-family: 'NotoSans_bold_online_security'; 
            src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/assets/fonts/noto-sans-bold.woff);
        }

        @font-face {
            font-family: 'NotoSans_semibold_online_security'; 
            src: url(chrome-extension://llbcnfanfmjhpedaedhbcnpgeepdnnok/assets/fonts/noto-sans-semibold.ttf);
        }
</style></head>


<body>
  <header>
    <nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top text-center mr-auto mb-0" style="height:70px; background-color:#fff !important; border-bottom: 1px solid #ccc;">
    <div class="container d-flex flex-row">
		
	  <span class="mx-3">
		<a class="logo" href="http://192.168.20.22/smartbooking_front_test/home"><img src="http://192.168.20.22/smartbooking_front_test/images/10.png" width="70"></a>
	  </span>  

	  <!-- new menu -->
	  <div class="col-9">
		<ul class="navbar-nav me-auto mb-2 mb-lg-0 menu-bar">
            <li class="nav-item" id="nav_aboutus">
                <a class="nav-link" href="#aboutus">
					About us 
				</a>
            </li>
            <li class="nav-item" id="nav_roomstype">
                <a class="nav-link" href="#roomtype">
					Rooms type 
				</a>
            </li>
            <li class="nav-item" id="nav_packagep_promotions">
                <a class="nav-link" href="#package">
					Package &amp; Promotions 
				</a>
            </li>
            <li class="nav-item" id="nav_contactus">
                <a class="nav-link" href="#facilities_amenities">
					Facilities &amp; Amenities				</a>
            </li>
			<li class="nav-item" id="nav_contactus">
                <a class="nav-link" href="#nearby_locations">
					Nearby Locations				</a>
            </li>
			<li class="nav-item" id="nav_contactus">
                <a class="nav-link" href="#contactus">
					Contact us				</a>
            </li>
        </ul>
	</div>
	  <!-- new menu -->
      <div class="" id="navbarSupportedContent">       
        <div class="navbar navbar-expand d-flex flex-row" style="gap: 0 16px; background-color:#fff !important;">
          
		  		  <div class="button mx-1">
                <a class="btn btn_sign_in" href="http://192.168.20.22/smartbooking_front_test/login" height="20">Sign In</a>
              </div>
		  		  <div class="button">
            <a class="nav-link" href="http://192.168.20.22/smartbooking_front_test/cart"><span class="button__badge">1</span><object style="pointer-events: none;" data="https://sharefolder.buildersmart.com/sms_booking/images/icons/cart.svg" height="20"> </object></a>
          </div>
		  
		<div class="d-flex flex-rows" style="margin-top:3px;padding: 5px; margin-right: 5px;">
						<a href="http://192.168.20.22/smartbooking_front_test/LanguageSwitcher/switchLang/thai" title="Thai" style="">TH</a>
			<span>&nbsp;|&nbsp;</span>
			<a href="http://192.168.20.22/smartbooking_front_test/LanguageSwitcher/switchLang/english" title="English" style="font-weight: bold!important;">EN</a>
		  </div>

        </div>
      </div>
      
      </div>
    </nav>
	
	
</header><title>Smart Booking</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
	.span, .icon-content {
		color: #000 !important;
	}
	.carousel-item.active {
		z-index: 0 !important;
		opacity: 1;
	}
	.slideshow {
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
			width: 100%;
			max-width: 1500px; /* กำหนดความกว้างสูงสุดที่ body สามารถขยายตามจอได้ */
			margin: 0 auto; /* จัดตำแหน่งกึ่งกลางของหน้า */
			
		}
		
</style>

<!-- Package -->
<!-- <link rel="stylesheet" href="http://192.168.20.22/smartbooking_front_test//css/style.css"> -->
<link rel="stylesheet" href="http://192.168.20.22/smartbooking_front_test//css/tiny-slider.css">
<link rel="stylesheet" href="http://192.168.20.22/smartbooking_front_test//css/package.css">
<!-- <link rel="stylesheet" href="http://192.168.20.22/smartbooking_front_test//css/main.css"> -->
<link rel="icon" type="image/png" sizes="16x16" href="http://192.168.20.22/smartbooking_front_test//images/10.png">
<link rel="stylesheet" href="http://192.168.20.22/smartbooking_front_test/assets/select-picker/css/bootstrap-select.min.css">


<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b050bc5d.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0513633.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0517c12.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b051ab44.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b051db56.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0520399.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0522c54.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0525525.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b05284d2.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b052bd8c.jpeg" alt="First slide">
				</div>
							<div class="carousel-item active">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b052f541.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b05327fe.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0535e8c.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0539007.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b053bf62.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b053f3e2.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0542118.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0546018.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0549beb.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b054d7ac.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b055270d.jpeg" alt="First slide">
				</div>
							<div class="carousel-item">
					<img class="d-block w-100 img-cover" src="https://sharefolder.buildersmart.com/sms_booking/upload/project_photo/1_64880b0556486.jpeg" alt="First slide">
				</div>
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
		<form name="frm_search" id="frm_search" method="post" action="http://192.168.20.22/smartbooking_front_test/home/search">
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
							<label class="ml-1" for="name">Location </label>
							<!-- <input type='text' class=" form-control search_input" value=""/>	 -->
							<div class="dropdown bootstrap-select form-control search_input"><select class="form-control selectpicker search_input" data-live-search="true" name="project_id" id="project_id" tabindex="-98">
																	<option value="1">SM Resort Showroom @ Khaoyai</option>
																	<option value="15">Condo</option>
															</select><button type="button" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-1" aria-haspopup="listbox" aria-expanded="false" data-id="project_id" title="SM Resort Showroom @ Khaoyai" fdprocessedid="90me2e"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">SM Resort Showroom @ Khaoyai</div></div> </div></button><div class="dropdown-menu "><div class="bs-searchbox"><input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-1" aria-autocomplete="list"></div><div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>

						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-xs-6">
						<div class="col-md-12 text-left">
							<label class="ml-1" for="name">Check-in Date</label>

							<input type="text" class="form-control form-control-ckinout datepicker search_input hasDatepicker" name="check_in_date" id="check_in_date" value="" fdprocessedid="i485j">
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-xs-6">
						<div class="col-md-12 text-left">
							<label class="ml-1" for="name">Checkout Date</label>
							<input type="text" class="form-control form-control-ckinout datepicker search_input hasDatepicker" name="check_out_date" id="check_out_date" value="" fdprocessedid="ouovj">
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<!-- <div class="col-md-12 mt-2"><b>Search By Room</b></div> -->
						<div class="col-md-12 mb-2 text-left">
							<label class="ml-1" for="name">Adult</label>
							<div class="dropdown">
								<button class="btn dropdown-toggle w-100 search_input" style="color: #495057; width:100%;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" fdprocessedid="6v1tw">
									<div class="d-inline-flex"><span id="div_adult">2</span> Adults, <span id="div_children">0</span> Children, <span id="div_room">1</span></div> Rooms								</button>
								<div class="dropdown-menu" style="vertical-align: bottom;" aria-labelledby="dropdownMenuButton">
									<div class="stepper">
										<div style="display: flex; justify-content: center;"></div>
										<div style="display: flex; justify-content: center; background-color: white; ">
											<button type="button" class="btn_stepper " id="decrement-adult" onclick="stepper(this);"> - </button>
											<input class="input_number" type="number" min="0" max="100" step="1" value="2" name="adult" id="adult" readonly="">
											<button type="button" class="btn_stepper " id="increment-adult" onclick="stepper(this);"> + </button>
										</div>
										<div class="rounded hr3 mt-2 mb-2"></div>
										<div style="display: flex; justify-content: center;">Children</div>
										<div style="display: flex; justify-content: center;">
											<button type="button" class="btn_stepper " id="decrement-children" onclick="stepper(this);"> - </button>
											<input class="input_number" type="number" min="0" max="100" step="1" value="0" name="children" id="children" readonly="">
											<button type="button" class="btn_stepper " id="increment-children" onclick="stepper(this);"> + </button>
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
											<button type="button" class="btn_stepper " id="decrement-room" onclick="stepper(this);"> - </button>
											<input class="input_number" type="number" min="0" max="100" step="1" value="1" name="room" id="room" readonly="">
											<button type="button" class="btn_stepper " id="increment-room" onclick="stepper(this);"> + </button>
										</div>
										<div class="rounded hr3 mt-2" style="padding: 5px; font-size: 0.8em;">Notes:
																							Please be informed that the maximum age for children is 0												years old. Kindly add children aged more than 0 years as adult.
																					</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-6">
						<div class="col-md-12 mb-2 text-left">
							<label for="name">&nbsp;</label>
							<button id="search" class="form-control form-control-btnsearch search_input search_button btn-default btn-search" data-search-type="search_room" style="background-color:#81BB4A;cursor: pointer; display: flex; align-items: center; justify-content: center; " fdprocessedid="h36ztr">
								Search							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		



		<!-- <div class="col-md-6">
				
				<div class="row">
					<div class="col-md-12 mt-2"><b>Search By Package</b></div>
					<div class="col-md-6 mb-2">
						<div class="checkbox-dropdown" style="">
						  						  <ul class="checkbox-dropdown-list">
														<li>
							  <label>
								<input class="package_cbox" type="checkbox" value="
<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined variable: package</p>
<p>Filename: views/v_home.php</p>
<p>Line Number: 686</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\application\views\v_home.php<br />
			Line: 686<br />
			Function: _error_handler			</p>

		
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\application\controllers\home.php<br />
			Line: 39<br />
			Function: view			</p>

		
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\index.php<br />
			Line: 315<br />
			Function: require_once			</p>

		
	

</div>
<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Trying to get property of non-object</p>
<p>Filename: views/v_home.php</p>
<p>Line Number: 686</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\application\views\v_home.php<br />
			Line: 686<br />
			Function: _error_handler			</p>

		
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\application\controllers\home.php<br />
			Line: 39<br />
			Function: view			</p>

		
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\index.php<br />
			Line: 315<br />
			Function: require_once			</p>

		
	

</div>" name="package" />
<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Undefined variable: package</p>
<p>Filename: views/v_home.php</p>
<p>Line Number: 686</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\application\views\v_home.php<br />
			Line: 686<br />
			Function: _error_handler			</p>

		
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\application\controllers\home.php<br />
			Line: 39<br />
			Function: view			</p>

		
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\index.php<br />
			Line: 315<br />
			Function: require_once			</p>

		
	

</div>
<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Notice</p>
<p>Message:  Trying to get property of non-object</p>
<p>Filename: views/v_home.php</p>
<p>Line Number: 686</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\application\views\v_home.php<br />
			Line: 686<br />
			Function: _error_handler			</p>

		
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\application\controllers\home.php<br />
			Line: 39<br />
			Function: view			</p>

		
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\inetpub\wwwroot\smartbooking_front_test\index.php<br />
			Line: 315<br />
			Function: require_once			</p>

		
	

</div></label>
							</li>
														
						  </ul>
						</div>
					</div>
				
				<div class="col-md-6">
					<div >
						<button disabled id="search_package" class="form-control search_input search_button btn-default" data-search-type="search_package" style="cursor: pointer; padding: 0 50px 0 50px;">Search Package</button>
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
					btn.innerHTML = 'Read less...<i class="fas fa-angle-down"></i>';
				} else {
					longText.style.display = 'none';
					btn.innerHTML = 'Read more...<i class="fas fa-angle-up"></i>';
				}
			});
		});

		</script>
		<div class="col-md-12 mb-4 description-banner">
			<div class="section-heading text-center mb-3">
				<a href="https://smsmartbooking.buildersmart.com/project_info" target="_blank" class="a-readmore" id="aboutus">
					<h4 style="font-weight: 600;">
						SM Resort					</h4>
				</a>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="content">
						<p class="short-text">
							Relax amidst the stunning scenery, surrounded by nature and fresh air.
SM Resort redefines a new style of accommodation with its modern resort collection under the BuildSmart Group. Located in the picturesque Khao Yai area						</p>
						<p class="long-text">
							SM Resort redefines a new style of accommodation with its modern resort collection under the BuildSmart Group. Located in the picturesque Khao Yai area, SM Resort offers a remarkable transformation to welcome guests. With various activities available, we are ready to provide a new kind of experience for travelers. Additionally, we host a variety of gatherings and events, ensuring to create precious memories for you. <a href="https://smsmartbooking.buildersmart.com/project_info" target="_blank" class="em-readmore"><em><i class="fas fa-angle-double-left"></i>Read more...<i class="fas fa-angle-double-right"></i></em></a>						</p>
						<!--<button id="readMoreBtn" class="mt-3">อ่านต่อ...</button>-->
						<span id="readMoreBtn" class="readmore-toggle">
							Read more...							<i class="fas fa-angle-up"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
		<!-- Descripttion -->
</div>
<!--
<div class="container"> 
    <div class="row"> 
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 m-t20" style="font-size:17px;>
            <nav aria-label=" breadcrumb"="">
              <ul class="breadcrumb">
                <li>
					<svg width="19" height="19" fill="currentColor" class="bi bi-house" viewBox="0 2 16 16">
					  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"></path>
					</svg>
				</li>
                <li class="breadcrumb-item"><a href="index.php"><i></i>&nbsp;&nbsp;หน้าหลัก</a></li>
                <li class="breadcrumb-item active" aria-current="page">ติดต่อเรา</li>
              </ul> 
		</div>
    </div>  
</div>
<br/>
-->
<div class="container mt-5">
	<div class="row">
		<div class="col-md-12 ml-2 text-center mt-0">
			<section class="section-full bg-white about-bx1 m-b20 m-t30 m-b90">
                <div class="container">
          <div class="section-head text-center ">
            <h4 class="">
				<span style="color: #102958; font-weight: 600;">
					<?php echo $lang == "english" ? 'Contact us' : 'ติดต่อเรา'; ?>
					</span>
				<span style="color: #4590B8;"></span> 
			</h4>

          </div>    
          <br><br>
          <div class="row">

             <div class="col-md-6 col-lg-6 col-sm-12">
            <div class=" d-flex">
              <div class="icon-box-icon pe-3 pb-3">
                <svg width="20" height="20" fill="#102958" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"></path>
                </svg>
              </div>

              <div class="icon-box-content">
                <h6 class="card-title " style="color: #102958; font-weight: 600; text-align: left;">
					<?php echo $lang == "english" ? 'Address' : 'ที่อยู่'; ?>
				</h6>
                <!-- (มหาชน) -->
                <p style="color: #969FA7;font-size:14px; text-align: left;">
					<span>
						<?php echo $lang == "english" ? 'InstallDirect Co., Ltd.' : 'บริษัท อินสตอลไดเรค จำกัด'; ?>
					</span><br/>
					<span>
						<?php echo $lang == "english" ? '905/7 Rama 3 Road Bangpongpang Yannawa, Bangkok, Thailand 10120' : '905/7 ถนนพระราม 3 แขวงบางโพงพาง เขตยานนาวา จ.กรุงเทพฯ 10120'; ?>
					</span>
				</p>
              </div>
            </div>

            <div class=" d-flex">
              <div class="icon-box-icon pe-3 pb-3">
                <svg width="20" height="20" fill="#102958" class="bi bi-telephone" viewBox="0 0 16 16">
				  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"></path>
				</svg>
              </div>

              <div class="icon-box-content">
                <h6 class="card-title " style="color: #102958; font-weight: 600;">
					<?php echo $lang == "english" ? 'Phone' : 'เบอร์โทรศัพท์'; ?>
				</h6>
                <p style="color: #969FA7;font-size:14px; text-align: left;">065-989-8845</p>
              </div>
            </div>
            <div class=" d-flex">
              <div class="icon-box-icon pe-3 pb-3">
                  <i style="font-size:20px;color:#102958;" class="fa fa-fax"></i>
              </div>
              <div class="icon-box-content">
                <h6 class="card-title " style="color: #102958; font-weight: 600;">
					<?php echo $lang == "english" ? 'Fax' : 'เบอร์โทรแฟกซ์'; ?>
				</h6>
                <p style="color: #969FA7;font-size:14px; text-align: left;">0-2683-4949</p>
              </div>
            </div>

            <div class=" d-flex">
              <div class="icon-box-icon pe-3 pb-3">
                <svg width="20" height="20" fill="#102958" class="bi bi-envelope" viewBox="0 0 16 16">
				  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"></path>
				</svg>
            </div>

            <div class="icon-box-content">
                <h6 class="card-title " style="color: #102958; font-weight: 600; text-align: left;">
					<?php echo $lang == "english" ? 'E-mail' : 'อีเมล'; ?>
				</h6>
                <p style="color: #969FA7;font-size:14px; text-align: left;">customercare@installdirect.asia</p>
              </div>
            </div>

            
            
            <div class=" d-flex">
              <div class="icon-box-icon pe-3 pb-3">
               <svg width="20" height="20" fill="#102958" class="bi bi-line" viewBox="0 0 16 16">
				  <path d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0M5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.15.15 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157m.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832l-.013-.015v-.001l-.01-.01-.003-.003-.011-.009h-.001L7.88 4.79l-.003-.002-.005-.003-.008-.005h-.002l-.003-.002-.01-.004-.004-.002-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.2.2 0 0 0 .039.038l.001.001.01.006.004.002.008.004.007.003.005.002.01.003h.003a.2.2 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.16.16 0 0 0-.108.044h-.001l-.001.002-.002.003a.16.16 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.16.16 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z"></path>
				</svg>
              </div>

              <div class="icon-box-content">
                <h6 class="card-title " style="color: #102958; font-weight: 600; text-align: left;">
					<?php echo $lang == "english" ? 'LINE ID' : 'ไลน์ไอดี'; ?>
				</h6>
                <p style="color: #969FA7;font-size:14px;">@installdirect</p>
              </div>
            </div>

          </div>

          <!-- <div class="col-md-5 col-lg-5 col-sm-12"> -->
			<div class="col-md-6 col-lg-6 col-sm-12">
				<form class="contact-box dzForm p-a10 border-1">
					<div id="google-map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5462.972307432571!2d101.55065412783209!3d14.490156270739496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311c3b5927861817%3A0x4ef8dd372f4d0716!2sSMS%20Showroom!5e0!3m2!1sth!2sth!4v1683184985267!5m2!1sth!2sth" width=100% height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</form>
			</div>
          </div>
        </div>
      </section>
		</div>
	</div>
</div>


<script src="http://192.168.20.22/smartbooking_front_test/js/jquery.min.js"></script>
<script src="http://192.168.20.22/smartbooking_front_test/js/jquery-ui.min.js"></script>
<script src="http://192.168.20.22/smartbooking_front_test/bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script src="http://192.168.20.22/smartbooking_front_test/assets/select-picker/js/bootstrap-select.min.js"></script>
<script src="http://192.168.20.22/smartbooking_front_test/assets/swiper-element/js/swiper-element-bundle.min.js"></script>



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
					max_age = '0';
					var option_ct = 1;
					new_html += '<div class="col-md-4" style="padding: 5px;">' +
						'<label>Ages</label>' +
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
					max_age = '0';
					var option_ct = 1;
					new_html += '<div class="col-md-3" style="padding: 1px;">' +
						'<label>Ages</label>' +
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
				var url = "https://sharefolder.buildersmart.com/sms_booking/" + arr_photos[x];
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
			var _url = "http://192.168.20.22/smartbooking_front_test/cart/add_to_cart";

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

<style>
	.footer-social {
		color: rgb(215, 215, 219) !important;
	}
</style>



<footer class="mt-3 bg-light" style="background-color: rgb(42, 42, 46) !important; color: rgba(255, 255, 255, 1.00);">
		<div class="footer-top">
			<div class="container">
				<div class="row " id="contactus">
					<div class="col-md-6 col-lg-6 footer-about wow fadeInUp mt-3">
						<div class="d-flex pt-2">
							<p class=" mt-3">BuilderSmart (Public) Company Limited <br>1055 Rama 3 Road.Chongnonsi, Yannawa, Bangkok 10120 <br><br> SM Resort @ Khaoyai <br> 499 Moo 4 Pong Ta Long, Pak Chong, Nakhon Ratchasima 30130</p>                 
						</div>
					</div>
					<div class="col-md-6 col-lg-6 text-right mt-3">							
						<p>If your interest room rent could you please contact admin via Line or Mobile <span class="footer-phone">065-989-8845</span></p>
						<img class="logo-footer" src="http://192.168.20.22/smartbooking_front_test//images/line.jpg" alt="qr-code" data-at2x="http://192.168.20.22/smartbooking_front_test//images/line.jpg" width="100" height="100">
					</div>
				</div>
			</div>
		</div>
		<div class="bottom-footer">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="d-flex pt-2" style="justify-content: center;">
							<a class="btn btn-square me-1 footer-social" href=""><i class="fab fa-twitter"></i></a>
							<a class="btn btn-square me-1 footer-social" href=""><i class="fab fa-facebook-f"></i></a>
							<a class="btn btn-square me-1 footer-social" href=""><i class="fab fa-youtube"></i></a>
							<a class="btn btn-square me-0 footer-social" href=""><i class="fab fa-linkedin-in"></i></a>                  
						</div>
						<p class="text-center text-light">© 2021-24 smsmartbooking  | All Rights Reserved. Design by <a class="text-light" href="https://www.installdirect.asia/"><b>InstallDirect</b></a></p>
					</div>
				</div>
			</div>
		</div>
	</footer>
<!--2-->

<div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div><span id="PING_IFRAME_FORM_DETECTION" style="display: none;"></span></body></html>