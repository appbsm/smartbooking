<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>SMS Booking</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">

    

    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?php echo site_url();?>assets/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo site_url();?>css/style.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
	
	<style>
		.img-size{
/* 	padding: 0;
	margin: 0; */
	height: 450px;
	width: 700px;
	background-size: cover;
	overflow: hidden;
}
.modal-content {
   width: 700px;
  border:none;
}
.modal-body {
   padding: 0;
}

.carousel-control-prev-icon {
	background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
	width: 30px;
	height: 48px;
}
.carousel-control-next-icon {
	background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
	width: 30px;
	height: 48px;
}
	
	</style>
<!-- 	
	<style>
body {font-family: Arial, Helvetica, sans-serif;}

.myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
 -->
</style>
    
  </head>
  
  
  
  <body>
    
<header>
  <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
    <div class="container-fluid" >
      <a href="index.php"><img src="images/SMS_Logo_Final.png"  width="120"></a>  

      <div class="collapse navbar-collapse" id="navbarCollapse" style="width: auto; justify-content: end;">
        <ul class="navbar-nav nav mb-2 mb-md-0" >
          
          
          <li class="nav-item" id="home" data-name="home" style="float: right;">
            <a class="nav-link active n_link"  aria-current="page" href="index.php"><i class="fa fa-bars"></i> </a>
          </li>
          
         
        <div>
            <!-- <a class="" href="#" >TH</a> | <a class="" href="#" >EN</a>  -->
        </div>
        
        <!-- 
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
         -->
      </div>
      
    </div>
  </nav>
</header>

<main>

  <section class="py-5 text-center container">
    <!-- SECTION FOR SEARCH -->
  </section>
  <div class="container">
  	<div class="row"> 
    	<div class="col-md-6">
    	<img class="myImg" src="<?php echo site_url().'/images/home_carousel/header_1.jpg'?>" style="max-width: 100%;">
    	</div>
    	<div class="col-md-6">
    		<div class="row"> 
    			<div class="col-md-6">
    			<img class="myImg" src="<?php echo site_url().'/images/Type_C/Type_C_1.jpg'?>" style="max-width: 100%;">
    			</div>
    			<div class="col-md-6">
    			<img class="myImg" src="<?php echo site_url().'/images/Type_C/Type_C_2.jpg'?>" style="max-width: 100%;">
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
    			<img class="myImg" src="<?php echo site_url().'/images/Type_C/Type_C_3.jpg'?>" style="max-width: 100%;">
    			</div>
    			<div class="col-md-6">
    			<img class="myImg" src="<?php echo site_url().'/images/Type_C/Type_C_4.jpg'?>" style="max-width: 100%;">
    			</div>
    		</div>
    	</div>
    </div>
  
    <div class="row mb-4">
    <div class="col text-center">
      <a href="#" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#largeModal">Click to open Modal</a>
    </div>
  </div>
  
  </div>


  

</main>

<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>


 <!-- modal -->
  <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
           <!-- carousel -->
          <div
               id='carouselExampleIndicators'
               class='carousel slide'
               data-ride='carousel'
               >
            <ol class='carousel-indicators'>
              <li
                  data-target='#carouselExampleIndicators'
                  data-slide-to='0'
                  class='active'
                  ></li>
              <li
                  data-target='#carouselExampleIndicators'
                  data-slide-to='1'
                  ></li>
              <li
                  data-target='#carouselExampleIndicators'
                  data-slide-to='2'
                  ></li>
            </ol>
            <div class='carousel-inner'>
              <div class='carousel-item active'>
                <img class='img-size' src="<?php echo site_url().'/images/home_carousel/header_1.jpg'?>" alt='First slide' />
              </div>
              <div class='carousel-item'>
                <img class='img-size' src="<?php echo site_url().'/images/Type_C/Type_C_2.jpg'?>" alt='Second slide' />
              </div>
              <div class='carousel-item'>
                <img class='img-size' src="<?php echo site_url().'/images/Type_C/Type_C_2.jpg'?>" alt='Second slide' />
              </div>
            </div>
            <a
               class='carousel-control-prev'
               href='#carouselExampleIndicators'
               role='button'
               data-slide='prev'
               >
              <span class='carousel-control-prev-icon'
                    aria-hidden='true'
                    ></span>
              <span class='sr-only'>Previous</span>
            </a>
            <a
               class='carousel-control-next'
               href='#carouselExampleIndicators'
               role='button'
               data-slide='next'
               >
              <span
                    class='carousel-control-next-icon'
                    aria-hidden='true'
                    ></span>
              <span class='sr-only'>Next</span>
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  
  
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<footer class="text-muted py-5">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#">Back to top</a>
    </p>
    <p class="mb-1">Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
    <p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="../getting-started/introduction/">getting started guide</a>.</p>
  </div>
</footer>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>


    <script src="<?php echo site_url().'assets/dist/js/bootstrap.bundle.min.js';?>"></script>
	<script>
	$(function(){	
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
//var img = document.getElementByClass("myImg");
var img = $('.myImg');
$(".myImg").on('click', function(e){
	  var self = $(this);
	  var name = self.data('name'); // or src = self.attr('src');
	  var modalImg = document.getElementById("img01");
	  var captionText = document.getElementById("caption");
	  modal.style.display = "block";
	  modalImg.src = this.src;
	  captionText.innerHTML = this.alt;
	});



// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
	});
</script>
      
  </body>
</html>
