<?php 
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI =& get_instance();
$CI->load->model('m_room_type');
 
?>

<style>
body {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}

.navbrand {

}

label {
	font-weight: 100!important;
}

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






page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
page[size="A4"] {  
  width: 21cm;
  height: 29.7cm; 
}
page[size="A4"][layout="portrait"] {
  width: 29.7cm;
  height: 21cm;  
}
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
}

.page_content {
	padding: 20px;
}

.box {
  border: 1px solid #7F8C8D; 
  border-radius: 10px;
}

.balance_amount_1 {
	/*background-color: red;*/
	color: red;
}

table, tr, th, td {
	text-align: center;
}

.center_text {
	text-align: center;
}

.button__badge {
	margin-right: 0px;
	font-size: 0.8em !important;
	position: absolute;
	top: -8px !important;
	right: -4px !important;
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<main class="main-2">
	<div class="container">


	<div class="container_progress_bar">
      <ul class="progressbar">
        <li class="active"><?php echo $this->lang->line('guest_info');?></li>
        <li class="active"><?php echo $this->lang->line('billing');?></li>
        <li class="active"><?php echo $this->lang->line('payment');?></li>
        <li class=""><?php echo $this->lang->line('confirmation');?></li>
      </ul>
    </div>


  <form name="frm_payment" id="frm_payment" method="post" action="<?php echo site_url('booking/save_payment')?>" enctype="multipart/form-data" >
  <input type="hidden" name="id_booking" id="id_booking" value="<?php echo $booking->id_booking;?>">
  <div class="container-fluid" >
  	<div class="row">
  		<div class="col-md-12 price room_type_header m-0">
			<h4><span><?php echo $this->lang->line('step_3');?></span></h4>
		</div>
  	</div>
  	<?php 
  	$total_payment = (isset($booking_payment->total_payment)) ? $booking_payment->total_payment : 0;
  	$balance = $booking->grand_total - $total_payment;
  	?>
  	<div class="row"> 
  		<div class="col-md-6"></div>
  		<div class="col-md-6">
  			<div class="row" style="margin-left: 15px; font-weight: bold; text-align: right; margin-right: 10px;">
				<div class="col-md-8 col-xs-9"><?php echo $this->lang->line('total');?> : </div>
				<div class="col-md-4 col-xs-3" style="text-align: right;"><?php echo number_format($booking->grand_total, 2);?></div>
				<div class="col-md-8 col-xs-9"><?php echo $this->lang->line('total_payment');?> : </div>
				<div class="col-md-4 col-xs-3" style="text-align: right;"><?php echo number_format($total_payment, 2); ?></div>
				<div class="col-md-8 col-xs-9 <?php echo ($balance > 0) ? 'balance_amount' : '';?>"><?php echo $this->lang->line('balance_amount');?>: </div>
				<div class="col-md-4 col-xs-3 <?php echo ($balance > 0) ? 'balance_amount' : '';?>" style="text-align: right;"><?php echo number_format($balance, 2);?></div>
			</div>
  		</div>
  	
  		<div class="col-md-6">
  		<div class="row mt-3">	
  			<div class="col-md-12">
	  			<div class="form-outline">
	                <label class="form-label" for="booking_number"><span class="required">*</span><?php echo $this->lang->line('booking_number');?></label>
	            	<input type="text" id="booking_number" name="booking_number" class="form-control" value="<?php echo $booking_number;?>" readonly required/>					                    
	            </div>
            </div>
            
            <div class="col-md-12">
	  			<div class="form-outline">
	                <label class="form-label" for="booking_date"><span class="required">*</span><?php echo $this->lang->line('booking_date');?></label>
	            	<input type="text" id="booking_date" name="booking_date" class="form-control" value="<?php echo date('d-m-Y', strtotime($booking->booking_date));?>" readonly required/>					                    
	            </div>
            </div>            
            
            <div class="col-md-12">
	  			<div class="form-outline">
	                <label class="form-label" for="transfer_date"><span class="required">*</span><?php echo $this->lang->line('transfer_date');?></label>
	                <input type='text' class="form-control datepicker" name="transfer_date" id="transfer_date" value="" required />				                    
	            </div>
            </div>
            
            <div class="col-md-12">
	  			<div class="form-outline">
	                <label class="form-label" for="transfer_time"><span class="required">*</span><?php echo $this->lang->line('transfer_time');?></label>		
	            	<div class='input-group date' id='transfer_time'>
			          <input type='text' class="form-control" name="transfer_time" value="<?php echo date('H:i');?>" required />
			          <span class="input-group-addon">
			            <span class="glyphicon glyphicon-time"></span>
			          </span>
			        </div>
	            	
	            	<!-- <input type="text" class="form-control time-pickable" id="transfer_time" name="transfer_time" readonly value="<?php echo date('H:i');?>"> -->
	            </div>
            </div>
            
            <div class="col-md-12">
	  			<div class="form-outline">
	                <label class="form-label" for="amount"><span class="required">*</span><?php echo $this->lang->line('amount');?></label>
	            	<input type="text" id="amount" name="amount" class="form-control" value="<?php echo number_format($booking->balance_amount,2);?>" required />					                    
	            </div>
            </div>
            
            <div class="col-md-12">
	  			<div class="form-outline">
	                <label class="form-label" for="transfer_slip"><span class="required">*</span><?php echo $this->lang->line('attach_transfer_slip');?></label>
	            	<input type="file" id="transfer_slip" name="transfer_slip" class="form-control" required />					                    
	            </div>
            </div>
  		</div>
  		
		
		<div class="row mt-3">	
					<!-- 
					<div class="col-md-6 mb-2 text-right" > 
						<button class="btn button-primary " id="back">Back</button>
					</div> -->
					<div class="col-md-12 mb-2 text-center"> 
						<button class="btn button-primary " id="payment"><?php echo $this->lang->line('submit_to_payment');?></button>
					</div>
					</div>
  		</div>
  		
  		<div class="col-md-6">
  			<div class="row mt-4" style="border: 1px solid #7F8C8D; border-radius: 10px; ">	
  				<div class="col-md-12 price" style="font-weight: bold; text-align: center; width: 100%; margin: 10px 0 0 0!important">
				 <?php echo $this->lang->line('payment_history');?>
				</div>
				
	  			<div class="col-md-12">
	  				
		  			<table class="table w-100" style="padding: 5px; ;">
		            		<tr>
		            			<th class="center_text"><?php echo $this->lang->line('number');?></th>
			  					<th class="center_text"><?php echo $this->lang->line('transfer_date');?></th>
			  					<th class="center_text"><?php echo $this->lang->line('transfer_time');?></th>
			  					<th class="center_text"><?php echo $this->lang->line('amount');?></th>
			  					<th class="center_text"><?php echo $this->lang->line('attach_transfer_slip');?></th>
			  				</tr>
  							<?php 
  							$ctr = 1;
  							foreach ($payment_history as $pay) {
  							
  								?>
		            		<tr>
			  					<td><?php echo $ctr;?></td>
			  					<td><?php echo $pay->transfer_date;?></td>
			  					<td><?php echo $pay->transfer_time;?></td>
			  					<td><?php echo number_format($pay->transferred_amount, 2);?></td>
			  					<td><img class="pay_img" width="50" src="<?php echo share_folder_path().$pay->transfer_slip;?>"></td>
			  				</tr>
			  				<?php 
  							$ctr++;
  							}?>
		            	</table>
	            </div>
	       </div>
  		</div>
  		
  		
    </div>
  </div>
  </form>
  </div>
</main>


<!-- Modal -->
<div class="modal " id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">
      
      <div class="modal-body" style="text-align: center; margin: auto;">
       <img class="modal-content" id="img01" style="width:100%;">
      </div>
      
    </div>
  </div>
</div>




<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>


<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>


$('.datepicker').datepicker({ 
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    minDate: new Date(), // = today    
  }).val();

var today = new Date();
var today_date = ('0' + today.getDate()).slice(-2) + '-'
        + ('0' + (today.getMonth()+1)).slice(-2) + '-'
        + today.getFullYear();      
$("#transfer_date").val(today_date);

$('#payment').click(function() {
	$('#frm_payment').submit();
});

$('#frm_payment').submit(function(e) {
	if ($('#transfer_slip').val() == '') {
		//alert("Please attach slip");
		e.preventDefault();
	}
	/*else if (parseFloat($('#amount').val()) == 0) {
		$('#amount').focus();
		e.preventDefault();
	}*/
	else {		
		$(this).submit();
	}
})

function stepper(dis) {
	let btn_id = dis.getAttribute('id');
	let max = dis.getAttribute('max');

	
	const myArray = btn_id.split("-");
	var myInput = myArray[1];
	let min = $('#'+myInput).val();
	
	var newval = ( myArray[0] == 'increment' ) ? (parseInt(min)+1) : (parseInt(min)-1);
	newval = (newval < 0) ? 0 : newval;
	$('#'+myInput).val(newval);
	$('#div_'+myInput).html(newval);
	console.log(newval);
	if (btn_id == 'increment-children') {
		$('.div_kids_age').html('');
		var new_html = '';
		if (newval > 0) {
			for (var x=0; x < newval; x++) {
				max_age = 12;
				var option_ct = 1;
				new_html += '<div class="col-md-3" style="padding: 1px;">'
						+ '<select class="form-control select_age">'
						+ '<option value="0">0</option>';
				do {
					new_html += '<option value="'+option_ct+'">'+option_ct+'</option>';
					option_ct++;
				} while(option_ct <= max_age);		
				new_html += '</select></div>';
			}
				
		}
		console.log(new_html);
		$('.div_kids_age').html(new_html);
	}

	if (btn_id == 'increment-room' || btn_id == 'decrement-room') {		
		$('#h_room').val(newval);

		var rate = $('#h_rate').val();
		var total = newval * rate;
		console.log(newval + ' ' + rate);
		$('#number_of_rooms').text(newval);
		
		$('.total_rate').text(numFor.format(total));
		$('.grand_total').text(numFor.format(total));
		//$('#total_rate').val(total);
	}
}


	$(function(){		
		$('#transfer_time').datetimepicker({
            format: 'HH:mm'
  		});
	});

	$(".pay_img").on('click', function(e){
		var mymodal = document.getElementById("myModal");
		
		var self = $(this);
		var name = self.data('name'); // or src = self.attr('src');
		var src = self.attr('src');
		//console.log(mymodal);
		var modalImg = document.getElementById("img01");
		var captionText = document.getElementById("caption");
		modalImg.style.display = "block";
		
		modalImg.src = src;
		// captionText.innerHTML = this.alt;
		$('#myModal').modal('show');
	});

	//$('#myModal').modal('show');
</script>

