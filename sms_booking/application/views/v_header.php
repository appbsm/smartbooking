<!doctype html>
<html lang="en">
  <head>
	<link rel="icon" type="image/x-icon" href="<?php echo site_url(); ?>images/favicon.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>bootstrap-4.0.0-dist/css/bootstrap.css">
    <link href="<?php echo site_url();?>css/styles.css" rel="stylesheet">
    <link href="<?php echo site_url();?>css/custom_header.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?v=1001">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<style>


</style>

</head>
<?php 
$CI =& get_instance();
$CI->load->model('m_guest');
$lang = $this->input->get('lang');

$id_guest = $this->session->userdata('id_guest');
if ($id_guest != '') {
$guest = $CI->m_guest->get_profile_by_guestID($id_guest);
}
?>

<body>
<header>
<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light text-center mr-auto">
  
  
  <!-- responsive menu - Hide for now -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <a class="navbar-brand" href="<?php echo site_url('home');?>"><img src="<?php echo site_url();?>images/SMS_Logo_Final.png"  width="100"></a>
  
  <div style="width:100px; position:absolute; top:12px; right:-25px">
  	<a href="<?php echo site_url();?>?lang=th" style="<?php echo $lang == 'th' ? 'text-decoration:underline': ''; ?>">TH</a>
  	<span>&nbsp;|&nbsp;</span>
  	<a href="<?php echo site_url();?>?lang=en" style="margin-right:20px; <?php echo $lang == 'en' ? 'text-decoration:underline': ''; ?>">EN</a>
  </div>
  
  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <div class="project_name ml-auto">SMS Showroom @ Khao Yai</div>
    <ul class="navbar-nav ml-auto">
   
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $guest->firstname.' '.$guest->lastname;?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?php echo site_url('profile');?>">Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo site_url('cart');?>">Cart</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo site_url('booking/history');?>">Booking History</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo site_url('login/logout');?>">Logout</a>
        </div>
      </li>
    </ul>
     
    
    
  </div>
  
</nav>



</header>