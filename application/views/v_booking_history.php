<?php $lang = $this->input->get('lang');
$CI = &get_instance();
$CI->load->model('m_room_type');

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap.min.css">

<style>
	.form-control, label, a {
		color: #000 !important;
	}
	a:hover {
		color: #000 !important;
	}
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

	.balance_amount {
		/*background-color: red;*/
		color: red;
	}



	/* Fixed sidenav, full height */
	.sidenav {
		/* height: 100%; */
		/* width: 200px; */
		/* position: fixed; */
		/* z-index: 1; */
		/* top: 0; */
		/* left: 0; */
		/* background-color: #111; */
		overflow-x: hidden;
		padding-top: 20px;
	}

	/* Style the sidenav links and the dropdown button */
	.sidenav a,
	.dropdown-btn {
		padding: 6px 8px 6px 16px;
		text-decoration: none;
		font-size: 16px;
		color: #818181;
		display: block;
		border: none;
		background: none;
		/* width: 100%; */
		text-align: left;
		cursor: pointer;
		outline: none;
	}

	/* On mouse-over */
	.sidenav a:hover,
	.dropdown-btn:hover {
		color: #000000;
	}


	/* Add an active class to the active dropdown button */
	.active {
		/* background-color: green; */
		color: #81BB4A;
	}

	/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
	.dropdown-container {
		display: none;
		/* background-color: #262626; */
		padding-left: 8px;
	}

	/* Optional: Style the caret down icon */
	.fa-caret-down {
		float: right;
		padding-right: 8px;
	}

	/* Some media queries for responsiveness */
	@media screen and (max-height: 450px) {
		.sidenav {
			padding-top: 15px;
		}

		.sidenav a {
			font-size: 16px;
		}
	}
	
	.button__badge {
		margin-right: 0px;
		font-size: 0.6em !important;
		position: absolute;
		top: -8px !important;
		right: -4px !important;
	}
	.menu-bar {
		width: 100%;
		max-width: 100%;
		display: flex;
		justify-content: space-around;
		font-weight: 400;
	}
	
	.price {
		/*background-color: #2a2a2e;*/
		background-color: #102958;
		color: white;
		text-shadow: 2px 2px 4px #000000;
	}
	/*   
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        background-color: #102958 !important;
        border-color: #102958 !important;
    }
	*/
	
	.paginate_button {
        width: auto !important;
        height: auto !important;
        text-transform: uppercase;
        /*line-height: 30px !important;*/
        font-size: 14px !important;
		background-color: #fff !important;
		color: #102958 !important; 
		border: 1px solid #102958 !important;
        padding: 6px 12px;
        margin: 0 5px;
        border-radius: 4px;
    }
	.paginate_button:hover {
		color: #000 !important;
        background-color: #fff !important;
        border-color: #102958 !important;
        
		border-radius: 4px;
    }	
	.previous, .next {
		margin: 0px;
		padding: 5px 15px;
		
		width: auto;
		height: auto;
		text-transform: uppercase;
		/*line-height: 30px !important;*/
		color: #fff !important;
		font-size: 14px !important;
		background-color: #102958 !important;
		border: 1px solid #102958 !important;
		border-radius: 5px;
	}
	.previous:hover, .next:hover {
		background-color: #102958 !important;
		color: #fff !important; 
		border: 1px solid #102958 !important;
		border-radius: 4px;
	}
	
	table.dataTable thead th, table.dataTable thead td, table.dataTable tfoot th, table.dataTable tfoot td {
		text-align: left;
		vertical-align: middle;
		color: #000 !important;
	}
	.table-responsive {
		display: block;
		width: 100%;
		overflow-x: auto;
		-webkit-overflow-scrolling: touch;
		-ms-overflow-style: -ms-autohiding-scrollbar;
	}
	.table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
		overflow-y: auto; 
        -webkit-overflow-scrolling: touch;
    }
    .table td, .table th {
        white-space: nowrap;
		color: #000 !important;
    }
	div.dataTables_wrapper div.dataTables_info {
		color: #000 !important;
		font-size: 13px !important;
	}
	div.dataTables_wrapper div.dataTables_length label {
		font-size: 13px !important;
	}
	div.dataTables_wrapper div.dataTables_filter label {
		font-size: 13px !important;
	}
</style>
<script>
	$(document).ready(function() {
		$('#booking-history-table').DataTable({
			"scrollY": "100px", // สามารถปรับความสูงตามที่ต้องการ
			"scrollCollapse": true,
			"paging": false // ปิดการแบ่งหน้า
		});
	});
</script>

<?php
$id_project_info = 1;
?>


<div class="main-2 p-2" style="margin-top: 35px;">
	<div class="container">
	<!--
		<div class="row">
			<div class="col-md-12 price room_type_header">
				<span style="margin-left: 10px;"><?php echo $this->lang->line('booking_history'); ?></span>
			</div>
		</div>
	-->
		<div class="row">
			<div class="col-md-2">
				<div class="sidenav">
					<a style="font-weight: 600;"><?php echo _r('Booking History', 'ประวัติการจอง'); ?>
						<i class="fa fa-caret-down"></i>
					</a>
					<div class="dropdown">
						<a href="history" style="color:#81BB4A;margin-left:10px;"><?php echo _r('Booking History', 'ประวัติการจอง'); ?></a>
					</div>
					<a style="font-weight: 600;" href="<?php echo site_url('profile/edit_profile_code'); ?>" class="dropdown-btn"><?php echo _r('Discount Code', 'โค้ดส่วนลด'); ?>
					</a>
					<a style="font-weight: 600;" href="<?php echo site_url('profile/edit_profile_security'); ?>" class="dropdown-btn"><?php echo _r('Security', 'ความปลอดภัย'); ?>
					</a>
					<div class="dropdown-container">
						<a href="#"><?php echo _r('Password', 'รหัสผ่าน'); ?></a>
					</div>
					<a style="font-weight: 600;" href="<?php echo site_url('profile/edit_profile'); ?>" class="dropdown-btn"><?php echo _r('Personal Information', 'ข้อมูลส่วนตัว'); ?>

					</a>
					<!-- <div class="dropdown-container">
						<a href="#">ชื่อผู้ใช้งาน</a>
						<a href="#">อีเมลล์</a>
						<a href="#">เบอร์โทรติดต่อ</a>
						<a href="#">ที่อยู่</a>
					</div> -->
				</div>
			</div>
			<div class="col-md-10">
				<div class="table-responsive mt-4">
					<table class="table" style="width: 100%; font-size: 13px;" id="booking-history-table">
						<thead>
							<tr>
								<th><?php echo $this->lang->line('number'); ?></th>
								<th><?php echo $this->lang->line('booking_number'); ?></th>
								<th><?php echo $this->lang->line('guest_name'); ?></th>
								<th><?php echo $this->lang->line('booking_date'); ?></th>
								<th><?php echo $this->lang->line('check_in_date'); ?></th>
								<th><?php echo $this->lang->line('check_out_date'); ?></th>
								<th><?php echo $this->lang->line('due_date'); ?></th>
								<th><?php echo $this->lang->line('total'); ?></th>
								<th><?php echo $this->lang->line('total_payment'); ?></th>
								<th><?php echo $this->lang->line('balance_amount'); ?></th>
								<th><?php echo $this->lang->line('status'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$ctr = 1;
							foreach ($booking_history as $booking) {
								$_url = '';
								if ($booking->status == 'Booked' || $booking->status == 'Verifying' || $booking->status == 'Confirmed') {
									$_url = site_url('booking/billing') . '?number=' . $booking->booking_number;
								} else {
									$_url = site_url('booking/booking_details') . '?booking_number=' . $booking->booking_number;
								}
							?>
								<tr class="<?php echo ($booking->status == 'Expired') ? 'balance_amount' : ''; ?>">
									<td><?php echo $ctr++; ?></td>
									<td><a href="<?php echo $_url; ?>"><?php echo $booking->booking_number; ?></a></td>
									<td><?php echo $booking->guest_name; ?></td>
									<td><?php echo date('d-m-Y H:i:s', strtotime($booking->booking_date)); ?></td>
									<td><?php echo date('d-m-Y', strtotime($booking->check_in_date)); ?></td>
									<td><?php echo date('d-m-Y', strtotime($booking->check_out_date)); ?></td>
									<td><?php echo date('d-m-Y', strtotime($booking->credit_due_date)); ?></td>
									<td><?php echo number_format($booking->grand_total, 2); ?></td>
									<td><?php echo number_format($booking->transferred_amount, 2); ?></td>
									<td><?php echo number_format($booking->balance_amount, 2); ?></td>
									<td><a href="<?php echo $_url; ?>"><?php echo $booking->status; ?></a></td>
								</tr>
							<?php } ?>

						</tbody>
					</table>
					<form name="frm_book" id="frm_book" method="post" action="<?php echo site_url('booking') . '/guest_info'; ?>">

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
















<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap.min.css">


<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo site_url(); ?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url(); ?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<script>
	/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
	var dropdown = document.getElementsByClassName("dropdown-btn");
	var i;

	for (i = 0; i < dropdown.length; i++) {
		dropdown[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var dropdownContent = this.nextElementSibling;
			if (dropdownContent.style.display === "block") {
				dropdownContent.style.display = "none";
			} else {
				dropdownContent.style.display = "block";
			}
		});
	}








	$(function() {
		$('.table').DataTable();

		$('.delete-item').click(function() {
			var r = confirm("Are you sre you want to delete this item?");
			if (r) {
				var id = $(this).attr('data-id');
				var _url = "<?php echo site_url('cart/delete_to_cart'); ?>";

				$.ajax({
						method: "POST",
						url: _url,
						data: {
							'id_cart_item': id
						}
					})
					.done(function(res) {
						//var obj = eval('('+res+')');
						//console.log(res);
						alert('Delete Successful')
						location.reload();
					});
			}
		});


	});
</script>

<button type="button" onclick="topFunction()" class="return-to-top btn-returntop" id="returnTopBtn" title="Go to top" style="float: right; background-color: #102958 !important; color: #FFF !important; border: #102958; margin: -16px 2px; ">↑</button>

<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  var mybutton = document.getElementById("returnTopBtn");
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>