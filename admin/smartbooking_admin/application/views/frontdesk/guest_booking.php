<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" v-cloak style="min-width:300px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= _r('Front Desk', 'แผนกต้อนรับ'); ?></li>
                        <li class="breadcrumb-item"><a href="<?php echo guest_booking_url(); ?>">{{ menu }}</a></li>
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
                        <filterguest :lang='lang' :filter='filter' @change-filter="changeFilter" :search_guest_url='search_guest_url'></filterguest>
                        <filterdate :lang='lang' :filter='filter' @change-filter="changeFilter"></filterdate>
                    </div>

                    <div class="row" style="margin-top:30px;">
                        <div class="col-md-4" style="min-width:300px; margin-top:15px;" v-for="g in guest_info">
                            <div style="width:100%; height:200px; border:1px solid black; padding-left:5px; padding-right:5px;">
                                <div style="height:40px; margin-bottom:5px;">
                                    <div style="width:49%; display:inline-block;">
                                        <?= _r('Room', 'ห้อง'); ?> {{ g.room_number }}
                                        <div style="font-size:12px; margin-top:-5px;"><i>({{ <?= _r('g.room_type_name_en', 'g.room_type_name_th'); ?> }})</i></div>
                                    </div>
                                    <div style="width:49%; float:right;" class="text-right">
                                        <button :class="'btn btn-sm btn-'+ getBsClass(g.status)" style="border-radius:30px; width:120px; height:25px; font-size:12px; font-weight:bold; line-height:5px; margin-top:5px;" @click="editBooking(g.id_booking)">{{ g.status }}</button>
                                    </div>
                                </div>

                                <div style="height:30px; font-size:14px;">
                                    <div style="width:49%; display:inline-block; padding-left:12px;">
                                        <i class="fa fa-sign-in-alt"></i> &nbsp;{{ <?= _r('formatDateShort(g.check_in_date)', 'formatDateThaiShort(g.check_in_date)'); ?> }}
                                    </div>
                                    <div style="width:49%; float:right; padding-right:12px;" class="text-right">
                                        <i class="fa fa-sign-out-alt"></i> &nbsp;{{ <?= _r('formatDateShort(g.check_out_date)', 'formatDateThaiShort(g.check_out_date)'); ?> }}
                                    </div>
                                </div>

                                <div style="height:25px; font-size:14px;">
                                    <div style="width:49%; display:inline-block; padding-left:12px;"><?= _r('Booking Number', 'หมายเลข Booking'); ?></div>
                                    <div style="width:49%; float:right; padding-right:12px;" class="text-right">
                                        {{ g.booking_number }}
                                    </div>
                                </div>
                                <div style="height:25px; font-size:14px;">
                                    <div style="width:49%; display:inline-block; padding-left:12px;"><?= _r('Pax', 'จำนวนผู้เข้าพัก'); ?></div>
                                    <div style="width:49%; float:right; padding-right:12px;" class="text-right">
                                        <i class="fa fa-user"></i> {{ g.number_of_adults }} &nbsp;&nbsp;&nbsp;<i class="fa fa-child"></i> {{ g.number_of_children }}
                                    </div>
                                </div>
                                <div style="height:25px; font-size:14px;">
                                    <div style="width:49%; display:inline-block; padding-left:12px;"><?= _r('Guest', 'ชื่อผู้เข้าพัก'); ?></div>
                                    <div style="width:49%; float:right; padding-right:12px;" class="text-right">
                                        {{ g.guest_name }}
                                    </div>
                                </div>

                                <?php if (has_permission('guest_booking', 'edit')) : ?>
                                <div style="height:30px; font-size:14px; margin-top:10px;" class="text-center">
                                    <button class="btn" style="width:95%; height:100%; background-color:#0275d8; color:white; font-size:15px; line-height:10px;" @click="editBooking(g.id_booking)"><?= _r('Details', 'รายละเอียด'); ?></button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo site_url(); ?>asset/component/filterGuest.js"></script>
<script src="<?php echo site_url(); ?>asset/component/filterDate.js"></script>
<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Guest Booking', 'การจองของผู้เข้าพัก'); ?>",
            lang: '<?php echo getLang(); ?>',
            search_guest_url: '<?php echo search_guest_url(); ?>',
            filter: {
                'guest_id': '',
                'guest_name': '',
                'date_type': 'Booked',
                'range': '',
                'from_day': '<?php echo date('Y-m-d'); ?>',
                'to_day': '<?php echo date('Y-m-d'); ?>',
                'month': '<?php echo date('Y-m'); ?>'
            },
            guest_info: <?php echo json_encode($guest_info); ?>
        },
        mounted() {
        },
        methods: {
            editBooking: function(id) {
                <?php if (has_permission('guest_booking', 'edit')) : ?>
                location.href = "<?php echo edit_booking_url(); ?>"+ id;
                <?php endif; ?>
            },
            loadGuestInfo: function() {
                let self = this;
                $.post("<?php echo get_guest_booking_url(); ?>", this.filter, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        self.guest_info = res.message;
                    }
                });
            },
            changeFilter: function(v) {
                this.filter = v;
                this.loadGuestInfo();
            }
        }
    });
});
</script>