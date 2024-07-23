<!-- Content Header (Page header) -->
<div id="selectMultiRooms" style="z-index:99 !important; visibility:hidden; width:0px; height:0px; border:1px dashed #888888; position:absolute; top:0; left:0;"></div>
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
                        <li class="breadcrumb-item"><a href="<?php echo calendar_url(); ?>">{{ menu }}</a></li>
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
                        <filterdateshort :lang='lang' :filter='filter' :current_date_to='nextWeek()' @change-filter="changeFilter"></filterdateshort>
                        <div class="row">
                            <div class="col-md-6" style="margin-top:5px;">
                                <small>
                                    <b><?= _r('Booking Status', 'สถานะ Booking'); ?></b> (<font color="#dc3545">Booked</font>, <font color="#ffc107">Verifying</font>, <font color="#28a745">Confirmed</font>, <font color="#007bff">Checked-in</font>)
                                </small>
                                <select class="form-control" v-model="filter.booking_status" @change="loadCalendar()">
                                    <option value="All"><?= _r('All', 'ทั้งหมด'); ?></option>
                                    <option value="Booked">Booked</option>
                                    <option value="Verifying">Verifying</option>
                                    <option value="Confirmed">Confirmed</option>
                                    <option value="Checked-in">Checked-in</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:30px; overflow:auto; user-select:none;">
                        <div class="col-md-12" :style="'min-width:'+ (252 + (162 * calendar.dates.length)) +'px;'">
                            <div style="width:100%; height:40px; overflow:hidden; white-space:nowrap;">
                                <div style="background-color:#dddddd; width:250px; height:100%; line-height:35px; float:left; border:1px solid white;" class="text-center"><b><?= _r('Rooms \ Dates', 'ห้อง \ วัน'); ?></b></div>
                                <div style="background-color:#dddddd; width:160px; height:100%; line-height:37px; float:left; border:1px solid white; font-size:14px;" class="text-center" v-for="d in calendar.dates">
                                    {{ <?= _r('formatDateShort(d)', 'formatDateThaiShort(d)'); ?> }}
                                </div>
                            </div>
                            <div style="width:100%; height:40px; overflow:hidden; white-space:nowrap;" v-for="(r, i) in sortRoom()">
                                <div style="width:250px; height:100%; line-height:35px; float:left; border:1px solid #dddddd; padding-left:5px; padding-right:5px;">
                                    <span class="badge badge-success" style="float:left;" v-if="(i == 0 || r.id_room_type != sortRoom()[i - 1].id_room_type)">{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</span>
                                    <span style="float:right;">{{ r.room_number }}</span>
                                </div>
                                <span id="calendar-grid-container">
                                    <div style="width:160px; height:100%; line-height:35px; float:left; border:1px solid #dddddd; cursor:pointer;" class="calendar-grid" v-for="(d, j) in calendar.dates" @click="bookRoom(r, d)" :data-room="i" :data-date="d" :data-col="j"></div>
                                </span>
                                <div class="text-center" @click="editBooking(b.id_booking)" :style="'cursor:pointer; height:20px; font-size:13px; background-color:'+ getColor(b.status) +'; position:absolute; top:'+ ((i * 40) + 50) +'px; left:'+ (342 + (b.grid_start * 160))  +'px; width:'+ (160 * b.grid_length - 10) +'px;'" v-for="b in r.booking">
                                    {{ b.booking_number }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo site_url(); ?>asset/component/filterDateShort.js"></script>
<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Calendar', 'ปฏิทินการจอง'); ?>",
            lang: '<?php echo getLang(); ?>',
            filter: {
                'range': '',
                'from_day': '<?php echo $calendar['start_date']; ?>',
                'to_day': '<?php echo $calendar['end_date']; ?>',
                'month': '<?php echo date('Y-m'); ?>',
                'booking_status': 'All'
            },
            calendar: <?php echo json_encode($calendar); ?>
        },
        mounted() {},
        methods: {
            getColor: function(status) {
                if (status == 'Booked') {
                    return '#dc3545';
                } else if (status == 'Verifying') {
                    return '#ffc107';
                } else if (status == 'Confirmed') {
                    return '#28a745';
                } else if (status == 'Checked-in') {
                    return '#007bff';
                }
            },
            editBooking: function(id) {
                <?php if (has_permission('calendar', 'edit')) : ?>
                location.href = "<?php echo edit_booking_url(); ?>"+ id;
                <?php endif; ?>
            },
            loadCalendar: function() {
                let self = this;
                $.post("<?php echo get_calendar_url(); ?>", this.filter, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        self.calendar = res.message;
                    }
                });
            },
            bookRoom: function(room, date) {
                <?php if (!has_permission('calendar', 'edit')) : ?>
                return;
                <?php endif; ?>

                let valid = this.checkAvailable(room, date);
                if (!valid) {
                    alert("Room is not available in this date");
                    return;
                }

                $.blockUI({css:{'backgroundColor':'#d9d9d9', 'padding-top':'10px'}});
                location.href = "<?php echo edit_booking_url(); ?>?room="+ room.id_room_details +"&check-in-date="+ date;
                setTimeout(() => {
                    $.unblockUI();
                }, 1000);
            },
            checkAvailable: function(room, date) {
                let valid = true;
                room.booking.forEach((v) => {
                    if (v.check_in_date <= date && date < v.check_out_date) {
                        valid = false;
                    }
                });

                return valid;
            },
            sortRoom: function() {
                let tmp = Object.values(this.calendar.room_data);
                tmp.sort(function(a, b) {
                    if (a.id_project_info != b.id_project_info) {
                        return parseInt(a.id_project_info) - parseInt(b.id_project_info);
                    } else {
                        if (a.display_sequence != b.display_sequence) {
                            return parseInt(a.display_sequence) - parseInt(b.display_sequence);
                        } else {
                            return a.room_number.localeCompare(b.room_number);
                        }
                    }
                });
                return tmp;
            },
            changeFilter: function(v) {
                this.filter = v;
                this.loadCalendar();
            }
        }
    });

    /////
    let dragging = false;
    let startX = 0;
    let startY = 0;
    $(document).on('mouseenter', '.calendar-grid', function(e) {
        if (!dragging) {
            $(this).css('background-color', '#ffffcc');
            $('.calendar-grid[data-room="'+ $(this).attr('data-room') +'"][data-col="'+ (parseInt($(this).attr('data-col')) + 1) +'"]').css('background-color', '#ffffcc');
        }
    });
    $(document).on('mouseleave', '.calendar-grid', function(e) {
        if (!dragging) {
            $(this).css('background-color', '');
            $('.calendar-grid[data-room="'+ $(this).attr('data-room') +'"][data-col="'+ (parseInt($(this).attr('data-col')) + 1) +'"]').css('background-color', '');
        }
    });

    $(document).on('mousedown', '#calendar-grid-container', function(e) {
        dragging = true;
        startX = e.pageX;
        startY = e.pageY;
    });

    $(document).on('mouseup', '#calendar-grid-container', function(e) {
        dragging = false;
        let endX = e.pageX;
        let endY = e.pageY;
        let scrollLeft = $(window).scrollLeft();
        let scrollTop = $(window).scrollTop();
        $('#selectMultiRooms').css('visibility', 'hidden');
        $('#selectMultiRooms').css('width', 0);
        $('#selectMultiRooms').css('height', 0);

        let valid = true;
        let count = 0;
        let all_room = [];
        let all_date = [];
        let rooms = app.sortRoom();

        $('.calendar-grid').each((i, v) => {
            $(v).css('background-color', '');
            let left = $(v).offset().left - scrollLeft;
            let top = $(v).offset().top - scrollTop;
            let right = left + 160;
            let bottom = top + 40;

            let room = rooms[$(v).attr('data-room')];
            let date = $(v).attr('data-date');
            if (startX < right && startY < bottom && endX > left && endY > top) {
                all_date.push(date);
                if (!all_room.includes(room.id_room_details)) {
                    all_room.push(room.id_room_details);
                }
            }

            if (startX < right && startY < bottom && endX > right && endY > top) {
                count++;
                if (!app.checkAvailable(room, date)) {
                    valid = false;
                }
            }
        });

        if (count > 0) {
            if (!valid) {
                alert("Room is not available in this period");
            } else {
                $.blockUI({css:{'backgroundColor':'#d9d9d9', 'padding-top':'10px'}});
                location.href = "<?php echo edit_booking_url(); ?>?room="+ all_room.join(',') +"&check-in-date="+ getMin(all_date) +"&check-out-date="+ getMax(all_date);
                setTimeout(() => {
                    $.unblockUI();
                }, 1000);
            }
        }
    });

    $(document).on('mousemove', '#calendar-grid-container', function(e) {
        if (dragging) {
            let endX = e.pageX;
            let endY = e.pageY;
            let scrollLeft = $(window).scrollLeft();
            let scrollTop = $(window).scrollTop();
            $('#selectMultiRooms').css('visibility', 'visible');
            $('#selectMultiRooms').css('left', startX);
            $('#selectMultiRooms').css('top', startY);
            $('#selectMultiRooms').css('width', endX - startX);
            $('#selectMultiRooms').css('height', endY - startY);

            $('.calendar-grid').each((i, v) => {
                let left = $(v).offset().left - scrollLeft;
                let top = $(v).offset().top - scrollTop;
                let right = left + 160;
                let bottom = top + 40;

                if (startX < right && startY < bottom && endX > left && endY > top) {
                    $(v).css('background-color', '#ffffcc');
                } else {
                    $(v).css('background-color', '');
                }
            });
        }
    });
});
</script>