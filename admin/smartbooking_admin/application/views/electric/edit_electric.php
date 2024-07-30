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
                            <a href="<?php echo electric_management_url(); ?>?tab=1"><?= _r('Electric Meter List', 'รายการมิเตอร์ไฟฟ้า'); ?></a>
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
                                <select class="form-control" v-model="electric_info.id_room_details">
                                    <option v-for="r in room_details" :value="r.id_room_details">{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Serial No', 'หมายเลขซีเรียล'); ?></small>
                                <input type="text" class="form-control" v-model="electric_info.serial_no">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <small><?= _r('CT Value', 'หมายเลขซีเรียล'); ?></small>
                                <input type="text" class="form-control" v-model="electric_info.ct">
                            </div>

                            <div class="col-md-6">
                                <small><?= _r('Is Main Meter', 'เป็นมิเตอร์หลัก'); ?></small>
                                <!-- <input type="checkbox" class="form-control" v-model="room_type_info.is_active"> -->
                                <input type="checkbox" class="form-control" :checked='electric_info.is_meter_main' v-model="electric_info.is_meter_main" style="width:20px; height:20px; ">
                                <!-- display:inline-block; vertical-align:top; -->
                            </div>

                            <!-- <div class="col-md-6">
                                <div class="form-group ">
                                    <small><?= _r('CT Value', 'หมายเลขซีเรียล'); ?></small>
                                    <div class="col-md-1">
                                        <input type="checkbox"  id="is_ct"  name="is_ct" value="1"  onclick="select_ct()"/>
                                    </div>
                                    <div class="col-md-7" id="div_ct_val">
                                        <input type="text" class="form-control" id="ct_value"  name="ct_value" value="" placeholder="CT Value..."  />
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-6">
                                <small><?= _r('Status', 'สถานะ'); ?></small>
                                <input type="checkbox" class="form-control" :checked='electric_info.is_active' style="width:20px; height:20px; ">
                            </div> -->

                        </div>

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
            menu: '<?php echo empty($electric_info['id']) ? _r("Add Electric Meter", "เพิ่ม Electric Meter") : _r("Update Electric Meter", "แก้ไข Electric Meter"); ?>',
            electric_info: <?php echo empty($electric_info) ? '{}' : json_encode($electric_info); ?>,
            project_info: <?php echo empty($project_info) ? '{}' : json_encode($project_info); ?>,
            room_type: <?php echo empty($room_type) ? '{}' : json_encode($room_type); ?>,
            room_details: <?php echo empty($room_details) ? '{}' : json_encode($room_details); ?>
        },
        watch: {
            'electric_info.id_project_info': function(newVal) {
                this.fetchRoomTypes(newVal);
            }
            // ,
            // 'electric_info.id_room_type': function(newValRoom) {
            //     this.fetchRoomId(newValRoom);
            // }
        },
        methods: {
            handleRoomTypeChange(event) {
                const newVal = event.target.value;
                // alert('newVal:'+newVal);
                this.fetchRoomId(newVal);
            },
            fetchRoomTypes: function(projectId) {
                var vm = this;
                $.ajax({
                    url: '<?php echo get_electric_by_project(); ?>/' + projectId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_type = JSON.parse(response);
                        vm.electric_info.id_room_type = null;
                        vm.electric_info.id_room_details = null;
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
                    url: '<?php echo get_electric_by_room_details(); ?>/' + roomtId,
                    method: 'GET',
                    success: function(response) {
                        vm.room_details = JSON.parse(response);
                        vm.electric_info.id_room_details = null;
                        // alert('success');
                    },
                    error: function() {
                        // alert('Failed to fetch room types. test2');
                    }
                });
            },
            saveElectricInfo: function() {
                let self = this;

                var valid = true;
                var keys = Object.keys(this.electric_info);
                keys.forEach((v) => {
                    if (valid && !['id','meter_id','is_meter_main','is_active','create_date', 'create_by', 'update_date','update_by','ct'].includes(v) && self.electric_info[v] === '') {
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