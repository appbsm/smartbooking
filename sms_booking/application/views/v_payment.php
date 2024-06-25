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

</style>

<main class="main-2">

<div class="container_progress_bar">
      <ul class="progressbar">
        <li class="active">Guest Info</li>
        <li class="active">Billing</li>
        <li class="active">Payment</li>
        <li class="">Confirmation</li>
      </ul>
    </div>


  <form name="frm_payment" id="frm_payment" method="post" action="<?php echo site_url('booking/save_payment')?>" enctype="multipart/form-data">
  <div class="container-fluid" >
  	<div class="row">
  		<div class="col-md-12 price room_type_header">Step 3 Payment</div>
  	</div>
  	<div class="row"> 
  		<div class="col-md-12">
  		<div class="row mt-3">	
  			<div class="col-md-6">
	  			<div class="form-outline">
	                <label class="form-label" for="booking_number">Booking Number</label>
	            	<input type="text" id="booking_number" name="booking_number" class="form-control" value="<?php echo $booking_number;?>" readonly/>					                    
	            </div>
            </div>
            
            <div class="col-md-6">
	  			<div class="form-outline">
	                <label class="form-label" for="booking_date">Booking Date</label>
	            	<input type="text" id="booking_date" name="booking_date" class="form-control" value="<?php echo date('d-m-Y', strtotime($booking->booking_date));?>" readonly/>					                    
	            </div>
            </div>            
            
            <div class="col-md-6">
	  			<div class="form-outline">
	                <label class="form-label" for="transfer_date">Transfer Date</label>
	                <input type='text' class="form-control datepicker" name="transfer_date" id="transfer_date" value=""/>				                    
	            </div>
            </div>
            
            <div class="col-md-6">
	  			<div class="form-outline">
	                <label class="form-label" for="transfer_time">Transfer Time</label>		
	            	<input type="text" class="form-control time-pickable" id="transfer_time" name="transfer_time" readonly value="<?php echo date('h:i a');?>">
	            </div>
            </div>
            
            <div class="col-md-6">
	  			<div class="form-outline">
	                <label class="form-label" for="amount">Amount</label>
	            	<input type="text" id="amount" name="amount" class="form-control" value="<?php echo number_format($booking->grand_total,2);?>"/>					                    
	            </div>
            </div>
            
            <div class="col-md-6">
	  			<div class="form-outline">
	                <label class="form-label" for="transfer_slip">Attach Transfer Slip</label>
	            	<input type="file" id="transfer_slip" name="transfer_slip" class="form-control" />					                    
	            </div>
            </div>
  		</div>
  		
		
		<div class="row mt-3">	
					<div class="col-md-6 mb-2 text-right" > 
						<button class="btn button-primary " id="back">Back</button>
					</div>
					<div class="col-md-6 mb-2 text-left"> 
						<button class="btn button-primary " id="payment">Submit Payment</button>
					</div>
					</div>
  		</div>
    </div>
  </div>
  </form>

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
		function activate() {
			document.head.insertAdjacentHTML("beforeend", `
				<style>
					.time-picker {
						position: absolute;
						display: inline-block;
						padding: 10px;
						background: #eeeeee;
						border-radius: 6px;
					}

					.time-picker__select {
						-webkit-appearance: none;
						-moz-appearance: none;
						appearance: none;
						outline: none;
						text-align: center;
						border: 1px solid #dddddd;
						border-radius: 6px;
						padding: 6px 10px;
						background: #ffffff;
						cursor: pointer;
						font-family: 'Heebo', sans-serif;
					}
				</style>
			`);

			document.querySelectorAll(".time-pickable").forEach(timePickable => {
				let activePicker = null;

				timePickable.addEventListener("focus", () => {
					if (activePicker) return;

					activePicker = show(timePickable);

					const onClickAway = ({ target }) => {
						if (
							target === activePicker
							|| target === timePickable
							|| activePicker.contains(target)
						) {
							return;
						}

						document.removeEventListener("mousedown", onClickAway);
						document.body.removeChild(activePicker);
						activePicker = null;
					};

					document.addEventListener("mousedown", onClickAway);
				});
			});
		}

		function show(timePickable) {
			const picker = buildPicker(timePickable);
			const { bottom: top, left } = timePickable.getBoundingClientRect();

			picker.style.top = `${top}px`;
			picker.style.left = `${left}px`;

			document.body.appendChild(picker);

			return picker;
		}

		function buildPicker(timePickable) {
			const picker = document.createElement("div");
			const hourOptions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].map(numberToOption);
			//const minuteOptions = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55].map(numberToOption);
			var min = [];
			for (var x=0;x<60;x++) {
				min.push(x);
			}
			const minuteOptions = min.map(numberToOption);
			picker.classList.add("time-picker");
			picker.innerHTML = `
				<select class="time-picker__select">
					${hourOptions.join("")}
				</select>
				:
				<select class="time-picker__select">
					${minuteOptions.join("")}
				</select>
				<select class="time-picker__select">
					<option value="am">am</option>
					<option value="pm">pm</option>
				</select>
			`;

			const selects = getSelectsFromPicker(picker);

			selects.hour.addEventListener("change", () => timePickable.value = getTimeStringFromPicker(picker));
			selects.minute.addEventListener("change", () => timePickable.value = getTimeStringFromPicker(picker));
			selects.meridiem.addEventListener("change", () => timePickable.value = getTimeStringFromPicker(picker));

			if (timePickable.value) {
				const { hour, minute, meridiem } = getTimePartsFromPickable(timePickable);

				selects.hour.value = hour;
				selects.minute.value = minute;
				selects.meridiem.value = meridiem;
			}

			return picker;
		}

		function getTimePartsFromPickable(timePickable) {
			const pattern = /^(\d+):(\d+) (am|pm)$/;
			const [hour, minute, meridiem] = Array.from(timePickable.value.match(pattern)).splice(1);

			return {
				hour,
				minute,
				meridiem
			};
		}

		function getSelectsFromPicker(timePicker) {
			const [hour, minute, meridiem] = timePicker.querySelectorAll(".time-picker__select");

			return {
				hour,
				minute,
				meridiem
			};
		}

		function getTimeStringFromPicker(timePicker) {
			const selects = getSelectsFromPicker(timePicker);

			return `${selects.hour.value}:${selects.minute.value} ${selects.meridiem.value}`;
		}

		function numberToOption(number) {
			const padded = number.toString().padStart(2, "0");

			return `<option value="${padded}">${padded}</option>`;
		}

		activate();
		
		
	});
</script>
	
</body>
</html>

