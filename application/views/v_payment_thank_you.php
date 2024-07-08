<?php 
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI =& get_instance();
$CI->load->model('m_room_type');
setlocale(LC_ALL, 'th_TH');
?>

<style>
.nav-link.active {
	background-color: #81BB4A!important;
}

.room_type_header {
	font-size: 1.4em;
	font-weight: bold;
	color: #eee;
}

hr {
	border: 0;
	border-top: 1px solid #CCC;
}

.hr3 {
  border: 0;
  height: 2px;
  background-image: linear-gradient(to right, transparent, #CCC, transparent);  
}

.section_header {
	font-weight: bold; 
	font-size: 1.1em;
}



.container_progress_bar {
  padding-top: 3em;
  width: 100%;
}

.progressbar {
  counter-reset: step;
}
.progressbar li {
  list-style: none;
  display: inline-block;
  width: 24%;
  position: relative;
  text-align: center;
  cursor: pointer;
}
.progressbar li:before {
  content: counter(step);
  counter-increment: step;
  width: 30px;
  height: 30px;
  line-height : 30px;
  border: 1px solid #ddd;
  border-radius: 100%;
  display: block;
  text-align: center;
  margin: 0 auto 10px auto;
  background-color: #fff;
}
.progressbar li:after {
  content: "";
  position: absolute;
  width: 100%;
  height: 1px;
  background-color: #ddd;
  
  top: 15px;
  left: -50%;
  z-index : -1;
}
.progressbar li:first-child:after {
  content: none;
}
.progressbar li.active {
  color: green;
}

/* this is for the circle*/
.progressbar li.active:before { 
  border-color: green;
  background-color: green;
  color: #fff;
} 
.progressbar li.active + li:after {
  background-color: green;
}


page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  /*box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);*/
}
/*
page[size="A4"] {  
  width: 21cm;
  height: 29.7cm; 
}
page[size="A4"][layout="portrait"] {
  width: 29.7cm;
  height: 21cm;  
}
*/
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
}

.page_content {
	padding: 20px;
}

.button__badge {
	margin-right: 0px;
	font-size: 0.8em !important;
	position: absolute;
	top: -8px !important;
	right: -4px !important;
}

.button__badge {
	margin-right: 0px;
	font-size: 0.6em !important;
	position: absolute;
	top: -8px !important;
	right: -4px !important;
}
.price {
    /*background-color: #2a2a2e;*/
	background-color: #5392f9;
    color: white;
    text-shadow: 2px 2px 4px #000000;
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<main class="main-2 ">
<div class="container " >


  <div class="container-fluid " >
	<!--
  	<div class="row">
  		<div class="col-md-12 price room_type_header m-0" style="text-align: center; margin-top: 40px !important;">
			<h4>
				<span><?php echo $this->lang->line('thank_you');?>!</span>
			</h4>
		</div>
  	</div>
	-->
  	<div class="row"> 
  		
  			
  		<page size="A4">
			
			<div class="page_content">
				<div class="row" style="margin-top: 30px;">
					<div class="col-md-12 message" style="margin: 20px; text-align: center; font-size: 1.1em; line-height: 20px;">
			  			<p style="font-size: 1.1em; font-weight: 700; color: #000;"><?php echo $this->lang->line('thank_you_payment');?></p>
			  			
			  			<p><?php echo $this->lang->line('message_receive_email');?></p>
			  			<p><?php echo $this->lang->line('message_go_to_link');?>: <a style="font-weight: 700; color: #000 !important;" href="<?php echo site_url('booking/booking_details').'?booking_number='.$booking->booking_number;?>"><?php echo $this->lang->line('click_here');?></a></p>
			  		</div>
				</div>
				
				<hr />
				
				<div class="row mt-3">
					<div class="col-md-6">
						<div class="row">
					
							<div class="col-md-12">
								<div class="booking_number" style="font-size: 1.3em; text-align: left; font-weight: 700; padding: 2px 0 2px 10px; line-height: 20px;">
									<span><?php echo $this->lang->line('booking_number');?>: <?php echo $booking_number;?></span>
								</div>
							</div>
							
							<div class="col-md-12">
								<div class="status" style=" font-size: 1.3em; font-weight: bold; color: green; padding: 2px 0 2px 10px;"><span><?php echo $this->lang->line('status');?>: <?php echo $booking->status;?></span></div>
							</div>
						</div>
					</div>
					<div class="col-md-6" style="line-height: 20px;">
						<!-- <div class="price" style="color: white; padding: 1px 0 1px 5px;">Invoice No.: </div> -->
						
						<div class="row" style="padding: 1px 15px 1px 15px; font-size: 1em;">
							<div class="col-md-6" style="font-weight: bold;"><?php echo $this->lang->line('grand_total');?></div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->grand_total, 2);?></div>
						</div>											
						
						<div class="row mb-2" style="padding: 1px 15px 1px 15px; font-size: 1em;">						
							<div class="col-md-6" style="font-weight: bold;"><?php echo $this->lang->line('discount');?></div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->discounted_amount, 2);?></div>
						</div>
						
						<div class="row mb-2" style="padding: 1px 15px 1px 15px; font-size: 1em;">						
							<div class="col-md-6" style="font-weight: bold;"><?php echo $this->lang->line('vat');?> (7%)</div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->vat, 2);?></div>
						</div>
						
						<div class="row mb-2" style="padding: 1px 15px 1px 15px; font-size: 1em;">						
							<div class="col-md-6" style="font-weight: bold;"><?php echo $this->lang->line('subtotal');?></div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->sub_total, 2);?></div>
						</div>
						
						
					</div>
					
					
				</div>
	
			</div> <!-- page content -->
			
		</page>
		<!-- <page size="A4" layout="portrait">A4 portrait</page> -->
		
		<!-- 
		<div class="row mt-3">	
					
					<div class="col-md-6 mb-2 text-right" > 
						<a href="<?php echo site_url('booking/billing').'?number='.$booking_number;?>" class="btn button-primary" id="">Back</a>
					</div>
					
					<div class="col-md-12 mb-5 text-center" style=""> 
						<a href="<?php echo site_url('booking/payment').'?number='.$booking_number;?>" class="btn button-primary" id="">Proceed to Payment</a>
					</div>
					</div>
  		</div>
  		 -->
    </div>
  </div>
  </div>
</main>





<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script>



</script>
	
