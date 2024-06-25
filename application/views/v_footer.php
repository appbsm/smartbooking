
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

 <!-- Footer -->
	<!--<footer class="mt-3" style="background-color:#839287">-->
	<footer class="mt-3 bg-light" >
		<div class="footer-top">
			<div class="container">
				<div class="row " >
					<div class="col-md-6 col-lg-6 footer-about wow fadeInUp mt-3">
						<div class="d-flex pt-2">
							<a class="btn btn-square me-1" href="" ><i class="fab fa-twitter"></i></a>
							<a class="btn btn-square me-1" href="" ><i class="fab fa-facebook-f"></i></a>
							<a class="btn btn-square me-1" href="" ><i class="fab fa-youtube"></i></a>
							<a class="btn btn-square me-0" href="" ><i class="fab fa-linkedin-in"></i></a>                  
						</div>
						<div class="d-flex pt-2">
							<p class=" mt-3" ><?php echo $lang == 'english' ? 'BuilderSmart (Public) Company Limited <br/>1055 Rama 3 Road.Chongnonsi, Yannawa, Bangkok 10120 <br/><br/> SM Resort @ Khaoyai <br/> 499 Moo 4 Pong Ta Long, Pak Chong, Nakhon Ratchasima 30130': 'บริษัท บิวเดอสมาร์ท จำกัด (มหาชน) <br/>1055 ถนนพระราม 3 แขวงช่องนนทรี เขตยานนาวา กทม 10120 <br/><br/> เอส เอ็ม รีสอร์ท เขาใหญ่<br/> 499 หมู่ 4 ตำบล โป่งตาลอง อำเภอปากช่อง นครราชสีมา 30130';?></p>                 
						</div>
					</div>
					<div class="col-md-6 col-lg-6 text-right mt-3">							
						<p ><?php echo $lang == 'english' ? 'If your interest room rent could you please contact admin via Line or Mobile <span class="footer-phone">065-989-8845</span>' : 'หากท่านสนใจห้องพักกรุณาติดต่อพนักงานผ่าน Line หรือ โทร <span class="footer-phone">065-989-8845</span>'; ?></p>
						<img class="logo-footer" src="<?php echo site_url();?>/images/line.jpg" alt="qr-code" data-at2x="<?php echo site_url();?>/images/line.jpg" width="100" height="100">
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bottom mt-2">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12 text-center footer-copyright" style="color: white;">
						<p>Copyright &copy; <a href="#"></a>, 2023.</p>
					</div>	           			
				</div>
			</div>
		</div>
	</footer>


</body>
</html>