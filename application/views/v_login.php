<?php 


$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
if($lg=='thai'){
    $this->lang->load('content','thai');
}
elseif($lg=='english'){
    $this->lang->load('content','english');
}
$lang  = $lg;

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $this->lang->line('sms_booking');?></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>bootstrap-4.0.0-dist/css/bootstrap.css">
    <link href="<?php echo site_url();?>css/styles.css" rel="stylesheet">
    <!--<link href="<?php echo site_url();?>css/custom_header.css" rel="stylesheet">-->
	<?php echo $lang=='english'?'<link href="'.site_url().'css/custom_header_en.css" rel="stylesheet">':'<link href="'.site_url().'css/custom_header_th.css" rel="stylesheet">';?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?v=1001">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">


</head>


<style>
	.button__badge {
		margin-right: 0px;
		font-size: 0.6em !important;
		position: absolute;
		top: -8px !important;
		right: -4px !important;
	}
	.form-control-userpass {
		padding: 1.165rem .75rem !important;
	}
	.form-control-email {
		padding: 1.165rem .75rem !important;
	}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<main class="main-2">
	<div style="height:100px">
	</div>
	<div class="container">
        <form name="frm_login" id="frm_login" class="user" method="post" action="<?php echo site_url('login');?>">
			<div class="row my-3 d-flex justify-content-center">
				<div class="col-sm-12 col-md-6">
                    <label class="form-label" for="email"><span class="required">*</span><?php echo $this->lang->line('username');?></label>
                    <input type="text" name="username" class="form-control form-control-user form-control-userpass"
                            id="username" aria-describedby="username"
                                placeholder="<?php echo $this->lang->line('username');?>">
				</div>
			</div>
			<div class="row my-3 d-flex justify-content-center">
				<div class="col-sm-12 col-md-6">
                    <label class="form-label" for="password"><span class="required">*</span><?php echo $this->lang->line('password');?></label>
                    <input type="password" name="password" class="form-control form-control-user form-control-userpass"
                             id="password" placeholder="<?php echo $this->lang->line('password');?>">
				</div>
			</div>
			

			<div class="row d-flex justify-content-center">
				<div class="col-sm-12 col-md-6 text-center">
                    <button name="login_btn" class="btn button-primary btn-user btn-block"><?php echo $this->lang->line('login');?></button>
				</div>
			</div>
			<div class="row d-flex justify-content-center mt-3">
				<div class="col-sm-12 col-md-6 text-center">
					<a href="login_with_facebook.php" id="link-login-facebook" class="text-primary">
						<i class="fab fa-facebook-f"></i> Login with Facebook
					</a>
				</div>
			</div>

			<div class="row d-flex justify-content-center mt-3">
				<div class="col-sm-12 col-md-6 text-center">
					<a href="login_with_google.php" id="link-login-google" class="text-danger">
						<i class="fab fa-google"></i> Login with Google
					</a>
				</div>
			</div>

			<script>
				$('#link-login-facebook').click(function(e) {
					e.preventDefault(); 
					window.open($(this).attr('href'), '_blank'); 
				});

				$('#link-login-google').click(function(e) {
					e.preventDefault(); 
					window.open($(this).attr('href'), '_blank'); 
				});
			</script>
			

            <div class="row d-flex justify-content-center mt-3">
                <div class="col-md-6 text-center">
                    <div class="row mx-2 d-flex justify-content-between">
                        <div class="text-align-center">
                            <a class="forgot_pass" href="javascript:;"><?php echo $this->lang->line('forgot_password');?></a>
                        </div>                                  
                        <div class="text-center">
                            <a class="" href="<?php echo site_url('profile/create_profile');?>"><?php echo $this->lang->line('register_here');?></a>
                        </div>
                    </div>
                </div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-sm-12 col-md-6 text-center">
					<hr>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<div class="col-sm-12 col-md-6 text-center">
					<p>By signing in, I agree to smsbooking.builder Terms of Use and Privacy Policy.</p>
				</div>
			</div>
		</form>
	</div>
</main>
<br><br>
  
    
   <!-- Modal -->
<div class="modal " id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

    <div class="modal-content">
      <div class="modal-header" style="text-align: center; margin: auto; border-bottom: none !important;">
      	<h4><?php echo $this->lang->line('get_password_reset')?></h4>
      </div>
      
      <div class="modal-body" style="text-align: center; margin: auto;">
       <form name="frm_reset" id="frm_reset" method="post" action="<?php echo site_url('profile/send_temp_password');?>">
       <div class="row">
	       <!-- <div class="col-md-12 mb-4">
	       		<div class="row">
		       		<div class="col-md-3" style="text-align: right;">
		       		<label class="form-label" for="reset_username"><span class="required">*</span><?php echo $this->lang->line('username');?></label>
		       		</div>
		       		<div class="col-md-8">
		       		<input type="text" id="reset_username" name="reset_username" class="form-control" value="" required />
		       		</div>
	            
	            </div>
	       </div> -->
	       <div class="col-md-12">
	       		<div class="row" style="align-items: center;">
		       		<div class="col-md-3" style="text-align: right;">
		       		<label class="form-label" for="reset_email"><span class="required">*</span><?php echo $this->lang->line('email');?></label>
		       		</div>
		       		<div class="col-md-8">
		       		<input type="text" id="reset_email" name="reset_email" class="form-control form-control-email" value="" required />
		       		</div>
	            </div>
	       </div>
	       <div class="col-md-12 mt-4 mb-2 text-center"> 
				<button class="btn button-primary " id="send_to_email"><?php echo $this->lang->line('send_temporary_password');?></button>
		   </div>
		</div>
       </form>
       
       
      </div>
      
    </div>
  </div>
</div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo site_url();?>js/jquery.min.js"></script>
	<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
	<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    
    <script>
    $(".forgot_pass").on('click', function(e){
		var mymodal = document.getElementById("myModal");
		
		var self = $(this);
		//var name = self.data('name'); // or src = self.attr('src');
		//var src = self.attr('src');
		//console.log(mymodal);
		//var modalImg = document.getElementById("img01");
		//var captionText = document.getElementById("caption");
		//modalImg.style.display = "block";
		
		//modalImg.src = src;
		// captionText.innerHTML = this.alt;
		$('#myModal').modal('show');
	});

    $('#send_to_email').click(function(){
		if ($('#reset_username').val() == '' || $('#reset_email').val() == '') {
			alert('<?php echo $this->lang->line('message_required_fields');?>');
		}
		else {
			alert('<?php echo $this->lang->line('message_checkmail_temp_password');?>')
			$('#frm_reset').submit();

			/*
			var _url = "<?php echo site_url('profile/send_temp_password');?>";
			//console.log($('#reset_username').val()+' '+$('#reset_email').val());
			$.ajax({
				method: "POST",
				url: _url,
				data: {
					reset_username: $('#reset_username').val(),
					reset_email: $('#reset_email').val()
					}
			})
			.done(function (result){
				//console.log(result);
				$('#myModal').modal('hide');
				alert('<?php echo $this->lang->line('message_checkmail_temp_password');?>')
			});*/
		}
    });
	
    </script>

</body>

</html>