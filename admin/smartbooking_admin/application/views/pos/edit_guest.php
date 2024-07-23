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
                            <a href="<?php echo guest_url(); ?>"><?= _r('Guest', 'ผู้เข้าพัก'); ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo edit_guest_url($guest['id_guest']); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"><?= _r('Edit Discount', 'แก้ไขส่วนลด'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <?php if (has_permission('guest', 'edit')) : ?>
                    <button class="btn btn-sm" style="float:right; font-size:13px; background-color:#0275d8; color:white; margin-bottom:20px;" @click="loadEditDiscount(0)"><?= _r('Add New Discount', 'เพิ่มส่วนลดใหม่'); ?></button>
                    <?php endif; ?>
                    <div style="width:100%; overflow:auto;">
                        <table id="discountTable" class="display" style="width:99%;">
                            <thead>
                                <tr>
                                    <th style="width:100px; min-width:100px;">Title</th>
                                    <th style="width:50px; min-width:50px;"><?= _r('Code', 'โค้ด'); ?></th>
                                    <th style="width:50px; min-width:50px;"><?= _r('Can Booking Between', 'ช่วงเวลาที่กดใช้ได้'); ?></th>
                                    <th style="width:50px; min-width:50px;"><?= _r('Can Check-in Between', 'ช่วงเวลาที่ใช้เข้าพักได้'); ?></th>
                                    <th><?= _r('Discount', 'มูลค่าส่วนลด'); ?></th>
                                    <th style="width:100px; min-width:100px;"><?= _r('Note', 'หมายเหตุ'); ?></th>
                                    <?php if (has_permission('guest', 'edit') || has_permission('guest', 'delete')) : ?>
                                    <th style="width:60px; min-width:60px; font-size:13px; font-weight:normal;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="d in shift_json(discount)">
                                    <td class="text-left">{{ <?= _r('d.title_en', 'd.title_th'); ?> }}</td>
                                    <td class="text-center">{{ d.code }}</td>
                                    <td class="text-center">{{ convertDateSlash(d.start_date_booking) }}<br>-<br>{{ convertDateSlash(d.end_date_booking) }}</td>
                                    <td class="text-center">{{ convertDateSlash(d.start_date_check_in) }}<br>-<br>{{ convertDateSlash(d.end_date_check_in) }}</td>
                                    <td class="text-right">{{ d.discount_type == 'percent' ? (d.discount_value +'%') : ('฿'+ formatBaht(d.discount_value)) }}</td>
                                    <td class="text-right">{{ d.note }}</td>

                                    <?php if (has_permission('guest', 'edit') || has_permission('guest', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('guest', 'edit')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="loadEditDiscount(d.id_discount)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('guest', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteDiscount(d.id_discount)">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editDiscountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">{{ edit_discount.id_discount == 0 ? '<?= _r('Add', 'เพิ่ม'); ?>' : '<?= _r('Update', 'แก้ไข'); ?>' }}<?= _r(' Discount', 'ส่วนลด'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> Title <?= _r('EN', 'ภาษาอังกฤษ'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_discount.title_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> Title <?= _r('TH', 'ภาษาไทย'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_discount.title_th">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Code', 'โค้ด'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_discount.code">
                            </div>
                            <div class="col-md-6">
                                <small><?= _r('Note', 'หมายเหตุ'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_discount.note">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Start Date Booking', 'ใช้ได้ตั้งแต่วันที่'); ?></small>
                                <input type="text" id="start_date_booking" class="form-control" style="margin-top:-3px;" :value="convertDateSlash(edit_discount.start_date_booking)">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('End Date Booking', 'ใช้ได้ถึงวันที่'); ?></small>
                                <input type="text" id="end_date_booking" class="form-control" style="margin-top:-3px;" :value="convertDateSlash(edit_discount.end_date_booking)">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Start Date Check-in', 'เข้าพักได้ตั้งแต่วันที่'); ?></small>
                                <input type="text" id="start_date_check_in" class="form-control" style="margin-top:-3px;" :value="convertDateSlash(edit_discount.start_date_check_in)">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('End Date Check-in', 'เข้าพักได้ถึงวันที่'); ?></small>
                                <input type="text" id="end_date_check_in" class="form-control" style="margin-top:-3px;" :value="convertDateSlash(edit_discount.end_date_check_in)">
                            </div>
                        </div>
                        <div class="row" style="margin-top:5px;">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Discount Type', 'รูปแบบส่วนลด'); ?></small>
                                <select class="form-control" style="margin-top:-3px;" v-model="edit_discount.discount_type">
                                    <option value="percent">percent</option>
                                    <option value="amount">amount</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Discount Value', 'มูลค่าส่วนลด'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_discount.discount_value">
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="saveDiscount()">{{ edit_discount.id_discount == 0 ? '<?= _r('Add', 'เพิ่ม'); ?>' : '<?= _r('Update', 'แก้ไข'); ?>' }}</button>
                            </div>
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
                <!-- Guest Info -->
                <div class="col-md-12">
                    <!-- Button trigger modal -->
                    <?php if (has_permission('guest', 'view')) : ?>
                    <button class="btn" data-toggle="modal" data-target="#discountModal" style="float:right; width:120px; height:30px; line-height:9px; background-color:#0275d8; color:white;"><?= _r('Edit Discount', 'จัดการส่วนลด'); ?></button>
                    <?php endif; ?>
                    <div class="col-md-11" style="margin-top:50px;">
						<div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Fullname', 'Fullname'); ?></small>
                                <input type="text" class="form-control" v-model="guest.name">
                            </div>
                            
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('First Name', 'ชื่อ'); ?></small>
                                <input type="text" class="form-control" v-model="guest.firstname">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Last Name', 'นามสกุล'); ?></small>
                                <input type="text" class="form-control" v-model="guest.lastname">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Username', 'ยูสเซอร์เนม'); ?></small>
                                <input type="text" rows="3" class="form-control" v-model="guest.username">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Password', 'รหัสผ่าน'); ?></small>
                                <input type="text" rows="3" class="form-control" v-model="guest.password" disabled v-if="guest.id_guest">
                                <input type="text" rows="3" class="form-control" v-model="guest.password" v-else>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><!--<font color="red">*</font>--> <?= _r('Email', 'อีเมล'); ?></small>
                                <input type="text" class="form-control" v-model="guest.email">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Contact number', 'เบอร์โทรติดต่อ'); ?></small>
                                <input type="text" class="form-control" id="phone" v-model="guest.contact_number">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><!--<font color="red">*</font>--> <?= _r('Birthday', 'วันเกิด'); ?></small>
                                <input type="text" id="birthday" class="form-control" :value="convertDateSlash(guest.birthday)">
                            </div>
                            <div class="col-md-6">
                                <!--<small><font color="red">*</font> <?= _r('Gender', 'เพศ'); ?></small>-->
                                <select class="form-control" v-model="guest.gender">
                                    <option value="male"><?= _r('Male', 'ชาย'); ?></option>
                                    <option value="female"><?= _r('Female', 'หญิง'); ?></option>
                                    <option value="other"><?= _r('Other', 'ไม่ระบุ'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><!--<font color="red">*</font>--> <?= _r('Address', 'ที่อยู่'); ?></small>
                                <textarea class="form-control" v-model="guest.address"></textarea>
                            </div>
                            <div class="col-md-6">
                                <small><?= _r('Tax ID', 'หมายเลขประจำตัวผู้เสียภาษี'); ?></small>
                                <input type="text" class="form-control" v-model="guest.tax_id">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-6">
                                <small><?= _r('Discount', 'ส่วนลด'); ?></small>
                                <select class="form-control" v-model="guest.id_discount">
                                    <option v-for="d in discount" :value="d.id_discount">{{ d.code+ ((d.title_en != '') ? ' ('+d.title_en+') ' : '' ) + check_expired(d.end_date_booking) }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Status', 'สถานะ'); ?></small>
                                <select class="form-control" v-model="guest.is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-6">
                                <small><?= _r('Credit Term', 'Credit Term'); ?></small>
                                <select class="form-control" v-model="guest.id_credit">
                                    <option v-for="c in credit" :value="c.id_credit">{{ c.credit_description }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" id="url-image-input-guest" v-model="guest.photo_url">
                                <input type="file" style="display:none;" class="image-input image-input-guest" id="image-input-guest" accept="image/jpeg, image/png, image/jpg">
                                <div style="width:150px !important;">
                                    <small><?= _r('Photo', 'รูปภาพ'); ?></small>
                                    <div class="display-image" id="display-image-input-guest">
                                        <img :src="guest.photo_url ? guest.photo_url : '<?php echo site_url(); ?>asset/image/upload.jpg'" style="margin-top:-1px; height:77px;">
                                    </div>
                                </div>
                                <div style="width:150px !important;">
                                    <button style="background-color:black; color:white;" @click="uploadImage('guest')">Browse...</button>
                                </div>
                            </div>
                        </div>

                        <?php if (has_permission('guest', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="saveGuest()"><?php echo empty($guest['id_guest']) ? _r('Add', 'เพิ่ม') : _r('Update', 'แก้ไข'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: '<?php echo empty($guest['id_guest']) ? _r("Add Guest", "เพิ่มผู้เข้าพัก") : _r("Update Guest", "แก้ไขผู้เข้าพัก"); ?>',
            guest: <?php echo empty($guest) ? '{}' : json_encode($guest); ?>,
            edit_discount: {},
            discount: <?php echo empty($discount) ? '{}' : json_encode($discount); ?>,
            credit: <?php echo empty($credit) ? '{}' : json_encode($credit); ?>,
        },
        mounted() {
            let self = this;

            $("#birthday").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.guest.birthday = convertDateDash(d);
                }
            });
            $("#start_date_booking").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.edit_discount.start_date_booking = convertDateDash(d);
                }
            });
            $("#end_date_booking").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.edit_discount.end_date_booking = convertDateDash(d);
                }
            });
            $("#start_date_check_in").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.edit_discount.start_date_check_in = convertDateDash(d);
                }
            });
            $("#end_date_check_in").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.edit_discount.end_date_check_in = convertDateDash(d);
                }
            });

            $("#phone").inputmask({"mask": "999-999-9999"});

            $("#discountTable").DataTable();
        },
        methods: {
            uploadImage: function(id) {
                $('#image-input-'+ id).trigger('click');
            },
            saveGuest: function() {
				//console.log(this);
                let self = this;
                this.guest.contact_number = $("#phone").val();
                this.guest.name = this.guest.firstname +' '+ this.guest.lastname;

                var valid = true;
                var keys = Object.keys(this.guest);
				//console.log(keys);
				//console.log(self.guest);
                keys.forEach((v) => {
					if (valid && ['firstname', 'lastname', 'username', 'password', 'contact_number'].includes(v) && self.guest[v] === '') {
                    //if (valid && !['date_created', 'id_guest', 'photo_url', 'tax_id', ''].includes(v) && self.guest[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
				
                if (!valid) {
                    return;
                }

                if (!validateEmail(this.guest.email) && this.guest.email !== '') {
                    alert("Invalid Email");
                    return;
                }
				if (valid) {
                    $.post("<?php echo save_guest_url(); ?>", this.guest, function(res) {
						if (res.result == 'false') {
							alert(res.message);
							return;
						} else {
							alert('Save Guest Success');
							location.href = "<?php echo edit_guest_url(); ?>"+ res.message;
						}
					});
                }
                //
				
            },
            loadEditDiscount: function(id) {
                let self = this;
                this.discount.forEach((v) => {
                    if (v.id_discount == id) {
                        self.edit_discount = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editDiscountModal').modal('show');
            },
            deleteDiscount: function(id) {
                if (confirm("Delete this Discount ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_discount_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Discount Success');
                            location.reload();
                        }
                    });
                }
            },
            saveDiscount: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.edit_discount);
                keys.forEach((v) => {
                    if (valid && v != 'note' && self.edit_discount[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                $.post("<?php echo save_discount_url(); ?>", this.edit_discount, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Discount Success');
                        location.reload();
                    }
                });
            },
            check_expired: function(expiry_date) {
                const date_today_time = new Date().getTime();
                var expiry_date_time = new Date(expiry_date).getTime();
                console.log(date_today_time + ' ' + expiry_date_time);
                if (expiry_date != '' && date_today_time > expiry_date_time) {
                    return 'EXPIRED';
                }
                else {
                    return '';
                }
            },
        }
    });

    $(document).on('change', '.image-input', function() {
        let self = $(this);
        let id = $(this).attr('id');

        const reader = new FileReader();
        
		reader.addEventListener("load", () => {
            const uploaded_image = reader.result;

            if (self.hasClass('image-input-guest')) {
                app.guest.photo_url = uploaded_image;
            }
        });
        reader.readAsDataURL(this.files[0]);
    });
});
</script>