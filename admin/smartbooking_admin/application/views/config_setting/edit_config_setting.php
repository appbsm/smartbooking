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
                            <a href="<?php echo edit_config_setting_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="updateSettingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"><?= _r('Update', 'แก้ไข'); ?> Setting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <small><?= _r('Name', 'ชื่อ Setting'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="settings_update_row.name" disabled>
                            </div>
                            <div class="col-md-3">
                                <small><font color="red">*</font> <?= _r('Value', 'ค่า Setting'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="settings_update_row.value">
                            </div>
                            <div class="col-md-6">
                                <small><?= _r('Remark', 'หมายเหตุ'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="settings_update_row.remark">
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="updateSettings()"><?= _r('Update', 'แก้ไข'); ?></button>
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
                <div class="col-md-6 offset-md-3">
                    <div class="row" style="overflow:auto; margin-top:40px">
                        <table style="min-width:300px; width:100%;">
                            <thead style="text-align:center;">
                                <tr>
                                    <th class="w100"><?= _r('Name', 'ชื่อ Setting'); ?></th>
                                    <th class="w100"><?= _r('Value', 'ค่า Setting'); ?></th>
                                    <th class="w200"><?= _r('Remark', 'หมายเหตุ'); ?></th>
                                    <?php if (has_permission('edit_config_setting', 'edit')) : ?>
                                    <th class="w50"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(s, i) in settings">
                                    <td>{{ s.name }}</td>
                                    <td class="text-right">{{ s.value }}</td>
                                    <td class="text-right">{{ s.remark }}</td>
                                    <?php if (has_permission('edit_config_setting', 'edit')) : ?>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning" @click="loadUpdateSettings(i)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
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
            menu: "<?= _r('Config Setting', 'ตั้งค่าคอนฟิก'); ?>",
            settings: <?php echo json_encode($setting_rows); ?>,
            settings_update_row: {}
        },
        mounted() {},
        methods: {
            loadUpdateSettings: function(id) {
                this.settings_update_row = JSON.parse(JSON.stringify(this.settings[id]));
                $('#updateSettingsModal').modal('show');
            },
            updateSettings: function(id) {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.settings_update_row);
                keys.forEach((v) => {
                    if (valid && v != 'remark' && self.settings_update_row[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                //
                $.post("<?php echo save_config_setting_url(); ?>", this.settings_update_row, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Update Setting Success');
                        location.reload();
                    }
                });
            }
        }
    });
});
</script>