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
                            <a href="<?php echo unit_management_url(); ?>"><?= _r('Setting Unit Rate', 'การตั้งค่าอัตราต่อหน่วย'); ?></a>
                        </li>

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
                                <small><font color="red">*</font><?= _r('Categories List', 'รายการหมวดหมู่'); ?></small>
                                <select class="form-control" v-model="setting_unit_rate.type">
                                    <option value="electric">Electric</option>
                                    <option value="water">Water</option>
                                    <option value="internet">Internet</option>
                                    <!-- <option v-for="p in project_info" :value="p.id_project_info">{{ <?= _r('p.project_name_en', 'p.project_name_th'); ?> }}</option> -->
                                </select>
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font> <?= _r('Unit Rate', 'อัตราต่อหน่วย'); ?></small>
                                <input type="text" class="form-control" @input="validateNumber" v-model="setting_unit_rate.unit_rate">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Start Date', 'เริ่มวันที่เรียกเก็บเงิน'); ?></small>
                                <input type="text" id="start_date_id" class="form-control" style="margin-top:-3px;" v-model="setting_unit_rate.start_date" >
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('End Date', 'วันที่ติดตั้ง'); ?></small>
                                <input type="text" id="expire_date_id" class="form-control" style="margin-top:-3px;" v-model="setting_unit_rate.expire_date" @change="logEndDate" >
                            </div>
                        </div>

                        <div class="row">
                             <div class="col-md-6">
                                <small><?= _r('Description', 'คำอธิบาย'); ?></small>
                                <input type="text" class="form-control" v-model="setting_unit_rate.description">
                            </div>

                            <div class="col-md-6">
                                <small><?= _r('Is Main Meter', 'เป็นมิเตอร์หลัก'); ?></small>
                                <input type="checkbox" class="form-control" :checked='setting_unit_rate.status' v-model="setting_unit_rate.status" style="width:20px; height:20px; ">
                            </div>
                        </div>   

                        <?php if (has_permission('unit_management', 'edit')) : ?>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12" style="text-align:center">
                                <button class="btn" style="width:150px; height:30px; line-height:9px; background-color:#0275d8; color:white;" @click="saveSettingInfo()"><?= _r('Save', 'บันทึก'); ?></button>
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
            menu: '<?php echo empty($setting_unit_rate['id']) ? _r("Add Setting Unit Rate", "เพิ่มการตั้งค่าอัตราต่อหน่วย") : _r("Update Setting Unit Rate", "แก้ไขการตั้งค่าอัตราต่อหน่วย"); ?>',
            setting_unit_rate: <?php echo empty($setting_unit_rate) ? '{}' : json_encode($setting_unit_rate); ?>,
            project_info: <?php echo empty($project_info) ? '{}' : json_encode($project_info); ?>,
            room_type: <?php echo empty($room_type) ? '{}' : json_encode($room_type); ?>,
            tmp_amenity: {},
            room_details: <?php echo empty($room_details) ? '{}' : json_encode($room_details); ?>
        },
        watch: {
            // 'internet_info.id_project_info': function(newVal) {
            //     this.fetchRoomTypes(newVal);
            // }
        },
        mounted() {
            let self = this;
            // self.tmp_amenity = JSON.parse(JSON.stringify(shift_json(self.internet_info)));

            $("#start_date_id").datepicker({
                dateFormat: "dd-mm-yy",
                onSelect: function(d) {
                    //alert('start_date');
                    self.setting_unit_rate.start_date = convertDateDash(d);
                    //alert('end');
                }
            });
            $("#expire_date_id").datepicker({
                dateFormat: "dd-mm-yy",
                onSelect: function(d) {
                    self.setting_unit_rate.expire_date = convertDateDash(d);
                }
            });
        },
        methods: {
            validateNumber(event) {
                const value = event.target.value;
                if (!/^\d*$/.test(value)) {
                    this.setting_unit_rate.unit_rate = value.replace(/\D/g, '');
                }
            },
            logStartDate() {
                // alert('customer_id:'+this.internet_info.start_date);
            },
            logEndDate() {
                // alert('End Date changed: ' + this.internet_info.end_date);
            },
            saveSettingInfo: function() {
                
                let self = this;
                var valid = true;
                var keys = Object.keys(this.setting_unit_rate);

                keys.forEach((v) => { 
                    if (valid && !['id','update_date','update_by','create_date','create_by','description','status'].includes(v) && self.setting_unit_rate[v] === '') {
                        alert("Empty "+ v);
                        valid = false;
                    }
                });
                
                if (!valid) {
                    return;
                }

                var start_check = this.setting_unit_rate.start_date;
                var end_check = this.setting_unit_rate.expire_date;
                // var today = new Date();
                // var dd = String(today.getDate()).padStart(2, '0');
                // var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                // var yyyy = today.getFullYear();
                // today =  dd+'-'+mm+'-'+yyyy;

                var parsedStart = parseDate(start_check);
                var parsedEnd = parseDate(end_check);

                function parseDate(dateString) {
                    var parts = dateString.split("-");
                    return new Date(parts[2], parts[1] - 1, parts[0]); // ปี, เดือน (0-11), วัน
                }

                // alert('parsedStart:'+parsedStart+" :parsedEnd: "+parsedEnd);
                if(parsedStart >= parsedEnd){
                    alert('Cannot select a date less than end date');
                    return;
                }

                // if (!self.setting_unit_rate.id_room_type) {
                //     alert("Empty id_room_type");
                //     return;
                // }

                // if (!self.setting_unit_rate.id_room_details) {
                //     alert("Empty id_room_details");
                //     return;
                // }

                $.post("<?php echo save_unit_url(); ?>", this.setting_unit_rate, function(res) {
                    if (res.result == 'false') {
                        alert(res.message);
                        return;
                    } else {
                        alert('Save internet Success');
                        location.href = "<?php echo edit_unit_url(); ?>"+res.id_setting;
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