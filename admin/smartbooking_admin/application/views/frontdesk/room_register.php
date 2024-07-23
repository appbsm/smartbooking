<style>
    .available {background-color:#6aca25;}
    .occupied {background-color:#6624fb;}
    .blocked {background-color:#fc0d1b;}
</style>

<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" v-cloak>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= _r('Front Desk', 'แผนกต้อนรับ'); ?></li>
                        <li class="breadcrumb-item"><a href="<?php echo room_register_url(); ?>">{{ menu }}</a></li>
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
                    <div class="row">
                        <div class="col-md-12" style="font-size:18px; font-weight:bold; text-align:center; vertical-align:middle; height:40px; line-height:40px; background-color:#0275d8; color:white;">
                            {{ menu }}
                        </div>
                    </div>

                    <div class="row">
                        <?php if (has_permission('booking', 'edit')) : ?>
                        <span style="width:100%; text-align:right;">
                            <a href="<?php echo edit_booking_url(); ?>" style="color:white;">    
                                <button class="btn" style="float:right; width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-top:10px;">
                                    <?= _r('Add New Booking', 'เพิ่มการจองใหม่'); ?>
                                </button>
                            </a>
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12" style="margin-top:30px; border:1px solid #dddddd; border-radius:5px; padding:15px 15px 30px 15px;">
                        <filterroom :lang='lang' :filter='filter' @change-filter="changeFilter" :projects='projects' :rooms='rooms'></filterroom>
                        <div class="row">
                            <div class="col-md-6">
                                <small><b><?= _r('Room Status', 'สถานะห้องพัก'); ?></b> (<font color="#6aca25"><?= _r('Available', 'ว่าง'); ?></font>, <font color="#6624fb"><?= _r('Occupied', 'ไม่ว่าง'); ?></font>, <font color="#fc0d1b"><?= _r('Blocked', 'ปิดใช้งาน'); ?></font>)</small>
                                <select class="form-control" v-model="filter.room_status" @change="loadRoomRegister()">
                                    <option value="All"><?= _r('All', 'ทั้งหมด'); ?></option>
                                    <option value="Available"><?= _r('Available', 'ว่าง'); ?></option>
                                    <option value="Occupied"><?= _r('Occupied', 'ไม่ว่าง'); ?></option>
                                    <option value="Blocked"><?= _r('Blocked', 'ปิดใช้งาน'); ?></option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <small><b><?= _r('Booking Status', 'สถานะ Booking'); ?></b></small>
                                <select class="form-control" v-model="filter.booking_status" @change="loadRoomRegister()">
                                    <option value="All"><?= _r('All', 'ทั้งหมด'); ?></option>
                                    <option value="Booked">Booked</option>
                                    <option value="Verifying">Verifying</option>
                                    <option value="Confirmed">Confirmed</option>
                                    <option value="Checked-in">Checked-in</option>
                                    <option value="Checked-out">Checked-out</option>
                                    <option value="Cancel">Cancel</option>
                                    <option value="Expired">Expired</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                <input type="checkbox" v-model="filter.show_only_last_booking" @change="loadRoomRegister()">&nbsp;&nbsp; Show only last booking of each room
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:30px;">
                        <div class="col-md-12" style="max-width:100%; overflow:auto;">
                            <table id="roomRegisterTable" class="display" style="width:99%;">
                                <thead>
                                    <tr>
                                        <th class="w55"><?= _r('Booking Number', 'หมายเลข Booking'); ?></th>
                                        <th class="w55"><?= _r('Booking Date', 'วันที่ทำการจอง'); ?></th>
                                        <th class="w100"><?= _r('Room #', 'หมายเลขห้อง'); ?></th>
                                        <th class="w200"><?= _r('Room Type', 'ประเภทห้อง'); ?></th>
                                        <th class="w400"><?= _r('Guest', 'ผู้เข้าพัก'); ?></th>
                                        <th class="w200"><?= _r('Reservation Info', 'ข้อมูลการจอง'); ?></th>
                                        <th class="w100"><?= _r('Booking Status', 'สถานะ Booking'); ?></th>
                                        <?php if (has_permission('room_register', 'edit')) : ?>
                                        <th class="w50"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="r in room_register">
                                        <td class="text-center">{{ r.booking_number }}</td>
                                        <td class="text-center">{{ convertDateSlash(r.booking_date.split(' ')[0]) }}</td>
                                        <td style="text-align:center;">
                                            <div class="available" style="width:100px; height:20px; color:white; margin:auto;" v-if="r.room_status == 'Available'">{{ r.room_number }}</div>
                                            <div class="occupied" style="width:100px; height:20px; color:white; margin:auto;" v-if="r.room_status == 'Occupied'">{{ r.room_number }}</div>
                                            <div class="blocked" style="width:100px; height:20px; color:white; margin:auto;" v-if="r.room_status == 'Blocked'">{{ r.room_number }}</div>
                                        </td>
                                        <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                        <td>{{ r.guest_name }}</td>
                                        <td style="text-align:center; font-size:13px;">
                                            <a href="#" @click="editBooking(r.id_booking)">{{ r.booking_number }}</a>
                                            <br>
                                            <span style="float:left;"><span style="color:blue;"><i class="fa fa-sign-in-alt"></i></span> &nbsp;&nbsp;{{ convertDateSlash(r.check_in_date) }}</span>
                                            <span style="float:right;"><span style="color:red;"><i class="fa fa-sign-out-alt"></i></span> &nbsp;&nbsp;{{ convertDateSlash(r.check_out_date) }}</span>
                                        </td>
                                        <td style="text-align:center;">
                                            <span :class="'badge badge-'+ getBsClass(r.status)">{{ r.status }}</span>
                                        </td>
                                        <?php if (has_permission('room_register', 'edit')) : ?>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning" @click="editBooking(r.id_booking)">
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
        </div>
    </section>
</div>

<script src="<?php echo site_url(); ?>asset/component/filterRoom.js"></script>
<script>
$(document).ready(function() {
    let table = '';

    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Room Register', 'การจองของห้องพัก'); ?>",
            lang: '<?php echo getLang(); ?>',
            filter: {
                'project': '<?php echo $projects[0]['id_project_info']; ?>',
                'room': 'All',
                'room_status': 'All',
                'booking_status': 'All',
                'show_only_last_booking': false
            },
            projects: <?php echo json_encode($projects); ?>,
            rooms: <?php echo json_encode($rooms); ?>,
            room_register: <?php echo json_encode($room_register); ?>
        },
        mounted() {
            table = $("#roomRegisterTable").DataTable({"ordering": false});
        },
        methods: {
            editBooking: function(id) {
                <?php if (has_permission('room_register', 'edit')) : ?>
                location.href = "<?php echo edit_booking_url(); ?>"+ id;
                <?php endif; ?>
            },
            loadRoomRegister: function() {
                let self = this;

                $.post("<?php echo get_room_register_url(); ?>", this.filter, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        table.destroy();
                        self.room_register = res.message;
                        setTimeout(() => {
                            table = $("#roomRegisterTable").DataTable({"ordering": false});
                        }, 100);
                    }
                });
            },
            changeFilter: function(v) {
                this.filter = v;
                this.loadRoomRegister();
            }
        }
    });
});
</script>