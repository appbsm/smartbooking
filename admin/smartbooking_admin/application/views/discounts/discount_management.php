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
                        <li class="breadcrumb-item"><?= _r('Setting', 'การตั้งค่า'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo discount_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="editDiscountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ edit_discount.id_discount == 0 ? '<?= _r('Add', 'เพิ่ม'); ?>' : '<?= _r('Update', 'แก้ไข'); ?>' }}<?= _r(' Discount', 'ส่วนลด'); ?></h5>
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
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="edit_discount.discount_value">
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
                <div class="col-md-10 offset-md-1">
                    <?php if (has_permission('discount_management', 'edit')) : ?>
                    <span style="width:100%;">
                        <button class="btn" style="float:right; width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;" @click="loadEditDiscount(0)">
                            <?= _r('Add New Discount', 'เพิ่มส่วนลดใหม่'); ?>
                        </button>
                    </span>
                    <?php endif; ?>

                    <div style="width:100%; overflow:auto;">
                        <table id="discountTable" class="display" style="width:99%;">
                            <thead>
                                <tr>
                                    <th class="w200">Title</th>
                                    <th class="w150"><?= _r('Code', 'โค้ด'); ?></th>
                                    <th class="w150"><?= _r('Can Booking Between', 'ช่วงเวลาที่กดใช้ได้'); ?></th>
                                    <th class="w150"><?= _r('Can Check-in Between', 'ช่วงเวลาที่ใช้เข้าพักได้'); ?></th>
                                    <th class="w50"><?= _r('Discount', 'มูลค่าส่วนลด'); ?></th>
                                    <th><?= _r('Note', 'หมายเหตุ'); ?></th>
                                    <?php if (has_permission('discount_management', 'edit') || has_permission('discount_management', 'delete')) : ?>
                                    <th class="w70"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="d in shift_json(discount)">
                                    <td class="text-left">{{ <?= _r('d.title_en', 'd.title_th'); ?> }}</td>
                                    <td class="text-center">{{ d.code }}</td>
                                    <td class="text-center" :data-order="d.start_date_booking +' '+ d.end_date_booking">{{ convertDateSlash(d.start_date_booking) }} &nbsp;-&nbsp; {{ convertDateSlash(d.end_date_booking) }}</td>
                                    <td class="text-center" :data-order="d.start_date_check_in +' '+ d.end_date_check_in">{{ convertDateSlash(d.start_date_check_in) }} &nbsp;-&nbsp; {{ convertDateSlash(d.end_date_check_in) }}</td>
                                    <td class="text-right">{{ d.discount_type == 'percent' ? (d.discount_value +'%') : ('฿'+ formatBaht(d.discount_value)) }}</td>
                                    <td class="text-right">{{ d.note }}</td>

                                    <?php if (has_permission('discount_management', 'edit') || has_permission('discount_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('discount_management', 'edit')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="loadEditDiscount(d.id_discount)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('discount_management', 'delete')) : ?>
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
    </section>
</div>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Discount Management', 'ตั้งค่าส่วนลด'); ?>",
            edit_discount: {},
            discount: <?php echo empty($discount) ? '{}' : json_encode($discount); ?>,
        },
        mounted() {
            let self = this;

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

            $("#discountTable").DataTable();
        },
        methods: {
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
        }
    });
});
</script>