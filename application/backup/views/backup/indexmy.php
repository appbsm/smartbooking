<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>bootstrap-4.0.0-dist/css/bootstrap.css">
    <link href="<?php echo site_url();?>css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?v=1001">
<style>

body {
	font-size: 0.8em;
	
	font-family: 'source_sans', 'thai_sans', Arial, Tahoma!important;
}

.img_border {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
  
  }
  
.imgThumbnail_bg {
	margin: 7px;
	
}

.imgThumbnail_sm {
	padding: 5px;	
	border-radius: 5px;
}

.navbar {
	padding: 0!important;
}

.room_type {
	border-radius: 2px;	
	border-color: #CCC;
	border-style: solid;
	border-width: 1px;
	margin: 1px 0 1px 0;
}

.icon {
	border-radius: 0	;
}

.price {
	margin-bottom: 5px;
	background-color: #81BB4A;
	color: black;
}

.project_name {
	margin: auto;
	font-size: 3vh;
}






.icon_container {
  position: relative;
  min-height: 25px;
}

.icon-content-img {
  position: absolute;
  bottom: 0;
}

.icon-content {
  position: absolute;
}

.box {
    padding: 5px 5px 5px 5px;
}

.box-big {
    border: 1px;
   border-color: #CCC;
	border-style: solid;
   
}

.roomtypes {
	font-size: 3vh;
	font-weight: bold;
}


.roomname {
	font-size: 1.2em;
}



.icon_container {
  position: relative;
  min-height: 25px;
}

.text-left .col-md-9 {
  height: 40px !important;
}

.icon-content-img {
  position: absolute;
  bottom: 0;
}

.icon-content {
  position: absolute;
}

@media only screen and (max-width: 411px) {
	.top-left-grid img {
		width: 100%;
		height: auto;
		max-height: 97%;
	}
}

@media only screen and (min-width: 412px) {
	.top-left-grid img {
		width: 100%;
		height: auto;
		max-height: 98.5%;
	}
}

@media only screen and (max-width: 767px) {
	.top-left-grid {
		padding-left: 15px !important;
		padding-right: 15px !important;
	}
	.top-right-grid {
		padding-left: 16px !important;
		padding-right: 0px !important;
	}
}

@media only screen and (min-width: 768px) {
	.top-left-grid {
		padding-left: 15px !important;
		padding-right: 3px !important;
	}
	.top-right-grid {
		padding-left: 3px !important;
		padding-right: 3px !important;
	}
}

@media only screen and (max-width: 767px) {
	.room_type .text-left .row {
		margin: 0 -35px 0 -30px !important;
	}
	.room_type .price {
		margin-right: -15px;
	}
}

@media only screen and (min-width: 768px) {
	.room_type .text-left .row {
		margin: 0 -35px 0 -40px !important;
	}
}

@media only screen and (max-width: 300px) {
	.room_type .text-left .row .col-md-2 {
		width: 5% !important;
		padding-left: 5px !important;
		padding-right: 5px !important;
	}
	.room_type .text-left .row .col-md-9 {
		width: 90% !important;
		padding-left: 20px !important;
		padding-right: 0px !important;
	}
}

@media only screen and (min-width: 301px) and (max-width: 575px) {
	.room_type .text-left .row .col-md-2 {
		width: 5% !important;
		padding-left: 15px !important;
		padding-right: 5px !important;
	}
	.room_type .text-left .row .col-md-9 {
		width: 90% !important;
		padding-left: 20px !important;
		padding-right: 1px !important;
	}
}

@media only screen and (min-width: 576px) and (max-width: 1200px) {
	.room_type .text-left .row .col-md-2 {
		width: 3% !important;
		padding-left: 8px !important;
		padding-right: 0px !important;
	}
	.room_type .text-left .row .col-md-9 {
		width: 95% !important;
		padding-left: 1px !important;
		padding-right: 0px !important;
	}
}

@media only screen and (min-width: 1201px) {
	.room_type .text-left .row .col-md-9 {
		padding-left: 10px !important;
	}
}

.room_type1 .icon-content {
	white-space: nowrap;
    overflow: hidden;
    text-overflow: clip;
}

.room-type-name {
	font-size: 2.5vh;
	font-weight: bold;
	padding-top: 10px;
	padding-bottom: 5px;
}

.footer {
	font-size: 17px;
	width: 100%;
	height: 35px;
	margin-top: 2px;
	text-align: center;
}

.footer-phone {
	overflow: hidden;
	white-space: nowrap;
}

@media only screen and (min-width: 1201px) {
	.container-fluid {
		padding-left: 50px;
		padding-right: 50px;
	}
}

@media only screen and (max-width: 1200px) {
	.container-fluid {
		padding-left: 7px;
		padding-right: 7px;
	}
}

.room_img {
	cursor: pointer;
}



select {
	border: 1px;
    border-color: #ABB2B9;
	border-style: solid;
	border-radius: 3px;
	
}

input {
	border: 1px;
    border-color: #ABB2B9;
	border-style: solid;
	border-radius: 3px;
	height: 2em;
}

.group {
	display:flex;
    flex-direction:column;
    text-align: left;
    margin-left: 5px;
    width: 50%;
}
#dropdownMenuButton {
	height: 4em!important;	
	border-radius: 5px;
}

.dropdown-menu {
	width: 250px;
	/*height: 200px;*/
	
}

.input_number {
	-moz-appearance: textfield;
	text-align: center;
	font-size: 30px;
	border: none;
	background-color: #fffff;
	color: #202030;
	width: 80px;
}

.input-number::webkit-outer-spin-button,
.input-number::webkit-inner-spin-button {
	-webkit-appearance: none;
	margin: 0;
	border: none;
}

.input-number:focus {
	border: none;
}

.btn_stepper {
	color: #3264fe;
	background-color: #ffffff;
	border: none;
	font-size: 30px;
	cursor: pointer;
}

.stepper {
	display: flex;
	flex-direction: column;
	justify-content: center;
}

@media only screen and (max-width: 522px) {
	.project_name {
		font-size: 3.3vh;
		padding-right: 5px;
	}
}

@media only screen and (max-width: 280px) {
	.main-1 {
		margin-top: 155px;
	}
}

@media only screen and (min-width: 281px) and (max-width: 386px) {
	.main-1 {
		margin-top: 120px;
	}
}

@media only screen and (min-width: 387px) {
	.main-2 {
		margin-top: 100px;
	}
}




</style>

</head>
<?php 
$home = array(
	'Home_1.jpg',
	'Home_2.jpg',
	'Home_3.jpg',
	'Home_4.jpg',
	'Home_5.jpg',
	'Home_6.jpg',
	'Home_7.jpg',
	'Home_8.jpg',
	'Home_9.jpg',
	'Home_10.jpg',
	'Home_11.jpg',
	'Home_12.jpg',
	'Home_13.jpg',
	'Home_14.jpg',
	'Home_15.jpg'
);

$type_a = array(
	'images/Type_A/Type_A_1.jpg',
	'images/Type_A/Type_A_2.jpg',
	'images/Type_A/Type_A_3.jpg',
	'images/Type_A/Type_A_4.jpg'
);

$type_b = array(
	'images/Type_B/Type_B_1.jpg',
	'images/Type_B/Type_B_2.jpg',
	'images/Type_B/Type_B_3.jpg',
	'images/Type_B/Type_B_4.jpg'
);

$type_c = array(
	'images/Type_C/Type_C_1.jpg',
	'images/Type_C/Type_C_2.jpg',
	'images/Type_C/Type_C_3.jpg',
	'images/Type_C/Type_C_4.jpg'
);

$type_e = array(
	'images/Type_E/Type_E_1.jpg',
	'images/Type_E/Type_E_2.jpg',
	'images/Type_E/Type_E_3.jpg',
	'images/Type_E/Type_E_4.jpg'
);
?>

<?php 
$lang = $this->input->get('lang');
?>

<body>

<header>
<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light text-center mr-auto">
  
  
  <!-- responsive menu - Hide for now 
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  -->
  <a class="navbar-brand" href="#"><img src="<?php echo site_url();?>images/SMS_Logo_Final.png"  width="100"></a>
  <div class="project_name">SMS Showroom @ Khao Yai</div>
  <div style="width:100px; position:absolute; top:12px; right:-25px">
  	<a href="<?php echo site_url();?>?lang=th" style="<?php echo $lang == 'th' ? 'text-decoration:underline': ''; ?>">TH</a>
  	<span>&nbsp;|&nbsp;</span>
  	<a href="<?php echo site_url();?>?lang=en" style="margin-right:20px; <?php echo $lang == 'en' ? 'text-decoration:underline': ''; ?>">EN</a>
  </div>
  
  <!-- 
  <div class="collapse navbar-collapse" style="float: right;" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
   
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Panya Polnongluang
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Logout</a>
        </div>
      </li>
    </ul>
     
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    
  </div>
   -->
</nav>



</header>

<main style="margin-top: 120px;">

  <section class="text-center container">
    <!-- SECTION FOR SEARCH -->
    <div class="container-fluid text-center bg-light">
		<div class="row" style="display: flex; flex-direction: row;">
				<div class="col-md-6" style="display: flex; flex-direction: row; padding: 10px;">
					<div class="group">
					    <label for="name">Check-in Date</label>
					    <input type='text' class=" datepicker" name="dateSelect" id="dateSelect" value=""/>
					</div>
					<div class="group">
					    <label for="name">Check-out Date</label>
					    <input type='text' class=" datepicker" name="dateSelect" id="dateSelect" value=""/>
					</div>
				</div>
				
				<div class="col-md-3" style="display: flex; flex-direction: row; justify-content: center; padding: 10px;">
					<div class="dropdown" >
						  <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <span id="div_adult">2</span> Adults, <span id="div_children">0</span> Kids, <span id="div_room">1</span> Rooms
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							    <div class="stepper">
							    <div style="display: flex; justify-content: center;">Adult</div>
							    <div style="display: flex; justify-content: center; background-color: white; ">							    
							    <button class="btn_stepper " id="decrement-adult" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="2" id ="adult" readonly>
							    <button class="btn_stepper " id="increment-adult" onClick="stepper(this);"> + </button>
							    </div>

							    <div style="display: flex; justify-content: center;">Children</div>
							    <div style="display: flex; justify-content: center; background-color: ">							    
							    <button class="btn_stepper " id="decrement-children" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="0" id ="children" readonly>
							    <button class="btn_stepper " id="increment-children" onClick="stepper(this);"> + </button>
							    </div>
							    
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
				
				<div class="col-md-3" style="display: flex; flex-direction: row; padding: 10px;">
					<button id="search" class="form-control">SEARCH</button>
				</div>

		</div>
	</div>
  </section>
  
  
  <div class="container-fluid " >
  	<div class="row px-4"> 
    	<div class="col-md-6  box">
    	<!-- <img class="myImg imgThumbnail_bg" data-id="1" src="<?php echo site_url().'images/Home/home_1.jpg'?>" style="max-width: 100%;"> -->
    	<img class="myImg img_border" data-id="1" src="<?php echo site_url().'images/Home/home_1.jpg'?>" style=" max-width: 100%; height: 101%;">
    	</div>
    	
    	
    	<div class="col-md-6 " >
    		<div class="row"> 
    			<?php $ctr = 1;
    			do {
    				$rowct = $ctr + 1;
    			?>
    			<div class="col-md-6 box">
    			<img class="myImg img_border" data-id="<?php echo $rowct;?>" src="<?php echo site_url().'images/Home/home_'.$rowct.'.jpg'?>" style="max-width: 100%;">
    			</div>
    			<?php 	
    			$ctr++;
    			} while ($ctr < 5);
    			?>
    		</div>    		    	
    	</div>
    </div>


	<div><hr></div>

	<!-- Room Types -->
	<div class="container-fluid text-center bg-light">
		<div class="row" >
			<div class="col-md-12" style="margin-top:10px;">
				<span class="roomtypes"><?php echo $lang == 'en' ? 'Room Types' : 'รูปแบบห้องพัก'; ?></span>
			</div>
			<div class="col-md-6" style="padding:2px 17px 2px 17px;">
				
				<div class="row room_type">
					<div class="col-md-12">
						<div class="room-type-name">SMS1 - Standard Room</div>
					</div>
					<div class="col-md-7">
						<div class="row">
						<?php 
						$ctr = 0;
						do { 
						if ($ctr == 0) {
							echo '<div class="col-md-12 imgThumbnail_sm" ><img class="room_img" data-type="a" data-ctr="'.$ctr.'" src="'.site_url().$type_a[$ctr].'" style="max-width: 100%;"></div>';
						}
						else {
							echo '<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" data-type="a" data-ctr="'.$ctr.'" src="'.site_url().$type_a[$ctr].'" style="max-width: 100%;"></div>';
						}
						?>
						<?php 
						$ctr++;
						}while ($ctr < 4);?>													
						</div>
					</div>
					<div class="col-md-5">
						<div class="price" style="margin-bottom:15px; margin-top:5px; margin-left:-15px;"><b><?php echo $lang == 'en' ? '2,500/Night' : 'ราคา 2,500/คืน'; ?></b></div>
						
						<div class="container text-left">
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Area 18 Sq.m' : 'ขนาดพื้นที่ห้อง: 18 ตรม.'; ?></span>
						</div>
						</div>

						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container" >
							<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" height="18"></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '1 Queen-bed' : 'เตียงนอน: 1 Queen-bed'; ?></span>
						</div>
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container" >
							<span class="icon-content" style="margin-left:1px;"><object data="<?php echo site_url();?>images/icons/person-fill.svg" height="18"></object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '2 Adults' : 'จำนวนผู้เข้าพัก: 2' ;?></span>
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
						
						
						</div>
					
					
				</div>
			</div>
			<div class="col-md-6" style="padding:2px 17px 2px 17px;">
				
				<div class="row room_type">
					<div class="col-md-12">
						<div class="room-type-name">SMS2 - Superior Room</div>
					</div>
					<div class="col-md-7">
						<div class="row">
						<?php 
						$ctr = 0;
						do { 
						if ($ctr == 0) {
							echo '<div class="col-md-12 imgThumbnail_sm" ><img class="room_img" data-type="b" data-ctr="'.$ctr.'" src="'.site_url().$type_b[$ctr].'" style="max-width: 100%;"></div>';
						}
						else {
							echo '<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" data-type="b" data-ctr="'.$ctr.'" src="'.site_url().$type_b[$ctr].'" style="max-width: 100%;"></div>';
						}
						?>
						<?php 
						$ctr++;
						}while ($ctr < 4);?>													
						</div>
					</div>
					<div class="col-md-5">
						<div class="price" style="margin-bottom:15px; margin-top:5px; margin-left:-15px;"><b><?php echo $lang == 'en' ? '3,000/Night' : 'ราคา 3,000/คืน'; ?></b></div>
						<div class="container text-left">
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? 'Area 18 Sq.m' : 'ขนาดพื้นที่ห้อง: 18 ตรม.'; ?></span>
						</div>
						</div>

						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="margin-left:1px; margin-top:-3px;"><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" width="18"></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '1 Queen-bed' : 'เตียงนอน: 1 Queen-bed'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content" style="margin-left:1px;"><object data="<?php echo site_url();?>images/icons/person-fill.svg" height="18"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content"><?php echo $lang == 'en' ? '2 Adults' : 'จำนวนผู้เข้าพัก: 2'; ?></span>
						</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/tv.svg" height="20"> </object></span>
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
						
						<div class="row">
						<div class="col-md-2 col-sm-2 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/wifi.svg" height="20"> </object></span>
						</div>
						<div class="col-md-9 col-sm-9 icon_container">
							<span class="icon-content">Free WIFI</span>
						</div>						
						</div>												
						
						</div>
					</div>
					
					
				</div>
			</div>
			<div class="col-md-6 ">				
				<div class="row room_type">
					<div class="col-md-12"><span class="roomname">Junior Suite</span></div>
					<div class="col-md-6">
						<div class="row">
						<?php 
						$ctr = 0;
						do { 
						if ($ctr == 0) {
							echo '<div class="col-md-12 imgThumbnail_sm" ><img class="room_img" data-type="c" data-ctr="'.$ctr.'" src="'.site_url().$type_c[$ctr].'" style="max-width: 100%;"></div>';
						}
						else {
							echo '<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" data-type="c" data-ctr="'.$ctr.'" src="'.site_url().$type_c[$ctr].'" style="max-width: 100%;"></div>';
						}
						?>
						<?php 
						$ctr++;
						}while ($ctr < 4);?>													
						</div>
					</div>
					<div class="col-md-6">
						<div class="price">4,000/Night</div>
						<div class="text-left">
						
						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">Area 36 Sq.m</span></div>
						</div>

						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" height="18"></span>
						</div>
						<div class="col-md-10 col-9 icon_container" ><span class="icon-content">1 Bedroom/1 Queen-bed</span></div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/person-fill.svg" height="18"> </object></span>
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">2 Adults, 2 Kids</span></div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/tv.svg" height="20"> </object></span>
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">TV (Internet)</span></div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/snow.svg" height="20"> </object></span>
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">Air Conditioning</span></div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/wifi.svg" height="20"> </object></span>
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">Free WIFI</span></div>						
						</div>
												
						</div>
					</div>
					
					
				</div>
			</div>
			<div class="col-md-6 ">
				
				<div class="row room_type">
					<div class="col-md-12"><span class="roomname">Family Junior Suite</span></div>
					<div class="col-md-6">
						<div class="row">
						<?php 
						$ctr = 0;
						do { 
						if ($ctr == 0) {
							echo '<div class="col-md-12 imgThumbnail_sm" ><img class="room_img" data-type="e" data-ctr="'.$ctr.'" src="'.site_url().$type_e[$ctr].'" style="max-width: 100%;"></div>';
						}
						else {
							echo '<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" data-type="e" data-ctr="'.$ctr.'" src="'.site_url().$type_e[$ctr].'" style="max-width: 100%;"></div>';
						}
						?>
						<?php 
						$ctr++;
						}while ($ctr < 4);?>													
						</div>
					</div>
					<div class="col-md-6">
						<div class="price">7,500/Night</div>
						<div class="text-left">
						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/house.svg" height="20"></object></span> 
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">Area 72 Sq.m</span></div>
						</div>

						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" height="18"></span>
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">3 Bedrooms/Queen-bed</span></div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/person-fill.svg" height="18"> </object></span>
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">6 Adults</span></div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/tv.svg" height="20"> </object></span>
						</div>
						<div class="col-md-10 col-9 icon_container">TV (Internet)</div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-1">
							<object data="<?php echo site_url();?>images/icons/snow.svg" width="20" height="20"> </object>
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">Air Conditioning</span></div>						
						</div>
						
						<div class="row">
						<div class="col-md-2 col-1 icon_container">
							<span class="icon-content"><object data="<?php echo site_url();?>images/icons/wifi.svg" height="20"> </object></span>
						</div>
						<div class="col-md-10 col-9 icon_container"><span class="icon-content">Free WIFI</span></div>						
						</div>
						
						
						</div>
					</div>
					
					
				</div>
			</div>
			
		</div>
  	</div>
  	
  	
  	<div><hr></div>
  	
  </div>


  

</main>

<!-- The Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
        <img class="modal-content" id="img01">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
      </div>
    </div>
  </div>
</div>

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
    foreach ($home as $h) {
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
    foreach ($home as $h) {
    ?>
    <div class="carousel-item <?php echo $ctr;?> active" >
      <img class="d-block w-100" src="<?php echo site_url().'images/Home/home_'.$ctr.'.jpg'?>" alt="slide <?php echo $ctr;?>">
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

		
			

		
		
		var type_a = [<?php echo '"'.implode('","', $type_a).'"' ?>]; 
		var type_b = [<?php echo '"'.implode('","', $type_b).'"' ?>]; 
		var type_c = [<?php echo '"'.implode('","', $type_c).'"' ?>]; 
		var type_e = [<?php echo '"'.implode('","', $type_e).'"' ?>]; 
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
				var url = "<?php echo site_url();?>" + arr_photos[x];
				var li = '<li data-target="#carouselRoomExampleIndicators" data-slide-to="'+x+'" class="slide '+i+'"></li>';
					 
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

		/*
		$(".room_img").on('click', function(e){
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
	})
</script>
	
</body>
</html>

