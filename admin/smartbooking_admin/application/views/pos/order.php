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
                        <li class="breadcrumb-item"><?= _r('POS', 'จัดการออเดอร์'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo order_url(); ?>">{{ menu }}</a>
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
                <?php if (has_permission('order', 'edit')) : ?>
                <span style="width:100%; text-align:right;">
                    <a href="<?php echo edit_order_url(); ?>" style="color:white;">    
                        <button class="btn" style="float:right; width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-top:-25px;">
                            <?= _r('Add New Order', 'เพิ่มออเดอร์ใหม่'); ?>
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
                            <small><b><?= _r('Order Number', 'หมายเลข Order'); ?></b></small>
                            <input type="text" class="form-control" v-model="filter.order_number" @keyup="getOrder()">
                        </div>
                        <div class="col-md-4">
                            <small><b><?= _r('Order Status', 'สถานะ Order'); ?></b></small>
                            <select class="form-control" v-model="filter.order_status" @change="getOrder()">
                                <option value="All"><?= _r('All', 'ทั้งหมด'); ?></option>
                                <option value="Ordered">Ordered</option>
                                <option value="Verifying">Verifying</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Closed">Closed</option>
                                <option value="Cancel">Cancel</option>
                                <option value="Expired">Expired</option>
                            </select>
                        </div>
                    </div>

                    <filterdateorder :lang='lang' :filter='filter' @change-filter="changeFilter"></filterdateorder>
                </div>


                <div class="col-md-12" style="margin-top:10px; max-width:100%; overflow:auto;">
                    <imagemodal :showimage='show_image' :title="_r('Transfer Slip', 'สลิปโอนเงิน', lang)"></imagemodal>
                    <table id="orderTable" class="display" style="width:100%;">
                        <thead style="text-align:center;">
                            <tr>
                                <th class="w100"><?= _r('Order Number', 'หมายเลข Order'); ?></th>
                                <th class="w70"><?= _r('Created Date', 'วันที่ทำรายการ'); ?></th>
                                <th><?= _r('Guest Name', 'ชื่อลูกค้า'); ?></th>
                                <th class="w55"><?= _r('Service Date', 'วันที่ใช้บริการ'); ?></th>
                                <th class="w40"><?= _r('Total Price', 'ราคารวม'); ?></th>
                                <th class="w60"><?= _r('Transferred Amount', 'ยอดเงินที่<br>ชำระแล้ว'); ?></th>
                                <th class="w110"><?= _r('Transfer Slip', 'สลิปโอนเงิน'); ?></th>
                                <th class="w90"><?= _r('Order Status', 'สถานะ Order'); ?></th>
                                <?php if (has_permission('order', 'view') || has_permission('order', 'delete')) : ?>
                                <th class="w90"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="o in order">
                                <td class="text-center">{{ o.order_number }}</td>
                                <td class="text-center" :data-order="o.date_created">{{ convertDateSlash(o.date_created) }}</td>
                                <td>{{ o.guest_name }}</td>
                                <td class="text-center" :data-order="o.order_date">{{ convertDateSlash(o.order_date) }}</td>
                                <td class="text-right">{{ formatBaht(o.grand_total) }}</td>
                                <td class="text-right">{{ formatBaht(o.transferred_amount) }}</td>
                                <td>
                                    <img style="height:50px; margin-left:3px; cursor:zoom-in;" v-for="p in o.order_payment" :src="p.transfer_slip" data-toggle="modal" data-target="#showImageModal" @click="showImage(p.transfer_slip)">
                                </td>
                                <td class="text-center">
                                    <span :class="'badge badge-'+ getBsClass(o.status)">{{ o.status }}</span>
                                </td>
                                <?php if (has_permission('order', 'view') || has_permission('order', 'delete')) : ?>
                                <td class="text-center">
                                    <?php if (has_permission('order', 'view')) : ?>
                                    <button class="btn btn-sm btn-info" @click="viewOrder(o.id_order)">
                                        <i class="fa fa-file-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" @click="editOrder(o.id_order)">
                                        <i class="fa fa-pencil" style="color:black !important;"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if (has_permission('order', 'delete')) : ?>
                                    <button class="btn btn-sm btn-danger" style="padding: 4px 11px 4px 11px;" @click="deleteOrder(o.id_order)">
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
<script src="<?php echo site_url(); ?>asset/component/filterDateOrder.js"></script>
<script src="<?php echo site_url(); ?>asset/component/imageModal.js"></script>
<script>
$(document).ready(function() {
    let table = '';

    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Order', 'ออเดอร์'); ?>",
            lang: '<?php echo getLang(); ?>',
            filter: {
                'project': '<?php echo $projects[0]['id_project_info']; ?>',
                'room': 'All',
                'order_number': '',
                'order_status': 'All',
                'date_type': 'Created',
                'range': '',
                'from_day': '<?php echo date('Y-m-d'); ?>',
                'to_day': '<?php echo date('Y-m-d'); ?>',
                'month': '<?php echo date('Y-m'); ?>',
                'guest_id': '',
                'guest_name': ''
            },
            order: <?php echo json_encode($order); ?>,
            projects: <?php echo json_encode($projects); ?>,
            rooms: <?php echo json_encode($rooms); ?>,
            searching: false,
            search_guest_url: '<?php echo search_guest_url(); ?>',
            show_image: ''
        },
        mounted() {
            table = $("#orderTable").DataTable();
        },
        methods: {
            viewOrder: function(id) {
                <?php if (has_permission('order', 'view')) : ?>
                window.open("<?php echo show_order_url(); ?>"+ id, '_blank').focus();
                <?php endif; ?>
            },
            editOrder: function(id) {
                <?php if (has_permission('order', 'view')) : ?>
                location.href = "<?php echo edit_order_url(); ?>"+ id;
                <?php endif; ?>
            },
            deleteOrder: function(id) {
                if (confirm("Delete this Order ?")) {
                    let param = {'id': id};
                    $.post("<?php echo delete_order_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                            return;
                        } else {
                            alert('Delete Order Success');
                            location.reload();
                        }
                    });
                }
            },
            getOrder: function() {
                let self = this;
                if (this.searching) {
                    return;
                }
                this.searching = true;

                $.post("<?php echo get_order_url(); ?>", this.filter, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        table.destroy();
                        self.order = res.message;
                        setTimeout(() => {
                            table = $("#orderTable").DataTable();
                            self.searching = false;
                        }, 10);
                    }
                });
            },
            changeFilter: function(v) {
                this.filter = v;
                this.getOrder();
            }
        }
    });
});
</script>