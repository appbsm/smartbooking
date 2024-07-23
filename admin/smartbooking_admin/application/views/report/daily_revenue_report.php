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
                            <a href="<?php echo daily_revenue_report_url(); ?>">{{ menu }}</a>
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
                        <filterdateshort :lang='lang' :filter='filter' :current_date_to='currentDate()' @change-filter="changeFilter"></filterdateshort>
                    </div>

                    <div class="text-right" style="width:100%; margin-top:10px;">
                        <button class="btn btn-sm btn-success btn-export" @click="exportTable()">Export</button>
                    </div>

                    <div class="row" style="margin-top:25px;" v-for="(type, i) in types">
                    <div class="col-md-12" style="max-width:100%;">
                    <h6>{{ type }}</h6>
                    </div>
                        <div class="col-md-12" style="max-width:100%;">
                            <div class="card" :style="'outline:1px solid black; padding:15px; overflow-x:auto; background-color:'+ color[i] +';'">
                                <table :id="type.replace(' ', '') + 'Table'" class="display fixheader result_table" style="min-width:1375px; margin-left:-15px; border:1px !important;">
                                    <thead class="w1920" style="text-align:center; display:block; overflow-x:hidden; overflow-y:scroll; font-size:13px;">
                                        <tr>
                                            <th class="w100"><?= _r('Revenue Type', 'ประเภทรายได้'); ?></th>
                                            <th class="w100"><?= _r('Booking Channel', 'ช่องทางการจอง'); ?></th>
                                            <th class="w100"><?= _r('Check_In Date', 'วัน check-in'); ?></th>
                                            <th class="w100"><?= _r('Stay Date', 'วันที่พัก'); ?></th>
                                            <th class="w100"><?= _r('Booking Number', 'หมายเลข Booking'); ?></th>
                                            <th class="w100"><?= _r('Order Number', 'หมายเลข Order'); ?></th>
                                            <th class="w160"><?= _r('Item Description', 'รายการ'); ?></th>
                                            <th class="w160"><?= _r('Staff Name', 'สตาฟที่ทำการจอง'); ?></th>
                                            <th class="w60"><?= _r('Credit Term', 'Credit Term'); ?></th>
                                            <th class="w60"><?= _r('Due Date', 'Due Date'); ?></th>

                                            <th class="w60"><?= _r('Total Before Discount', 'Total before Discount'); ?></th>
                                            <th class="w60"><?= _r('Discount', 'ส่วนลด'); ?></th>
                                            <th class="w60"><?= _r('Sub Total', 'ยอดก่อนรวม Vat'); ?></th>
                                            <th class="w60">Vat</th>                                            
                                            <th class="w60"><?= _r('Grand Total', 'Grand Total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody style="max-height:420px; display:block; overflow-x:hidden; overflow-y:scroll;">
                                        <tr v-for="r in filterType(revenue, type)">
                                            <td class="w116 text-center" :data-order="r.revenue_type">{{ r.revenue_type }}
                                            <td class="w116 text-center" :data-order="r.booking_channel">{{ r.booking_channel }}</td>
                                            <td class="w116 text-center" :data-order="r.check_in_date">{{ convertDateSlash(r.check_in_date) }}</td>
                                            <td class="w116 text-center" :data-order="r.date">{{ convertDateSlash(r.date) }}</td>

                                            <?php if (has_permission('daily_revenue_report', 'edit')) : ?>
                                            <td class="w116 text-center" :data-order="r.booking_number" @click="editBooking(r.id_booking)"><a href="#">{{ r.booking_number }}</a></td>
                                            <td class="w116 text-center" :data-order="r.order_number" @click="editOrder(r.id_order)"><a href="#">{{ r.order_number }}</a></td>
                                            <?php else: ?>
                                            <td class="w116 text-center" :data-order="r.booking_number">{{ r.booking_number }}</td>
                                            <td class="w116 text-center" :data-order="r.order_number">{{ r.order_number }}</td>
                                            <?php endif; ?>

                                            <td class="w176" :data-order="r.item_description">{{ r.item_description }}</td>
                                            <td class="w176" :data-order="r.staff_name">{{ r.staff_name }}</td>
                                            <td class="w76" :data-order="r.credit_term">{{ (r.credit_term > 0) ? r.credit_term : '' }}</td>
                                            <td class="w76" :data-order="r.due_date">{{ (r.credit_due_date != '' && r.credit_term > 0) ? convertDateSlash(r.credit_due_date) : ''}}</td>

                                            <td class="w76 text-right" :data-order="r.total_before_discount">{{ formatBaht(r.total_before_discount) }}</td>
                                            <td class="w76 text-right" :data-order="r.discount">{{ formatBaht(r.discount) }}</td>
                                            <td class="w76 text-right" :data-order="r.sub_total">{{ formatBaht(r.sub_total) }}</td>                                            
                                            <td class="w76 text-right" :data-order="r.vat">{{ formatBaht(r.vat) }}</td>                                            
                                            <td class="w76 text-right" :data-order="r.total">{{ formatBaht(r.total) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table :id="type.replace(' ', '') + 'SummaryTable'" class="display fixheader result_table" style="margin-left:-15px; margin-top:10px; font-weight:bold; font-size:13px; border:1px !important;">
                                    <thead style="display:none;"><tr><th v-for="i in 15">{{ i }}</th></tr></thead>
                                    <tbody style="max-height:420px; display:block; overflow-x:hidden; overflow-y:hidden;">
                                        <tr class="sum-row">
                                            <td class="w116 text-left"><?= _r('Total', 'ยอดรวม'); ?></td>
                                            <td class="w116"></td>
                                            <td class="w116"></td>
                                            <td class="w116"></td>
                                            <td class="w116"></td>
                                            <td class="w116"></td>
                                            <td class="w176"></td>
                                            <td class="w176"></td>
                                            <td class="w76"></td>
                                            <td class="w76"></td>
                                            
                                            <td class="w76">{{ formatBaht(sumByCol(filterType(revenue, type), 'total_before_discount')) }}</td>
                                            <td class="w76">{{ formatBaht(sumByCol(filterType(revenue, type), 'discount')) }}</td>
                                            <td class="w76">{{ formatBaht(sumByCol(filterType(revenue, type), 'sub_total')) }}</td>
                                            <td class="w76">{{ formatBaht(sumByCol(filterType(revenue, type), 'vat')) }}</td>                                            
                                            <td class="w76">{{ formatBaht(sumByCol(filterType(revenue, type), 'total')) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--hr style="border:1px dashed black; width:50%; margin:auto; margin-top:25px;"-->
                        </div>
                    </div>

                    <!-- Export -->
                    <table id="exportTable">
                        <thead>
                            <tr>
                                <th><?= _r('Revenue Type', 'ประเภทรายได้'); ?></th>
                                <th><?= _r('Booking Channel', 'ช่องทางการจอง'); ?></th>
                                <th><?= _r('Check_In Date', 'วัน check-in'); ?></th>
                                <th><?= _r('Stay Date', 'วันที่พัก'); ?></th>
                                <th><?= _r('Booking Number', 'หมายเลข Booking'); ?></th>
                                <th><?= _r('Order Number', 'หมายเลข Order'); ?></th>
                                <th><?= _r('Item Description', 'รายการ'); ?></th>
                                <th><?= _r('Credit Term', 'Credit Term'); ?></th>
                                <th><?= _r('Due Date', 'Due Date'); ?></th>
                                <th><?= _r('Staff Name', 'สตาฟที่ทำการจอง'); ?></th>
                                
                                <th><?= _r('Total Before Discount', 'Total Before Discount'); ?></th>
                                <th><?= _r('Discount', 'ส่วนลด'); ?></th>                                                                
                                <th><?= _r('Total', 'ยอดรวม'); ?></th>
                                <th>Vat</th>
                                <th><?= _r('Grand Total', 'Grand Total'); ?></th>
                            </tr>
                        </thead>
                        <tbody v-for="type in types">
                            
                            <tr v-for="r in filterType(revenue, type)">
                                <td>{{ r.revenue_type }}</td>
                                <td>{{ r.booking_channel }}</td>
                                <td>{{ convertDateSlash(r.check_in_date) }}</td>
                                <td>{{ convertDateSlash(r.date) }}</td>
                                <td>{{ r.booking_number }}</td>
                                <td>{{ r.order_number }}</td>
                                <td>{{ r.item_description }}</td>
                                <td>{{ (r.credit_term > 0) ? r.credit_term : '' }}</td>
                                <td>{{ (r.credit_due_date != '' && r.credit_term > 0) ? convertDateSlash(r.credit_due_date) : '' }}</td>
                                <td>{{ r.staff_name }}</td>
                               
                                <td>{{ formatBaht(r.total_before_discount) }}</td>
                                <td>{{ formatBaht(r.discount) }}</td>
                                <td>{{ formatBaht(r.sub_total) }}</td>
                                <td>{{ formatBaht(r.vat) }}</td>                                
                                <td>{{ formatBaht(r.total) }}</td>
                            </tr>
                            <tr><td v-for="i in 15">&nbsp;</td></tr>
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
                                
                                <td>{{ formatBaht(sumByCol(filterType(revenue, type), 'total_before_discount')) }}</td>
                                <td>{{ formatBaht(sumByCol(filterType(revenue, type), 'discount')) }}</td>
                                <td>{{ formatBaht(sumByCol(filterType(revenue, type), 'sub_total')) }}</td>
                                <td>{{ formatBaht(sumByCol(filterType(revenue, type), 'vat')) }}</td>
                                <td>{{ formatBaht(sumByCol(filterType(revenue, type), 'total')) }}</td>
                            </tr>
                            <tr><td v-for="i in 15">&nbsp;</td></tr>
                            <tr><td v-for="i in 15">&nbsp;</td></tr>
                            <tr><td v-for="i in 15">&nbsp;</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="<?php echo site_url(); ?>asset/component/filterDateShort.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.10.3/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    let table = [];

    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Daily Revenue Report', 'รายงานรายได้ประจำวัน'); ?>",
            lang: '<?php echo getLang(); ?>',
            filter: {
                'range': '',
                'from_day': '<?php echo date('Y-m-d'); ?>',
                'to_day': '<?php echo date('Y-m-d'); ?>',
                'month': '<?php echo date('Y-m'); ?>'
            },
            revenue: <?php echo json_encode($revenue); ?>,
            types: ['Room Booking', 'Extra Charge', 'Cancellations'],
            color: ['#e6ffe6', '#ffffe6', '#ffe6e6']
        },
        mounted() {
            
            this.types.forEach((v, i) => {
                table[i] = $('#'+ v.replace(' ', '') +'Table').DataTable({
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']]
                });
            });

            this.types.forEach((v, i) => {
                $('#'+ v.replace(' ', '') +'SummaryTable').DataTable({
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                    "bPaginate": false,
                    "bFilter": false,
                    "bInfo": false
                });
            });
        },
        methods: {
            editBooking: function(id) {
                <?php if (has_permission('daily_revenue_report', 'edit')) : ?>
                location.href = "<?php echo edit_booking_url(); ?>"+ id;
                <?php endif; ?>
            },
            editOrder: function(id) {
                <?php if (has_permission('daily_revenue_report', 'edit')) : ?>
                location.href = "<?php echo edit_order_url(); ?>"+ id;
                <?php endif; ?>
            },
            loadRevenue: function(id) {
                let self = this;

                $.post("<?php echo get_daily_revenue_report_url(); ?>", this.filter, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        self.types.forEach((v, i) => {
                            table[i].destroy();
                        });

                        self.revenue = res.message;
                        console.log(self.revenue);
                        setTimeout(() => {
                            self.types.forEach((v, i) => {
                                table[i] = $('#'+ v.replace(' ', '') +'Table').DataTable({
                                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']]
                                });
                            });
                        }, 100);
                    }
                });
            },
            exportTable: function() {
                let len = [];
                let page = [];
                this.types.forEach((v, i) => {
                    len[i] = table[i].page.len();
                    page[i] = table[i].page.info().page;
                    table[i].page.len(-1).draw();
                });

                $("#exportTable").table2csv({
                    filename: 'Daily Revenue.csv'
                });

                this.types.forEach((v, i) => {
                    table[i].page.len(len[i]).draw();
                    table[i].page(page[i]).draw(false);
                });
            },
            changeFilter: function(v) {
                this.filter = v;
                console.log(v);
                this.loadRevenue();
            },
            filterType: function(arr, type) {
                let tmp = [];
                arr.forEach((v) => {
                    if (v.revenue_type == type) {
                        tmp.push(v);
                    }
                });
                return tmp;
            }
        }
    });
});
</script>