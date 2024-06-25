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

    <title>SM Unit</title>
	
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
	<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">
	
	<?php } ?>
	
	
</head>

<div class="row" style="margin: 10px 5px 1px 5px;">
	<div class="col-md-12 " >
	<a href="<?php echo site_url('sms_units'); ?>" class="btn btn-sms btn-sm" style="float: left;"><<</a>
	<?php
	$switch_en = 'English';
	$switch_th = 'Thai';
	?>
	<span style="float: right; text-align: right;">
	<a class="<?php echo ($lang == 'thai') ? 'lang_current' : 'lang';?>" href="<?php echo site_url() . 'LanguageSwitcher/switchLang/thai'; ?>" title="<?php echo $switch_th; ?>" >TH</a>
	<span>&nbsp;|&nbsp;</span>
	<a class="<?php echo ($lang == 'english') ? 'lang_current' : 'lang';?>" href="<?php echo site_url() . 'LanguageSwitcher/switchLang/english'; ?>" title="<?php echo $switch_en; ?>" >EN</a>
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
					<div class="col-sm-12 d-flex mb-2" style="text-align: center;">
						<h5 style="" class="gallery_category"><?php echo _r($sms_unit[0]['unit_description_en'], $sms_unit[0]['unit_description_th']); ?></h5>
					</div>	
					
					<div id="links">
					<div class="row ">
					<?php foreach ($sms_unit as $ctr1 => $g) {
					if ($g['unit_photo_url']	!= '') {
					?>
					<div class="col-md-6 mb-3">				
						<a href="<?php echo share_folder_path().$g['unit_photo_url'];?>" title="">
						<img data-ctr="<?php echo $ctr1;?>" src="<?php echo share_folder_path().$g['unit_photo_url'];?>" width="100%" alt="">
						</a>
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
	</div>
</main>

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

	<link rel="stylesheet" href="<?php echo site_url();?>blueimp-gallery/css/blueimp-gallery.min.css" />
	
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