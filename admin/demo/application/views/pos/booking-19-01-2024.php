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
                            <a href="<?php echo booking_url(); ?>">{{ menu }}</a>
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
                <?php if (has_permission('booking', 'edit')) : ?>
                <span style="width:100%; text-align:right;">
                    <a href="<?php echo edit_booking_url(); ?>" style="color:white;">    
                        <button class="btn" style="float:right; width:170px; height:30px; line-height:9px; background-color:#809f4e; color:white; margin-top:-25px;">
                            <?= _r('Add New Booking', 'เพิ่มการจองใหม่'); ?>
                        </button>
                    </a>
                </span>
                <?php endif; ?>

                <div class="col-md-12" style="margin-top:5px; border:1px solid #dddddd; border-radius:5px; padding:15px 15px 30px 15px;">
                    <filterroom :lang='lang' :filter='filter' @change-filter="changeFilter" :projects='projects' :rooms='rooms'></filterroom>

                    <div class="row">
                        <div class="col-md-4">
                            <filterguest :lang='lang' :filter='filter' @change-filter="changeFilter" :search_guest_url='search_guest_url'></filterguest>
                        </div>
                        <div class="col-md-4">
                            <small><b><?= _r('Booking Number', 'หมายเลข Booking'); ?></b></small>
                            <input type="text" class="form-control" v-model="filter.booking_number" @keyup="getBooking()">
                        </div>
                        <div class="col-md-4">
                            <small><b><?= _r('Booking Status', 'สถานะ Booking'); ?></b></small>
                            <select class="form-control" v-model="filter.booking_status" @change="getBooking()">
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


                <div class="col-md-12" style="margin-top:10px; max-width:100%; overflow:auto;">
                    <imagemodal :showimage='show_image' :title="_r('Transfer Slip', 'สลิปโอนเงิน', lang)"></imagemodal>
                    <table id="bookingTable" class="display" style="width:1600px;">
                        <thead style="text-align:center;">
                            <tr>
                                <th class="w40"><?= _r('Booking Number', 'หมายเลข Booking'); ?></th>
                                <th class="w70"><?= _r('Booking Date', 'วันที่<br>ทำการจอง'); ?></th>
                                <th><?= _r('Guest Name', 'ชื่อผู้เข้าพัก'); ?></th>
                                <th class="w40"><?= _r('# of Adults', 'จำนวนผู้ใหญ่'); ?></th>
                                <th class="w40"><?= _r('# of Children', 'จำนวนเด็ก'); ?></th>
                                <th class="w70"><?= _r('Check In Date', 'วัน check-in'); ?></th>
                                <th class="w70"><?= _r('Check Out Date', 'วัน check-out'); ?></th>
                                <th class="w40"><?= _r('Total Price', 'ราคารวม'); ?></th>
                                <th class="w60"><?= _r('Transferred Amount', 'ยอดเงินที่<br>ชำระแล้ว'); ?></th>
                                <th class="w110"><?= _r('Transfer Slip', 'สลิปโอนเงิน'); ?></th>
                                
                                <th class="w40"><?= _r('Credit Term', 'Credit Term'); ?></th>
                                <th class="w70"><?= _r('Due Date', 'Due Date'); ?></th>
                                <th class="w40"><?= _r('Booking Status', 'สถานะ Booking'); ?></th>
                                <?php if (has_permission('booking', 'view') || has_permission('booking', 'delete')) : ?>
                                <th class="w90"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="b in booking">
                                <td class="text-center">{{ b.booking_number }}</td>
                                <td class="text-center" :data-order="b.booking_date">{{ convertDateSlash(b.booking_date) }}</td>
                                <td>{{ b.guest_name }}</td>
                                <td class="text-center">{{ b.number_of_adults }}</td>
                                <td class="text-center">{{ b.number_of_children }}</td>
                                <td class="text-center" :data-order="b.check_in_date">{{ convertDateSlash(b.check_in_date) }}</td>
                                <td class="text-center" :data-order="b.check_out_date">{{ convertDateSlash(b.check_out_date) }}</td>
                                <td class="text-right">{{ formatBaht(b.grand_total) }}</td>
                                <td class="text-right">{{ formatBaht(b.transferred_amount) }}</td>
                                <td>
                                    <img style="height:50px; margin-left:3px; cursor:zoom-in;" v-for="p in b.booking_payment" :src="p.transfer_slip" data-toggle="modal" data-target="#showImageModal" @click="showImage(p.transfer_slip)">
                                </td>
                                
                                <td class="text-center">{{ b.credit_description }}</td>
                                <td class="text-center">{{ convertDateSlash(b.credit_due_date) }}</td>
                                <td class="text-center">
                                    <span :class="'badge badge-'+ getBsClass(b.status)">{{ b.status }}</span>
                                </td>
                                <?php if (has_permission('booking', 'view') || has_permission('booking', 'delete')) : ?>
                                <td class="text-center">
                                    <?php if (has_permission('booking', 'view')) : ?>
                                    <button class="btn btn-sm btn-info" @click="viewBooking(b.id_booking)">
                                        <i class="fa fa-file-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" @click="editBooking(b.id_booking)">
                                        <i class="fa fa-pencil" style="color:black !important;"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if (has_permission('booking', 'delete')) : ?>
                                    <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteBooking(b.id_booking)">
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

<script src="<?php echo site_url(); ?>asset/component/filterRoom.js"></script>
<script src="<?php echo site_url(); ?>asset/component/filterGuest.js"></script>
<script src="<?php echo site_url(); ?>asset/component/filterDate.js"></script>
<script src="<?php echo site_url(); ?>asset/component/imageModal.js"></script>
<script>
$(document).ready(function() {
    let table = '';

    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Booking', 'จองห้องพัก'); ?>",
            lang: '<?php echo getLang(); ?>',
            filter: {
                'project': '<?php echo $projects[0]['id_project_info']; ?>',
                'room': 'All',
                'booking_number': '',
                'booking_status': 'All',
                'date_type': 'Booked',
                'range': '',
                'from_day': '<?php echo date('Y-m-d'); ?>',
                'to_day': '<?php echo date('Y-m-d'); ?>',
                'month': '<?php echo date('Y-m'); ?>',
                'guest_id': '',
                'guest_name': ''
            },
            booking: <?php echo json_encode($booking); ?>,
            projects: <?php echo json_encode($projects); ?>,
            rooms: <?php echo json_encode($rooms); ?>,
            searching: false,
            search_guest_url: '<?php echo search_guest_url(); ?>',
            show_image: ''
        },
        mounted() {
            table = $("#bookingTable").DataTable();
        },
        methods: {
            viewBooking: function(id) {
                <?php if (has_permission('booking', 'view')) : ?>
                window.open("<?php echo show_invoice_url(); ?>"+ id, '_blank').focus();
                <?php endif; ?>
            },
            editBooking: function(id) {
                <?php if (has_permission('booking', 'view')) : ?>
                location.href = "<?php echo edit_booking_url(); ?>"+ id;
                <?php endif; ?>
            },
            deleteBooking: function(id) {
                if (confirm("Delete this Booking ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_booking_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Booking Success');
                            location.reload();
                        }
                    });
                }
            },
            getBooking: function() {
                let self = this;
                if (this.searching) {
                    return;
                }
                this.searching = true;

                $.post("<?php echo get_booking_url(); ?>", this.filter, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        table.destroy();
                        self.booking = res.message;
                        setTimeout(() => {
                            table = $("#bookingTable").DataTable();
                            self.searching = false;
                        }, 10);
                    }
                });
            },
            changeFilter: function(v) {
                this.filter = v;
                this.getBooking();
            }
        }
    });
});
</script>