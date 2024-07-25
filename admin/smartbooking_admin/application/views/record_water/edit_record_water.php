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
                            <a href="<?php echo record_water_management_url(); ?>"><?= _r('Water Using Record Detail', 'รายละเอียดบันทึกการใช้น้ำ'); ?></a>
                        </li>
                        <!-- <li class="breadcrumb-item">
                            <a href="<?php echo edit_water_url($water_info['id']); ?>">{{ menu }}<?php echo $water_info['id'] ? (' ('. $water_info['serial_no'] .')') : ''; ?></a>
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
                                <select class="form-control" v-model="water_info.id_project_info">
                                    <option v-for="p in project_info" :value="p.id_project_info">{{ <?= _r('p.project_name_en', 'p.project_name_th'); ?> }}</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Type', 'ประเภทห้อง'); ?></small>
                                <select class="form-control" v-model="water_info.id_room_type" @change="handleRoomTypeChange" >
                                    <option v-for="r in room_type" :value="r.id_room_type">{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Room Number', 'หมายเลขห้อง'); ?></small>
                                <select class="form-control" v-model="water_info.id_room_details" @change="handleRoomNumberChange" >
                                    <option v-for="r in room_details" :value="r.id_room_details">{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Meter ID', 'รหัสมิเตอร์'); ?></small>
                                <!-- :value="meter_name" -->
                                <input type="text" class="form-control" disabled="true" v-model="meter_name"  >
                                 <span class="help-box" style="color: gray;" id="last_rec_date">
                                    <?= _r('Last Record Date','บันทึกครั้งล่าสุด'); ?> : {{ lastRecordDate }}
                                </span>
                            </div>

                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Record Date', 'วันที่จดบันทึก'); ?></small>
                                <input id="installation_date_modal" type="text" class="form-control" v-model="water_info.record_date" @change="lastRecordDateChange" >
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Current Unit', 'หน่วยปัจจุบัน'); ?></small>
                                <input type="text" id="cur_meter" name="cur_meter" class="form-control" v-model="water_info.current_unit" @input="validateNumber" @change="checkCurrent" >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Previous Unit', 'หน่วยก่อนหน้า'); ?></small>
                                <input type="text" id="pre_meter" class="form-control" disabled="true" v-model="previous_unit" >
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Current Using', 'ยอดใช้ปัจจุบัน'); ?></small>
                                <input type="text" class="form-control" disabled="true" v-model="current_using" >
                            </div>
                        </div>

                        <?php if (has_permission('record_water_management', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="savewaterInfo()"><?= _r('Save', 'บันทึก'); ?></button>
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
            menu: '<?php echo empty($water_info['id']) ? _r("Add Record water", "เพิ่ม Record water") : _r("Update Record water", "แก้ไข Record water"); ?>',
            water_info: <?php echo empty($water_info) ? '{}' : json_encode($water_info); ?>,
            project_info: <?php echo empty($project_info) ? '{}' : json_encode($project_info); ?>,
            room_type: <?php echo empty($room_type) ? '{}' : json_encode($room_type); ?>,
            room_details: <?php echo empty($room_details) ? '{}' : json_encode($room_details); ?>,
            water_list: <?php echo empty($water_list) ? '{}' : json_encode($water_list); ?>,
            lastRecordDate: '<?php echo empty($lastRecordDate) ? '-' : $lastRecordDate; ?>',
            previous_unit: '<?php echo empty($previous_unit) ? '-' : $previous_unit; ?>',
            current_using: '<?php echo empty($current_using) ? '-' : $current_using; ?>',
            meter_name: '',
            meter_id: ''
        },
        watch: {
            'water_info.id_project_info': function(newVal) {
                this.fetchRoomTypes(newVal);
            }
        },
        mounted() {
            let self = this;
            $("#installation_date_modal").datepicker({
                dateFormat: "dd-mm-yy",
                onSelect: function(d) {
                    const convertedDate = convertDateDash(d);
                    self.water_info.record_date = convertedDate;
                    self.lastRecordDateChange(convertedDate);
                }

            });
            if (this.project_info.length > 0) {
                this.water_info.id_project_info = this.project_info[0].id_project_info;
                this.fetchRoomTypes(this.water_info.id_project_info);
            }
        },
        methods: {
            validateNumber(event) {
                const value = event.target.value;
                if (!/^\d*$/.test(value)) {
                    this.water_info.current_unit = value.replace(/\D/g, '');
                }
            },
            checkCurrent(event) {
                // ตรวจสอบค่าและคำนวณการใช้งาน
                const curMeter = parseFloat(this.water_info.current_unit);
                const preMeter = parseFloat(this.previous_unit);

                if (curMeter > preMeter) {
                    this.calculateUsage();
                } else if (curMeter <= preMeter) {
                    // alert(_r('Current Meter must be greater than Previous Meter.','มิเตอร์ปัจจุบันต้องมากกว่ามิเตอร์ก่อนหน้า'));
                    alert('Current Meter must be greater than Previous Meter.');
                    this.water_info.current_unit = ''; // ล้างค่าใน input
                    this.current_using = ''; // ตั้งค่าเป็น 0
                }
            },
            calculateUsage() {
                const curMeter = parseFloat(this.water_info.current_unit);
                const preMeter = parseFloat(this.previous_unit);
                this.current_using = curMeter - preMeter;
            },
            handleRoomTypeChange(event) {
                const newVal = event.target.value;
                // alert('newVal:'+newVal);
                this.fetchRoomId(newVal);
            },
            handleRoomNumberChange(event) {
                const newVal = event.target.value;
                this.fetchRoomNumberId(newVal);
               
            },
            lastRecordChange(event) {
                const newVal = event.target.value;
                // alert('newVal:'+newVal);
                this.fetchLastDate(newVal);
            },
            lastRecordDateChange(newDate) {
                const newVal = this.water_info.id;
                // alert('newDate:'+newDate);
                if(newVal){
                    // var date_check = $('#last_rec_date').val();
                    var date_check = this.lastRecordDate;
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();
                    today =  dd+'-'+mm+'-'+yyyy;

                    // alert('newDate:'+newDate+"/date_check:"+date_check+"/today:"+today);

                    function parseDate(dateString) {
                        var parts = dateString.split("-");
                        return new Date(parts[2], parts[1] - 1, parts[0]); // ปี, เดือน (0-11), วัน
                    }

                    var parsedNewDate = parseDate(newDate);
                    var parsedDateCheck = parseDate(date_check);
                    var parsedToday = parseDate(today);

                    if(date_check=="This meter has no previous data"){
                        if(parsedNewDate <= parsedToday){
                            this.fetchLastPrevious(newVal);
                        }else{
                            alert('Cannot select a date less than Last date record and must not exceed the current day');
                            this.water_info.record_date = '';
                            this.water_info.current_unit = '';
                            this.previous_unit='';
                            this.current_using='';
                        }
                    }else{
                        if(parsedNewDate > parsedDateCheck && parsedNewDate <= parsedToday){
                        // if (new Date(newDate) > new Date(date_check) && new Date(newDate) <= today) {
                            this.fetchLastPrevious(newVal);
                            // alert('today:'+today);
                        }else{
                            alert('Cannot select a date less than Last date record and must not exceed the current day');
                            // current_unit
                            this.water_info.record_date = '';
                            this.water_info.current_unit = '';
                            this.previous_unit='';
                            this.current_using='';
                        }
                    }
                }else{
                    alert('Please Select Meter First.');
                    // alert(_r('Please Select Meter First.','กรุณาเลือกมิเตอร์ก่อน'));
                }
            },
            fetchRoomTypes: function(projectId) {
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_water_by_project(); ?>/' + projectId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_type = JSON.parse(response);
                        vm.water_list = null;
                        vm.water_info.id_room_type = null;
                        vm.water_info.id_room_details = null;
                        vm.water_info.water_list_id = null;
                        
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
                    url: '<?php echo get_record_water_by_room_details(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_details = JSON.parse(response);
                        vm.water_list = null;
                        vm.water_info.id_room_details = null;
                        vm.water_info.water_list_id = null;
                        // alert('success');
                    },
                    error: function() {
                        // alert('Failed to fetch room types. test');
                    }
                });
            },
            fetchRoomNumberId: function(roomtId) {
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_water_by_room_number(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        vm.water_info.record_date = '';
                        vm.water_info.current_unit = '';
                        vm.previous_unit = '';
                        vm.current_using = '';

                        // vm.water_list = JSON.parse(response);
                        var result = JSON.parse(response);
                        var record = result[0];
                        if (result.length>0) {
                            vm.meter_name = record.meter_id;
                            vm.water_info.id = record.id;
                            vm.meter_id = record.id;
                            vm.fetchLastDate(vm.meter_id);
                        } else {
                            vm.lastRecordDate = 'Meter data not found';
                            vm.meter_name = '';
                            vm.water_info.id = null;
                            vm.meter_id = null;
                        }

                        // vm.water_info.water_list_id = null;
                        // alert('success'+record.meter_id);
                    },
                    error: function() {
                        alert('Failed to fetch room types. test');
                    }
                });
            },
            fetchLastDate: function(roomtId) {
                
                var vm = this;
                // alert('roomtId:'+roomtId);
                // alert('water_info:'+this.meter_id);
                $.ajax({
                    url: '<?php echo get_record_water_by_meter(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        // vm.water_list = JSON.parse(response);

                        var result = JSON.parse(response);
                        var record = result[0];
                        // alert('record.last_record_date:'+record.last_record_date);
                        if (record.last_record_date) {
                            if(record.last_record_date == 'null'){
                                vm.lastRecordDate = 'This meter has no previous data';
                            }else{
                                var parts = record.last_record_date.split('-');
                                var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                                vm.lastRecordDate = formattedDate;
                            }
                        } else {
                            vm.lastRecordDate = '-';
                        }

                    },
                    error: function() {
                        // vm.lastRecordDate = '-';
                        alert('Failed to fetch room types.');
                    }
                });
            },
            fetchLastPrevious: function(roomtId) {
                // alert('fetchLastPrevious roomtId:'+roomtId);
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_water_by_meter_date(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        // vm.water_list = JSON.parse(response);
                        var result = JSON.parse(response);
                        var record = result[0]; // Get the first item in the array
                        // alert('record.previous_unit:'+record.previous_unit);
                        if (record.current_unit) {
                            vm.previous_unit = record.current_unit;
                        } else {
                            // vm.previous_unit = '';
                            vm.previous_unit = '0';
                        }
                    },
                    error: function() {
                        alert('Failed to fetch Previous Unit.');
                    }
                });
            },
            savewaterInfo: function() {
                let self = this;
                var valid = true;
                var keys = Object.keys(this.water_info);
                keys.forEach((v) => {
                    if (valid && !['id','meter_id','is_meter_main','is_active','create_date', 'create_by', 'update_date','update_by','ct','id_internet','previous_unit','qty','unit_rate'].includes(v) && self.water_info[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                // ตรวจสอบและกำหนดค่าใหม่ให้กับ id_room_type หากจำเป็น
                if (!self.water_info.id_room_type) {
                    alert("Empty id room type");
                    return;
                }
                if (!self.water_info.id_room_details) {
                    alert("Empty id room details");
                    return;
                }
                
                // alert("record_date::"+self.water_info.record_date);
                if (!self.meter_name || self.meter_name=='') {
                    alert("Empty meter id");
                    return;
                }

                $.post("<?php echo save_record_water_url(); ?>", {
                    water_info: JSON.stringify(this.water_info),
                    previous_unit: this.previous_unit,
                    current_using: this.current_using,
                    lastRecordDate: this.lastRecordDate,
                    meter_id: this.meter_id
                }, function(res) {
                    if (res.result == 'false') {
                        alert('error');
                        // alert(res.message);
                        return;
                    } else {
                        alert('Save Record Water Success');
                        // alert('TEST:'+res.message);
                        // location.href = "<?php echo edit_record_water_url(); ?>"+res.id_water;
                        location.href = "<?php echo record_water_management_url(); ?>";
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