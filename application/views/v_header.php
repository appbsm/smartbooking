<!doctype html>
<html lang="en">
<?php
$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
if ($lg == 'thai') {
  $this->lang->load('content', 'thai');
} elseif ($lg == 'english') {
  $this->lang->load('content', 'english');
}
$lang  = $lg;

$CI = &get_instance();
$CI->load->model('m_guest');
$CI->load->model('m_cart');

$id_guest = $this->session->userdata('id_guest');
$cart_count = 0;
if ($id_guest != '') {
  $guest = $CI->m_guest->get_profile_by_guestID($id_guest);
  $cart_count = $CI->m_cart->get_cart_item_count($id_guest);
} else {
  $cart_count = sizeof($this->session->userdata('my_cart'));
}
?>
<head>

<title>Smart Booking</title>

  <link rel="icon" type="image/x-icon" href="<?php echo site_url(); ?>images/10.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <?php echo $lang=='english'?'<link href="https://fonts.googleapis.com/css2?family=Syne&display=swap" rel="stylesheet">':'<link href="https://fonts.googleapis.com/css2?family=Prompt&family=Syne&display=swap" rel="stylesheet">';?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo site_url(); ?>bootstrap-4.0.0-dist/css/bootstrap.css">

  <link href="<?php echo site_url(); ?>assets/font-awesome/css/all.min.css" rel="stylesheet">
  <link href="<?php echo site_url(); ?>css/styles.css" rel="stylesheet">
  <link href="<?php echo site_url(); ?>css/css.css" rel="stylesheet">
  <?php echo $lang=='english'?'<link href="'.site_url().'css/custom_header_en.css" rel="stylesheet">':'<link href="'.site_url().'css/custom_header_th.css" rel="stylesheet">';?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?v=1001">

  <style>
  	.datepicker {
      font-size: 12px; /* กำหนดขนาดตัวอักษรสำหรับ input field */
    }

    .datepicker-dropdown {
      font-size: 12px; /* กำหนดขนาดตัวอักษรสำหรับ dropdown ของปฏิทิน */
    }

    /* กำหนดขนาดตัวอักษรสำหรับ Datepicker โดยตรง */
    .datepicker table td,
    .datepicker table th {
      font-size: 12px;
    }

  	.ui-button {
      background-color: #0275d8;
      color: white;
    }

    /* Adjust modal styles */
    .modal-dialog {
      max-width: 800px; /* Adjust modal width */
    }

    /* Customize form inputs */
    .form-control {
      border-color: #0275d8; /* Adjust input border color */
    }

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
		/*width: 100%;
        padding: 10px;*/
        /*background-color: #5392f9 !important;*/
		background-color: #4891b7 !important;
        color: #fff;
       /* border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
		padding: 4px 8px !important;*/
	}
	.btn_sign_in:hover {
        background-color: #4891b7 !important;
        color: #fff !important;
        /*border: #5392f9 !important;*/
	}
	 
	.dropdown-user {
		/*border: 1px solid #5392f9;*/
		border-radius: 4px;
		padding: 4px;
	}
	
	
	.input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3) {
		background-color: #f8f9fa !important;
	}

	@font-face {
	  font-family: 'Noto_Font';
	  src: url('<?= site_url() ?>NotoSerifThai-VariableFont_wdth,wght.ttf') format('truetype');
	  
	}
	
	body {
    font-family: Arial, sans-serif !important;
	}

	.thai-text {
    font-family: 'Noto_Font', Arial, sans-serif !important;
  }

	.navbar-light .navbar-nav .nav-link {
		color: rgba(255, 255, 255, 1.00) !important;
	}
	.navbar-expand {
		background-color: #102958 !important;  
		color: rgba(255, 255, 255, 1.00) !important;
		gap: 0 16px;
	}
	a {
		color: rgba(255, 255, 255, 1.00) !important;
		text-decoration: none !important;
	}
	.dropdown-item {
		color: #000 !important;
		
	}
	
	.logo-img {
/*		width: 70% !important; */
		width: 100px !important;
	}

	@media (min-width: 1024px) {
		.logo-img {
/*			max-width: 70% !important; */
			width: 100px !important;
		}
		.menu-gap {
			gap: 40px !important;
		}
	}

	@media (min-width: 1400px) {
		.logo-img {
/*			max-width: 30% !important; */
			width: 100px !important;
		}
		.navbar-expand-lg .navbar-collapse {
			display: flex !important;
			flex-basis: auto;
		}
		.menu-gap {
			gap: 50px !important;
		}
		
	}

	@media (min-width: 769px) and (max-width: 1024px) {
		.logo-img {
/*			max-width: 50% !important; */
			width: 100px !important;
		}
		
	}
	@media (max-width: 767px) {
		.logo-img {
/*		  width: 20% !important;*/
		  width: 100px !important;
		}
	}
	@media (min-width: 992px) {
		.navbar-expand-lg .navbar-collapse {
			display: flex !important;
			flex-basis: auto;
		}
		.menu-gap {
			gap: 30px !important;
		}
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
</head>

<style type="text/css">
	.enavbar-collaps {
    padding-left: 0;
    padding-right: 0;
    margin-left: 0;
    margin-right: 0;
}
</style>
 <style>
    .header-wrapper {
      background-color: lightblue;
    }

    .slider-wrapper {
      background-color: lightcoral;
    }
  </style>
  
<body>
	<!-- class="navbar navbar-expand-lg navbar-light bg-light fixed-top text-center mr-auto mb-0 m-0 p-0" -->
  <header class="header-wrapper row">


    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top text-center mr-auto mb-0 m-0 p-0" style="height:60px; background-color:#102958 !important; font-size: 14px;">

    	<!-- class="container-fluid m-0 p-0 d-flex justify-content-between align-items-center"	 -->
    	<div class="container-fluid m-0 p-0 d-flex justify-content-between align-items-center" >
				<a class="px-3 mb-0 pb-0" href="<?php echo site_url('home'); ?>">
					<img src="<?php echo site_url(); ?>images/logo-SM/SM smart booking_White.png" style="width: 85px !important;" >
				</a>

      <div  id="menu_t1" class="navbar-expand d-flex flex-row ml-auto navbar-toggler d-lg-none" style="margin-left: auto !important;text-align: right !important;" >

        <!-- <div class="navbar navbar-expand d-flex flex-row ml-auto " style="background-color: #102958 !important;">  -->

       <button id="dropdown_menu"style="background-color: #5392f9 !important;padding: 0.1rem 0.5rem;border-radius: 0.25rem; border: none;" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

		  <?php if ($id_guest != '') { ?>
		  <?php if ($guest->photo_url != '') { ?>
		  <a class=""><img src="<?php echo share_folder_path() . $guest->photo_url; ?>" class="rounded-circle mx-auto d-block" style="height:50px;width:50px;" alt=""></a>
		  <?php } ?>

		  <div class="input-group d-flex flex-row bg-light dropdown-user" style="background-color: #102958 !important;">
			<a class="nav-link align-text-bottom dropdown-toggle" id="profile_name" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #102958 !important; color: rgba(255, 255, 255, 1.00) !important;font-size: 14px;">
				<?php //echo $guest->firstname . ' ' . substr($guest->lastname, 0, 1). '.'; ?>
				<?php
				if (empty($guest->firstname)) {
				    // ถ้า $guest->firstname เป็นค่าว่างหรือ ''
				    echo $guest->name . '.';
				} else {
				    // ถ้า $guest->firstname มีค่า
				    echo $guest->firstname . ' ' . substr($guest->lastname, 0, 1) . '.';
				}
				?>
			</a>

			<button class="btn btn-outline-default btn-default btn-sm dropdown-toggle" style="display: none; " id="profile_dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>

		  <div class="input-group-append">
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="background-color: #fff !important;">
				<a class="dropdown-item" href="<?php echo site_url('profile'); ?>"><?php echo $this->lang->line('profile'); ?></a>
				<a class="dropdown-item" href="<?php echo site_url('booking/history'); ?>"><?php echo $this->lang->line('booking_history'); ?></a>
				<a class="dropdown-item" href="<?php echo site_url('facility'); ?>"><?php echo $this->lang->line('facility'); ?></a>
				<a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a>
			  </div>
		  </div>

		</div>

		  <?php } 
		  else {
		  ?>
		 <div class="button mx-1 ">
	        <a id="signin_button" class="btn btn_sign_in" href="<?php echo site_url('login'); ?>"  style="font-size: 14px !important;padding: 0.3rem 0.9rem !important;border-radius: 0.3rem !important;background-color: #5392f9 !important;" >Sign In</a>
	      </div>

		  <?php } ?>
		  <div class="button">
        <a class="nav-link" href="<?php echo site_url('cart'); ?>">
					<span class="button__badge"><?php echo ($cart_count > 0) ? $cart_count : ''; ?></span>
					<object style="pointer-events: none;" data="<?php echo share_folder_path(); ?>images/icons/cart-white.svg" height="20"> </object>
				</a>
      </div>
		  
		<div id="language_mini2" class="d-flex flex-rows" style="margin-top:3px;padding: 5px; margin-right: 5px;">
			<?php
				$switch_en = 'English';
				$switch_th = 'Thai';
			?>
			<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/thai'; ?>" title="<?php echo $switch_th; ?>" style="color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;" style="<?php echo ($lang == 'thai') ? 'font-weight: bold!important; color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;' : ''; ?>">TH</a>
			<span style="color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;">&nbsp;|&nbsp;</span>
			<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/english'; ?>" title="<?php echo $switch_en; ?>" style="color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;" style="<?php echo ($lang == 'english') ? 'font-weight: bold!important; color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;' : ''; ?>">EN</a>
		</div>

  	</div>

     <!------------- end sign ------->
    

	  <!-- new menu -->
	  <!-- collapse navbar-collapse -->
	  <!-- <div class="collapse navbar-collapse col-8" id="navbarNav"> -->
	  <!-- <div class="container-fluid m-0 p-0 d-flex navbar-collapse" id="navbarNav" style="background-color: #102958 !important;padding-left: 0;padding-right: 0;" > -->

<?php 
$current_url = $_SERVER['REQUEST_URI'];
$is_home = (strpos($current_url, 'home') !== false);

function add_trailing_slash($url) {
    return rtrim($url, '/') . '/';
}

?>

<style type="text/css">
	@media (max-width: 992px) {
    #language_mini {
        display: block !important;
    }
    #language_mini2 {
	      display: none !important;
	   }
	}

	@media (min-width: 992px) {
	    #language_mini {
	       display: none !important;
	    }
	    #language_mini2 {
	    	display: block !important; 
	    }
	}
</style>

	   <div class="collapse navbar-collapse " id="navbarNav" style="background-color: #102958 !important; padding-left: 0; padding-right: 0; padding-top: 0 !important;">
	   			<!-- me-auto -->
					<ul class="navbar-nav mb-4  mb-lg-0  menu-gap" style="font-size: 14px;margin: 0 auto !important;">
						<!-- style="padding-left: 5% !important;" -->
						<!-- style="margin-right: 5% !important;" -->
						<li class="nav-item nav-item-custom" id="nav_aboutus" >
								<a class="nav-link" href="<?php echo site_url('home#aboutus'); ?>">
        					<?php echo $lang == "english" ? 'About us' : 'ข้อมูลโครงการ'; ?>
    						</a>
            </li>

				    <li class="nav-item nav-item-custom" id="nav_roomstype" >
								<a class="nav-link" href="<?php echo site_url('home#roomtype'); ?>"> 
        					<?php echo $lang == "english" ? 'Rooms type' : 'ประเภทห้อง'; ?>
    						</a>
            </li>

            <li class="nav-item nav-item-custom" id="nav_packagep_promotions" >
								<a class="nav-link" href="<?php echo site_url('home#package'); ?>">
        					<?php echo $lang == "english" ? 'Package & Promotions' : 'แพ็คเกจและโปรโมชั่น'; ?>
    						</a>
            </li>

            <li class="nav-item" id="nav_contactus">
                <a class="nav-link" href="<?php echo site_url('facilities'); ?>" >
					<?php echo $lang == "english" ? 'Facilities & Amenities' : 'สิ่งอำนวยความสะดวก'; ?>
								</a>
            </li>

					<li class="nav-item" id="nav_contactus">
              <a class="nav-link" href="<?php echo site_url('conditions'); ?>" >
					<?php echo $lang == "english" ? 'Conditions & Policies' : 'เงื่อนไขและข้อกำหนด'; ?>
							</a>
          </li>

					<li class="nav-item" id="nav_contactus">
						<a class="nav-link" href="<?php echo site_url('contact'); ?>" >
							<?php echo $lang == "english" ? 'Contact us' : 'ติดต่อเรา'; ?>
						</a>
          </li>

          <li class="nav-item" id="language_mini">
          <!-- <div class="d-flex flex-rows" style="margin-top:3px;padding: 5px; margin-right: 5px;"> -->
						<?php
							$switch_en = 'English';
							$switch_th = 'Thai';
						?>
						<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/thai'; ?>" title="<?php echo $switch_th; ?>" style="color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;" style="<?php echo ($lang == 'thai') ? 'font-weight: bold!important; color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;' : ''; ?>">TH</a>
						<span style="color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;">&nbsp;|&nbsp;</span>
						<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/english'; ?>" title="<?php echo $switch_en; ?>" style="color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;" style="<?php echo ($lang == 'english') ? 'font-weight: bold!important; color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;' : ''; ?>">EN</a>
					<!-- </div> -->
					</li>

        </ul>

	<!-- new menu -->
      <div id="menu_t2" class="navbar-expand d-flex flex-row ml-auto d-lg-block d-none" >       
        <div class="navbar navbar-expand d-flex flex-row ml-auto" style="background-color: #102958 !important;"> 
		  <?php if ($id_guest != '') { ?>
		  <?php if ($guest->photo_url != '') { ?>
		  <a class=""><img src="<?php echo share_folder_path() . $guest->photo_url; ?>" class="rounded-circle mx-auto d-block" style="height:50px;width:50px;" alt=""></a>
		  <?php } ?>

		  <div class="input-group d-flex flex-row bg-light dropdown-user" style="background-color: #102958 !important;">            
			<a class="nav-link align-text-bottom dropdown-toggle" id="profile_name" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #102958 !important; color: rgba(255, 255, 255, 1.00) !important;">
				<?php //echo $guest->firstname . ' ' . substr($guest->lastname, 0, 1). '.'; ?>
				<?php
				if (empty($guest->firstname)) {
				    // ถ้า $guest->firstname เป็นค่าว่างหรือ ''
				    echo $guest->name . '.';
				} else {
				    // ถ้า $guest->firstname มีค่า
				    echo $guest->firstname . ' ' . substr($guest->lastname, 0, 1) . '.';
				}
				?>
			</a>

			<button class="btn btn-outline-default btn-default btn-sm dropdown-toggle" style="display: none; " id="profile_dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>

		  <div class="input-group-append">
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="background-color: #fff !important;">
				<a class="dropdown-item" href="<?php echo site_url('profile'); ?>"><?php echo $this->lang->line('profile'); ?></a>
				<a class="dropdown-item" href="<?php echo site_url('booking/history'); ?>"><?php echo $this->lang->line('booking_history'); ?></a>
				<a class="dropdown-item" href="<?php echo site_url('facility'); ?>"><?php echo $this->lang->line('facility'); ?></a>
				<a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a>
			  </div>
		  </div>

		</div>

		  <?php } 
		  else {
		  ?>
			  <div class="button mx-1 ">
	        <a id="signin_button" class="btn btn_sign_in" href="<?php echo site_url('login'); ?>" height="20" style="background-color: #5392f9 !important;" >Sign In</a>
	      </div>
		  <?php } ?>
		  <div class="button pl-lg-4 mr-lg-4 pl-sm-0 mr-sm-0d">
        <a class="nav-link" href="<?php echo site_url('cart'); ?>">
					<span class="button__badge"><?php echo ($cart_count > 0) ? $cart_count : ''; ?></span>
					<object style="pointer-events: none;" data="<?php echo share_folder_path(); ?>images/icons/cart-white.svg" height="20"> </object>
				</a>
      </div>
			<div class="d-flex flex-rows" style="margin-top:3px;padding: 5px; margin-right: 5px;">
			<?php
				$switch_en = 'English';
				$switch_th = 'Thai';
			?>
			<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/thai'; ?>" title="<?php echo $switch_th; ?>" style="color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;" style="<?php echo ($lang == 'thai') ? 'font-weight: bold!important; color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;' : ''; ?>">TH</a>
			<span style="color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;">&nbsp;|&nbsp;</span>
			<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/english'; ?>" title="<?php echo $switch_en; ?>" style="color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;" style="<?php echo ($lang == 'english') ? 'font-weight: bold!important; color: rgba(255, 255, 255, 1.00) !important; font-size: 14px !important;' : ''; ?>">EN</a>
					</div>
        </div>
      </div>

     <!------------- end sign ------->
     </div>
      
    </div>

  </nav>
	
	
</header>

<script>
    document.getElementById('dropdown_menu').addEventListener('click', function() {
        document.getElementById('signin_button').classList.toggle('ml-auto');
    });
</script>