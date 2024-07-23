<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" style="padding-bottom:50px;" v-cloak>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= _r('Front Desk', 'แผนกต้อนรับ'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo booking_url(); ?>"><?= _r('Booking', 'จองห้องพัก'); ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo edit_booking_url($booking_info['id_booking']); ?>">
                                {{ menu }}{{ booking_info.id_booking ? (' ('+ booking_info.booking_number +')') : '' }}
                            </a>
                            <?php if (has_permission('booking', 'view') && !empty($booking_info['id_booking'])) : ?>
                            <button class="btn btn-sm btn-info" style="margin-left:8px; margin-top:-2px;" @click="viewBooking(<?php echo $booking_info['id_booking']; ?>)">
                                <i class="fa fa-file-alt"></i>
                            </button>
                            <?php endif; ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="searchGuestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"><?= _r('Search', 'ค้นหา'); ?> Guest</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-12">
                            <div style="overflow:hidden; white-space:nowrap;">
                                <input type="text" placeholder="<?= _r('Search Name, Phone, Email or Username', 'พิมพ์ชื่อ, เบอร์โทร, อีเมล หรือ ยูสเซอร์เนม'); ?>" style="width:calc(100% - 52px); float:left;" id="searchGuestInput" class="form-control" v-model="guestSearchQuery" @keyup.enter="searchGuest()">
                                <button style="margin-left:-3px; border-radius:0px; padding-left:5px; padding-right:5px; width:52px; height:38px; float:left;" class="btn btn-sm btn-success" @click="searchGuest()"><?= _r('Search', 'ค้นหา'); ?></button>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:10px">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th style="width:70px"><?= _r('Photo', 'รูปภาพ'); ?></th>
                                        <th style="width:200px"><?= _r('Email', 'อีเมล'); ?></th>
                                        <th><?= _r('Name', 'ชื่อ'); ?></th>
                                        <th style="width:200px"><?= _r('Contact Number', 'เบอร์โทรติดต่อ'); ?></th>
                                        <th style="width:70px; font-size:13px; font-weight:normal;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(g, i) in guestSearchResult">
                                        <td class="text-center">
                                            <img style="width:40px;" :src="g.photo_url">
                                        </td>
                                        <td class="text-left">{{ g.email }}</td>
                                        <td class="text-left">{{ g.firstname +' '+ g.lastname }}</td>
                                        <td class="text-right">{{ g.contact_number }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-success" @click="selectGuest(i)">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 text-center" style="margin-top:10px; font-size:16px;" v-if="guestSearchResult.length == 0 && searched">
                            <?= _r('No Result Found !!', 'ไม่พบผลลัพธ์ !!'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Search Biller -->
    <div class="modal fade" id="searchBillingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2"><?= _r('Search', 'ค้นหา'); ?> Billing Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="row" style="margin-top:10px">
                        <div class="col-md-12">
                            <div style="overflow:hidden; white-space:nowrap;">
                                <input type="text" placeholder="<?= _r('Search Name, Phone, Email or Username', 'พิมพ์ชื่อ, เบอร์โทร, อีเมล หรือ ยูสเซอร์เนม'); ?>" style="width:calc(100% - 52px); float:left;" id="searchBillingInput" class="form-control" v-model="billingSearchQuery" @keyup.enter="searchBilling()">
                                <button style="margin-left:-3px; border-radius:0px; padding-left:5px; padding-right:5px; width:52px; height:38px; float:left;" class="btn btn-sm btn-success" @click="searchBilling()"><?= _r('Search', 'ค้นหา'); ?></button>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:10px">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th style="width:70px"><?= _r('Photo', 'รูปภาพ'); ?></th>
                                        <th style="width:200px"><?= _r('Email', 'อีเมล'); ?></th>
                                        <th><?= _r('Name', 'ชื่อ'); ?></th>
                                        <th style="width:200px"><?= _r('Contact Number', 'เบอร์โทรติดต่อ'); ?></th>
                                        <th style="width:70px; font-size:13px; font-weight:normal;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(g, i) in billingSearchResult">
                                        <td class="text-center">
                                            <img style="width:40px;" :src="g.photo_url">
                                        </td>
                                        <td class="text-left">{{ g.email }}</td>
                                        <td class="text-left">{{ g.firstname +' '+ g.lastname }}</td>
                                        <td class="text-right">{{ g.contact_number }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-success" @click="selectBilling(i)">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 text-center" style="margin-top:10px; font-size:16px;" v-if="billingSearchResult.length == 0 && searchedBilling">
                            <?= _r('No Result Found !!', 'ไม่พบผลลัพธ์ !!'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <imagemodal :showimage='show_image' :title="_r('Transfer Slip', 'สลิปโอนเงิน', lang)"></imagemodal>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Booking Info -->
                <div class="col-md-12">
                    <h6><?= _r('Guest Info', 'Guest Info'); ?></h6>                                                      
                    <div class="row" style="margin-top:-5px">
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('Guest Name', 'Guest Name'); ?></small>
                            <input type="text" style="width:100%; float:left;" class="form-control" v-model="booking_info.guest_name" v-if="disable">
                            <div style="overflow:hidden; white-space:nowrap;" v-else>
                                <input type="text" style="width:calc(100% - 38px); float:left;" class="form-control" v-model="booking_info.guest_name" readonly>
                                <button style="border-radius:0px; width:38px; height:38px; float:left;" class="btn btn-sm btn-secondary" id="id_guest_info" data-toggle="modal" data-target="#searchGuestModal"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Credit Term', 'Credit Term'); ?></small>
                            <select class="form-control" v-model="booking_info.id_credit" v-on:change="calculateDueDate(booking_info.check_out_date, booking_info.id_credit)">
                                <option v-for="c in guestCreditTerm" :value="c.value">{{c.text}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Guest Contact Number', 'เบอร์โทรติดต่อผู้เข้าพัก'); ?></small>
                            <input type="text" class="form-control" v-model="booking_info.guest_contact_number">
                        </div>
                        
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-4">
                            <small><?= _r('Guest Address', 'ที่อยู่ผู้เข้าพัก'); ?></small>
                            <input type="text" class="form-control" v-model="booking_info.guest_address">
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Guest Email', 'อีเมลผู้เข้าพัก'); ?></small>
                            <input type="text" class="form-control" v-model="booking_info.guest_email">
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Guest Tax ID', 'Tax ID ผู้เข้าพัก'); ?></small>
                            <input type="text" class="form-control" v-model="booking_info.guest_tax_id">
                        </div> 
                    </div>
                    <div class="row" style="margin-top:5px">                                                                       
                        <div class="col-md-4">
                            <small><?= _r('Notes', 'หมายเหตุ'); ?></small>
                            <input type="text" class="form-control" v-model="booking_info.notes">
                        </div>                        
                    </div>
                    
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('# of Adults', 'จำนวนผู้ใหญ่'); ?></small>
                            <input type="number" min="0" class="form-control" v-model="booking_info.number_of_adults" id="number_of_adults" :disabled="disable == 1">
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('# of Children', 'จำนวนเด็ก'); ?></small>
                            <input type="number" min="0" class="form-control" v-model="booking_info.number_of_children" id="number_of_children" :disabled="disable == 1">
                        </div>
                        <div class="col-md-4">
                            <small style="overflow:hidden; white-space:nowrap;"><?= _r('Children Age', 'อายุเด็ก'); ?> <font color="#bfbfbf">(<?= _r('separate with ,', 'คั่นด้วย ,'); ?>)</font></small>
                            <input type="text" class="form-control" v-model="booking_info.children_age" id="children_age" :disabled="disable == 1">
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('Check In Date', 'วัน check-in'); ?></small>
                            <input type="text" class="form-control" id="check_in_date" :value="convertDateSlash(booking_info.check_in_date)" @keyup="updateBookingPrice()" @change="updateBookingPrice()" :disabled="disable == 1">
                        </div>
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('Check Out Date', 'วัน check-out'); ?></small>
                            <input type="text" class="form-control" id="check_out_date" :value="convertDateSlash(booking_info.check_out_date)" @keyup="updateBookingPrice()" @change="updateBookingPrice()" :disabled="disable == 1">
                        </div>
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('Booking Status', 'สถานะ Booking'); ?></small>
                            <select class="form-control" v-model="booking_info.status" id="status" :disabled="disable == 1">
                                <!--
                                <option value="Booked" v-if="!booking_info.id_booking || old_booking_info.status == 'Booked'">Booked</option>
                                <option value="Verifying" v-if="!booking_info.id_booking || ['Booked', 'Verifying'].includes(old_booking_info.status)">Verifying</option>
                                <option value="Confirmed" v-if="!booking_info.id_booking || ['Booked', 'Verifying', 'Confirmed'].includes(old_booking_info.status)">Confirmed</option>
                                <option value="Checked-in" v-if="['Confirmed', 'Checked-in'].includes(old_booking_info.status)">Checked-in</option>-->
                                <option value="Checked-out" v-if="!booking_info.id_booking || old_booking_info.status == 'Checked-out'">Checked-out</option>
                                <!--<option value="Cancel" v-if="booking_info.id_booking">Cancel</option>
                                <option value="Expired" v-if="old_booking_info.status == 'Expired'">Expired</option>-->
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Billing Details -->
                <div class="col-md-12 mt-4">
                <input type="checkbox" style="width:17px; height:17px;" v-model="bill_to"><label style="padding-left: 10px;">Bill To</label>
                </div>

                <div class="col-md-12 mt-4 billing_info" v-if="bill_to" >
                    <h6><?= _r('Billing Info', 'Billing Info'); ?></h6>
                    <div class="row" style="margin-top:-5px">
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('Billing Name', 'Billing Name'); ?></small>
                            <input type="text" style="width:100%; float:left;" class="form-control" v-model="booking_info.billing_name" v-if="disable">
                            <div style="overflow:hidden; white-space:nowrap;" v-else>
                                <input type="text" style="width:calc(100% - 38px); float:left;" class="form-control" v-model="booking_info.billing_name" readonly>
                                <button style="border-radius:0px; width:38px; height:38px; float:left;" class="btn btn-sm btn-secondary" id="id_billing_info" data-toggle="modal" data-target="#searchBillingModal"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Credit Term', 'Credit Term'); ?></small>
                            <select class="form-control" v-model="booking_info.id_credit" v-on:change="calculateDueDate(booking_info.check_out_date, booking_info.id_credit)">
                                <option v-for="c in billingCreditTerm" :value="c.value">{{c.text}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Billing Contact Number', 'Billing Contact Number'); ?></small>
                            <input type="text" class="form-control" v-model="booking_info.billing_contact_number">
                        </div>
                        
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-4">
                            <small><?= _r('Billing Address', 'ที่อยู่ผู้เข้าพัก'); ?></small>
                            <input type="text" class="form-control" v-model="booking_info.billing_address">
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Guest Email', 'อีเมลผู้เข้าพัก'); ?></small>
                            <input type="text" class="form-control" v-model="booking_info.billing_email">
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Guest Tax ID', 'Tax ID ผู้เข้าพัก'); ?></small>
                            <input type="text" class="form-control" v-model="booking_info.billing_tax_id">
                        </div>
                        
                        </div>
                    </div>
                </div>

                <!-- Room -->
                <div class="col-md-12" style="margin-top:20px;">
                    <div>
                        <u><b><?= _r('Room', 'ห้องพัก'); ?></b></u>
                        <div class="row" style="margin-top:23px;">
                            <div class="col-md-4" v-for="(r, i) in sort_room" style="margin-bottom:30px;">
                                <span style="font-size:12px; color:#bfbfbf; position:absolute; top:-20px;" v-if="i == 0 || r.id_project_info != sort_room[i - 1].id_project_info">
                                    <i>({{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }})</i>
                                </span>
                                <input type="checkbox" @click="selectRoom(r.id_room_details, $event)" :checked='r.is_selected' style="width:17px; height:17px;">
                                <span style="font-size:14px; position:absolute; top:-2px; padding-left:5px;">
                                    {{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }} <b>({{ r.room_number }})</b>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package -->
                <div class="col-md-12" style="margin-top:-8px;">
                    <div>
                        <u><b><?= _r('Package', 'แพ็กเกจ'); ?></b></u>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-4" v-for="(p, i) in sort_package" style="margin-bottom:30px;">
                                <span style="font-size:12px; color:#bfbfbf; position:absolute; top:-16px;" v-if="i == 0 || p.id_project_info != sort_package[i - 1].id_project_info">
                                    <i>({{ <?= _r('p.project_name_en', 'p.project_name_th'); ?> }})</i>
                                </span>
                                <input type="checkbox" @click="selectPackage(p.id_package, $event)" :checked='p.is_selected' style="width:17px; height:17px; position:absolute; top:5px;">
                                <span style="font-size:14px; padding-left:22px; display:inline-block;">
                                    {{ p.name }}
                                    <span style="font-weight:bold;" v-show="p.package_qty > 0"> (x{{ p.package_qty }})</span>
                                </span>
                                <span class="badge badge-info" v-for="pi in p.package_item" style="font-size:11px; font-weight:normal; margin-left:1px; display:inline-block;">
                                    {{ pi.room_type_name_en }}
                                    <span style="font-weight:bold; color:black;" v-show="pi.qty > 1"> (x{{ pi.qty }})</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Extra -->
                <div class="col-md-12" style="margin-top:-2px;">
                    <u><b>Extra</b></u>
                    <div class="row" style="margin-top:-15px">
                        <span class="col-md-4" v-for="(e, i) in extras" style="margin-top:20px;">
                            <input type="checkbox" class="form-control test" style="width:17px; height:17px; display:inline-block; vertical-align:top;" @click="selectExtra(e.id_extras, $event)" :checked='select_extra_qty[e.id_extras]' :disabled="disable == 1">
                            <span style="width:calc(100% - 25px); display:inline-block; height:50px; font-size:14px; overflow:hidden; text-overflow:ellipsis; margin-left:5px; position:absolute; top:-2px;">
                                {{ <?= _r('e.title_en', 'e.title_th'); ?> }}
                                <span style="font-weight:bold;" v-show="select_extra_qty[e.id_extras]"> (x{{ select_extra_qty[e.id_extras] }})</span>
                            </span>
                        </span>
                    </div>
                </div>

                <!-- Price -->
                <div class="col-md-12" style="margin-top:-5px;">
                    <hr style="border:none; border-bottom:1px solid #bbbbbb;">
                    <div class="row credit_term" v-if="booking_info.id_credit">
                        <div class="col-md-4 offset-md-8" style="font-style: italic;">Credit Due on <label>{{ convertDateSlash(booking_info.credit_due_date) }}</label></div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-4 offset-md-8">
                            <div class="row" style="margin-top:-10px;">
                                <div class="col-md-10" style="overflow:hidden; white-space:nowrap;"><b><?= _r('Total Before Discount', 'ยอดก่อนหักส่วนลด'); ?></b></div>
                                <div class="col-md-2 text-right" style="overflow:hidden; white-space:nowrap;"><b>{{ formatBaht(booking_info.grand_total + booking_info.discounted_amount) }}</b></div>
                            </div>
                            <div class="row">
                                <div class="col-md-10" style="overflow:hidden; white-space:nowrap;">
                                    <b style="margin-right:5px;"><font color="red"><?= _r('Discount', 'ส่วนลด'); ?></font></b>
                                    <input type="text" style="display:inline-block; width:120px;" v-model="booking_info.discount_code" @keyup="updateBookingPrice()" @change="updateBookingPrice()" :disabled="disable == 1">
                                </div>
                                <div class="col-md-2 text-right" style="overflow:hidden; white-space:nowrap;"><b><font color="red">{{ '- '+ formatBaht(booking_info.discounted_amount) }}</font></b></div>
                            </div>
                            <div class="row">
                                <div class="col-md-10" style="overflow:hidden; white-space:nowrap;"><b><font color="green"><?= _r('Total', 'ยอดรวม'); ?></font></b></div>
                                <div class="col-md-2 text-right" style="overflow:hidden; white-space:nowrap;"><b><u><font color="green">{{ formatBaht(booking_info.grand_total) }}</font></u></b></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr style="margin-top:8px;">
                                </div>
                            </div>
                            <div class="row" style="font-size:13px; margin-top:-13px;">
                                <div class="col-md-10" style="overflow:hidden; white-space:nowrap;">(<?= _r('VAT', 'ภาษีมูลค่าเพิ่ม'); ?>)</div>
                                <div class="col-md-2 text-right" style="overflow:hidden; white-space:nowrap;">{{ formatBaht(booking_info.vat) }}</div>
                            </div>
                            <div class="row" style="font-size:13px;">
                                <div class="col-md-10" style="overflow:hidden; white-space:nowrap;">(<?= _r('Sub Total', 'ยอดก่อนรวมภาษีมูลค่าเพิ่ม'); ?>)</div>
                                <div class="col-md-2 text-right" style="overflow:hidden; white-space:nowrap;">{{ formatBaht(booking_info.sub_total) }}</div>
                            </div>
                        </div>
                    </div>
                    <hr style="border:none; border-bottom:1px solid #bbbbbb; margin-top:2px;">
                </div>

                <!-- Payment -->
                <!--
                <span class="col-md-12" style="text-align:right;">
                    
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-3 offset-md-8" style="margin-bottom:20px;">
                            <div class="col-md-12">
                                <div class="row" style="font-size:13px; margin-top:-13px;">
                                    <div class="col-md-8" style="overflow:hidden; white-space:nowrap;">(<?= _r('Total Transfer', 'ยอดเงินที่ชำระแล้ว'); ?>)</div>
                                    <div class="col-md-4 text-right" style="overflow:hidden; white-space:nowrap;">{{ formatBaht(booking_info.transferred_amount) }}</div>
                                </div>
                                <div class="row" style="font-size:13px;">
                                    <div class="col-md-8" style="overflow:hidden; white-space:nowrap;">(<?= _r('Balance', 'ยอดค้างชำระ'); ?>)</div>
                                    <div class="col-md-4 text-right" style="overflow:hidden; white-space:nowrap;">{{ formatBaht(booking_info.balance_amount) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-sm btn-warning" style="width:100%; font-size:13px; margin-top:-18px;" @click="addSlip()"><?= _r('Add Slip', 'เพิ่มสลิป'); ?></button>
                        </div>
                    </div>
                </span>
                <div class="col-md-12" style="margin-top:5px;" v-for="(p, i) in booking_payment">
                    <div class="row">
                        <div class="col-md-2">
                            <input type="hidden" :id="'url-image-input-slip-'+ i" v-model="p.transfer_slip">
                            <input type="file" style="display:none;" class="image-input image-input-slip" :id="'image-input-slip-'+ i" accept="image/jpeg, image/png, image/jpg">
                            <div style="width:150px !important;">
                                <small><?= _r('Transfer Slip', 'สลิปโอนเงิน'); ?></small>
                                <div class="display-image" :id="'display-image-input-slip-'+ i">
                                    <img :src="p.transfer_slip ? p.transfer_slip : '<?php echo site_url(); ?>asset/image/upload.jpg'" style="margin-top:-1px; height:77px; cursor:zoom-in;" data-toggle="modal" data-target="#showImageModal" @click="showImage(p.transfer_slip)">
                                </div>
                            </div>
                            <div style="width:150px !important;">
                                <button style="background-color:black; color:white;" @click="uploadImage('slip-'+ i)">Browse...</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <small><?= _r('Transfer Date', 'วันโอนเงิน'); ?></small>
                            <input type="text" class="form-control" :id="'transfer_date-'+ i" :value="convertDateSlash(p.transfer_date)">
                        </div>
                        <div class="col-md-3">
                            <small><?= _r('Transfer Time (XX:XX or XX.XX)', 'เวลาโอนเงิน (XX:XX หรือ XX.XX)'); ?></small>
                            <input type="text" class="form-control" v-model="p.transfer_time" :id="'transfer_time-'+ i">
                        </div>
                        <div class="col-md-3">
                            <small><?= _r('Transfer Amount', 'ยอดโอนเงิน'); ?></small>
                            <input type="number" class="form-control" v-model="p.transferred_amount" :id="'transferred_amount-' + i" @change="sumSlip()">
                        </div>
                        <?php if (has_permission('booking', 'delete')) : ?>
                        <div class="col-md-1" style="text-align:center">
                            <button class="btn btn-sm btn-danger" style="padding:0px 5px 0px 5px; margin-top:31px;" @click="removeSlip(i)">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                -->
                <!-- Save, Check-in, Check-out -->
                <?php if (has_permission('booking', 'edit')) : ?>
                <div class="col-md-12">
                    <div class="row" style="margin-top:15px">
                        <div class="col-md-12" style="text-align:center">
                            <button class="btn" style="width:200px; height:34.5px; line-height:9px; background-color:#809f4e; color:white;" @click="saveBookingInfo()"><?= _r('Save', 'บันทึก'); ?></button>
                        </div>
                    </div>
                </div>
                <!-- Check-in -->
                <?php if (!empty($booking_info['status']) && $booking_info['status'] == 'Confirmed') : ?>
                <div class="col-md-12">
                    <div class="row" style="margin-top:15px">
                        <div class="col-md-12" style="text-align:center">
                            <button class="btn" style="width:200px; height:34.5px; line-height:9px; background-color:#007bff; color:white;" @click="updateBookingStatus('Checked-in')">
                                <i class="fa fa-sign-in-alt"></i> Check In
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <!-- Check-out -->
                <?php if (!empty($booking_info['status']) && $booking_info['status'] == 'Checked-in') : ?>
                <div class="col-md-12">
                    <div class="row" style="margin-top:15px">
                        <div class="col-md-12" style="text-align:center">
                            <button class="btn" style="width:200px; height:34.5px; line-height:9px; background-color:#ff8c1a; color:white;" @click="updateBookingStatus('Checked-out')">
                                Check Out <i class="fa fa-sign-out-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo site_url(); ?>asset/component/imageModal.js"></script>
<script>
function putChildrenIntoRooms(children, rooms) {
    children = children.map(Number);
    children.sort(function(a, b) { return b - a; });
    rooms.sort(function(a, b) { return parseInt(a.max_children_age) - parseInt(b.max_children_age); });

    let remain_children = [];
    children.forEach((a) => {
        let found = false;
        rooms.forEach((r) => {
            if (!found && a <= r.max_children_age && r.number_of_children > 0) {
                r.number_of_children--;
                found = true;
            }
        });

        if (!found) {
            remain_children.push(a);
        }
    });
    
    return remain_children;
}

$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: '<?php echo empty($booking_info['id_booking']) ? _r("Late Booking", "Late Booking") : _r("Update Booking", "แก้ไขการจอง"); ?>',
            lang: '<?php echo getLang(); ?>',
            old_booking_info: <?php echo empty($booking_info) ? '{}' : json_encode($booking_info); ?>,
            booking_info: <?php echo empty($booking_info) ? '{}' : json_encode($booking_info); ?>,
            rooms: <?php echo empty($rooms) ? '{}' : json_encode($rooms); ?>,
            extras: <?php echo empty($extras) ? '{}' : json_encode($extras); ?>,
            select_extra: <?php echo empty($select_extra) ? '{}' : json_encode($select_extra); ?>,
            select_extra_qty: <?php echo empty($select_extra_qty) ? '{}' : json_encode($select_extra_qty); ?>,
            searched: false,
            searchedBiller: false,
            guestSearchQuery: '',
            guestSearchResult: {},
            guestCreditTerm: [
                {'value': '', 'text': ''}
            ],
            billingSearchQuery: '',
            billingSearchResult: {},
            billingCreditTerm: [
                {'value': '', 'text': ''}
            ],
            old_booking_item: <?php echo empty($booking_item) ? '[]' : json_encode($booking_item); ?>,
            booking_item: <?php echo empty($booking_item) ? '[]' : json_encode($booking_item); ?>,
            booking_payment: <?php echo empty($booking_payment) ? '[]' : json_encode($booking_payment); ?>,
            booking_payment_blank_row: <?php echo empty($booking_payment_blank_row) ? '{}' : json_encode($booking_payment_blank_row); ?>,
            disable: <?php echo in_array($booking_info['status'], array('Confirmed', 'Checked-in', 'Checked-out', 'Cancel', 'Expired')) ? 1 : 0; ?>,
            packages: <?php echo empty($packages) ? '[]' : json_encode($packages); ?>,
            credit: <?php echo empty($credit) ? '{}' : json_encode($credit); ?>,
            show_image: '',
            sort_room: [],
            sort_package: [],
            bill_to: false,
            credit_term_due: '',
            status: 'Checked-out'
        },
        mounted() {
            let self = this;

            $("#check_in_date").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.booking_info.check_in_date = convertDateDash(d);
                    self.updateBookingPrice();
                    self.calculateDueDate(self.booking_info.check_out_date, self.booking_info.id_credit);
                }
            });
            $("#check_out_date").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.booking_info.check_out_date = convertDateDash(d);
                    self.updateBookingPrice();                    
                    self.calculateDueDate(self.booking_info.check_out_date, self.booking_info.id_credit);
                }                
            });

            this.booking_payment.forEach((v, i) => {
                $('#transfer_date-'+ i).datepicker({
                    dateFormat: "dd/mm/yy",
                    onSelect: function(d) {
                        self.booking_payment[i].transfer_date = convertDateDash(d);
                    }
                });
            });

            let room = '<?php echo empty($_GET['room']) ? '' : $_GET['room']; ?>';
            if (room) {
                this.updateBookingPrice();
            }
            this.sort_room = this.sortRoom();
            this.sort_package = this.sortPackage();  
            this.booking_info.status = 'Checked-out';
            if (this.booking_info.id_credit != '') {
                if (this.booking_info.billing_name != '') {
                    this.billingCreditTerm = [
                        {'value': '', 'text': ''},
                        {'value': this.booking_info.id_credit, 'text': this.booking_info.credit_description}                      
                    ];
                }
                else {
                    this.guestCreditTerm = [
                        {'value': '', 'text': ''},
                        {'value': this.booking_info.id_credit, 'text': this.booking_info.credit_description}                 
                    ];
                    console.log(this.guestCreditTerm);
                }
            } 
            this.bill_to = (this.booking_info.billing_name != '') ? true : false;
            
        },
        
        methods: {
            uploadImage: function(id) {
                $('#image-input-'+ id).trigger('click');
            },           
            searchGuest: function() {
                if (!this.guestSearchQuery) {
                    return;
                }

                let self = this;
                let param = {query: this.guestSearchQuery};
                $.post("<?php echo search_guest_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        self.searched = true;
                        self.guestSearchResult = res.message;
                    }
                });
            },
            searchBilling: function() {
                if (!this.billingSearchQuery) {
                    return;
                }

                let self = this;
                let param = {query: this.billingSearchQuery};
                $.post("<?php echo search_guest_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        self.searchedBiller = true;
                        self.billingSearchResult = res.message;
                    }
                });
            },
            selectGuest: function(id) {
                let guest = JSON.parse(JSON.stringify(this.guestSearchResult[id]));

                this.booking_info.id_guest_info = guest.id_guest;
                this.booking_info.id_discount_code = guest.id_discount;
                this.booking_info.discount_code = guest.discount_code;

                this.booking_info.guest_name = guest.firstname +' '+ guest.lastname;
                this.booking_info.guest_contact_number = guest.contact_number;
                this.booking_info.guest_address = guest.address;
                this.booking_info.guest_email = guest.email;
                this.booking_info.guest_tax_id = guest.tax_id;

                this.booking_info.billing_name = guest.firstname +' '+ guest.lastname;
                this.booking_info.billing_contact_number = guest.contact_number;
                this.booking_info.billing_address = guest.address;
                this.booking_info.billing_email = guest.email;
                this.booking_info.billing_tax_id = guest.tax_id;
                

                this.guestCreditTerm = [
                    {'value': '', 'text': ''},
                    {'value': guest.id_credit, 'text': guest.credit_description}                      
                ];
                this.billingCreditTerm = [
                    {'value': '', 'text': ''},
                    {'value': guest.id_credit, 'text': guest.credit_description}
                ];
                this.booking_info.id_credit = guest.id_credit;
                this.booking_info.credit_term = guest.credit_term;
                this.booking_info.credit_description = guest.credit_description;
                this.calculateDueDate(this.booking_info.check_out_date, this.booking_info.id_credit);
                this.updateBookingPrice();
                $('#searchGuestModal').modal('hide');
            },
            selectBilling: function(id) {
                let biller = JSON.parse(JSON.stringify(this.billingSearchResult[id]));
                /*
                this.booking_info.id_guest_info = guest.id_guest;
                this.booking_info.id_discount_code = guest.id_discount;
                this.booking_info.discount_code = guest.discount_code;

                this.booking_info.guest_name = guest.firstname +' '+ guest.lastname;
                this.booking_info.guest_contact_number = guest.contact_number;
                this.booking_info.guest_address = guest.address;
                this.booking_info.guest_email = guest.email;
                this.booking_info.guest_tax_id = guest.tax_id;
                */

                this.booking_info.billing_name = biller.firstname +' '+ biller.lastname;
                this.booking_info.billing_contact_number = biller.contact_number;
                this.booking_info.billing_address = biller.address;
                this.booking_info.billing_email = biller.email;
                this.booking_info.billing_tax_id = biller.tax_id;
                this.billingCreditTerm = [
                    {'value': '', 'text': ''},
                    {'value': biller.id_credit, 'text': biller.credit_description}
                ];
                this.booking_info.id_credit = biller.id_credit;
                this.booking_info.id_credit = biller.id_credit;
                this.booking_info.credit_term = biller.credit_term;
                this.booking_info.credit_description = biller.credit_description;
                this.calculateDueDate(this.booking_info.check_out_date, this.booking_info.id_credit);
                this.updateBookingPrice();
                $('#searchBillingModal').modal('hide');
            },
            saveBookingInfo: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.booking_info);
                keys.forEach((v) => {
                    if (valid && self.booking_info[v] === '' && !['id_credit', 'credit_description', 'credit_due_date','id_booking', 'booking_number', 'booking_date', 'billing_contact_number', 'billing_address', 'billing_email', 'billing_tax_id', 'guest_tax_id', 'transfer_date', 'transferred_amount', 'balance_amount', 'number_of_adults', 'number_of_children', 'children_age', 'number_of_rooms', 'id_discount_code', 'discount_code', 'discount_type', 'discount_value', 'notes', 'confirm_staff_id'].includes(v)) {
                        valid = false;
                        let e = $('#'+ v);
                        if (e.prop("tagName") == 'BUTTON') {
                            alert("Empty Guest");
                            e.click();
                        } else {
                            alert("Empty "+ v);
                            e.focus();
                        }
                    }
                });
                if (!valid) {
                    return;
                }

                this.booking_payment.forEach((v, i) => {
                    if (valid && v.transfer_slip) {
                        if (!v.transfer_date) {
                            alert("Empty Transfer Date");
                            $('#transfer_date-'+ i).focus();
                            valid = false;
                        } else if (!v.transfer_time) {
                            alert("Empty Transfer Time");
                            $('#transfer_time-'+ i).focus();
                            valid = false;
                        } else if (!v.transferred_amount) {
                            alert("Empty Transfer Amount");
                            $('#transferred_amount-'+ i).focus();
                            valid = false;
                        } else if (v.transfer_date && !validateDate(v.transfer_date)) {
                            alert("Invalid Transfer_Date");
                            $('#transfer_date-'+ i).focus();
                            valid = false;
                        } else if (v.transfer_time && !validateTime(v.transfer_time)) {
                            alert("Invalid Transfer_Time");
                            $('#transfer_time-'+ i).focus();
                            valid = false;
                        }
                    }
                });
                if (!valid) {
                    return;
                }

                current_date = getCurrentDate();
                /*if (!validateDate(this.booking_info.check_in_date) || (this.booking_info.check_in_date < current_date && !['Confirmed', 'Checked-in', 'Checked-out', 'Cancel', 'Expired'].includes(this.old_booking_info.status))) {
                    alert("Invalid Check_In_Date");
                    $('#check_in_date').focus();
                    return;
                }
                if (!validateDate(this.booking_info.check_out_date) || (this.booking_info.check_out_date <= current_date && !['Confirmed', 'Checked-in', 'Checked-out', 'Cancel', 'Expired'].includes(this.old_booking_info.status))) {
                    alert("Invalid Check_Out_Date");
                    $('#check_out_date').focus();
                    return;
                }*/
                if (dateDiff(this.booking_info.check_in_date, this.booking_info.check_out_date) < 1) {
                    alert("Check_In_Date  must less than  Check_Out_Date");
                    $('#check_in_date').focus();
                    return;
                }
                if (this.old_booking_info.status != 'Checked-in' && this.booking_info.status == 'Checked-in' && current_date < this.booking_info.check_in_date) {
                    alert("Can not change booking status to 'Checked-in'\nif Check_In_Date is more than today.");
                    $('#status').focus();
                    return;
                }

                if (this.booking_info.number_of_adults && !isNumber(this.booking_info.number_of_adults)) {
                    alert('# of Adults is invalid');
                    $('#number_of_adults').focus();
                    return;
                }
                if (this.booking_info.number_of_children && !isNumber(this.booking_info.number_of_children)) {
                    alert('# of Children is invalid');
                    $('#number_of_children').focus();
                    return;
                }
                if ((!this.booking_info.number_of_adults || parseInt(this.booking_info.number_of_adults) == 0) && (!this.booking_info.number_of_children || parseInt(this.booking_info.number_of_children) == 0)) {
                    alert('Please fill # of Adults or # of Children');
                    $('#number_of_adults').focus();
                    return;
                }
                if (parseInt(this.booking_info.number_of_children) > 0 && (!this.booking_info.children_age || this.booking_info.number_of_children != this.booking_info.children_age.split(',').length)) {
                    alert('Please fill all children ages');
                    $('#children_age').focus();
                    return;
                }
                if (this.booking_info.children_age && !this.booking_info.number_of_children) {
                    alert('Please fill # of Children');
                    $('#number_of_children').focus();
                    return;
                }
                if (this.booking_info.children_age && !onlyNumbers(this.booking_info.children_age.split(','))) {
                    alert('Children Age is invalid');
                    $('#children_age').focus();
                    return;
                }
                if (getMax(this.booking_info.children_age.split(',').map(Number)) > <?php echo $settings['max_children_age']; ?>) {
                    alert('Children ages exceed setting limit (<?php echo $settings['max_children_age']; ?>).');
                    $('#children_age').focus();
                    return;
                }

                // check rooms
                let tmp_room = [];
                let input_rooms = [];
                let total_capacity_adults = 0;
                let total_capacity_children = 0;

                let rooms_key = Object.keys(this.rooms);
                rooms_key.forEach((k) => {
                    let r = self.rooms[k];
                    if (r.is_selected) {
                        tmp_room.push(JSON.parse(JSON.stringify(r)));
                        input_rooms.push(JSON.parse(JSON.stringify(r)));

                        total_capacity_adults += r.number_of_adults ? parseInt(r.number_of_adults) : 0;
                        total_capacity_children += r.number_of_children ? parseInt(r.number_of_children) : 0;
                    }
                });

                let packages_key = Object.keys(this.packages);
                packages_key.forEach((k) => {
                    let p = self.packages[k];
                    if (p.is_selected) {
                        p.package_item.forEach((r) => {
                            input_rooms.push(JSON.parse(JSON.stringify(r)));

                            total_capacity_adults += r.number_of_adults ? parseInt(r.number_of_adults) * parseInt(r.qty) : 0;
                            total_capacity_children += r.number_of_children ? parseInt(r.number_of_children) * parseInt(r.qty) : 0;
                        });
                    }
                });

                if (input_rooms.length == 0) {
                    alert('Please Select Room');
                    return;
                }

                // get extra_beds qty
                let extra_beds = 0;
                this.extras.forEach((v) => {
                    if (v.is_bed == 1) {
                        extra_beds = this.select_extra_qty[v.id_extras];
                    }
                });

                // check if adults and children fit rooms
                if (parseInt(this.booking_info.number_of_adults) > total_capacity_adults) {
                    if (extra_beds < parseInt(this.booking_info.number_of_adults) - total_capacity_adults) {
                        alert('Total # of booking adults exceed all selected rooms limit.');
                        $('#number_of_adults').focus();
                        return;
                    } else {
                        extra_beds -= parseInt(this.booking_info.number_of_adults) - total_capacity_adults;
                    }
                }

                let remain_children = putChildrenIntoRooms(this.booking_info.children_age.split(','), input_rooms);
                if (extra_beds < remain_children.length) {
                    alert('Total # of booking children exceed all selected rooms limit.');
                    $('#number_of_children').focus();
                    return;
                }

                //////////
                let param = {
                    booking_info: this.booking_info,
                    select_extra: this.select_extra,
                    booking_item: this.booking_item,
                    booking_payment: this.booking_payment,
                    rooms: tmp_room,
                    packages: this.packages
                };
                                
                $.blockUI({css:{'backgroundColor':'#d9d9d9', 'padding-top':'10px'}});
                $.post("<?php echo save_booking_url(); ?>", param, function(res) {
                    console.log(res);
					if (res.result == 'false') {
                        alert(res.message);
                        $.unblockUI();
                        return;
                    } else {
                        alert('Save Booking Success');
                        location.href = "<?php echo edit_booking_url(); ?>"+ res.message;
                    }
                });
                
            },
            updateBookingStatus: function(booking_status) {
                let param = {
                    id_booking: this.booking_info.id_booking,
                    booking_status: booking_status
                };

                $.blockUI({css:{'backgroundColor':'#d9d9d9', 'padding-top':'10px'}});
                $.post("<?php echo update_booking_status_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        $.unblockUI();
                        return;
                    } else {
                        alert('Update Booking To "'+ booking_status +'" Success');
                        location.reload();
                    }
                });
            },
            selectRoom: function(id) {
                if (this.rooms[id]['is_selected']) {
                    this.rooms[id]['is_selected'] = 0;
                } else {
                    this.rooms[id]['is_selected'] = 1;
                }
                this.updateBookingPrice();
            },
            selectPackage: function(id) {
                if (this.packages[id]['is_selected']) {
                    this.packages[id]['is_selected'] = 0;
                    this.packages[id]['package_qty'] = 0;
                } else {
                    let qty = prompt("Please enter Quantity", "1");
                    if (!isNumber(qty) || qty <= 0) {
                        alert("Invalid Quantity");
                        let el = event.target;
                        $(el).prop("checked", false);
                        return;
                    }

                    this.packages[id]['is_selected'] = 1;
                    this.packages[id]['package_qty'] = qty;
                    //this.packages[id]['price'] = this.packages[id]['origin_price'];
                }
                this.updateBookingPrice();
            },
            selectExtra: function(id) {
                if (this.select_extra_qty[id]) {
                    this.select_extra_qty[id] = 0;
                    this.select_extra[id].quantity = 0;
                } else {
                    let extra = '';
                    this.extras.forEach((v) => {
                        if (v.id_extras == id) {
                            extra = JSON.parse(JSON.stringify(v));
                        }
                    });

                    let max = 0;
                    if (extra.is_bed) {
                        let rooms_key = Object.keys(this.rooms);
                        rooms_key.forEach((k) => {
                            let r = this.rooms[k];
                            if (r.is_selected && r.is_big_room) {
                                max += extra.max_qty;
                            }
                        });

                        let packages_key = Object.keys(this.packages);
                        packages_key.forEach((k) => {
                            let p = this.packages[k];
                            if (p.is_selected) {
                                p.package_item.forEach((r) => {
                                    if (r.is_big_room) {
                                        max += extra.max_qty;
                                    }
                                });
                            }
                        });
                    } else {
                        max = extra.max_qty;
                    }

                    let qty = prompt("Please enter Quantity (Max "+ max +")", "1");
                    if (!isNumber(qty) || qty <= 0 || qty > max) {
                        alert("Invalid Quantity");
                        let el = event.target;
                        $(el).prop("checked", false);
                        return;
                    }

                    this.select_extra[id] = {
                        'id_booking': this.booking_info.id_booking,
                        'id_extras': id,
                        'item_name': extra.title_en,
                        'quantity': qty,
                        'full_unit_cost': this.select_extra[id].full_unit_cost ? this.select_extra[id].full_unit_cost : extra.price // extra.price
                    };
                    this.select_extra_qty[id] = qty;
                }

                this.updateBookingPrice();
            },
            updateBookingPrice: function() {
                let self = this;
                
                this.booking_info.discount_code = (this.booking_info.discount_code != null) ? this.booking_info.discount_code.trim() : '';
                
                let param = {
                    booking: this.booking_info,
                    booking_item: this.old_booking_item,
                    rooms: this.rooms,
                    packages: this.packages,
                    extras: this.select_extra
                };

                $.post("<?php echo calculate_booking_price_url(); ?>", param, function(res) {

                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        self.booking_info.sub_total = res.message.sub_total;
                        self.booking_info.vat = res.message.vat;
                        self.booking_info.grand_total = res.message.grand_total;
                        self.booking_info.discounted_amount = res.message.discounted_amount;
                        self.booking_item = res.message.booking_item;
                        self.sumSlip();
                    }
                });
            },
            sortRoom: function() {
                let tmp = Object.values(this.rooms);
                tmp.sort(function(a, b) {
                    if (a.id_project_info != b.id_project_info) {
                        return parseInt(a.id_project_info) - parseInt(b.id_project_info);
                    } else {
                        if (a.display_sequence != b.display_sequence) {
                            return parseInt(a.display_sequence) - parseInt(b.display_sequence);
                        } else {
                            return a.room_number.localeCompare(b.room_number);
                        }
                    }
                });
                return tmp;
            },
            sortPackage: function() {
                let tmp = Object.values(this.packages);
                tmp.sort(function(a, b) {
                    if (a.id_project_info != b.id_project_info) {
                        return parseInt(a.id_project_info) - parseInt(b.id_project_info);
                    } else {
                        if (a.name != b.name) {
                            return a.name.localeCompare(b.name);
                        }
                    }
                });
                return tmp;
            },
            viewBooking: function(id) {
                <?php if (has_permission('booking', 'view')) : ?>
                window.open("<?php echo show_invoice_url(); ?>"+ id, '_blank').focus();
                <?php endif; ?>
            },
            addSlip: function() {
                let self = this;
                tmp = JSON.parse(JSON.stringify(this.booking_payment_blank_row));
                this.booking_payment.push(tmp);

                this.booking_payment.forEach((v, i) => {
                    setTimeout(() => {
                        $('#transfer_date-'+ i).datepicker({
                            dateFormat: "dd/mm/yy",
                            onSelect: function(d) {
                                self.booking_payment[i].transfer_date = convertDateDash(d);
                            }
                        });
                    }, 100);
                });
            },
            removeSlip: function(id) {
                let self = this;
                tmp = [];
                this.booking_payment.forEach((v, i) => {
                    if (i != id) {
                        tmp.push(JSON.parse(JSON.stringify(v)));
                    }
                });
                this.booking_payment = JSON.parse(JSON.stringify(tmp));

                this.booking_payment.forEach((v, i) => {
                    setTimeout(() => {
                        $('#transfer_date-'+ i).datepicker({
                            dateFormat: "dd/mm/yy",
                            onSelect: function(d) {
                                self.booking_payment[i].transfer_date = convertDateDash(d);
                            }
                        });
                    }, 100);
                });

                this.sumSlip();
            },
            sumSlip: function() {
                let sum = 0;
                this.booking_payment.forEach((v) => {
                    sum += parseFloat(v.transferred_amount ? v.transferred_amount : 0);
                });

                this.booking_info.transferred_amount = sum;
                this.booking_info.balance_amount = this.booking_info.grand_total - sum;
            },
            calculateDueDate: function(date, id) {
                if (id != '') {
                    var index = this.credit.findIndex(c => c.id_credit == id);
                    var days = this.credit[index].credit_term;
                    this.booking_info.credit_due_date = add_days_to_date (date, days);
                }
            }
        }
    });

    $(document).on('shown.bs.modal', '#searchGuestModal', function (e) {
        $('#searchGuestInput').focus();
    });

    $(document).on('change', '.image-input', function() {
        let self = $(this);
        let id = $(this).attr('id');

        const reader = new FileReader();
        reader.addEventListener("load", () => {
            const uploaded_image = reader.result;

            if (self.hasClass('image-input-slip')) {
                let ids = id.split('-');
                app.booking_payment[ids[ids.length - 1]].transfer_slip = uploaded_image;
                $('#display-'+ id +' img').attr('src', uploaded_image);
            }
        });
        reader.readAsDataURL(this.files[0]);
    });
});
</script>