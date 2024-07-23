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
                            <a href="<?php echo record_electric_management_url(); ?>"><?= _r('Eletric Using Record Detail', 'รายละเอียดบันทึกการใช้ไฟฟ้า'); ?></a>
                        </li>
                        <!-- <li class="breadcrumb-item">
                            <a href="<?php echo edit_electric_url($electric_info['id']); ?>">{{ menu }}<?php echo $electric_info['id'] ? (' ('. $electric_info['serial_no'] .')') : ''; ?></a>
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
                                <select class="form-control" v-model="electric_info.id_project_info">
                                    <option v-for="p in project_info" :value="p.id_project_info">{{ <?= _r('p.project_name_en', 'p.project_name_th'); ?> }}</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Room Type', 'Room Type'); ?></small>
                                <select class="form-control" v-model="electric_info.id_room_type" @change="handleRoomTypeChange" >
                                    <option v-for="r in room_type" :value="r.id_room_type">{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Room Number', 'หมายเลขห้อง'); ?></small>
                                <select class="form-control" v-model="electric_info.id_room_details" @change="handleRoomNumberChange" >
                                    <option v-for="r in room_details" :value="r.id_room_details">{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Meter ID test', 'รหัสมิเตอร์'); ?></small>
                                <select class="form-control" v-model="electric_info.id" @change="lastRecordChange" >
                                    <option v-for="r in electric_list" :value="r.id">{{ <?= _r('r.meter_id', 'r.meter_id'); ?> }}</option>
                                </select>
                                <span class="help-box" style="color: gray;" id="last_rec_date">
                                    <?= _r('Last Record Date','บันทึกครั้งล่าสุด'); ?> : {{ lastRecordDate }}
                                </span>
                            </div>

                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Record Date', 'วันที่จดบันทึก'); ?></small>
                                <input id="installation_date_modal" type="text" class="form-control" v-model="electric_info.record_date" @change="lastRecordDateChange" >
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Current Unit', 'หน่วยปัจจุบัน'); ?></small>
                                <input type="text" id="cur_meter" name="cur_meter" class="form-control" v-model="electric_info.current_unit" @input="validateNumber" >
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

<script type="text/javascript">
    $('#cur_meter').change(function(){

     var value = $(this).val();
     var pre_meter_unit = $('#pre_meter').val();

   
     var pre_meter = parseFloat(pre_meter_unit);
     var cur_meter = value*1-pre_meter*1;
      
     if(pre_meter > cur_meter)
     {
         console.log('.........');
     }
    
    //console.log(cur_meter.toFixed(2));
     $('#cur_meter_using').val(cur_meter.toFixed(2));
     //$('#cur_meter').val(c_meter);
  })
</script>   


                        <?php if (has_permission('room_management', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="saveElectricInfo()"><?= _r('Save', 'บันทึก'); ?></button>
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
            menu: '<?php echo empty($electric_info['id']) ? _r("Add Record Electric", "เพิ่ม Record Electric") : _r("Update Record Electric", "แก้ไข Record Electric"); ?>',
            electric_info: <?php echo empty($electric_info) ? '{}' : json_encode($electric_info); ?>,
            project_info: <?php echo empty($project_info) ? '{}' : json_encode($project_info); ?>,
            room_type: <?php echo empty($room_type) ? '{}' : json_encode($room_type); ?>,
            room_details: <?php echo empty($room_details) ? '{}' : json_encode($room_details); ?>,
            electric_list: <?php echo empty($electric_list) ? '{}' : json_encode($electric_list); ?>,
            lastRecordDate: '-',
            previous_unit: '',
            current_using: ''
        },
        watch: {
            'electric_info.id_project_info': function(newVal) {
                this.fetchRoomTypes(newVal);
            }
        },
        mounted() {
            let self = this;
            $("#installation_date_modal").datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(d) {
                    self.electric_info.record_date = convertDateDash(d);
                    self.lastRecordDateChange();
                }

            });

        },
        methods: {
            validateNumber(event) {
                const value = event.target.value;
                if (!/^\d*$/.test(value)) {
                    this.electric_info.current_unit = value.replace(/\D/g, '');
                }
            },
            handleRoomTypeChange(event) {
                const newVal = event.target.value;
                // alert('newVal:'+newVal);
                this.fetchRoomId(newVal);
            },
            handleRoomNumberChange(event) {
                const newVal = event.target.value;
                // alert('newVal:'+newVal);
                this.fetchRoomNumberId(newVal);
            },
            lastRecordChange(event) {
                const newVal = event.target.value;
                // alert('newVal:'+newVal);
                this.fetchLastDate(newVal);
                
                // if (this.electric_info.electric_list_id) {
                //     this.lastRecordDate = '25-06-2024';
                // } else {
                //     this.lastRecordDate = '-';
                // }
            },
            lastRecordDateChange(event) {
                // const newVal = event.target.value;
                const newVal = this.electric_info.id;
                // alert('electric_info.id:'+this.electric_info.id);
                if(newVal){
                    this.fetchLastPrevious(newVal);
                }else{
                    alert('Please Select Meter First.');
                }
            },
            fetchRoomTypes: function(projectId) {
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_electric_by_project(); ?>/' + projectId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_type = JSON.parse(response);
                        vm.electric_list = null;
                        vm.electric_info.id_room_type = null;
                        vm.electric_info.id_room_details = null;
                        vm.electric_info.electric_list_id = null;
                        
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
                    url: '<?php echo get_record_electric_by_room_details(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_details = JSON.parse(response);
                        vm.electric_list = null;
                        vm.electric_info.id_room_details = null;
                        vm.electric_info.electric_list_id = null;
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
                    url: '<?php echo get_record_electric_by_room_number(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        vm.electric_list = JSON.parse(response);
                        vm.electric_info.electric_list_id = null;

                        // alert('success');
                    },
                    error: function() {
                        // alert('Failed to fetch room types. test');
                    }
                });
            },
            fetchLastDate: function(roomtId) {
                // alert('fetchLastDate roomtId:'+roomtId);
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_electric_by_meter(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        // vm.electric_list = JSON.parse(response);
                        var result = JSON.parse(response);
                        var record = result[0]; // Get the first item in the array
                        if (record.last_record_date) {
                            vm.lastRecordDate = record.last_record_date;
                            // vm.previous_unit = record.last_record_date;
                            // vm.current_using = record.last_record_date;
                        } else {
                            vm.lastRecordDate = '-';
                        }
                    },
                    error: function() {
                        // vm.lastRecordDate = '-';
                        // alert('Failed to fetch room types.');
                    }
                });
            },
            fetchLastPrevious: function(roomtId) {
                // alert('fetchLastPrevious roomtId:'+roomtId);
                var vm = this;
                $.ajax({
                    url: '<?php echo get_record_electric_by_meter_date(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        // vm.electric_list = JSON.parse(response);
                        var result = JSON.parse(response);
                        var record = result[0]; // Get the first item in the array

                        alert('previous_unit:'+record.previous_unit);
                        if (record.previous_unit) {
                            vm.previous_unit = record.previous_unit;
                        } else {
                            vm.previous_unit = '';
                        }
                    },
                    error: function() {
                        alert('Failed to fetch room types.');
                    }
                });
            },
            saveElectricInfo: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.electric_info);
                keys.forEach((v) => {
                    if (valid && !['id','meter_id','is_meter_main','is_active','create_date', 'create_by', 'update_date','update_by','ct','id_internet'].includes(v) && self.electric_info[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                if (!valid) {
                    return;
                }

                // ตรวจสอบและกำหนดค่าใหม่ให้กับ id_room_type หากจำเป็น
                if (!self.electric_info.id_room_type) {
                    alert("Empty id_room_type");
                    return;
                }
                if (!self.electric_info.id_room_details) {
                    alert("Empty id_room_details");
                    return;
                }

                $.post("<?php echo save_electric_url(); ?>", this.electric_info, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save Electric Success');
                        location.href = "<?php echo edit_electric_url(); ?>"+res.id_electric;
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