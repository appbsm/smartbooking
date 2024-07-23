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
                        <li class="breadcrumb-item"><a href="<?php echo reservations_url(); ?>">{{ menu }}</a></li>
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
                                <small><b><?= _r('Booking Number', 'หมายเลข Booking'); ?></b></small>
                                <input type="text" class="form-control" v-model="filter.booking_number" @keyup="loadReservations()">
                            </div>
                            <div class="col-md-6">
                                <small><b><?= _r('Booking Status', 'สถานะ Booking'); ?></b></small>
                                <select class="form-control" v-model="filter.booking_status" @change="loadReservations()">
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

                        <filterdate :lang='lang' :filter='filter' @change-filter="changeFilter"></filterdate>
                    </div>

                    <div class="row" style="margin-top:30px;">
                        <div class="col-md-12" style="max-width:100%; overflow:auto;">
                            <table id="reservationTable" class="display" style="width:99%;">
                                <thead>
                                    <tr>
                                        <th class="w55"><?= _r('Booking Number', 'หมายเลข Booking'); ?></th>
                                        <th class="w55"><?= _r('Booking Date', 'วันที่ทำการจอง'); ?></th>
                                        <th class="w250"><?= _r('Guest', 'ชื่อผู้เข้าพัก'); ?></th>
                                        <th class="w100"><?= _r('Date', 'วันเข้าพัก'); ?></th>
                                        <th class="w100"><?= _r('Rooms', 'ห้องพัก'); ?></th>
                                        <th class="w100"><?= _r('Pax', 'จำนวนผู้เข้าพัก'); ?></th>
                                        <th class="w200"><?= _r('Note', 'หมายเหตุ'); ?></th>
                                        <th class="w70"><?= _r('Booking Status', 'สถานะ Booking'); ?></th>
                                        <?php if (has_permission('reservations', 'edit')) : ?>
                                        <th class="w50"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="r in reservations">
                                        <td style="text-align:center;">{{ r.booking_number }}</td>
                                        <td style="text-align:center;" :data-order="r.booking_date">{{ convertDateSlash(r.booking_date.split(' ')[0]) }}</td>
                                        <td>{{ r.guest_name }}</td>
                                        <td style="text-align:center; font-size:13px;" :data-order="r.check_in_date +' '+ r.check_out_date">
                                            <span style="color:blue;"><i class="fa fa-sign-in-alt"></i></span> &nbsp;&nbsp;{{ convertDateSlash(r.check_in_date) }}
                                            <br>
                                            <span style="color:red;"><i class="fa fa-sign-out-alt"></i></span> &nbsp;&nbsp;{{ convertDateSlash(r.check_out_date) }}
                                        </td>
                                        <td style="text-align:center;">
                                            <span class="badge badge-primary" style="margin-left:2px;" v-for="br in r.booking_room">{{ br.room_number }}</span>
                                        </td>
                                        <td style="text-align:center; font-size:13px;">
                                            <i class="fa fa-user"></i> {{ r.number_of_adults }} &nbsp;&nbsp;&nbsp;<i class="fa fa-child"></i> {{ r.number_of_children }}    
                                        </td>
                                        <td style="text-align:right;">{{ r.notes }}</td>
                                        <td style="text-align:center;">
                                            <span :class="'badge badge-'+ getBsClass(r.status)">{{ r.status }}</span>
                                        </td>
                                        <?php if (has_permission('reservations', 'edit')) : ?>
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
<script src="<?php echo site_url(); ?>asset/component/filterDate.js"></script>
<script>
$(document).ready(function() {
    let table = '';

    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Reservations', 'รายการการจองทั้งหมด'); ?>",
            lang: '<?php echo getLang(); ?>',
            filter: {
                'booking_number': '',
                'project': '<?php echo $projects[0]['id_project_info']; ?>',
                'room': 'All',
                'booking_status': 'All',
                'date_type': 'Booked',
                'range': '',
                'from_day': '<?php echo date('Y-m-d'); ?>',
                'to_day': '<?php echo date('Y-m-d'); ?>',
                'month': '<?php echo date('Y-m'); ?>'
            },
            reservations: <?php echo json_encode($reservations); ?>,
            projects: <?php echo json_encode($projects); ?>,
            rooms: <?php echo json_encode($rooms); ?>,
            searching: false
        },
        mounted() {
            table = $("#reservationTable").DataTable();
        },
        methods: {
            editBooking: function(id) {
                <?php if (has_permission('reservations', 'edit')) : ?>
                location.href = "<?php echo edit_booking_url(); ?>"+ id;
                <?php endif; ?>
            },
            loadReservations: function() {
                let self = this;
                if (this.searching) {
                    return;
                }
                this.searching = true;

                $.post("<?php echo get_reservations_url(); ?>", this.filter, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        table.destroy();
                        self.reservations = res.message;
                        setTimeout(() => {
                            table = $("#reservationTable").DataTable();
                            self.searching = false;
                        }, 100);
                    }
                });
            },
            changeFilter: function(v) {
                this.filter = v;
                this.loadReservations();
            }
        }
    });
});
</script>