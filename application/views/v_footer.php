
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
<style>
	.footer-social {
		color: rgb(215, 215, 219) !important;
	}
</style>
 <!-- Footer -->
	<!--<footer class="mt-3" style="background-color:#839287">-->
<!--	
	<footer class="mt-3 bg-light" >
		<div class="footer-top">
			<div class="container">
				<div class="row " id="contactus">
					<div class="col-md-6 col-lg-6 footer-about wow fadeInUp mt-3">
						<div class="d-flex pt-2">
							<img src="<?= site_url() ?>/images/10.png" style="width: 70px;" class="" alt="logo-smartbooking" id="contactus"/>
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
		<div class="bottom-footer">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="d-flex pt-2" style="justify-content: center;">
							<a class="btn btn-square me-1" href="" ><i class="fab fa-twitter"></i></a>
							<a class="btn btn-square me-1" href="" ><i class="fab fa-facebook-f"></i></a>
							<a class="btn btn-square me-1" href="" ><i class="fab fa-youtube"></i></a>
							<a class="btn btn-square me-0" href="" ><i class="fab fa-linkedin-in"></i></a>                  
						</div>
						<p class="text-center text-dark">© 2021-24 smsmartbooking  | All Rights Reserved. Design by <a href="https://www.installdirect.asia/"><b>InstallDirect</b></a></p>
					</div>
				</div>
			</div>
		</div>
	</footer>
-->
<!--2-->
<footer class="mt-3 bg-light" style="background-color: rgb(42, 42, 46) !important; color: rgba(255, 255, 255, 1.00);">
		<div class="footer-top">
			<div class="container">
				<div class="row " id="contactus">
					<div class="col-md-6 col-lg-6 footer-about wow fadeInUp mt-3">
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
		<div class="bottom-footer">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="d-flex pt-2" style="justify-content: center;">
							<a class="btn btn-square me-1 footer-social" href="" ><i class="fab fa-twitter"></i></a>
							<a class="btn btn-square me-1 footer-social" href="" ><i class="fab fa-facebook-f"></i></a>
							<a class="btn btn-square me-1 footer-social" href="" ><i class="fab fa-youtube"></i></a>
							<a class="btn btn-square me-0 footer-social" href="" ><i class="fab fa-linkedin-in"></i></a>                  
						</div>
						<p class="text-center text-light">© 2021-24 smsmartbooking  | All Rights Reserved. Design by <a class="text-light" href="https://www.installdirect.asia/"><b>InstallDirect</b></a></p>
					</div>
				</div>
			</div>
		</div>
	</footer>
<!--2-->
</body>
</html>