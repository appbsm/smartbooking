 <!-- CDN for SheetJS -->
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<!-- CDN for jsPDF -->
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.4.0/dist/jspdf.umd.min.js"></script>
<!-- CDN for jsPDF autoTable -->
<script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.23/dist/jspdf.plugin.autotable.min.js"></script>

<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" style="padding-bottom:50px;" v-cloak>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ menu }}</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12 " >
                    <div style="width:100%; overflow:auto;">
                        <table id="roomTable" class="display" style="width:99%;">

                            <thead style="text-align:center;">
                                <tr>
                                    <th style="width:100px;"><?= _r('No', 'ลำดับ'); ?></th>
                                    <th style="width:160px;"><?= _r('Price List Desc', 'รายการราคา'); ?></th>
                                    <th style="width:230px;"><?= _r('Start Date', 'วันเริ่ม'); ?></th>
                                    <th style="width:160px;"><?= _r('End Date', 'วันสิ้นสุด'); ?></th>
                                    <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th>
                                    <?php if (has_permission('unit_management', 'view') || has_permission('unit_management', 'delete')) : ?>
                                    <th style="width:80px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>


                                </tr>
                            </thead>

                            <tbody>
                                <!-- <tr v-for="r in setting_unit_rate">
                                    <td class="text-center">{{ r.run_id }}
                                    </td>
                                    <td class="text-center">{{ r.record_date_f }}</td>
                                    <td class="text-center">{{ r.meter_id }}</td>
                                    
                                    <td>{{ <?= _r('r.project_name_en', 'r.project_name_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_type_name_en', 'r.room_type_name_th'); ?> }}</td>
                                    <td>{{ <?= _r('r.room_name_en', 'r.room_name_th'); ?> }}</td>
                                    <td class="text-center">{{ (parseFloat(r.previous_unit)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ (parseFloat(r.current_unit)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ (parseFloat(r.qty)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ (parseFloat(r.ct)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>

                                    <td class="text-center">{{ r.ct !== 0 && r.ct !== '' ? (r.qty * r.ct).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : (parseFloat(r.qty)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ (parseFloat(r.unit_rate)).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
                                    <td class="text-center">{{ r.ct !== 0 && r.ct !== '' ? ((r.qty * r.ct) * r.unit_rate).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : (r.qty * r.unit_rate).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>

                                    <?php if (has_permission('unit_management', 'view') || has_permission('unit_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('unit_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="loadEditDiscount(r.id)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                    
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{edit_setting.id == 0 ? '<?= _r('Add', 'เพิ่ม'); ?>' : '<?= _r('Update Record Eletric', 'แก้ไขรายละเอียดการใช้ไฟฟ้า'); ?>' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Record Date', 'วันที่จดบันทึก'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_setting.record_date_f" disabled="true">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Meter ID', 'รหัสมิเตอร์'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_setting.meter_id" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Project', 'โปรเจกต์'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="<?= _r('edit_setting.project_name_en', 'edit_setting.project_name_th'); ?>" disabled="true">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Room Type', 'ประเภทห้อง'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="<?= _r('edit_setting.room_type_name_en', 'edit_setting.room_type_name_th'); ?>" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Room Number', 'หมายเลขห้อง'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="<?= _r('edit_setting.room_name_th', 'edit_setting.room_name_en'); ?>" disabled="true">
                            </div>
                            
                        </div>
                    </div>

                    <hr>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Current Unit', 'หน่วยปัจจุบัน'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_setting.current_unit" >
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Previous Unit', 'หน่วยก่อนหน้า'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_setting.previous_unit" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Qty', 'จำนวน'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_setting.qty" disabled="true">
                            </div>
                            
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Unit Rate', 'อัตราต่อหน่วย'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_setting.unit_rate" disabled="true">
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row justify-content-center w-100">
                        <button type="button" class="btn btn-info" style="background-color:#0275d8;" onclick="close_edit()">Close</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-info" style="background-color:#0275d8;" @click="EditUnitInfo()" >Save</button>
                    </div>

                    
                </div>
            </div>        
        </div>
    </div>
        
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script>
    function close_edit() {
      $('#editUnitModal').modal('hide');
    }
</script>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Setting Unit Rate', 'การตั้งค่าอัตราต่อหน่วย'); ?>",
            setting_unit_rate: <?php echo json_encode($setting_unit_rate); ?>,
            edit_setting: {}
        },
        
        methods: {
            EditUnitInfo: function() {
                // alert('current_unit:'+this.edit_electric.current_unit);
                if (!this.edit_setting.current_unit) {
                // แสดงข้อความแจ้งเตือน
                    alert('กรุณากรอกข้อมูลทั้งหมด');
                    return; // หยุดการทำงานต่อไปถ้ามีค่าว่าง
                }

                if(this.edit_setting.current_unit <= this.edit_setting.previous_unit){
                    alert('มิเตอร์ปัจจุบันต้องมากกว่ามิเตอร์ก่อนหน้า');
                    return;
                }

                $.post("<?php echo edit_unit_id(); ?>", {
                    id: this.edit_setting.id,
                    current_unit: this.edit_setting.current_unit,
                    previous_unit: this.edit_setting.previous_unit,
                    qty: this.edit_setting.qty,
                    unit_rate: this.edit_setting.unit_rate
                }, function(response) {
                    // alert('success');
                    // ตรวจสอบการส่งค่ากลับ
                    if (response.success) {
                        // alert('บันทึกข้อมูลสำเร็จ');
                        alert('บันทึกข้อมูลสำเร็จ');
                        // ทำสิ่งที่ต้องการหลังจากบันทึกข้อมูลสำเร็จ เช่น รีเฟรชหน้าเว็บ
                        location.href = "<?php echo unit_management_url(); ?>";
                    } else {
                        alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' + response.message);
                        // กระทำตามที่ต้องการในกรณีเกิดข้อผิดพลาด
                    }
                }, 'json')
                .fail(function() {
                    alert('เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์');
                });
            },
            loadEditDiscount: function(id) {
                let self = this;
                this.setting_unit_rate.forEach((v) => {
                    if (v.id == id) {
                        self.edit_setting = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editUnitModal').modal('show');
            },
            editRoomType: function(id) {
                <?php if (has_permission('unit_management', 'view')) : ?>
                location.href = '<?php echo edit_setting_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteRoomType: function(id) {
                if (confirm('Delete this Setting Unit ?')) {
                    let param = {'id': id};
                    $.post("<?php echo delete_setting_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Delete Setting Unit Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>