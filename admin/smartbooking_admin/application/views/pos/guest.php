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
                            <a href="<?php echo guest_url(); ?>">{{ menu }}</a>
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
                <?php if (has_permission('guest', 'edit')) : ?>
                <span style="width:100%; text-align:right;">
                    <a href="<?php echo edit_guest_url(); ?>" style="color:white;">
                        <button class="btn" style="width:140px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;">
                            <?= _r('Add New Guest', 'เพิ่มผู้เข้าพักใหม่'); ?>
                        </button>
                    </a>
                </span>
                <?php endif; ?>
                <div class="col-md-12" style="max-width:100%; overflow:auto;">
                    <table id="guestTable" class="display" style="width:99%;">
                        <thead style="text-align:center;">
                            <tr>
                                <th class="w50"><?= _r('Photo', 'รูปภาพ'); ?></th>
								<th class="w250"><?= _r('Fullname', 'ชื่อ'); ?></th>
                                <th class="w250"><?= _r('First Name', 'ชื่อ'); ?></th>
                                <th class="w250"><?= _r('Last Name', 'นามสกุล'); ?></th>
                                <th class="w150"><?= _r('Contact Number', 'เบอร์โทรติดต่อ'); ?></th>
                                <th class="w250"><?= _r('Email', 'อีเมล'); ?></th>
                                <th class="w150"><?= _r('Username', 'ยูสเซอร์เนม'); ?></th>
                                <th class="w100"><?= _r('Status', 'สถานะ'); ?></th>
                                <?php if (has_permission('guest', 'view') || has_permission('guest', 'delete')) : ?>
                                <th class="w100"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="g in guests">
                                <td class="text-center">
                                    <img style="width:40px; height: 40px;" :src="g.photo_url ? g.photo_url : '<?php echo site_url(); ?>asset/image/user.jpg'">
                                </td>
								<td>{{ g.name }}</td>
                                <td>{{ g.firstname }}</td>
                                <td>{{ g.lastname }}</td>
                                <td class="text-center">{{ g.contact_number }}</td>
                                <td>{{ g.email }}</td>
                                <td>{{ g.username }}</td>
                                <td class="text-center">
                                    <span class="badge badge-success" v-if="g.is_active == 1">Active</span>
                                    <span class="badge badge-danger" v-if="g.is_active == 0">Inactive</span>
                                </td>

                                <?php if (has_permission('guest', 'view') || has_permission('guest', 'delete')) : ?>
                                <td class="text-center">
                                    <?php if (has_permission('guest', 'view')) : ?>
                                    <button class="btn btn-sm btn-warning" @click="editGuest(g.id_guest)">
                                        <i class="fa fa-pencil" style="color:black !important;"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if (has_permission('guest', 'delete')) : ?>
                                    <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteGuest(g.id_guest)">
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
    </section>
</div>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Guest', 'ผู้เข้าพัก'); ?>",
            guests: <?php echo json_encode($guests); ?>
        },
        mounted() {
            $("#guestTable").DataTable();
        },
        methods: {
            editGuest: function(id) {
                <?php if (has_permission('guest', 'view')) : ?>
                location.href = "<?php echo edit_guest_url(); ?>"+ id;
                <?php endif; ?>
            },
            deleteGuest: function(id) {
                if (confirm("Delete this Guest ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_guest_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Guest Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>