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
                        <li class="breadcrumb-item"><a href="<?php echo dashboard_url(); ?>">{{ menu }}</a></li>
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

                    <div class="row" style="margin-top:25px;">
                        <div class="col-md-4" style="min-width:300px; height:130px; margin-top:5px;">
                            <div style="font-weight:bold; overflow:hidden; white-space:nowrap; border:1px solid #e0dcdc; padding-left:15px; width:100%; height:40px; line-height:40px; background-color:#e0dcdc;">
                                <?php echo _r('Daily Booking', 'Booking วันนี้'); ?>: <font color="blue">{{ booking.length }}</font>
                            </div>
                            <div style="padding:2px; font-size:12px; overflow:auto; border:1px solid #e0dcdc; width:100%; height:90px;">
                                <span v-for="b in booking">
                                    <div style="width:100%; height:28px; overflow:hidden; white-space:nowrap; display: flex;">
                                        <button :class="'btn btn-xs btn-'+ getBsClass(b.status)" style="padding-left:0; padding-right:0; margin-top:4px; border-radius:0px; width:100px;" @click="editBooking(b.id_booking)">{{ b.booking_number }}</button>
                                        <span style="padding-left:3px; line-height:27px; max-width:calc(100% - 100px); display:inline-block; overflow:hidden; text-overflow:ellipsis;">{{ b.guest_name }}</span>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4" style="min-width:300px; height:130px; margin-top:5px;">
                            <div style="font-weight:bold; overflow:hidden; white-space:nowrap; border:1px solid #e0dcdc; padding-left:15px; width:100%; height:40px; line-height:40px; background-color:#e0dcdc;">
                                <?php echo _r('Waiting Transfer', 'Booking รอการยืนยัน'); ?>: <font color="blue">{{ booking.length - confirmedBookingCount() }}</font>
                            </div>
                            <div style="padding:2px; font-size:12px; overflow:auto; border:1px solid #e0dcdc; width:100%; height:90px;">
                                <span v-for="b in booking">
                                    <div style="width:100%; height:28px; overflow:hidden; white-space:nowrap; display: flex;" v-if="b.status == 'Booked' || b.status == 'Verifying'">
                                        <button :class="'btn btn-xs btn-'+ getBsClass(b.status)" style="padding-left:0; padding-right:0; margin-top:4px; border-radius:0px; width:100px;" @click="editBooking(b.id_booking)">{{ b.booking_number }}</button>
                                        <span style="padding-left:3px; line-height:27px; max-width:calc(100% - 100px); display:inline-block; overflow:hidden; text-overflow:ellipsis;">{{ b.guest_name }}</span>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4" style="min-width:300px; height:130px; margin-top:5px;">
                            <div style="font-weight:bold; overflow:hidden; white-space:nowrap; border:1px solid #e0dcdc; padding-left:15px; width:100%; height:40px; line-height:40px; background-color:#e0dcdc;">
                                <?php echo _r('Confirmed Booking', 'Booking ที่ยืนยันแล้ว'); ?>: <font color="blue">{{ confirmedBookingCount() }}</font>
                            </div>
                            <div style="padding:2px; font-size:12px; overflow:auto; border:1px solid #e0dcdc; width:100%; height:90px;">
                                <span v-for="b in booking">
                                    <div style="width:100%; height:28px; overflow:hidden; white-space:nowrap; display: flex;" v-if="b.status == 'Confirmed'">
                                        <button :class="'btn btn-xs btn-'+ getBsClass(b.status)" style="padding-left:0; padding-right:0; margin-top:4px; border-radius:0px; width:100px;" @click="editBooking(b.id_booking)">{{ b.booking_number }}</button>
                                        <span style="padding-left:3px; line-height:27px; max-width:calc(100% - 100px); display:inline-block; overflow:hidden; text-overflow:ellipsis;">{{ b.guest_name }}</span>
                                    </div>
                                </span>
                            </div>    
                        </div>
                    </div>

                    <div class="row" style="margin-top:25px;">
                        <div class="col-md-4" style="min-width:300px; height:350px; margin-top:5px;">
                            <div style="color:white; font-weight:bold; overflow:hidden; white-space:nowrap; border:1px solid #e0dcdc; padding-left:15px; padding-right:10px; width:100%; height:40px; line-height:40px; background-color:#0275d8;">
                                <?php echo _r('Today', 'วันนี้'); ?> <span style="float:right; font-weight:normal;">{{ <?php echo _r('formatDate(today)', 'formatDateThai(today)'); ?> }}</span>
                            </div>
                            <div style="padding:8px; font-size:15px; overflow:auto; border:1px solid #e0dcdc; width:100%; height:310px;">
                                <div class="row" style="overflow:hidden; white-space:nowrap; padding-left:12px;">
                                    <div style="width:49%;"><span><b><?php echo _r('Occupied', 'จองแล้ว'); ?>:</b></span> {{ occupied.today.occupied }}%</div>
                                    <div style="width:49%;" class="text-right"><span><b><?php echo _r('Available', 'ว่าง'); ?>:</b></span> {{ occupied.today.available }}</div>
                                </div>
                                <div class="row" style="margin-top:20px; padding-left:12px;">
                                    <div><b><u><?php echo _r('Guest Arriving Today', 'ลูกค้าที่จะเข้าพักวันนี้'); ?>:</u></b></div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px;" v-for="a in occupied.today.arriving">
                                        <button class="btn btn-secondary" style="width:40px; float:left; padding:6px 10px 6px 10px; border:0px; border-radius:50%; background-color:#e0dcdc; color:black;" @click="editBooking(a.id_booking)">
                                            <i class="fa fa-credit-card"></i>
                                        </button>
                                        <span style="font-size:13px; float:left; width:calc(100% - 40px); height:100%; padding-left:7px; margin-top:-2px;">
                                            <div style="width:100%; height:50%;"><b><?php echo _r('Guest', 'ชื่อ'); ?>:</b> {{ a.guest_name }}</div>
                                            <div style="width:100%; height:50%;">
                                                <i class="fa fa-user"></i> {{ a.number_of_adults }} &nbsp;&nbsp;&nbsp;<i class="fa fa-child"></i> {{ a.number_of_children }}
                                                <span style="float:right; padding-right:8px;"><b>{{ a.room_number }}</b></span>
                                            </div>
                                        </span>                                        
                                    </div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px; padding-left:12px;" v-if="occupied.today.arriving.length == 0"><?php echo _r('No guest arriving today', 'ไม่มีลูกค้าที่จะเข้าพักวันนี้'); ?></div>

                                    <div style="margin-top:15px;"><b><u><?php echo _r('Guest Checkout Today', 'ลูกค้าที่จะ checkout วันนี้'); ?>:</u></b></div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px;" v-for="c in occupied.today.checking_out">
                                        <button class="btn btn-secondary" style="width:40px; float:left; padding:6px 10px 6px 10px; border:0px; border-radius:50%; background-color:#e0dcdc; color:black;" @click="editBooking(c.id_booking)">
                                            <i class="fa fa-credit-card"></i>
                                        </button>
                                        <span style="font-size:13px; float:left; width:calc(100% - 40px); height:100%; padding-left:7px; margin-top:-2px;">
                                            <div style="width:100%; height:50%;"><b><?php echo _r('Guest', 'ชื่อ'); ?>:</b> {{ c.guest_name }}</div>
                                            <div style="width:100%; height:50%;">
                                                <i class="fa fa-user"></i> {{ c.number_of_adults }} &nbsp;&nbsp;&nbsp;<i class="fa fa-child"></i> {{ c.number_of_children }}
                                                <span style="float:right; padding-right:8px;"><b>{{ c.room_number }}</b></span>
                                            </div>
                                        </span>                                        
                                    </div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px; padding-left:12px;" v-if="occupied.today.checking_out.length == 0"><?php echo _r('No guest checking out today', 'ไม่มีลูกค้าที่จะ checkout วันนี้'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="min-width:300px; height:350px; margin-top:5px;">
                            <div style="color:white; font-weight:bold; overflow:hidden; white-space:nowrap; border:1px solid #e0dcdc; padding-left:15px; padding-right:10px; width:100%; height:40px; line-height:40px; background-color:#0275d8;">
                                <?php echo _r('Tomorrow', 'พรุ่งนี้'); ?> <span style="float:right; font-weight:normal;">{{ <?php echo _r('formatDate(tomorrow)', 'formatDateThai(tomorrow)'); ?> }}</span>
                            </div>
                            <div style="padding:8px; font-size:15px; overflow:auto; border:1px solid #e0dcdc; width:100%; height:310px;">
                                <div class="row" style="overflow:hidden; white-space:nowrap; padding-left:12px;">
                                    <div style="width:49%;"><span><b><?php echo _r('Occupied', 'จองแล้ว'); ?>:</b></span> {{ occupied.tomorrow.occupied }}%</div>
                                    <div style="width:49%;" class="text-right"><span><b><?php echo _r('Available', 'ว่าง'); ?>:</b></span> {{ occupied.tomorrow.available }}</div>
                                </div>
                                <div class="row" style="margin-top:20px; padding-left:12px;">
                                    <div><b><u><?php echo _r('Guest Arriving Tomorrow', 'ลูกค้าที่จะเข้าพักพรุ่งนี้'); ?>:</u></b></div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px;" v-for="a in occupied.tomorrow.arriving">
                                        <button class="btn btn-secondary" style="width:40px; float:left; padding:6px 10px 6px 10px; border:0px; border-radius:50%; background-color:#e0dcdc; color:black;" @click="editBooking(a.id_booking)">
                                            <i class="fa fa-credit-card"></i>
                                        </button>
                                        <span style="font-size:13px; float:left; width:calc(100% - 40px); height:100%; padding-left:7px; margin-top:-2px;">
                                            <div style="width:100%; height:50%;"><b><?php echo _r('Guest', 'ชื่อ'); ?>:</b> {{ a.guest_name }}</div>
                                            <div style="width:100%; height:50%;">
                                                <i class="fa fa-user"></i> {{ a.number_of_adults }} &nbsp;&nbsp;&nbsp;<i class="fa fa-child"></i> {{ a.number_of_children }}
                                                <span style="float:right; padding-right:8px;"><b>{{ a.room_number }}</b></span>
                                            </div>
                                        </span>                                        
                                    </div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px; padding-left:12px;" v-if="occupied.tomorrow.arriving.length == 0"><?php echo _r('No guest arriving tomorrow', 'ไม่มีลูกค้าที่จะเข้าพักพรุ่งนี้'); ?></div>

                                    <div style="margin-top:15px;"><b><u><?php echo _r('Guest Checkout Tomorrow', 'ลูกค้าที่จะ checkout พรุ่งนี้'); ?>:</u></b></div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px;" v-for="c in occupied.tomorrow.checking_out">
                                        <button class="btn btn-secondary" style="width:40px; float:left; padding:6px 10px 6px 10px; border:0px; border-radius:50%; background-color:#e0dcdc; color:black;" @click="editBooking(c.id_booking)">
                                            <i class="fa fa-credit-card"></i>
                                        </button>
                                        <span style="font-size:13px; float:left; width:calc(100% - 40px); height:100%; padding-left:7px; margin-top:-2px;">
                                            <div style="width:100%; height:50%;"><b><?php echo _r('Guest', 'ชื่อ'); ?>:</b> {{ c.guest_name }}</div>
                                            <div style="width:100%; height:50%;">
                                                <i class="fa fa-user"></i> {{ c.number_of_adults }} &nbsp;&nbsp;&nbsp;<i class="fa fa-child"></i> {{ c.number_of_children }}
                                                <span style="float:right; padding-right:8px;"><b>{{ c.room_number }}</b></span>
                                            </div>
                                        </span>                                        
                                    </div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px; padding-left:12px;" v-if="occupied.tomorrow.checking_out.length == 0"><?php echo _r('No guest checking out tomorrow', 'ไม่มีลูกค้าที่จะ checkout พรุ่งนี้'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" style="min-width:300px; height:350px; margin-top:5px;">
                            <div style="color:white; font-weight:bold; overflow:hidden; white-space:nowrap; border:1px solid #e0dcdc; padding-left:15px; padding-right:10px; width:100%; height:40px; line-height:40px; background-color:#0275d8;">
                                <?php echo _r('In', 'ใน'); ?> {{ days }} <?php echo _r('Days', 'วัน'); ?>
                                <span style="float:right; font-weight:normal; padding-top:0px;">
                                    <input type="text" id="next_day" v-model="next_day" style="text-align:right; width:80px; height:100%;">
                                </span>
                            </div>
                            <div style="padding:8px; font-size:15px; overflow:auto; border:1px solid #e0dcdc; width:100%; height:310px;">
                                <div class="row" style="overflow:hidden; white-space:nowrap; padding-left:12px;">
                                    <div style="width:49%;"><span><b><?php echo _r('Occupied', 'จองแล้ว'); ?>:</b></span> {{ occupied.next_day.occupied }}%</div>
                                    <div style="width:49%;" class="text-right"><span><b><?php echo _r('Available', 'ว่าง'); ?>:</b></span> {{ occupied.next_day.available }}</div>
                                </div>
                                <div class="row" style="margin-top:20px; padding-left:12px;">
                                    <div><b><u><?php echo _r('Guest Arriving In', 'ลูกค้าที่จะเข้าพักใน'); ?> {{ days }} <?php echo _r('Days', 'วัน'); ?>:</u></b></div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px;" v-for="a in occupied.next_day.arriving">
                                        <button class="btn btn-secondary" style="width:40px; float:left; padding:6px 10px 6px 10px; border:0px; border-radius:50%; background-color:#e0dcdc; color:black;" @click="editBooking(a.id_booking)">
                                            <i class="fa fa-credit-card"></i>
                                        </button>
                                        <span style="font-size:13px; float:left; width:calc(100% - 40px); height:100%; padding-left:7px; margin-top:-2px;">
                                            <div style="width:100%; height:50%;"><b><?php echo _r('Guest', 'ชื่อ'); ?>:</b> {{ a.guest_name }}</div>
                                            <div style="width:100%; height:50%;">
                                                <i class="fa fa-user"></i> {{ a.number_of_adults }} &nbsp;&nbsp;&nbsp;<i class="fa fa-child"></i> {{ a.number_of_children }}
                                                <span style="float:right; padding-right:8px;"><b>{{ a.room_number }}</b></span>
                                            </div>
                                        </span>                                        
                                    </div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px; padding-left:12px;" v-if="occupied.next_day.arriving.length == 0"><?php echo _r('No guest arriving in', 'ไม่มีลูกค้าที่จะเข้าพักใน'); ?> {{ days }} <?php echo _r('days', 'วัน'); ?></div>

                                    <div style="margin-top:15px;"><b><u><?php echo _r('Guest Checkout In', 'ลูกค้าที่จะ checkout ใน'); ?> {{ days }} <?php echo _r('Days', 'วัน'); ?>:</u></b></div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px;" v-for="c in occupied.next_day.checking_out">
                                        <button class="btn btn-secondary" style="width:40px; float:left; padding:6px 10px 6px 10px; border:0px; border-radius:50%; background-color:#e0dcdc; color:black;" @click="editBooking(c.id_booking)">
                                            <i class="fa fa-credit-card"></i>
                                        </button>
                                        <span style="font-size:13px; float:left; width:calc(100% - 40px); height:100%; padding-left:7px; margin-top:-2px;">
                                            <div style="width:100%; height:50%;"><b><?php echo _r('Guest', 'ชื่อ'); ?>:</b> {{ c.guest_name }}</div>
                                            <div style="width:100%; height:50%;">
                                                <i class="fa fa-user"></i> {{ c.number_of_adults }} &nbsp;&nbsp;&nbsp;<i class="fa fa-child"></i> {{ c.number_of_children }}
                                                <span style="float:right; padding-right:8px;"><b>{{ c.room_number }}</b></span>
                                            </div>
                                        </span>                                        
                                    </div>
                                    <div style="width:100%; padding-top:5px; padding-bottom:5px; padding-left:12px;" v-if="occupied.next_day.checking_out.length == 0"><?php echo _r('No guest checking out in', 'ไม่มีลูกค้าที่จะ checkout ใน'); ?> {{ days }} <?php echo _r('days', 'วัน'); ?></div>
                                </div>
                            </div>   
                        </div>
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
            menu: "<?= _r('Dashboard', 'แดชบอร์ด'); ?>",
            booking: <?php echo json_encode($booking); ?>,
            occupied: <?php echo json_encode($occupied); ?>,
            days: '<?php echo $days; ?>',
            today: '<?php echo $today; ?>',
            tomorrow: '<?php echo $tomorrow; ?>',
            next_day: '<?php echo $next_day; ?>'
        },
        mounted() {
            let self = this;
            $("#next_day").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.next_day = d;
                    self.days = dateDiff(convertDateDash(self.today), convertDateDash(d));
                    self.changeNextDay();
                }
            });
        },
        methods: {
            confirmedBookingCount: function() {
                let count = 0;
                this.booking.forEach((v) => {
                    if (v.status == 'Confirmed') {
                        count++;
                    }
                })
                return count;
            },
            editBooking: function(id) {
                <?php if (has_permission('dashboard', 'edit')) : ?>
                location.href = "<?php echo edit_booking_url(); ?>"+ id;
                <?php endif; ?>
            },
            changeNextDay: function() {
                let self = this;
                let param = {date: convertDateDash(this.next_day)};

                $.post("<?php echo get_occupied_by_date_url(); ?>", param, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        self.occupied.next_day = res.message;
                    }
                });
            }
        }
    });
});
</script>