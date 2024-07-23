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
                            <a href="<?php echo user_management_url(); ?>">{{ menu }}</a>
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
                <div class="col-md-12">
                    <?php if (has_permission('user_management', 'edit')) : ?>
                    <a href="<?php echo edit_user_url(); ?>" style="color:white;">
                        <button class="btn" style="float:right; width:130px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;">
                            <?= _r('Add New User', 'เพิ่ม User ใหม่'); ?>
                        </button>
                    </a>
                    <?php endif; ?>
                    <div style="width:100%; overflow:auto;">
                        <table id="userTable" class="display" style="min-width:500px; width:99%;">
                            <thead style="text-align:center;">
                                <tr>
                                    <th><?= _r('Name', 'ชื่อ'); ?></th>
                                    <th style="width:300px;"><?= _r('Email', 'อีเมล'); ?></th>
                                    <th style="width:150px;"><?= _r('Username', 'ยูสเซอร์เนม'); ?></th>
                                    <th style="width:100px;">Role</th>
                                    <th style="width:150px;"><?= _r('Date Created', 'วันสร้าง User'); ?></th>
                                    <th style="width:100px;"><?= _r('Status', 'สถานะ'); ?></th>
                                    <?php if (has_permission('user_management', 'view') || has_permission('user_management', 'delete')) : ?>
                                    <th style="width:100px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="u in users">
                                    <td>{{ u.name }}</td>
                                    <td>{{ u.email }}</td>
                                    <td>{{ u.username }}</td>
                                    <td class="text-center">{{ u.role_name }}</td>
                                    <td class="text-center" :data-order="convertDateDash(u.date_created.split(' ')[0]) +' '+ u.date_created.split(' ')[1]">{{ u.date_created }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="u.active == 1">Active</span>
                                        <span class="badge badge-danger" v-if="u.active == 0">Inactive</span>
                                    </td>

                                    <?php if (has_permission('user_management', 'view') || has_permission('user_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('user_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="editUser(u.id_user)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('user_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteUser(u.id_user)">
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
            menu: "<?= _r('User Management', 'ตั้งค่า User'); ?>",
            users: <?php echo json_encode($users); ?>
        },
        mounted() {
            $("#userTable").DataTable();
        },
        methods: {
            editUser: function(id) {
                location.href = "<?php echo edit_user_url(); ?>"+ id;
            },
            deleteUser: function(id) {
                if (confirm("Delete this User ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_user_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete User Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>