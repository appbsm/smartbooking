<?php $lang = $this->input->get('lang');
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
  		<div class="col-md-12 price room_type_header" style="text-align: center;">Thank You!</div>
  	</div>
  	<div class="row"> 
  		
  			
  		<page size="A4">
			
			<div class="page_content">
				<div class="row">
					<div class="col-md-12 message" style="margin: 20px; text-align: center; font-size: 1.1em;">
			  			<p>Thank you for your payment.</p>
			  			
			  			<p>You will receive an email regarding your payment details. Your booking confirmation in under way. Our customer service will contact you shortly.</p>
			  			<p>Please go to this link to see the progress of you booking: <a style="font-weight: bold;" href="<?php echo site_url('booking/booking_details').'?booking_number='.$booking->booking_number;?>">Click Here</a></p>
			  		</div>
				</div>
				
				<div class="col-md-12 price" >
					<div style="color: white; font-weight: bold; font-size: 1.2em; padding: 1px 0 0 0;"></div>					
				</div>
				
				<div class="row mt-3">
					<div class="col-md-6">
						<div class="row">
					
							<div class="col-md-12">
								<div class="booking_number" style="font-size: 1.3em; text-align: left; font-weight: bold; padding: 2px 0 2px 10px;"><span>Booking Number: <?php echo $booking_number;?></span></div>
							</div>
							
							<div class="col-md-12">
								<div class="status" style=" font-size: 1.3em; font-weight: bold; color: green; padding: 2px 0 2px 10px;"><span>Status: <?php echo $booking->status;?></span></div>
							</div>
						</div>
					</div>
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

