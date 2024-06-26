<!DOCTYPE html>
<html>
 
<head>
    <title>
        JS Slider
    </title>
 
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <style>
 @import url(https://fonts.googleapis.com/css?family=Josefin+Slab:100);

.animate {
  transition: transform 0.3s ease-out;
}

html,
body {
  height: 100%;
}

body {
  margin: 0;
  padding: 0;
  overflow: hidden;
}

.slider-wrap {
  width: 300px;
  height: 500px;
  position: absolute;
  left: 50%;
  margin-left: -150px;
  top: 50%;
  margin-top: -225px;
}

.slider {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.ms-touch.slider {
  overflow-x: scroll;
  overflow-y: hidden;
  
  -ms-overflow-style: none;
  /* Hides the scrollbar. */
  
  -ms-scroll-chaining: none;
  /* Prevents Metro from swiping to the next tab or app. */
  
  -ms-scroll-snap-type: mandatory;
  /* Forces a snap scroll behavior on your images. */
  
  -ms-scroll-snap-points-x: snapInterval(0%, 100%);
  /* Defines the y and x intervals to snap to when scrolling. */
}

.holder {
  width: 300%;
  max-height: 500px;
  height: 100%;
  overflow-y: hidden;
}

.slide-wrapper {
  width: 33.333%;
  height: 100%;
  float: left;
  height: 500px;
  position: relative;
  overflow: hidden;
}

.slide {
  height: 100%;
  position: relative;
}

.temp {
  position: absolute;
  z-index: 1;
  color: white;
  font-size: 100px;
  bottom: 15px;
  left: 15px;
  font-family: 'Josefin Slab', serif;
  font-weight: 100;
}

.slide img {
  position: absolute;
  z-index: 0;
  transform: translatex(-100px);
}

.slide:before {
  content: "";
  position: absolute;
  z-index: 1;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 40%;
  background: linear-gradient(transparent, black);
}

.slide div {
  width: 300px;
  height: 500px;
  z-index: 0;
}
 </style>
</head>    

<body>
<div class="slider-wrap">
  <div class="slider" id="slider">
    <div class="holder">
	<?php foreach ($gallery_photos as $ctr1 => $g) { ?>	
      <div class="slide-wrapper">
        <div class="slide"><img class="slide-image" src="<?php echo share_folder_path().$g['photo_url'];?>" /></div>
      </div>	  
	<?php } ?>
      
    </div>
  </div>
</div>

<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script>
if (navigator.msMaxTouchPoints) {

  $('#slider').addClass('ms-touch');

  $('#slider').on('swipe', function(e) {
	  alert(e)
    $('.slide-image').css('transform','translate3d(-' + (100-$(this).scrollLeft()/6) + 'px,0,0)');
  });

} else {

  var slider = {

    el: {
      slider: $("#slider"),
      holder: $(".holder"),
      imgSlide: $(".slide-image")
    },

    slideWidth: $('#slider').width(),
    touchstartx: undefined,
    touchmovex: undefined,
    movex: undefined,
    index: 0,
    longTouch: undefined,
    
    init: function() {
      this.bindUIEvents();
    },

    bindUIEvents: function() {

      this.el.holder.on("touchstart", function(event) {
        slider.start(event);
      });

      this.el.holder.on("touchmove", function(event) {
        slider.move(event);
      });

      this.el.holder.on("touchend", function(event) {
        slider.end(event);
      });

    },

    start: function(event) {
      // Test for flick.
      this.longTouch = false;
      setTimeout(function() {
        window.slider.longTouch = true;
      }, 250);

      // Get the original touch position.
      this.touchstartx =  event.originalEvent.touches[0].pageX;

      // The movement gets all janky if there's a transition on the elements.
      $('.animate').removeClass('animate');
    },

    move: function(event) {
      // Continuously return touch position.
      this.touchmovex =  event.originalEvent.touches[0].pageX;
      // Calculate distance to translate holder.
      this.movex = this.index*this.slideWidth + (this.touchstartx - this.touchmovex);
      // Defines the speed the images should move at.
      var panx = 100-this.movex/6;
      if (this.movex < 600) { // Makes the holder stop moving when there is no more content.
        this.el.holder.css('transform','translate3d(-' + this.movex + 'px,0,0)');
      }
      if (panx < 100) { // Corrects an edge-case problem where the background image moves without the container moving.
        this.el.imgSlide.css('transform','translate3d(-' + panx + 'px,0,0)');
      }
    },

    end: function(event) {
      // Calculate the distance swiped.
      var absMove = Math.abs(this.index*this.slideWidth - this.movex);
      // Calculate the index. All other calculations are based on the index.
      if (absMove > this.slideWidth/2 || this.longTouch === false) {
        if (this.movex > this.index*this.slideWidth && this.index < 2) {
          this.index++;
        } else if (this.movex < this.index*this.slideWidth && this.index > 0) {
          this.index--;
        }
      }      
      // Move and animate the elements.
      this.el.holder.addClass('animate').css('transform', 'translate3d(-' + this.index*this.slideWidth + 'px,0,0)');
      this.el.imgSlide.addClass('animate').css('transform', 'translate3d(-' + 100-this.index*50 + 'px,0,0)');

    }

  };

  slider.init();
}
</script>

</body>
</html>