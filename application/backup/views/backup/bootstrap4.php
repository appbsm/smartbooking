<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>bootstrap-4.0.0-dist/css/bootstrap.css">
    <link href="<?php echo site_url();?>css/styles.css" rel="stylesheet">
<style>

body {
	font-size: 0.8em;
}

	img {
  border-radius: 10px;
  cursor: pointer;
  transition: 0.3s;
  }
  
.imgThumbnail_bg {
	padding: 5px;
	padding-left: 5px;
}

.imgThumbnail_sm {
	padding: 5px;	
	border-radius: 5px;
}

.room_type {
	border-radius: 10px;
	border-color: #CCC;
	border-style: solid;
	border-width: 1px;
	margin: 10px;
}

.icon {
	border-radius: 0	;
}

.price {
	background-color: #81BB4A;
}

</style>

</head>
<body>
<main>
<header>
<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
  <a class="navbar-brand" href="#"><img src="<?php echo site_url();?>images/SMS_Logo_Final.png"  width="120"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" style="float: right;" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
    <!-- 
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
       -->
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
    <!-- 
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
     -->
  </div>
</nav>



</header>

<?php 
$proj_photos = array();
$proj_photos[0] = "/images/home_carousel/header_1.jpg";
$proj_photos[1] = 'images/Type_A/Type_A_1.jpg';
$proj_photos[2] = 'images/Type_B/Type_B_1.jpg';
$proj_photos[3] = 'images/Type_C/Type_C_1.jpg';
$proj_photos[4] = 'images/Type_D/Type_D_1.jpg';

$type_a = array();
$type_a[0] = 'images/Type_A/Type_A_1.jpg';
$type_a[1] = 'images/Type_A/Type_A_2.jpg';
$type_a[2] = 'images/Type_A/Type_A_3.jpg';
$type_a[3] = 'images/Type_A/Type_A_4.jpg';

$type_b = array();
$type_b[0] = 'images/Type_B/Type_B_1.jpg';
$type_b[1] = 'images/Type_B/Type_B_2.jpg';
$type_b[2] = 'images/Type_B/Type_B_3.jpg';
$type_b[3] = 'images/Type_B/Type_B_4.jpg';

$type_c = array();
$type_c[0] = 'images/Type_C/Type_C_1.jpg';
$type_c[1] = 'images/Type_C/Type_C_2.jpg';
$type_c[2] = 'images/Type_C/Type_C_3.jpg';
$type_c[3] = 'images/Type_C/Type_C_4.jpg';

$type_d = array();
$type_d[0] = 'images/Type_D/Type_D_1.jpg';
$type_d[1] = 'images/Type_D/Type_D_2.jpg';
$type_d[2] = 'images/Type_D/Type_D_3.jpg';
$type_d[3] = 'images/Type_D/Type_D_4.jpg';
?>


<main style="margin-top: 100px;">

  <section class="py-5 text-center container">
    <h3>SMS Khao Yai</h3>
    
    <!-- SECTION FOR SEARCH -->
  </section>
  <div class="container-fluid" >
  	<div class="row"> 
    	<div class="col-md-6">
    	<img class="myImg" data-id="1" src="<?php echo site_url().'/images/home_carousel/header_1.jpg'?>" style="max-width: 100%;">
    	</div>
    	
    	
    	<div class="col-md-6">
    		<div class="row"> 
    			<div class="col-md-6">
    			<img class="myImg" data-id="2" src="<?php echo site_url().'/images/Type_C/Type_C_1.jpg'?>" style="max-width: 100%;">
    			</div>
    			<div class="col-md-6">
    			<img class="myImg" data-id="3" src="<?php echo site_url().'/images/Type_C/Type_C_2.jpg'?>" style="max-width: 100%;">
    			</div>
    			<!-- 
    			<div class="col-md-6">
    			<img src="<?php echo site_url().'/images/Type_C/Type_C_3.jpg'?>" style="max-width: 100%;">
    			</div>
    			<div class="col-md-6">
    			<img src="<?php echo site_url().'/images/Type_C/Type_C_4.jpg'?>" style="max-width: 100%;">
    			</div>
    			 -->
    		</div>
    		
    		
    		<div class="row" style="margin-top: 25px;" > 
    			<!-- 
    			<div class="col-md-6">
    			<img src="<?php echo site_url().'/images/Type_C/Type_C_1.jpg'?>" style="max-width: 100%;">
    			</div>
    			<div class="col-md-6">
    			<img src="<?php echo site_url().'/images/Type_C/Type_C_2.jpg'?>" style="max-width: 100%;">
    			</div>
    			 -->
    			<div class="col-md-6">
    			<img class="myImg" data-id="4" src="<?php echo site_url().'/images/Type_C/Type_C_3.jpg'?>" style="max-width: 100%;">
    			</div>
    			<div class="col-md-6">
    			<img class="myImg" data-id="5" src="<?php echo site_url().'/images/Type_C/Type_C_4.jpg'?>" style="max-width: 100%;">
    			</div>
    		</div>
    	</div>
    </div>


	<div><hr></div>

	<!-- Room Types -->
	<div class="container text-center">
		<div class="row" >
			<div class="col-md-12"><h3>Room Types</h3></div>
			
			
			<div class="col-md-6">
				<div class="row room_type">
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12 imgThumbnail_bg" ><img class="room_img" src="<?php echo site_url().'images/Type_A/Type_A_1.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" src="<?php echo site_url().'images/Type_A/Type_A_2.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img" src="<?php echo site_url().'images/Type_A/Type_A_3.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img" src="<?php echo site_url().'images/Type_A/Type_A_4.jpg'?>" style="max-width: 100%;"></div>
						</div>
					</div>
					<div class="col-md-5">
						<div style="padding-top: 5px;"><h6>Standard Room</h6></div>
						<div class="price">2,300/Night</div>
						<div class="container text-left">
						<div><object data="<?php echo site_url();?>images/icons/house.svg" width="20" height="20"></object> Area 18 sqm</div>
						<div><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" width="18"> 1 Queen-bed</div>
						<div><object data="<?php echo site_url();?>images/icons/person-fill.svg" width="22" height="22"> </object> 2 Persons</div>
						<div><object data="<?php echo site_url();?>images/icons/tv.svg" width="20" height="20"> </object> TV (Internet)</div>
						<div><object data="<?php echo site_url();?>images/icons/snow.svg" width="20" height="20"> </object> Air Conditioning</div>
						<div><object data="<?php echo site_url();?>images/icons/wifi.svg" width="20" height="20"> </object> Free WIFI</div>
						</div>
					</div>
					
					
				</div>
			</div>
			<div class="col-md-6">
				<div class="row room_type">
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12 imgThumbnail_bg" ><img class="room_img" src="<?php echo site_url().'images/Type_B/Type_B_1.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" src="<?php echo site_url().'images/Type_B/Type_B_2.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img" src="<?php echo site_url().'images/Type_B/Type_B_3.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img" src="<?php echo site_url().'images/Type_B/Type_B_4.jpg'?>" style="max-width: 100%;"></div>
						</div>
					</div>
					<div class="col-md-5">
						<div style="padding-top: 5px;"><h6>Superior Room</h6></div>
						<div class="price">2,500/Night</div>
						<div class="container text-left">
						<div><object data="<?php echo site_url();?>images/icons/house.svg" width="20" height="20"></object> Area 18 Sq.m w/ deck</div>
						<div><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" width="18"> 1 Queen-bed</div>
						<div><object data="<?php echo site_url();?>images/icons/person-fill.svg" width="22" height="22"> </object> 2 Persons</div>
						<div><object data="<?php echo site_url();?>images/icons/tv.svg" width="20" height="20"> </object> TV (Internet)</div>
						<div><object data="<?php echo site_url();?>images/icons/snow.svg" width="20" height="20"> </object> Air Conditioning</div>
						<div><object data="<?php echo site_url();?>images/icons/wifi.svg" width="20" height="20"> </object> Free WIFI</div>
						</div>
					</div>
					
					
				</div>
			</div>
			<div class="col-md-6">
				<div class="row room_type">
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12 imgThumbnail_bg" ><img class="room_img" src="<?php echo site_url().'images/Type_C/Type_C_1.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" src="<?php echo site_url().'images/Type_C/Type_C_2.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img" src="<?php echo site_url().'images/Type_C/Type_C_3.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img" src="<?php echo site_url().'images/Type_C/Type_C_4.jpg'?>" style="max-width: 100%;"></div>
						</div>
					</div>
					<div class="col-md-5">
						<div style="padding-top: 5px;"><h6>Junior Suite</h6></div>
						<div class="price">3,800/Night</div>
						<div class="container text-left">
						<div><object data="<?php echo site_url();?>images/icons/house.svg" width="20" height="20"></object> Area 36 Sq.m</div>
						<div><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" width="18"> 2 Bedrooms <br>&nbsp;1 Queen-bed</div>
						<div><object data="<?php echo site_url();?>images/icons/person-fill.svg" width="22" height="22"> </object> 2 Adults, 2 Kids</div>
						<div><object data="<?php echo site_url();?>images/icons/tv.svg" width="20" height="20"> </object> TV (Internet)</div>
						<div><object data="<?php echo site_url();?>images/icons/snow.svg" width="20" height="20"> </object> Air Conditioning</div>
						<div><object data="<?php echo site_url();?>images/icons/wifi.svg" width="20" height="20"> </object> Free WIFI</div>
						</div>
					</div>
					
					
				</div>
			</div>
			<div class="col-md-6">
				<div class="row room_type">
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12 imgThumbnail_bg" ><img class="room_img" src="<?php echo site_url().'/images/Type_A/Type_A_1.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm" ><img class="room_img" src="<?php echo site_url().'/images/Type_A/Type_A_2.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img" src="<?php echo site_url().'/images/Type_A/Type_A_3.jpg'?>" style="max-width: 100%;"></div>
							<div class="col-md-4 imgThumbnail_sm"><img class="room_img" src="<?php echo site_url().'/images/Type_A/Type_A_4.jpg'?>" style="max-width: 100%;"></div>
						</div>
					</div>
					<div class="col-md-5">
						<div style="padding-top: 5px;"><h6>Family Junior Suite</h6></div>
						<div class="price">6,800/Night</div>
						<div class="container text-left">
						<div><object data="<?php echo site_url();?>images/icons/house.svg" width="20" height="20"></object> Area 72 Sq.m</div>
						<div><img class="icon" src="<?php echo site_url();?>images/icons/icons8-bedroom-50.png" width="18"> 1 Queen-bed</div>
						<div><object data="<?php echo site_url();?>images/icons/person-fill.svg" width="22" height="22"> </object> 2 abults or 2 kid over 12 years old</div>
						<div><object data="<?php echo site_url();?>images/icons/tv.svg" width="20" height="20"> </object> TV (Internet)</div>
						<div><object data="<?php echo site_url();?>images/icons/snow.svg" width="20" height="20"> </object> Air Conditioning</div>
						<div><object data="<?php echo site_url();?>images/icons/wifi.svg" width="20" height="20"> </object> Free WIFI</div>
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


<div class="container text-center">

<!-- Modal -->
<div class="modal fade" id="ModalCarousel" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

  

 <!-- Sliding images statring here --> 
   <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="slide 1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"  class="slide 2"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"  class="slide 3"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="3"  class="slide 4"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="4"  class="slide 5"></li>
  </ol>
  <div class="carousel-inner">
  	<div class="carousel-item 1 active">
      <img class="d-block w-100" src="<?php echo site_url().'/images/home_carousel/header_1.jpg'?>" alt="First slide">
    </div>
    <div class="carousel-item 2 ">
      <img class="d-block w-100" src="<?php echo site_url().'/images/Type_C/Type_C_1.jpg'?>" alt="Second slide">
    </div>
    <div class="carousel-item 3">
      <img class="d-block w-100" src="<?php echo site_url().'/images/Type_C/Type_C_2.jpg'?>" alt="Third slide">
    </div>
    <div class="carousel-item 4">
      <img class="d-block w-100" src="<?php echo site_url().'/images/Type_C/Type_C_3.jpg'?>" alt="Fourth slide">
    </div>
    <div class="carousel-item 5">
      <img class="d-block w-100" src="<?php echo site_url().'/images/Type_C/Type_C_4.jpg'?>" alt="Fifth slide">
    </div>
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

<script src="//code.jquery.com/jquery.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
<script>
	$(function(){
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
			});
	})
</script>
	
</body>
</html>

