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
</style>

<?php 
$id_project_info = 1;
?>

<main class="main-2">

  <section class="text-center container">
    
  </section>
  <div class="container-fluid" >
  	<div class="row mb-3">
  		<div class="col-md-12 price room_type_header" style="text-align: center;">Booking History</div>
  	</div>
  	
	<div class="row">
		<div class="col-md-12">

		<div class = "table-responsive">
         <table class = "table">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Booking #</th>
                  <th>Check-in Date</th>
                  <th>Checkout Date</th>
                  <th>Amount</th>
                  <th>Status</th>
               </tr>
            </thead>
         	<tbody>
         	<?php 
         	$ctr = 1;
         	foreach($booking_history as $booking) {
         	$_url = '';
         	if ($booking->status == 'Booked') {
         		$_url = site_url('booking/booking_details').'?booking_number='.$booking->booking_number;
         	}
         	?>
         	<tr >
         		<td><?php echo $ctr++;?></td>
               <td><a href="<?php echo $_url;?>"><?php echo $booking->booking_number;?></a></td>               
               <td><?php echo date('d-m-Y', strtotime($booking->check_in_date));?></td>
               <td><?php echo date('d-m-Y', strtotime($booking->check_out_date));?></td>
               <td><?php echo number_format($booking->grand_total, 2);?></td>
               <td><?php echo $booking->status;?></td>
            </tr>
         	<?php }?>
					            
			</tbody>
		</table>
      	</div>
		
		</div>
		
	</div>
	
	<div class="col-md-12 price mb-4" >
	<div style="color: white; font-weight: bold; font-size: 1.2em; padding: 1px 0 0 0;"></div>
	
	</div>
  </div>


<form name="frm_book" id="frm_book" method="post" action="<?php echo site_url('booking').'/guest_info';?>"> 

</form>

</main>





<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script>
const numFor = Intl.NumberFormat('en-US');


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
	//console.log(newval);
	if (btn_id == 'increment-children') {
		$('.div_kids_age').html('');
		var new_html = '';
		if (newval > 0) {
			for (var x=0; x < newval; x++) {
				max_age = 12;
				var option_ct = 1;
				new_html += '<div class="col-md-3" style="padding: 1px;">'
						+ '<select class="form-control select_age" name="select_age[]">'
						+ '<option value="0">0</option>';
				do {
					new_html += '<option value="'+option_ct+'">'+option_ct+'</option>';
					option_ct++;
				} while(option_ct <= max_age);		
				new_html += '</select></div>';
			}
				
		}
		//console.log(new_html);
		$('.div_kids_age').html(new_html);
	}

	if (btn_id == 'increment-room' || btn_id == 'decrement-room') {		
		$('#h_room').val(newval);

		var rate = $('#h_rate').val();
		var total = newval * rate;
		//console.log(newval + ' ' + rate);
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
		    minDate: new Date(), // = today
		    onSelect: function(dateText, inst) {
				
		        var in_date = $(this).val();
				check_in_date = in_date.split("-");

		        var d = new Date(check_in_date[2], check_in_date[1], check_in_date[0]);
		        let today = new Date(d);
		        var tomorrow = new Date();
		        tomorrow.setDate(today.getDate() + 1);
				var tomorow_date = tomorrow.getDate()+'-'+(tomorrow.getMonth() + 1)+"-"+tomorrow.getFullYear();		        
				$("#check_out_date").val(tomorow_date);
		    }
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

		$('#book_now').click(function() {
			$('#h_num_of_adult').val($('#div_adult').text());
			$('#h_num_of_room').val($('#div_room').text());
			$('#h_num_of_children').val($('#div_children').text());
			var children_ages = [];
			var ages = document.getElementsByClassName("select_age");
			for (var i = 0; i < ages.length; i++) {
				//console.log(ages[i].value);
				children_ages.push(ages[i].value);
			}
			$('#h_children_ages').val(children_ages.toString());
			$('#h_check_in_date').val($('#check_in_date').val());
			$('#h_check_out_date').val($('#check_out_date').val());
			$('#frm_book').submit();
		});

		$('.delete-item').click(function() {
			var r = confirm("Are you sre you want to delete this item?");
			if (r) {
				var id = $(this).attr('data-id');
				var _url = "<?php echo site_url('cart/delete_to_cart');?>";
				
		        $.ajax({
		               method: "POST",
		               url: _url,
		               data: {
		                   'id_cart_item': id              
		               }
		       })
		       .done(function( res ) {
		 			//var obj = eval('('+res+')');
		 			//console.log(res);
		 		    alert('Delete Successful')
		 		    location.reload();
		       });
			}
		});

		
	});
</script>
	
</body>
</html>

