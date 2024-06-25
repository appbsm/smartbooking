<?php $lang = $this->input->get('lang');
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

</style>

<?php 

?>


<main class="main-2">
	
	<div class="container">
		<form name="frm_save" id="frm_save" method="post" action="<?php echo site_url('profile').'/save_profile';?>" enctype="multipart/form-data">
				<div style="height:50px">
				</div>
			
			<div class="row my-3 d-flex justify-content-center">
				<div class="col-sm-12 col-md-6">
					<label class="form-label" for="firstname"><span class="required">*</span><?php echo $this->lang->line('firstname');?></label>
					<input type="text" id="firstname" name="firstname" class="form-control" required />
				</div>
			</div>
			<div class="row my-3 d-flex justify-content-center">
				<div class="col-md-6 col-sm-12">
					<label class="form-label" for="lastname"><span class="required">*</span><?php echo $this->lang->line('lastname');?></label>
					<input type="text" name="lastname" id="lastname" class="form-control" required />
				</div>
			</div>
			<div class="row my-3 d-flex justify-content-center">
				<div class="col-md-6 col-sm-12">
					<label class="form-label" for="email"><span class="required">*</span><?php echo $this->lang->line('email');?></label>
					<input type="email" id="email" name="email" class="form-control" required />
				</div>
			</div>

			<div class="row my-3 d-flex justify-content-center">							
				<div class="col-md-6 col-sm-12">
					<label class="form-label" for="username"><span class="required">*</span><?php echo $this->lang->line('username');?></label>
					<input type="text" id="username" name="username" class="form-control" required />					                    				
				</div>
			</div>
			<div class="row my-3 d-flex justify-content-center">
				<div class="col-md-6 sm-12">
					<label class="form-label" for="password"><span class="required">*</span><?php echo $this->lang->line('password');?></label>
					<input type="password" id="password" name="password" class="form-control" required />
				</div>
			</div>
			<div class="row my-3 d-flex justify-content-center">
				<div class="col-md-6 col-sm-12">
					
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-md-6 col-sm-12 text-center">
					<button class="btn button-primary" id="save" style="width:100%"><?php echo $lang=='english'?'Sign Up':'ลงทะเบียน';?></button>
				</div>
			</div>
			</form>
			<div class="row d-flex justify-content-center">
				<div class="col-md-6 col-sm-12 text-center">
					<hr>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-md-6 col-sm-12 text-center">
					<a class="btn button-primary" href="<?php echo site_url('login'); ?>" id="already" style="width:100%"><?php echo $lang=='english'?'Already have an account? Sign in':'มีบัญชีผู้ใช้งานอยู่แล้ว';?></a>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-md-6 col-sm-12 text-center">
					<p>By signing in, I agree to smsbooking.builder Terms of Use and Privacy Policy.</p>
				</div>
			</div>
		
	</div>
</main>
<br><br>
<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>



<script>
function ValidateEmail(mail) 
{  
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/.test(mail))
  {
    return (true)
  }
  else {
  	alert("You have entered an invalid email address!")
  	return (false)
  }
}

	$("#contact_number").inputmask({"mask": "999-999-9999"}); 

	$('#contact_number').on('focusout', function() {
		var pattern1 = new RegExp("^([0-9]{3})[-]([0-9]{3})[-]([0-9]{4})$");
		var value = $(this).val();
		if (pattern1.test(value) || value == '') {
			$('#save').attr('disabled', false);
		}
		else {
			$('#contact_number').focus();
			$('#save').attr('disabled', true);
		}				
	});
		
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
	
