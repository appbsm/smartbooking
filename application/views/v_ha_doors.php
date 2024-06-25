<?php
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI = &get_instance();
$CI->load->model('m_room_type');
$check_in_date = date('d-m-Y');
$check_out_date = date('d-m-Y', strtotime($check_in_date . '+1 day'));
?>
<meta http-equiv="refresh" content="30">
<style>
	.nav-link.active {
		background-color: #81BB4A !important;
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
	
	.dot_on  {
	 margin-right: 5px;
      height: 10px;
      width: 10px;
      background-color: green;
      border-radius: 50%;
      display: inline-block;
    }
    
    .dot_off  {
      margin-right: 5px;
      height: 10px;
      width: 10px;
      background-color: red;
      border-radius: 50%;
      display: inline-block;
    }
    
    .dot_unavailable  {
      margin-right: 5px;
      height: 10px;
      width: 10px;
      background-color: gray;
      border-radius: 50%;
      display: inline-block;
    }
    
   
</style>


<main class="main-2 " style="margin-top: 70px;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12 price room_type_header"><span style="margin-left: 10px;">Bathroom Status</span></div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 mt-4">
				<table class="table">
					<tr>
						<th>No</th>
						<th>Room Name</th>
						<th>Status</th>
					</tr>
					<?php 
					$ctr = 1;
					foreach ($doors as $door) {
					?>
					<tr>
						<td style="width: 100px;;"><?php echo $ctr;?></td>
						<td style="width: 200px;"><?php echo $door->door_name;?></td>
						<td style=""><span class="dot_<?php echo $door->class_state;?> "></span><?php echo $door->state;?></td>
					</tr>
					<?php 
					$ctr++;
					}
					?>
				</table>
			</div>
		</div>
	</div>
</main>

<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo site_url(); ?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url(); ?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
