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
                        <li class="breadcrumb-item"><?= _r('HR', 'จัดการผู้ใช้งาน'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo role_management_url(); ?>">{{ menu }}</a>
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
                    <?php if (has_permission('role_management', 'edit')) : ?>
                    <a href="<?php echo edit_role_url(); ?>" style="color:white;">
                        <button class="btn" style="float:right; width:130px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;">
                            <?= _r('Add New Role', 'เพิ่ม Role ใหม่'); ?>
                        </button>
                    </a>
                    <?php endif; ?>
                    <div style="width:100%; overflow:auto;">
                        <table style="min-width:500px; width:100%;">
                            <thead style="text-align:center;">
                                <tr>
                                    <th style="width:200px;"><?= _r('Role Name', 'ชื่อ Role'); ?></th>
                                    <th style="min-width:200px;"><?= _r('Description', 'รายละเอียด'); ?></th>
                                    <th style="width:100px;"><?= _r('Status', 'สถานะ'); ?></th>
                                    <?php if (has_permission('role_management', 'view') || has_permission('role_management', 'delete')) : ?>
                                    <th style="width:100px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="r in roles">
                                    <td class="text-center">{{ r.role_name }}</td>
                                    <td class="text-left">{{ r.description }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="r.active == 1">Active</span>
                                        <span class="badge badge-danger" v-if="r.active == 0">Inactive</span>
                                    </td>
                                    <?php if (has_permission('role_management', 'view') || has_permission('role_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('role_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="editRole(r.id_role)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('role_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteRole(r.id_role)">
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
            menu: "<?= _r('Role Management', 'ตั้งค่า Role'); ?>",
            roles: <?php echo json_encode($roles); ?>
        },
        mounted() {},
        methods: {
            editRole: function(id) {
                location.href = "<?php echo edit_role_url(); ?>"+ id;
            },
            deleteRole: function(id) {
                if (confirm("Delete this Role ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_role_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Role Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>