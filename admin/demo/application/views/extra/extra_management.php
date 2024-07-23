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
                            <a href="<?php echo extra_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="updateExtraModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"><?= _r('Update', 'แก้ไข'); ?> Extra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> Title <?= _r('EN', '(ภาษาอังกฤษ)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="extra_update_row.title_en">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> Title <?= _r('TH', '(ภาษาไทย)'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="extra_update_row.title_th">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Price', 'ราคา'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="extra_update_row.price">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Max Qty', 'จำนวนสูงสุด'); ?></small>
                                <input type="number" class="form-control" style="margin-top:-3px;" v-model="extra_update_row.max_qty">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Is Bed?', 'เตียงนอนใช่หรือไม่?'); ?></small>
                                <select class="form-control" style="margin-top:-3px;" v-model="extra_update_row.is_bed">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Status', 'สถานะ'); ?></small>
                                <select class="form-control" style="margin-top:-3px;" v-model="extra_update_row.active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="updateExtra()"><?= _r('Update', 'แก้ไข'); ?></button>
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
                    <?php if (has_permission('extra_management', 'edit')) : ?>
                    <div class="row">
                        <div class="col-md-6">
                            <small><font color="red">*</font> Title <?= _r('EN', '(ภาษาอังกฤษ)'); ?></small>
                            <input type="text" class="form-control" v-model="extra_add_row.title_en">
                        </div>
                        <div class="col-md-6">
                            <small><font color="red">*</font> Title <?= _r('TH', '(ภาษาไทย)'); ?></small>
                            <input type="text" class="form-control" v-model="extra_add_row.title_th">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('Price', 'ราคา'); ?></small>
                            <input type="number" class="form-control" v-model="extra_add_row.price">
                        </div>
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('Max Qty', 'จำนวนสูงสุด'); ?></small>
                            <input type="number" class="form-control" v-model="extra_add_row.max_qty">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('Is Bed?', 'เตียงนอนใช่หรือไม่?'); ?></small>
                            <select class="form-control" style="margin-top:-3px;" v-model="extra_add_row.is_bed">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <small><font color="red">*</font> <?= _r('Status', 'สถานะ'); ?></small>
                            <select class="form-control" style="margin-top:-3px;" v-model="extra_add_row.active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px">
                        <div class="col-md-12" style="text-align:center">
                            <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#809f4e; color:white;" @click="addExtra()"><?= _r('Add', 'เพิ่ม'); ?></button>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row" style="overflow:auto; margin-top:40px">
                        <table style="min-width:600px; width:100%;">
                            <thead style="text-align:center;">
                                <tr>
                                    <th>Title</th>
                                    <th style="width:100px;"><?= _r('Price', 'ราคา'); ?></th>
                                    <th style="width:100px;"><?= _r('Max Qty', 'จำนวนสูงสุด'); ?></th>
                                    <th style="width:110px;"><?= _r('Is Bed?', 'เตียงนอน<br>ใช่หรือไม่?'); ?></th>
                                    <th style="width:110px;"><?= _r('Status', 'สถานะ'); ?></th>
                                    <?php if (has_permission('extra_management', 'edit') || has_permission('extra_management', 'delete')) : ?>
                                    <th style="width:100px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(e, i) in extras">
                                    <td class="text-left">{{ <?= _r('e.title_en', 'e.title_th'); ?> }}</td>
                                    <td class="text-right">{{ formatBaht(e.price) }}</td>
                                    <td class="text-center">{{ e.max_qty }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="e.is_bed == 1">Yes</span>
                                        <span class="badge badge-danger" v-if="e.is_bed == 0">No</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="e.active == 1">Active</span>
                                        <span class="badge badge-danger" v-if="e.active == 0">Inactive</span>
                                    </td>
                                    <?php if (has_permission('extra_management', 'edit') || has_permission('extra_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('extra_management', 'edit')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="loadUpdateExtra(i)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('extra_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteExtra(e.id_extras)">
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
            menu: "<?= _r('Extra Management', 'ตั้งค่า Extra'); ?>",
            extras: <?php echo json_encode($extras); ?>,
            extra_add_row: <?php echo empty($extra_blank_row) ? '{}' : json_encode($extra_blank_row); ?>,
            extra_update_row: <?php echo empty($extra_blank_row) ? '{}' : json_encode($extra_blank_row); ?>
        },
        mounted() {},
        methods: {
            addExtra: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.extra_add_row);
                keys.forEach((v) => {
                    if (valid && self.extra_add_row[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                let param = {'extra': this.extra_add_row};
                $.post("<?php echo save_extra_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Add Extra Success');
                        location.reload();
                    }
                });
            },
            loadUpdateExtra: function(id) {
                this.extra_update_row = JSON.parse(JSON.stringify(this.extras[id]));
                $('#updateExtraModal').modal('show');
            },
            updateExtra: function(id) {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.extra_update_row);
                keys.forEach((v) => {
                    if (valid && self.extra_update_row[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                let param = {'extra': this.extra_update_row};
                $.post("<?php echo save_extra_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Update Extra Success');
                        location.reload();
                    }
                });
            },
            deleteExtra: function(id) {
                let self = this;
                if (confirm("Delete this Extra ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_extra_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Extra Success');
                            location.reload();
                        }
                    });
                }
            },
        }
    });
});
</script>