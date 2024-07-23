<style>
.btn-export {
    color: #fff;
    background-color: #0275d8 !important;
    border-color: #0275d8 !important;
    box-shadow: none;
}
</style>
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
                        <li class="breadcrumb-item"><?= _r('Report', 'รายงาน'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo reservation_report_url(); ?>">{{ menu }}</a>
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
                    <div class="col-md-12" style="margin-top:5px; border:1px solid #dddddd; border-radius:5px; padding:15px 15px 30px 15px;">
                        <filterdate :lang='lang' :filter='filter' @change-filter="changeFilter"></filterdate>
                    </div>

                    <div class="text-right" style="width:100%; margin-top:10px;">
                        <button class="btn btn-sm btn-success btn-export" @click="exportTable()">Export</button>
                    </div>

                    <div class="row" style="margin-top:5px;">
                        <div class="col-md-12" style="max-width:100%; overflow-x:auto;">
                            <table id="reservationReportTable" class="display fixheader" style="width:100%; min-width:1400px;">
                                <thead class="w1905" style="text-align:center; display:block; overflow-x:hidden; overflow-y:scroll; font-size:13px;">
                                    <tr>
                                        <th class="w50"><?= _r('No.', 'ลำดับ'); ?></th>
                                        <th class="w60"><?= _r('Booking Number', 'หมายเลข Booking'); ?></th>
                                        <th class="w125"><?= _r('Guest Name', 'ชื่อผู้เข้าพัก'); ?></th>
                                        <th class="w65"><?= _r('Booking Date', 'วัน Booking'); ?></th>
                                        <th class="w65"><?= _r('Check_In Date', 'วัน check-in'); ?></th>
                                        <th class="w65"><?= _r('Check_Out Date', 'วัน check-out'); ?></th>
                                        <th class="w150"><?= _r('Item Description', 'รายการ'); ?></th>
                                        <th class="w40"><?= _r('Pax (A|C)', 'จำนวนผู้เข้าพัก (A|C)'); ?></th>
                                        <th class="w50"><?= _r('Booking Channel', 'ช่องทางการจอง'); ?></th>
                                        <th class="w125"><?= _r('Staff Name', 'สตาฟที่ทำการจอง'); ?></th>
                                        <th class="w50"><?= _r('Length of Stay', 'จำนวนวันเข้าพัก'); ?></th>
                                        <th class="w50"><?= _r('Qty', 'Qty'); ?></th>
                                        <th class="w75"><?= _r('Item Price', 'ราคา'); ?></th>
                                        <th class="w50"><?= _r('Total Before Discount', 'Total Before Discount'); ?></th>
                                        <th class="w50"><?= _r('Discount', 'ส่วนลด'); ?></th>
                                        <th class="w50"><?= _r('Subtotal', 'Subtotal'); ?></th>
                                        <th class="w50">Vat</th>                                        
                                        <th class="w50"><?= _r('Grand Total', 'Grand Total'); ?></th>
                                    </tr>
                                </thead>
                                <tbody style="max-height:420px; display:block; overflow-x:hidden; overflow-y:scroll;">
                                    <tr v-for="(r, i) in reservations">
                                        <td class="w66 text-center" :data-order="r.no">{{ r.no }}</td>

                                        <?php if (has_permission('reservation_report', 'edit')) : ?>
                                        <td class="w76 text-center" :data-order="r.booking_number" @click="editBooking(r.id_booking)"><a href="#">{{ r.booking_number }}</a></td>
                                        <?php else: ?>
                                        <td class="w76 text-center" :data-order="r.booking_number">{{ r.booking_number }}</td>
                                        <?php endif; ?>

                                        <td class="w141" :data-order="r.guest_name">{{ r.guest_name }}</td>
                                        <td class="w81 text-center" :data-order="r.booking_date">{{ convertDateSlash(r.booking_date) }}</td>
                                        <td class="w81 text-center" :data-order="r.check_in_date">{{ convertDateSlash(r.check_in_date) }}</td>
                                        <td class="w81 text-center" :data-order="r.check_out_date">{{ convertDateSlash(r.check_out_date) }}</td>
                                        <td class="w166" :data-order="r.item_description">{{ r.item_description }}</td>
                                        <td class="w56 text-center" :data-order="r.pax">{{ r.pax }}</td>
                                        <td class="w66 text-center" :data-order="r.channel">{{ r.channel }}</td>
                                        <td class="w141" :data-order="r.staff_name">{{ r.staff_name }}</td>
                                        <td class="w66 text-center" :data-order="r.length_of_stay">{{ r.length_of_stay }}</td>
                                        <td class="w66 text-center" :data-order="r.rate">{{ r.quantity }}</td>
                                        <td class="w91 text-center" :data-order="r.rate">{{ r.rate }}</td>

                                        <td class="w66 text-right" :data-order="r.total_before_discount">{{ formatBaht(r.total_before_discount) }}</td>
                                        <td class="w66 text-right" :data-order="r.discount">{{ formatBaht(r.discount) }}</td>
                                        <td class="w66 text-right" :data-order="r.sub_total">{{ formatBaht(r.sub_total) }}</td>
                                        <td class="w66 text-right" :data-order="r.vat">{{ formatBaht(r.vat) }}</td>                                        
                                        <td class="w66 text-right" :data-order="r.total">{{ formatBaht(r.total) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table id="summaryTable" class="display fixheader" style="width:100%; min-width:1400px; margin-top:10px; font-weight:bold; font-size:13px; border:1px !important;">
                                <thead style="display:none;"><tr><th v-for="i in 16">{{ i }}</th></tr></thead>
                                <tbody style="max-height:420px; display:block; overflow-x:hidden; overflow-y:hidden;">
                                    <tr class="sum-row">
                                        <td class="w66 text-left"><?= _r('Total', 'ยอดรวม'); ?></td>
                                        <td class="w76"></td>
                                        <td class="w141"></td>
                                        <td class="w81"></td>
                                        <td class="w81"></td>
                                        <td class="w81"></td>
                                        <td class="w166"></td>
                                        <td class="w56"></td>
                                        <td class="w66"></td>
                                        <td class="w141"></td>
                                        <td class="w66"></td>
                                        <td class="w91"></td>
                                        <td class="w91"></td>

                                        <td class="w66">{{ formatBaht(sumByCol(reservations, 'total_before_discount')) }}</td>
                                        <td class="w66">{{ formatBaht(sumByCol(reservations, 'discount')) }}</td>
                                        <td class="w66">{{ formatBaht(sumByCol(reservations, 'sub_total')) }}</td>
                                        <td class="w66">{{ formatBaht(sumByCol(reservations, 'vat')) }}</td>
                                        <td class="w66">{{ formatBaht(sumByCol(reservations, 'total')) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Export -->
                            <table id="exportTable">
                                <thead>
                                    <tr>
                                        <th><?= _r('No.', 'ลำดับ'); ?></th>
                                        <th><?= _r('Booking Number', 'หมายเลข Booking'); ?></th>
                                        <th><?= _r('Guest Name', 'ชื่อผู้เข้าพัก'); ?></th>
                                        <th><?= _r('Check_In Date', 'วัน check-in'); ?></th>
                                        <th><?= _r('Check_Out Date', 'วัน check-out'); ?></th>
                                        <th><?= _r('Item Description', 'รายการ'); ?></th>
                                        <th><?= _r('Pax (A|C)', 'จำนวนผู้เข้าพัก (A|C)'); ?></th>
                                        <th><?= _r('Booking Channel', 'ช่องทางการจอง'); ?></th>
                                        <th><?= _r('Staff Name', 'สตาฟที่ทำการจอง'); ?></th>
                                        <th><?= _r('Length of Stay', 'จำนวนวันเข้าพัก'); ?></th>
                                        <th><?= _r('Qty', 'Qty'); ?></th>
                                        <th><?= _r('Item Price', 'ราคา'); ?></th>
                                        <th><?= _r('Total Before Discount', 'Total Before Discount'); ?></th>
                                        <th><?= _r('Discount', 'ส่วนลด'); ?></th>
                                        <th><?= _r('Sub Total', 'Subtotal'); ?></th>
                                        <th>Vat</th>                                        
                                        <th><?= _r('Grand Total', 'Grand Total'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(r, i) in reservations">
                                        <td>{{ r.no }}</td>
                                        <td>{{ r.booking_number }}</td>
                                        <td>{{ r.guest_name }}</td>
                                        <td>{{ convertDateSlash(r.check_in_date) }}</td>
                                        <td>{{ convertDateSlash(r.check_out_date) }}</td>
                                        <td>{{ r.item_description }}</td>
                                        <td>{{ r.pax }}</td>
                                        <td>{{ r.channel }}</td>
                                        <td>{{ r.staff_name }}</td>
                                        <td>{{ r.length_of_stay }}</td>
                                        <td>{{ r.quantity }}</td>
                                        <td>{{ r.rate }}</td>

                                        <td>{{ formatBaht(r.total_before_discount) }}</td>                                        
                                        <td>{{ formatBaht(r.discount) }}</td>
                                        <td>{{ formatBaht(r.sub_total) }}</td>
                                        <td>{{ formatBaht(r.vat) }}</td>                                        
                                        <td>{{ formatBaht(r.total) }}</td>
                                    </tr>
                                    <tr><td v-for="i in 17">&nbsp;</td></tr>
                                    <tr>
                                        <td><?= _r('Total', 'ยอดรวม'); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ formatBaht(sumByCol(reservations, 'total_before_discount')) }}</td>
                                        <td>{{ formatBaht(sumByCol(reservations, 'discount')) }}</td>
                                        <td>{{ formatBaht(sumByCol(reservations, 'sub_total')) }}</td>
                                        <td>{{ formatBaht(sumByCol(reservations, 'vat')) }}</td>                                        
                                        <td>{{ formatBaht(sumByCol(reservations, 'total')) }}</td>
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

<script src="<?php echo site_url(); ?>asset/component/filterDate.js"></script>
<script>
$(document).ready(function() {
    let table = '';

    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Reservation Report', 'รายงานการจอง'); ?>",
            lang: '<?php echo getLang(); ?>',
            filter: {
                'date_type': 'Booked',
                'range': '',
                'from_day': '<?php echo date('Y-m-d'); ?>',
                'to_day': '<?php echo date('Y-m-d'); ?>',
                'month': '<?php echo date('Y-m'); ?>'
            },
            reservations: <?php echo json_encode($reservations); ?>
        },
        mounted() {
            table = $("#reservationReportTable").DataTable({
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']]
            });

            $("#summaryTable").DataTable({
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                "bPaginate": false,
                "bFilter": false,
                "bInfo": false
            });
        },
        methods: {
            editBooking: function(id) {
                <?php if (has_permission('reservation_report', 'edit')) : ?>
                location.href = "<?php echo edit_booking_url(); ?>"+ id;
                <?php endif; ?>
            },
            loadReservation: function(id) {
                let self = this;
                $.post("<?php echo get_reservation_report_url(); ?>", this.filter, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        table.destroy();
                        self.reservations = res.message;
                        console.log(res);
                        setTimeout(() => {
                            table = $("#reservationReportTable").DataTable({
                                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']]
                            });
                        }, 100);
                    }
                });
            },
            exportTable: function() {
                let len = table.page.len();
                let page = table.page.info().page;
                table.page.len(-1).draw();

                $("#exportTable").table2csv({
                    filename: 'Reservation Report.csv'
                });

                table.page.len(len).draw();
                table.page(page).draw(false);
            },
            changeFilter: function(v) {
                //console.log(v);
                this.filter = v;
                this.loadReservation();
            }
        }
    });
});
</script>