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

?>

<main class="main-2">

  <div class="container-fluid" >
  	<div class="row">
  		<div class="col-md-12 price room_type_header"><span style="margin-left: 10px;">Profile</span></div>
  	</div>
  	<div class="row"> 
    	<div class="col-md-12 mt-3 mb-3">
    	<form name="frm_save" id="frm_save" method="post" action="<?php echo site_url('profile').'/save_profile';?>" enctype="multipart/form-data">
    							<div class="row">
					                <div class="col-md-6 mb-2">
					
					                  <div class="form-outline">
					                  	<label class="form-label" for="firstname"><span class="required">*</span>First Name</label>
					                    <input type="text" id="firstname" name="firstname" class="form-control" required />					                    
					                  </div>
					
					                </div>
					                <div class="col-md-6 mb-2">
					
					                  <div class="form-outline">
					                  	<label class="form-label" for="lastname"><span class="required">*</span>Last Name</label>
					                    <input type="text" name="lastname" id="lastname" class="form-control" required />					                    
					                  </div>
					
					                </div>
					           </div>
					              
					           <div class="row">
					              <div class="col-md-6 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="contact_number"><span class="required">*</span>Contact Number (Please enter 10-digit number)</label>
					                    <input type="tel" class="form-control" name="contact_number" id="contact_number" />
					                    
					                    <!-- <input type="tel" id="contact_number" name="contact_number" id="contact_number" class="form-control" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" /> -->					                    
					                  </div>					
					                </div>
					                
					                <div class="col-md-6 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="email"><span class="required">*</span>Email</label>
					                    <input type="email" id="email" name="email" class="form-control" required />					                    
					                  </div>					
					                </div>
    						</div>  
    						
    						<div class="row">
    							<div class="col-md-12 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="address">Address</label>
					                    <textarea id="address" name="address" class="form-control"></textarea>					                    				                    
					                  </div>					
					            </div>
    						</div>
    						
    						<div class="row">
					                <div class="col-md-6 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="username"><span class="required">*</span>Username</label>
					                    <input type="text" id="username" name="username" class="form-control" required />					                    
					                  </div>					
					                </div>
					                <div class="col-md-6 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="password"><span class="required">*</span>Password</label>
					                    <input type="password" id="password" name="password" class="form-control" required />					                    
					                  </div>					
					                </div>
					        </div>
					        
					        <div class="row">
					        	<div class="col-md-6">
						  			<div class="form-outline">
						                <label class="form-label" for="guest_photo">Upload Photo</label>
						            	<input type="file" id="guest_photo" name="guest_photo" class="form-control" />					                    
						            </div>
					            </div>
					        </div>
    							
    						
    						<div class="row mt-4 mb-4"> 
    							<div class="col-md-12 d-flex justify-content-center">
				    				<button class="btn button-primary" id="cancel">Cancel</button>&nbsp;&nbsp;
				    				<button class="btn button-primary" id="save">Save</button>
				    			</div>
    						</div>
    </form>
    </div>
  </div>

</main>





<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script src=
"https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js">
    </script>
<!-- 
<link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css" /> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    
     <!--<link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">  -->


<script>
function ValidateEmail(mail) 
{  
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
  {
    return (true)
  }
  else {
  	alert("You have entered an invalid email address!")
  	return (false)
  }
}

function convertToValidPhoneNumber(text) {  
    return text = text.replace(/'-'/g,"").replace(/^(?=[0-9]{10})([0-9]{3})([0-9]{3})([0-9]{4})$/, "$1-$2-$3");
}


$("#contact_number").inputmask({"mask": "999-999-9999"}); 
/*
Inputmask("9{3}[-]9{3}[-]9{4}", {
    placeholder: "-",
    greedy: false
}).mask('#contact_number');
*/	
	$('#email').on('focusout', function() {
		if ($(this).val() != '') {
			var check = ValidateEmail($(this).val());
			if (!check) {			
				$(this).focus();
				$(this).val('');			
			}
			else {
				var _url = "<?php echo site_url('profile/check_email_exist');?>";
				$.ajax({
		               method: "POST",
		               url: _url,
		               data: {
		                   'email': $(this).val()             
		               }
		       })
		       .done(function( res ) {
		    	   if (res > 0) {
			    	   alert('Email already exists.')
		    		   $('#email').val('');
			       } 	    	   
		       });
			}
		}
	});
</script>
	
