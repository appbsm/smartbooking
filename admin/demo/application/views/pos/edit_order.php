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
                        <li class="breadcrumb-item"><?= _r('POS', 'จัดการออเดอร์'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo order_url(); ?>"><?= _r('Order', 'ออเดอร์'); ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo edit_order_url($order_info['id_order']); ?>">
                                {{ menu }}{{ order_info.id_order ? (' ('+ order_info.order_number +')') : '' }}
                            </a>
                            <?php if (has_permission('order', 'view') && !empty($order_info['id_order'])) : ?>
                            <button class="btn btn-sm btn-info" style="margin-left:8px; margin-top:-2px;" @click="viewOrder(<?php echo $order_info['id_order']; ?>)">
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
    <div class="modal fade" id="showTransferSlipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2"><?= _r('Transfer Slip', 'สลิปโอนเงิน'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="row">
                        <div class="col-md-12">
                            <img :src="show_transfer_slip" style="width:100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Order Info -->
                <div class="col-md-12">
                    <div class="row" style="margin-top:-5px">
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('Guest Name', 'ชื่อผู้ใช้บริการ'); ?></small>
                            <input type="text" style="width:100%; float:left;" class="form-control" v-model="order_info.billing_name" v-if="disable">
                            <div style="overflow:hidden; white-space:nowrap;" v-else>
                                <input type="text" style="width:calc(100% - 38px); float:left;" class="form-control" v-model="order_info.billing_name">
                                <button style="border-radius:0px; width:38px; height:38px; float:left;" class="btn btn-sm btn-secondary" id="id_guest_info" data-toggle="modal" data-target="#searchGuestModal"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Guest Contact Number', 'เบอร์โทรติดต่อผู้ใช้บริการ'); ?></small>
                            <input type="text" class="form-control" v-model="order_info.billing_contact_number">
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Guest Address', 'ที่อยู่ผู้ใช้บริการ'); ?></small>
                            <input type="text" class="form-control" v-model="order_info.billing_address">
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-4">
                            <small><?= _r('Guest Email', 'อีเมลผู้ใช้บริการ'); ?></small>
                            <input type="text" class="form-control" v-model="order_info.billing_email">
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Guest Tax ID', 'Tax ID ผู้ใช้บริการ'); ?></small>
                            <input type="text" class="form-control" v-model="order_info.billing_tax_id">
                        </div>
                        <div class="col-md-4">
                            <small><?= _r('Notes', 'หมายเหตุ'); ?></small>
                            <input type="text" class="form-control" v-model="order_info.notes">
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('Project', 'โปรเจกต์'); ?></small>
                            <select class="form-control" v-model="order_info.id_project_info" id="id_project_info" :disabled="disable == 1">
                                <option :value="p.id_project_info" v-for="p in projects">{{ p.project_name_en }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('Service Date', 'วันที่ใช้บริการ'); ?></small>
                            <input type="text" class="form-control" id="order_date" :value="convertDateSlash(order_info.order_date)" :disabled="disable == 1">
                        </div>
                        <div class="col-md-4">
                            <small><font color="red">*</font> <?= _r('Order Status', 'สถานะ Order'); ?></small>
                            <select class="form-control" v-model="order_info.status" id="status" :disabled="disable == 1">
                                <option value="Ordered" v-if="!order_info.id_order || old_order_info.status == 'Ordered'">Ordered</option>
                                <option value="Verifying" v-if="!order_info.id_order || ['Ordered', 'Verifying'].includes(old_order_info.status)">Verifying</option>
                                <option value="Confirmed" v-if="!order_info.id_order || ['Ordered', 'Verifying', 'Confirmed'].includes(old_order_info.status)">Confirmed</option>
                                <option value="Closed" v-if="['Confirmed', 'Closed'].includes(old_order_info.status)">Closed</option>
                                <option value="Cancel" v-if="order_info.id_order">Cancel</option>
                                <option value="Expired" v-if="old_order_info.status == 'Expired'">Expired</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-4">
                            <small><?= _r('Booking', 'Booking'); ?></small>
                            <select class="form-control" v-model="order_info.id_booking" :disabled="disable == 1">
                                <option value=""></option>
                                <option :value="b.id_booking" v-for="b in bookings">{{ b.booking_number }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Extra -->
                <div class="col-md-12" style="margin-top:20px;">
                    <u><b>Extra</b></u>
                    <div class="row" style="margin-top:-10px">
                        <span class="col-md-2" v-for="(e, i) in extras" style="margin-top:20px;">
                            <input type="checkbox" class="form-control test" style="width:17px; height:17px; display:inline-block; vertical-align:top;" @click="selectExtra(e.id_extras, $event)" :checked='select_extra[e.id_extras]' :disabled="disable == 1">
                            <span style="width:calc(100% - 25px); display:inline-block; height:50px; font-size:14px; overflow:hidden; text-overflow:ellipsis; margin-left:5px; position:absolute; top:-2px;">
                                {{ <?= _r('e.title_en', 'e.title_th'); ?> }}<span v-show="select_extra_qty[e.id_extras] > 0"> ({{ select_extra_qty[e.id_extras] }})</span>
                            </span>
                        </span>
                    </div>
                </div>

                <!-- Price -->
                <div class="col-md-12" style="margin-top:-5px;">
                    <hr style="border:none; border-bottom:1px solid #bbbbbb;">
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-4 offset-md-8">
                            <div class="row" style="margin-top:-10px;">
                                <div class="col-md-10" style="overflow:hidden; white-space:nowrap;"><b><font color="green"><?= _r('Total', 'ยอดรวม'); ?></font></b></div>
                                <div class="col-md-2 text-right" style="overflow:hidden; white-space:nowrap;"><b><u><font color="green">{{ formatBaht(order_info.grand_total) }}</font></u></b></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr style="margin-top:8px;">
                                </div>
                            </div>
                            <div class="row" style="font-size:13px; margin-top:-13px;">
                                <div class="col-md-10" style="overflow:hidden; white-space:nowrap;">(<?= _r('VAT', 'ภาษีมูลค่าเพิ่ม'); ?>)</div>
                                <div class="col-md-2 text-right" style="overflow:hidden; white-space:nowrap;">{{ formatBaht(order_info.vat) }}</div>
                            </div>
                            <div class="row" style="font-size:13px;">
                                <div class="col-md-10" style="overflow:hidden; white-space:nowrap;">(<?= _r('Sub Total', 'ยอดก่อนรวมภาษีมูลค่าเพิ่ม'); ?>)</div>
                                <div class="col-md-2 text-right" style="overflow:hidden; white-space:nowrap;">{{ formatBaht(order_info.sub_total) }}</div>
                            </div>
                        </div>
                    </div>
                    <hr style="border:none; border-bottom:1px solid #bbbbbb; margin-top:2px;">
                </div>

                <!-- Payment -->
                <span class="col-md-12" style="text-align:right;">
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-3 offset-md-8" style="margin-bottom:20px;">
                            <div class="col-md-12">
                                <div class="row" style="font-size:13px; margin-top:-13px;">
                                    <div class="col-md-8" style="overflow:hidden; white-space:nowrap;">(<?= _r('Total Transfer', 'ยอดเงินที่ชำระแล้ว'); ?>)</div>
                                    <div class="col-md-4 text-right" style="overflow:hidden; white-space:nowrap;">{{ formatBaht(order_info.transferred_amount) }}</div>
                                </div>
                                <div class="row" style="font-size:13px;">
                                    <div class="col-md-8" style="overflow:hidden; white-space:nowrap;">(<?= _r('Balance', 'ยอดค้างชำระ'); ?>)</div>
                                    <div class="col-md-4 text-right" style="overflow:hidden; white-space:nowrap;">{{ formatBaht(order_info.balance_amount) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1" v-if="!disable">
                            <button class="btn btn-sm btn-warning" style="width:100%; font-size:13px; margin-top:-18px;" @click="addSlip()"><?= _r('Add Slip', 'เพิ่มสลิป'); ?></button>
                        </div>
                    </div>
                </span>
                <div class="col-md-12" style="margin-top:5px;" v-for="(p, i) in order_payment">
                    <div class="row">
                        <div class="col-md-2">
                            <input type="hidden" :id="'url-image-input-slip-'+ i" v-model="p.transfer_slip">
                            <input type="file" style="display:none;" class="image-input image-input-slip" :id="'image-input-slip-'+ i" accept="image/jpeg, image/png, image/jpg">
                            <div style="width:150px !important;">
                                <small><?= _r('Transfer Slip', 'สลิปโอนเงิน'); ?></small>
                                <div class="display-image" :id="'display-image-input-slip-'+ i">
                                    <img :src="p.transfer_slip ? p.transfer_slip : '<?php echo site_url(); ?>asset/image/upload.jpg'" style="margin-top:-1px; height:77px; cursor:zoom-in;" data-toggle="modal" data-target="#showTransferSlipModal" @click="showSlip(p)">
                                </div>
                            </div>
                            <div style="width:150px !important;">
                                <button style="background-color:black; color:white;" @click="uploadImage('slip-'+ i)" v-if="!disable">Browse...</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <small><?= _r('Transfer Date', 'วันโอนเงิน'); ?></small>
                            <input type="text" class="form-control" :id="'transfer_date-'+ i" :value="convertDateSlash(p.transfer_date)" :disabled="disable == 1">
                        </div>
                        <div class="col-md-3">
                            <small><?= _r('Transfer Time (XX:XX or XX.XX)', 'เวลาโอนเงิน (XX:XX หรือ XX.XX)'); ?></small>
                            <input type="text" class="form-control" v-model="p.transfer_time" :id="'transfer_time-'+ i" :disabled="disable == 1">
                        </div>
                        <div class="col-md-3">
                            <small><?= _r('Transfer Amount', 'ยอดโอนเงิน'); ?></small>
                            <input type="number" class="form-control" v-model="p.transferred_amount" :id="'transferred_amount-' + i" :disabled="disable == 1" @change="sumSlip()">
                        </div>
                        <?php if (has_permission('order', 'delete')) : ?>
                        <div class="col-md-1" style="text-align:center">
                            <button class="btn btn-sm btn-danger" style="padding:0px 5px 0px 5px; margin-top:31px;" @click="removeSlip(i)" v-if="!disable">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Save, Check-in, Check-out -->
                <?php if (has_permission('order', 'edit')) : ?>
                <div class="col-md-12">
                    <div class="row" style="margin-top:15px">
                        <div class="col-md-12" style="text-align:center">
                            <button class="btn" style="width:200px; height:34.5px; line-height:9px; background-color:#809f4e; color:white;" @click="saveOrderInfo()"><?= _r('Save', 'บันทีก'); ?></button>
                        </div>
                    </div>
                </div>
                <!-- Close -->
                <?php if (!empty($order_info['status']) && $order_info['status'] == 'Confirmed') : ?>
                <div class="col-md-12">
                    <div class="row" style="margin-top:15px">
                        <div class="col-md-12" style="text-align:center">
                            <button class="btn" style="width:200px; height:34.5px; line-height:9px; background-color:#ff8c1a; color:white;" @click="updateOrderStatus('Closed')">
                                Close <i class="fa fa-sign-out-alt"></i>
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

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: '<?php echo empty($order_info['id_order']) ? _r("Add Order", "เพิ่มออเดอร์") : _r("Update Order", "แก้ไขออเดอร์"); ?>',
            old_order_info: <?php echo empty($order_info) ? '{}' : json_encode($order_info); ?>,
            order_info: <?php echo empty($order_info) ? '{}' : json_encode($order_info); ?>,
            extras: <?php echo empty($extras) ? '{}' : json_encode($extras); ?>,
            select_extra: <?php echo empty($select_extra) ? '{}' : json_encode($select_extra); ?>,
            select_extra_qty: <?php echo empty($select_extra_qty) ? '{}' : json_encode($select_extra_qty); ?>,
            searched: false,
            guestSearchQuery: '',
            guestSearchResult: {},
            order_item: <?php echo empty($order_item) ? '{}' : json_encode($order_item); ?>,
            order_payment: <?php echo empty($order_payment) ? '[]' : json_encode($order_payment); ?>,
            order_payment_blank_row: <?php echo empty($order_payment_blank_row) ? '{}' : json_encode($order_payment_blank_row); ?>,
            projects: <?php echo empty($projects) ? '[]' : json_encode($projects); ?>,
            bookings: <?php echo empty($bookings) ? '[]' : json_encode($bookings); ?>,
            disable: <?php echo in_array($order_info['status'], array('Confirmed', 'Closed', 'Cancel', 'Expired')) ? 1 : 0; ?>,
            show_transfer_slip: ''
        },
        mounted() {
            let self = this;

            $("#order_date").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.order_info.order_date = convertDateDash(d);
                }
            });

            this.order_payment.forEach((v, i) => {
                $('#transfer_date-'+ i).datepicker({
                    dateFormat: "dd/mm/yy",
                    onSelect: function(d) {
                        self.order_payment[i].transfer_date = convertDateDash(d);
                    }
                });
            });
        },
        methods: {
            showSlip: function(p) {
                this.show_transfer_slip = p.transfer_slip;
            },
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
            selectGuest: function(id) {
                let guest = JSON.parse(JSON.stringify(this.guestSearchResult[id]));
                this.bookings = guest.bookings;
                this.order_info.id_booking = '';
                this.order_info.id_guest_info = guest.id_guest;

                this.order_info.guest_name = guest.firstname +' '+ guest.lastname;
                this.order_info.guest_contact_number = guest.contact_number;
                this.order_info.guest_address = guest.address;
                this.order_info.guest_email = guest.email;
                this.order_info.guest_tax_id = guest.tax_id;

                this.order_info.billing_name = guest.firstname +' '+ guest.lastname;
                this.order_info.billing_contact_number = guest.contact_number;
                this.order_info.billing_address = guest.address;
                this.order_info.billing_email = guest.email;
                this.order_info.billing_tax_id = guest.tax_id;

                this.updateOrderPrice();
                $('#searchGuestModal').modal('hide');
            },
            saveOrderInfo: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.order_info);
                keys.forEach((v) => {
                    if (valid && self.order_info[v] === '' && !['id_order', 'order_number', 'id_booking', 'date_created', 'billing_contact_number', 'billing_address', 'billing_email', 'billing_tax_id', 'guest_tax_id', 'transfer_date', 'notes'].includes(v)) {
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

                this.order_payment.forEach((v, i) => {
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
                if (!validateDate(this.order_info.order_date) || (this.order_info.order_date < current_date && !['Confirmed', 'Closed', 'Cancel', 'Expired'].includes(this.old_order_info.status))) {
                    alert("Invalid Service Date");
                    $('#order_date').focus();
                    return;
                }

                if (this.order_item.length == 0) {
                    alert("Please select item");
                    return;
                }

                //////////
                let param = {
                    order_info: this.order_info,
                    select_extra: this.select_extra,
                    order_item: this.order_item,
                    order_payment: this.order_payment
                };

                $.blockUI({css:{'backgroundColor':'#d9d9d9', 'padding-top':'10px'}});
                $.post("<?php echo save_order_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        $.unblockUI();
                        return;
                    } else {
                        alert('Save Order Success');
                        location.href = "<?php echo edit_order_url(); ?>"+ res.message;
                    }
                });
            },
            updateOrderStatus: function(order_status) {
                let param = {
                    id_order: this.order_info.id_order,
                    order_status: order_status
                };

                $.blockUI({css:{'backgroundColor':'#d9d9d9', 'padding-top':'10px'}});
                $.post("<?php echo update_order_status_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        $.unblockUI();
                        return;
                    } else {
                        alert('Update Order To "'+ order_status +'" Success');
                        location.reload();
                    }
                });
            },
            selectExtra: function(id) {
                if (this.select_extra[id]) {
                    this.select_extra[id] = 0;
                    this.select_extra_qty[id] = 0;
                } else {
                    let extra = '';
                    this.extras.forEach((v) => {
                        if (v.id_extras == id) {
                            extra = JSON.parse(JSON.stringify(v));
                        }
                    });

                    let max = extra.max_qty;
                    let qty = prompt("Please enter Quantity (Max "+ max +")", "1");
                    if (!isNumber(qty) || qty <= 0 || qty > max) {
                        alert("Invalid Quantity");
                        let el = event.target;
                        $(el).prop("checked", false);
                        return;
                    }

                    this.select_extra[id] = {
                        'id_order': this.order_info.id_order,
                        'id_extras': id,
                        'item_name': extra.title_en,
                        'quantity': qty,
                        'unit_cost': this.select_extra[id].unit_cost ? this.select_extra[id].unit_cost : extra.price // extra.price
                    };
                    this.select_extra_qty[id] = qty;
                }

                this.updateOrderPrice();
            },
            updateOrderPrice: function(action = '') {
                let self = this;
                let param = {
                    order: this.order_info,
                    order_item: this.select_extra
                };

                $.post("<?php echo calculate_order_price_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        self.order_info.sub_total = res.message.sub_total;
                        self.order_info.vat = res.message.vat;
                        self.order_info.grand_total = res.message.grand_total;
                        self.order_item = res.message.order_item;
                        self.sumSlip();
                    }
                });
            },
            viewOrder: function(id) {
                <?php if (has_permission('order', 'view')) : ?>
                window.open("<?php echo show_order_url(); ?>"+ id, '_blank').focus();
                <?php endif; ?>
            },
            addSlip: function() {
                let self = this;
                tmp = JSON.parse(JSON.stringify(this.order_payment_blank_row));
                this.order_payment.push(tmp);

                this.order_payment.forEach((v, i) => {
                    setTimeout(() => {
                        $('#transfer_date-'+ i).datepicker({
                            dateFormat: "dd/mm/yy",
                            onSelect: function(d) {
                                self.order_payment[i].transfer_date = convertDateDash(d);
                            }
                        });
                    }, 100);
                });
            },
            removeSlip: function(id) {
                let self = this;
                tmp = [];
                this.order_payment.forEach((v, i) => {
                    if (i != id) {
                        tmp.push(JSON.parse(JSON.stringify(v)));
                    }
                });
                this.order_payment = JSON.parse(JSON.stringify(tmp));

                this.order_payment.forEach((v, i) => {
                    setTimeout(() => {
                        $('#transfer_date-'+ i).datepicker({
                            dateFormat: "dd/mm/yy",
                            onSelect: function(d) {
                                self.order_payment[i].transfer_date = convertDateDash(d);
                            }
                        });
                    }, 100);
                });

                this.sumSlip();
            },
            sumSlip: function() {
                let sum = 0;
                this.order_payment.forEach((v) => {
                    sum += parseFloat(v.transferred_amount ? v.transferred_amount : 0);
                });

                this.order_info.transferred_amount = sum;
                this.order_info.balance_amount = this.order_info.grand_total - sum;
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
                app.order_payment[ids[ids.length - 1]].transfer_slip = uploaded_image;
            }
        });
        reader.readAsDataURL(this.files[0]);
    });
});
</script>