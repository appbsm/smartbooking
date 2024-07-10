
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
<!--<footer class="mt-3 bg-light" style="background-color: rgb(42, 42, 46) !important; color: rgba(255, 255, 255, 1.00);">-->
<footer class="mt-3 bg-light" style="background-color: #102958 !important; color: rgba(255, 255, 255, 1.00);">
		<div class="footer-top">
			<div class="container">
				<div class="row " id="contactus">
					<div class="col-md-6 col-lg-6 footer-about wow fadeInUp mt-3">
						<div class="d-flex pt-2">
							<!--<p class=" mt-3" ><?php echo $lang == 'english' ? 'BuilderSmart (Public) Company Limited <br/>1055 Rama 3 Road.Chongnonsi, Yannawa, Bangkok 10120 <br/><br/> SM Resort @ Khaoyai <br/> 499 Moo 4 Pong Ta Long, Pak Chong, Nakhon Ratchasima 30130': 'บริษัท บิวเดอสมาร์ท จำกัด (มหาชน) <br/>1055 ถนนพระราม 3 แขวงช่องนนทรี เขตยานนาวา กทม 10120 <br/><br/> เอส เอ็ม รีสอร์ท เขาใหญ่<br/> 499 หมู่ 4 ตำบล โป่งตาลอง อำเภอปากช่อง นครราชสีมา 30130';?></p>-->
						</div>
					</div>
					<div class="col-md-6 col-lg-6 text-right mt-3">							
						<p ><?php echo $lang == 'english' ? 'If your interest room rent could you please contact admin via Line or Mobile <span class="footer-phone">065-989-8845</span>' : 'หากท่านสนใจห้องพักกรุณาติดต่อพนักงานผ่าน Line หรือ โทร <span class="footer-phone">065-989-8845</span>'; ?></p>
						<!--<img class="logo-footer" src="<?php echo site_url();?>/images/line.jpg" alt="qr-code" data-at2x="<?php echo site_url();?>/images/line.jpg" width="100" height="100">-->
					</div>
				</div>
			</div>
		</div>
		<div>
        <div class="row">
          <div class="footer-top-area">
            <div class="row d-flex flex-wrap justify-content-between">

              <div class="col-lg-3 col-sm-6 pb-3 text-center pl-3">

                
                <div class="footer_set_left footer_set_left2">

                <div class="footer-menu">
                  <img src="http://192.168.20.22/smartbooking_front_test/images/logo_small.png" width="140" alt="logo">
          <br><br>
                  <p class="text-light" style="font-size:18px;font-family: yourFontName,'PSLxText';">IoT Specialist<br>"Connecting your world, <br>
                    Simplifying your life."
                  </p>

<p>
<a href="https://www.facebook.com/profile.php?id=61551989652981">
            <svg width="16" height="16" fill="#F9FAFA" class="bi bi-facebook" viewBox="0 0 16 16">
  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"></path>
  <use xlink:href="#facebook"></use>
</svg>
</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<a href="#">
                         <svg width="16" height="16" fill="#F9FAFA" class="bi bi-line" viewBox="0 0 16 16">
                <path d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0M5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.15.15 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157m.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832l-.013-.015v-.001l-.01-.01-.003-.003-.011-.009h-.001L7.88 4.79l-.003-.002-.005-.003-.008-.005h-.002l-.003-.002-.01-.004-.004-.002-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.2.2 0 0 0 .039.038l.001.001.01.006.004.002.008.004.007.003.005.002.01.003h.003a.2.2 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.16.16 0 0 0-.108.044h-.001l-.001.002-.002.003a.16.16 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.16.16 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z"></path>
              </svg>
</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <a href="mailto:customercare@buildersmart.com">
                           <svg width="16" height="16" fill="#F9FAFA" class="bi bi-envelope" viewBox="0 0 16 16">
  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"></path>
                          </svg>
                        </a>
                    </p>
                </div>
                </div>

              </div>

      <div class="col-lg-3 col-sm-6 pb-3">
              <!-- footer-title -->
        <h5 class="text-center" style="font-size:17px;">WEBSITE MENU</h5>
        <br>
              
                <div class="footer-menu d-flex justify-content-center">
           
              
                  <ul class="menu-list list-unstyled ">
          
                    <li class="menu-item pb-2">
          <svg width="23" height="23" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
          </svg>
                      <a href="../../en.php#about" class="text-light">&nbsp;&nbsp;&nbsp;About us</a>
                    </li>
					
					<li class="menu-item pb-2">
          <svg width="23" height="23" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
          </svg>
                      <a href="../en.php#iot-services" class="text-light">&nbsp;&nbsp;&nbsp;Rooms type</a>
                    </li>
          
                    <li class="menu-item pb-2">
          <svg width="23" height="23" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
          </svg>
                      <a href="../en.php#iot-services" class="text-light">&nbsp;&nbsp;&nbsp;Package & Promotions</a>
                    </li>
                   

                    <li class="menu-item pb-2">
          <svg width="23" height="23" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
          </svg>
                      <a href="../en.php#service" class="text-light">&nbsp;&nbsp;&nbsp;Facilities & Amenities</a>
                    </li>
					
					<li class="menu-item pb-2">
          <svg width="23" height="23" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
          </svg>
                      <a href="../en.php#service" class="text-light">&nbsp;&nbsp;&nbsp;Conditions & Policies</a>
                    </li>
					
          <li class="menu-item pb-2">
          <svg width="23" height="23" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"></path>
          </svg>
                      <a href="../en/contact.php" class="text-light">&nbsp;&nbsp;&nbsp;Contact us</a>
                    </li>
                  </ul>
                </div>
              </div>
        
            <div class="col-lg-4 col-sm-6 pb-3 d-flex justify-content-center">
                <div class="footer_set_right footer_set_left2">

                <div class="footer-menu ">
                  <h5 class="text-center" style="font-size:17px;">CONTACT US</h5>
                  <br>
                  <!-- <h5 class="widget-title pb-2"  ><u>CONTACT US</u></h5> -->
          
         
                <svg width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"></path>
                </svg>
                <i class="las"></i><strong></strong>&nbsp;&nbsp;InstallDirect Co., Ltd. <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;905/7 Rama 3 Road Bangpongpang
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yannawa, Bangkok, Thailand 10120
              <br>
              <svg width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"></path>
              </svg>

              <i class="las "></i><strong>&nbsp;&nbsp;TEL :</strong><a class="text-light" href="tel:026834900">&nbsp;&nbsp;02-683-4900 ext. 223</a>
              
              <br>
              <i class="fa fa-fax"></i>
              <i style="font-size:17px;"></i><strong>&nbsp;&nbsp;&nbsp;FAX :</strong>&nbsp;&nbsp;02-683-4949
              <br>

              <svg width="16" height="16" fill="currentColor" class="bi bi-line" viewBox="0 0 16 16">
  <path d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0M5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.15.15 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157m.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832l-.013-.015v-.001l-.01-.01-.003-.003-.011-.009h-.001L7.88 4.79l-.003-.002-.005-.003-.008-.005h-.002l-.003-.002-.01-.004-.004-.002-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.2.2 0 0 0 .039.038l.001.001.01.006.004.002.008.004.007.003.005.002.01.003h.003a.2.2 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.16.16 0 0 0-.108.044h-.001l-.001.002-.002.003a.16.16 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.16.16 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z"></path>
</svg>
              
              &nbsp;&nbsp;LINE ID :</strong>&nbsp;&nbsp;<strong>@installdirect</strong>
              
              <br>
              
              <svg width="16" height="16" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
  <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"></path>
</svg>
              &nbsp;&nbsp;Tiktok :</strong>&nbsp;&nbsp;installdirect
                </div>


              </div>
            </div>


              <div class="col-lg-2 col-sm-6 pb-3 p-0">
                <!-- <div style="float: right !important;"> -->
                <div class="footer_set_right footer_set_right2">
                <h5 class="text-center" style="font-size:17px;">ADD LINE</h5>
                <br>
                <div class="footer-menu contact-item d-flex justify-content-center">
                  
                  <!-- <h5 class="widget-title  pb-2"><u>QR CODE LINE</u></h5> -->
                <img class="footer_image" src="http://192.168.20.22/smartbooking_front_test/images/qrcode_s.png" width="60%">
                </div>
                </div>
              </div>


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
						<p class="text-center text-light">© 2021-24 smartbooking  | All Rights Reserved. Design by <a class="text-light" href="https://www.installdirect.asia/"><b>InstallDirect</b></a></p>
					</div>
				</div>
			</div>
		</div>
	</footer>
	
<!--2-->
</body>
</html>