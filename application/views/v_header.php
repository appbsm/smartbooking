<?php
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI = &get_instance();
$CI->load->model('m_room_type');

?>
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

  <!-- icon font-awesome -->
  <link href="<?php echo site_url(); ?>assets/font-awesome/css/all.min.css" rel="stylesheet">

  <link href="<?php echo site_url(); ?>css/styles.css" rel="stylesheet">
  <link href="<?php echo site_url(); ?>css/css.css" rel="stylesheet">
  <?php echo $lang=='english'?'<link href="'.site_url().'css/custom_header_en.css" rel="stylesheet">':'<link href="'.site_url().'css/custom_header_th.css" rel="stylesheet">';?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?v=1001">
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
</head>


<body>
  <header>
    <nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top text-center mr-auto mb-0" style="height:70px; background-color:#fff !important; border-bottom: 1px solid #ccc;">
    <div class="container d-flex flex-row">
		
	  <span class="mx-3">
		<a class="logo" href="<?php echo site_url('home'); ?>"><img src="<?php echo site_url(); ?>images/10.png" width="70"></a>
	  </span>  

	  <!-- new menu -->
	  <div class="col-9">
		<ul class="navbar-nav me-auto mb-2 mb-lg-0 menu-bar">
            <li class="nav-item" id="nav_aboutus">
                <a class="nav-link" href="#aboutus">
					<?php echo $lang == "english" ? 'About us' : 'เกี่ยวกับเรา'; ?> 
				</a>
            </li>
            <li class="nav-item" id="nav_roomstype">
                <a class="nav-link" href="#roomtype">
					<?php echo $lang == "english" ? 'Rooms type' : 'ประเภทห้อง'; ?> 
				</a>
            </li>
            <li class="nav-item" id="nav_packagep_promotions">
                <a class="nav-link" href="#package">
					<?php echo $lang == "english" ? 'Package & Promotions' : 'แพ็คเกจและโปรโมชั่น'; ?> 
				</a>
            </li>
            <li class="nav-item" id="nav_contactus">
                <a class="nav-link" href="#facilities_amenities">
					<?php echo $lang == "english" ? 'Facilities & Amenities' : 'สิ่งอำนวยความสะดวก'; ?>
				</a>
            </li>
			<li class="nav-item" id="nav_contactus">
                <a class="nav-link" href="#nearby_locations">
					<?php echo $lang == "english" ? 'Nearby Locations' : 'สถานที่ใกล้เคียง'; ?>
				</a>
            </li>
			<li class="nav-item" id="nav_contactus">
                <a class="nav-link" href="#contactus">
					<?php echo $lang == "english" ? 'Contact us' : 'ติดต่อเรา'; ?>
				</a>
            </li>
        </ul>
	</div>
	  <!-- new menu -->
      <div class="" id="navbarSupportedContent" >       
        <div class="navbar navbar-expand d-flex flex-row" style="gap: 0 16px; background-color:#fff !important;">
          
		  <?php if ($id_guest != '') { ?>
		  <?php if ($guest->photo_url != '') { ?>
		  <a class=""><img src="<?php echo share_folder_path() . $guest->photo_url; ?>" class="rounded-circle mx-auto d-block" style="height:50px;width:50px;" alt=""></a>
		  <?php } ?>
		  <div class="input-group d-flex flex-row bg-light" >            
			<a class="nav-link align-text-bottom dropdown-toggle" id="profile_name" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php echo $guest->firstname . ' ' . substr($guest->lastname, 0, 1). '.'; ?>
			</a>
			<button class="btn btn-outline-default btn-default btn-sm dropdown-toggle" style="display: none;" id="profile_dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
		  <div class="input-group-append">
			
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
		  <div class="button mx-1">
                <a class="btn btn_sign_in"  href="<?php echo site_url('login'); ?>" height="20">Sign In</a>
              </div>
		  <?php } ?>
		  <div class="button">
            <a class="nav-link" href="<?php echo site_url('cart'); ?>"><span class="button__badge"><?php echo ($cart_count > 0) ? $cart_count : ''; ?></span><object style="pointer-events: none;" data="<?php echo share_folder_path(); ?>images/icons/cart.svg" height="20"> </object></span></a>
          </div>
		  
		<div class="d-flex flex-rows" style="margin-top:3px;padding: 5px; margin-right: 5px;">
			<?php
			$switch_en = 'English';
			$switch_th = 'Thai';
			?>
			<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/thai'; ?>" title="<?php echo $switch_th; ?>" style="<?php echo ($lang == 'thai') ? 'font-weight: bold!important;' : ''; ?>">TH</a>
			<span>&nbsp;|&nbsp;</span>
			<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/english'; ?>" title="<?php echo $switch_en; ?>" style="<?php echo ($lang == 'english') ? 'font-weight: bold!important;' : ''; ?>">EN</a>
		  </div>

        </div>
      </div>
      
      </div>
    </nav>
	
	
</header>