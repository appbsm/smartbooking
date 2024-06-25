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
  		<div class="col-md-12 price room_type_header">Profile</div>
  	</div>
  	<div class="row"> 
    	<div class="col-md-12 mt-3 mb-3">
    	<form name="frm_save" id="frm_save" method="post" action="<?php echo site_url('profile').'/save_profile';?>" enctype="multipart/form-data">
    							<div class="row">
					                <div class="col-md-6 mb-2">
					
					                  <div class="form-outline">
					                  	<label class="form-label" for="firstname">First Name</label>
					                    <input type="text" id="firstname" name="firstname" class="form-control" />					                    
					                  </div>
					
					                </div>
					                <div class="col-md-6 mb-2">
					
					                  <div class="form-outline">
					                  	<label class="form-label" for="lastname">Last Name</label>
					                    <input type="text" name="lastname" id="lastname" class="form-control" />					                    
					                  </div>
					
					                </div>
					           </div>
					              
					           <div class="row">
					              <div class="col-md-6 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="contact_number">Contact Number</label>
					                    <input type="tel" id="contact_number" name="contact_number" class="form-control" />					                    
					                  </div>					
					                </div>
					                
					                <div class="col-md-6 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="email">Email</label>
					                    <input type="email" id="email" name="email" class="form-control" />					                    
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
					                  	<label class="form-label" for="username">Username</label>
					                    <input type="text" id="username" name="username" class="form-control" />					                    
					                  </div>					
					                </div>
					                <div class="col-md-6 mb-2">					
					                  <div class="form-outline">
					                  	<label class="form-label" for="password">Password</label>
					                    <input type="password" id="password" name="password" class="form-control" />					                    
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
<script>

</script>
	
</body>
</html>

