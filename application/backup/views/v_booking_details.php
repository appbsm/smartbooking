<?php 
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI =& get_instance();
$CI->load->model('m_room_type');

?>

<style>

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


.page_content {
	padding: 20px;
}

</style>

<main class="main-2">
<div class="row">
  		<div class="col-md-12">
  			<ul class="breadcrumb">
			  <li><a href="<?php echo site_url();?>"><?php echo $this->lang->line('home');?></a></li>
			  <li><?php echo $this->lang->line('booking');?></li>
			</ul>
  		</div>
  	</div>
<!-- 
<div class="container_progress_bar">
      <ul class="progressbar">
        <li class="active">Guest Info</li>
        <li class="active">Billing</li>
        <li class="">Payment</li>
        <li class="">Confirmation</li>
      </ul>
    </div>
 -->


  <div class="container-fluid" >
  	<div class="row">
  		<div class="col-md-12 price room_type_header" style="text-align: center;"><?php echo $this->lang->line('booking_details');?></div>
  	</div>
  	<div class="row"> 
  		<div class="col-md-12">
  			
  		<page size="A4">
			
			<div class="page_content">
				<div class="row">
					<!--  
					<div class="col-md-6 d-flex flex-row">
						<img src="<?php echo site_url();?>images/SMS_Logo_Final.png"  style="max-width: 100px;">
						<span style="display: block; margin-top: auto; padding-bottom: 10px; font-size: 1.3em; font-weight: bold;">SMS Showroom at Khao Yai</span>
					</div>
					-->
					<div class="col-md-6">
						<div class="booking_number" style="margin-top: 40px; font-size: 1.3em; text-align: left; font-style: italic; font-weight: bold; padding: 2px 0 2px 10px;"><span><?php echo $this->lang->line('booking_number');?>: <?php echo $booking_number;?></span></div>
					</div>
					
					<div class="col-md-6">
						<div class="status" style="margin-top: 40px; font-size: 1.3em; text-align: right; font-style: italic; font-weight: bold; color: green; padding: 2px 0 2px 0;"><span style="color: <?php echo ($booking->status == 'Expired') ? 'red' : (($booking->status == 'Closed') ? 'blue' : 'green');?>;"><?php echo $this->lang->line('status');?>: <?php echo $booking->status;?></span></div>
					</div>
				</div>
				
				<div class="row mt-3">
					<div class="col-md-6">
						<!-- <div class="price" style="color: white; padding: 1px 0 1px 5px;">Invoice No.: </div> -->
						
						<div class="row" style="padding: 1px 15px 1px 15px; font-size: 1.1em;">
							<div class="col-md-6" style="font-weight: bold;"><?php echo $this->lang->line('grand_total');?></div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->grand_total, 2);?></div>
						</div>											
						
						<div class="row mb-2" style="padding: 1px 15px 1px 15px; font-size: 1.1em;">						
							<div class="col-md-6" style="font-weight: bold;"><?php echo $this->lang->line('discount');?></div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->discounted_amount, 2);?></div>
						</div>
						
						<div class="row mb-2" style="padding: 1px 15px 1px 15px; font-size: 1.1em;">						
							<div class="col-md-6" style="font-weight: bold;"><?php echo $this->lang->line('vat');?> (7%)</div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->vat, 2);?></div>
						</div>
						
						<div class="row mb-2" style="padding: 1px 15px 1px 15px; font-size: 1.1em;">						
							<div class="col-md-6" style="font-weight: bold;"><?php echo $this->lang->line('subtotal');?></div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->sub_total, 2);?></div>
						</div>
						
						
					</div>
					
					<div class="col-md-6">
						<div class="row" style="margin-left: 15px;">
							<div class="col-md-6"><?php echo $this->lang->line('customer_name');?>: </div>
							<div class="col-md-6" style="text-align: right;"><?php echo $guest->firstname;?> <?php echo $guest->lastname;?></div>
							<div class="col-md-6"><?php echo $this->lang->line('contact_number');?>: </div>
							<div class="col-md-6" style="text-align: right;"><?php echo $guest->contact_number;?></div>	
							
							<div class="col-md-6"><?php echo $this->lang->line('check_in_date');?>: </div>
							<div class="col-md-6" style="text-align: right;"><?php echo date('M d, Y', strtotime($booking->check_in_date));?></div>
							<div class="col-md-6"><?php echo $this->lang->line('check_out_date');?>: </div>
							<div class="col-md-6" style="text-align: right;"><?php echo date('M d, Y', strtotime($booking->check_out_date));?></div>					
							<div class="col-md-6"><?php echo $this->lang->line('number_of_nights');?>: </div>
							<div class="col-md-6" style="text-align: right;"><?php echo $date_diff;?></div>
						</div>
					</div>
				</div>
				
				<div class="row mt-3">
					
					<div class="col-md-6">
						<div class="row mt-3" style="padding: 0 15px 0 5px;">
													
						</div>
					</div>
				</div>
				
				<div class="row mt-3" style="margin: 1px 0 1px 15px;">
					<div class="col-md-12 price" style="color: white; font-weight: bold; font-size: 1.2em; padding: 3px 15px 3px 15px;"><?php echo $this->lang->line('booking_items');?>:</div>
					<div class="col-md-12">
						<div class = "table-responsive">
					         <table class = "table table-bordered">
					            <thead>
					               <tr>
					                  <th><?php echo $this->lang->line('number');?></th>
					                  <th><?php echo $this->lang->line('description');?></th>
					                  <th><?php echo $this->lang->line('unit_price');?></th>
					                  <th><?php echo $this->lang->line('quantity');?></th>
					                  <th><?php echo $this->lang->line('total');?></th>
					               </tr>
					            </thead>
					         <tbody>
					         	<?php 
					         	$ctr = 1;
					         	foreach ($items as $item) {
					         	?>
					         	<tr >
					               <td><?php echo $ctr++;?></td>
					               <td><?php echo $item->item_name;?></td>
					               <td><?php echo number_format($item->unit_cost);?></td>
					               <td><?php echo (($item->is_multiplied_by_night == 1)) ? $item->quantity.'x'.$date_diff.' Nights': $item->quantity;?></td>
					               <td><?php echo ($item->is_multiplied_by_night == 1) ? number_format($item->unit_cost*$item->quantity*$date_diff) : number_format($item->unit_cost*$item->quantity);?></td>
					            </tr>
					         	<?php }?>
					            
					         </tbody>
					      </table>
      					</div>
					</div>
					
					<div class="col-md-12 price" >
					<div style="color: white; font-weight: bold; font-size: 1.2em; padding: 1px 0 0 0;"></div>
					
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

</main>





<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>


