<!DOCTYPE html>
<html>
 
<head>
    <title>
        Blueimp Slider
    </title>
 
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="<?php echo site_url();?>blueimp-gallery/css/blueimp-gallery.min.css" />
</head>    

<body>

<!-- The Gallery as lightbox dialog, should be a document body child element -->
<div
  id="blueimp-gallery"
  class="blueimp-gallery"
  aria-label="image gallery"
  aria-modal="true"
  role="dialog"
>
  <div class="slides" aria-live="polite"></div>
  <h3 class="title"></h3>
  <a
    class="prev"
    aria-controls="blueimp-gallery"
    aria-label="previous slide"
    aria-keyshortcuts="ArrowLeft"
  ></a>
  <a
    class="next"
    aria-controls="blueimp-gallery"
    aria-label="next slide"
    aria-keyshortcuts="ArrowRight"
  ></a>
  <a
    class="close"
    aria-controls="blueimp-gallery"
    aria-label="close"
    aria-keyshortcuts="Escape"
  ></a>
  <a
    class="play-pause"
    aria-controls="blueimp-gallery"
    aria-label="play slideshow"
    aria-keyshortcuts="Space"
    aria-pressed="false"
    role="button"
  ></a>
  <ol class="indicator"></ol>
</div>


<div id="links">
<?php foreach ($gallery_photos as $ctr1 => $g) { ?>	
	<a href="<?php echo share_folder_path().$g['photo_url'];?>" title="">
		<img src="<?php echo share_folder_path().$g['photo_url'];?>" alt="" />
	</a>
<?php } ?>
</div>

<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>

<script src="<?php echo site_url();?>blueimp-gallery/js/blueimp-gallery.min.js"></script>
<script>
  document.getElementById('links').onclick = function (event) {
    event = event || window.event
    var target = event.target || event.srcElement
    var link = target.src ? target.parentNode : target
    var options = { index: link, event: event }
    var links = this.getElementsByTagName('a')
    blueimp.Gallery(links, options)
  }
</script>

</body>
</html>