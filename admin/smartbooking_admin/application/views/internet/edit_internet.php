<style>
    .display-image {
        height: 100%;
        width: 100%;
        border: 0px solid black;
        background-position: center;
        background-size: cover;
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
                        <li class="breadcrumb-item"><?= _r('Setting', 'การตั้งค่า'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo internet_management_url(); ?>"><?= _r('internet Meter List', 'รายการมิเตอร์ไฟฟ้า'); ?></a>
                        </li>
                        <!-- <li class="breadcrumb-item">
                            <a href="<?php echo edit_internet_url($internet_info['id']); ?>">{{ menu }}<?php echo $internet_info['id'] ? (' ('. $internet_info['serial_no'] .')') : ''; ?></a>
                        </li> -->
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="overflow-x:auto;">
                    <span  >
                        <!-- <b>{{ m }}</b> -->
                    </span>
                </div>


                <div class="col-md-12" >
                    <div class="col-md-11" style="margin-top:50px;">
                         <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Project', 'โปรเจกต์'); ?></small>
                                <select class="form-control" v-model="internet_info.id_project_info">
                                    <option v-for="p in project_info" :value="p.id_project_info">{{ <?= _r('p.project_name_en', 'p.project_name_th'); ?> }}</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Type', 'Room Type'); ?></small>
                                <select class="form-control" v-model="internet_info.id_room_type" @change="handleRoomTypeChange">
                                    <option v-for="r in room_type" :value="r.id_room_type">{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                           <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Room Number', 'หมายเลขห้อง'); ?></small>
                                <select class="form-control" v-model="internet_info.id_room_details">
                                    <option v-for="r in room_details" :value="r.id_room_details">{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Unit No', 'หมายเลขหน่วย'); ?></small>
                                <input type="text" class="form-control" v-model="internet_info.unit_no">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <small><?= _r('ID', 'ID'); ?></small>
                                <input type="text" class="form-control" v-model="internet_info.id_internet">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Installation Date', 'เริ่มวันที่เรียกเก็บเงิน'); ?></small>
                                <input type="text" id="installation_date_modal" class="form-control" style="margin-top:-3px;" v-model="internet_info.installation_date"  >

                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Start Bill Date', 'วันที่ติดตั้ง'); ?></small>
                                <input type="text" id="start_bill_modal" class="form-control" style="margin-top:-3px;" v-model="internet_info.start_bill_date" :value="internet_info.start_bill_date" @change="logEndDate" >
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Start Date', 'วันเริ่มต้น'); ?></small>
                                <input type="text" id="start_date_seasonal_price_modal" class="form-control" style="margin-top:-3px;" v-model="internet_info.start_date"  >

                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('End Date', 'วันสิ้นสุด'); ?></small>
                                <input type="text" id="end_date_seasonal_price_modal" class="form-control" style="margin-top:-3px;" v-model="internet_info.end_date" :value="internet_info.end_date" @change="logEndDate" >
                            </div>
                        </div> -->

                        <?php if (has_permission('room_management', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="saveinternetInfo()"><?= _r('Save', 'บันทึก'); ?></button>
                            </div>
                        </div>
                        <?php endif; ?>
                       
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
            menu: '<?php echo empty($internet_info['id']) ? _r("Add internet Meter", "เพิ่ม internet Meter") : _r("Update internet Meter", "แก้ไข internet Meter"); ?>',
            internet_info: <?php echo empty($internet_info) ? '{}' : json_encode($internet_info); ?>,
            project_info: <?php echo empty($project_info) ? '{}' : json_encode($project_info); ?>,
            room_type: <?php echo empty($room_type) ? '{}' : json_encode($room_type); ?>,
            tmp_amenity: {},
            room_details: <?php echo empty($room_details) ? '{}' : json_encode($room_details); ?>
        },
        watch: {
            'internet_info.id_project_info': function(newVal) {
                this.fetchRoomTypes(newVal);
            }
        },
        mounted() {
            let self = this;
            // self.tmp_amenity = JSON.parse(JSON.stringify(shift_json(self.internet_info)));

            $("#installation_date_modal").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.internet_info.installation_date = convertDateDash(d);
                }

            });

            $("#start_bill_modal").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.internet_info.start_bill_date = convertDateDash(d);
                }
            });
        },
        methods: {
            handleRoomTypeChange(event) {
                const newVal = event.target.value;
                // alert('newVal:'+newVal);
                this.fetchRoomId(newVal);
            },
            logStartDate() {
                // alert('customer_id:'+this.internet_info.start_date);
            },
            logEndDate() {
                // alert('End Date changed: ' + this.internet_info.end_date);
            },
            fetchRoomTypes: function(projectId) {
                var vm = this;
                // alert('projectId:'+projectId);
                $.ajax({
                    url: '<?php echo get_internet_by_project(); ?>/' + projectId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_type = JSON.parse(response);
                        vm.internet_info.id_room_type = null;
                        vm.internet_info.id_room_details = null;
                        // alert('success');
                    },
                    error: function() {
                        alert('Failed to fetch room types.');
                    }
                });
            },
            fetchRoomId: function(roomtId) {
                var vm = this;
                $.ajax({
                    url: '<?php echo get_internet_by_room_details(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_details = JSON.parse(response);
                        vm.internet_info.id_room_details = null;
                        // alert('success');
                    },
                    error: function() {
                        // alert('Failed to fetch room types. test');
                    }
                });
            },
            saveinternetInfo: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.internet_info);
                keys.forEach((v) => { 
                    if (valid && !['id','meter_id','is_meter_main','is_active','create_date', 'create_by', 'update_date','update_by','ct','start_date','end_date','id_internet'].includes(v) && self.internet_info[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                if (!self.internet_info.id_room_type) {
                    alert("Empty id_room_type");
                    return;
                }

                if (!self.internet_info.id_room_details) {
                    alert("Empty id_room_details");
                    return;
                }

                // if (this.internet_info.start_date > this.internet_info.end_date) {
                //     alert("Start Date  must less than  End Date");
                //     return;
                // }

                // if (dateDiff(this.internet_info.start_date, this.internet_info.end_date) >= 365) {
                //     alert("Date Range is too long");
                //     return;
                // }

                $.post("<?php echo save_internet_url(); ?>", this.internet_info, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save internet Success');
                        location.href = "<?php echo edit_internet_url(); ?>"+res.id_internet;
                    }
                });
            }
        }
    });

});

function select_ct(){
    if($('#is_ct').prop("checked") == true){
        $('#div_ct_val').show();                    
    }
    else if($('#is_ct').prop("checked") == false){
        $('#div_ct_val').hide();
    }
}

</script>