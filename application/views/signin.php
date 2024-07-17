<?php
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI = &get_instance();
$CI->load->model('m_room_type');

?>
<title>Smart Booking</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="<?= site_url() ?>/css/tiny-slider.css">
<link rel="stylesheet" href="<?= site_url() ?>/css/package.css">
<link rel="icon" type="image/png" sizes="16x16" href="<?= site_url() ?>/images/10.png">
<link rel="stylesheet" href="<?= site_url() ?>assets/select-picker/css/bootstrap-select.min.css">

<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<meta name="google-signin-scope" content="profile email">
<meta name="google-signin-client_id" content="914587690606-4tt68kl5i732amq39va44ki024gvmahm.apps.googleusercontent.com">
<script src="https://apis.google.com/js/platform.js" async defer></script>


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        max-width: 100%;
        margin-top: 40px;
/*        display: flex;*/
    }
    /*.container-login {
        background-color: #fff;
        padding: 16px 30px 24px;
        position: relative;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 400px;
        text-align: center;
        max-width: 100%;
        margin: 0 15px;
        display: flex;
        flex: none;
    }*/
    .container-login {
        background-color: #fff;
        padding: 16px 30px 24px;
        position: relative;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 400px;
        text-align: center;
        max-width: 100%;
        margin: 0 15px;
        flex: none;
    }

    h3 {
        color: #333;
    }
    h6 {
        color: #666;
    }
    input[type="email"],input[type="firstname"],input[type="lastname"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    label {
        display: block;
        text-align: left;
        margin-bottom: 0px;
        margin-top: 5px;
        font-weight: 500;
        font-size: 16px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #5392f9;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #3a73d4;
    }

    .tabs ul {
        list-style-type: none;
        padding: 0;
        display: flex;
        justify-content: center;
    }

    .tabs li {
        margin: 0;
    }

    .tabs span {
        color: #5392f9;
        cursor: pointer;
    }

    .tabs .active {
        font-weight: bold;
    }

    .password-container {
        display: flex;
        align-items: center;
    }

    .password-container input {
        flex: 1;
    }

    .password-container {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .toggle-password i {
        font-size: 16px;
        color: #999;
    }

    .toggle-password.active i {
        color: #5392f9; 
    }

    .footer-links {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        line-height: 20px;
        font-weight: 400;
    }
    .footer-links a {
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        margin: 10px 0;
        color: #5392f9;
        text-decoration: none;
    }

    .footer-links a:hover {
        text-decoration: underline;
    }

    .social-login {
        margin: 16px 0;
    }

    .social-buttons {
        display: flex;
        justify-content: space-between;
    }

    .social-buttons button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48%;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        color: rgb(83, 146, 249);
        font-size: 14px;
        line-height: 20px;
        font-weight: 500;
    }
    .social-buttons button img {
        margin-right: 10px;
    }
    .social-buttons button:hover {
        background-color: #f5f5f5;
    }

    .terms-policy {
        margin-top: 20px;
        font-size: 12px;
        color: #666;
    }
    .terms-policy a {
        color: #5392f9;
        text-decoration: none;
    }
    .terms-policy a:hover {
        text-decoration: underline;
    }

    .forget-svg * {
        fill: rgb(83, 146, 249);
    }

    .tx-signin {
        font-size: 24px ;
        line-height: 24px;
        font-weight: 500;
        margin: 0px;
        padding-bottom: 16px;
        color: black;
    }
    .tx-sub-signin {
        font-size: 14px;
        line-height: 20px;
        font-weight: 400;
        margin: 0px;
        margin-top: 8px;
    }

    .tab-signin {
        display: flex;
        flex-direction: row;
        padding: 0px;
        -webkit-box-pack: start;
        justify-content: flex-start;
    }
    .tab-email {
        flex: 1 1 0%;
        -webkit-box-align: center;
        align-items: center;
        cursor: pointer;
        display: flex;
        list-style-type: none;
        padding: 12px 8px;
        width: auto;
        border-bottom: 2px solid rgb(83, 146, 249);
        margin-bottom: -2px;
    }
    .tab-mobile {
        flex: 1 1 0%;
        -webkit-box-align: center;
        align-items: center;
        cursor: pointer;
        display: flex;
        list-style-type: none;
        padding: 12px 8px;
        width: auto;
        border-bottom: 1px solid rgb(221, 223, 226);
        margin-bottom: -1px;
    }

    
    .line-bt-signin {
        min-width: 1px;
        width: 100%;
        flex: 1 1 0%;
        margin: 0px;
        border-bottom: 1px solid rgb(221, 223, 226);
    }
    .or-signin {
        width: 100%;
        display: flex;
        text-align: center;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        position: relative;
        background-color: transparent;
        padding: 0px;
    }
    .line-or-signin {
        min-width: 1px;
        width: 100%;
        flex: 1 1 0%;
        margin: 0px;
        border-bottom: 1px solid rgb(221, 223, 226);
    }
    .tx-or-signin {
        font-size: 14px;
        line-height: 20px;
        font-weight: 400;
        margin-left: 8px;
        margin-right: 8px;
    }

    .icon-social {
        width: 20px;
        height: 20px;
    }
    
    .icon-flag {
        background-image: url(https://cdn6.agoda.net/images/desktop/bg-sprite-flags.png);
        background-repeat: no-repeat;
        display: inline-block;
        width: 16px;
        height: 16px;
        background-position: -176px -122px;
    }

    .button-mobile {
        background-color: unset !important;
        color: #000;
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .button-mobile:hover {
        color: #000;
    }

    .signin-mobile {
        display: flex;
    }

    @media (min-width: 1200px) {
        .container-login {
            width: 40%;
        }
    }
    
    .tx-ck-agree  {
        font-size: 14px;
    }
    input[type=checkbox], input[type=radio] {
        margin: 4px 4px 0;
    }
    .ck-agree {
        width: 100%;
        display: flex;
        position: relative;
        -webkit-box-align: center;
        align-items: center;
        user-select: none;
    }
    
    .password-container input {
        flex: 1;
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .set_center {
        justify-content: center !important;
    }
    .container-login2 {
        background-color: #fff;
        padding: 16px 30px 24px;
        position: relative;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 400px;
        text-align: center;
        max-width: 100%;
        margin: 0 15px;
    }
     footer {
        text-align: center;
        padding: 10px;
        background-color: #102958 !important;
        color: rgba(255, 255, 255, 1.00);
        margin-top: auto; /* This will push the footer to the bottom */
    }
    .footer-top {
        padding: 20px 0;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
<body>

<!-- Modal -->
<div class="modal " id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

    <div class="modal-content">
      <div class="modal-header" style="text-align: center; margin: auto; border-bottom: none !important;"> 
        <h4 style="color: black;" ><?php echo $lang == "english" ? 'Get Password Reset via Email' : 'รับการรีเซ็ตรหัสผ่านทางอีเมล์'; ?></h4>
      </div>
        <!-- action="<?php //echo site_url('profile/send_temp_password');?>" forgot_password.php -->
        <!-- echo site_url('forgot_password.php') -->
      <div class="modal-body" style="text-align: center; margin: auto;">
       <form name="frm_reset" id="frm_reset" method="post" action="<?php echo site_url('/login/forgot_password');?>">
       <div class="row">
        <!-- hidden="true" -->
         <input hidden="true" type="text" name="lang" value="<? echo $lang; ?>" required />
            <div class="col-md-12 mb-4">
                <div class="row">
                    <div class="col-md-3" style="text-align: right;">
                    <label  style="color: black;"class="form-label" for="reset_username"><span class="required">*</span><?php echo $this->lang->line('username');?></label>
                    </div>
                    <div class="col-md-8">
                    <input style="color: black;" type="text" id="reset_username" name="reset_username" class="form-control" value="" required />
                    </div>
                
                </div>
           </div>

           <div class="col-md-12">
                <div class="row" style="align-items: center;">
                    <div class="col-md-3" style="text-align: right;">
                    <label style="color: black;" class="form-label" for="reset_email"><span class="required">*</span><?php echo $lang == "english" ? 'Email' : 'อีเมล์'; ?>
                    </label>
                    </div>
                    <div class="col-md-8">
                    <input style="color: black;" type="text" id="reset_email" name="reset_email" class="form-control form-control-email" value="" required />
                    </div>
                </div>
           </div>
           <div class="col-md-12 mt-4 mb-2 text-center"> 
                <button style="background-color: #102958 !important;" class="btn button-primary " id="send_to_email"><?php echo $this->lang->line('send_temporary_password');?></button>
           </div>
        </div>
       </form>

      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

    <?php if($this->session->flashdata('login_error')): ?>
    <script type="text/javascript">
        // alert("<?php echo $this->session->flashdata('login_error'); ?>");
        Swal.fire({
            position: 'top',
            icon: 'error',
            // title: 'Username or password is incorrect'
            text : 'Username or password is incorrect',
            // text: "<?php echo $this->session->flashdata('login_error'); ?>"
            timer: 3000 // Popup จะปิดอัตโนมัติหลังจาก 3 วินาที
        });
    </script>
    <?php endif; ?>

    <div class="container-login mx-auto">
        <div class="login-panel">
            <div class="login-form">
                <div class="login-panel-title" style="text-align: left;">
                    <h3 class="tx-signin">Sign in</h3>
                    <div>
                        <h6 style="color: black;" class="tx-sub-signin">For security, please sign in to access your information</h6>
                    </div>
                </div>
                <div>
					<!--
                    <div class="tabs">
                        <ul class="tab-signin">
                            <li class="tab-email active"><div><span>EMAIL</span></div></li>
                            <li class="tab-mobile"><div><span>MOBILE</span></div></li>
                        </ul>
                    </div>
					-->
                    <!-- tab email-->
                    <div class="form-content form-email">
                        <form name="frm_login" id="frm_login" class="user" method="post" action="<?php echo site_url('login');?>">
                            <div class="form-group">
                                <label style="color: black;" for="email"><span class="required">*</span>Email or Username</label>
                                <!-- type="email" -->
                                <input type="firstname" id="email" name="username" placeholder="Email or Username" required>
                            </div>

                            <div class="form-group">
                                <label style="color: black;" for="password"><span class="required">*</span>Password</label>
                                <div class="password-container">
                                    <input type="password" id="password" name="password" placeholder="Password" required>
                                    <span class="toggle-password"><i class="fas fa-eye-slash"></i></span>
                                </div>
                            </div>

                            <button style="background-color: #102958 !important;" type="submit"><?php echo $lang == "english" ? 'sign in' : 'ลงชื่อเข้าใช้งาน'; ?></button>

                        </form>

                        <div class="footer-links">
                            <a style="color: #5392f9 !important;" href="login/signup">Create account</a>

                            <a style="color: #5392f9 !important;" class="forgot_pass" href="javascript:;" >
                                <svg width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="forget-svg" style="padding-right: 4px;">
                                    <path d="M5.286 9.143V6.388A6.388 6.388 0 0 1 11.673 0h1.167a6.388 6.388 0 0 1 6.388 6.388 1 1 0 0 1-2 0A4.388 4.388 0 0 0 12.84 2h-1.167a4.388 4.388 0 0 0-4.387 4.388v2.755H19a2 2 0 0 1 2 2v10.714a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V11.143a2 2 0 0 1 2-2h.286zM13 17.829a3.001 3.001 0 1 0-2 0v2.15a1 1 0 1 0 2 0v-2.15zM11 15a1 1 0 1 1 2 0 1 1 0 0 1-2 0z"></path>
                                </svg>
                                Forgot password?
                            </a>
                        </div>

                    </div>
                    <!-- end tab email-->
<?php
if ($this->session->flashdata('message')) {
    // echo '<div class="alert alert-success">' . $this->session->flashdata('message') . '</div>';
    echo '<script>alert("ระบบได้ส่งรหัสใหม่ไปที่อีเมล์ของคุณ กรุณาตรวจสอบอีเมล์ของคุณสำหรับรหัสผ่านใหม่ชั่วคราว")</script>';
}
?>

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
            // alert('<?php echo $this->lang->line('message_checkmail_temp_password');?>')
            $('#loading').show();
            $('#frm_reset').submit();

            
            // var _url = "<?php echo site_url('profile/send_temp_password');?>";
            //console.log($('#reset_username').val()+' '+$('#reset_email').val());
            // $.ajax({
            //     method: "POST",
            //     url: _url,
            //     data: {
            //         reset_username: $('#reset_username').val(),
            //         reset_email: $('#reset_email').val()
            //         }
            // })
            // .done(function (result){
            //     //console.log(result);
            //     $('#myModal').modal('hide');
            //     alert('<?php echo $this->lang->line('message_checkmail_temp_password');?>')
            // });
        }
    });
    
    </script>

<style>
        /* CSS สำหรับการแสดง loading overlay */
        #loading {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        #loading img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px; /* กำหนดความกว้างของ GIF */
            height: auto; /* ให้รักษาสัดส่วน */
        }
    </style>
    <!-- <div id="loading" style="display:none;">
    <p>กำลังโหลด...</p>
    </div> -->
<div id="loading">
    <img src="loading.gif" alt="Loading...">
</div>


                    <!-- tab mobile-->
                    <div class="form-content form-mobile" style="display: none;">
                        <form>
                            <div class="form-group">
                                <label style="color: black;" for="mobilenumber">Mobile Number</label>
                                <div class="password-container">
                                <input type="mobilenumber" id="mobilenumber" name="mobilenumber" placeholder="Mobile Number" required>
                                </div>
                            </div>
                            <!--
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="password-container">
                                    <input type="password" id="password" name="password" placeholder="Password" required>
                                    <span class="toggle-password"><i class="fas fa-eye-slash"></i></span>
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label style="color: black;" for="password">Password</label>
                                <div class="password-container">
                                    <input type="password" id="password" name="password" placeholder="Password" required pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}">
                                    <span class="toggle-password"><i class="fas fa-eye-slash"></i></span>
                                </div>
                                <small>Password must be at least 8 characters, include an uppercase letter, a lowercase letter, a number, and a special character.</small>
                            </div>
                            <button style="background-color: #102958 !important;" type="submit">Sign in</button>
                        </form>
                        <div class="footer-links">
                            <a style="color: #5392f9 !important;" href="login/signup">Create account</a>
                            <a style="color: #5392f9 !important;" href="#">
                                <svg width="1em" height="1em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="forget-svg" style="padding-right: 4px;">
                                    <path d="M5.286 9.143V6.388A6.388 6.388 0 0 1 11.673 0h1.167a6.388 6.388 0 0 1 6.388 6.388 1 1 0 0 1-2 0A4.388 4.388 0 0 0 12.84 2h-1.167a4.388 4.388 0 0 0-4.387 4.388v2.755H19a2 2 0 0 1 2 2v10.714a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V11.143a2 2 0 0 1 2-2h.286zM13 17.829a3.001 3.001 0 1 0-2 0v2.15a1 1 0 1 0 2 0v-2.15zM11 15a1 1 0 1 1 2 0 1 1 0 0 1-2 0z"></path>
                                </svg>
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <!-- end tab mobile-->

                </div>
                <div class="or-signin" style="margin-top: 8px;">
                    <div class="line-or-signin"></div>
                    <div>
                        <span style="color: black;" class="sc-fznZeY tx-or-signin">or sign in with</span>
                    </div> 
                    <div class="line-or-signin"></div>
                </div>
                <div class="social-login ">
                    <div class="social-buttons">
                        <button style="background-color: white !important;color: #5392f9 !important;border: 1px solid #ccc;" class="google g-signin2" data-onsuccess="onSignIn" data-theme="dark"alt="Google">
							<img src="https://cdn6.agoda.net/images/universal-login/google-logo-v2.svg" alt="Google" class="icon-social">Google
                        </button>
						
                        <button style="background-color: white !important;color: #5392f9 !important;border: 1px solid #ccc;" class="facebook">
                            <img src="https://cdn6.agoda.net/images/universal-login/facebook-logo.svg" alt="Facebook" class="icon-social">Facebook
                        </button>
                    </div>
                </div>
				
				
				
				
                <div class="terms-policy">
                    <span style="color: black;">By signing in, I agree to Smsmartbooking's </span><br/>
                    <span>   
                        <!-- target="_blank" -->
                        <a style="color: #5392f9 !important;" href="#" >Terms of Use</a><span style="color: black;"> and</span>
                        <a style="color: #5392f9 !important;" href="#" >Privacy Policy</a>.
                    </span>
                </div>
            </div>
        </div>
    </div>
	
<!--	
	<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
<br>
Result: <textarea id="result"></textarea>
-->
<script>
  function onSignIn(userInfo) {
    var result = '';
    
    // Useful data for your client-side scripts:
    var profile = userInfo.getBasicProfile();
    
    result+= "ID: "+profile.getId()+"\n";
    result+= "Full Name:  "+profile.getName()+"\n";
    result+= "Given Name: "+profile.getGivenName()+"\n";
    result+= "Family Name: "+profile.getFamilyName()+"\n";
    result+= "Email: "+profile.getEmail()+"\n";
    result+= "ID Token: "+userInfo.getAuthResponse().id_token+"\n";
    
    document.getElementById("result").value = result;
  };
</script>

<!--
<div class="social-login">
    <div class="social-buttons">
        <button style="background-color: white !important;color: #5392f9 !important;border: 1px solid #ccc;" class="google" onclick="startGoogleSignIn()">
            <img src="https://cdn6.agoda.net/images/universal-login/google-logo-v2.svg" alt="Google" class="icon-social">Google
        </button>
        <button style="background-color: white !important;color: #5392f9 !important;border: 1px solid #ccc;" class="facebook">
            <img src="https://cdn6.agoda.net/images/universal-login/facebook-logo.svg" alt="Facebook" class="icon-social">Facebook
        </button>
    </div>
</div>
-->


    <script src="http://192.168.20.22/smartbooking_front_test/js/jquery.min.js"></script>
    <script src="http://192.168.20.22/smartbooking_front_test/js/jquery-ui.min.js"></script>
    <script src="http://192.168.20.22/smartbooking_front_test/bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://192.168.20.22/smartbooking_front_test/assets/select-picker/js/bootstrap-select.min.js"></script>
    <script src="http://192.168.20.22/smartbooking_front_test/assets/swiper-element/js/swiper-element-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-signin li');
            const forms = document.querySelectorAll('.form-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const tabName = this.classList.contains('tab-email') ? 'email' : 'mobile';

                    forms.forEach(form => {
                        if (form.classList.contains(`form-${tabName}`)) {
                            form.style.display = 'block';
                        } else {
                            form.style.display = 'none';
                        }
                    });
                });
            });

            const togglePassword = document.querySelector('.toggle-password');
            const passwordField = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('active');
            });
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordField = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>


