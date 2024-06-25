<?php 
$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
if($lg=='thai'){
    $this->lang->load('content','thai');
}
elseif($lg=='english'){
    $this->lang->load('content','english');
}
$lang  = $lg;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SM Resort @ Khaoyai gallery</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--<link rel="stylesheet" href="<?php echo site_url();?>bootstrap-4.0.0-dist/css/bootstrap.css">-->
    <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?v=1001">-->
	
    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
	<?php 
	$CI =& get_instance();
	$lang = $CI->session->userdata('site_lang');
	if ($lang == 'english') {
	?>	
	<link href="<?php echo site_url();?>css/gallery_css_en.css" rel="stylesheet">
	<?php 
	}
	else {
	?>
	<link href="<?php echo site_url();?>css/gallery_css_th.css" rel="stylesheet">
	
	<?php } ?>

<style>
.photoImg {
  cursor: pointer;
  transition: 0.3s;
}

.photoImg:hover {opacity: 0.7;}

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
  border-radius: 0px!important;
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
.modal {
	padding-top:0;
}

#swipe {
    position: absolute;
    left: -100px;
    width: 100px;
    height: 100px;
    background: blue;
    transition: 0.1s;
}
</style>

</head>

<div class="row" style="margin: 10px 5px 1px 5px;">
	<div class="col-md-12 " >
	<a href="<?php echo site_url('gallery'); ?>" class="btn btn-sms btn-sm" style="float: left;"><<</a>
	<?php
	$switch_en = 'English';
	$switch_th = 'Thai';
	?>
	<span style="float: right; text-align: right;">
	<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/thai'; ?>" title="<?php echo $switch_th; ?>" style="<?php echo ($lang == 'thai') ? 'font-weight: bold!important;' : ''; ?>">TH</a>
	<span>&nbsp;|&nbsp;</span>
	<a href="<?php echo site_url() . 'LanguageSwitcher/switchLang/english'; ?>" title="<?php echo $switch_en; ?>" style="<?php echo ($lang == 'english') ? 'font-weight: bold!important;' : ''; ?>">EN</a>
	</span>
	</div>
</div>


<main class="main d-flex justify-content-center mb-1" >
	<div class="container">
        
		<div class="row ">
			<div class="col-md-12 mb-3" style="text-align: right;">
				<img src="<?php echo site_url(); ?>images/SMLogo.png" width="80px" style="float: right;">
			</div>
			
			<div class="col-md-12 d-flex flex-column justify-content-center">
				
				<div class="row ">		
					<!--
					<div class="col-sm-12 d-flex justify-content-center mb-2">
						
						<h5><?php echo _r($gallery_photos[0]['gallery_name_en'], $gallery_photos[0]['gallery_name_th']); ?></h5>
					</div>	
					-->
					<?php foreach ($gallery_photos as $ctr1 => $g) {
					if ($g['photo_url']	!= '') {
					?>
					<div class="col-md-6 mb-3">				
						<img class="photoImg" data-ctr="<?php echo $ctr1;?>" src="<?php echo share_folder_path().$g['photo_url'];?>" width="100%" data-bs-target="#albumCarousel" data-bs-toggle="modal">

					</div>
						
					<?php 
					}
					else {
					?>
					<div class="col-md-12  d-flex flex-column justify-content-center mb-3" style="text-align: center;">				
						<?php echo _r('No photos in this album.', 'ไม่พบรูปภาพในอัลบั้ม'); ?>
					</div>
					<?php
					}	
					}
					?>	
					</div>
					
				</div>
			</div>	
		</div>
	</div>
</main>



<div class="modal albumCarousel " id="albumCarousel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
					<div id="carouselExampleIndicators" class="carousel slide " data-bs-touch="true" data-bs-interval="false">
					  
					  <div class="carousel-inner">
						<?php foreach ($gallery_photos as $ctr1 => $g) { ?>
						<div class="carousel-item <?php echo ($ctr1 == 0) ? 'active' : '';?>">
						  <!--<svg class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: slide <?php echo $ctr1;?>" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"></rect><text x="50%" y="50%" fill="#555" dy=".3em">Slide <?php echo $ctr1;?></text></svg>-->
						  <img class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" src="<?php echo share_folder_path().$g['photo_url'];?>" >

						</div>
						<?php } ?>
						
					  </div>
					  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					  </button>
					  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					  </button>
					</div>
		</div>
	</div>
</div>

	
    <!-- Bootstrap core JavaScript-->
    
	<script src="<?php echo site_url();?>js/jquery.min.js"></script>
	
	<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
	<!--<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>-->
	
	<!--
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>-->
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
    
 
<script>
$(function(){
	$('.photoImg').click(function(){
		let x = new bootstrap.Carousel('#carouselExampleIndicators');
		$('#albumCarousel').modal('show');
	});
  
});  

</script> 

<script>
        let slideIndex = 1;
        displaySlide(slideIndex);
 
        function moveSlides(n) {
            displaySlide(slideIndex += n);
			swipeHandler();
        }
 
        function activeSlide(n) {
            displaySlide(slideIndex = n);
			swipeHandler();
        }
 
        /* Main function */
        function displaySlide(n) {
            let i;
            let totalslides =
                document.getElementsByClassName("slide");
 
            
 
            if (n > totalslides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = totalslides.length;
            }
            for (i = 0; i < totalslides.length; i++) {
                totalslides[i].style.display = "none";
            }
            /*for (i = 0; i < totaldots.length; i++) {
                totaldots[i].className =
                    totaldots[i].className.replace(" active", "");
            }*/
            totalslides[slideIndex - 1].style.display = "block";
            //totaldots[slideIndex - 1].className += " active";
        }
		
		
		
		$(function(){
		  // Bind the swipeHandler callback function to the swipe event on div.box
		  /*$(".slide").on("tap", function () {
		 alert("Tap event detected!");
		 });

		 $(".slide").on("taphold", function () {
		 alert("Tap hold event detected!");
		 });

		 $(".slide").on("swipe", function () {
		 alert("Swipe event detected!");
		 });
		*/

		 $(".slide").on("swipeleft", function () {
		 //alert("Swipe left event detected!");
		 
		 moveSlides(1)
		 
		 });

		 $(".slide").on("swiperight", function () {
		 //alert("Swipe right event detected!");
		  moveSlides(-1)
		 });
		  
		  //$( ".slide" ).on( "swipe", swipeHandler );
		 
		  // Callback function references the event target and adds the 'swipe' class to it
		  function swipeHandler( event ){
			//$( event.target ).addClass( "swipe" );
			alert(event)
		  }
		});
    </script>
</body>

</html>