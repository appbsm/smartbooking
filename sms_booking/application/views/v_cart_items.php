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

.cross_out {
	text-decoration: line-through;
}
</style>

<?php 
$id_project_info = 1;
?>

<main class="main-2">

  <section class="text-center container">
    
  </section>
  <div class="container-fluid" >
  	<div class="row">
  		<div class="col-md-12 price room_type_header">My Cart</div>
  	</div>
  	
	<div class="row">
		<div class="col-md-8">

		<div class = "table-responsive">
         <table class = "table">
            <thead>
               <tr>
                  <th><input type="checkbox" class="select_all cb" onClick="toggle(this);"></th>
                  <th>Item</th>
                  <th>Unit Cost</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Action</th>
               </tr>
            </thead>
         	<tbody>
         	<?php 
         	$ctr = 1;
         	foreach($cart_items as $item) {
			$room_type = $CI->m_room_type->get_room_type_by_ID($id_project_info, $item->id_room_type);	
			
			$first_photo = $CI->m_room_type->get_first_photo_room_type($item->id_room_type);
         	?>
         	<tr class="" id="tr_<?php echo $item->id_room_type;?>">
               <td>
               <input type="checkbox" class="chk_item cb" id="id_<?php echo $item->id_room_type?>" data-item="<?php echo $item->id_room_type?>" data-price="<?php echo $item->unit_price;?>">
               </td>
               <td>
               <img src="<?php echo site_url().$first_photo->room_photo_url;?>" style="max-width: 100px;"/>
	    		<span style="padding-left: 10px; font-weight: bold;"><?php echo $room_type->room_type_name_en;?></span>
               </td>
               <td><?php echo number_format($item->unit_price);?></td>
               <td><?php echo $item->quantity;?></td>
               <td><?php echo number_format($item->unit_price*$item->quantity);?></td>
               <td><button class="btn button-primary delete-item" data-id="<?php echo $item->id_cart_item;?>">Delete</button></td>
               
            </tr>
         	<?php }?>
					            
			</tbody>
		</table>
      	</div>
		
		</div>
		
		<div class="col-md-4 ">
			
			<div style="width: 100%; border: 1px solid #7F8C8D; border-radius: 10px; ">
				
				
				<div class="col-md-12" style="display: flex; flex-direction: row; padding: 10px;">
					<div class="group">
					    <label for="name">Check-in Date</label>
					    <input type='text' class=" datepicker" name="check_in_date" id="check_in_date" value=""/>
					</div>
					<div class="group">
					    <label for="name">Check-out Date</label>
					    <input type='text' class=" datepicker" name="chec_out_date" id="check_out_date" value=""/>
					</div>
				</div>
				
				
				<div class="col-md-12 mb-3">
					<div class="dropdown" >
						  <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <span id="div_adult">2</span> Adults, <span id="div_children">0</span> Kids <!-- , <span id="div_room">1</span> Rooms -->
						  </button>
						  <div class="dropdown-menu" style="vertical-align: bottom;" aria-labelledby="dropdownMenuButton">
							    <div class="stepper">
							    <div style="display: flex; justify-content: center;">Adult</div>
							    <div style="display: flex; justify-content: center; background-color: white; ">							    
							    <button class="btn_stepper " id="decrement-adult" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="2" id ="adult" readonly>
							    <button class="btn_stepper " id="increment-adult" onClick="stepper(this);"> + </button>
							    </div>
								<div class="rounded hr3 mt-2 mb-2"></div>
							    <div style="display: flex; justify-content: center;">Children</div>
							    <div style="display: flex; justify-content: center; background-color: ">							    
							    <button class="btn_stepper " id="decrement-children" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="0" id ="children" readonly>
							    <button class="btn_stepper " id="increment-children" onClick="stepper(this);"> + </button>
							    </div>
							    
							   <div class="kids_age">
							    <div class="col-md-12">
									<div class="row div_kids_age">
							    	
							    	</div>
							    </div>
							    </div> <!-- Kids Age -->
							   <div class="rounded hr3 mt-2"></div>
							    <!-- 
							    <div style="display: flex; justify-content: center;">Rooms</div>
							    <div style="display: flex; justify-content: center; background-color: white; box-shadow: 0 20px 30px rgba(0,0,0,0.1)">							    
							    <button class="btn_stepper " id="decrement-room" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="1" id ="room" readonly>
							    <button class="btn_stepper " id="increment-room" onClick="stepper(this);"> + </button>
							    </div>
							     -->
						    </div>
						  </div>
						</div>
					
				</div>
				
				
			</div>
			
			
		</div>
		
		
		<div class="col-md-12 text-center mt-3 mb-5 d-flex flex-row justify-content-center">
			<label style="font-size: 1.2em; font-weight: bold; margin: 8px 5px 5px 5px;">Total: </label><div id="total" style="font-size: 1.2em; font-weight: bold; padding: 8px 20px 5px 0;">0.00</div>
    		<div>
    		<button class="btn button-primary" id="proceed_to_booking">Proceed to Booking</button>
    		</div>
    	</div>
	</div>
	
	<div class="row">
		
	</div>
	
	
	
		
  </div>


<form name="frm_book" id="frm_book" method="post" action="<?php echo site_url('booking').'/guest_info';?>"> 
<input type="hidden" name="h_id_room" id="h_id_room" value="">
<input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="">
<input type="hidden" name="h_num_of_room" id="h_num_of_room" value="">
<input type="hidden" name="h_num_of_children" id="h_num_of_children" value="">
<input type="hidden" name="h_children_ages" id="h_children_ages" value="">
<input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
<input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">
</form>

</main>





<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script>
const numFor = Intl.NumberFormat('en-US');

function toggle(source) {
	  checkboxes = document.getElementsByClassName('chk_item');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
	   var x = checkboxes[i].disabled;
	   if (!x)
	    checkboxes[i].checked = source.checked;
	  }
	}
	
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
						+ '<label>Age</label>'
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

		        //var d = new Date(check_in_date[2], parseInt(check_in_date[1])-1, check_in_date[0]);
		        var today = new Date(check_in_date[2], parseInt(check_in_date[1])-1, check_in_date[0]);
		        var tomorrow = new Date(today);
		        tomorrow.setDate(today.getDate()+1);
		        tomorrow.toLocaleDateString();
				var tomorow_date = ('0' + tomorrow.getDate()).slice(-2) + '-'
	             + ('0' + (tomorrow.getMonth()+1)).slice(-2) + '-'
	             + tomorrow.getFullYear();         
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

		$('.chk_item').click(function(){
			var total = 0;
			var className = document.getElementsByClassName('chk_item');
			for (var i = 0; i < className.length; i++) {
				if (className[i].checked) {
					total += parseFloat(className[i].getAttribute('data-price'));
				}				
			}
			document.getElementById('total').innerHTML = '';
			document.getElementById('total').append(numFor.format(total));
		});

		$('.select_all').click(function(){
			var total = 0;
			var className = document.getElementsByClassName('chk_item');
			for (var i = 0; i < className.length; i++) {
				if (className[i].checked) {
					total += parseFloat(className[i].getAttribute('data-price'));
				}				
			}
			document.getElementById('total').innerHTML = '';
			document.getElementById('total').append(numFor.format(total));
		})

		$('#proceed_to_booking').click(function(){
			
			if ($('#check_in_date').val() == '' || $('#check_out_date').val() == '') {
				alert('Select Date to Book.')
			}
			else {
			var className = document.getElementsByClassName('chk_item');
			
			var rooms = []; 
			var rooms_to_check = [];
			
			for (var i = 0; i < className.length; i++) {
				var id_room = className[i].getAttribute('data-item');
				if (className[i].checked) {				
					var room_rate = className[i].getAttribute('data-price');
					//console.log(id_room+':'+room_rate); 
					rooms.push(id_room+':'+room_rate);
					
				}
				rooms_to_check.push(id_room);
				/*var a = item_rates[i].innerHTML;
				a=a.replace(/\,/g,'');			
				prices += parseFloat(a);
				*/
			}
			if (rooms.length == 0) {
				alert('Select a room to book.')
			}
			else {
			var _url = "<?php echo site_url('cart/room_available');?>";
			$.ajax({
	               method: "POST",
	               url: _url,
	               data: {
	                   'rooms': rooms_to_check.toString(),
	                   'check_in_date': $('#check_in_date').val(),
	                   'check_out_date': $('#check_out_date').val()               
	               }
	       })
	       .done(function( res ) {
	    	   var obj = eval('('+res+')');
	    	   
	    	   for (var i=0; i<obj.length; i++) {
	    		   console.log(obj[i]);
			   	   $('#tr_'+obj[i]).addClass('cross_out');
			   	   $('.cb').prop('checked', false);
			   	   $('#id_'+obj[i]).attr('disabled', 'disabled');
		       }

		       if(obj.length > 0) {
					alert ("There is a room that is not available on the date selected")
			   }
		       else {
		    	   $('#h_id_room').val(rooms.toString());
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
			       }
	       });
			}
			}
		});

		var total = 0;
		var className = document.getElementsByClassName('chk_item');
		for (var i = 0; i < className.length; i++) {
			if (className[i].checked) {
				total += parseFloat(className[i].getAttribute('data-price'));
			}				
		}
		document.getElementById('total').innerHTML = '';
		document.getElementById('total').append(numFor.format(total));
	});
</script>
	
</body>
</html>

