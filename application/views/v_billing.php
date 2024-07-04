<?php
$lang = ($this->session->userdata('site_lang') !== null) ? $this->session->userdata('site_lang') : 'thai';
$CI = &get_instance();
$CI->load->model('m_room_type');
$CI->load->model('m_discount');
$CI->load->model('m_project_info');
$cancellation_policy = $this->m_project_info->get_property_policy($id_project_info = 1, $type = 'Cancellation Policy');
?>

<style>
	.room_type_header {
		font-size: 1.4em;
		font-weight: bold;
		color: #eee;
		margin: auto;
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





	page {
		background: white;
		display: block;
		margin: 0 auto;
		margin-bottom: 0.5cm;
		box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
	}

	@media (min-width: 700px) {
		page[size="A4"] {
			width: 950px;
			/*21cm*/
			/*height: 842px;*/
			/*29.7cm;*/
		}
	}

	page[size="A4"][layout="portrait"] {
		width: 29.7cm;
		height: 21cm;
	}

	@media print {

		body,
		page {
			margin: 0;
			box-shadow: 0;
		}
	}

	.page_content {
		padding: 20px;
	}

	.line {
		width: 100%;
		border-bottom: 1px solid black;
	}
	
	.button__badge {
		margin-right: 0px;
		font-size: 0.6em !important;
		position: absolute;
		top: -8px !important;
		right: -4px !important;
	}
	
	.price {
		/*background-color: #2a2a2e;*/
		background-color: #5392f9;
		color: white;
		text-shadow: 2px 2px 4px #000000;
	}
	.btn-payment {
		width: auto;
		height: auto;
		text-transform: uppercase;
		line-height: 30px !important;
		color: #fff !important;
		font-size: 16px !important;
		background-color: #5392f9 !important;
		border-color: #5392f9 !important;
	}
	.btn-payment:hover {
        background-color: #fff !important;
        color: #5392f9 !important; 
		border-color: #5392f9 !important;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<main class="main-2">
	<div class="container">


		<div class="container_progress_bar">
			<ul class="progressbar">
				<li class="active"><?php echo $this->lang->line('guest_info'); ?></li>
				<li class="active"><?php echo $this->lang->line('billing'); ?></li>
				<li class="<?php echo ($booking->status == 'Verifying' || $booking->status == 'Confirmed') ? 'active' : '' ?>"><?php echo $this->lang->line('payment'); ?></li>
				<li class="<?php echo ($booking->status == 'Confirmed') ? 'active' : '' ?>"><?php echo $this->lang->line('confirmation'); ?></li>


			</ul>
		</div>



		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 price room_type_header m-0">
					<h5><span style="margin-left: 10px;"><?php echo $this->lang->line('step_2'); ?></span></h5>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 mt-4">



					<page size="A4">

						<div class="page_content">
							<div class="row">
								<div class="col-md-6 col-sm-6 d-flex flex-row">
									<img src="<?php echo site_url(); ?>images/sm_resort.png" style="max-width: 80px; height: fit-content;">
									<span style="margin-left:10px;display: block; margin-top: auto; padding-bottom: 10px; font-size: 1.3em!important; font-weight: bold;"><?php echo ($lang == 'english') ? $project_info->project_name_en : $project_info->project_name_th; ?></span>
								</div>

								<div class="col-md-6">
									<div class="price" style="margin-top: 40px; font-size: 1.3em; text-align: center; font-style: italic; font-weight: bold; color: white; padding: 2px 0 2px 0;"><span><?php echo $this->lang->line('booking_number'); ?>: <?php echo $booking_number; ?></span></div>
								</div>
							</div>

							<div class="row mt-3">
								<div class="col-md-6 col-sm-6">
									<div class="row" style="margin-left: 15px; ">
										<div class="col-md-5 mb-2" style="font-weight: 500;"><?php echo $this->lang->line('company_name'); ?>: </div>
										<div class="col-md-7 mb-2"><?php echo ($lang == 'english') ? $project_info->project_name_en : $project_info->project_name_th; ?></div>
										<div class="col-md-5 mb-2" style="font-weight: 500;"><?php echo $this->lang->line('company_address'); ?>: </div>
										<div class="col-md-7 mb-2"><?php echo ($lang == 'english') ? $project_info->whole_address_en : $project_info->whole_address_th; ?></div>
										<div class="col-md-5 mb-2" style="font-weight: 500;"><?php echo $this->lang->line('company_tax_id'); ?>: </div>
										<div class="col-md-7 mb-2"><?php echo $project_info->business_tax_id; ?></div>
										<div class="col-md-5 mb-2" style="font-weight: 500;"><?php echo $this->lang->line('contact_number'); ?>: </div>
										<div class="col-md-7 mb-2"><?php echo $project_info->phone_number; ?></div>
										<div class="col-md-5 mb-2" style="font-weight: 500;"><?php echo $this->lang->line('bank'); ?>: </div>
										<div class="col-md-7 mb-2">Kasikorn Bank</div>
										<div class="col-md-5 mb-2" style="font-weight: 500;"><?php echo $this->lang->line('account_name'); ?>: </div>
										<div class="col-md-7 mb-2">BuilderSmart (Public) Co., Ltd.</div>
										<div class="col-md-5 mb-2" style="font-weight: 500;"><?php echo $this->lang->line('account_number'); ?>: </div>
										<div class="col-md-7 mb-2">145-1-69629-3</div>
									</div>

								</div>
								<div class="col-md-6 col-sm-6" style="">
									<div class="price" style="color: white; padding-left: 10px;"><?php echo $this->lang->line('invoice'); ?> # <?php echo $booking->id_booking; ?></div>

									<div class="row mb-2" style="padding: 1px 15px 1px 15px; ">
										<div class="col-md-6" style=""><?php echo $this->lang->line('total_before_discount'); ?></div>
										<div class="col-md-6" style="text-align: right;"><?php echo number_format($booking->grand_total + $booking->discounted_amount, 2); ?></div>
									</div>
									<?php
									$discount_desc = '';
									//print_r($discount);
									if (isset($discount->discount_type)) {
										$discount_desc = ($discount->discount_type == 'percent') ? $discount->discount_value . '%' : '฿' . $discount->discount_value;
									}
									?>
									<div class="row mb-2" style="padding: 1px 15px 1px 15px; ">
										<div class="col-md-6 col-sm-6" style=""><?php echo $this->lang->line('discount'); ?> (<?php echo $discount_desc; ?>)</div>
										<div class="col-md-6 col-sm-6" style="text-align: right;"><?php echo number_format($booking->discounted_amount, 2); ?></div>
									</div>

									<div class="row mb-2" style="padding: 0 15px 0 15px; ">
										<div class="col-md-6 col-sm-6" style="font-weight: bold; "><?php echo $this->lang->line('grand_total'); ?></div>
										<div class="col-md-6 col-sm-6" style="font-weight: bold; text-align: right; "><?php echo number_format($booking->grand_total, 2); ?></div>
										<div class="col-md-12">
											<div class="line"></div>
										</div>
									</div>

									<div class="row mt-2 mb-2" style="padding: 0 15px 0 15px; ">
										<div class="col-md-6 col-sm-6" style=""><?php echo $this->lang->line('vat'); ?> (7%)</div>
										<div class="col-md-6 col-sm-6" style="text-align: right;"><?php echo number_format($booking->vat, 2); ?></div>
									</div>

									<div class="row mb-2" style="padding: 0px 15px 1px 15px;  margin-top:-5px;">
										<div class="col-md-6 col-sm-6" style=""><?php echo $this->lang->line('subtotal'); ?></div>
										<div class="col-md-6 col-sm-6" style="text-align: right;"><?php echo number_format($booking->sub_total, 2); ?></div>
									</div>

									<div class="price">&nbsp;</div>
								</div>
							</div>

							<div class="row mt-3">
								<div <?= @$booking->billing_name ? 'class="col-md-4 col-sm-6"' : 'class="col-md-6 col-sm-6"';  ?>>
									<div class="row mt-3" style="margin-left: 15px; ">
										<div class="col-md-5 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('customer_name'); ?>: </div>
										<div class="col-md-7 col-sm-6"><?php echo $booking->guest_name; ?></div>
										<!-- <div class="col-md-5 col-sm-6"><?php echo $this->lang->line('address'); ?>: </div>
										<div class="col-md-7 col-sm-6"><?php echo $booking->guest_address; ?></div>
										<div class="col-md-5 col-sm-6"><?php echo $this->lang->line('guest_tax_id'); ?>: </div>
										<div class="col-md-7 col-sm-6"><?php echo $booking->guest_tax_id; ?></div> -->
										<div class="col-md-5 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('contact_number'); ?>: </div>
										<div class="col-md-7 col-sm-6"><?php echo $booking->guest_contact_number; ?></div>
									</div>
								</div>
								<?php if (@$booking->billing_name) { ?>
									<div class="col-md-4 col-sm-6">
										<div class="row mt-3" style="margin-left: 15px; ">
											<div class="col-md-5 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('billing_name'); ?>: </div>
											<div class="col-md-7 col-sm-6"><?php echo $booking->billing_name; ?></div>
											<div class="col-md-5 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('billing_address'); ?>: </div>
											<div class="col-md-7 col-sm-6"><?php echo $booking->billing_address; ?></div>
											<div class="col-md-5 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('billing_tax_id'); ?>: </div>
											<div class="col-md-7 col-sm-6"><?php echo $booking->billing_tax_id; ?></div>
											<div class="col-md-5 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('billing_contact_number'); ?>: </div>
											<div class="col-md-7 col-sm-6"><?php echo $booking->billing_contact_number; ?></div>
										</div>
									</div>
								<?php } ?>
								<div <?= @$booking->billing_name ? 'class="col-md-4"' : ' class="col-md-6"'  ?>>
									<div class="row mt-3" style="padding: 0 15px 0 15px; ">
										<div class="col-md-6 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('check_in_date'); ?>: </div>
										<div class="col-md-6 col-sm-6" style="text-align: right;"><?php echo date('M d, Y', strtotime($booking->check_in_date)); ?></div>
										<div class="col-md-6 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('check_out_date'); ?>: </div>
										<div class="col-md-6 col-sm-6" style="text-align: right;"><?php echo date('M d, Y', strtotime($booking->check_out_date)); ?></div>
										<div class="col-md-6 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('number_of_nights'); ?>: </div>
										<div class="col-md-6 col-sm-6" style="text-align: right;"><?php echo $date_diff; ?></div>
										<?php if (@$booking->credit_term) { ?>
											<div class="col-md-6 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('credit_term'); ?>: </div>
											<div class="col-md-6 col-sm-6" style="text-align: right;"><?php echo $booking->credit_term . " " . $this->lang->line('days'); ?></div>
											<div class="col-md-6 col-sm-6" style="font-weight: 500;"><?php echo $this->lang->line('due_date') ?>: </div>
											<div class="col-md-6 col-sm-6" style="text-align: right;"><?php echo $booking->credit_due_date; ?></div>
										<?php } ?>
									</div>
								</div>
							</div>

							<div class="row mt-3" style="margin: 1px 0 1px 15px;">
								<div class="col-md-12 col-sm-12 mb-3 price" style="margin: 0 -5px 0 0; color: white; font-weight: bold; font-size: 1em; padding: 3px 15px 3px 15px;"><?php echo $this->lang->line('booking_items'); ?>:</div>
								<div class="col-md-12 col-sm-12">
									<div class="table-responsive">
										<table class="table table-bordered" style="border-color: var(--bs-border-color);">
											<thead>
												<tr style="text-align: center;">
													<th style="width: 80px;"><?php echo $this->lang->line('number'); ?></th>
													<th><?php echo $this->lang->line('description'); ?></th>
													<th style="width: 120px;"><?php echo $this->lang->line('unit_price'); ?></th>
													<th style="width: 120px;"><?php echo $this->lang->line('discount'); ?></th>
													<th style="width: 80px;"><?php echo $this->lang->line('quantity'); ?></th>
													<th style="width: 120px;"><?php echo $this->lang->line('total'); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$ctr = 1;
												$id_project_info = 1;
												$curr_package = array();
												$package_details = new stdClass();
												foreach ($items as $item) {
													if ($item->type == 'package') {
														$curr_package[] = $item->id_package;
												?>
														<tr>
															<td style="text-align: center;"><?php echo $ctr++; ?>.</td>
															<td><?php echo $item->desc; ?></td>
															<td style="text-align: right;"><?php echo number_format($item->full_unit_price, 2); ?></td>
															<td style="text-align: right;"><?php echo number_format($item->discount, 2); ?></td>
															<td style="text-align: center;"><?php echo (($item->is_multiplied_by_night == 1)) ? $item->quantity . 'x' . $date_diff . ' Nights' : $item->quantity; ?></td>
															<td style="text-align: right;"><?php echo ($item->is_multiplied_by_night == 1) ? number_format($item->unit_price * $date_diff, 2) : number_format($item->unit_price * $item->quantity, 2); ?></td>

														</tr>
														<?php
														$package_rooms = $this->m_package->get_package_items_by_id($item->id_package);
														foreach ($package_rooms as $p) {
															$room_type = $this->m_room_type->get_room_type_by_ID($id_project_info, $p->id_room_type);
														?>
															<tr>
																<td style="text-align: center;"></td>
																<td colspan="5"><?php echo $room_type->room_type_name_en; ?></td>

															</tr>
														<?php
														} //  foreach ($package_rooms as $p) {
													} // if ($item->type == 'package') {
													else {
														?>
														<tr>
															<td style="text-align: center;"><?php echo $ctr++; ?>.</td>
															<td><?php echo $item->desc; ?></td>
															<td style="text-align: right;"><?php echo number_format($item->full_unit_price, 2); ?></td>
															<td style="text-align: right;"><?php echo number_format($item->discount, 2); ?></td>
															<td style="text-align: center;"><?php echo (($item->is_multiplied_by_night == 1)) ? $item->quantity . 'x' . $date_diff . ' Nights' : $item->quantity; ?></td>
															<td style="text-align: right;"><?php echo ($item->is_multiplied_by_night == 1) ? number_format($item->unit_price * $item->quantity * $date_diff, 2) : number_format($item->unit_price * $item->quantity, 2); ?></td>
														</tr>
												<?php
													} // else if ($item->id_package == '') {				            
												}
												?>
											</tbody>
										</table>
									</div>
								</div>

								<div class="col-md-12 col-sm-12 price" style="margin: 0 -5px 0 0">
									<div style="color: white; font-weight: 700; font-size: 1em; padding: 3px 0 0 10px;"><?php echo $this->lang->line('notes'); ?>:</div>
									<p style="font-size:small; padding: 3px 40px 3px 40px;">
										<!-- This will serve as your invoice . Please settle the amount stated within 2 hours, then proceed to the next step for <br>the confirmation of your booking. Thank you. -->
										<?php
										foreach ($cancellation_policy as $cp) {
											echo ($lang == 'english') ? $cp->description_en : $cp->description_th;
										}
										?>
									</p>
								</div>
							</div>
						</div> <!-- page content -->

					</page>
					<!-- <page size="A4" layout="portrait">A4 portrait</page> -->

					<div class="row mt-3">
						<!-- 
					<div class="col-md-6 mb-2 text-right" > 
						<a href="<?php echo site_url('booking/billing') . '?number=' . $booking_number; ?>" class="btn button-primary" id="">Back</a>
					</div>
					 -->
						<?php if ($booking->status == 'Booked' || $booking->status == 'Verifying') { ?>
							<div class="col-md-12 mb-5 text-center" style="">
								<a href="<?php echo site_url('booking/payment') . '?number=' . $booking_number; ?>" class="btn button-primary btn-payment" id=""><?php echo $this->lang->line('proceed_to_payment'); ?></a>
							</div>
						<?php } ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</main>

<!-- <script src="//code.jquery.com/jquery.js"></script> -->
<script src="<?php echo site_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo site_url(); ?>js/jquery-ui.min.js"></script>
<script src="<?php echo site_url(); ?>bootstrap-4.0.0-dist/js/bootstrap.bundle.min.js"></script>
<script>
	$(function() {

	});
</script>