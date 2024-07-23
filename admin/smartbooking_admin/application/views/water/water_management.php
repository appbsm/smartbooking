<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" style="padding-bottom:50px;" v-cloak>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ menu }}</h1>
                </div>
                <!-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= _r('Setting', 'การตั้งค่า'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo water_management_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php if (has_permission('water_management', 'edit')) : ?>
                    <a href="<?php echo edit_water_url(); ?>" style="color:white;">
                        <button class="btn" style="float:right; width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;">
                            <?= _r('Create', 'สร้าง'); ?>
                        </button>
                    </a>
                    <?php endif; ?>
                    <div style="width:100%; overflow:auto;">
                        <table id="roomTable" class="display" style="width:99%;">

                            <thead style="text-align:center;">
                                <tr>
                                    <th style="width:100px;"><?= _r('No', 'ลำดับ'); ?></th>
                                    <th style="width:160px;"><?= _r('Project', 'โครงการ'); ?></th>
                                    <th style="width:60px;"><?= _r('Rooms type', 'ห้อง'); ?></th>
                                    <th style="width:60px;"><?= _r('Room Number', 'หมายเลขห้อง'); ?></th>
                                    <th style="width:80px;"><?= _r('Meter ID', 'รหัสมิเตอร์'); ?></th>
                                    <th style="width:60px;"><?= _r('Serial No', 'หมายเลขซีเรียล'); ?></th>
                                    <!-- <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th> -->

                                    <?php if (has_permission('water_management', 'view') || has_permission('water_management', 'delete')) : ?>
                                    <th style="width:80px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>

                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="r in water_list">
                                    <td class="text-center">{{ r.run_id }}
                                        <!-- <img :src="r.image" style="width:100%;"> -->
                                    </td>
                                    <td>{{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</td>
                                    <td class="text-center">{{ r.meter_id }}</td>
                                    <td class="text-center">{{ r.serial_no }}</td>
                                    
                                    <!-- <td class="text-center">
                                        <span class="badge badge-success" v-if="r.is_active == 1">Active</span>
                                        <span class="badge badge-danger" v-if="r.is_active == 0">Inactive</span>
                                    </td> -->

                                    <?php if (has_permission('water_management', 'view') || has_permission('water_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('water_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="editRoomType(r.id)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('water_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteRoomType(r.id)">
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
            menu: "<?= _r('Water Meter List', 'รายการมิเตอร์น้ำ'); ?>",
            water_list: <?php echo json_encode($water_list); ?>
        },
        mounted() {
            $("#roomTable").DataTable();
        },
        methods: {
            editRoomType: function(id) {
                <?php if (has_permission('water_management', 'view')) : ?>
                location.href = '<?php echo edit_water_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteRoomType: function(id) {
                if (confirm('Delete this Room Type ?')) {
                    let param = {'id': id};
                    $.post("<?php echo delete_water_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Delete Water Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>