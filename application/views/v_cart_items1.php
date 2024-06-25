<?php 
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
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

.red_color {
	color: red;
}
.table th, .table td {
	vertical-align: middle!important;
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
  		<div class="col-md-12 price room_type_header"><span style="margin-left: 10px;"><?php echo $this->lang->line('my_cart');?></span></div>
  	</div>
  	
	<div class="row mt-3 mb-3">
		<div class="col-md-12 ">
			
			<div style="width: 100%; border: 1px solid #7F8C8D; border-radius: 10px; padding: 10px;">
				
				<div class="row">
				<div class="col-md-8" style="display: flex; flex-direction: row;">
					<div class="group">
					    <label for="name"><?php echo $this->lang->line('check_in_date');?></label>
					    <input type='text' class=" datepicker search_input" name="check_in_date" id="check_in_date" value=""/>
					</div>
					<div class="group">
					    <label for="name"><?php echo $this->lang->line('check_out_date');?></label>
					    <input type='text' class=" datepicker search_input" name="check_out_date" id="check_out_date" value=""/>
					</div>
				</div>
				
				
				<div class="col-md-4" style="padding-top: 27px;">
					<div class="dropdown" >
						  <button class="btn dropdown-toggle w-100 search_input" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <span id="div_adult">2</span> <?php echo $this->lang->line('adults');?>, <span id="div_children">0</span> <?php echo $this->lang->line('children');?> <!-- , <span id="div_room">1</span> Rooms -->
						  </button>
						  <div class="dropdown-menu" style="vertical-align: bottom;" aria-labelledby="dropdownMenuButton">
							    <div class="stepper">
							    <div style="display: flex; justify-content: center;"><?php echo $this->lang->line('adult');?></div>
							    <div style="display: flex; justify-content: center; background-color: white; ">							    
							    <button class="btn_stepper " id="decrement-adult" onClick="stepper(this);"> - </button>
							    <input class="input_number" type="number" min="0" max="100" step="1" value="2" id ="adult" readonly>
							    <button class="btn_stepper " id="increment-adult" onClick="stepper(this);"> + </button>
							    </div>
								<div class="rounded hr3 mt-2 mb-2"></div>
							    <div style="display: flex; justify-content: center;"><?php echo $this->lang->line('children');?></div>
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
			
		</div>
	
		<div class="col-md-12">

		<div class = "table-responsive">
         <table class = "table">
            <thead style="text-align: center;">
               <tr>
                  <th style="text-align: left;"><input type="checkbox" class="select_all cb" onClick="toggle(this);"></th>
                  <th style="text-align: left;"><?php echo $this->lang->line('item');?></th>
                  <th><?php echo $this->lang->line('unit_price');?></th>
                  <th><?php echo $this->lang->line('quantity');?></th>
                  <th><?php echo $this->lang->line('total');?></th>
                  <th><?php echo $this->lang->line('action');?></th>
               </tr>
            </thead>
         	<tbody>
         	<?php          	
         	//print_r($_SESSION);
         	$date = date('Y-m-d');
         	$ctr = 1;
         	if (sizeof($cart_items) > 0) {
         		foreach($cart_items as $key => $item) {
	         		if (isset($item->id_room_type)) {		         		
						$room_type = $CI->m_room_type->get_room_type_by_ID($id_project_info, $item->id_room_type);	
						
						$room_count = $CI->m_room_type->get_count_available_rooms($item->id_room_type, date('Y-m-d'), date("Y-m-d", strtotime('tomorrow')));
						$room_qty = ($room_count > $item->quantity) ? $item->quantity : $room_count;
			         	$rate = $CI->m_room_type->get_day_rate ($room_type->id_room_type, $date);
						if ($rate == '') {
							$rate = $rt->default_rate;				
						}
						$first_photo = $CI->m_room_type->get_first_photo_room_type($item->id_room_type);
         	?>
         	<tr class="<?php echo ($room_count == 0) ? 'red_color' : '';?>" id="tr_room_<?php echo $item->id_room_type?>">
               <td>
               <input <?php echo ($room_count == 0) ? 'disabled' : '';?> type="checkbox" class="chk_item cb room" id="id_room_<?php echo $item->id_room_type?>" data-id="room_<?php echo $item->id_room_type?>" data-item-type="room" data-item="<?php echo $item->id_room_type?>" data-price="<?php echo $rate;?>">
               </td>
               <td>
               <img src="<?php echo share_folder_path().$first_photo->room_photo_url;?>" style="max-width: 100px;"/>
	    		<span style="padding-left: 10px; font-weight: bold;"><?php echo $room_type->room_type_name_en;?></span>
               </td>
               <td style="text-align: center;"><?php echo number_format($rate, 2);?></td>
               <td>
            	<div style="display: flex; justify-content: center; background-color: white; border: 1px solid gray; vertical-align: bottom; font-size: 12px!important;">							    
			    <button class="btn_stepper_sm" data-max="<?php echo $room_count;?>" data-cart-item="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key;?>" data-room="<?php echo $item->id_room_type;?>" id="decrement-room-<?php echo $item->id_room_type;?>" onClick="stepper_room(this);"> - </button>
			    <input class="input_number_sm room_stepper" type="number" min="0" max="<?php echo $room_count;?>" step="1" value="<?php echo $room_qty;?>" id ="room_<?php echo $item->id_room_type;?>" style="margin-top: 7px;" readonly>
			    <button class="btn_stepper_sm" data-max="<?php echo $room_count;?>" data-cart-item="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key;?>" data-room="<?php echo $item->id_room_type;?>" id="increment-room-<?php echo $item->id_room_type;?>" onClick="stepper_room(this);"> + </button>
			    </div>   
			    </td>
               <td style="text-align: center;"><?php echo number_format($rate*$item->quantity, 2);?></td>
               <td style="text-align: center;"><button class="btn button-primary delete-item" data-id="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key;?>"><?php echo $this->lang->line('delete');?></button></td>
               
            </tr>
         	<?php 
         			} // if ($item->id_room_type
		         	else if (isset($item->id_package))  {
		         		$package_rooms = $this->m_package->get_package_items_by_id($item->id_package);
		         		$package_count = $this->m_package->get_available_package (date('Y-m-d'), $item->id_package);
		         		$room_qty = ($package_count > $item->quantity) ? $item->quantity : $package_count;
		   ?>
		   <tr class="<?php echo (sizeof($package_count) == 0) ? 'red_color' : '';?>" id="tr_package_<?php echo $package_rooms[0]->id_package;?>">
		   	<td>
               <input <?php echo (sizeof($package_count) == 0) ? 'disabled' : '';?> type="checkbox" class="chk_item cb package" data-id="package_<?php echo $package_rooms[0]->id_package;?>" id="id_package_<?php echo $package_rooms[0]->id_package;?>" data-item-type="package" data-item="<?php  echo $package_rooms[0]->id_package;?>" data-price="<?php echo $package_rooms[0]->price;?>">
            </td>
            <td>
            	<span style="font-weight: bold;"> <?php echo $package_rooms[0]->name;?></span>
              
            </td>
            <td style="text-align: center;">
               <?php echo number_format($package_rooms[0]->price, 2);?>
            </td>
            <td>
            	<div style="display: flex; justify-content: center; background-color: white; border: 1px solid gray; vertical-align: bottom; font-size: 12px!important;">							    
			    <button class="btn_stepper_sm" data-max="<?php echo sizeof($package_count);?>" data-cart-item="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key;?>" data-package="<?php $package_rooms[0]->id_package;?>" id="decrement-package-<?php echo $package_rooms[0]->id_package;?>" onClick="stepper_package(this);"> - </button>
			    <input class="input_number_sm room_stepper" type="number" min="0" max="<?php echo sizeof($package_count);?>" step="1" value="<?php echo $room_qty;?>" id ="package_<?php echo $item->id_package;?>" style="margin-top: 7px;" readonly>
			    <button class="btn_stepper_sm" data-max="<?php echo sizeof($package_count);?>" data-cart-item="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key;?>" data-room="<?php echo $package_rooms[0]->id_package;?>" id="increment-room-<?php echo $package_rooms[0]->id_package;?>" onClick="stepper_package(this);"> + </button>
			    </div>   
			    </td>
            <td style="text-align: center;">
               <?php echo number_format($package_rooms[0]->price, 2);?>
            </td>
            <td style="text-align: center;"><button class="btn button-primary delete-item" data-id="<?php echo ($this->session->userdata('id_guest') != '') ? $item->id_cart_item : $key;?>"><?php echo $this->lang->line('delete');?></button></td>
		   </tr>
		   
		   <?php 
		         foreach ($package_rooms as $item) {
		         	$first_photo = $CI->m_room_type->get_first_photo_room_type($item->id_room_type);
		         	$room_type = $CI->m_room_type->get_room_type_by_ID($id_project_info, $item->id_room_type);
		   ?>
		   	<tr>
		   	<td>
               
            </td>
            <td colspan="5">
               <img src="<?php echo share_folder_path().$first_photo->room_photo_url;?>" style="max-width: 100px;"/>
	    	   <span style="padding-left: 10px; font-weight: bold;"><?php echo $room_type->room_type_name_en;?></span>
            </td>            
		   </tr>
		   <?php 		
		         }
		         	} // else if ($item->id_room_type
         		} // foreach($cart_items as $key => $item) {
         	} // IF
         	?>
					            
			</tbody>
		</table>
      	</div>
		
		</div>
		
		
		
		
		<div class="col-md-12 text-center mt-3 mb-5 d-flex flex-row justify-content-center">
			<label style="font-size: 1.2em; font-weight: bold; margin: 8px 5px 5px 5px;"><?php echo $this->lang->line('total');?>: </label><div id="total" style="font-size: 1.2em; font-weight: bold; padding: 8px 20px 5px 0;">0.00</div>
    		<div>
    		<button class="btn button-primary" id="proceed_to_booking"><?php echo $this->lang->line('proceed_to_booking');?></button>
    		</div>
    	</div>
	</div>
	
	<div class="row">
		
	</div>
	
	
	
		
  </div>


<form name="frm_book" id="frm_book" method="post" action="<?php echo site_url('booking').'/guest_info';?>"> 
<input type="hidden" name="h_id_room" id="h_id_room" value="">
<input type="hidden" name="h_id_package" id="h_id_package" value="">
<input type="hidden" name="h_num_of_adult" id="h_num_of_adult" value="">
<input type="hidden" name="h_num_of_room" id="h_num_of_room" value="">
<input type="hidden" name="h_num_of_children" id="h_num_of_children" value="">
<input type="hidden" name="h_children_ages" id="h_children_ages" value="">
<input type="hidden" name="h_check_in_date" id="h_check_in_date" value="">
<input type="hidden" name="h_check_out_date" id="h_check_out_date" value="">
<input type="hidden" name="page" id="page" value="cart_items">
</form>

</main>





<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script>


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
				max_age = '<?php echo app_settings('max_children_age');?>';
				var option_ct = 1;
				new_html += '<div class="col-md-3" style="padding: 1px;">'
						+ '<label><?php echo $this->lang->line('ages');?></label>'
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
	
	if (btn_id == 'decrement-children') {		
		var new_html = '';
		if (newval > 0) {
			for (var x=0; x < newval; x++) {
				max_age = '<?php echo app_settings('max_children_age');?>';
				var option_ct = 1;
				new_html += '<div class="col-md-3" style="padding: 1px;">'
						+ '<label><?php echo $this->lang->line('ages');?></label>'
						+ '<select class="form-control select_age" name="select_age[]">'
						+ '<option value="0">0</option>';
				do {
					new_html += '<option value="'+option_ct+'">'+option_ct+'</option>';
					option_ct++;
				} while(option_ct <= max_age);		
				new_html += '</select></div>';
			}				
		}
		$('.div_kids_age').html(new_html);
	}

	
}

function stepper_room(dis) {
	let btn_id = dis.getAttribute('id');
	let max = dis.getAttribute('data-max');
	//console.log(max);
	var id_room_type = dis.getAttribute('data-room');
	var id_cart_item = dis.getAttribute('data-cart-item');
	//console.log(id_room_type);
	const myArray = btn_id.split("-");
	var myInput = myArray[1];
	let min = $('#room_'+id_room_type).val();
	//console.log(min);
	var newval = ( myArray[0] == 'increment' ) ? (parseInt(min)+1) : (parseInt(min)-1);
	newval = (newval < 0) ? 0 : newval;
	//alert(newval)
	
	//$('#'+myInput).val(newval);
	if (myArray[0] == 'decrement') {
		if (newval > 0) {
			$('#room_'+id_room_type).val(newval);
			var _url = "<?php echo site_url('cart/update_cart_ajax');?>";
			$.ajax({
		        method: "POST",
		        url: _url,
		        data: {
		            'id_cart_item': id_cart_item,
		            'id_room_type': id_room_type,
		            'quantity': newval            
		        }
			})
			.done(function( res ) {
			});			
		}
		else {
			delete_row (id_cart_item);
		}
	}
	if (myArray[0] == 'increment') {
		if (newval <= max) {
			$('#room_'+id_room_type).val(newval);
			var _url = "<?php echo site_url('cart/update_cart_ajax');?>";
			$.ajax({
		        method: "POST",
		        url: _url,
		        data: {
		            'id_cart_item': id_cart_item,
		            'id_room_type': id_room_type,
		            'quantity': newval            
		        }
			})
			.done(function( res ) {
			});
		}
		else {
			alert("Max available room reached")
		}
	}
	
	
	calc_total_price();
}

function stepper_package(dis) {
	let btn_id = dis.getAttribute('id');
	let max = dis.getAttribute('data-max');
	var id_package = dis.getAttribute('data-package');
	var id_cart_item = dis.getAttribute('data-cart-item');
	//console.log(id_room_type);
	const myArray = btn_id.split("-");
	var myInput = myArray[1];
	let min = $('#package_'+id_cart_item).val();
	//console.log(min);
	var newval = ( myArray[0] == 'increment' ) ? (parseInt(min)+1) : (parseInt(min)-1);
	newval = (newval < 0) ? 0 : newval;
	//alert(newval)
	
	//$('#'+myInput).val(newval);
	if (myArray[0] == 'decrement') {
		if (newval > 0) {
			$('#package_'+id_package).val(newval);
			var _url = "<?php echo site_url('cart/update_cart_package');?>";
			$.ajax({
		        method: "POST",
		        url: _url,
		        data: {
		            'id_cart_item': id_cart_item,
		            'id_package': id_package,
		            'quantity': newval            
		        }
			})
			.done(function( res ) {
			});			
		}
		else {
			delete_row (id_cart_item);
		}
	}
	if (myArray[0] == 'increment') {
		if (newval <= max) {
			$('#package_'+id_package).val(newval);
			var _url = "<?php echo site_url('cart/update_cart_package');?>";
			$.ajax({
		        method: "POST",
		        url: _url,
		        data: {
		            'id_cart_item': id_cart_item,
		            'id_package': id_package,
		            'quantity': newval            
		        }
			})
			.done(function( res ) {
			});
		}
		else {
			alert("Max available room reached")
		}
	}
	
	
	calc_total_price();
}

function get_room_count_on_change_date () {
	var className = document.getElementsByClassName('chk_item');	
	var rooms = []; 
	var rooms_to_check = [];
	
	for (var i = 0; i < className.length; i++) {
		var item_type = className[i].getAttribute('data-item-type');
		var id_item = className[i].getAttribute('data-item');
		var id_ = className[i].getAttribute('data-id');
		console.log(id_ + ' ' +id_item+' '+item_type);
		
		//console.log(id_room_type);
		if (item_type == 'room') {
			var _url = "<?php echo site_url('cart/get_available_room_by_room_type');?>";
			$.ajax({
	               method: "POST",
	               url: _url,
	               data: {
	                   'id_room_type': id_item,
	                   'id_item': id_,
	                   'check_in_date': $('#check_in_date').val(),
	                   'check_out_date': $('#check_out_date').val()               
	               }
	       })
	       .done(function( res ) {
	    	   var obj = eval('('+res+')');
			   console.log("RooM: "+obj.id_room_type+' = '+	obj.room_count);
			   console.log(obj);
	           if (obj.room_count == 0) {
					console.log('red');
	       	   		$('#tr_'+obj._id_item).addClass('red_color');
			   	   	$('.cb').prop('checked', false);
			   	 	$('#id_'+obj._id_item).attr('disabled', true);
	           }
	           else {
		           //console.log('test');
	        	   $('#tr_'+obj._id_item).removeClass('red_color');
	        	  
	        	   $('#id_'+obj._id_item).prop('disabled', false);
	        	   // set data-max 
	          }
	          //$('#room_'+obj.id_room_type).val(obj.room_count);
	          $('#room_'+obj.id_room_type).attr('max', obj.room_count);
	          $('#increment-room-'+obj.id_room_type).attr('data-max', obj.room_count);
	          $('#decrement-room-'+obj.id_room_type).attr('data-max', obj.room_count);
	       });	  
		}    
		else if (item_type == 'package') {
			var _url = "<?php echo site_url('cart/get_available_package');?>";
			$.ajax({
	               method: "POST",
	               url: _url,
	               data: {
	                   'id_package': id_item,
	                   'id_item': id_,
	                   'check_in_date': $('#check_in_date').val(),
	                   'check_out_date': $('#check_out_date').val()               
	               }
	       })
	       .done(function( res ) {
	    	   var obj = eval('('+res+')');			   
			   console.log(obj);
	           if (obj.package_count == 0) {
					console.log('red');
	       	   		$('#tr_'+obj._id_item).addClass('red_color');
			   	   	$('.cb').prop('checked', false);
			   	   	$('#id_'+obj._id_item).attr('disabled', true);
	           }
	           else {
		           //console.log('test');
	        	   $('#tr_'+obj._id_item).removeClass('red_color');	        	  
	        	   $('#id_'+obj._id_item).prop('disabled', false);
	        	   // set data-max 
	          }
	          //$('#'+obj._id_item).val(obj.package_count);
	          $('#'+obj._id_item).attr('max', obj.package_count);
	          $('#increment-package-'+obj.id_package).attr('data-max', obj.package_count);
	          $('#decrement-package-'+obj.id_package).attr('data-max', obj.package_count);
	       });	
		}   
	}
}

function delete_row (id_cart_item) {
	var r = confirm("<?php echo $this->lang->line('message_delete_item');?>");
	if (r) {				
		var _url = "<?php echo site_url('cart/delete_to_cart');?>";
		
        $.ajax({
               method: "POST",
               url: _url,
               data: {
                   'id_cart_item': id_cart_item              
               }
       })
       .done(function( res ) {
 			//var obj = eval('('+res+')');
 			//console.log(res);
 		    alert('<?php echo $this->lang->line('delete_successful');?>')
 		    location.reload();
       });
	}
	
}

function calc_total_price() {
	var total = 0;
	var className = document.getElementsByClassName('chk_item');
	
	for (var i = 0; i < className.length; i++) {							
		if (className[i].checked) {
			var item_type = className[i].getAttribute('data-item-type');
			if (item_type == 'room') {
				var id_room_type = className[i].getAttribute('data-item');
				item_total_price = (parseFloat(className[i].getAttribute('data-price')) * parseInt($('#room_'+id_room_type).val()));
				total = total + item_total_price;
			}
			else {
				var id_package = className[i].getAttribute('data-item');
				item_total_price = (parseFloat(className[i].getAttribute('data-price')) );
				total = total + item_total_price;
			}
		}				
	}
	document.getElementById('total').innerHTML = '';
	document.getElementById('total').append(number_add_comma_decimal(total));
}



	$(function(){		

		
		
		$('#check_in_date').datepicker({ 
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
				$('.cb').prop('checked', false);
			   	$('.cb').attr('disabled', false);
			   	$('.table tr').removeClass("cross_out");	
				var total = 0;
			   	$('#total').text(number_add_comma_decimal(total));
			   	get_room_count_on_change_date();
			   	
		    }
		  }).val();

		$('#check_out_date').datepicker({ 
		    dateFormat: 'dd-mm-yy',
		    changeMonth: true,
		    changeYear: true,
		    minDate: new Date(), // = today
		    onSelect: function(dateText, inst) {						       
				$('.cb').prop('checked', false);
			   	$('.cb').attr('disabled', false);
			   	$('.table tr').removeClass("cross_out");	
			   	var total = 0;
			   	$('#total').text(number_add_comma_decimal(total));
			   	get_room_count_on_change_date();
		    }
		  }).val();

		var today = new Date();
        var tomorrow = new Date(today);
        tomorrow.setDate(today.getDate()+1);
        tomorrow.toLocaleDateString();
        var today_date = ('0' + today.getDate()).slice(-2) + '-'
        + ('0' + (today.getMonth()+1)).slice(-2) + '-'
        + today.getFullYear();         

        
		var tomorow_date = ('0' + tomorrow.getDate()).slice(-2) + '-'
         + ('0' + (tomorrow.getMonth()+1)).slice(-2) + '-'
         + tomorrow.getFullYear();         
		$("#check_in_date").val(today_date);
		$("#check_out_date").val(tomorow_date);
		
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
			var id = $(this).attr('data-id');
			delete_row (id);
		});

		$('.chk_item').click(function(){
			calc_total_price();
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
			document.getElementById('total').append(number_add_comma_decimal(total));
		})

		$('#proceed_to_booking').click(function(){
			
			if ($('#check_in_date').val() == '' || $('#check_out_date').val() == '') {
				alert('Select Date to Book.')
			}
			else {
			var className = document.getElementsByClassName('chk_item');
			
			var rooms = []; 
			var rooms_to_check = [];
			var packages = [];
			var packages_to_check = [];
			
			for (var i = 0; i < className.length; i++) {
				var id_room = className[i].getAttribute('data-item');
				var item_type = className[i].getAttribute('data-item-type');
				
				if (className[i].checked == true) {	
					var room_rate = className[i].getAttribute('data-price');
					var room_count = $('#room_'+id_room).val();
					if (item_type == 'room') {							
						//console.log(id_room+':'+room_rate); 
						rooms.push(id_room+':'+room_rate+':'+room_count+':'+item_type);
						rooms_to_check.push(id_room);
					}
					else if (item_type == 'package') {
						packages.push(id_room+':'+room_rate+':'+1+':'+item_type);
						packages_to_check.push(id_room);
					}
					
					
				}				
				/*var a = item_rates[i].innerHTML;
				a=a.replace(/\,/g,'');			
				prices += parseFloat(a);
				*/
			  }
			//console.log(rooms_to_check);
			if (rooms.length == 0 && packages.length == 0) {
				alert('Select a room to book.')
			}
			
			else {
				var proceed_to_booking = 0;
				//if (item_type == 'room') {
					console.log(rooms_to_check.toString());
					var _url = "<?php echo site_url('room_details/room_available');?>";
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
			    	   console.log(obj);
			    	   for (var i=0; i<obj.length; i++) {
			    		   console.log(obj[i]);
					   	   $('#tr_room_'+obj[i]).addClass('red_color');
					   	   $('.cb').prop('checked', false);
					   	   $('#id_room_'+obj[i]).attr('disabled', 'disabled');
				       }
		
				       if(obj.length > 0 && obj[0] != '') {
							alert ("<?php echo $this->lang->line('room_not_available');?>")
					   }
				       else {
				    	   $('#h_id_package').val(packages.toString());
					    	$('#h_id_room').val(rooms.toString());
							$('#h_num_of_adult').val($('#div_adult').text());
							$('#h_num_of_room').val($('#div_room').text());
							$('#h_num_of_children').val($('#div_children').text());
			
							var children_ages = [];
							var ages = document.getElementsByClassName("select_age");
							for (var i = 0; i < ages.length; i++) {
								children_ages.push(ages[i].value);
							}
							$('#h_children_ages').val(children_ages.toString());
							$('#h_check_in_date').val($('#check_in_date').val());		
							$('#h_check_out_date').val($('#check_out_date').val());						
							$('#frm_book').submit();   
					   }
			       });
				//}
				//else {
					
				//}
					
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
		document.getElementById('total').append(number_add_comma_decimal(total));
	});
	sessionStorage.clear();
</script>
	

