
<style>
    .display-image {
        height: 100%;
        width: 100%;
        border: 0px solid black;
        background-position: center;
        background-size: cover;
    }

    .round{
        background-color: #0275d9; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;color: white;font-weight: bold;margin-right: 10px;
    }

    .topic{
        display: flex; align-items: center;margin-bottom: 20px;
    }
    

  .card-type {
    background-color: white; /* พื้นหลังสีขาว */
    border: 2px solid transparent; /* ไม่มีขอบ */
    border-radius: 8px; /* มุมโค้ง */
    padding: 15px; /* ช่องว่างภายใน */
    margin-bottom: 10px; /* ระยะห่างระหว่างปุ่ม */
    cursor: pointer; /* แสดงสัญลักษณ์มือเมื่อเลื่อนเมาส์ไปเหนือปุ่ม */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* เงาเบา */
    transition: background-color 0.3s, border-color 0.3s, box-shadow 0.3s; /* การเปลี่ยนแปลงสีลื่นไหล */
  }

  .card-type:hover {
    background-color: #f8f9fa; /* สีพื้นหลังเมื่อวางเมาส์บนปุ่ม */
  }

  .card-type.type-selected {
    border-color: #0275d8; /* ขอบสีน้ำเงินเมื่อเลือก */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* เงาที่ชัดเจนเมื่อเลือก */
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
                            <a href="<?php echo electric_management_url(); ?>?tab=4"><?= _r('Service Charge', 'ค่าบริการ'); ?></a>
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

                        <!-- addService -->

                        <div class="row">
                            <div class="col-md-3 mb-3" v-for="r in room_type" :key="r.id_room_type" >
                              <button @click="editService(r.id_room_type)" class="btn btn-light btn-block custom-btn" style="background-color: white;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);height: 150px;" data-toggle="modal" data-target="#addService" >
                                <img src='<?php echo site_url(); ?>images/<? if($service_info[0]['type']=='service'){echo 'room.png';}else{ echo 'room.png';} ?>' alt="Image" class="img-fluid mb-2" width="60" >
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

    <div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <!-- <div class="modal fade modal-apartment-setting in" id="addService" style="display: block;"> -->
      <div class="modal-dialog modal-lg modal-add-service">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> ปิด</span></button>
            <!-- <h4 class="modal-title">กำหนด</h4> -->
          </div>
          <form ng-submit="saveServiceRate()" class="ng-pristine ng-valid ng-valid-required">

            <div class="modal-body">
              <div class="row">

                <div class="col-xs-12 col-md-6 col-lg-4">
                  <div class="section s1">

                    <div class="topic" >
                      <div class="round" >1</div>
                      <span >เลือกรูปแบบการคำนวณ</span>
                    </div >

                    <div class="content">
                      <div class="card-type type-selected" ng-class="{ 'type-selected' : serviceModal.type == 0 }" ng-click="clickType(0)">คิดแบบเหมาต่อเดือน</div>

                      <div class="card-type" ng-class="{ 'type-selected' : serviceModal.type == 1 }" ng-click="clickType(1)">คิดอ้างอิงจาก มิเตอร์น้ำ</div>

                      <div class="card-type" ng-class="{ 'type-selected' : serviceModal.type == 2 }" ng-click="clickType(2)">คิดอ้างอิงจาก มิเตอร์ไฟฟ้า</div>

                    </div>

                  </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-4">
                  <div class="section s2 disabled" ng-class="{'disabled' : serviceModal.type == 0}">
                    <div class="topic">
                      <div class="round">2</div>
                      <span>เลือกวิธีคิดค่าบริการ</span>
                    </div>
                    <div class="content">
                      <div class="card-sub-type" ng-click="clickSubType(0)">
                        <input ng-checked="serviceModal.subType == 0" type="radio" name="inlineRadioOptions2" id="inlineRadio2_1" value="0" checked="checked">
                        คิดตามจริง
                      </div>
                      <div class="card-sub-type" ng-click="clickSubType(1)">
                        <input ng-checked="serviceModal.subType == 1" type="radio" name="inlineRadioOptions2" id="inlineRadio2_2" value="1">
                        คิดตามจริง (ขั้นต่ำเป็นจำนวนเงิน)
                      </div>
                      <div class="card-sub-type" ng-click="clickSubType(2)">
                        <input ng-checked="serviceModal.subType == 2" type="radio" name="inlineRadioOptions2" id="inlineRadio2_3" value="2">
                        คิดตามจริง (ขั้นต่ำเป็นยูนิต)
                      </div>
                      <div class="card-sub-type" ng-click="clickSubType(3)">
                        <input ng-checked="serviceModal.subType == 3" type="radio" name="inlineRadioOptions2" id="inlineRadio2_4" value="3">
                        คิดตามจริง (บวกส่วนต่างจากราคาขั้นต่ำ)
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4">
                  <div class="section s3">
                    <div class="topic">
                      <div class="round">3</div>
                      <span>กรุณากรอกข้อมูลจำนวนเงิน</span>
                    </div>
                    <div class="content">
                      <!---->
                      <div>
                        <!-- เหมาต่อเดือน -->
                        <!----><div ng-if="serviceModal.type == 0">
                          <div class="form-group">
                            <label>ค่าบริการ (บาท/เดือน)</label>
                            <input ng-model="serviceModal.cost_month" type="text" valid-number="" class="form-control ng-pristine ng-untouched ng-valid ng-not-empty ng-valid-required" required="" placeholder="0">
                          </div>
                        </div><!---->
                        <!-- คิดตามจริง -->
                        <!---->
                        <!-- คิดตามจริง ขั้นต่ำเป็นจำนวนเงิน -->
                        <!---->
                        <!-- คิดตามจริง ขั้นต่ำเป็นยูนิต -->
                        <!---->
                        <!-- คิดตามจริง บวกส่วนต่างจากราคาขั้นต่ำ -->
                        <!---->
                      </div>
                      <!---->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" ng-disabled="isSaving" ng-click="removeService()" class="btn btn-red">ยกเลิกบริการ</button>
              <button type="submit" ng-disabled="isSaving" class="btn btn-green">บันทึก</button>
            </div>

          </form>
        </div>
      </div>
    </div>  
    

</div>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: '<?php echo empty($service_info[0]['id']) ? _r("Add Service Charge", "เพิ่มค่าบริการ") : _r("Update Service Charge ".$service_info[0]['service_name_en'], "แก้ไขค่าบริการ ".$service_info[0]['service_name_th']); ?>',
            service_info: <?php echo empty($internet_info) ? '{}' : json_encode($internet_info); ?>,
            room_type: <?php echo empty($room_type) ? '{}' : json_encode($room_type); ?>,
            service_detail: <?php echo empty($service_detail) ? '{}' : json_encode($service_detail); ?>,
            serviceModal: {
                type: 0,
                subType: 0,
                cost_month: ''
              },
            isSaving: false
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
            clickType(type) {
                this.serviceModal.type = type;
            },
            clickSubType(subType) {
                this.serviceModal.subType = subType;
            },
            saveServiceRate() {
                this.isSaving = true;
                // Perform your save logic here
                console.log('Saving service rate...', this.serviceModal);
                // After saving, reset isSaving to false
                this.isSaving = false;
            },
            removeService() {
                // Perform your remove logic here
                console.log('Removing service...');
            },

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