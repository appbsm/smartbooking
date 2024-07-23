<!-- Content Header (Page header) -->
<div class="content-wrapper" id="vApp" style="padding-bottom:50px;" v-cloak>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ menu }}</h1>
                </div>
               <!--  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= _r('Setting', 'การตั้งค่า'); ?></li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo electric_management_url(); ?>">{{ menu }}</a>
                        </li>
                    </ol>
                </div> -->
            </div>
        </div>
    </section>

<section class="content">
<form action="<?php echo site_url('record_electric/record_electric_management') ?>" method="get">

    <div class="container-fluid center-content">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 d-flex justify-content-center">
                <div class="form-inline">
                    <label>Date From :</label> 
                    <div class="form-group px-3">
                        <input type="text" class="form-control date-picker" id="date_from" name="date_from" autocomplete="off" value="<?php if($date_from){echo $date_from;} ?>"> 
                     </div>
                     <label class="px-3" >Date To :</label>
                     <div class="form-group px-3">
                        <input type="text" class="form-control date-picker" id="date_to" name="date_to" autocomplete="off" value="<?php if($date_to){echo $date_to;} ?>"> 
                     </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row justify-content-center w-100">
            <button style="background-color:#0275d8;" type="submit" class="btn btn-info">Search</button>
            <!-- &nbsp;&nbsp;&nbsp;
            <button type="button" id="btn_clear" class="btn btn-danger px-5">Clear Filter</button>   -->     
        </div>
    </div>

</form>
</section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <?php if (has_permission('electric_management', 'edit')) : ?>
                    <a href="<?php echo edit_record_electric_url(); ?>" style="color:white;">
                        <button class="btn" style="float:right; width:170px; height:30px; line-height:9px; background-color:#0275d8; color:white; margin-bottom:20px;">
                            <?= _r('Create', 'สร้าง'); ?>
                        </button>
                    </a>
                    <?php endif; ?>
                    <div style="width:100%; overflow:auto;">
                        <table id="roomTable" class="display" style="width:99%;">

                            <thead style="text-align:center;">
                                <tr>
                                    <th style="width:100px;"><?= _r('No', 'ลำดับ'); ?></th>
                                    <th style="width:160px;"><?= _r('Record Date', 'วันที่บันทึก'); ?></th>
                                    <th style="width:230px;"><?= _r('Meter ID', 'หมายเลขมิเตอร์'); ?></th>
                                    <th style="width:160px;"><?= _r('Project', 'โครงการ'); ?></th>
                                    <th style="width:60px;"><?= _r('Rooms type', 'ห้อง'); ?></th>
                                    <th style="width:60px;"><?= _r('Room Number', 'หมายเลขห้อง'); ?></th>
                                    <th style="width:80px;"><?= _r('Previous Unit', 'หน่วยก่อนหน้า'); ?></th>
                                    <th style="width:60px;"><?= _r('Current Unit', 'หน่วยปัจจุบัน'); ?></th>
                                    <th style="width:60px;"><?= _r('Qty', 'จำนวน'); ?></th>
                                    <th style="width:60px;"><?= _r('CT Value', 'CT Value'); ?></th>
                                    <th style="width:60px;"><?= _r('Qty*CT Value', 'จำนวน*CT Value'); ?></th>
                                    <th style="width:60px;"><?= _r('Unit Rate', 'อัตราต่อหน่วย'); ?></th>
                                    <th style="width:60px;"><?= _r('Amount(Inc. VAT)', 'ยอดรวม(ไม่รวม VAT)'); ?></th>

                                    <!-- <th style="width:60px;"><?= _r('Status', 'สถานะ'); ?></th> -->

                                    <?php if (has_permission('electric_management', 'view') || has_permission('electric_management', 'delete')) : ?>
                                    <th style="width:80px;"><?= _r('Action', 'ดำเนินการ'); ?></th>
                                    <?php endif; ?>

                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="r in electric_record">
                                    <td class="text-center">{{ r.run_id }}
                                        <!-- <img :src="r.image" style="width:100%;"> -->
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

                                    <?php if (has_permission('electric_management', 'view') || has_permission('electric_management', 'delete')) : ?>
                                    <td class="text-center">
                                        <?php if (has_permission('electric_management', 'view')) : ?>
                                        <button class="btn btn-sm btn-warning" @click="loadEditDiscount(r.id)">
                                            <i class="fa fa-pencil" style="color:black !important;"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="editElectricModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="height:90vh; overflow-y:auto;">
            <div class="modal-content" style="height:100%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ edit_electric.id == 0 ? '<?= _r('Add', 'เพิ่ม'); ?>' : '<?= _r('Update Record Eletric', 'แก้ไขรายละเอียดการใช้ไฟฟ้า'); ?>' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;">

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Record Date', 'วันที่จดบันทึก'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.record_date_f" disabled="true">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Meter ID', 'รหัสมิเตอร์'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.meter_id" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Project', 'โปรเจกต์'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="<?= _r('edit_electric.project_name_en', 'edit_electric.project_name_th'); ?>" disabled="true">
                            </div>
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Room Type', 'ประเภทห้อง'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="<?= _r('edit_electric.room_type_name_en', 'edit_electric.room_type_name_th'); ?>" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Room Number', 'หมายเลขห้อง'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="<?= _r('edit_electric.room_name_th', 'edit_electric.room_name_en'); ?>" disabled="true">
                            </div>
                            
                        </div>
                    </div>

                    <hr>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Current Unit', 'หน่วยปัจจุบัน'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.current_unit" >
                            </div>

                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Previous Unit', 'หน่วยก่อนหน้า'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.previous_unit" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Qty', 'จำนวน'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.qty" disabled="true">
                            </div>
                            
                            <div class="col-md-6">
                                <small><font color="red">*</font><?= _r('Unit Rate', 'อัตราต่อหน่วย'); ?></small>
                                <input type="text" class="form-control" style="margin-top:-3px;" v-model="edit_electric.unit_rate" disabled="true">
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row justify-content-center w-100">
                        <button type="button" class="btn btn-info" style="background-color:#0275d8;" onclick="close_edit()">Close</button>&nbsp;&nbsp;&nbsp;
                        <!-- <button type="submit" class="btn btn-info" style="background-color:#0275d8;" >Save</button> -->
                        <button type="button" class="btn btn-info" style="background-color:#0275d8;" @click="EditElectricInfo()" >Save</button>
                    </div>

                    
                </div>
            </div>        
        </div>
    </div>
        
</div>

<script>
    function close_edit() {
      $('#editElectricModal').modal('hide');
    }
</script>

<script>
$(document).ready(function() {
    app = new Vue({
        el: '#vApp',
        data: {
            menu: "<?= _r('Eletric Using Record Detail', 'บันทึกรายละเอียดการใช้ไฟฟ้า'); ?>",
            electric_record: <?php echo json_encode($electric_record); ?>,
            edit_electric: {}
        },
        mounted() {
            $("#roomTable").DataTable();
            $("#date_from").datepicker({
                dateFormat: "dd-mm-yy",
                onSelect: function(d) {
                    const convertedDate = convertDateDash(d);
                    self.electric_info.record_date = convertedDate;
                    self.lastRecordDateChange(convertedDate);
                }
            });
            $("#date_to").datepicker({
                dateFormat: "dd-mm-yy",
                onSelect: function(d) {
                    const convertedDate = convertDateDash(d);
                    self.electric_info.record_date = convertedDate;
                    self.lastRecordDateChange(convertedDate);
                }
            });
        },
        methods: {
            EditElectricInfo: function() {
                // alert('current_unit:'+this.edit_electric.current_unit);
                if (!this.edit_electric.current_unit) {
                // แสดงข้อความแจ้งเตือน
                    alert('กรุณากรอกข้อมูลทั้งหมด');
                    return; // หยุดการทำงานต่อไปถ้ามีค่าว่าง
                }

                if(this.edit_electric.current_unit <= this.edit_electric.previous_unit){
                    alert('มิเตอร์ปัจจุบันต้องมากกว่ามิเตอร์ก่อนหน้า');
                    return;
                }

                $.post("<?php echo edit_record_electric_id(); ?>", {
                    id: this.edit_electric.id,
                    current_unit: this.edit_electric.current_unit,
                    previous_unit: this.edit_electric.previous_unit,
                    qty: this.edit_electric.qty,
                    unit_rate: this.edit_electric.unit_rate
                }, function(response) {
                    // alert('success');
                    // ตรวจสอบการส่งค่ากลับ
                    if (response.success) {
                        // alert('บันทึกข้อมูลสำเร็จ');
                        alert('บันทึกข้อมูลสำเร็จ');
                        // ทำสิ่งที่ต้องการหลังจากบันทึกข้อมูลสำเร็จ เช่น รีเฟรชหน้าเว็บ
                        location.href = "<?php echo record_electric_management_url(); ?>";
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
                this.electric_record.forEach((v) => {
                    if (v.id == id) {
                        self.edit_electric = JSON.parse(JSON.stringify(v));
                    }
                });
                $('#editElectricModal').modal('show');
            },
            editRoomType: function(id) {
                <?php if (has_permission('electric_management', 'view')) : ?>
                location.href = '<?php echo edit_electric_url(); ?>'+ id;
                <?php endif; ?>
            },
            deleteRoomType: function(id) {
                if (confirm('Delete this Electric ?')) {
                    let param = {'id': id};
                    $.post("<?php echo delete_electric_url(); ?>", param, function(res) {
                        if (res.result == 'false') {
                            alert(res.message);
                        } else {
                            alert('Delete Electric Success');
                            location.reload();
                        }
                    });
                }
            }
        }
    });
});
</script>