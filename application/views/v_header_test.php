<!doctype html>
<html lang="en">
<?php
$lg = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
if ($lg == 'thai') {
  $this->lang->load('content', 'thai');
} elseif ($lg == 'english') {
  $this->lang->load('content', 'english');
}
$lang  = $lg;


$CI = &get_instance();
$CI->load->model('m_guest');
$CI->load->model('m_cart');


$id_guest = $this->session->userdata('id_guest');
$cart_count = 0;
if ($id_guest != '') {
  $guest = $CI->m_guest->get_profile_by_guestID($id_guest);
  $cart_count = $CI->m_cart->get_cart_item_count($id_guest);
} else {
  $cart_count = sizeof($this->session->userdata('my_cart'));
}
?>
<head>
  <link rel="icon" type="image/x-icon" href="<?php echo site_url(); ?>images/favicon.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <?php echo $lang=='english'?'<link href="https://fonts.googleapis.com/css2?family=Syne&display=swap" rel="stylesheet">':'<link href="https://fonts.googleapis.com/css2?family=Prompt&family=Syne&display=swap" rel="stylesheet">';?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo site_url(); ?>bootstrap-4.0.0-dist/css/bootstrap.css">

  <!-- icon font-awesome -->
  <link href="<?php echo site_url(); ?>assets/font-awesome/css/all.min.css" rel="stylesheet">

  <link href="<?php echo site_url(); ?>css/styles.css" rel="stylesheet">
  <link href="<?php echo site_url(); ?>css/css.css" rel="stylesheet">
  <?php echo $lang=='english'?'<link href="'.site_url().'css/custom_header_en.css" rel="stylesheet">':'<link href="'.site_url().'css/custom_header_th.css" rel="stylesheet">';?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css?v=1001">
  <!--<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>-->
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>-->
  

  
   
  <style>
    

    .button {
      color: white;
      display: inline-block;
      /* Inline elements with width and height. TL;DR they make the icon buttons stack from left-to-right instead of top-to-bottom */
      position: relative;
      /* All 'absolute'ly positioned elements are relative to this one */

    }

    .button__badge {
      background-color: #fa3e3e;
      border-radius: 50%;
      color: white;

      padding: 0 5px 0 5px;
      margin-right: 10px;
      font-size: 0.8em !important;

      position: absolute;
      /* Position the badge within the relatively positioned button */
      top: 0;

      right: 0;
    }

    input,
    textarea,
    button,
    span {
      font-size: 1em !important;
      /* font-family: arial; */
    }
	
	.inside{
        height:max-content;
        position:absolute;
        width:100%;
 }
	
	
  </style>

  <script>
    const numFor = new Intl.NumberFormat('en-US');

    function ValidateEmail(mail) {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return (true)
      } else {
        alert("You have entered an invalid email address!")
        return (false)
      }
    }

    function number_add_comma_decimal(num) {
      num = parseFloat(num).toFixed(2);
      return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function number_add_comma(num) {
      //num = parseFloat(num).toFixed(2);
      return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function remove_comma(num) {
      return num.replace(/\,/g, '');
    }

    function date_diff(date1, date2) {
      const diffTime = Math.abs(date2 - date1);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      //console.log(diffTime + " milliseconds");
      //console.log(diffDays + " days");
      return diffDays;
    }
    let width = screen.width;
    //console.log(width);
  </script>
</head>


<body>
  <header>
  <nav class="navbar navbar-light bg-faded justify-content-between flex-nowrap flex-row">
    <div class="container">
        <a href="/" class="navbar-brand float-left">PIM</a>
        <ul class="nav navbar-nav flex-row float-right" style="position:relative;">
			
			<li class="nav-item dropdown" >
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Dropdown link
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<div class="inside">
				  <a class="dropdown-item" href="#">Action</a>
				  <a class="dropdown-item" href="#">Another action</a>
				  <a class="dropdown-item" href="#">Something else here</a>
				  </div>
				</div>
			  </li>
			  </div>
            <li class="nav-item"><a class="nav-link pr-3" href="">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="">Sign up</a></li>
        </ul>
    </div>
</nav>
</header>

<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url();?>js/jquery.min.js"></script>
<script src="<?php echo site_url();?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url();?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo site_url();?>assets/select-picker/js/bootstrap-select.min.js"></script>
	<script>
		$(function(){
			
		});
	</script>