<?php $lang = $this->input->get('lang');
$CI =& get_instance();
$CI->load->model('m_room_type');

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

</style>

<main class="main-2">

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
  		<div class="col-md-12 price room_type_header" style="text-align: center;">Booking Details</div>
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
						<div class="booking_number" style="margin-top: 40px; font-size: 1.3em; text-align: left; font-style: italic; font-weight: bold; padding: 2px 0 2px 10px;"><span>Booking Number: <?php echo $booking_number;?></span></div>
					</div>
					
					<div class="col-md-6">
						<div class="status" style="margin-top: 40px; font-size: 1.3em; text-align: right; font-style: italic; font-weight: bold; color: green; padding: 2px 0 2px 0;"><span>Status: <?php echo $booking->status;?></span></div>
					</div>
				</div>
				
				<div class="row mt-3">
					<!--  
					<div class="col-md-6">
						<div class="row" style="margin-left: 15px;">
							
							<div class="col-md-6">Company Name: </div>
							<div class="col-md-6">Buildersmart</div>
							<div class="col-md-6">Contact Number: </div>
							<div class="col-md-6">065-989-8845</div>
							<div class="col-md-6">Bank: </div>
							<div class="col-md-6">Kasikorn Bank</div>
							<div class="col-md-6">Account Name: </div>
							<div class="col-md-6">BuilderSmart (Public) Co., Ltd.</div>
							<div class="col-md-6">Account Number: </div>
							<div class="col-md-6">145-1-69629-3</div>
						</div>
						
					</div>
					-->
					<div class="col-md-6">
						<!-- <div class="price" style="color: white; padding: 1px 0 1px 5px;">Invoice No.: </div> -->
						
						<div class="row" style="padding: 1px 15px 1px 15px; font-size: 1.1em;">
							<div class="col-md-6" style="font-weight: bold;">Grand Total</div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->grand_total, 2);?></div>
						</div>											
						
						<div class="row mb-2" style="padding: 1px 15px 1px 15px; font-size: 1.1em;">						
							<div class="col-md-6" style="font-weight: bold;">Discount</div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->discounted_amount, 2);?></div>
						</div>
						
						<div class="row mb-2" style="padding: 1px 15px 1px 15px; font-size: 1.1em;">						
							<div class="col-md-6" style="font-weight: bold;">VAT (7%)</div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->vat, 2);?></div>
						</div>
						
						<div class="row mb-2" style="padding: 1px 15px 1px 15px; font-size: 1.1em;">						
							<div class="col-md-6" style="font-weight: bold;">Subtotal</div>
							<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->sub_total, 2);?></div>
						</div>
						
						
					</div>
					
					<div class="col-md-6">
						<div class="row" style="margin-left: 15px;">
							<div class="col-md-6">Customer Name: </div>
							<div class="col-md-6" style="text-align: right;"><?php echo $guest->firstname;?> <?php echo $guest->lastname;?></div>
							<div class="col-md-6">Contact Number: </div>
							<div class="col-md-6" style="text-align: right;"><?php echo $guest->contact_number;?></div>	
							
							<div class="col-md-6">Check-in Date: </div>
							<div class="col-md-6" style="text-align: right;"><?php echo date('M d, Y', strtotime($booking->check_in_date));?></div>
							<div class="col-md-6">Check-out Date: </div>
							<div class="col-md-6" style="text-align: right;"><?php echo date('M d, Y', strtotime($booking->check_out_date));?></div>					
							<div class="col-md-6">Number of Nights: </div>
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
					<div class="col-md-12 price" style="color: white; font-weight: bold; font-size: 1.2em; padding: 3px 15px 3px 15px;">Booking Items:</div>
					<div class="col-md-12">
						<div class = "table-responsive">
					         <table class = "table table-bordered">
					            <thead>
					               <tr>
					                  <th>No.</th>
					                  <th>Description</th>
					                  <th>Unit Cost</th>
					                  <th>Quantity</th>
					                  <th>Total</th>
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
<script>
const numFor = Intl.NumberFormat('en-US');

const progressBar = document.getElementById("progress-bar");
const progressNext = document.getElementById("progress-next");
const progressPrev = document.getElementById("progress-prev");
const steps = document.querySelectorAll(".step");
let active = 1;

/*
progressNext.addEventListener("click", () => {
	  active++;
	  if (active > steps.length) {
	    active = steps.length;
	  }
	  updateProgress();
	});

	progressPrev.addEventListener("click", () => {
	  active--;
	  if (active < 1) {
	    active = 1;
	  }
	  updateProgress();
	});

	const updateProgress = () => {
		  // toggle active class on list items
		  steps.forEach((step, i) => {
		    if (i < active) {
		      step.classList.add("active");
		    } else {
		      step.classList.remove("active");
		    }
		  });
		  // set progress bar width  
		  progressBar.style.width = 
		    ((active - 1) / (steps.length - 1)) * 100 + "%";
		  // enable disable prev and next buttons
		  if (active === 1) {
		    progressPrev.disabled = true;
		  } else if (active === steps.length) {
		    progressNext.disabled = true;
		  } else {
		    progressPrev.disabled = false;
		    progressNext.disabled = false;
		  }
		};
*/

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
		$('.datepicker').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		  // change : updateDate
		  }).val();

		//console.log(type_a);
		$('.myImg').click(function(){
			var id = $(this).attr('data-id');
			$('.carousel-item').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.slide').each(function(i, obj) {
			    $(this).removeClass('active');
			});
			$('.'+id).addClass('active');
			$('#ModalCarousel').modal('show');
		});

		$('.select_age').click(function(){
		});

		$('.dropdown-menu').on('click', function(event){
		    // The event won't be propagated up to the document NODE and 
		    // therefore delegated events won't be fired
		    event.stopPropagation();
		});
	});
</script>
	
</body>
</html>

