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
                            <a href="<?php echo room_management_url(); ?>">{{ menu }}</a>
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
                    <?php if (has_permission('room_management', 'edit')) : ?>
                    <a href="<?php echo edit_room_type_url(); ?>" style="color:white;">
                        <button class="btn" style="float:right; width:170px; height:30px; line-height:9px; background-color:#809f4e; color:white; margin-bottom:20px;">
                            <?= _r('Add New Room Type', 'เพิ่ม Room Type ใหม่'); ?>
                        </button>
                    </a>
                    <?php endif; ?>
                    <div style="width:100%; overflow:auto;">
                        <table id="roomTable" class="display" style="width:99%;">
                            <thead style="text-align:center;">
                                <tr>
                                    <th style="width:100px;"><?= _r('Image', 'รูปภาพ'); ?></th>
                                    <th style="width:160px;"><?= _r('Project', 'Project'); ?></th>
                                    <th style="width:80px;">Title</th>
                                    <th><?= _r('Room Type Name', 'ชื่อ Room Type'); ?></th>
                                    <th style="width:60px;"><?= _r('# of Rooms', 'จำนวนห้อง'); ?></th>
                                    <th style="width:80px;"><?= _r('Room Price', 'ราคาห้อง'); ?></th>
                                    <th style="width:60px;"><?= _r('# of Adults', 'จำนวนผู้ใหญ่'); ?></th>
                                    <th style="width:60px;"><?= _r('# of Children', 'จำนวนเด็ก'); ?></th>
                                    <th style="width:80px;"><?= _r('Max Children Age', 'อายุเด็กสูงสุด'); ?></th>
                                    <th style="width:80px;"><?= _r('Is Big Room?', 'เป็นห้องใหญ่หรือไม่'); ?></th>
                                    <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th>
                                    <?php if (has_permission('room_management', 'view') || has_permission('room_management', 'delete')) : ?>
                                    <th style="width:80px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="r in room_type">
                                    <td class="text-center"><img :src="r.image" style="width:100%;"></td>
                                    <td>{{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }}</td>
                                    <td class="text-center">{{ <?= _r('r.modular_type_en', 'r.modular_type_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                    <td class="text-center">{{ r.rooms_count }}</td>
                                    <td class="text-center">{{ formatBaht(r.default_rate) }}</td>
                                    <td class="text-center">{{ r.number_of_adults }}</td>
                                    <td class="text-center">{{ r.number_of_children }}</td>
                                    <td class="text-center">{{ r.max_children_age }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="r.is_big_room == 1">Yes</span>
                                        <span class="badge badge-danger" v-if="r.is_big_room == 0">No</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-success" v-if="r.active == 1">Active</span>
                                        <span class="badge badge-danger" v-if="r.active == 0">Inactive</span>
                                    </td>
                                    <?php if (has_permission('room_management', 'view') || has_permission('room_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('room_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="editRoomType(r.id_room_type)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (has_permission('room_management', 'delete')) : ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteRoomType(r.id_room_type)">
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
            menu: "<?= _r('Room Management', 'ตั้งค่าห้องพัก'); ?>",
            room_type: <?php echo json_encode($room_type); ?>
        },
        mounted() {
            $("#roomTable").DataTable();
        },
        methods: {
            editRoomType: function(id) {
                <?php if (has_permission('room_management', 'view')) : ?>
                location.href = '<?php echo edit_room_type_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteRoomType: function(id) {
                if (confirm('Delete this Room Type ?')) {
                    let param = {'id': id};
                    $.post("<?php echo delete_room_type_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Delete Room Type Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>