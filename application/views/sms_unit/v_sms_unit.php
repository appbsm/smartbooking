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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>bootstrap-4.0.0-dist/css/bootstrap.css">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?v=1001">

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
	<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap" rel="stylesheet">
	<link href="<?php echo site_url();?>css/gallery_css_th.css" rel="stylesheet">
	
	<?php } ?>

	
</head>

<div class="row" style="margin: 10px 5px 1px 5px;">
<div class="col-md-12 " >
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
			<div class="col-md-12 d-flex justify-content-center mb-2">
				<img src="<?php echo site_url(); ?>images/SMLogo.png" width="120px">
			</div>
			<div class="col-md-12 d-flex justify-content-center mb-3" style="<?php echo ($lang == 'thai') ? "font-family: 'promptregular';" : ''; ?> font-size: 1.5em; text-align:center;">
				SM Unit				
			</div>	
			
			<div class="col-md-12 justify-content-center" style="text-align: center;">
			<?php 
			$thai_desc = 'เอส เอ็ม รีสอร์ท ตั้งอยู่ท่ามกลางธรรมชาติเขาใหญ่ โอบล้อมด้วยแนวเขาวิว 360 องศา ด้วยรูปแบบอาคารที่ทันสมัยมี Rooftop ซึ่งสามารถชมทิวทัศน์ที่เปลี่ยนแปลงไปตามเวลาทุกๆ ช่วงของวัน ช่วยเพิ่มบรรยากาศของการพักผ่อนได้อย่างมีสไตล์ ยังมีกิจกรรมหลากหลาย และจุดเซลฟี่มากมายในรีสอร์ท';
			$eng_desc = "SM Resort graces the heart of Khao Yai's natural landscape. Encircled by majestic mountain ranges, it offers sweeping 360-degree vistas. The contemporary architectural design features a rooftop, providing an ideal vantage to witness the evolving scenery throughout the day, elevating the ambience of stylish relaxation. Abound with activities and captivating selfie spots, the resort ensures an enriching experience.";
			?>
			<h5 class="gallery_category"><?php echo _r($eng_desc, $thai_desc);?></h5>
			<hr>
			</div>
			<div class="col-md-12 d-flex justify-content-center">
				<div class="row">
					<?php foreach ($sms_unit as $g) {?>
					<div class="col-6 col-md-3">
						<div class="cover_box">
						<a class=" mt-1 " href="<?php echo site_url('sms_units/photo_album').'/'.$g['id_sms_unit']; ?>">
						
						<img src="<?php echo share_folder_path().$g['unit_thumbnail'];?>" width="100%">
						<span class="d-flex justify-content-center cover_title" ><?php echo _r($g['unit_name_en'], $g['unit_name_th']);?></span>
						</a>
						</div>
					</div>
						
					<?php }?>	
					</div>
					
				</div>
			</div>	
		</div>
	</div>
</main>


    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo site_url();?>js/jquery.min.js"></script>
	<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
	<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    

</body>

</html>