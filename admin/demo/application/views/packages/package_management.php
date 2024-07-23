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
                            <a href="<?php echo package_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <?php if (has_permission('package_management', 'edit')) : ?>
                    <span style="width:100%; text-align:right;">
                        <a href="<?php echo edit_package_url(); ?>" style="color:white;">    
                            <button class="btn" style="float:right; width:170px; height:30px; line-height:9px; background-color:#809f4e; color:white; margin-bottom:20px;">
                                <?= _r('Add New Package', 'เพิ่มแพ็กเกจใหม่'); ?>
                            </button>
                        </a>
                    </span>
                    <?php endif; ?>

                    <div style="width:100%; overflow:auto;">
                        <table id="packageTable" class="display" style="width:99%;">
                            <thead style="text-align:center;">
                                <tr>
                                    <th><?= _r('Image', 'รูปภาพ'); ?></th>
                                    <th><?= _r('Package Name', 'ชื่อแพ็กเกจ'); ?></th>
                                    <th class="w60"><?= _r('Package Price', 'ราคาแพ็กเกจ'); ?></th>
                                    <th class="w65"><?= _r('Start Date', 'ใช้ได้<br>ตั้งแต่วันที่'); ?></th>
                                    <th class="w65"><?= _r('End Date', 'ใช้ได้<br>ถึงวันที่'); ?></th>
                                    <th class="w150"><?= _r('Project', 'โปรเจกต์'); ?></th>
                                    <th class="w250"><?= _r('Room', 'ห้องพัก'); ?></th>
                                    <th class="w60"><?= _r('Package Status', 'สถานะแพ็กเกจ'); ?></th>

                                    <?php if (has_permission('package_management', 'view') || has_permission('package_management', 'delete')) : ?>
                                    <th class="w70"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="p in package">
                                    <td class="text-center"><img :src="p.package_photo" style="width:100%;"></td>        
                                    <td>{{ p.name }}</td>
                                    <td class="text-right">{{ formatBaht(p.price) }}</td>
                                    <td class="text-center" :data-order="p.start_date">{{ convertDateSlash(p.start_date) }}</td>
                                    <td class="text-center" :data-order="p.end_date">{{ convertDateSlash(p.end_date) }}</td>
                                    <td class="text-center">{{ p.project_name_en }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-info" style="font-weight:normal; margin-left:2px;" v-for="r in p.package_item">
                                            {{ r.room_type_name_en }}
                                            <span style="font-weight:bold; color:black;" v-show="r.qty > 1"> (x{{ r.qty }})</span>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="p.is_active == 1">Active</span>
                                        <span class="badge badge-danger" v-else>Inactive</span>
                                    </td>

                                    <?php if (has_permission('package_management', 'view') || has_permission('package_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('package_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="editPackage(p.id_package)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('package_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deletePackage(p.id_package)">
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
            menu: "<?= _r('Package Management', 'ตั้งค่าแพ็กเกจ'); ?>",
            package: <?php echo json_encode($package); ?>
        },
        mounted() {
            $("#packageTable").DataTable();
        },
        methods: {
            editPackage: function(id) {
                <?php if (has_permission('package_management', 'view')) : ?>
                location.href = "<?php echo edit_package_url(); ?>"+ id;
                <?php endif; ?>
            },
            deletePackage: function(id) {
                if (confirm("Delete this Package ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_package_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Package Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>