<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>bootstrap-3.1.1-dist/css/bootstrap.css">
    <link href="<?php echo site_url();?>css/styles.css" rel="stylesheet">
<style>
	.myImg {
  border-radius: 10px;
  cursor: pointer;
  transition: 0.3s;

}
</style>

</head>
<body>
<main>
<header>
<nav class="navbar fixed-top bg-light">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="<?php echo site_url();?>images/SMS_Logo_Final.png"  width="120"></a>
      <button style="background-color:#81BB4A;" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <i class="fa fa-bars"></i>
                            <span class="sr-only">Toggle navigation</span>
                        </button>
    </div>
    <div class="collapse navbar-collapse" style="float: right;" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="dropdown" ><a class="dropdown-toggle" style="color:#607d8b;" data-toggle="dropdown" href="#">Mychelle Taawan <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <!-- 
          <li><a href="#">Profile</a></li>
          <li><a href="#">Booking History</a></li>
           -->
          <li><a href="#">Logout</a></li>
        </ul>
      </li>
    </ul>
    </div>
    
  </div>
</nav>
  
</header>

<main style="margin-top: 50px;">

  <section class="py-5 text-center container">
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


	<!-- Room Types -->
	<div class="row">
		<div class="col-md-12"><h3>Room Types</h3></div>
	
	</div>
  
  </div>


  

</main>




<div class="container text-center">

<!-- Modal -->
<div class="modal fade" id="ModalCarousel" tabindex="-1" role="dialog" aria-labelledby="ModalCarouselLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div id="carousel-modal-demo" class="carousel slide" data-ride="carousel">

  

 <!-- Sliding images statring here --> 
   <div class="carousel-inner"> 
   	<div class="item 1"> 
      <img class="" src="<?php echo site_url().'/images/home_carousel/header_1.jpg'?>" style="max-width: 100%;">
    </div> 
    <div class="item 2"> 
      <img class="" src="<?php echo site_url().'/images/Type_C/Type_C_1.jpg'?>" style="max-width: 100%;">
    </div> 
    <div class="item 3"> 
      <img class="" src="<?php echo site_url().'/images/Type_C/Type_C_2.jpg'?>" style="max-width: 100%;">
   </div> 
    <div class="item 4"> 
      <img class="" src="<?php echo site_url().'/images/Type_C/Type_C_3.jpg'?>" style="max-width: 100%;">
    </div>
    <div class="item 5 active"> 
      <img class="" src="<?php echo site_url().'/images/Type_C/Type_C_4.jpg'?>" style="max-width: 100%;">
    </div> 
     
  </div> 
  <!-- Next / Previous controls here -->
  <a class="left carousel-control" href="#carousel-modal-demo" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-modal-demo" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
  
</div>
    </div>
  </div>
</div>
</div>

<script src="//code.jquery.com/jquery.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
	$(function(){
		$('.myImg').click(function(){
			var id = $(this).attr('data-id');
			$('.item').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.'+id).addClass('active');
			$('#ModalCarousel').modal('show');
		});
	})
</script>
	
</body>
</html>

