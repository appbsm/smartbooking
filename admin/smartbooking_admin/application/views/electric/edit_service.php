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
                            <?php //echo internet_management_url(); ?>
                            <a href="<?php echo electric_management_url(); ?>?tab=3"><?= _r('internet Meter List', 'รายการมิเตอร์ไฟฟ้า'); ?></a>
                        </li>

                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" >

                        <div class="row">
                            <div class="col-md-3 mb-3" v-for="r in room_type" :key="r.id_room_type" >
                              <button @click="editService(r.id_room_type)" class="btn btn-light btn-block custom-btn" style="background-color: white;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);height: 150px;" data-toggle="modal" data-target="#addServiceModal" >
                                <img src='<?php echo site_url(); ?>images/<? if($service_info[0]['type']=='service'){echo 'service.png';}else{ echo 'discount.png';} ?>' alt="Image" class="img-fluid mb-2" width="50" >
                                <div class="text-center">{{r.room_type_name_en}}</div>
                              </button>
                            </div>
                        </div>

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
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceModalLabel"><?= _r('Add a new service', 'เพิ่มค่าบริการใหม่'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                        <div class="form-group">
                            <label for="serviceName"><?= _r('Service name', 'ชื่อบริการ'); ?></label>
                            <input type="text" class="form-control" id="serviceName" placeholder="<?= _r('Please enter service name', 'กรุณากรอกชื่อบริการ'); ?>" v-model="service_info.service_name_th">
                        </div>
                        <div class="form-group">
                            <label for="serviceNameEN"><?= _r('Service name (English)', 'ชื่อบริการ (ภาษาอังกฤษ)'); ?></label>
                            <input type="text" class="form-control" id="serviceNameEN" placeholder="<?= _r('Please enter service name in English', 'กรุณากรอกชื่อบริการภาษาอังกฤษ'); ?>" v-model="service_info.service_name_en" >
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= _r('Close', 'ปิด'); ?></button>
                    <button type="button" class="btn btn-primary" @click="saveService('service')" ><?= _r('Save', 'บันทึก'); ?></button>
                </div>

            </div>
        </div>
    </div>    
    

</div>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: '<?php echo empty($service_info[0]['id']) ? _r("Add Service Charge", "เพิ่ม Service Charge") : _r("Update Service Charge", "แก้ไข Service Charge"); ?>',
            service_info: <?php echo empty($internet_info) ? '{}' : json_encode($internet_info); ?>,
            room_type: <?php echo empty($room_type) ? '{}' : json_encode($room_type); ?>,
            service_detail: <?php echo empty($service_detail) ? '{}' : json_encode($service_detail); ?>
        },
        watch: {
            // 'internet_info.id_project_info': function(newVal) {
            //     this.fetchRoomTypes(newVal);
            // }
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