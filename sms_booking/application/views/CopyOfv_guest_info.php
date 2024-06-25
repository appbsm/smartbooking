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

#progress {
  position: relative;
  margin-bottom: 30px;   
}

#progress-bar {
  position: absolute;
  background: #81BB4A;
  height: 5px;
  width: 0%;
  top: 50%;
  left: 0;
}

#progress-num {
  margin: 0;
  padding: 0;
  list-style: none;
  display: flex;
  justify-content: space-between;
}

#progress-num::before {
  content: "";
  background-color: lightgray;
  position: absolute;
  top: 50%;
  left: 0;
  height: 5px;
  width: 100%;
  z-index: -1;
}

#progress-num .step {
  border: 3px solid lightgray;
  border-radius: 100%;
  width: 25px;
  height: 25px;
  /*line-height: 25px;*/
  text-align: center;
  background-color: #fff;
  font-family: sans-serif;
  font-size: 14px;    
  position: relative;
  z-index: 1;
}

#progress-num .step.active {
  border-color: #81BB4A;
  background-color: #81BB4A;
  color: #fff;
}


.container {
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
.progressbar li.active:before {
  border-color: green;
} 
.progressbar li.active + li:after {
  background-color: green;
}

</style>

<?php 

?>

<main class="main-2">

<div class="container">
      <ul class="progressbar">
        <li class="active">Guest Info</li>
        <li class="active">Billing</li>
        <li class="active">Payment</li>
        <li class="active">Confirmation</li>
      </ul>
    </div>


  <section class="text-center container">
    <div id="progress">
	  <div id="progress-bar"></div>
	  <ul id="progress-num">
	    <li class="step active">1</li>
	    <li class="step">2</li>
	    <li class="step">3</li>
	    <li class="step">4</li>
	  </ul>
	</div>
	
	
	<button id="progress-prev" class="btn" disabled>Prev</button>
	<button id="progress-next" class="btn">Next</button>
  </section>
  <div class="container-fluid" >
  	<div class="row">
  		<div class="col-md-12 price room_type_header">ROOM AND GUEST INFO</div>
  	</div>
  	<div class="row"> 
    	
    	
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

