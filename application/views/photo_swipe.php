<!DOCTYPE html>
<html>
 
<head>
    <title>
        How to Design Image
        Slider using jQuery ?
    </title>
 
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <link rel="stylesheet"
          href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <style>
        img {
            width: 100%;
        }
 
        .height {
            height: 10px;
        }
 
        /* Image-container design */
        .image-container {
            max-width: 800px;
            position: relative;
            margin: auto;
        }
 
        .next {
            right: 0;
        }
 
        /* Next and previous icon design */
        .previous,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            padding: 10px;
            margin-top: -25px;
        }
 
        /* caption decorate */
        .captionText {
            color: #000000;
            font-size: 14px;
            position: absolute;
            padding: 12px 12px;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }
 
        /* Slider image number */
        .slideNumber {
            background-color: #5574C5;
            color: white;
            border-radius: 25px;
            right: 0;
            opacity: .5;
            margin: 5px;
            width: 30px;
            height: 30px;
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            position: absolute;
        }
 
        .fa {
            font-size: 32px;
        }
 
        .fa:hover {
            transform: rotate(360deg);
            transition: 1s;
            color: white;
        }
 
        .footerdot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.5s ease;
        }
 
        .active,
        .footerdot:hover {
            background-color: black;
        }
    </style>
	
  <link rel="stylesheet" href="//code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.css">
  <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="//code.jquery.com/mobile/1.5.0-alpha.1/jquery.mobile-1.5.0-alpha.1.min.js"></script>
</head>
 
<body>
    <center>
        
        <b>
            How to code Image
            Slider using jQuery
        </b>
 
        <br><br>
    </center>
 
    <!-- Image container of the image slider -->
    <div class="image-container">
		<?php 
		//echo sizeof($gallery_photos);
		foreach ($gallery_photos as $ctr1 => $g) { ?>
        <div class="slide">
            <!--<div class="slideNumber"><?echo $ctr1;?></div>-->
            <img src="<?php echo share_folder_path().$g['photo_url'];?>">
        </div>
		<?php }?>
        
        
 
        <!-- Next and Previous icon to change images -->
        <a class="previous" onclick="moveSlides(-1)">
            <i class="fa fa-chevron-circle-left"></i>
        </a>
        <a class="next" onclick="moveSlides(1)">
            <i class="fa fa-chevron-circle-right"></i>
        </a>
    </div>
    <br>
 
    
 
    <script>
        let slideIndex = 1;
        displaySlide(slideIndex);
 
        function moveSlides(n) {
            var r = displaySlide(slideIndex += n);						
        }
 
        function activeSlide(n) {
            displaySlide(slideIndex = n);
        }
 
        /* Main function */
        function displaySlide(n) {
            let i;
            let totalslides =
                document.getElementsByClassName("slide");
			//console.log(totalslides);
            let totaldots =
                document.getElementsByClassName("footerdot");
 
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
			//totalslides[slideIndex - 1].addClass( "swipe" );
			
			//$( event.target ).addClass( "swipe" );
            //totaldots[slideIndex - 1].className += " active";
			return totalslides[slideIndex - 1];
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

		 $(".slide").on("swipeleft", function (e) {		 
			//var interval = 3000;
			//timer = setInterval(moveSlides(1), interval); 
			moveSlides(1);
		 });

		 $(".slide").on("swiperight", function (e) {		
			moveSlides(-1)
		 });
		  
		  //$( ".slide" ).on( "swipe", swipeHandler );
		 
		  // Callback function references the event target and adds the 'swipe' class to it
		  function swipeHandler( event ){
			$( event.target ).addClass( "swipe" );
			//alert(event)
		  }
		});
    </script>
	
	
</body>
 
</html>